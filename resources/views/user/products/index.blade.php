@extends('layouts.app')

@section('title', 'Products Catalog')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <h1>Products Catalog</h1>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Filter by Category</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ route('user.products.index') }}" class="btn btn-sm {{ request()->routeIs('user.products.index') && !request()->query('category') ? 'btn-primary' : 'btn-outline-primary' }} mb-2">All</a>
                        @foreach($categories as $category)
                        <a href="{{ route('user.products.index', ['category' => $category->id]) }}" class="btn btn-sm {{ request()->query('category') == $category->id ? 'btn-primary' : 'btn-outline-primary' }} mb-2">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    @foreach($products as $product)
    <div class="col-md-3 mb-4">
        <div class="card h-100">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top product-image" alt="{{ $product->name }}">
            @else
                <div class="bg-light p-4 text-center card-img-top product-image">
                    <p class="text-muted mt-4">No image available</p>
                </div>
            @endif
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text text-primary fw-bold">{{ $product->formatPrice() }}</p>
                <p class="card-text">Category: {{ $product->category->name }}</p>
                <p class="card-text">
                    @if($product->isOutOfStock())
                        <span class="badge bg-danger">Out of Stock</span>
                    @else
                        <span class="badge bg-success">In Stock ({{ $product->quantity }})</span>
                    @endif
                </p>
            </div>
            <div class="card-footer">
                <a href="{{ route('user.products.show', $product->id) }}" class="btn btn-info btn-sm">View Details</a>
                @if(!$product->isOutOfStock())
                <form action="{{ route('user.cart.add', $product->id) }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn btn-primary btn-sm">Add to Cart</button>
                </form>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection