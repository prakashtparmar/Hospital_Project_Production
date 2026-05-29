@extends('layouts.app')

@section('title', 'Medicine Issue Invoice')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state no-print" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ route('issue-medicines.index') }}">Issue Medicines</a>
        </li>
        <li class="active">Invoice</li>
    </ul>
</div>
@endsection

@section('content')
@php
    $patient = $issue->patient;
    $doctor = $issue->doctor;
    $subtotal = $issue->items->sum('amount');
    $grandTotal = $issue->total_amount ?: $subtotal;
@endphp

<style>
    .invoice-actions {
        margin-bottom: 15px;
    }

    .invoice-sheet {
        max-width: 980px;
        margin: 0 auto;
        background: #fff;
        border: 1px solid #d9d9d9;
        padding: 24px;
        color: #333;
    }

    .invoice-title {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        color: #2b5f85;
        letter-spacing: 0;
    }

    .invoice-subtitle {
        margin: 4px 0 0;
        color: #777;
    }

    .invoice-heading {
        text-align: right;
    }

    .invoice-heading h2 {
        margin: 0;
        color: #333;
        font-weight: 700;
        text-transform: uppercase;
    }

    .invoice-meta {
        margin-top: 8px;
        line-height: 1.7;
    }

    .invoice-divider {
        border: 0;
        border-top: 2px solid #2b5f85;
        margin: 18px 0;
    }

    .invoice-section-title {
        margin: 0 0 8px;
        color: #2b5f85;
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .invoice-box {
        border: 1px solid #e3e3e3;
        background: #fafafa;
        padding: 12px;
        min-height: 118px;
        line-height: 1.7;
    }

    .invoice-table th {
        background: #eef4f8 !important;
        color: #333;
        border-color: #c8d6df !important;
        vertical-align: middle !important;
    }

    .invoice-table td {
        vertical-align: middle !important;
    }

    .invoice-total-table {
        width: 100%;
        max-width: 360px;
        margin-left: auto;
    }

    .invoice-total-table td {
        padding: 8px 10px;
        border: 1px solid #ddd;
    }

    .invoice-total-table .grand-total td {
        background: #eef4f8;
        font-size: 16px;
        font-weight: 700;
    }

    .invoice-footer {
        margin-top: 38px;
    }

    .signature-line {
        border-top: 1px solid #888;
        width: 220px;
        margin: 42px 0 0 auto;
        padding-top: 7px;
        text-align: center;
    }

    @media print {
        body {
            background: #fff !important;
        }

        .navbar,
        .sidebar,
        .footer,
        .breadcrumbs,
        .no-print,
        #btn-scroll-up {
            display: none !important;
        }

        .main-content,
        .sidebar + .main-content,
        .page-content {
            margin: 0 !important;
            padding: 0 !important;
        }

        .invoice-sheet {
            max-width: none;
            border: 0;
            padding: 0;
        }

        a[href]:after {
            content: "";
        }
    }
</style>

<div class="invoice-actions no-print clearfix">
    <a href="{{ route('issue-medicines.index') }}" class="btn btn-default btn-sm">
        <i class="fa fa-arrow-left"></i> Back
    </a>

    <button type="button" class="btn btn-primary btn-sm pull-right" onclick="window.print()">
        <i class="fa fa-print"></i> Print Invoice
    </button>
</div>

<div class="invoice-sheet" id="medicineIssueInvoice">
    <div class="row">
        <div class="col-xs-7">
            <h1 class="invoice-title">{{ config('app.name', 'Hospital Management System') }}</h1>
            <p class="invoice-subtitle">Pharmacy Department</p>
            <p class="invoice-meta">
                <strong>Address:</strong> {{ config('app.address', 'Hospital Address') }}<br>
                <strong>Phone:</strong> {{ config('app.phone', 'N/A') }}
            </p>
        </div>

        <div class="col-xs-5 invoice-heading">
            <h2>Invoice</h2>
            <div class="invoice-meta">
                <strong>Issue No:</strong> {{ $issue->issue_no ?? ('ISS-' . $issue->id) }}<br>
                <strong>Issue Date:</strong>
                {{ $issue->issue_date ? \Carbon\Carbon::parse($issue->issue_date)->format('d M Y') : 'N/A' }}<br>
                <strong>Printed On:</strong> {{ now()->format('d M Y, h:i A') }}
            </div>
        </div>
    </div>

    <hr class="invoice-divider">

    <div class="row">
        <div class="col-xs-6">
            <h4 class="invoice-section-title">Patient Details</h4>
            <div class="invoice-box">
                <strong>{{ $patient?->full_name ?? 'N/A' }}</strong><br>
                <strong>Patient ID:</strong> {{ $patient?->patient_id ?? 'N/A' }}<br>
                <strong>Gender/Age:</strong>
                {{ $patient?->gender ?? 'N/A' }} / {{ $patient?->age ?? 'N/A' }}<br>
                <strong>Phone:</strong> {{ $patient?->phone ?? 'N/A' }}<br>
                <strong>Address:</strong> {{ $patient?->address ?? 'N/A' }}
            </div>
        </div>

        <div class="col-xs-6">
            <h4 class="invoice-section-title">Reference Details</h4>
            <div class="invoice-box">
                <strong>Doctor:</strong> {{ $doctor?->name ?? 'N/A' }}<br>
                <strong>OPD ID:</strong> {{ $issue->opd_id ?? 'N/A' }}<br>
                <strong>IPD ID:</strong> {{ $issue->ipd_id ?? 'N/A' }}<br>
                <strong>Status:</strong> Medicine Issued<br>
                <strong>Created:</strong> {{ optional($issue->created_at)->format('d M Y, h:i A') ?? 'N/A' }}
            </div>
        </div>
    </div>

    <div class="space-12"></div>

    <h4 class="invoice-section-title">Issued Medicines</h4>
    <div class="table-responsive">
        <table class="table table-bordered invoice-table">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Medicine</th>
                    <th class="text-center" style="width: 90px;">Qty</th>
                    <th class="text-right" style="width: 120px;">Rate</th>
                    <th class="text-right" style="width: 140px;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($issue->items as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>
                            <strong>{{ $item->medicine?->name ?? 'Deleted Medicine' }}</strong>
                            @if($item->medicine?->sku)
                                <br><small class="text-muted">SKU: {{ $item->medicine->sku }}</small>
                            @endif
                        </td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">₹{{ number_format($item->rate, 2) }}</td>
                        <td class="text-right"><strong>₹{{ number_format($item->amount, 2) }}</strong></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No medicines found for this invoice.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="row">
        <div class="col-xs-7">
            <p class="text-muted">
                Medicines once issued should be verified at the pharmacy counter.
            </p>
        </div>
        <div class="col-xs-5">
            <table class="invoice-total-table">
                <tr>
                    <td>Subtotal</td>
                    <td class="text-right">₹{{ number_format($subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td>Discount</td>
                    <td class="text-right">₹0.00</td>
                </tr>
                <tr class="grand-total">
                    <td>Grand Total</td>
                    <td class="text-right">₹{{ number_format($grandTotal, 2) }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="invoice-footer row">
        <div class="col-xs-6">
            <strong>Notes</strong>
            <p class="text-muted">This is a computer-generated pharmacy issue invoice.</p>
        </div>
        <div class="col-xs-6">
            <div class="signature-line">Authorized Signature</div>
        </div>
    </div>
</div>

@endsection
