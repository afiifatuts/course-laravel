<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscribeTransaction;

class SubTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = SubscribeTransaction::with(['user'])->orderByDesc('id')->get();
        return view('admin.transactions.index',compact('transactions'));
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
    public function show(SubscribeTransaction $subsribeTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubscribeTransaction $subsribeTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubscribeTransaction $subsribeTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubscribeTransaction $subsribeTransaction)
    {
        //
    }
}
