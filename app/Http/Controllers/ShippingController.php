<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index()
    {
        return Shipping::all();
    }

    public function show(Shipping $shipping)
    {
        return $shipping;
    }

    public function store(Request $request)
    {
        $shipping = Shipping::create($request->all());
        return response()->json($shipping, 201);
    }

    public function update(Request $request, Shipping $shipping)
    {
        $shipping->update($request->all());
        return response()->json($shipping, 200);
    }

    public function destroy(Shipping $shipping)
    {
        $shipping->delete();
        return response()->json(null, 204);
    }
}
