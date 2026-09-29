@extends('layouts.app')

@section('title', 'Expense Details')

@section('content')

<div class="min-h-screen bg-slate-50 py-6">

    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <div class="flex items-center gap-3">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-100">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>

                    <div>
                        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Expense Details</h1>
                        <p class="mt-1 text-sm text-slate-500">View complete expense information</p>
                    </div>

                </div>
            </div>

            {{-- Header Actions --}}
            <div class="flex flex-wrap gap-2">

                <a href="{{ route('expenses.index') }}"
                   class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back
                </a>

                <a href="{{ route('expenses.edit', $expense) }}"
                   class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-9.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 8.5-8.5z"/>
                    </svg>
                    Edit Expense
                </a>

            </div>

        </div>


        {{-- Success Message --}}
        @if (session('success'))
            <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 p-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-green-100">
                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif


        {{-- Summary Cards --}}
        @php
            $paymentIcons = [
                'cash'         => '💵',
                'mobile_money' => '📱',
                'bank'         => '🏦',
                'credit'       => '📋',
                'card'         => '💳',
                'cheque'       => '📝',
                'transfer'     => '🔁',
            ];

            $paymentLabels = [
                'cash'         => '💵 Cash',
                'mobile_money' => '📱 Mobile Money',
                'bank'         => '🏦 Bank Transfer',
                'credit'       => '📋 Credit',
                'card'         => '💳 Card',
                'cheque'       => '📝 Cheque',
                'transfer'     => '🔁 Transfer',
            ];

            $icon  = $paymentIcons[$expense->payment_method]  ?? '💰';
            $label = $paymentLabels[$expense->payment_method] ?? ucfirst(str_replace('_', ' ', $expense->payment_method));
        @endphp

        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

            {{-- Amount --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm overflow-hidden relative">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Amount</p>
                        <p class="mt-2 text-xl font-bold text-slate-900">TZS {{ number_format((float) $expense->amount, 2) }}</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-100">
                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V6m0 10v2"/>
                        </svg>
                    </div>
                </div>
                <div style="height:4px; background:#16A34A; position:absolute; bottom:0; left:0; right:0; border-radius:0 0 16px 16px;"></div>
            </div>

            {{-- Category --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm overflow-hidden relative">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Category</p>
                        <p class="mt-2 text-lg font-bold text-slate-900">{{ $expense->category }}</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100">
                        <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5.586a1 1 0 01.707.293l7.414 7.414a2 2 0 010 2.828l-6.172 6.172a2 2 0 01-2.828 0L4.293 12.293A1 1 0 014 11.586V6a3 3 0 013-3z"/>
                        </svg>
                    </div>
                </div>
                <div style="height:4px; background:#2563EB; position:absolute; bottom:0; left:0; right:0; border-radius:0 0 16px 16px;"></div>
            </div>

            {{-- Date --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm overflow-hidden relative">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Expense Date</p>
                        <p class="mt-2 text-lg font-bold text-slate-900">{{ optional($expense->expense_date)->format('d M Y') }}</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-100">
                        <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <div style="height:4px; background:#7C3AED; position:absolute; bottom:0; left:0; right:0; border-radius:0 0 16px 16px;"></div>
            </div>

            {{-- Payment --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm overflow-hidden relative">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Payment</p>
                        <p class="mt-2 text-lg font-bold text-slate-900">{{ $label }}</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-2xl">
                        {{ $icon }}
                    </div>
                </div>
                <div style="height:4px; background:#D97706; position:absolute; bottom:0; left:0; right:0; border-radius:0 0 16px 16px;"></div>
            </div>

        </div>


        {{-- Main Content --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            {{-- Expense Information --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm lg:col-span-2">

                <div class="border-b border-slate-200 px-6 py-5">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-50">
                            <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.707.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="font-semibold text-slate-900">Expense Information</h2>
                            <p class="text-sm text-slate-500">Complete record information</p>
                        </div>
                    </div>
                </div>

                <div class="divide-y divide-slate-100">

                    {{-- Title --}}
                    <div class="flex flex-col gap-2 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Expense Title</p>
                            <p class="mt-1 text-base font-semibold text-slate-900">{{ $expense->title }}</p>
                        </div>
                    </div>

                    {{-- Category --}}
                    <div class="flex flex-col gap-2 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Category</p>
                            <p class="mt-1 text-sm font-medium text-slate-900">{{ $expense->category }}</p>
                        </div>
                        <span class="inline-flex w-fit items-center rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                            {{ $expense->category }}
                        </span>
                    </div>

                    {{-- Amount --}}
                    <div class="flex flex-col gap-2 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Amount</p>
                            <p class="mt-1 text-xl font-bold text-green-600">TZS {{ number_format((float) $expense->amount, 2) }}</p>
                        </div>
                    </div>

                    {{-- Date --}}
                    <div class="flex flex-col gap-2 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Expense Date</p>
                            <p class="mt-1 text-sm font-medium text-slate-900">{{ optional($expense->expense_date)->format('d F Y') }}</p>
                        </div>
                    </div>

                    {{-- Payment Method --}}
                    <div class="flex flex-col gap-2 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Payment Method</p>
                            <p class="mt-1 text-sm font-medium text-slate-900">{{ $label }}</p>
                        </div>
                        <span class="inline-flex w-fit items-center gap-1.5 rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                            {{ $icon }} {{ $label }}
                        </span>
                    </div>

                    {{-- Paid To --}}
                    <div class="flex flex-col gap-2 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Paid To</p>
                            <p class="mt-1 text-sm font-medium text-slate-900">{{ $expense->paid_to ?: '—' }}</p>
                        </div>
                    </div>

                    {{-- Reference --}}
                    <div class="flex flex-col gap-2 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Reference Number</p>
                            <p class="mt-1 text-sm font-medium text-slate-900">{{ $expense->reference_number ?: '—' }}</p>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="px-6 py-5">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Description / Notes</p>
                        @if ($expense->description)
                            <p class="mt-3 whitespace-pre-line text-sm leading-7 text-slate-700">{{ $expense->description }}</p>
                        @else
                            <p class="mt-3 text-sm italic text-slate-400">No description provided.</p>
                        @endif
                    </div>

                </div>

            </div>


            {{-- Side Information --}}
            <div class="space-y-6">

                {{-- Recorded By --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100">
                            <svg class="h-5 w-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-900">Recorded By</h3>
                            <p class="text-xs text-slate-500">User information</p>
                        </div>
                    </div>
                    <div class="mt-5 rounded-xl bg-slate-50 p-4">
                        @if ($expense->user)
                            <p class="font-semibold text-slate-900">{{ $expense->user->name }}</p>
                            <p class="mt-1 break-all text-sm text-slate-500">{{ $expense->user->email }}</p>
                        @else
                            <p class="text-sm italic text-slate-400">User information unavailable.</p>
                        @endif
                    </div>
                </div>


                {{-- Attachment --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50">
                            <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.414a4 4 0 00-5.656-5.656l-6.415 6.414a6 6 0 108.486 8.486L20.5 13"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-900">Receipt / Attachment</h3>
                            <p class="text-xs text-slate-500">Supporting document</p>
                        </div>
                    </div>

                    @if ($expense->attachment)

                        @php
                            $ext      = strtolower(pathinfo($expense->attachment, PATHINFO_EXTENSION));
                            $isImage  = in_array($ext, ['jpg','jpeg','png','gif','webp']);
                            $isPdf    = $ext === 'pdf';
                            $fileIcon = $isPdf ? '📄' : ($isImage ? '🖼️' : '📎');
                            $fileUrl  = asset('storage/' . $expense->attachment);
                        @endphp

                        <div class="mt-5 rounded-xl border border-slate-200 bg-slate-50 p-4">

                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white shadow-sm ring-1 ring-slate-200 text-xl">
                                    {{ $fileIcon }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-semibold text-slate-800">Receipt File</p>
                                    <p class="truncate text-xs text-slate-500">{{ basename($expense->attachment) }}</p>
                                </div>
                            </div>

                            {{-- View button — opens modal, NOT new tab --}}
                            <button
                                onclick="openAttachmentModal('{{ $fileUrl }}', '{{ $ext }}')"
                                class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700"
                            >
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {{ $fileIcon }} View Attachment
                            </button>

                        </div>

                    @else

                        <div class="mt-5 rounded-xl border border-dashed border-slate-300 bg-slate-50 p-6 text-center">
                            <p class="text-3xl mb-2">📎</p>
                            <p class="text-sm font-medium text-slate-500">No attachment</p>
                            <p class="mt-1 text-xs text-slate-400">No receipt was uploaded.</p>
                        </div>

                    @endif

                </div>


                {{-- Record Information --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="font-semibold text-slate-900">Record Information</h3>
                    <div class="mt-4 space-y-4">
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-sm text-slate-500">Expense ID</span>
                            <span class="text-sm font-semibold text-slate-900">#{{ $expense->id }}</span>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-sm text-slate-500">Created</span>
                            <span class="text-right text-sm font-medium text-slate-900">{{ $expense->created_at?->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-sm text-slate-500">Last Updated</span>
                            <span class="text-right text-sm font-medium text-slate-900">{{ $expense->updated_at?->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>


        {{-- Bottom Actions --}}
        <div class="mt-6 flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-semibold text-slate-900">Expense #{{ $expense->id }}</p>
                <p class="mt-1 text-xs text-slate-500">Review or manage this expense record.</p>
            </div>
            <div class="flex flex-col gap-2 sm:flex-row">
                <a href="{{ route('expenses.index') }}"
                   class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                    Back to Expenses
                </a>
                <a href="{{ route('expenses.edit', $expense) }}"
                   class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-green-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-9.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 8.5-8.5z"/>
                    </svg>
                    Edit Expense
                </a>
            </div>
        </div>

    </div>

</div>


{{-- ================================================
     ATTACHMENT MODAL
================================================ --}}

<div
    id="attachmentModal"
    onclick="handleOverlayClick(event)"
    style="
        display: none;
        position: fixed; inset: 0; z-index: 9999;
        background: rgba(0,0,0,0.65);
        align-items: center; justify-content: center;
        padding: 20px;
        backdrop-filter: blur(4px);
    "
>
    <div
        id="attachmentModalBox"
        style="
            background: #fff;
            border-radius: 20px;
            width: 100%; max-width: 860px;
            max-height: 90vh;
            display: flex; flex-direction: column;
            overflow: hidden;
            box-shadow: 0 24px 64px rgba(0,0,0,0.25);
            animation: modalIn 0.2s ease;
        "
    >

        {{-- Modal Header --}}
        <div style="
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid #E2E8F0;
            background: #F8FAFC;
            border-radius: 20px 20px 0 0;
        ">
            <div style="display:flex; align-items:center; gap:10px;">
                <span id="modalFileIcon" style="font-size:22px;">📄</span>
                <div>
                    <div style="font-size:14px; font-weight:700; color:#0F172A;">Attachment Preview</div>
                    <div style="font-size:11px; color:#64748B;">{{ basename($expense->attachment ?? '') }}</div>
                </div>
            </div>
            <div style="display:flex; align-items:center; gap:8px;">
                {{-- Download button --}}
                <a
                    id="modalDownloadBtn"
                    href="#"
                    download
                    style="
                        display: inline-flex; align-items: center; gap: 6px;
                        padding: 8px 14px; border-radius: 10px;
                        background: #16A34A; color: #fff;
                        font-size: 12px; font-weight: 700;
                        text-decoration: none; transition: background 0.2s;
                    "
                >
                    ⬇️ Download
                </a>
                {{-- X Close button --}}
                <button
                    onclick="closeAttachmentModal()"
                    style="
                        width: 36px; height: 36px; border-radius: 10px;
                        background: #FEE2E2; color: #DC2626;
                        border: none; cursor: pointer;
                        display: flex; align-items: center; justify-content: center;
                        font-size: 16px; font-weight: 800;
                        transition: background 0.15s;
                    "
                    title="Close (Esc)"
                >
                    ✕
                </button>
            </div>
        </div>

        {{-- Modal Body --}}
        <div id="attachmentModalBody" style="flex:1; overflow:auto; padding:20px; display:flex; align-items:center; justify-content:center; background:#F1F5F9; min-height:300px;">
            {{-- Content loaded by JS --}}
        </div>

        {{-- Modal Footer --}}
        <div style="
            padding: 14px 20px;
            border-top: 1px solid #E2E8F0;
            background: #F8FAFC;
            display: flex; align-items: center; justify-content: center;
            gap: 8px;
            border-radius: 0 0 20px 20px;
        ">
            <button
                onclick="closeAttachmentModal()"
                style="
                    padding: 9px 24px; border-radius: 10px;
                    background: #fff; color: #64748B;
                    border: 1.5px solid #E2E8F0; cursor: pointer;
                    font-size: 13px; font-weight: 600;
                    transition: all 0.15s;
                "
            >
                Close
            </button>
        </div>

    </div>
</div>


<style>
    @keyframes modalIn {
        from { transform: scale(0.93); opacity: 0; }
        to   { transform: scale(1);    opacity: 1; }
    }
</style>


<script>
    function openAttachmentModal(url, ext) {
        const modal   = document.getElementById('attachmentModal');
        const body    = document.getElementById('attachmentModalBody');
        const dlBtn   = document.getElementById('modalDownloadBtn');
        const fileIcon= document.getElementById('modalFileIcon');

        const imageExts = ['jpg','jpeg','png','gif','webp','svg'];
        const isImage   = imageExts.includes(ext.toLowerCase());
        const isPdf     = ext.toLowerCase() === 'pdf';

        // Set download link
        dlBtn.href = url;

        // Set icon
        fileIcon.textContent = isPdf ? '📄' : isImage ? '🖼️' : '📎';

        // Render content
        if (isImage) {
            body.innerHTML = `
                <img
                    src="${url}"
                    alt="Attachment"
                    style="max-width:100%; max-height:65vh; border-radius:12px; box-shadow:0 4px 20px rgba(0,0,0,0.12);"
                    onerror="this.parentElement.innerHTML='<p style=\\'color:#64748B; font-size:14px;\\'>Could not load image.</p>'"
                >`;
        } else if (isPdf) {
            body.innerHTML = `
                <iframe
                    src="${url}"
                    style="width:100%; height:65vh; border:none; border-radius:8px; background:#fff;"
                    title="PDF Attachment"
                ></iframe>`;
        } else {
            body.innerHTML = `
                <div style="text-align:center; color:#64748B;">
                    <div style="font-size:52px; margin-bottom:12px;">📎</div>
                    <p style="font-size:14px; font-weight:600; color:#0F172A; margin-bottom:8px;">Preview not available</p>
                    <p style="font-size:13px; margin-bottom:20px;">This file type cannot be previewed.</p>
                    <a href="${url}" download
                       style="display:inline-flex; align-items:center; gap:6px; padding:10px 20px; background:#16A34A; color:#fff; border-radius:10px; font-size:13px; font-weight:700; text-decoration:none;">
                        ⬇️ Download File
                    </a>
                </div>`;
        }

        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeAttachmentModal() {
        const modal = document.getElementById('attachmentModal');
        const body  = document.getElementById('attachmentModalBody');
        modal.style.display = 'none';
        body.innerHTML = '';
        document.body.style.overflow = '';
    }

    // Click outside modal box → close
    function handleOverlayClick(e) {
        if (e.target === document.getElementById('attachmentModal')) {
            closeAttachmentModal();
        }
    }

    // Escape key → close
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeAttachmentModal();
    });
</script>

@endsection