@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0">My Orders</h4>
            </div>

            <div class="card-body">
                @if($orders->isEmpty())
                    <div class="alert alert-warning text-center">
                        You have not placed any orders yet.
                    </div>
                @else
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Order Date</th>                             
                                <th>Status</th>
                                <th>Cancel Order</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->product->name }}</td>
                                    <td>{{ $order->quantity }}</td>
                                    <td>₹{{ number_format($order->total_price, 2) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y, h:i A') }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($order->status === 'completed') bg-success 
                                            @elseif($order->status === 'pending') bg-warning 
                                            @else bg-secondary 
                                            @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
                                         @if($order->status !== 'cancelled' && \Carbon\Carbon::now()->lt($order->delivered_date))
                                        <form method="POST" action="{{ route('order.cancel', $order->id) }}"
                                              onsubmit="if(confirm('Are you sure you want to cancel this order?')) { this.querySelector('button').disabled = true; } else { return false; }">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">Cancel</button>
                                        </form>
                                    @else
                                        <button class="btn btn-sm btn-secondary" disabled>Cancelled</button>
                                    @endif
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
