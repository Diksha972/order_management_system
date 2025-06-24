@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">Admin Dashboard</h4>
            </div>

            <div class="card-body">
                <p class="mb-4">Welcome, <strong>{{ auth()->user()->name }}</strong>! Use the options below to manage the system.</p>

                <div class="list-group">
                    <a href="{{ route('products.index') }}" class="list-group-item list-group-item-action">
                        🛒 Manage Products
                    </a>

                    <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action">
                        👥 Manage Users
                    </a>

                    <a href="{{ route('orders.all') }}" class="list-group-item list-group-item-action">
                        📦 View All Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
