<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\Sponsor;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(User $user)
    {
        $request = request();
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'sometimes',
            'img' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = $request->hasFile('img') ? time() . '.' . $request->img->extension() : null;
        if ($imageName) {
            // Delete old image
            $oldImage = str_replace(url('/'), public_path(), $user->img);
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }

            // Move new image
            $request->img->move(public_path('images'), $imageName);

            // Update image URL
            $user->img = url('images/' . $imageName);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return response()->json(['user' => $user], 200);
    }

    public function orders()
    {
        return response()->json(['orders' => User::find(auth()->user()->id)->orders], 200);
    }
    public function cards()
    {
        return response()->json(['cards' => User::find(auth()->user()->id)->cards], 200);
    }
    public function addresses()
    {
        return response()->json(['addresses' => User::find(auth()->user()->id)->addresses], 200);
    }

    public function attributes()
    {
        return response()->json([
            'categories' => Category::all(),
            'products' => Product::with('category')->get(),
            'sponsors' => Sponsor::all(),
            'shippings' => Shipping::all(),
            'user' => User::find(auth()->user()->id)->load('addresses', 'cards', 'orders')
        ], 200);
    }
}
