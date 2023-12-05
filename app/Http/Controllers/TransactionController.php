<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        return Transaction::all();
    }

    public function show(Transaction $transaction)
    {
        return $transaction;
    }

    public function store(Request $request)
    {

        $transaction = Transaction::create($request->all());

        foreach ($request->products as $product) {
            DB::table('transaction_product')->insert([
                'transaction_id' => $transaction->id,
                'product_id' => $product['id'],
                'quantity' => $product['qty'],
            ]);
        }

        return response()->json([
            'message' => 'Transaction created successfully',
            'transaction' => $transaction
        ], 201);
    }

    public function update(Request $request, Transaction $transaction)
    {
        $transaction->update($request->all());
        return response()->json($transaction, 200);
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return response()->json(null, 204);
    }
}
