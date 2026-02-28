@extends('layouts.app')

@section('content')
<style>
    .card-disabled {
        background-color: #ececec !important;
        border: 1px solid #ccc;
    }
    .img-gray {
        filter: grayscale(100%);
        opacity: 0.5;
    }
    .unavailable-label {
        position: absolute;
        top: 40%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-15deg);
        z-index: 10;
        background: rgba(255, 0, 0, 0.8);
        color: white;
        padding: 5px 15px;
        font-weight: bold;
        font-size: 1.5rem;
        border: 2px solid white;
        text-transform: uppercase;
        pointer-events: none;
    }
</style>

<div class="container py-4">
    <div class="row">
        @foreach($equipments as $item)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm position-relative {{ $item->stock <= 0 ? 'card-disabled' : '' }}">

                    @if($item->stock <= 0)
                        <div class="unavailable-label">Unavailable</div>
                    @endif

                    <img src="{{ asset('storage/' . $item->image) }}"
                         class="card-img-top {{ $item->stock <= 0 ? 'img-gray' : '' }}"
                         style="height: 200px; object-fit: cover;">

                    <div class="card-body">
                        <h5 class="card-title">{{ $item->name }}</h5>
                        <p class="text-muted small">{{ $item->description }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-primary fw-bold">Rp {{ number_format($item->price_per_day) }}</span>
                            <span class="badge {{ $item->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                Stok: {{ $item->stock }}
                            </span>
                        </div>
                    </div>

                    <div class="card-footer bg-transparent border-0">
                        @if($item->stock > 0)
                            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#rentModal{{ $item->id }}">
                                Sewa Sekarang
                            </button>
                        @else
                            <button class="btn btn-secondary w-100" disabled>Tidak Tersedia</button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="modal fade" id="rentModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('rentals.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="equipment_id" value="{{ $item->id }}">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Sewa {{ $item->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Tanggal Mulai</label>
                                    <input type="date" name="rent_date" class="form-control" required min="{{ date('Y-m-d') }}">
                                </div>
                                <div class="mb-3">
                                    <label>Tanggal Kembali</label>
                                    <input type="date" name="return_date" class="form-control" required min="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary w-100">Konfirmasi</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
