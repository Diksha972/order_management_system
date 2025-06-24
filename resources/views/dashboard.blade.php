@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">User Dashboard</h4>
            </div>

            <div class="card-body">
                <p class="mb-4">Welcome, <strong>{{ auth()->user()->name }}</strong>! Explore products or view your order history below.</p>

                <div class="list-group">
                    <a href="{{ route('products.list') }}" class="list-group-item list-group-item-action">
                        🛍️ View Products
                    </a>

                    <a href="{{ route('orders.user') }}" class="list-group-item list-group-item-action">
                        📜 Order History
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
