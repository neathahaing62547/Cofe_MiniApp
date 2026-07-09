@extends('layout.app')

@section('title', 'Products')

@section('page-header', 'true')
@section('page-title', 'Products')
@section('page-subtitle', 'Manage coffee products')
@section('page-actions')
    <button type="button" class="btn btn-primary" id="openProductModal">
        <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <line x1="12" y1="5" x2="12" y2="19" />
            <line x1="5" y1="12" x2="19" y2="12" />
        </svg>
        Add Product
    </button>
@endsection

@section('content')
    <div class="product-toolbar  card">
        <form action="{{ route('search_product') }}" method="GET" class="search-form d-flex align-items-center">
            <div class="search-field">
                <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                    <circle cx="11" cy="11" r="7" />
                    <line x1="16.5" y1="16.5" x2="21" y2="21" />
                </svg>
                <input name="search" type="search" placeholder="Search product name or category ID"
                    value="{{ request('search') }}">
            </div>
            <div class="toolbar-filters">
                <button type="submit" class="btn btn-outline">
                    <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                        <line x1="4" y1="21" x2="4" y2="14" />
                        <line x1="4" y1="10" x2="4" y2="3" />
                        <line x1="12" y1="21" x2="12" y2="12" />
                        <line x1="12" y1="8" x2="12" y2="3" />
                        <line x1="20" y1="21" x2="20" y2="16" />
                        <line x1="20" y1="12" x2="20" y2="3" />
                        <line x1="1" y1="14" x2="7" y2="14" />
                        <line x1="9" y1="8" x2="15" y2="8" />
                        <line x1="17" y1="16" x2="23" y2="16" />
                    </svg>
                    Search
                </button>
            </div>
        </form>
    </div>

    <div class="card product-table-card">
        <div class="card-header">
            <h2 class="card-title">Product List</h2>
            <span class="table-meta">{{ $products->count() }} products</span>
        </div>

        <div class="table-responsive">
            <table class="table product-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>Category ID</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Created At</th>
                        <th class="table-actions-head">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        @php
                            $initials = collect(explode(' ', $product->product_name))
                                ->map(fn($word) => substr($word, 0, 1))
                                ->take(2)
                                ->implode('');
                        @endphp
                        <tr>
                            <td class="order-id">#{{ $product->product_id }}</td>
                            <td>
                                <div class="product-cell">
                                    @if ($product->image)
                                        <div class="product-thumb">
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                alt="{{ $product->product_name }}"
                                                style="width:100%; height:100%; object-fit:cover; border-radius:inherit;" />
                                        </div>
                                    @else
                                        <div class="product-thumb">{{ strtoupper($initials) }}</div>
                                    @endif
                                    <div>
                                        <span class="product-title">{{ $product->product_name }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $product->category_id }}</td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->stock_quantity }}</td>
                            <td class="table-description">{{ $product->description ?? '-' }}</td>
                            <td>
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                        alt="{{ $product->product_name }}" width="48">
                                @endif
                            </td>
                            <td>{{ $product->created_at->format('Y-m-d') }}</td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('edit_product', $product->product_id) }}" type="button"
                                        class="product-action-btn product-action-btn--edit">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.7">
                                            <path d="M12 20h9" />
                                            <path d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4z" />
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('delete_product', $product->product_id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="product-action-btn product-action-btn--delete">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.7">
                                                <polyline points="3 6 5 6 21 6" />
                                                <path d="M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2" />
                                                <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" />
                                                <line x1="10" y1="11" x2="10" y2="17" />
                                                <line x1="14" y1="11" x2="14" y2="17" />
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="product-empty-state">
                                    <img src="{{ asset('storage/default/download.png') }}" alt="No products">
                                    <p>No products found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Container tailored exclusively for standard addition tasks -->
    <div class="modal-backdrop" id="productModal" aria-hidden="true">
        <div class="modal-panel" role="dialog" aria-modal="true" aria-labelledby="productModalTitle">
            <div class="modal-header">
                <div>
                    <h2 class="modal-title" id="productModalTitle">Add Product</h2>
                    <p class="modal-subtitle" id="productModalSubtitle">Create a new product item</p>
                </div>
                <button type="button" class="icon-btn" id="closeProductModal" aria-label="Close add product modal">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('save_product') }}" method="POST" enctype="multipart/form-data" class="modal-form"
                id="productForm">
                @csrf
                <div class="form-grid">
                    <label class="form-field">
                        <span>Product Name</span>
                        <input type="text" name="product_name" placeholder="Caramel Latte">
                    </label>
                    <label class="form-field">
                        <span>Category ID</span>
                        <input type="number" name="category_id" placeholder="2">
                    </label>
                    <label class="form-field">
                        <span>Price</span>
                        <input type="number" name="price" step="0.01" placeholder="5.50">
                    </label>
                    <label class="form-field">
                        <span>Stock Quantity</span>
                            <select name="stock_quantity" class="form-select">
                                <option value="In Stock">In Stock</option>
                                <option value="Out of Stock">Out of Stock</option>
                            </select>

                    </label>
                    <label class="form-field form-field--full">
                        <span>Description</span>
                        <textarea name="description" rows="4" placeholder="Espresso with steamed milk and caramel syrup."></textarea>
                    </label>
                    <label class="form-field form-field--full">
                        <span>Image</span>
                        <label class="upload-field">
                            <input type="file" name="image" accept="image/*">
                            <svg class="upload-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.7">
                                <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" />
                                <polyline points="17 8 12 3 7 8" />
                                <line x1="12" y1="3" x2="12" y2="15" />
                            </svg>
                            <span class="upload-title" id="uploadTitle">Choose product image</span>
                            <span class="upload-hint">PNG, JPG, or WEBP</span>
                        </label>
                    </label>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn btn-outline" id="cancelProductModal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="productSubmitButton">Save Product</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const productModal = document.getElementById('productModal');
        const openProductModal = document.getElementById('openProductModal');
        const closeProductModal = document.getElementById('closeProductModal');
        const cancelProductModal = document.getElementById('cancelProductModal');
        const productForm = document.getElementById('productForm');

        function showProductModal() {
            productModal.classList.add('is-open');
            productModal.setAttribute('aria-hidden', 'false');
        }

        function hideProductModal() {
            productModal.classList.remove('is-open');
            productModal.setAttribute('aria-hidden', 'true');
        }

        openProductModal.addEventListener('click', function() {
            productForm.reset();
            showProductModal();
        });

        closeProductModal.addEventListener('click', hideProductModal);
        cancelProductModal.addEventListener('click', hideProductModal);

        productModal.addEventListener('click', function(event) {
            if (event.target === productModal) {
                hideProductModal();
            }
        });
    </script>
@endpush
