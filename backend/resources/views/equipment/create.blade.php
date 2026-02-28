@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <h3 class="mb-3">Tambah Equipment</h3>

        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('equipment.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @include('equipment.form')

                    <div class="mt-3">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                        <a href="{{ route('equipment.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
