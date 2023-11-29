<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sponsor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function all()
    {
        return response()->json([
            'categories' => Category::all(),
            'products' => Product::with('category')->get(),
            'sponsors' => Sponsor::all(),
            'cards' => auth()->user()->cards,
        ]);
    }
}
