@extends('layouts.admin')

@section('title', 'Tambah Equipment')

@section('content')

<div class="card shadow-sm">
    <div class="card-body">

        <form action="{{ route('equipment.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Equipment</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Type</label>
                <input type="text" name="type" class="form-control" value="{{ old('type') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Foto Alat</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Harga per Hari</label>
                <input type="number" name="price_per_day" class="form-control" value="{{ old('price_per_day') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control" value="{{ old('stock') }}" required>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Simpan
                </button>

                <a href="{{ route('equipment.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>

        </form>

    </div>
</div>

@endsection
