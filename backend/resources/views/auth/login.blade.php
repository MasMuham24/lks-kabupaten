@extends('layouts.app')
@section('title', 'Login')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header text-center bg-primary text-white">
                    Login
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login.process') }}">
                        @csrf

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('register') }}">Belum punya akun? Register</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
