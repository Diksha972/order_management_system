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
                                    {{-- <div class="col-auto">
                                        <label class="form-label">Qty:</label>
                                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->quantity }}" class="form-control form-control-sm" required>
                                    </div> --}}
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#orderModal" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" data-product-price="{{ $product->price }}">Order</button>
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
    <!-- Order Modal -->
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
                    <small class="text-muted">Available: <span id="maxQtyText"></span></small>
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



<script>
    var orderModal = document.getElementById('orderModal');
    orderModal.addEventListener('show.bs.modal', function(event) {
        var btn = event.relatedTarget;
        var pid = btn.getAttribute('data-product-id');
        var pname = btn.getAttribute('data-product-name');
        var maxQty = btn.getAttribute('data-max-qty');
        document.getElementById('modalProductName').textContent = pname;
        document.getElementById('qtyInput').max = maxQty;
        document.getElementById('maxQtyText').textContent = maxQty;
        document.getElementById('modalOrderForm').action = '/order/' + pid;
    });
</script>


</div>
@endsection
