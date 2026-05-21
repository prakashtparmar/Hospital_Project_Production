<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Purchase Invoice - {{ $purchase->invoice_no }}</title>

    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 12px; 
            margin: 20px;
            color: #333;
        }

        h2 {
            margin-bottom: 5px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        h3 { 
            margin: 10px 0 5px 0; 
            color: #444;
            border-left: 4px solid #337ab7;
            padding-left: 6px;
        }

        hr { 
            border: 0; 
            border-top: 1px solid #999; 
            margin: 10px 0 15px 0;
        }

        .info-block { 
            margin-bottom: 15px; 
            line-height: 1.6; 
            background: #f9f9f9;
            padding: 10px;
            border: 1px solid #ddd;
        }

        .title-bar {
            background: #337ab7;
            color: white;
            padding: 8px 10px;
            margin-top: 25px;
            font-weight: bold;
            font-size: 13px;
            letter-spacing: 0.5px;
            border-radius: 4px;
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 15px; 
            font-size: 12px;
        }

        table th { 
            background: #f1f1f1; 
            border: 1px solid #666; 
            padding: 6px; 
            font-weight: bold;
            text-align: center;
        }

        table td { 
            border: 1px solid #666; 
            padding: 6px; 
            vertical-align: top;
        }

        .summary-table td { 
            border: 1px solid #666; 
            padding: 8px;
        }

        .right { 
            text-align: right; 
            font-weight: bold; 
        }

        .signature-block {
            margin-top: 40px;
            text-align: right;
            font-size: 12px;
        }

        .footer-note {
            margin-top: 35px;
            text-align: center;
            font-size: 11px;
            color: #777;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
    </style>
</head>

<body>

<h2>Purchase Invoice</h2>

<hr>

<h3>Basic Information</h3>

<div class="info-block">
    <strong>Hospital:</strong> {{ config('app.name') }} <br>
    <strong>GRN:</strong> {{ $purchase->grn_no }} <br>
    <strong>Invoice No:</strong> {{ $purchase->invoice_no }} <br>
    <strong>Date:</strong> {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d-M-Y') }} <br>
</div>

<h3>Supplier Details</h3>

<div class="info-block">
    <strong>{{ $purchase->supplier->name }}</strong><br>

    @if($purchase->supplier->email)
        Email: {{ $purchase->supplier->email }} <br>
    @endif

    @if($purchase->supplier->phone)
        Phone: {{ $purchase->supplier->phone }} <br>
    @endif
</div>

<div class="title-bar">Items Purchased</div>

<table>
    <thead>
        <tr>
            <th>Medicine</th>
            <th>Qty</th>
            <th>Rate</th>
            <th>GST%</th>
            <th>GST Amt</th>
            <th>Total</th>
            <th>Batch</th>
            <th>Expiry</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($purchase->items as $item)
        @php
            $qty = $item->quantity;
            $rate = $item->rate;
            $amount = $item->amount;
            $taxPercent = $item->tax_percent ?? 0;
            $taxAmount = ($amount * $taxPercent) / 100;
        @endphp

        <tr>
            <td>{{ $item->medicine->name ?? 'Unknown' }}</td>
            <td style="text-align:center;">{{ $qty }}</td>
            <td style="text-align:right;">₹{{ number_format($rate, 2) }}</td>
            <td style="text-align:center;">{{ $taxPercent }}%</td>
            <td style="text-align:right;">₹{{ number_format($taxAmount, 2) }}</td>
            <td style="text-align:right;">₹{{ number_format($amount, 2) }}</td>
            <td>{{ $item->batch_no ?? '—' }}</td>
            <td>
                @if($item->expiry_date)
                    {{ \Carbon\Carbon::parse($item->expiry_date)->format('d-M-Y') }}
                @else
                    —
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="title-bar">Payment Summary</div>

<table class="summary-table">
    <tr>
        <td><strong>Subtotal</strong></td>
        <td class="right">₹{{ number_format($purchase->total_amount, 2) }}</td>
    </tr>
    <tr>
        <td><strong>Total GST</strong></td>
        <td class="right">₹{{ number_format($purchase->tax_amount, 2) }}</td>
    </tr>
    <tr>
        <td><strong>Grand Total</strong></td>
        <td class="right"><strong>₹{{ number_format($purchase->grand_total, 2) }}</strong></td>
    </tr>
</table>

<div class="signature-block">
    __________________________ <br>
    <strong>Authorized Signature</strong>
</div>

<div class="footer-note">
    This is a computer-generated invoice and does not require a physical signature.
</div>

</body>
</html>
