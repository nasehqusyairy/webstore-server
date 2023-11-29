<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    public function index()
    {
        return response()->json(['sponsors' => Sponsor::all()]);
    }

    public function show(Sponsor $sponsor)
    {
        return $sponsor;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $imageName = $request->hasFile('image') ? time() . '.' . $request->image->extension() : null;
        if ($imageName) {
            if ($request->image->getSize() > 2048 * 1024) {
                return response()->json(['message' => 'Image size must not exceed 2MB'], 400);
            }
            $request->image->move(public_path('images'), $imageName);
        }

        $sponsor = new Sponsor($request->all());
        $sponsor->image = url('images/' . $imageName);
        $sponsor->save();

        return response()->json(['sponsor' => $sponsor], 201);
    }

    public function update(Request $request, Sponsor $sponsor)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $imageName = $request->hasFile('image') ? time() . '.' . $request->image->extension() : null;
        if ($imageName) {
            if ($request->image->getSize() > 2048 * 1024) {
                return response()->json(['message' => 'Image size must not exceed 2MB'], 400);
            }
            $request->image->move(public_path('images'), $imageName);
        }

        if ($imageName) {
            // Delete old image
            $oldImage = str_replace(url('/'), public_path(), $sponsor->image);
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }

            $sponsor->image = url('images/' . $imageName);
        }

        $sponsor->name = $request->name;
        $sponsor->save();

        return response()->json(['sponsor' => $sponsor], 200);
    }

    public function destroy(Sponsor $sponsor)
    {
        // Delete image file
        $oldImage = str_replace(url('/'), public_path(), $sponsor->image);
        if (file_exists($oldImage)) {
            unlink($oldImage);
        }

        // Delete sponsor
        $sponsor->delete();

        return response()->json(null, 204);
    }
}
