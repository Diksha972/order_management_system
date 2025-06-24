@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Available Products</h4>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($products->isEmpty())
                    <div class="alert alert-warning text-center">No products available to order.</div>
                @else
                    @foreach($products as $product)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ $product->description }}</p>
                                <p class="card-text"><strong>Price:</strong> ₹{{ number_format($product->price, 2) }}</p>

                                <form method="POST" action="{{ route('order.place', $product->id) }}" class="row g-2 align-items-center">
                                    @csrf
                                    <div class="col-auto">
                                        <label class="form-label">Qty:</label>
                                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->quantity }}" class="form-control form-control-sm" required>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-success btn-sm mt-4">🛒 Order</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endif

                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mt-3">← Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
