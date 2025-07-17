<?php

namespace App\Http\Controllers\App\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class UserController
{
    public function index()
    {
        $query = User::query();

        // Exclude the currently authenticated user
        $query->where('id', '!=', auth()->id());

        $perPage = request()->input('limit', 50);

        if ($perPage > 50) {
            $perPage = 50;
            request()->merge(['limit' => 50]);
        }

        $customers = $query->paginate($perPage);
        $customers->appends(request()->all());

        return view('app.pages.dashboard.users.index', ['customers' => $customers]);
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
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // If the request is to verify the email, manually set email_verified_at
        if ($request->has('verify_email')) {
            $user->email_verified_at = Carbon::now();
        }

        // Validate other fields
        $validator = Validator::make($request->all(), [
            'active' => 'nullable|boolean',
            'price_list' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
        ]);

        $validate = $validator->validated();

        // Update validated fields
        $user->fill($validate);

        // Save all changes
        $user->save();

        return redirect()->back()->with('success', "Utente aggiornato con successo");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    /**
     * Abilita accesso mobile per un utente (genera PIN se non esiste)
     */
    public function enableMobileAccess(Request $request, User $user)
    {
        try {
            $user->enableMobileAccess();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Accesso mobile abilitato con successo',
                    'data' => [
                        'mobile_pin' => $user->mobile_pin,
                        'mobile_access_enabled' => $user->mobile_access_enabled,
                    ]
                ]);
            }
            
            return redirect()->back()->with('success', "Accesso mobile abilitato. PIN: {$user->mobile_pin}");
            
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Errore durante l\'abilitazione accesso mobile'
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Errore durante l\'abilitazione accesso mobile');
        }
    }

    public function regenerateMobilePin(Request $request, User $user)
    {
        try {
            $user->regenerateMobilePin();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'PIN rigenerato con successo',
                    'data' => [
                        'mobile_pin' => $user->mobile_pin
                    ]
                ]);
            }
            
            return redirect()->back()->with('success', "PIN rigenerato con successo. Nuovo PIN: {$user->mobile_pin}");
            
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Errore durante la rigenerazione del PIN'
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Errore durante la rigenerazione del PIN');
        }
    }

    /**
     * Ottieni info mobile per un utente specifico
     */
    public function getMobileInfo(Request $request, User $user)
    {
        try {
            $mobileData = $user->getMobileApiData();
            
            // Aggiungi info tenant se necessario
            $tenantInfo = [
                'tenant_id' => tenant('id'),
                'tenant_domain' => tenant('domain'),
            ];
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => array_merge($mobileData, [
                        'tenant' => $tenantInfo
                    ])
                ]);
            }
            
            return view('app.pages.dashboard.users.mobile-info', [
                'user' => $user,
                'mobileData' => $mobileData,
                'tenantInfo' => $tenantInfo
            ]);
            
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Errore durante il recupero delle informazioni mobile'
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Errore durante il recupero delle informazioni mobile');
        }
    }
}