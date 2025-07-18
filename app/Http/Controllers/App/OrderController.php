<?php

namespace App\Http\Controllers\App;

use App\Models\AvailableLocation;
use App\Models\Location;
use App\Models\Order;
use App\Models\Product;
use App\Models\ShippingSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (count($cart) < 1) {
            return redirect('/cart');
        }
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        // Get the shipping settings along with the rules
        $shippingSettings = ShippingSetting::with('rules')
            ->orderBy('minimum_order', 'asc')
            ->get();

        if ($shippingSettings->isEmpty()) {
            return back()->with('error', 'Qualcosa è andato storto. Nessun metodo di spedizione trovato. Riprova più tardi');
        }

        $minOrder = $shippingSettings->first()->minimum_order;

        // Check if the total price meets the minimum order requirement
        if ($minOrder > $totalPrice) {
            return back()->with('error', "Il totale del tuo carrello non soddisfa il requisito minimo dell'ordine di €" . number_format($minOrder, 2) . " per nessun metodo di spedizione.");
        }

        $validShippingSettings = $shippingSettings->filter(function ($setting) use ($totalPrice) {
            return $setting->minimum_order <= $totalPrice;
        });

        $proceed = $request->input('proceed') ?? null;
        if (!Auth::check()) {
            if ($proceed == 'proceed-checkout') {
                return view("app.pages.checkout.index", ["shipping_settings"=>$validShippingSettings]);
            }
            return view("app.pages.checkout.login-or-register");
        }
        return view("app.pages.checkout.index", ["shipping_settings"=>$validShippingSettings]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (count($cart) < 1) {
            return redirect()->route('app.cart');
        }

        $validate = $request->validate([
            'nominativo' => 'required|string',
            'ragione_sociale' => 'nullable|string',
            'indirizzo' => 'required|string',
            'cap' => 'required|string',
            'citta' => 'required|string',
            'provincia' => 'required|string',
            'email' => 'required|email',
            'telefono' => 'required|string',
            'stato' => 'nullable|integer',
            'pagamento' => 'nullable|boolean',
            'totale_netto' => 'nullable|numeric',
            'totale_iva' => 'nullable|numeric',
            'spese_spedizione' => 'nullable|numeric',
            'cod_fee' => 'nullable|numeric',
            'promotion_id' => 'nullable|numeric',
            'nominativo_spedizione' => 'nullable|string',
            'telefono_spedizione' => 'nullable|string',
            'ragione_sociale_spedizione' => 'nullable|string',
            'indirizzo_spedizione' => 'nullable|string',
            'cap_spedizione' => 'nullable|string',
            'citta_spedizione' => 'nullable|string',
            'provincia_spedizione' => 'nullable|string',
            'corriere' => 'nullable|string',
            'note' => 'nullable|string',
        ]);

        $user = auth()?->user();
        $discount = $user?->discount ?? 0;

        $total = 0;
        $vat = 0;

        foreach ($cart as $item) {
            $price = $item['price'];
            $quantity = $item['quantity'];
            $vatPercent = $item['vat'];

            $itemTotal = $price * $quantity;
            $itemTotalAfterDiscount = $itemTotal - ($itemTotal * $discount / 100);
            $itemVat = ($itemTotalAfterDiscount * $vatPercent) / 100;

            $total += $itemTotalAfterDiscount;
            $vat += $itemVat;
        }

        $validate['totale_netto'] = $total;
        $validate['totale_iva'] = $vat;

        $postal = $validate['cap'];
        $city = $validate['citta'];
        $province = $validate['provincia'];

        $allLocations = AvailableLocation::all();
        $availableLocations = AvailableLocation::where('postal_code', $postal)->with('location')->get();

        $locationMatch = $availableLocations->first(function ($location) use ($city, $province) {
            return $location->location->place === $city && $location->location->province === $province;
        });

        if (!$locationMatch && (count($allLocations) > 0)) {
            return redirect()->back()
                ->withErrors(['cap_not_available' => 'Al momento non siamo disponibili nella tua zona'])
                ->withInput();
        }

        $validate['nominativo_spedizione'] = $validate['nominativo_spedizione'] ?: $validate['nominativo'];
        $validate['telefono_spedizione'] = $validate['telefono_spedizione'] ?: $validate['telefono'];
        $validate['indirizzo_spedizione'] = $validate['indirizzo_spedizione'] ?: $validate['indirizzo'];
        $validate['cap_spedizione'] = $validate['cap_spedizione'] ?: $validate['cap'];
        $validate['citta_spedizione'] = $validate['citta_spedizione'] ?: $validate['citta'];
        $validate['provincia_spedizione'] = $validate['provincia_spedizione'] ?: $validate['provincia'];
        $validate['promo'] = $validate['promo'] ?? '';

        try {
            DB::beginTransaction();

            if (Auth::check()) {
                $validate['user_id'] = $user->id;
                $validate['piva'] = $user->vat_number;
                $validate['cf'] = $user->tax_id;
                $validate['pec'] = $user->pec_address;
                $validate['sdi'] = $user->pec_address;
            }

            $filledValues = array_filter($validate, fn ($value) => !is_null($value) && $value !== '');
            $filledValues['note'] = $validate['note'] ?? " ";

            $order = Order::create($filledValues);

            $order->n_ordine = $order->id;
            $order->data_ordine = $order->created_at;
            $order->save();

            foreach ($cart as $item) {
                $order->articoli()->create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'ivato' => $item['vat'],
                    'imponibile' => $item['price'],
                    'qta' => $item['quantity'],
                    'IDARTICOLO' => $item['id_articolo']
                ]);

                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->update([
                        'GIACENZA' => $product->GIACENZA - $item['quantity']
                    ]);
                }
            }

            $order->load('articoli.product');

            
            $this->sendOrderConfirmationEmail($order);

            DB::commit();

            return redirect()->route('app.confirm-order')->with(['order' => $order, 'success' => true]);

        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return redirect()->route('app.confirm-order')->with('message', "Internal Server Error")->with('success', false)->with('error', true);
        }
    }

    public function confirm_order()
    {
        session()->forget('cart');
        $order = session('order');
        $success = session('success');
        $error = session('error');

        if (!$order && !$error && !$success) {
            return redirect()->route('app.cart');
        }

        return view('app.pages.checkout.confirmation', ['success' => $success, 'order' => $order]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        if(!Auth::check()){
            return redirect()->back();
        }
        $order = Order::with('articoli.product')->findOrFail($order->id);
        abort_if($order->user_id !== auth()->user()->id, 404);
        
        return view("app.pages.my-account.show-order", ["order" => $order]);
        
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    private function sendOrderConfirmationEmail($order)
    {
        $smtp = tenant()->smtp;

        $data = [
            'id' => $order->id,
            'created_at' => $order->created_at,
            'totale_netto' => $order->totale_netto,
            'spese_spedizione' => $order->spese_spedizione,
            'totale_iva' => $order->totale_iva,
            'cod_fee' => $order->cod_fee,
            'articoli' => $order->articoli,
            'nominativo_spedizione' => $order->nominativo_spedizione,
            'indirizzo_spedizione' => $order->indirizzo_spedizione,
            'citta_spedizione' => $order->citta_spedizione,
            'shipping_state' => $order->shipping_state,
            'cap_spedizione' => $order->cap_spedizione,
            'provincia_spedizione' => $order->provincia_spedizione,
            'telefono' => $order->telefono,
            'email' => $order->email,
        ];

        if (
            isset($smtp) && $smtp['mail_host'] && $smtp['mail_port'] &&
            $smtp['mail_username'] && $smtp['mail_password'] && $smtp['mail_from_address']
        ) {
            try {
                // Configure SMTP
                Config::set('mail.mailers.smtp.host', $smtp['mail_host']);
                Config::set('mail.mailers.smtp.port', $smtp['mail_port']);
                Config::set('mail.mailers.smtp.username', $smtp['mail_username']);
                Config::set('mail.mailers.smtp.password', $smtp['mail_password']);
                Config::set('mail.from.address', $smtp['mail_from_address']);
                Config::set('mail.from.name', tenant()->business_name ?? "Ecommerce");

                Log::info("Start sending order confirmation email");
                Mail::send('app.emails.order-confirmation', $data, function ($message) use ($smtp, $data) {
                    $message->from($smtp['mail_from_address'], tenant()->business_name);
                    $message->to($data['email']);
                    $message->subject('Conferma Ordine');
                });

                $adminEmail = tenant()?->smtp['secretary_email'];
                Mail::send('app.emails.order-admin', $data, function ($message) use ($smtp, $adminEmail) {
                    $message->from($smtp['mail_from_address'], tenant()->business_name);
                    $message->to($adminEmail);
                    $message->subject('Nuovo Ordine Ricevuto');
                });
                Log::info("End sending order confirmation email");
            } catch (\Exception $e) {
                Log::error("Errore durante l'invio delle email per la conferma ordine", [
                    'order_id' => $order->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        } else {
            Log::error("Errore: SMTP non configurato per invio email conferma ordine", ['order_id' => $order->id]);
        }
    }

}
