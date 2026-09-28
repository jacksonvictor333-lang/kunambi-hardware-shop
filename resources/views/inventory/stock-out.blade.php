@extends('layouts.app')

@section('title', 'Stock Out')

@section('content')

<style>
    :root {
        --primary-green: #16A34A;
        --dark-green: #15803D;
        --light-green: #DCFCE7;
        --very-light-green: #F0FDF4;
        --border: #BBF7D0;
        --text: #0F172A;
        --muted: #64748B;
        --danger: #DC2626;
        --danger-dark: #B91C1C;
        --danger-light: #FEF2F2;
        --danger-border: #FECACA;
    }

    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 24px;
    }

    .page-title {
        font-size: 22px;
        font-weight: 700;
        color: var(--text);
        margin: 0;
    }

    .page-subtitle {
        font-size: 13px;
        color: var(--muted);
        margin-top: 4px;
    }

    .breadcrumb-custom {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 12px;
        color: var(--muted);
        margin-bottom: 8px;
    }

    .breadcrumb-custom a {
        color: var(--primary-green);
        text-decoration: none;
        font-weight: 600;
    }

    .breadcrumb-custom a:hover {
        color: var(--dark-green);
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        color: var(--muted);
        border: 1.5px solid var(--border);
        border-radius: 10px;
        padding: 9px 16px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all .2s;
    }

    .btn-back:hover {
        border-color: var(--primary-green);
        color: var(--dark-green);
        background: var(--very-light-green);
    }

    /* ERROR */

    .error-card {
        background: #FEF2F2;
        border: 1px solid #FECACA;
        border-radius: 12px;
        padding: 16px 18px;
        margin-bottom: 20px;
    }

    .error-title {
        color: #991B1B;
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .error-card ul {
        margin: 0;
        padding-left: 20px;
        color: #B91C1C;
        font-size: 13px;
    }

    /* WARNING */

    .warning-card {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        background: var(--danger-light);
        border: 1px solid var(--danger-border);
        border-radius: 14px;
        padding: 17px 18px;
        margin-bottom: 20px;
    }

    .warning-icon {
        width: 34px;
        height: 34px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #FEE2E2;
        color: var(--danger);
        font-size: 16px;
        font-weight: 800;
    }

    .warning-title {
        font-size: 14px;
        font-weight: 700;
        color: #991B1B;
        margin-bottom: 3px;
    }

    .warning-text {
        font-size: 13px;
        line-height: 1.6;
        color: #991B1B;
        margin: 0;
    }

    /* FORM CARD */

    .form-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(22, 163, 74, .06);
        overflow: hidden;
    }

    .form-card-header {
        padding: 20px 22px;
        background: var(--very-light-green);
        border-bottom: 1px solid var(--border);
    }

    .form-card-title {
        display: flex;
        align-items: center;
        gap: 9px;
        font-size: 16px;
        font-weight: 700;
        color: var(--dark-green);
        margin: 0;
    }

    .form-card-title i {
        font-size: 17px;
    }

    .form-card-subtitle {
        margin: 5px 0 0 26px;
        font-size: 12px;
        color: var(--muted);
    }

    .form-card-body {
        padding: 24px 22px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-label-custom {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #166534;
        margin-bottom: 7px;
    }

    .required {
        color: var(--danger);
    }

    .optional {
        color: #94A3B8;
        font-weight: 400;
    }

    .form-control-custom {
        width: 100%;
        min-height: 44px;
        padding: 10px 13px;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        font-size: 13px;
        color: var(--text);
        background: var(--very-light-green);
        outline: none;
        transition: all .2s;
        font-family: inherit;
        box-sizing: border-box;
    }

    .form-control-custom:focus {
        border-color: var(--primary-green);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, .10);
    }

    .form-control-custom::placeholder {
        color: #94A3B8;
    }

    select.form-control-custom {
        cursor: pointer;
        appearance: auto;
    }

    textarea.form-control-custom {
        min-height: 110px;
        resize: vertical;
    }

    .form-help {
        margin-top: 6px;
        font-size: 11px;
        color: var(--muted);
        line-height: 1.5;
    }

    .field-error {
        margin-top: 6px;
        color: var(--danger);
        font-size: 12px;
    }

    /* PRODUCT INFO */

    .product-info {
        margin-top: 8px;
        padding: 10px 12px;
        border-radius: 9px;
        background: var(--very-light-green);
        border: 1px solid #DCFCE7;
        font-size: 11px;
        color: var(--muted);
    }

    /* ACTIONS */

    .form-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        padding: 18px 22px;
        background: #FAFFFB;
        border-top: 1px solid var(--border);
    }

    .btn-cancel {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 42px;
        padding: 0 18px;
        background: #fff;
        color: var(--muted);
        border: 1.5px solid #CBD5E1;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all .2s;
    }

    .btn-cancel:hover {
        background: #F8FAFC;
        border-color: #94A3B8;
        color: var(--text);
    }

    .btn-submit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 42px;
        padding: 0 20px;
        background: var(--danger);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 3px 8px rgba(220, 38, 38, .18);
        transition: all .2s;
    }

    .btn-submit:hover {
        background: var(--danger-dark);
        transform: translateY(-1px);
        box-shadow: 0 5px 12px rgba(220, 38, 38, .22);
    }

    /* RESPONSIVE */

    @media (max-width: 640px) {

        .page-header {
            align-items: stretch;
        }

        .btn-back {
            justify-content: center;
        }

        .form-card-body {
            padding: 20px 16px;
        }

        .form-actions {
            flex-direction: column-reverse;
            align-items: stretch;
            padding: 16px;
        }

        .btn-cancel,
        .btn-submit {
            width: 100%;
        }
    }
