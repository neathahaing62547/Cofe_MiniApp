@extends('layout.app')

@section('title', 'Categories')

@section('page-header', 'true')
@section('page-title', 'Categories')
@section('page-subtitle', 'Manage category listings and examples')
@section('page-actions')
    <button type="button" class="btn btn-primary" id="openCategoryModal">
        <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <line x1="12" y1="5" x2="12" y2="19" />
            <line x1="5" y1="12" x2="19" y2="12" />
        </svg>
        Add Category
    </button>
@endsection

@section('content')
    <div class="product-toolbar card">
        <form action="{{ route('search_category') }}" method="GET" class="search-form d-flex align-items-center">
            <div class="search-field">
                <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                    <circle cx="11" cy="11" r="7" />
                    <line x1="16.5" y1="16.5" x2="21" y2="21" />
                </svg>
                <input name="search" type="search" placeholder="Search category name" aria-label="Search categories"
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
            <h2 class="card-title">Category List</h2>
            <span class="table-meta">{{ $categories->count() }} categories</span>
        </div>

        <div class="table-responsive">
            <table class="table product-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category ID</th>
                        <th>Category</th>
                        <th>Created At</th>
                        <th class="table-actions-head">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        @php
                            $initials = collect(explode(' ', $category->category_name))
                                ->map(fn($word) => substr($word, 0, 1))
                                ->take(2)
                                ->implode('');
                        @endphp
                        <tr>
                            <td class="order-id">#{{ $category->id }}</td>
                            <td>{{ $category->category_id }}</td>
                            <td>
                                <div class="product-cell">
                                    <div class="product-thumb">{{ strtoupper($initials) }}</div>
                                    <div>
                                        <span class="product-title">{{ $category->category_name }}</span>
                                    </div>
                                </div>
                            </td>
    <td>{{ $category->created_at ? $category->created_at->format('Y-m-d') : 'No Date information' }}</td>
    <td>
        <div class="table-actions">
            <form action="{{ route('delete_category', $category->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="product-action-btn product-action-btn--delete">Delete</button>
            </form>
        </div>
    </td>
    </tr>
@empty
    <tr>
        <td colspan="5">
            <div class="product-empty-state">
                <img src="{{ asset('storage/default/download.png') }}" alt="No categories">
                <p>No categories found</p>
            </div>
        </td>
    </tr>
    @endforelse
    </tbody>
    </table>
    </div>
    </div>

    <div class="modal-backdrop" id="categoryModal" aria-hidden="true">
        <div class="modal-panel" role="dialog" aria-modal="true" aria-labelledby="categoryModalTitle">
            <div class="modal-header">
                <div>
                    <h2 class="modal-title" id="categoryModalTitle">Add Category</h2>
                    <p class="modal-subtitle" id="categoryModalSubtitle">Create New category</p>
                </div>
                <button type="button" class="icon-btn" id="closeCategoryModal" aria-label="Close add category modal">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('add_category') }}" class="modal-form" id="categoryForm" method="POST">
                @csrf
                <div class="form-grid">
                    <label class="form-field">
                        <span>Category ID</span>
                        <input type="number" name="category_id" placeholder="1, 2, 3, etc.">
                    </label>
                    <label class="form-field">
                        <span>Category Name</span>
                        <input type="text" name="category_name" placeholder="Coffee, Tea, Bakery, etc.">
                    </label>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn btn-outline" id="cancelCategoryModal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Category</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const categoryModal = document.getElementById('categoryModal');
        const openCategoryModal = document.getElementById('openCategoryModal');
        const closeCategoryModal = document.getElementById('closeCategoryModal');
        const cancelCategoryModal = document.getElementById('cancelCategoryModal');
        const categoryForm = document.getElementById('categoryForm');

        function showCategoryModal() {
            categoryModal.classList.add('is-open');
            categoryModal.setAttribute('aria-hidden', 'false');
        }

        function hideCategoryModal() {
            categoryModal.classList.remove('is-open');
            categoryModal.setAttribute('aria-hidden', 'true');
        }

        openCategoryModal.addEventListener('click', function() {
            categoryForm.reset();
            showCategoryModal();
        });

        closeCategoryModal.addEventListener('click', hideCategoryModal);
        cancelCategoryModal.addEventListener('click', hideCategoryModal);

        categoryModal.addEventListener('click', function(event) {
            if (event.target === categoryModal) {
                hideCategoryModal();
            }
        });

        // Allow normal form submission so server-side `add_category` handles creation
    </script>
@endpush
