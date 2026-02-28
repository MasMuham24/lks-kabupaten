@extends('layouts.admin')

@section('content')
    <h3 class="mb-4">
        <i class="bi bi-speedometer2"></i> Dashboard Overview
    </h3>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 text-white bg-primary shadow-sm">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1">Total Equipment</h6>
                        <h2 class="fw-bold mb-0">{{ \App\Models\Equipment::count() }}</h2>
                    </div>
                    <i class="bi bi-box fs-1 opacity-50"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 text-white bg-success shadow-sm">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1">Total Rental</h6>
                        <h2 class="fw-bold mb-0">{{ \App\Models\Rental::count() }}</h2>
                    </div>
                    <i class="bi bi-receipt fs-1 opacity-50"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 text-white bg-warning shadow-sm">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1">Total Pelanggan</h6>
                        <h2 class="fw-bold mb-0">{{ \App\Models\User::where('role', 'user')->count() }}</h2>
                    </div>
                    <i class="bi bi-people fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-bar-chart-line text-primary"></i> Tren Rental (7 Hari Terakhir)
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="rentalChart" style="min-height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-5 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-clock-history text-primary"></i> Rental Terbaru</h6>
                    <a href="{{ route('admin.rentals.index') }}" class="btn btn-sm btn-link text-decoration-none p-0">Lihat
                        Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @php
                            $recentRentals = \App\Models\Rental::with(['user', 'equipment'])
                                ->latest()
                                ->take(6)
                                ->get();
                        @endphp

                        @forelse($recentRentals as $rental)
                            <div class="list-group-item border-0 border-bottom px-3 py-3">
                                <div class="d-flex w-100 justify-content-between align-items-center">
                                    <h6 class="mb-1 fw-bold text-dark">{{ $rental->user->name ?? 'User Unknown' }}</h6>
                                    <small
                                        class="badge bg-light text-primary border">{{ $rental->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1 small text-muted">Menyewa:
                                    <strong>{{ $rental->equipment->name ?? 'Deleted Item' }}</strong></p>
                                <small class="text-muted"><i class="bi bi-calendar-check"></i>
                                    {{ $rental->created_at->format('d M Y, H:i') }}</small>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="bi bi-inbox fs-2 text-muted"></i>
                                <p class="text-muted small">Belum ada transaksi</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('rentalChart');

        // Mengambil data 7 hari terakhir secara dinamis
        const chartData = {!! json_encode(
            \App\Models\Rental::selectRaw('DATE(created_at) as date, COUNT(*) as count')->where('created_at', '>=', now()->subDays(6))->groupBy('date')->orderBy('date', 'asc')->get()->map(function ($item) {
                    return [
                        'label' => \Carbon\Carbon::parse($item->date)->format('d M'),
                        'value' => $item->count,
                    ];
                }),
        ) !!};

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.map(d => d.label),
                datasets: [{
                    label: 'Jumlah Transaksi',
                    data: chartData.map(d => d.value),
                    backgroundColor: '#0d6efd',
                    borderRadius: 5,
                    barThickness: 30
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
@endsection
