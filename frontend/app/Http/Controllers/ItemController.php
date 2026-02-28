<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        return response()->json(Item::latest()->get());
    }

    public function show(Item $item)
    {
        return response()->json($item);
    }

    public function store(Request $request)
    {
        $item = Item::create($request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'stock' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
        ]));

        return response()->json([
            'status' => 'true',
            'message' => 'Data Berhasil Ditambahkan',
            'data' => $item,
        ]);
    }

    public function update(Request $request, Item $item)
    {
        $item->update($request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'stock' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
        ]));

        return response()->json([
            'status' => 'true',
            'message' => 'Data Berhasil Diupdate',
            'data' => $item,
        ]);
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return response()->json([
            'status' => 'true',
            'message' => 'Data Berhasil Dihapus',
        ]);
    }
}
