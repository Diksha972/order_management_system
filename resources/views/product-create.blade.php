@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Add New Product</h4>
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('products.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter product name" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Enter product description" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price (₹)</label>
                        <input type="number" name="price" step="0.01" class="form-control" placeholder="Enter product price" required>
                    </div>

                    {{-- <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" name="quantity" class="form-control" placeholder="Enter available quantity" required>
                    </div> --}}

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">💾 Save Product</button>
                    </div>
                </form>

                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary mt-3">← Back to Product List</a>
            </div>
        </div>
    </div>
</div>
@endsection
