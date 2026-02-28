<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $perPage = $request->per_page ?? 10;
        $sort = $request->sort ?? 'created_at';
        $direction = $request->direction ?? 'desc';

        $equipments = Equipment::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('type', 'like', "%$search%");
        })
            ->orderBy($sort, $direction)
            ->paginate($perPage)
            ->appends($request->query());

        return view('equipment.index', compact(
            'equipments',
            'search',
            'perPage',
            'sort',
            'direction'
        ));
    }

    public function show($id)
    {
        $equipment = Equipment::findOrFail($id);
        return view('equipment.show', compact('equipment'));
    }

    public function create()
    {
        return view('equipment.create');
    }

    public function edit($id)
    {
        $equipment = Equipment::findOrFail($id);
        return view('equipment.update', compact('equipment'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'description' => 'required|string',
            'price_per_day' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('equipment_images', 'public');
        }

        Equipment::create($validated);

        return redirect()->route('equipment.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $equipment = Equipment::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'description' => 'required|string',
            'price_per_day' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($equipment->image) {
                Storage::disk('public')->delete($equipment->image);
            }
            $validated['image'] = $request->file('image')->store('equipment_images', 'public');
        }

        $equipment->update($validated);

        return redirect()->route('equipment.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $equipment = Equipment::findOrFail($id);

        if ($equipment->image) {
            Storage::disk('public')->delete($equipment->image);
        }

        $equipment->delete();

        return redirect()->route('equipment.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
