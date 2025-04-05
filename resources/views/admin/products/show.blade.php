@extends('layouts.app')

@section('title', 'Product Details')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4 d-flex justify-content-between align-items-center">
        <h1>Product Details</h1>
        <div>
            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
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
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">{{ $product->name }}</h2>
                <p class="card-text fs-4 text-primary">{{ $product->formatPrice() }}</p>
                
                <dl class="row mt-4">
                    <dt class="col-sm-3">Category</dt>
                    <dd class="col-sm-9">{{ $product->category->name }}</dd>
                    
                    <dt class="col-sm-3">Quantity</dt>
                    <dd class="col-sm-9">
                        {{ $product->quantity }}
                        @if($product->isOutOfStock())
                            <span class="badge bg-danger">Out of Stock</span>
                        @elseif($product->quantity < 10)
                            <span class="badge bg-warning">Low Stock</span>
                        @else
                            <span class="badge bg-success">In Stock</span>
                        @endif
                    </dd>
                    
                    <dt class="col-sm-3">Created At</dt>
                    <dd class="col-sm-9">{{ $product->created_at->format('F d, Y H:i') }}</dd>
                    
                    <dt class="col-sm-3">Last Updated</dt>
                    <dd class="col-sm-9">{{ $product->updated_at->format('F d, Y H:i') }}</dd>
                </dl>
                
                <div class="mt-4">
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection