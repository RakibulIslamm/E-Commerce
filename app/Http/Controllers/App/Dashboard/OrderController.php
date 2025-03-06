<?php

namespace App\Http\Controllers\App\Dashboard;

use App\Models\Order;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with('articoli');

        if ($request->filled('NUOVI')) {
            $query->where('nuovi', false);
        }

        if ($request->filled('IDORDINE')) {
            $order = $query->find($request->IDORDINE);
            if (!$order) {
                return response()->json(['error' => 'Incorrect order ID'], 400);
            }
            return response()->json(['codice' => 'OK', 'n_ordini' => 1, 'ordini' => [$order]]);
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
            return response()->json(['codice' => 'OK', 'n_ordini' => 1, 'ordini' => [$order]]);
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

        return response()->json(['codice' => 'OK', 'n_ordini' => $orders->count(), 'ordini' => $orders]);
    }

    // public function get_orders(Request $request)
    // {
    //     $tenant = tenant();
    //     Log::info("Start get_orders(): ", ['payload' => $request->all(), 'url'=> request()->url()]);
    
    //     $query = Order::with('articoli');

    //     if ($request->filled('NUOVI')) {
    //         $query->where('nuovi', false);
    //     }

    //     if ($request->filled('IDORDINE')) {
    //         $order = $query->find($request->IDORDINE);
    //         if (!$order) {
    //             Log::error("Error -> (Tenant ID: {$tenant->id})", ["errore" => [
    //                 "numero" => 400,
    //                 "msg" => "ID ordine errato",
    //                 "errors" => "",
    //                 "extra_msg" => ''
    //             ]]);
    //             return response()->json([
    //                 "codice" => "OK",
    //                 "errore" => [
    //                     "numero" => 400,
    //                     "msg" => "ID ordine errato",
    //                     "extra_msg" => ""
    //                 ]
    //             ]);
    //         }
    //         return response()->json([
    //             "codice" => "OK",
    //             "n_ordini" => 1,
    //             "array ordini" => [$order]
    //         ]);
    //     }

    //     if ($request->filled('DATAORDINE')) {
    //         $query->whereDate('data_ordine', $request->DATAORDINE);
    //     }

    //     if ($request->filled('DATAORDINEDA')) {
    //         $query->whereDate('data_ordine', '>=', $request->DATAORDINEDA);
    //     }

    //     if ($request->filled('DATAORDINEA')) {
    //         $query->whereDate('data_ordine', '<=', $request->DATAORDINEA);
    //     }

    //     if ($request->filled('N_ORDINE')) {
    //         $order = $query->find($request->N_ORDINE);
    //         if (!$order) {
    //             Log::error("Error -> (Tenant ID: {$tenant->id})", ["errore" => [
    //                 "numero" => 400,
    //                 "msg" => "Numero d'ordine errato",
    //                 "errors" => "",
    //                 "extra_msg" => ''
    //             ]]);
    //             return response()->json([
    //                 "codice" => "OK",
    //                 "errore" => [
    //                     "numero" => 400,
    //                     "msg" => "Numero d'ordine errato",
    //                     "extra_msg" => ""
    //                 ]
    //             ]);
    //         }
    //         return response()->json([
    //             "codice" => "OK",
    //             "n_ordini" => 1,
    //             "array ordini" => [$order]
    //         ]);
    //     }

    //     if ($request->filled('STATO')) {
    //         $query->where('stato', $request->STATO);
    //     }

    //     if ($request->filled('PAGATO')) {
    //         $query->where('pagato', $request->PAGATO);
    //     }

    //     $orders = $query->get();
    //     return response()->json(['codice' => 'OK', 'n_ordini' => $orders->count(), 'ordini' => $orders]);
    // }

    public function get_orders(Request $request)
    {
        $tenant = tenant();
        Log::info("Start get_orders(): ", ['payload' => $request->all(), 'url'=> request()->url()]);
        $query = Order::with('articoli');
    
        if ($request->input('NUOVI')) {
            $query->where('nuovi', false);
        }
    
        if ($request->input('IDORDINE')) {
            $order = $query->find($request->IDORDINE);
            if (!$order) {
                Log::error("Error -> (Tenant ID: {$tenant->id})", ["errore" => [
                    "numero" => 400,
                    "msg" => "ID ordine errato",
                    "errors" => "",
                    "extra_msg" => ''
                ]]);
                return response()->json([
                    "codice" => "OK",
                    "errore" => [
                        "numero" => 400,
                        "msg" => "ID ordine errato",
                        "extra_msg" => ""
                    ]
                ]);
            }
            return response()->json([
                'codice' => 'OK',
                'n_ordini' => 1,
                'ordini' => [$this->formatOrder($order)]
            ]);
        }
    
        if ($request->input('DATAORDINE')) {
            $query->whereDate('data_ordine', $request->DATAORDINE);
        }
    
        if ($request->input('DATAORDINEDA')) {
            $query->whereDate('data_ordine', '>=', $request->DATAORDINEDA);
        }
    
        if ($request->input('DATAORDINEA')) {
            $query->whereDate('data_ordine', '<=', $request->DATAORDINEA);
        }
    
        if ($request->input('N_ORDINE')) {
            $order = $query->find($request->N_ORDINE);
            if (!$order) {
                Log::error("Error -> (Tenant ID: {$tenant->id})", ["errore" => [
                    "numero" => 400,
                    "msg" => "Numero d'ordine errato",
                    "errors" => "",
                    "extra_msg" => ''
                ]]);
                return response()->json([
                    "codice" => "OK",
                    "errore" => [
                        "numero" => 400,
                        "msg" => "Numero d'ordine errato",
                        "extra_msg" => ""
                    ]
                ]);
            }
            return response()->json([
                'codice' => 'OK',
                'n_ordini' => 1,
                'ordini' => [$this->formatOrder($order)]
            ]);
        }
    
        if ($request->input('STATO')) {
            $query->where('stato', $request->STATO);
        }
    
        if ($request->input('PAGATO')) {
            $query->where('pagato', $request->PAGATO);
        }
        $query->orderBy('created_at', 'desc');
        $perPage = $request->get('limit', 100);
        $currentPage = $request->get('page', 1);
        $orders = $query->paginate($perPage, ['*'], 'page', $currentPage);

        $formattedOrders = $orders->items();
        $formattedOrders = collect($formattedOrders)->map(fn($order) => $this->formatOrder($order));
    
        return response()->json([
            'codice' => 'OK',
            'n_ordini' => $formattedOrders->count(),
            'ordini' => $formattedOrders,
            'current_page' => $orders->currentPage(),
            'last_page' => $orders->lastPage(),
            'total' => $orders->total(),
        ]);
    }


    public function place_order(Request $request)
    {

    }

    public function change_order_status(Request $request)
    {
        $tenant = tenant();
        Log::info("Start change_order_status(): ", ['payload' => $request->all(), 'url'=> request()->url()]);

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

        try{
            $order->save();
            // Logic to send confirmation email (omitted for brevity)
            Log::info("Success change_order_status()");
            return response()->json([
                'codice' => 'OK',
                "msg" => "Stato ordine aggiornato correttamente"
            ]);
        }
        catch(\Exception $e){
            Log::error("Error -> (Tenant ID: {$tenant->id})", ["errore" => [
                "numero" => 400,
                "msg" => "Errore durante l'aggiornamento dello stato ordine",
                "errors" => "",
                "extra_msg" => $e->getMessage()
            ]]);
            return response()->json([
                'codice' => 'KO',
                'errore'=>[
                    "numero" => 310,
                    "msg" => "Errore durante l'aggiornamento dello stato ordine",
                    "extra_msg" => $e->getMessage()
                ]
            ]);
        }
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

    private function formatOrder($order)
    {
        return [
            'id' => $order->id,
            'n_ordine' => $order->n_ordine,
            'user_id' => $order->user_id,
            'nominativo' => $order->nominativo,
            'promo' => $order->promo,
            'ragione_sociale' => $order->ragione_sociale,
            'indirizzo' => $order->indirizzo,
            'cap' => $order->cap,
            'citta' => $order->citta,
            'provincia' => $order->provincia,
            'email' => $order->email,
            'telefono' => $order->telefono,
            'stato' => $order->stato,
            'pagato' => $order->pagato,
            'totale_netto' => $order->totale_netto,
            'totale_iva' => $order->totale_iva,
            'promo_netto' => $order->promo_netto,
            'promo_iva' => $order->promo_iva,
            'spese_spedizione' => $order->spese_spedizione,
            'nominativo_spedizione' => $order->nominativo_spedizione,
            'ragione_sociale_spedizione' => $order->ragione_sociale_spedizione,
            'indirizzo_spedizione' => $order->indirizzo_spedizione,
            'cap_spedizione' => $order->cap_spedizione,
            'citta_spedizione' => $order->citta_spedizione,
            'provincia_spedizione' => $order->provincia_spedizione,
            'pec' => $order->pec,
            'sdi' => $order->sdi,
            'note' => $order->note,
            'corriere' => $order->corriere,
            'nuovi' => $order->nuovi,
            'created_at' => $order->created_at,
            'data_ordine' => $order->data_ordine,
            'updated_at' => $order->updated_at,
            'cod_fee' => $order->cod_fee,
            'articoli' => $order->articoli_formatted,
            'piva' => $order->piva,
            'cf' => $order->cf,
        ];
    }
}
