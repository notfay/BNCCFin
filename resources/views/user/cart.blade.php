@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4 d-flex justify-content-between align-items-center">
        <h1>Shopping Cart</h1>
        <div>
            <a href="{{ route('user.products.index') }}" class="btn btn-primary">Continue Shopping</a>
            @if(count($cart) > 0)
            <form action="{{ route('user.cart.clear') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to clear your cart?')">Clear Cart</button>
            </form>
            @endif
        </div>
    </div>
</div>

@if(count($cart) > 0)
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Cart Items</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $id => $details)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($details['image'])
                                            <img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['name'] }}" class="img-thumbnail me-2" width="50">
                                        @endif
                                        <div>
                                            <h6 class="mb-0">{{ $details['name'] }}</h6>
                                            <small class="text-muted">{{ $details['category'] }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>Rp. {{ number_format($details['price'], 0, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('user.cart.update', $id) }}" method="POST">
                                        @csrf
                                        <div class="input-group input-group-sm" style="width: 100px;">
                                            <input type="number" class="form-control" name="quantity" value="{{ $details['quantity'] }}" min="1">
                                            <button type="submit" class="btn btn-outline-secondary">
                                                <i class="bi bi-arrow-repeat">↻</i>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                                <td>Rp. {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('user.cart.remove', $id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Cart Summary</h5>
            </div>
            <div class="card-body">
                @php
                    $total = 0;
                    foreach($cart as $details) {
                        $total += $details['price'] * $details['quantity'];
                    }
                @endphp
                <p class="mb-2">Number of items: <span class="float-end">{{ count($cart) }}</span></p>
                <hr>
                <h5>Total: <span class="float-end">Rp. {{ number_format($total, 0, ',', '.') }}</span></h5>
                <div class="d-grid gap-2 mt-4">
                    <a href="{{ route('user.checkout') }}" class="btn btn-success">Proceed to Checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="card">
    <div class="card-body text-center py-5">
        <h3>Your cart is empty</h3>
        <p>You have no items in your shopping cart.<br>Click "Continue Shopping" to browse products.</p>
    </div>
</div>
@endif
@endsection