@extends('layout')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4 text-primary">Available Products</h3>

   

    @if($products->isEmpty())
        <div class="alert alert-warning text-center">No products available to order.</div>
    @else
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow rounded-3 border-0">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-center mb-3">{{ $product->name }}</h5>
                            <img src="{{ asset('storage/products/' . $product->image) }}" class="img-fluid rounded mb-3" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                            <p class="card-text text-muted mb-3">{{ Str::limit($product->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <strong class="text-dark">₹{{ number_format($product->price, 2) }}</strong>
                             <a href="{{ route('products.details', $product->id) }}" class="btn btn-sm btn-primary">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mt-3">← Back</a>
</div>


@endsection
