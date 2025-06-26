@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-11">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Product List</h4>
                <a href="{{ route('products.create') }}" class="btn btn-light btn-sm">➕ Add Product</a>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($products->isEmpty())
                    <div class="alert alert-warning text-center">No products available.</div>
                @else
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Price (₹)</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->description }}</td>
                                <td>
                                        <img src="{{ asset('storage/products/' . $product->image) }}"  alt="{{ $product->name }}" style="width: 50px; height: 50px;">             
                                </td>
                                <td>₹{{ number_format($product->price, 2) }}</td>
                                <td>
                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">✏️ Edit</a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">🗑 Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mt-3">← Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
