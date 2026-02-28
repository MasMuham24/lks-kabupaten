@extends('layouts.admin')

@section('title', 'Edit Equipment')

@section('content')

<div class="card shadow-sm">
    <div class="card-body">

        <form action="{{ route('equipment.update', $equipment->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Equipment</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $equipment->name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Type</label>
                <input type="text" name="type" class="form-control" value="{{ old('type', $equipment->type) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3" required>{{ old('description', $equipment->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Foto Alat</label>
                @if($equipment->image)
                    <div class="mb-2">
                        <small class="text-muted d-block mb-1">Foto Saat Ini:</small>
                        <img src="{{ asset('storage/' . $equipment->image) }}" class="img-thumbnail" style="width: 150px;">
                    </div>
                @endif
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                <small class="text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Harga per Hari</label>
                <input type="number" name="price_per_day" class="form-control" value="{{ old('price_per_day', $equipment->price_per_day) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control" value="{{ old('stock', $equipment->stock) }}" required>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-pencil-square"></i> Update
                </button>

                <a href="{{ route('equipment.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>

        </form>

    </div>
</div>

@endsection
