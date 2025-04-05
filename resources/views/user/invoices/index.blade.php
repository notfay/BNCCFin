@extends('layouts.app')

@section('title', 'My Invoices')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <h1>My Invoices</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                @if($invoices->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ $invoice->created_at->format('d M Y H:i') }}</td>
                                <td>{{ $invoice->formatTotal() }}</td>
                                <td>
                                    <a href="{{ route('user.invoices.show', $invoice->id) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('user.invoices.print', $invoice->id) }}" class="btn btn-sm btn-primary" target="_blank">Print</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <h4>You have no invoices yet</h4>
                    <p>Start shopping to create your first invoice</p>
                    <a href="{{ route('user.products.index') }}" class="btn btn-primary mt-2">Browse Products</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection