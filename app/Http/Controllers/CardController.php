<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index()
    {
        return Card::all();
    }

    public function show(Card $card)
    {
        return $card;
    }

    public function store(Request $request)
    {
        $card = Card::create($request->all());
        return response()->json($card, 201);
    }

    public function update(Request $request, Card $card)
    {
        $card->update($request->all());
        return response()->json($card, 200);
    }

    public function destroy(Card $card)
    {
        $card->delete();
        return response()->json(null, 204);
    }
}
