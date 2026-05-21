@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>

        <li>
            <a href="{{ route('purchases.index') }}">Purchases</a>
        </li>

        <li class="active">Edit Purchase</li>
    </ul>
</div>
@endsection


@section('content')

<div class="page-header">
    <h4 class="page-title">Edit Purchase (GRN: {{ $purchase->grn_no }})</h4>
</div>

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade in">
    <button class="close" data-dismiss="alert">&times;</button>
    <i class="ace-icon fa fa-exclamation-triangle"></i>
    Please fix the highlighted fields.
</div>
@endif

@if(session('success'))
<div class="alert alert-success alert-dismissible fade in">
    <button class="close" data-dismiss="alert">&times;</button>
    <i class="ace-icon fa fa-check"></i>
    {{ session('success') }}
</div>
@endif


<div class="row">
<div class="col-xs-12">

    <div class="widget-box">

        <div class="widget-header">
            <h4 class="widget-title">Purchase Details</h4>
        </div>

        <div class="widget-body">
            <div class="widget-main">

                <form class="form-horizontal"
                      method="POST"
                      action="{{ route('purchases.update', $purchase->id) }}">

                    @csrf
                    @method('PUT')

                    {{-- Supplier --}}
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">Supplier</label>
                        <div class="col-sm-9">
                            <select name="supplier_id"
                                    class="col-xs-12 col-sm-6 form-control"
                                    required>

                                <option value="">Select Supplier</option>

                                @foreach($suppliers as $s)
                                    <option value="{{ $s->id }}"
                                        {{ $purchase->supplier_id == $s->id ? 'selected' : '' }}>
                                        {{ $s->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    {{-- Invoice No --}}
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">Invoice No</label>
                        <div class="col-sm-9">
                            <input type="text"
                                   name="invoice_no"
                                   value="{{ $purchase->invoice_no }}"
                                   class="col-xs-12 col-sm-6 form-control">
                        </div>
                    </div>

                    {{-- Purchase Date --}}
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">Purchase Date *</label>
                        <div class="col-sm-9">
                            <input type="date"
                                   name="purchase_date"
                                   value="{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d') }}"
                                   class="col-xs-12 col-sm-6 form-control"
                                   required>
                        </div>
                    </div>

                    {{-- Purchase Status --}}
<div class="form-group">
    <label class="col-sm-3 control-label no-padding-right">Status</label>
    <div class="col-sm-9">
        <select name="status" class="col-xs-12 col-sm-6 form-control" required>
            <option value="inapproval" {{ $purchase->status == 'inapproval' ? 'selected' : '' }}>In Approval</option>
            <option value="approved" {{ $purchase->status == 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="completed" {{ $purchase->status == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ $purchase->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
    </div>
</div>



                    <hr>

                    <h4 class="header blue">Purchase Items</h4>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="itemsTable">
                            <thead>
                                <tr>
                                    <th width="25%">Medicine</th>
                                    <th width="8%">Qty</th>
                                    <th width="12%">Rate</th>
                                    <th width="12%">Amount</th>
                                    <th width="12%">GST %</th>
                                    <th width="12%">Batch</th>
                                    <th width="12%">Expiry</th>
                                    <th width="3%"></th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($purchase->items as $item)
                                <tr>

                                    {{-- Medicine --}}
                                    <td>
                                        <select name="medicine_id[]" class="form-control" required>
                                            <option value="">Select Medicine</option>
                                            @foreach($medicines as $m)
                                            <option value="{{ $m->id }}"
                                                {{ $item->medicine_id == $m->id ? 'selected' : '' }}>
                                                {{ $m->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </td>

                                    {{-- Qty --}}
                                    <td>
                                        <input name="qty[]"
                                               type="number"
                                               class="form-control qty"
                                               value="{{ $item->quantity }}"
                                               required>
                                    </td>

                                    {{-- Rate --}}
                                    <td>
                                        <input name="rate[]"
                                               type="number"
                                               step="0.01"
                                               class="form-control rate"
                                               value="{{ $item->rate }}"
                                               required>
                                    </td>

                                    {{-- Amount --}}
                                    <td>
                                        <input name="amount[]"
                                               class="form-control amount"
                                               readonly
                                               value="{{ number_format($item->amount,2) }}">
                                    </td>

                                    {{-- GST --}}
                                    <td>
                                        <select name="tax_percent[]" class="form-control">
                                            <option value="0"  {{ $item->tax_percent == 0 ? 'selected' : '' }}>0%</option>
                                            <option value="5"  {{ $item->tax_percent == 5 ? 'selected' : '' }}>5%</option>
                                            <option value="12" {{ $item->tax_percent == 12 ? 'selected' : '' }}>12%</option>
                                            <option value="18" {{ $item->tax_percent == 18 ? 'selected' : '' }}>18%</option>
                                            <option value="28" {{ $item->tax_percent == 28 ? 'selected' : '' }}>28%</option>
                                        </select>
                                    </td>

                                    {{-- Batch --}}
                                    <td>
                                        <input name="batch_no[]"
                                               class="form-control"
                                               value="{{ $item->batch_no }}">
                                    </td>

                                    {{-- Expiry --}}
                                    <td>
                                        <input type="date"
                                               name="expiry_date[]"
                                               class="form-control"
                                               value="{{ $item->expiry_date ? \Carbon\Carbon::parse($item->expiry_date)->format('Y-m-d') : '' }}">
                                    </td>

                                    {{-- Remove Row --}}
                                    <td class="text-center">
                                        <button type="button"
                                                class="btn btn-danger btn-sm removeRow">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>

                                </tr>
                                @endforeach

                            </tbody>

                        </table>
                    </div>

                    <button type="button"
                            id="addRowBtn"
                            class="btn btn-sm btn-secondary mb-3">
                        <i class="fa fa-plus"></i> Add Item
                    </button>


                    {{-- Submit --}}
                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">

                            <button type="submit" class="btn btn-success">
                                <i class="ace-icon fa fa-check"></i> Update Purchase
                            </button>

                            &nbsp;

                            <a href="{{ route('purchases.index') }}" class="btn btn-default">
                                <i class="ace-icon fa fa-arrow-left"></i> Back
                            </a>

                        </div>
                    </div>

                </form>

            </div>
        </div>

    </div>

</div>
</div>


{{-- JS Logic --}}
<script>
/* AUTO UPDATE AMOUNT */
document.addEventListener("input", function () {
    document.querySelectorAll("#itemsTable tbody tr").forEach(function (row) {
        let qty  = parseFloat(row.querySelector(".qty")?.value || 0);
        let rate = parseFloat(row.querySelector(".rate")?.value || 0);

        let amountField = row.querySelector(".amount");
        amountField.value = (qty * rate).toFixed(2);
    });
});

/* ADD NEW ROW */
document.getElementById("addRowBtn").addEventListener("click", function () {
    let table = document.querySelector("#itemsTable tbody");
    let row = table.rows[0].cloneNode(true);

    row.querySelectorAll("input").forEach(input => input.value = "");
    row.querySelectorAll("select").forEach(select => select.value = "");

    table.appendChild(row);
});

/* REMOVE ROW */
document.addEventListener("click", function (e) {
    if (e.target.closest(".removeRow")) {
        let rows = document.querySelectorAll("#itemsTable tbody tr").length;
        if (rows > 1) {
            e.target.closest("tr").remove();
        }
    }
});
</script>

@endsection
