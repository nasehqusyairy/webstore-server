<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        return response()->json(['orders' => Transaction::with(['user', 'address', 'card', 'shipping'])->get()], 200);
    }

    public function show(Transaction $order)
    {
        return response()->json(['order' => $order->load('user', 'address', 'card', 'shipping', 'products.category')], 200);
    }

    public function store(Request $request)
    {

        $order = Transaction::create($request->all());

        foreach ($request->products as $product) {
            DB::table('product_transaction')->insert([
                'transaction_id' => $order->id,
                'product_id' => $product['id'],
                'quantity' => $product['qty'],
            ]);

            // Decrease product quantity
            $productModel = Product::find($product['id']);
            $productModel->stock -= $product['qty'];
            $productModel->save();
        }

        return response()->json([
            'message' => 'Transaction created successfully',
            'order' => $order->load('user', 'address', 'card', 'shipping')
        ], 201);
    }

    public function update(Request $request, Transaction $order)
    {
        $order->update($request->all());
        return response()->json(['order' => $order->load('user', 'address', 'card', 'shipping')], 200);
    }

    public function destroy(Transaction $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }
}
