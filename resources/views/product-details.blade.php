@extends('layout')

@section('content')
<div class="container mt-5">
     @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card shadow-lg">
        <div class="row g-0">
            <div class="col-md-5">
                <img src="{{ asset('storage/products/' . $product->image) }}" class="img-fluid rounded-start" alt="{{ $product->name }}">
            </div>
            <div class="col-md-7">
                <div class="card-body d-flex flex-column h-100">
                    <h3 class="card-title">{{ $product->name }}</h3>
                    <p class="card-text text-muted mt-3">{{ $product->description }}</p>
                    <h4 class="text-success mt-auto">₹{{ number_format($product->price, 2) }}</h4>

                    @auth
                        <form method="POST" action="{{ route('order.place', $product->id) }}" class="mt-4">
                            @csrf
                              <button type="button" class="btn btn-sm btn-success"
                                    data-bs-toggle="modal"
                                    data-bs-target="#orderModal"
                                    data-product-id="{{ $product->id }}"
                                    data-product-name="{{ $product->name }}"
                                    data-product-price="{{ $product->price }}">
                                    Order
                                </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary mt-4">Login to Order</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('products.list') }}" class="btn btn-link mt-3">← Back to Products</a>

    <!-- Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="modalOrderForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Place Order for <span id="modalProductName"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="qtyInput" class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="quantity" id="qtyInput" value="1" min="1" required>
                        <small class="text-muted">Default quantity: 1</small>
                    </div>

                    <div class="mb-3">
                        <label for="addressInput" class="form-label">Address</label>
                        <textarea name="address" id="addressInput" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="phoneInput" class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" id="phoneInput" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Buy Now</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Script -->
<script>
    var orderModal = document.getElementById('orderModal');
    orderModal.addEventListener('show.bs.modal', function(event) {
        var btn = event.relatedTarget;
        var pid = btn.getAttribute('data-product-id');
        var pname = btn.getAttribute('data-product-name');
        document.getElementById('modalProductName').textContent = pname;
        document.getElementById('modalOrderForm').action = '/order/' + pid;
    });
</script>
</div>
@endsection
