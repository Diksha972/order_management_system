<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use PDF;
use Mail;
use Carbon\Carbon;


class OrderController extends Controller
{
    public function showProducts()
    {
        $products = Product::all();
        return view('product-list', compact('products'));
    }

public function placeOrder(Request $request, $id)
{
    $request->validate([
          'address' => 'required|string',
            'phone' => 'required|string|max:15',
        'quantity' => 'required|integer|min:1|max:100', 
    ]);

    $product = Product::findOrFail($id);
    $quantity = $request->input('quantity');
    $total = $product->price * $quantity;

    // Create the order (only once)
    $order = Order::create([
        'user_id' => Auth::id(),
        'product_id' => $product->id,
        'quantity' =>$request->input('quantity'),
         'address'  => $request->input('address'),
         'phone'    => $request->input('phone'),
        'total_price' => $total,
        'order_date'     => Carbon::now(),
        'delivered_date' => Carbon::now()->addDays(3),
        'status' => 'pending',
    ]);

    // Generate PDF
    $pdf = PDF::loadView('invoice', [
        'order' => $order,
        'product' => $product,
        'user' => Auth::user(),
    ]);

    $pdfPath = storage_path("app/public/invoice_order_{$order->id}.pdf");
    $pdf->save($pdfPath);

    // Send email with invoice
    Mail::send('email', ['order' => $order], function($message) use ($pdfPath, $order) {
        $message->to(Auth::user()->email)
                ->subject('Order Confirmation')
                ->attach($pdfPath, [
                    'as' => "invoice_order_{$order->id}.pdf",
                    'mime' => 'application/pdf',
                ]);
    });

    return redirect()->back()->with('success', 'Order placed! Invoice sent via email.');
}

    public function userOrders()
    {
        $orders = Order::where('user_id', Auth::id())->with('product')->get();
        return view('order-history', compact('orders'));
    }

    public function allOrders()
    {
        $orders = Order::with('user', 'product')->get();
        return view('order-list', compact('orders'));
    }
    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:pending,completed,cancelled',
    ]);

    $order = \App\Models\Order::findOrFail($id);
    $order->status = $request->status;
    $order->save();

    return redirect()->route('orders.all')->with('success', 'Order status updated.');
}

}
