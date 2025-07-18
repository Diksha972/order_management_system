@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">Edit Product</h4>
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3" required>{{ $product->description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price (₹)</label>
                        <input type="number" step="0.01" name="price" class="form-control" value="{{ $product->price }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        @if ($product->image)
                            <div class="mt-2">
                                <p>Current Image:</p>
                                <img src="{{ asset('storage/products/' . $product->image) }}" width="120">
                            </div>
                        @endif
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-warning">✏️ Update Product</button>
                    </div>
                </form>

                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary mt-3">← Back to Product List</a>
            </div>
        </div>
    </div>
</div>
@endsection
