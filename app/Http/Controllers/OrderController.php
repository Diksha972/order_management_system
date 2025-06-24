<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use PDF;
use Mail;


class OrderController extends Controller
{
    public function showProducts()
    {
        $products = Product::all();
        return view('product-list', compact('products'));
    }

//     public function placeOrder(Request $request, $id)
// {
//     $product = Product::findOrFail($id);

//     $quantity = $request->input('quantity', 1);
//     $total = $product->price * $quantity;

//     $order = new Order();
//     $order->user_id = auth()->id();
//     $order->product_id = $product->id;
//     $order->quantity = $quantity;
//     $order->total_price = $total;  // ✅ Save total price
//     $order->status = 'pending';
//     $order->save();

//     return redirect()->back()->with('success', 'Order placed successfully!');
// }

//  public function placeOrder(Request $request, $id)
// {
//     $product = Product::findOrFail($id);

//     $quantity = $request->input('quantity', 1);
//     $total = $product->price * $quantity;

//     $order = new Order();
//     $order->user_id = auth()->id();
//     $order->product_id = $product->id;
//     $order->quantity = $quantity;
//     $order->total_price = $total;  
//     $order->status = 'pending';
//     $order->save();

//     $request->validate([
//         'quantity' => 'required|integer|min:1',
//     ]);

//     $product = Product::findOrFail($id);

//     // Store the order
//     $order = Order::create([
//         'user_id' => Auth::id(),
//         'product_id' => $product->id,
//         'quantity' => $request->quantity,
//         'total_price' => $product->$total,
//         'status' => 'pending',
//     ]);

//     // Generate PDF
//     $pdf = PDF::loadView('invoice', [
//         'order' => $order,
//         'product' => $product,
//         'user' => Auth::user(),
//     ]);

//     $pdfPath = storage_path("app/public/invoice_order_{$order->id}.pdf");
//     $pdf->save($pdfPath); // Save to disk

//     // Email with attachment (optional)
//     Mail::send('email', ['order' => $order], function($message) use ($pdfPath, $order) {
//         $message->to(Auth::user()->email)
//                 ->subject('Order Confirmation')
//                 ->attach($pdfPath, [
//                     'as' => "invoice_order_{$order->id}.pdf",
//                     'mime' => 'application/pdf',
//                 ]);
//     });

//     return redirect()->back()->with('success', 'Order placed! Invoice sent via email.');
// }

public function placeOrder(Request $request, $id)
{
    $request->validate([
        'quantity' => 'required|integer|min:1',
    ]);

    $product = Product::findOrFail($id);
    $quantity = $request->input('quantity', 1);
    $total = $product->price * $quantity;

    // Create the order (only once)
    $order = Order::create([
        'user_id' => Auth::id(),
        'product_id' => $product->id,
        'quantity' => $quantity,
        'total_price' => $total,
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
