@extends('layout.app')

@section('title', 'Customers')

@section('page-header', 'true')
@section('page-title', 'Customers')
@section('page-subtitle', 'Manage customer records')

@section('content')
    <div class="stats-grid report-stats">
        <div class="stat-card">
            <div class="stat-icon stat-icon--blue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 00-3-3.87" />
                    <path d="M16 3.13a4 4 0 010 7.75" />
                </svg>
            </div>
            <div class="stat-body">
                <span class="stat-label">Customers</span>
                <span class="stat-value">{{ $customers->count() }}</span>
                <span class="stat-delta stat-delta--up">Unique buyers</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon--amber">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                    <line x1="16" y1="13" x2="8" y2="13" />
                    <line x1="16" y1="17" x2="8" y2="17" />
                </svg>
            </div>
            <div class="stat-body">
                <span class="stat-label">Orders</span>
                <span class="stat-value">{{ $customers->sum('total_orders') }}</span>
                <span class="stat-delta stat-delta--up">Total orders</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon--green">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <line x1="12" y1="1" x2="12" y2="23" />
                    <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6" />
                </svg>
            </div>
            <div class="stat-body">
                <span class="stat-label">Revenue</span>
                <span class="stat-value">${{ number_format($customers->sum('total_spent'), 2) }}</span>
                <span class="stat-delta stat-delta--up">Customer total</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon--red">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" />
                    <line x1="3" y1="6" x2="21" y2="6" />
                    <path d="M16 10a4 4 0 01-8 0" />
                </svg>
            </div>
            <div class="stat-body">
                <span class="stat-label">Latest ID</span>
                <span class="stat-value">#{{ $customers->max('customer_id') ?? 0 }}</span>
                <span class="stat-delta stat-delta--up">Newest customer</span>
            </div>
        </div>
    </div>

    <div class="card product-table-card">
        <div class="card-header">
            <h2 class="card-title">Customer List</h2>
            <span class="table-meta">{{ $customers->count() }} customers</span>
        </div>

        <div class="table-responsive">
            <table class="table product-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Orders</th>
                        <th>Total Spent</th>
                        <th>Last Order</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customers as $customer)
                        @php
                            $initials = collect(explode(' ', $customer->customer_name))
                                ->map(fn ($word) => substr($word, 0, 1))
                                ->take(2)
                                ->implode('');
                        @endphp
                        <tr>
                            <td>
                                <div class="product-cell">
                                    <div class="product-thumb product-thumb--blue">{{ strtoupper($initials) }}</div>
                                    <div>
                                        <span class="product-title">{{ $customer->customer_name }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $customer->phone ?? 'NONE' }}</td>
                            <td>{{ $customer->email ?? 'NONE' }}</td>
                            <td class="table-description">{{ $customer->address ?? 'NONE' }}</td>
                            <td>{{ $customer->total_orders }}</td>
                            <td class="receipt-grand-total">${{ number_format($customer->total_spent, 2) }}</td>
                            <td>{{ $customer->last_order_at ? $customer->last_order_at->format('Y-m-d') : '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="product-empty-state">
                                    <img src="{{ asset('storage/default/download.png') }}" alt="No customers">
                                    <p>No customers found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
