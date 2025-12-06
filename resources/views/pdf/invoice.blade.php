<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .title { font-size: 22px; font-weight: bold; text-align:center; }
    </style>
</head>
<body>

    <div class="title">Invoice</div>

    <p><strong>Invoice No:</strong> {{ $invoice->invoice_no }}</p>
    <p><strong>Patient:</strong> {{ $invoice->patient->full_name }}</p>

    <table width="100%" border="1" cellspacing="0" cellpadding="8">
        <thead>
            <tr>
                <th>Item</th><th>Qty</th><th>Rate</th><th>Amount</th>
            </tr>
        </thead>
        <tbody>
        @foreach($invoice->items as $item)
            <tr>
                <td>{{ $item->item_name }}</td>
                <td>{{ $item->qty }}</td>
                <td>{{ $item->rate }}</td>
                <td>{{ $item->amount }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

</body>
</html>
