<a href="{{ route('purchases.show',$purchase->id) }}" class="btn btn-primary">View GRN</a>





<h4>Goods Received Note</h4>
<p><strong>Supplier:</strong> {{ $purchase->supplier->name }}</p>
<p><strong>Invoice No:</strong> {{ $purchase->invoice_no }}</p>
<p><strong>Date:</strong> {{ $purchase->invoice_date }}</p>

<table class="table table-bordered mt-3">
    <tr>
        <th>Medicine</th>
        <th>Qty</th>
        <th>Rate</th>
        <th>Amount</th>
    </tr>

    @foreach($purchase->items as $item)
    <tr>
        <td>{{ $item->medicine->name }}</td>
        <td>{{ $item->quantity }}</td>
        <td>{{ $item->rate }}</td>
        <td>{{ $item->amount }}</td>
    </tr>
    @endforeach
</table>

<h5>Total: {{ $purchase->total_amount }}</h5>
