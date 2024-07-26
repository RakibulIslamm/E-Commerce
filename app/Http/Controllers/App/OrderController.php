<?php

namespace App\Http\Controllers\App;

use App\Models\Location;
use App\Models\Order;
use App\Models\Product;
use Auth;
use Illuminate\Http\Request;

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
    public function create()
    {

        // if (session('cart', [])->isEmpty()) {
        //     return redirect()->route('app.cart');
        // }
        $cart = session()->get('cart', []);

        if (count($cart) < 1) {
            return redirect('/cart');
        }

        return view("app.pages.checkout.index");
        // return view("app.pages.checkout.confirmation");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd(request()->all());

        $cart = session()->get('cart', []);

        $validate = $request->validate([
            'nominativo' => 'required|string', // name
            'ragione_sociale' => 'nullable|string', // business name
            'indirizzo' => 'required|string', // address
            'cap' => 'required|string', // Postal code
            'citta' => 'nullable|string', // city
            'provincia' => 'required|string', // province
            'email' => 'required|email',
            'telefono' => 'required|string', // telephone
            'stato' => 'nullable|integer', // state code
            'pagamento' => 'nullable|boolean', // payment
            'totale_netto' => 'nullable|numeric', // total
            'totale_iva' => 'nullable|numeric', // total vat
            'promotion_id' => 'nullable|numeric',
            'spese_spedizione' => 'nullable|numeric', // Shipping costs
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


        $validate['nominativo_spedizione'] = $validate['nominativo_spedizione'] ? $validate['nominativo_spedizione'] : $validate['nominativo'];
        $validate['telefono_spedizione'] = $validate['telefono_spedizione'] ? $validate['telefono_spedizione'] : $validate['telefono'];
        // $validate['ragione_sociale_spedizione'] = $validate['ragione_sociale_spedizione'] ? $validate['ragione_sociale_spedizione'] : $validate['ragione_sociale'];
        $validate['indirizzo_spedizione'] = $validate['indirizzo_spedizione'] ? $validate['indirizzo_spedizione'] : $validate['indirizzo'];
        $validate['cap_spedizione'] = $validate['cap_spedizione'] ? $validate['cap_spedizione'] : $validate['cap'];
        $validate['citta_spedizione'] = $validate['citta_spedizione'] ? $validate['citta_spedizione'] : $validate['citta'];
        $validate['provincia_spedizione'] = $validate['provincia_spedizione'] ? $validate['provincia_spedizione'] : $validate['provincia'];
        $validate['promotion_id'] = $validate['promotion_id'] ?? '';

        $validate['promotion_id'] = $validate['promotion_id'] ? $validate['promotion_id'] : 0;


        if (Auth::check()) {
            $validate['user_id'] = auth()->user()->id;
        }

        $filledValues = array_filter($validate, function ($value) {
            return !is_null($value) && $value !== '';
        });
        // dd($validate);
        $order = Order::create($filledValues);

        // dd($order);

        foreach ($cart as $item) {
            // dd($item['product_id']);
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
        $order->load('order_items');
        session()->forget('cart');
        return view('app.pages.checkout.confirmation', ['success' => true, 'order' => $order]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
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
}
