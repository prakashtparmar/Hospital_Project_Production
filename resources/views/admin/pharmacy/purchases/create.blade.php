@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li><i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li><a href="{{ route('purchases.index') }}">Purchases</a></li>
        <li class="active">New Purchase</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h4 class="page-title">New Purchase Entry</h4>
</div>

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade in">
    <button class="close" data-dismiss="alert">&times;</button>
    <strong>Please correct the following errors:</strong>
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
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

                <form class="form-horizontal" method="POST" action="{{ route('purchases.store') }}">
                    @csrf

                    {{-- Supplier (Required) --}}
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">Supplier *</label>
                        <div class="col-sm-9">
                            <select name="supplier_id" class="col-xs-12 col-sm-6 form-control" required>
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Invoice No (auto generated) --}}
                    <input type="hidden" name="invoice_no" value="">

                    {{-- Purchase Date --}}
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">Purchase Date *</label>
                        <div class="col-sm-9">
                            <input type="date"
                                   name="purchase_date"
                                   value="{{ date('Y-m-d') }}"
                                   class="col-xs-12 col-sm-6 form-control"
                                   required>
                        </div>
                    </div>

                    <hr>

                    <h4 class="header blue">Purchase Items</h4>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="itemsTable">
                            <thead>
                                <tr>
                                    <th>Medicine *</th>
                                    <th>Qty *</th>
                                    <th>Rate *</th>
                                    <th>GST %</th>
                                    <th>Amount</th>
                                    <th>Batch</th>
                                    <th>Expiry</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>
                                        <select name="medicine_id[]" class="form-control" required>
                                            <option value="">Select</option>
                                            @foreach($medicines as $m)
                                            <option value="{{ $m->id }}">{{ $m->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td><input name="qty[]" type="number" min="1" class="form-control qty" required></td>

                                    <td><input name="rate[]" type="number" step="0.01" class="form-control rate" required></td>

                                    <td>
                                        <select name="tax_percent[]" class="form-control tax">
                                            <option value="0">0%</option>
                                            <option value="5">5%</option>
                                            <option value="12">12%</option>
                                            <option value="18">18%</option>
                                            <option value="28">28%</option>
                                        </select>
                                    </td>

                                    <td><input name="amount[]" class="form-control amount" readonly></td>

                                    <td><input name="batch_no[]" class="form-control"></td>

                                    <td>
                                        <input type="date"
                                               name="expiry_date[]"
                                               class="form-control"
                                               min="{{ date('Y-m-d') }}">
                                    </td>

                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm removeRow">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Add Row --}}
                    <button type="button" id="addRowBtn" class="btn btn-sm btn-secondary mb-3">
                        <i class="fa fa-plus"></i> Add Item
                    </button>

                    {{-- TOTAL BAR --}}
                    <div class="well">
                        <div class="row">
                            <div class="col-md-4">
                                <h5><b>Subtotal:</b> ₹ <span id="subtotal">0.00</span></h5>
                            </div>

                            <div class="col-md-4">
                                <h5><b>Total GST:</b> ₹ <span id="total_gst">0.00</span></h5>
                            </div>

                            <div class="col-md-4">
                                <h4><b>Grand Total:</b> ₹ <span id="grand_total">0.00</span></h4>
                            </div>
                        </div>

                        <input type="hidden" name="total_amount" id="subtotal_input">
                        <input type="hidden" name="tax_amount" id="gst_input">
                        <input type="hidden" name="grand_total" id="grand_input">
                    </div>

                    {{-- Submit --}}
                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <button class="btn btn-success" type="submit">
                                <i class="ace-icon fa fa-check"></i> Save Purchase
                            </button>

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

<script>
function recalcTotals() {
    let subtotal = 0;
    let total_gst = 0;

    document.querySelectorAll("#itemsTable tbody tr").forEach(function(row) {
        let qty   = parseFloat(row.querySelector(".qty").value || 0);
        let rate  = parseFloat(row.querySelector(".rate").value || 0);
        let tax   = parseFloat(row.querySelector(".tax").value || 0);

        let amount = qty * rate;
        let gstAmt = (amount * tax) / 100;

        row.querySelector(".amount").value = amount.toFixed(2);

        subtotal += amount;
        total_gst += gstAmt;
    });

    let grand = subtotal + total_gst;

    document.getElementById("subtotal").innerHTML = subtotal.toFixed(2);
    document.getElementById("total_gst").innerHTML = total_gst.toFixed(2);
    document.getElementById("grand_total").innerHTML = grand.toFixed(2);

    document.getElementById("subtotal_input").value = subtotal.toFixed(2);
    document.getElementById("gst_input").value = total_gst.toFixed(2);
    document.getElementById("grand_input").value = grand.toFixed(2);
}

document.addEventListener("input", recalcTotals);

document.getElementById("addRowBtn").addEventListener("click", function () {
    let table = document.querySelector("#itemsTable tbody");
    let clone = table.rows[0].cloneNode(true);

    clone.querySelectorAll("input").forEach(i => {
        i.value = "";
        if (i.type === "date") {
            i.setAttribute("min", "{{ date('Y-m-d') }}");
        }
    });

    clone.querySelectorAll("select").forEach(s => s.value = "");

    table.appendChild(clone);
});

document.addEventListener("click", function (e) {
    if (e.target.closest(".removeRow")) {
        let rows = document.querySelectorAll("#itemsTable tbody tr").length;
        if (rows > 1) {
            e.target.closest("tr").remove();
            recalcTotals();
        }
    }
});
</script>

@endsection
