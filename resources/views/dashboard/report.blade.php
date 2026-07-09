@extends('layout.app')

@section('title', 'Receipt Reports')

@section('page-header', 'true')
@section('page-title', 'Receipt Reports')
@section('page-subtitle', 'Static receipt summary with product amount, tax, total, and grand total.')
@section('page-actions')
    <button type="button" class="btn btn-outline">
        <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
            <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" />
            <polyline points="7 10 12 15 17 10" />
            <line x1="12" y1="15" x2="12" y2="3" />
        </svg>
        Export
    </button>
@endsection

@section('content')
    <div class="product-toolbar card">
        <form action="#" method="GET" class="search-form">
            <div class="search-field">
                <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                    <circle cx="11" cy="11" r="7" />
                    <line x1="16.5" y1="16.5" x2="21" y2="21" />
                </svg>
                <input name="search" type="search" placeholder="Search receipt ID, customer, or product">
            </div>
            <div class="toolbar-filters">
                <select class="filter-control" aria-label="Receipt status">
                    <option>All Receipts</option>
                    <option>Paid</option>
                    <option>Refunded</option>
                    <option>Pending</option>
                </select>
                <button type="submit" class="btn btn-outline">
                    <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                        <circle cx="11" cy="11" r="7" />
                        <line x1="16.5" y1="16.5" x2="21" y2="21" />
                    </svg>
                    Search
                </button>
            </div>
        </form>
    </div>

    <div class="stats-grid report-stats">
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
                <span class="stat-label">Receipts</span>
              
                      <span class="stat-value">{{ $receipts->count() }}</span>
             
                <span class="stat-delta stat-delta--up">Today sample</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon--blue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" />
                    <line x1="3" y1="6" x2="21" y2="6" />
                    <path d="M16 10a4 4 0 01-8 0" />
                </svg>
            </div>
            <div class="stat-body">
                <span class="stat-label">Product Amount</span>
                <span class="stat-value">${{ number_format($reports->sum('product_amount'), 2) }}</span>
                <span class="stat-delta stat-delta--up">Before tax</span>
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
                <span class="stat-label">Tax Amount</span>
                <span class="stat-value">${{ number_format($reports->sum('tax_amount'), 2) }}</span>
                <span class="stat-delta stat-delta--up">10% tax sample</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon--red">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M12 2a10 10 0 1010 10A10 10 0 0012 2z" />
                    <path d="M12 6v6l4 2" />
                </svg>
            </div>
            <div class="stat-body">
                <span class="stat-label">Grand Total</span>
                <span class="stat-value">${{ number_format($reports->sum('grand_total_amount'), 2) }}</span>
                <span class="stat-delta stat-delta--up">Final amount</span>
            </div>
        </div>
    </div>  

    <div class="report-grid receipt-report-grid">
        <div class="card report-table-card">
            <div class="card-header">
                <h2 class="card-title">Receipt Table</h2>
                <span class="table-meta">{{ $receipts->count() }} receipts</span>
            </div>
            <div class="table-responsive">
                <table class="table report-table receipt-table">
                    <thead>
                        <tr>
                            <th>Receipt</th>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Product Amount</th>
                            <th>Tax</th>
                            <th>Total</th>
                            <th>Grand Total</th>
                            <th>Created At</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($receipts as $receipt)
                            <tr>
                                <td class="order-id">{{ $receipt->receipt_no }}</td>
                                <td>{{ $receipt->customer_name }}</td>
                                <td>
                                    @foreach ($receipt->products as $product)
                                        <div>{{ $product->product_name }} x{{ $product->quantity }}</div>
                                    @endforeach
                                </td>            
                                <td>{{ $receipt->quantity }}</td>
                                <td>${{ number_format($receipt->product_amount, 2) }}</td>
                                <td>${{ number_format($receipt->tax_amount, 2) }}</td>
                                <td>${{ number_format($receipt->total_amount, 2) }}</td>
                                <td class="receipt-grand-total">${{ number_format($receipt->grand_total_amount, 2) }}</td>
                                <td>{{ $receipt->created_at ? $receipt->created_at->format('Y-m-d') : 'No date' }}</td>
                                <td><span class="badge badge--success">{{ $receipt->status }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10">No reports found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @php
            $previewReceipt = $receipts->first();
        @endphp
        <div class="card receipt-card">
            <div class="card-header">
                <h2 class="card-title">Receipt Preview</h2>
                <span class="table-meta">{{ $previewReceipt ? '#' . $previewReceipt->receipt_no : 'No receipt' }}</span>
            </div>
            <div class="receipt-preview">
                <div class="receipt-preview-header">
                    <strong>Coffee System</strong>
                    <span>Main Coffee Bar</span>
                    <span>{{ $previewReceipt ? 'Receipt #' . $previewReceipt->receipt_no : 'No receipt yet' }}</span>
                </div>

                <div class="receipt-preview-lines">
                    @if ($previewReceipt)
                        @foreach ($previewReceipt->products as $product)
                            <div>
                                <span>{{ $product->product_name }} x{{ $product->quantity }}</span>
                                <b>${{ number_format($product->product_amount, 2) }}</b>
                            </div>
                        @endforeach
                        <div>
                            <span>Tax</span>
                            <b>${{ number_format($previewReceipt->tax_amount, 2) }}</b>
                        </div>
                        <div>
                            <span>Total</span>
                            <b>${{ number_format($previewReceipt->total_amount, 2) }}</b>
                        </div>
                        <div class="receipt-preview-grand">
                            <span>Grand Total</span>
                            <b>${{ number_format($previewReceipt->grand_total_amount, 2) }}</b>
                        </div>
                    @else
                        <div>
                            <span>No products</span>
                            <b>$0.00</b>
                        </div>
                    @endif
                </div>

                <div class="receipt-preview-footer">
                    <span>Paid by {{ $previewReceipt->payment_method ?? 'Cash' }}</span>
                    <span>Thank you for your order 💕</span>
                    <span>{{ $previewReceipt && $previewReceipt->created_at ? $previewReceipt->created_at->format('Y-m-d') : 'No date' }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
