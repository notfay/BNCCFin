@extends('layouts.app')

@section('title', 'Invoice Details')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4 d-flex justify-content-between align-items-center">
        <h1>Invoice #{{ $invoice->invoice_number }}</h1>
        <div>
            <a href="{{ route('user.invoices.print', $invoice->id) }}" class="btn btn-primary" target="_blank">Print Invoice</a>
            <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary">Back to Invoices</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Invoice Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
                        <p><strong>Date:</strong> {{ $invoice->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Customer:</strong> {{ $invoice->user->name }}</p>
                        <p><strong>Email:</strong> {{ $invoice->user->email }}</p>
                        <p><strong>Phone:</strong> {{ $invoice->user->phone }}</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <p><strong>Shipping Address:</strong><br>{{ $invoice->shipping_address }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Postal Code:</strong> {{ $invoice->postal_code }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5>Order Items</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice->invoiceItems as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->product->category->name }}</td>
                                <td>Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rp. {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-end">Total:</th>
                                <th>{{ $invoice->formatTotal() }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection