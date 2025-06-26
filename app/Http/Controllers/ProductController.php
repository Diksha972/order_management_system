<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('product-index', compact('products'));
    }

    public function create()
    {
        return view('product-create');
    }

    public function store(Request $request)
    {
       $product = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'quantity' => 'required|integer'
        ]);

         if ($request->hasFile('image')) {
        $product['image'] = basename($request->file('image')->store('products', 'public'));
    }
        Product::create($product);
        //   dd($request->file('image'));
        return redirect()->route('products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product)
    {
        return view('product-edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $productdata = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'quantity' => 'required|integer'
        ]);
        if ($request->hasFile('image')) {
            if ($product->image) {
            Storage::disk('public')->delete('products/' . $product->image);
        }
         $productdata['image'] = basename($request->file('image')->store('products', 'public'));
    }


        $product->update($productdata);
        return redirect()->route('products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted.');
    }

    public function showdetail($id)
{
    $product = Product::findOrFail($id);
    return view('product-details', compact('product'));
}

}
