@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <style>
        .img-wrapper {
            width: 100%;
            aspect-ratio: 16 / 10;
            overflow: hidden;
            background-color: #f8f9fa;
            border-top-left-radius: calc(0.375rem - 1px);
            border-top-right-radius: calc(0.375rem - 1px);
        }

        .card-img-fit {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .card:hover .card-img-fit {
            transform: scale(1.08);
        }

        .card-disabled {
            background-color: #f1f1f1 !important;
            opacity: 0.8;
        }

        .img-gray {
            filter: grayscale(100%) opacity(0.6);
        }

        .unavailable-ribbon {
            position: absolute;
            top: 15px;
            right: -35px;
            transform: rotate(45deg);
            z-index: 10;
            background: #dc3545;
            color: white;
            padding: 5px 40px;
            font-weight: bold;
            font-size: 0.75rem;
            text-transform: uppercase;
        }

        .filter-btn.active {
            background-color: #0d6efd !important;
            color: white !important;
            border-color: #0d6efd !important;
        }
    </style>

    <div class="container py-4">
        <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div>
                <h4 class="fw-bold">Halo, {{ Auth::user()->name }}!</h4>
                <p class="text-muted small">Pilih alat terbaik untuk kebutuhan Anda.</p>
            </div>
            <div class="mt-2 mt-md-0">
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2">
                    User Access
                </span>
            </div>
        </div>

        <div class="mb-4">
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('dashboard') }}"
                    class="btn btn-outline-primary btn-sm filter-btn {{ !request('type') ? 'active' : '' }}">Semua</a>
                @foreach (['Technology', 'Camera', 'Drone', 'Camping'] as $cat)
                    <a href="{{ route('dashboard', ['type' => $cat]) }}"
                        class="btn btn-outline-primary btn-sm filter-btn {{ request('type') == $cat ? 'active' : '' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="row">
            @forelse($equipments as $item)
                @php
                    $imagePath = Str::startsWith($item->image, ['http://', 'https://'])
                        ? $item->image
                        : asset('storage/' . $item->image);
                @endphp
                <div class="col-sm-6 col-lg-4 mb-4">
                    <div
                        class="card h-100 border-0 shadow-sm position-relative overflow-hidden {{ $item->stock <= 0 ? 'card-disabled' : '' }}">
                        @if ($item->stock <= 0)
                            <div class="unavailable-ribbon">Habis</div>
                        @endif
                        <div class="img-wrapper">
                            <img src="{{ $imagePath }}" class="card-img-fit {{ $item->stock <= 0 ? 'img-gray' : '' }}">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between mb-2">
                                <h6 class="fw-bold mb-0 text-truncate">{{ $item->name }}</h6>
                                <span class="badge bg-light text-secondary border small">{{ $item->type }}</span>
                            </div>
                            <p class="text-muted small mb-4">{{ Str::limit($item->description, 60) }}</p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <div>
                                    <span
                                        class="text-primary fw-bold fs-5">Rp{{ number_format($item->price_per_day, 0, ',', '.') }}</span>
                                    <small class="text-muted small">/hari</small>
                                </div>
                                <small
                                    class="fw-bold {{ $item->stock > 0 ? 'text-success' : 'text-danger' }}">{{ $item->stock }}
                                    Unit</small>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 pb-3">
                            @if ($item->stock > 0)
                                <button class="btn btn-primary w-100 fw-bold py-2" data-bs-toggle="modal"
                                    data-bs-target="#rentModal{{ $item->id }}">Sewa</button>
                            @else
                                <button class="btn btn-secondary w-100 py-2" disabled>Stok Habis</button>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="rentModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <form action="{{ route('rental.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="equipment_id" value="{{ $item->id }}">
                            <div class="modal-content border-0">
                                <div class="modal-header">
                                    <h5 class="fw-bold">Sewa {{ $item->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body py-0 text-center">
                                    <div class="img-wrapper mx-auto mb-3" style="width: 150px; border-radius: 8px;">
                                        <img src="{{ $imagePath }}" class="w-100 h-100" style="object-fit: cover;">
                                    </div>
                                    <div class="row g-2 mb-3">
                                        <div class="col-6 text-start">
                                            <label class="small fw-bold">Tgl Pinjam</label>
                                            <input type="date" name="rent_date" class="form-control form-control-sm"
                                                required min="{{ date('Y-m-d') }}">
                                        </div>
                                        <div class="col-6 text-start">
                                            <label class="small fw-bold">Tgl Kembali</label>
                                            <input type="date" name="return_date" class="form-control form-control-sm"
                                                required min="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="submit" class="btn btn-primary w-100 fw-bold">Konfirmasi Sewa</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 text-muted">Barang tidak ditemukan.</div>
            @endforelse
        </div>
    </div>
@endsection
