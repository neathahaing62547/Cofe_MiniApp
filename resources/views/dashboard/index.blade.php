@extends('layout.app')

@section('title', 'Dashboard — Coffee System')

@section('page-header')
@endsection
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Live overview of products, orders, customers, reports and revenue.')

@section('content')

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon stat-icon--amber">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M12 2a10 10 0 1010 10A10 10 0 0012 2z" />
                    <path d="M12 6v6l4 2" />
                </svg>
            </div>
            <div class="stat-body">
                <span class="stat-label">Orders</span>
                <span class="stat-value">{{ $orderCount }}</span>
                <span class="stat-delta stat-delta--up">Tracked from cart activity</span>
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
                <span class="stat-value">${{ number_format($revenue, 2) }}</span>
                <span class="stat-delta stat-delta--up">Based on saved orders</span>
            </div>
        </div>
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
                <span class="stat-value">{{ $totalCustomers }}</span>
                <span class="stat-delta stat-delta--up">Registered customers</span>
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
                <span class="stat-label">Products</span>
                <span class="stat-value">{{ $totalProducts }}</span>
                <span class="stat-delta stat-delta--down">Catalog inventory</span>
            </div>
        </div>
    </div>
        <div class="dashboard-right">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Revenue Snapshot</h2>
                </div>
                <div class="metric-list">
                    @foreach ($productSales as $sale)
                        <div class="metric-item">
                            <span>{{ $sale->product_name }}</span>
                            <strong>${{ number_format($sale->total_revenue, 2) }}</strong>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Operational Summary</h2>
                </div>
                <div class="metric-list">
                    <div class="metric-item">
                        <span>Reports</span>
                        <strong>{{ $totalReports }}</strong>
                    </div>
                    <div class="metric-item">
                        <span>Low Stock Items</span>
                        <strong>{{ $lowStockProducts->count() }}</strong>
                    </div>
                    <div class="metric-item">
                        <span>Recent Orders</span>
                        <strong>{{ $recentOrders->count() }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
