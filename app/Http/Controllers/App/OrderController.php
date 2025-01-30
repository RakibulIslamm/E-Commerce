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
        // dd(request()->all('citta_spedizione'));

        $cart = session()->get('cart', []);

        if (count($cart) < 1) {
            return redirect()->route('app.cart');
        }

        $validate = $request->validate([
            'nominativo' => 'required|string', // name
            'ragione_sociale' => 'nullable|string', // business name
            'indirizzo' => 'required|string', // address
            'cap' => 'required|string', // Postal code
            'citta' => 'required|string', // city
            'provincia' => 'required|string', // province
            'email' => 'required|email',
            'telefono' => 'required|string', // telephone
            'stato' => 'nullable|integer', // state code
            'pagamento' => 'nullable|boolean', // payment
            'totale_netto' => 'nullable|numeric', // total
            'totale_iva' => 'nullable|numeric', // total vat
            'spese_spedizione' => 'nullable|numeric', // Shipping costs
            'cod_fee' => 'nullable|numeric', // Cash on delivery fee
            'promotion_id' => 'nullable|numeric',
            'nominativo_spedizione' => 'nullable|string', // shipping name
            'telefono_spedizione' => 'nullable|string', // telephone
            'ragione_sociale_spedizione' => 'nullable|string', // shipping company name
            'indirizzo_spedizione' => 'nullable|string', // Shipping address
            'cap_spedizione' => 'nullable|string', // shipping postal code
            'citta_spedizione' => 'nullable|string', // shipping city
            'provincia_spedizione' => 'nullable|string', // shipping province
            'spedizione' => 'nullable|string', // shipping
            'corriere' => 'nullable|string', // courier
            'note' => 'nullable|string',
        ]);


        $total = 0;
        $vat = 0 ;
        foreach ($cart as $item) {
            $item_total = $item['price'] * $item['quantity'];
            $item_vat = ($item['price'] * $item['vat'] / 100) * $item['quantity'];
            
            $total += $item_total;
            $vat += $item_vat;
        }
        $validate['totale_netto'] = $total;
        $validate['totale_iva'] = $vat;

        $postal = $validate['cap'];
        $city = $validate['citta'];
        $province = $validate['provincia'];

        $allLocations = AvailableLocation::all();

        $availableLocations = AvailableLocation::where('postal_code', $postal)->with('location')->get();

        // Check if any location matches the provided city and province
        $locationMatch = $availableLocations->first(function ($location) use ($city, $province) {
            return $location->location->place === $city && $location->location->province === $province;
        });

        if (!$locationMatch && (count($allLocations) > 0)) {
            return redirect()->back()
                ->withErrors(['cap_not_available' => 'Al momento non siamo disponibili nella tua zona'])
                ->withInput();
        }

        $validate['nominativo_spedizione'] = $validate['nominativo_spedizione'] ? $validate['nominativo_spedizione'] : $validate['nominativo'];
        $validate['telefono_spedizione'] = $validate['telefono_spedizione'] ? $validate['telefono_spedizione'] : $validate['telefono'];
        // $validate['ragione_sociale_spedizione'] = $validate['ragione_sociale_spedizione'] ? $validate['ragione_sociale_spedizione'] : $validate['ragione_sociale'];
        $validate['indirizzo_spedizione'] = $validate['indirizzo_spedizione'] ? $validate['indirizzo_spedizione'] : $validate['indirizzo'];
        $validate['cap_spedizione'] = $validate['cap_spedizione'] ? $validate['cap_spedizione'] : $validate['cap'];
        $validate['citta_spedizione'] = $validate['citta_spedizione'] ? $validate['citta_spedizione'] : $validate['citta'];
        $validate['provincia_spedizione'] = $validate['provincia_spedizione'] ? $validate['provincia_spedizione'] : $validate['provincia'];
        $validate['promotion_id'] = $validate['promotion_id'] ?? '';

        $validate['promotion_id'] = $validate['promotion_id'] ? $validate['promotion_id'] : 0;


        try {
            if (Auth::check()) {
                $validate['user_id'] = auth()->user()->id;
            }
        
            $filledValues = array_filter($validate, function ($value) {
                return !is_null($value) && $value !== '';
            });
        
            $order = Order::create($filledValues);
            foreach ($cart as $item) {
                $order->order_items()->create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'vat' => $item['vat'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity']
                ]);
                $product = Product::find($item['product_id']);
                $product->update([
                    "GIACENZA" => $product->GIACENZA - $item['quantity']
                ]);
            }
            $order->load('order_items.product');
            $this->sendOrderConfirmationEmail($order);
            session()->forget('cart');
            return redirect()->route('app.confirm-order')->with(['order' => $order, 'success' => true]);
        } catch (\Exception $e) {
            return redirect()->route('app.confirm-order')->with('message', "Internal Server Error")->with('success', false);
        }
    }

    public function confirm_order()
    {
        $order = session('order');
        $success = session('success');

        if (!$order) {
            return redirect()->route('app.cart');
        }

        return view('app.pages.checkout.confirmation', ['success' => $success, 'order' => $order]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        try {
            // Correct eager loading when retrieving the order from the database
            $order = Order::with('order_items.product')->findOrFail($order->id);
            
            return view("app.pages.my-account.show-order", ["order" => $order]);
        } catch (\Exception $e) {
            // Handle the exception (optional: log the error, return a meaningful response, etc.)
            // Example: return redirect()->route('app.confirm-order')->with('message', "Internal Server Error")->with('success', false);
        }
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
            'id'=> $order->id,
            'created_at'=> $order->created_at,
            'totale_netto'=> $order->totale_netto,
            'spese_spedizione'=> $order->spese_spedizione,
            'totale_iva'=> $order->totale_iva,
            'cod_fee'=> $order->cod_fee,
            'order_items'=> $order->order_items,
            'nominativo_spedizione'=> $order->nominativo_spedizione,
            'indirizzo_spedizione'=> $order->indirizzo_spedizione,
            'citta_spedizione'=> $order->citta_spedizione,
            'shipping_state'=> $order->shipping_state,
            'cap_spedizione'=> $order->cap_spedizione,
            'provincia_spedizione'=> $order->provincia_spedizione,
            'telefono'=> $order->telefono,
            'email'=> $order->email,
        ];
        
        if (isset($smtp) && $smtp['mail_host'] && $smtp['mail_port'] && $smtp['mail_username'] && $smtp['mail_password'] && $smtp['mail_from_address']) {
            Config::set('mail.mailers.smtp.host', $smtp['mail_host']);
            Config::set('mail.mailers.smtp.port', $smtp['mail_port']);
            Config::set('mail.mailers.smtp.username', $smtp['mail_username']);
            Config::set('mail.mailers.smtp.password', $smtp['mail_password']);
            Config::set('mail.from.address', $smtp['mail_from_address']);
            Config::set('mail.from.name', tenant()->business_name ?? "Ecommerce");

            Mail::send('app.emails.order-confirmation', $data, function ($message) use ($smtp, $data) {
                $message->from($smtp['mail_from_address'], tenant()->business_name);
                $message->to($data['email']);
                $message->subject('Order Confirmation');
            });
        } else {
            Log::error("Error: SMTP not set up for order confirmation email", ['order_id' => $order->id]);
        }
    }
}
