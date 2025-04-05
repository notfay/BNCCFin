<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }
    
    public function dashboard()
    {
        $stats = [
            'products' => Product::count(),
            'categories' => Category::count(),
            'invoices' => Invoice::count(),
            'users' => User::where('role', 'user')->count(),
            'revenue' => Invoice::sum('total_amount')
        ];
        
        $latestProducts = Product::with('category')->latest()->take(5)->get();
        $latestInvoices = Invoice::with('user')->latest()->take(5)->get();
        
        return view('admin.dashboard', compact('stats', 'latestProducts', 'latestInvoices'));
    }
}