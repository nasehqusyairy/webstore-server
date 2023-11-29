<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index()
    {
        $cards = auth()->user()->cards;
        return response()->json(['cards' => $cards]);
    }

    public function show(Card $card)
    {
        return $card;
    }

    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required|unique:cards',
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer'
        ]);

        $card = Card::create($request->all());
        return response()->json(['card' => $card], 201);
    }

    public function update(Request $request, Card $card)
    {
        $request->validate([
            'number' => 'required|unique:cards,number,' . $card->id,
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer'
        ]);

        $card->update($request->all());
        return response()->json(['card' => $card], 200);
    }

    public function destroy(Card $card)
    {
        $card->delete();
        return response()->json(null, 204);
    }
}
