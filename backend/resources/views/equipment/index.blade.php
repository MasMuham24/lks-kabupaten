@extends('layouts.admin')

@section('title', 'Data Equipment')

@section('content')
    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-0 fw-bold">
                    <i class="bi bi-box-seam me-2 text-primary"></i>
                    Data Equipment
                </h3>
                <small class="text-muted">Kelola seluruh data peralatan rental</small>
            </div>

            <a href="{{ route('equipment.create') }}" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Tambah Equipment
            </a>
        </div>

        <form method="GET" class="row mb-3">
            <div class="col-md-4">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                    placeholder="Cari nama atau type...">
            </div>

            <div class="col-md-2">
                <select name="per_page" class="form-select" onchange="this.form.submit()">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-outline-primary">
                    <i class="bi bi-search"></i> Search
                </button>
            </div>
        </form>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table align-middle mb-0 table-hover">
                        <thead class="table-light">
                            <tr class="text-secondary">
                                <th width="60">#</th>

                                <th>
                                    <a href="{{ request()->fullUrlWithQuery([
                                        'sort' => 'name',
                                        'direction' => request('direction') == 'asc' ? 'desc' : 'asc',
                                    ]) }}"
                                        class="text-decoration-none text-dark">
                                        Nama
                                        @if (request('sort') == 'name')
                                            <i
                                                class="bi {{ request('direction') == 'asc' ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                        @endif
                                    </a>
                                </th>

                                <th>
                                    <a href="{{ request()->fullUrlWithQuery([
                                        'sort' => 'type',
                                        'direction' => request('direction') == 'asc' ? 'desc' : 'asc',
                                    ]) }}"
                                        class="text-decoration-none text-dark">
                                        Type
                                        @if (request('sort') == 'type')
                                            <i
                                                class="bi {{ request('direction') == 'asc' ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                        @endif
                                    </a>
                                </th>

                                <th>
                                    <a href="{{ request()->fullUrlWithQuery([
                                        'sort' => 'price_per_day',
                                        'direction' => request('direction') == 'asc' ? 'desc' : 'asc',
                                    ]) }}"
                                        class="text-decoration-none text-dark">
                                        Harga / Hari
                                        @if (request('sort') == 'price_per_day')
                                            <i
                                                class="bi {{ request('direction') == 'asc' ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                        @endif
                                    </a>
                                </th>

                                <th>
                                    <a href="{{ request()->fullUrlWithQuery([
                                        'sort' => 'stock',
                                        'direction' => request('direction') == 'asc' ? 'desc' : 'asc',
                                    ]) }}"
                                        class="text-decoration-none text-dark">
                                        Stock
                                        @if (request('sort') == 'stock')
                                            <i
                                                class="bi {{ request('direction') == 'asc' ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                        @endif
                                    </a>
                                </th>

                                <th width="170" class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($equipments as $key => $equipment)
                                <tr>
                                    <td class="text-muted">
                                        {{ $equipments->firstItem() + $key }}
                                    </td>

                                    <td class="fw-semibold">
                                        {{ $equipment->name }}
                                    </td>

                                    <td>
                                        <span class="badge bg-info text-dark">
                                            {{ $equipment->type }}
                                        </span>
                                    </td>

                                    <td class="fw-bold text-success">
                                        Rp {{ number_format($equipment->price_per_day, 0, ',', '.') }}
                                    </td>

                                    <td>
                                        @if ($equipment->stock > 5)
                                            <span class="badge bg-success">
                                                {{ $equipment->stock }} tersedia
                                            </span>
                                        @elseif($equipment->stock > 0)
                                            <span class="badge bg-warning text-dark">
                                                Stok sedikit ({{ $equipment->stock }})
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                Habis
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('equipment.edit', $equipment->id) }}"
                                            class="btn btn-sm btn-outline-warning me-1">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('equipment.destroy', $equipment->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Yakin hapus data ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="bi bi-inbox display-6 text-muted"></i>
                                        <p class="mt-3 text-muted">
                                            Belum ada data equipment.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between align-items-center p-3">
                        <div class="text-muted">
                            Menampilkan
                            {{ $equipments->firstItem() ?? 0 }}
                            -
                            {{ $equipments->lastItem() ?? 0 }}
                            dari
                            {{ $equipments->total() }} data
                        </div>

                        <div>
                            {{ $equipments->links('pagination::bootstrap-5') }}
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
