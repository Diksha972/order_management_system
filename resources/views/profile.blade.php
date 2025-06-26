<!DOCTYPE html>
<html>
<head>
    <title>MyShop - Home</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand" href="{{ route('profile') }}">MyShop</a>

        <!-- Navbar links -->
        <div class="ms-auto d-flex align-items-center">
            @auth
                <span class="text-white me-3">Welcome, {{ auth()->user()->name }}</span>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-light me-2">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-outline-danger">Logout</button>
                </form>
            @else
                <span class="text-white me-3">Welcome</span>
                <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline-light">Register</a>
            @endauth
        </div>
    </div>
</nav>

<!-- Main Shopping Content -->
<div class="container mt-4">
    <h3 class="mb-4">Available Products</h3>
  <div class="row">
    @foreach(\App\Models\Product::all() as $product)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow rounded-3 border-0">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-center  mb-3">{{ $product->name }}</h5>
                    <img src="{{ asset('storage/products/' . $product->image) }}" class="img-fluid rounded mb-3" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                    <p class="card-text text-muted mb-3">{{ Str::limit($product->description, 100) }}</p>
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <strong class="text-dark">₹{{ $product->price }}</strong>
                        @auth
                            <form method="POST" action="{{ route('order.place', $product->id) }}">
                                @csrf
                                <button class="btn btn-sm btn-success">Place Order</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">Order</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
