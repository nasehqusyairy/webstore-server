<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        return response()->json(['addresses' => auth()->user()->addresses]);
    }

    public function show(Address $address)
    {
        return $address;
    }

    public function store(Request $request)
    {
        $address = Address::create($request->all());
        return response()->json(['address' => $address], 201);
    }

    public function update(Request $request, Address $address)
    {
        $address->update($request->all());
        return response()->json(['address' => $address], 200);
    }

    public function destroy(Address $address)
    {
        $address->delete();
        return response()->json(null, 204);
    }
}
