@extends('layout.app')

@section('title', 'Edit Product')

@section('page-header', 'true')
@section('page-title', 'Edit Product')
@section('page-subtitle', 'Update coffee product details')
@section('page-actions')
    <a href="{{ route('product_page') }}" class="btn btn-outline">
        <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path d="M15 18l-6-6 6-6" />
        </svg>
        Back to Products
    </a>
@endsection

@section('content')
    <div class="card product-table-card">
        <div class="card-header">
            <h2 class="card-title">Edit Product</h2>
            <span class="table-meta">Update existing product information</span>
        </div>
        <form action="{{ route('update_product', $product->product_id) }}" method="POST" enctype="multipart/form-data"
            class="modal-form edit-product-form">
            @csrf
            <div class="form-grid">
                <label class="form-field">
                    <span>Product Name</span>
                    <input type="text" name="product_name" placeholder="Caramel Latte"
                        value="{{ $product->product_name ?? '' }}">
                </label>
                <label class="form-field">
                    <span>Category ID</span>
                    <input type="number" name="category_id" placeholder="2" value="{{ $product->category_id ?? '' }}">
                </label>
                <label class="form-field">
                    <span>Price</span>
                    <input type="number" name="price" step="0.01" placeholder="5.50"
                        value="{{ $product->price ?? '' }}">
                </label>
                <label class="form-field">
                    <span>Stock Quantity</span>
                       <select name="stock_quantity" class="form-select">
                            <option value="In Stock" {{ (isset($product->stock_quantity) && $product->stock_quantity == 'In Stock') ? 'selected' : '' }}>In Stock</option>
                            <option value="Out of Stock" {{ (isset($product->stock_quantity) && $product->stock_quantity == 'Out of Stock') ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                </label>
                <label class="form-field form-field--full">
                    <span>Description</span>
                    <textarea name="description" rows="4" placeholder="Espresso with steamed milk and caramel syrup.">{{ $product->description ?? '' }}</textarea>
                </label>
                <label class="form-field form-field--full">
                    <span>Image</span>
                    @if (!empty($product->image))
                        <div class="current-image-preview" style="margin-bottom:12px; display:flex; align-items:center; gap:10px;">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}" width="80" style="border-radius:8px; border:1px solid rgba(0,0,0,0.08);">
                            <span style="color: var(--text-secondary); font-size:13px;">Current image</span>
                        </div>
                    @endif
                    <label class="upload-field">    
                        <input type="file" name="image" accept="image/*">
                        <svg class="upload-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7">
                            <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" />
                            <polyline points="17 8 12 3 7 8" />
                            <line x1="12" y1="3" x2="12" y2="15" />
                        </svg>
                        <span class="upload-title">Choose product image</span>
                        <span class="upload-hint">PNG, JPG, or WEBP</span>
                    </label>
                </label>
            </div>

            <div class="modal-actions">
                <a href="{{ route('product_page') }}" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
@endsection
