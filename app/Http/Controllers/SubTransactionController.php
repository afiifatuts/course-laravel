<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscribeTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
    public function show($subTransaction)
    {
        $subscribeTransaction= SubscribeTransaction::where('id',$subTransaction)->first();
        return view('admin.transactions.show',compact('subscribeTransaction'));
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
    public function update($subscribeId)
    {
        $subscribeTransaction = SubscribeTransaction::where('id',$subscribeId)->first();
        $subscribeTransaction->update([
            'is_paid'=>1,
            'subscription_start_date'=>Carbon::now(),
        ]);
        return redirect()->route('admin.subscription_transaction.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubscribeTransaction $subsribeTransaction)
    {
        //
    }
}
