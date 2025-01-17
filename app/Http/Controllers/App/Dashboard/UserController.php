<?php

namespace App\Http\Controllers\App\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;

class UserController
{
    public function index()
    {
        $query = User::query();

        $perPage = request()->input('limit', 50);

        if($perPage > 50){
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
        $validate = $request->validate([
            'active' => 'nullable|boolean',
            'price_list' => 'nullable|integer',
        ]);
        $user->update($validate);
        return redirect()->back()->with('success', "User updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