</style>

{{-- PAGE HEADER --}}

<div class="page-header">

```
<div>

    <div class="breadcrumb-custom">

        <a href="{{ route('inventory.index') }}">
            <i class="bi bi-box-seam"></i>
            Inventory
        </a>

        <span>/</span>

        <span>Stock Out</span>

    </div>


    <h1 class="page-title">

        <i class="bi bi-box-arrow-right text-danger me-1"></i>

        Stock Out

    </h1>


    <p class="page-subtitle">

        Remove products from inventory and record the stock-out transaction.

    </p>

</div>


<a
    href="{{ route('inventory.index') }}"
    class="btn-back"
>

    <i class="bi bi-arrow-left"></i>

    Back to Inventory

</a>
```

</div>

{{-- VALIDATION ERRORS --}}
@if ($errors->any())

```
<div class="error-card">

    <div class="error-title">

        <i class="bi bi-exclamation-circle me-1"></i>

        Please fix the following errors

    </div>


    <ul>

        @foreach ($errors->all() as $error)

            <li>{{ $error }}</li>

        @endforeach

    </ul>

</div>
```

@endif

{{-- WARNING --}}

<div class="warning-card">

```
<div class="warning-icon">

    <i class="bi bi-exclamation-lg"></i>

</div>


<div>

    <div class="warning-title">

        Stock will decrease

    </div>


    <p class="warning-text">

        This transaction will immediately reduce the selected
        product's available stock and create a
        <strong>stock_out</strong> movement record.

    </p>

</div>
```

</div>

{{-- FORM --}}

<form
    method="POST"
    action="{{ route('inventory.stock-out.store') }}"
>

```
@csrf


<div class="form-card">


    {{-- HEADER --}}
    <div class="form-card-header">

        <h2 class="form-card-title">

            <i class="bi bi-box-arrow-right"></i>

            Stock Out Details

        </h2>


        <p class="form-card-subtitle">

            Select a product and enter the quantity to remove from inventory.

        </p>

    </div>


    {{-- BODY --}}
    <div class="form-card-body">


        {{-- PRODUCT --}}
        <div class="form-group">

            <label
                for="product_id"
                class="form-label-custom"
            >

                Product

                <span class="required">*</span>

            </label>


            <select
                name="product_id"
                id="product_id"
                required
                class="form-control-custom"
            >

                <option value="">
                    Select product
                </option>


                @foreach ($products as $product)

                    <option
                        value="{{ $product->id }}"
                        {{ old('product_id') == $product->id ? 'selected' : '' }}
                    >

                        {{ $product->name }}

                        — {{ $product->sku }}

                        — Available: {{ $product->quantity }}

                    </option>

                @endforeach

            </select>


            <div class="form-help">

                Select the product you want to remove from inventory.

            </div>


            @error('product_id')

                <div class="field-error">

                    <i class="bi bi-exclamation-circle"></i>

                    {{ $message }}

                </div>

            @enderror

        </div>


        {{-- QUANTITY --}}
        <div class="form-group">

            <label
                for="quantity"
                class="form-label-custom"
            >

                Quantity to Remove

                <span class="required">*</span>

            </label>


            <input
                type="number"
                name="quantity"
                id="quantity"
                min="1"
                value="{{ old('quantity') }}"
                required
                placeholder="e.g. 2"
                class="form-control-custom"
            >


            <div class="form-help">

                Enter the quantity you want to remove.
                The quantity cannot be greater than the available stock.

            </div>


            @error('quantity')

                <div class="field-error">

                    <i class="bi bi-exclamation-circle"></i>

                    {{ $message }}

                </div>

            @enderror

        </div>


        {{-- REFERENCE --}}
        <div class="form-group">

            <label
                for="reference"
                class="form-label-custom"
            >

                Reference

                <span class="optional">
                    (Optional)
                </span>

            </label>


            <input
                type="text"
                name="reference"
                id="reference"
                value="{{ old('reference') }}"
                placeholder="e.g. SALE-00001"
                class="form-control-custom"
            >


            <div class="form-help">

                Enter a sale number, invoice number,
                stock issue number, or other reference.

            </div>


            @error('reference')

                <div class="field-error">

                    <i class="bi bi-exclamation-circle"></i>

                    {{ $message }}

                </div>

            @enderror

        </div>


        {{-- REASON --}}
        <div class="form-group">

            <label
                for="r
```
