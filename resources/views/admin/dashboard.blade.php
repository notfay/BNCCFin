@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <h1>Dashboard</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white h-100">
            <div class="card-body">
                <h5 class="card-title">Products</h5>
                <h2 class="mt-3">{{ $stats['products'] }}</h2>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('admin.products.index') }}" class="text-white">View Details</a>
                <i class="bi bi-arrow-right text-white"></i>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <h5 class="card-title">Categories</h5>
                <h2 class="mt-3">{{ $stats['categories'] }}</h2>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('admin.categories') }}" class="text-white">View Details</a>
                <i class="bi bi-arrow-right text-white"></i>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card bg-warning h-100">
            <div class="card-body">
                <h5 class="card-title">Invoices</h5>
                <h2 class="mt-3">{{ $stats['invoices'] }}</h2>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('admin.invoices.index') }}" class="text-dark">View Details</a>
                <i class="bi bi-arrow-right text-dark"></i>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card bg-info text-white h-100">
            <div class="card-body">
                <h5 class="card-title">Users</h5>
                <h2 class="mt-3">{{ $stats['users'] }}</h2>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <span class="text-white">Registered Users</span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Recent Products</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestProducts as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->formatPrice() }}</td>
                                <td>
                                    @if($product->isOutOfStock())
                                        <span class="badge bg-danger">Out of Stock</span>
                                    @elseif($product->quantity < 10)
                                        <span class="badge bg-warning">Low Stock</span>
                                    @else
                                        <span class="badge bg-success">In Stock</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-primary">View All Products</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Recent Invoices</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestInvoices as $invoice)
                            <tr>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ $invoice->user->name }}</td>
                                <td>{{ $invoice->formatTotal() }}</td>
                                <td>{{ $invoice->created_at->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <a href="{{ route('admin.invoices.index') }}" class="btn btn-sm btn-primary">View All Invoices</a>
            </div>
        </div>
    </div>
</div>
@endsection