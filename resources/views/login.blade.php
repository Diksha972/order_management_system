@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card shadow">
            <div class="card-header bg-primary text-white">Login</div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">Login</button>
                    </div>

                    <div class="mt-3 text-center">
                        Don't have an account? <a href="{{ route('register') }}">Register here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
    