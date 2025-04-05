<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $invoices = Invoice::with('user')->latest()->get();
            return view('admin.invoices.index', compact('invoices'));
        }
        
        $invoices = Invoice::where('user_id', Auth::id())->latest()->get();
        return view('user.invoices.index', compact('invoices'));
    }
    
    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('user.products.index')
                ->with('error', 'Your cart is empty. Please add items before checkout.');
        }
        
        return view('user.checkout', compact('cart'));
    }
    
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('user.products.index')
                ->with('error', 'Your cart is empty. Please add items before checkout.');
        }
        
        $validator = Validator::make($request->all(), [
            'shipping_address' => 'required|string|min:10|max:100',
            'postal_code' => 'required|string|size:5|regex:/^[0-9]+$/',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        DB::beginTransaction();
        
        try {
           
            $invoiceNumber = 'INV-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));
            
            
            $totalAmount = 0;
            foreach ($cart as $item) {
                $totalAmount += $item['price'] * $item['quantity'];
            }
            
           
            $invoice = Invoice::create([
                'invoice_number' => $invoiceNumber,
                'user_id' => Auth::id(),
                'shipping_address' => $request->shipping_address,
                'postal_code' => $request->postal_code,
                'total_amount' => $totalAmount
            ]);
            
           
            foreach ($cart as $id => $details) {
                $product = Product::findOrFail($id);
                
                if ($product->quantity < $details['quantity']) {
                    DB::rollBack();
                    return back()->with('error', "Sorry, {$product->name} doesn't have enough stock.");
                }
                
                // Create invoice item
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $product->price,
                    'subtotal' => $product->price * $details['quantity']
                ]);
                
               
                $product->quantity -= $details['quantity'];
                $product->save();
            }
            
            DB::commit();
            
        
            session()->forget('cart');
            
            return redirect()->route('user.invoices.show', $invoice->id)
                ->with('success', 'Your order has been placed successfully.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'An error occurred while processing your order. Please try again.');
        }
    }
    
    public function show($id)
    {
        $invoice = Invoice::with(['user', 'invoiceItems.product.category'])->findOrFail($id);
        
        if (Auth::user()->role === 'user' && $invoice->user_id !== Auth::id()) {
            return redirect()->route('user.invoices.index')
                ->with('error', 'You are not authorized to view this invoice.');
        }
        
        if (Auth::user()->role === 'admin') {
            return view('admin.invoices.show', compact('invoice'));
        }
        
        return view('user.invoices.show', compact('invoice'));
    }
    
    public function printInvoice($id)
    {
        $invoice = Invoice::with(['user', 'invoiceItems.product.category'])->findOrFail($id);
        
        if (Auth::user()->role === 'user' && $invoice->user_id !== Auth::id()) {
            return redirect()->route('user.invoices.index')
                ->with('error', 'You are not authorized to print this invoice.');
        }
        
        return view('invoice.print', compact('invoice'));
    }
}