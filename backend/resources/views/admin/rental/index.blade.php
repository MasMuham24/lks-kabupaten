@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body">
                    <h6>Total Transaksi</h6>
                    <h2 class="fw-bold">{{ $rentals->total() }}</h2>
                    <i class="bi bi-cart-check position-absolute end-0 bottom-0 m-3 opacity-25" style="font-size: 3rem;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-warning text-dark">
                <div class="card-body">
                    <h6>Sedang Disewa</h6>
                    <h2 class="fw-bold">{{ $rentals->where('status', 'rented')->count() }}</h2>
                    <i class="bi bi-clock-history position-absolute end-0 bottom-0 m-3 opacity-25" style="font-size: 3rem;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body">
                    <h6>Pendapatan Estimasi</h6>
                    <h2 class="fw-bold">Rp {{ number_format($rentals->sum('total_price'), 0, ',', '.') }}</h2>
                    <i class="bi bi-wallet2 position-absolute end-0 bottom-0 m-3 opacity-25" style="font-size: 3rem;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-primary fw-bold">
                <i class="bi bi-receipt me-2"></i> Riwayat Transaksi Rental
            </h5>
            <button class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                <i class="bi bi-printer"></i> Cetak Laporan
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Pelanggan</th>
                            <th>Info Alat</th>
                            <th>Durasi Sewa</th>
                            <th>Total Biaya</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rentals as $rental)
                            <tr>
                                <td class="ps-3">
                                    <div class="fw-bold">{{ $rental->user->name }}</div>
                                    <small class="text-muted">{{ $rental->user->email }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $rental->equipment->type }}</span>
                                    <div class="small fw-semibold mt-1">{{ $rental->equipment->name }}</div>
                                </td>
                                <td>
                                    <div class="small">
                                        <i class="bi bi-calendar-event text-primary me-1"></i>
                                        {{ \Carbon\Carbon::parse($rental->rent_date)->format('d/m/y') }} -
                                        {{ \Carbon\Carbon::parse($rental->return_date)->format('d/m/y') }}
                                    </div>
                                    <small class="text-muted">
                                        ({{ \Carbon\Carbon::parse($rental->rent_date)->diffInDays($rental->return_date) }} Hari)
                                    </small>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</span>
                                </td>
                                <td>
                                    @if ($rental->status == 'rented')
                                        <span class="badge rounded-pill bg-warning text-dark px-3">
                                            <i class="bi bi-play-circle me-1"></i> Aktif
                                        </span>
                                    @else
                                        <span class="badge rounded-pill bg-success px-3">
                                            <i class="bi bi-check2-all me-1"></i> Selesai
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($rental->status == 'rented')
                                        <form action="{{ route('admin.rentals.return', $rental->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary shadow-sm"
                                                onclick="return confirm('Apakah barang sudah diterima kembali dengan baik?')">
                                                <i class="bi bi-arrow-return-left me-1"></i> Selesaikan
                                            </button>
                                        </form>
                                    @else
                                        <div class="text-muted small">
                                            <i class="bi bi-calendar-check me-1"></i>
                                            {{ \Carbon\Carbon::parse($rental->actual_return_date)->format('d/m/y H:i') }}
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                    Belum ada transaksi rental masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $rentals->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
