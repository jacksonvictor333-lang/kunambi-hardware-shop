
@extends('layouts.app')

@section('title', 'Sale Receipt')

@section('content')

@php
    // "Change" haihifadhiwi kwenye database, kwa hiyo inahesabiwa hapa hapa.
    $changeAmount = max(0, (float) $sale->paid_amount - (float) $sale->total);
@endphp

<div class="receipt-page">

    {{-- Top Actions --}}
    <div class="receipt-actions no-print">

        <a href="{{ route('sales.history') }}" class="back-btn">
            ← Back to Sales
        </a>

        <div class="action-buttons">

            <button
                type="button"
                onclick="window.print()"
                class="print-btn"
            >
                <svg width="18" height="18" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M6 9V2h12v7"/>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                    <path d="M6 14h12v8H6z"/>
                </svg>

                Print Receipt
            </button>

            <button
                type="button"
                onclick="window.print()"
                class="print-icon-btn"
                title="Print"
            >
                🖨
            </button>

        </div>

    </div>


    {{-- Receipt --}}
    <div class="receipt-wrapper">

        <div class="receipt-card">

            {{-- Header --}}
            <div class="receipt-header">

                <div class="store-logo">
                    <span>HS</span>
                </div>

                <h1>HARDWARE SHOP</h1>

                <p class="store-tagline">
                    Hardware & Building Materials
                </p>

                <div class="store-details">
                    <span>Dar es Salaam, Tanzania</span>
                    <span>Phone: +255 XXX XXX XXX</span>
                </div>

            </div>


            {{-- Receipt Title --}}
            <div class="receipt-title">
                <span>SALES RECEIPT</span>
            </div>


            {{-- Sale Information --}}
            <div class="sale-info">

                <div>
                    <span>Receipt No.</span>
                    <strong>
                        {{ $sale->invoice_number ?? 'SALE-' . str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}
                    </strong>
                </div>

                <div>
                    <span>Date</span>
                    <strong>
                        {{ $sale->created_at->format('d M Y') }}
                    </strong>
                </div>

                <div>
                    <span>Time</span>
                    <strong>
                        {{ $sale->created_at->format('h:i A') }}
                    </strong>
                </div>

                @if($sale->customer)
                    <div>
                        <span>Customer</span>
                        <strong>
                            {{ $sale->customer->name }}
                        </strong>
                    </div>
                @endif

                @if($sale->user)
                    <div>
                        <span>Cashier</span>
                        <strong>
                            {{ $sale->user->name }}
                        </strong>
                    </div>
                @endif

            </div>


            {{-- Items --}}
            <div class="items-section">

                <div class="items-header">
                    <span>ITEM</span>
                    <span>QTY</span>
                    <span>PRICE</span>
                    <span>TOTAL</span>
                </div>

                @foreach($sale->items as $item)

                    <div class="receipt-item">

                        <div class="item-name">
                            <strong>
                                {{ $item->product->name }}
                            </strong>

                            @if($item->product->sku)
                                <small>
                                    SKU: {{ $item->product->sku }}
                                </small>
                            @endif
                        </div>

                        <span>
                            {{ number_format($item->quantity, 0) }}
                        </span>

                        <span>
                            {{ number_format($item->unit_price, 0) }}
                        </span>

                        <strong>
                            {{ number_format($item->subtotal, 0) }}
                        </strong>

                    </div>

                @endforeach

            </div>


            {{-- Summary --}}
            <div class="receipt-summary">

                <div class="summary-line">
                    <span>Subtotal</span>

                    <strong>
                        TZS
                        {{ number_format($sale->subtotal, 0) }}
                    </strong>
                </div>

                @if($sale->discount > 0)

                    <div class="summary-line discount-line">
                        <span>Discount</span>

                        <strong>
                            - TZS
                            {{ number_format($sale->discount, 0) }}
                        </strong>
                    </div>

                @endif

                <div class="summary-divider"></div>

                <div class="grand-total">
                    <span>TOTAL</span>

                    <strong>
                        TZS
                        {{ number_format($sale->total, 0) }}
                    </strong>
                </div>

            </div>


            {{-- Payment --}}
            <div class="payment-summary">

                <div class="summary-line">
                    <span>Payment Method</span>

                    <strong>
                        {{ ucwords(str_replace('_', ' ', $sale->payment_method)) }}
                    </strong>
                </div>

                <div class="summary-line">
                    <span>Amount Paid</span>

                    <strong>
                        TZS
                        {{ number_format($sale->paid_amount, 0) }}
                    </strong>
                </div>

                @if($changeAmount > 0)

                    <div class="change-line">

                        <span>CHANGE</span>

                        <strong>
                            TZS
                            {{ number_format($changeAmount, 0) }}
                        </strong>

                    </div>

                @elseif($sale->balance > 0)

                    <div class="balance-line">

                        <span>BALANCE</span>

                        <strong>
                            TZS
                            {{ number_format($sale->balance, 0) }}
                        </strong>

                    </div>

                @endif

            </div>


            {{-- Thank You --}}
            <div class="receipt-footer">

                <div class="thank-you">
                    Thank you for your business!
                </div>

                <p>
                    Please keep this receipt for your records.
                </p>

                <div class="receipt-barcode">
                    {{ $sale->invoice_number ?? 'SALE-' . $sale->id }}
                </div>

            </div>

        </div>

    </div>

</div>


<style>

    .receipt-page {
        min-height: calc(100vh - 80px);
        padding: 24px;
        background: #f8fafc;
    }

    .receipt-actions {
        max-width: 850px;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #475569;
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
    }

    .back-btn:hover {
        color: #15803d;
    }

    .action-buttons {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .print-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 0;
        border-radius: 10px;
        padding: 11px 18px;
        background: #16a34a;
        color: white;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
    }

    .print-btn:hover {
        background: #15803d;
    }

    .print-icon-btn {
        display: none;
    }

    .receipt-wrapper {
        display: flex;
        justify-content: center;
    }

    .receipt-card {
        width: 100%;
        max-width: 620px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 34px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, .07);
    }

    .receipt-header {
        text-align: center;
    }

    .store-logo {
        width: 58px;
        height: 58px;
        margin: 0 auto 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        background: #16a34a;
        color: white;
        font-size: 20px;
        font-weight: 900;
    }

    .receipt-header h1 {
        margin: 0;
        color: #0f172a;
        font-size: 22px;
        font-weight: 900;
        letter-spacing: .5px;
    }

    .store-tagline {
        margin: 5px 0 12px;
        color: #64748b;
        font-size: 13px;
    }

    .store-details {
        display: flex;
        flex-direction: column;
        gap: 3px;
        color: #64748b;
        font-size: 12px;
    }

    .receipt-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 28px 0 20px;
        color: #15803d;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: 1.5px;
    }

    .receipt-title::before,
    .receipt-title::after {
        content: "";
        flex: 1;
        height: 1px;
        background: #bbf7d0;
    }

    .sale-info {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
        padding: 16px;
        background: #f8fafc;
        border-radius: 12px;
        margin-bottom: 22px;
    }

    .sale-info div {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .sale-info span {
        color: #94a3b8;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .sale-info strong {
        color: #0f172a;
        font-size: 13px;
    }

    .items-header,
    .receipt-item {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 55px 100px 100px;
        gap: 8px;
        align-items: center;
    }

    .items-header {
        padding-bottom: 10px;
        border-bottom: 1px solid #e2e8f0;
        color: #94a3b8;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .5px;
    }

    .items-header span:not(:first-child),
    .receipt-item > span,
    .receipt-item > strong {
        text-align: right;
    }

    .receipt-item {
        padding: 13px 0;
        border-bottom: 1px dashed #e2e8f0;
        color: #334155;
        font-size: 13px;
    }

    .item-name {
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .item-name strong {
        color: #0f172a;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .item-name small {
        color: #94a3b8;
        font-size: 10px;
    }

    .receipt-summary {
        margin-top: 20px;
    }

    .summary-line {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 10px;
        color: #64748b;
        font-size: 13px;
    }

    .summary-line strong {
        color: #0f172a;
    }

    .discount-line strong {
        color: #dc2626;
    }

    .summary-divider {
        height: 1px;
        margin: 14px 0;
        background: #e2e8f0;
    }

    .grand-total {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 16px;
        border-radius: 12px;
        background: #f0fdf4;
        color: #15803d;
        font-size: 15px;
        font-weight: 800;
    }

    .grand-total strong {
        font-size: 20px;
    }

    .payment-summary {
        margin-top: 18px;
        padding-top: 18px;
        border-top: 1px solid #e2e8f0;
    }

    .change-line {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 14px;
        padding: 13px 15px;
        border-radius: 10px;
        background: #dcfce7;
        color: #166534;
        font-size: 13px;
        font-weight: 800;
    }

    .change-line strong {
        font-size: 17px;
    }

    .balance-line {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 14px;
        padding: 13px 15px;
        border-radius: 10px;
        background: #fef3c7;
        color: #92400e;
        font-size: 13px;
        font-weight: 800;
    }

    .receipt-footer {
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px dashed #cbd5e1;
        text-align: center;
    }

    .thank-you {
        color: #15803d;
        font-size: 14px;
        font-weight: 800;
    }

    .receipt-footer p {
        margin: 5px 0 15px;
        color: #94a3b8;
        font-size: 11px;
    }

    .receipt-barcode {
        display: inline-block;
        padding: 7px 12px;
        border: 1px dashed #cbd5e1;
        border-radius: 6px;
        color: #64748b;
        font-family: monospace;
        font-size: 10px;
        letter-spacing: 1px;
    }

    @media (max-width: 640px) {

        .receipt-page {
            padding: 12px;
        }

        .receipt-card {
            padding: 22px 16px;
            border-radius: 12px;
        }

        .receipt-actions {
            align-items: flex-start;
        }

        .print-btn {
            padding: 10px 12px;
            font-size: 12px;
        }

        .items-header,
        .receipt-item {
            grid-template-columns: minmax(0, 1fr) 35px 75px 80px;
        }

        .sale-info {
            gap: 10px;
        }

        .receipt-header h1 {
            font-size: 19px;
        }
    }

    @media print {

        @page {
            size: 80mm auto;
            margin: 0;
        }

        html,
        body {
            margin: 0 !important;
            padding: 0 !important;
            background: white !important;
        }

        body * {
            visibility: hidden;
        }

        .receipt-card,
        .receipt-card * {
            visibility: visible;
        }

        .receipt-card {
            position: absolute;
            left: 0;
            top: 0;
            width: 80mm;
            max-width: 80mm;
            margin: 0;
            padding: 8mm 5mm;
            border: 0;
            border-radius: 0;
            box-shadow: none;
        }

        .receipt-page {
            padding: 0;
            background: white;
        }

        .no-print {
            display: none !important;
        }

        .store-logo {
            width: 45px;
            height: 45px;
            margin-bottom: 8px;
            border-radius: 8px;
        }

        .receipt-header h1 {
            font-size: 17px;
        }

        .store-tagline {
            font-size: 10px;
        }

        .store-details {
            font-size: 9px;
        }

        .receipt-title {
            margin: 15px 0 12px;
            font-size: 9px;
        }

        .sale-info {
            padding: 10px;
            margin-bottom: 14px;
            border-radius: 5px;
            gap: 8px;
        }

        .sale-info span {
            font-size: 8px;
        }

        .sale-info strong {
            font-size: 9px;
        }

        .items-header,
        .receipt-item {
            grid-template-columns: minmax(0, 1fr) 25px 55px 60px;
            gap: 4px;
        }

        .items-header {
            font-size: 7px;
        }

        .receipt-item {
            padding: 8px 0;
            font-size: 9px;
        }

        .item-name small {
            font-size: 7px;
        }

        .summary-line {
            font-size: 9px;
            margin-bottom: 6px;
        }

        .grand-total {
            padding: 9px;
            font-size: 10px;
        }

        .grand-total strong {
            font-size: 13px;
        }

        .change-line,
        .balance-line {
            padding: 8px 9px;
            font-size: 9px;
        }

        .change-line strong,
        .balance-line strong {
            font-size: 11px;
        }

        .receipt-footer {
            margin-top: 18px;
            padding-top: 12px;
        }

        .thank-you {
            font-size: 10px;
        }

        .receipt-footer p {
            font-size: 8px;
        }

        .receipt-barcode {
            font-size: 7px;
        }
    }

</style>

@endsection
