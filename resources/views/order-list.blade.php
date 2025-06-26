@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">All Orders</h4>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($orders->isEmpty())
                    <div class="alert alert-warning text-center">No orders have been placed yet.</div>
                @else
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>User</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Product Image</th>
                                <th>Total Price</th>
                                <th>Order Date</th>
                                <th>delivery Date</th>
                                <th>Status</th>
                                <th>Change Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->product->name }}</td>
                                <td>{{ $order->quantity }}</td>
                                <td>
                                        <img src="{{ asset('storage/products/' . $order->product->image) }}" style="width: 50px; height: 50px;">           
                                </td>
                                <td>₹{{ number_format($order->total_price, 2) }}</td>
                                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y, h:i A') }}</td>
                                 <td>
                                     {{ $order->delivered_date ? \Carbon\Carbon::parse($order->delivered_date)->format('d M Y, h:i A') : '' }}
                                 </td>

                                   <td>
                                    {{-- Display status with appropriate badge --}}
                                    <span class="badge 
                                        @if($order->status === 'completed') bg-success
                                        @elseif($order->status === 'cancelled') bg-danger
                                        @else bg-warning
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('orders.updateStatus', $order->id) }}">
                                        @csrf
                                        <div class="input-group">
                                            <select name="status" class="form-select form-select-sm">
                                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                        </div>
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
