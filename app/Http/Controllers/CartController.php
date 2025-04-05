<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:user');
    }
    
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('user.cart', compact('cart'));
    }
    
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $quantity = $request->quantity ?? 1;
        
        if ($product->isOutOfStock()) {
            return back()->with('error', 'Barang sudah habis, silakan tunggu hingga barang di-restock ulang');
        }
        
        if ($product->quantity < $quantity) {
            return back()->with('error', 'Requested quantity exceeds available stock');
        }
        
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            $newQuantity = $cart[$id]['quantity'] + $quantity;
            
            if ($newQuantity > $product->quantity) {
                return back()->with('error', 'Requested quantity exceeds available stock');
            }
            
            $cart[$id]['quantity'] = $newQuantity;
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->image,
                'category' => $product->category->name
            ];
        }
        
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully');
    }
    
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            $product = Product::findOrFail($id);
            $quantity = (int)$request->quantity;
            
            if ($quantity <= 0) {
                return redirect()->back()->with('error', 'Quantity must be greater than zero');
            }
            
            if ($quantity > $product->quantity) {
                return redirect()->back()->with('error', 'Requested quantity exceeds available stock');
            }
            
            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Cart updated successfully');
    }
    
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Product removed from cart successfully');
    }
    
    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Cart cleared successfully');
    }
}