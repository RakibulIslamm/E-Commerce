<?php

namespace App\Http\Controllers\App\Dashboard;

use App\Models\Order;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with('order_items');

        if ($request->filled('NUOVI')) {
            $query->where('nuovi', false);
        }

        if ($request->filled('IDORDINE')) {
            $order = $query->find($request->IDORDINE);
            if (!$order) {
                return response()->json(['error' => 'Incorrect order ID'], 400);
            }
            return response()->json(['Codice' => 'OK', 'n_ordini' => 1, 'ordini' => [$order]]);
        }

        if ($request->filled('DATAORDINE')) {
            $query->whereDate('data_ordine', $request->DATAORDINE);
        }

        if ($request->filled('DATAORDINEDA')) {
            $query->whereDate('data_ordine', '>=', $request->DATAORDINEDA);
        }

        if ($request->filled('DATAORDINEA')) {
            $query->whereDate('data_ordine', '<=', $request->DATAORDINEA);
        }

        if ($request->filled('N_ORDINE')) {
            $order = $query->find($request->N_ORDINE);
            if (!$order) {
                return response()->json(['error' => 'Incorrect order number'], 420);
            }
            return response()->json(['Codice' => 'OK', 'n_ordini' => 1, 'ordini' => [$order]]);
        }

        if ($request->filled('STATO')) {
            $query->where('stato', $request->STATO);
        }

        if ($request->filled('PAGATO')) {
            $query->where('pagato', $request->PAGATO);
        }

        $orders = $query->get();

        foreach ($orders as $order) {
            $user = User::find($order->user_id);
            $promotion = Promotion::find($order->promotion_id);
            $order['user'] = $user ? $user : null;
            $order['promotion'] = $promotion ? $promotion : null;
        }

        dd($orders);

        return response()->json(['Codice' => 'OK', 'n_ordini' => $orders->count(), 'ordini' => $orders]);
    }

    public function get_orders(Request $request)
    {
        $query = Order::with('order_items');

        // dd($request->NUOVI);

        if ($request->filled('NUOVI')) {
            $query->where('nuovi', false);
        }

        if ($request->filled('IDORDINE')) {
            $order = $query->find($request->IDORDINE);
            if (!$order) {
                return response()->json(['error' => 'Incorrect order ID'], 400);
            }
            return response()->json(['Codice' => 'OK', 'n_ordini' => 1, 'ordini' => [$order]]);
        }

        if ($request->filled('DATAORDINE')) {
            $query->whereDate('data_ordine', $request->DATAORDINE);
        }

        if ($request->filled('DATAORDINEDA')) {
            $query->whereDate('data_ordine', '>=', $request->DATAORDINEDA);
        }

        if ($request->filled('DATAORDINEA')) {
            $query->whereDate('data_ordine', '<=', $request->DATAORDINEA);
        }

        if ($request->filled('N_ORDINE')) {
            $order = $query->find($request->N_ORDINE);
            if (!$order) {
                return response()->json(['error' => 'Incorrect order number'], 420);
            }
            return response()->json(['Codice' => 'OK', 'n_ordini' => 1, 'ordini' => [$order]]);
        }

        if ($request->filled('STATO')) {
            $query->where('stato', $request->STATO);
        }

        if ($request->filled('PAGATO')) {
            $query->where('pagato', $request->PAGATO);
        }

        $orders = $query->get();
        return response()->json(['Codice' => 'OK', 'n_ordini' => $orders->count(), 'ordini' => $orders]);
    }


    public function place_order(Request $request)
    {

    }

    public function change_order_status(Request $request)
    {
        $order = Order::find($request->IDORDINE);
        if (!$order) {
            return response()->json(['error' => 'Incorrect order ID'], 400);
        }

        if ($request->filled('STATO')) {
            if ($request->STATO < $order->stato) {
                return response()->json(['error' => 'Status can only increase'], 400);
            }
            $order->stato = $request->STATO;
        }

        if ($request->filled('CORRIERE')) {
            $order->corriere = $request->CORRIERE;
        }

        if ($request->filled('PAGATO')) {
            $order->pagato = $request->PAGATO;
        }

        $order->save();

        // Logic to send confirmation email (omitted for brevity)

        return response()->json(['Codice' => 'OK']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
