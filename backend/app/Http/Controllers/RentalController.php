<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with(['user', 'equipment'])->latest()->paginate(10);
        return view('admin.rental.index', compact('rentals'));
    }

    public function indexUser(Request $request)
    {
        $type = $request->query('type');
        $query = Equipment::query();

        if ($type) {
            $query->where('type', $type);
        }

        $equipments = $query->latest()->get();
        return view('dashboard', compact('equipments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'rent_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after_or_equal:rent_date',
        ]);

        return DB::transaction(function () use ($request) {
            $equipment = Equipment::lockForUpdate()->findOrFail($request->equipment_id);

            if ($equipment->stock <= 0) {
                return back()->with('error', 'Stok baru saja habis!');
            }

            $start = Carbon::parse($request->rent_date);
            $end = Carbon::parse($request->return_date);
            $days = $start->diffInDays($end);
            $days = $days < 1 ? 1 : $days;

            $totalPrice = $days * $equipment->price_per_day;

            Rental::create([
                'user_id' => Auth::id(),
                'equipment_id' => $equipment->id,
                'rent_date' => $request->rent_date,
                'return_date' => $request->return_date,
                'total_price' => $totalPrice,
                'status' => 'rented',
            ]);

            $equipment->decrement('stock');

            return redirect()->route('dashboard')->with('success', 'Berhasil menyewa alat!');
        });
    }

    public function returnRental($id)
    {
        $rental = Rental::findOrFail($id);

        if ($rental->status === 'returned') {
            return back()->with('error', 'Barang sudah dikembalikan');
        }

        $rental->update([
            'status' => 'returned',
            'actual_return_date' => now(),
        ]);

        $rental->equipment->increment('stock');

        return back()->with('success', 'Barang berhasil dikembalikan');
    }
}
