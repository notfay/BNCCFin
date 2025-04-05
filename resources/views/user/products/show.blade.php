@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <a href="{{ route('user.products.index') }}" class="btn btn-secondary">Back to Products</a>
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <div class="card mb-4">
            <div class="card-body text-center">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded">
                @else
                    <div class="bg-light p-5 text-center">
                        <p class="text-muted">No image available</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">{{ $product->name }}</h1>
                <p class="card-text fs-3 text-primary">{{ $product->formatPrice() }}</p>
                
                <dl class="row mt-4">
                    <dt class="col-sm-3">Category</dt>
                    <dd class="col-sm-9">{{ $product->category->name }}</dd>
                    
                    <dt class="col-sm-3">Availability</dt>
                    <dd class="col-sm-9">
                        @if($product->isOutOfStock())
                            <span class="badge bg-danger">Out of Stock</span>
                        @else
                            <span class="badge bg-success">In Stock ({{ $product->quantity }} available)</span>
                        @endif
                    </dd>
                </dl>
                
                @if($product->isOutOfStock())
                    <div class="alert alert-warning mt-3">
                        Barang sudah habis, silakan tunggu hingga barang di-restock ulang
                    </div>
                @else
                    <div class="mt-4">
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-auto">
                                    <label for="quantity" class="visually-hidden">Quantity</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="{{ $product->quantity }}">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection