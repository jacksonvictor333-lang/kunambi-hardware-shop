@extends('layouts.app')

@section('title', 'Stock Movement History')

@section('content')

<style>
    :root {
        --primary-green:    #16A34A;
        --dark-green:       #15803D;
        --light-green:      #DCFCE7;
        --very-light-green: #F0FDF4;
        --border:           #BBF7D0;
        --text:             #0F172A;
        --muted:            #64748B;
        --danger:           #DC2626;
        --warning:          #D97706;
    }

    .page-header {
        display: flex; align-items: center;
        justify-content: space-between;
        flex-wrap: wrap; gap: 16px; margin-bottom: 24px;
    }

    .page-title   { font-size: 22px; font-weight: 700; color: var(--text); margin: 0; }
    .page-subtitle{ font-size: 13px; color: var(--muted); margin-top: 3px; }

    .btn-back {
        display: inline-flex; align-items: center; gap: 8px;
        background: #fff; color: var(--muted);
        border: 1.5px solid var(--border); border-radius: 10px;
        padding: 9px 16px; font-size: 13px; font-weight: 600;
        text-decoration: none; transition: all 0.2s;
    }

    .btn-back:hover {
        border-color: var(--primary-green);
        color: var(--dark-green);
        background: var(--very-light-green);
    }

    /* ALERTS */
    .alert-success-custom {
        display: flex; align-items: center; gap: 10px;
        padding: 14px 18px; background: var(--light-green);
        border: 1px solid #86EFAC; border-radius: 10px;
        font-size: 13px; color: #166534; font-weight: 500; margin-bottom: 20px;
    }

    /* FILTER CARD */
    .filter-card {
        background: #fff; border: 1px solid var(--border);
        border-radius: 14px; padding: 20px;
        margin-bottom: 20px;
    }

    .filter-title {
        font-size: 13px; font-weight: 700;
        color: var(--dark-green); margin-bottom: 16px;
        display: flex; align-items: center; gap: 6px;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr auto;
        gap: 12px;
        align-items: end;
    }

    .form-label-custom {
        font-size: 12px; font-weight: 600;
        color: #166534; margin-bottom: 6px; display: block;
    }

    .form-control-custom {
        width: 100%; height: 42px;
        padding: 0 14px;
        border: 1.5px solid var(--border);
        border-radius: 10px; font-size: 13px;
        color: var(--text); background: var(--very-light-green);
        outline: none; transition: all 0.2s;
        font-family: inherit;
    }

    .form-control-custom:focus {
        border-color: var(--primary-green); background: #fff;
        box-shadow: 0 0 0 3px rgba(22,163,74,0.10);
    }

    select.form-control-custom {
        appearance: none; cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2316A34A' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 12px center;
        padding-right: 36px;
    }

    .filter-btns { display: flex; gap: 8px; }

    .btn-filter {
        height: 42px; padding: 0 18px;
        background: var(--primary-green); color: #fff;
        border: none; border-radius: 10px; font-size: 13px;
        font-weight: 600; cursor: pointer;
        display: inline-flex; align-items: center; gap: 6px;
        transition: all 0.2s; font-family: inherit;
        white-space: nowrap;
    }

    .btn-filter:hover { background: var(--dark-green); }

    .btn-reset {
        height: 42px; padding: 0 14px;
        background: #fff; color: var(--muted);
        border: 1.5px solid var(--border); border-radius: 10px;
        font-size: 13px; font-weight: 600;
        display: inline-flex; align-items: center; gap: 6px;
        text-decoration: none; transition: all 0.2s;
        white-space: nowrap;
    }

    .btn-reset:hover { border-color: var(--primary-green); color: var(--primary-green); }

    /* TABLE CARD */
    .table-card {
        background: #fff; border: 1px solid var(--border);
        border-radius: 16px; overflow: hidden;
        box-shadow: 0 2px 12px rgba(22,163,74,0.06);
    }

    .table-card-header {
        padding: 16px 20px; border-bottom: 1px solid var(--border);
        background: var(--very-light-green);
        display: flex; align-items: center; justify-content: space-between;
    }

    .table-card-title { font-size: 14px; font-weight: 700; color: var(--dark-green); }
    .results-count    { font-size: 12px; color: var(--muted); }

    /* TABLE */
    .movements-table { width: 100%; border-collapse: collapse; }

    .movements-table th {
        padding: 12px 16px; font-size: 11px; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.05em;
        color: var(--dark-green); background: var(--very-light-green);
        border-bottom: 2px solid var(--border); white-space: nowrap;
    }

    .movements-table td {
        padding: 13px 16px; font-size: 13px; color: var(--text);
        border-bottom: 1px solid #F0FDF4; vertical-align: middle;
    }

    .movements-table tbody tr:last-child td { border-bottom: none; }
    .movements-table tbody tr:hover td { background: var(--very-light-green); }

    /* DATE CELL */
    .date-main { font-size: 13px; font-weight: 600; color: var(--text); }
    .date-time  { font-size: 11px; color: var(--muted); margin-top: 2px; }

    /* PRODUCT CELL */
    .product-name { font-weight: 600; color: var(--text); }
    .product-sku  { font-size: 11px; color: var(--muted); margin-top: 2px; font-family: monospace; }

    /* TYPE BADGES */
    .badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 10px; border-radius: 99px;
        font-size: 11px; font-weight: 700;
    }

    .badge-in         { background: #DCFCE7; color: #166534; border: 1px solid #86EFAC; }
    .badge-out        { background: #FEE2E2; color: #991B1B; border: 1px solid #FECACA; }
    .badge-adjustment { background: #FEF3C7; color: #92400E; border: 1px solid #FDE68A; }

    /* CHANGE CELL */
    .change-positive { font-weight: 700; color: #16A34A; }
    .change-negative { font-weight: 700; color: #DC2626; }
    .change-zero     { font-weight: 700; color: var(--muted); }

    /* QUANTITY CELLS */
    .qty-before { font-size: 13px; color: var(--muted); font-weight: 500; }
    .qty-after  { font-size: 13px; color: var(--text);  font-weight: 700; }

    /* USER CELL */
    .user-cell {
        display: flex; align-items: center; gap: 8px;
    }

    .user-avatar {
        width: 28px; height: 28px; border-radius: 50%;
        background: var(--light-green); color: var(--dark-green);
        display: flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 700; flex-shrink: 0;
    }

    .user-name { font-size: 13px; color: var(--text); }

    /* REASON CELL */
    .reason-text { font-size: 12px; color: var(--muted); }
    .ref-text    { font-size: 11px; color: #94A3B8; margin-top: 3px; }

    /* EMPTY STATE */
    .empty-state { padding: 60px 20px; text-align: center; color: var(--muted); }
    .empty-state i { font-size: 48px; color: var(--border); display: block; margin-bottom: 16px; }
    .empty-state h5 { font-size: 16px; font-weight: 600; color: var(--text); margin-bottom: 8px; }
    .empty-state p  { font-size: 13px; }

    /* PAGINATION */
    .pagination-wrapper {
        padding: 16px 20px; border-top: 1px solid var(--border);
        background: var(--very-light-green);
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 12px;
    }

    .pagination-info { font-size: 12px; color: var(--muted); }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .filter-grid { grid-template-columns: 1fr; }
        .filter-btns { flex-direction: row; }
    }
</style>


{{-- ALERTS --}}
@if(session('success'))
    <div class="alert-success-custom">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('success') }}
    </div>
@endif


{{-- PAGE HEADER --}}
<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="bi bi-clock-history me-2 text-success"></i>
            Stock Movement History
        </h1>
        <div class="page-subtitle">Track every stock transaction in your inventory</div>
    </div>
    <a href="{{ route('inventory.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i>
        Back to Inventory
    </a>
</div>


{{-- FILTERS --}}
<div class="filter-card">
    <div class="filter-title">
        <i class="bi bi-funnel"></i>
        Filter Movements
    </div>

    <form method="GET" action="{{ route('inventory.movements') }}">
        <div class="filter-grid">

            {{-- Search --}}
            <div>
                <label class="form-label-custom">Search</label>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control-custom"
                    placeholder="Product name or SKU..."
                >
            </div>

            {{-- Type --}}
            <div>
                <label class="form-label-custom">Movement Type</label>
                <select name="type" class="form-control-custom">
                    <option value="">All Movements</option>
                    <option value="stock_in"    {{ request('type') === 'stock_in'    ? 'selected' : '' }}>📥 Stock In</option>
                    <option value="stock_out"   {{ request('type') === 'stock_out'   ? 'selected' : '' }}>📤 Stock Out</option>
                    <option value="adjustment"  {{ request('type') === 'adjustment'  ? 'selected' : '' }}>⚖️ Adjustment</option>
                </select>
            </div>

            {{-- Date --}}
            <div>
                <label class="form-label-custom">Date</label>
                <input
                    type="date"
                    name="date"
                    value="{{ request('date') }}"
                    class="form-control-custom"
                >
            </div>

            {{-- Buttons --}}
            <div class="filter-btns">
                <button type="submit" class="btn-filter">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('inventory.movements') }}" class="btn-reset">
                    <i class="bi bi-x-circle"></i> Reset
                </a>
            </div>

        </div>
    </form>
</div>


{{-- TABLE --}}
<div class="table-card">

    <div class="table-card-header">
        <div class="table-card-title">
            <i class="bi bi-list-ul me-1"></i>
            Movement Records
        </div>
        <div class="results-count">
            {{ $movements->total() }} records found
        </div>
    </div>

    <div class="table-responsive">
        <table class="movements-table">
            <thead>
                <tr>
                    <th>Date & Time</th>
                    <th>Product</th>
                    <th class="text-center">Type</th>
                    <th class="text-end">Before</th>
                    <th class="text-end">Change</th>
                    <th class="text-end">After</th>
                    <th>User</th>
                    <th>Reason / Reference</th>
                </tr>
            </thead>
            <tbody>
                @forelse($movements as $movement)
                    <tr>

                        {{-- DATE --}}
                        <td>
                            <div class="date-main">
                                {{ $movement->created_at->format('d M Y') }}
                            </div>
                            <div class="date-time">
                                {{ $movement->created_at->format('H:i') }}
                            </div>
                        </td>

                        {{-- PRODUCT --}}
                        <td>
                            <div class="product-name">
                                {{ $movement->product?->name ?? 'Deleted Product' }}
                            </div>
                            @if($movement->product)
                                <div class="product-sku">{{ $movement->product->sku }}</div>
                            @endif
                        </td>

                        {{-- TYPE --}}
                        <td class="text-center">
                            @if($movement->type === 'stock_in')
                                <span class="badge badge-in">
                                    <i class="bi bi-arrow-down-circle-fill"></i> Stock In
                                </span>
                            @elseif($movement->type === 'stock_out')
                                <span class="badge badge-out">
                                    <i class="bi bi-arrow-up-circle-fill"></i> Stock Out
                                </span>
                            @else
                                <span class="badge badge-adjustment">
                                    <i class="bi bi-sliders"></i> Adjustment
                                </span>
                            @endif
                        </td>

                        {{-- BEFORE --}}
                        <td class="text-end">
                            <span class="qty-before">
                                {{ number_format($movement->quantity_before) }}
                            </span>
                        </td>

                        {{-- CHANGE --}}
                        <td class="text-end">
                            @if($movement->quantity > 0)
                                <span class="change-positive">
                                    +{{ number_format($movement->quantity) }}
                                </span>
                            @elseif($movement->quantity < 0)
                                <span class="change-negative">
                                    {{ number_format($movement->quantity) }}
                                </span>
                            @else
                                <span class="change-zero">0</span>
                            @endif
                        </td>

                        {{-- AFTER --}}
                        <td class="text-end">
                            <span class="qty-after">
                                {{ number_format($movement->quantity_after) }}
                            </span>
                        </td>

                        {{-- USER --}}
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar">
                                    {{ strtoupper(substr($movement->user?->name ?? 'SY', 0, 2)) }}
                                </div>
                                <span class="user-name">
                                    {{ $movement->user?->name ?? 'System' }}
                                </span>
                            </div>
                        </td>

                        {{-- REASON --}}
                        <td>
                            @if($movement->reason)
                                <div class="reason-text">{{ $movement->reason }}</div>
                            @else
                                <span style="color:#94A3B8;">—</span>
                            @endif
                            @if($movement->reference)
                                <div class="ref-text">
                                    <i class="bi bi-hash"></i> {{ $movement->reference }}
                                </div>
                            @endif
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="bi bi-clock-history"></i>
                                <h5>No stock movements found</h5>
                                <p>Stock transactions will appear here once recorded.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    @if($movements->hasPages())
        <div class="pagination-wrapper">
            <div class="pagination-info">
                Showing <strong>{{ $movements->firstItem() }}</strong>
                to <strong>{{ $movements->lastItem() }}</strong>
                of <strong>{{ $movements->total() }}</strong> records
            </div>
            {{ $movements->links() }}
        </div>
    @endif

</div>

@endsection