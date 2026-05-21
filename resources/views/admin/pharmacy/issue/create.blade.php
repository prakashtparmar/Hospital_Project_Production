@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>

        <li>
            <a href="{{ route('issue-medicines.index') }}">Issue Medicines</a>
        </li>

        <li class="active">Create Issue</li>
    </ul>
</div>
@endsection


@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4 class="page-title">Issue Medicines</h4>

    <a href="{{ route('issue-medicines.index') }}" class="btn btn-default btn-sm">
        <i class="fa fa-arrow-left"></i> Back
    </a>
</div>


{{-- SUCCESS --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade in">
    <button class="close" data-dismiss="alert">×</button>
    <i class="fa fa-check"></i> {{ session('success') }}
</div>
@endif


{{-- VALIDATION ERRORS --}}
@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade in">
    <button class="close">×</button>
    <strong>Error:</strong>
    <ul>
        @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
        @endforeach
    </ul>
</div>
@endif



<div class="card">
    <div class="card-header"><strong>Issue Medicine Form</strong></div>

    <div class="card-body">

       <form action="{{ route('issue-medicines.store') }}" method="POST">
            @csrf

            <div class="row">

                {{-- LEFT COLUMN --}}
                <div class="col-md-6">

                    {{-- Patient --}}
                    <div class="form-group">
                        <label><strong>Patient *</strong></label>
                        <select name="patient_id" class="form-control select2" required>
                            <option value="">Select Patient...</option>
                            @foreach ($patients as $p)
                            <option value="{{ $p->id }}">
                                {{ $p->first_name }} {{ $p->last_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Doctor --}}
                    <div class="form-group">
                        <label><strong>Doctor (Optional)</strong></label>
                        <select name="doctor_id" class="form-control select2">
                            <option value="">Select Doctor...</option>
                            @foreach ($doctors as $d)
                            <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Issue Date --}}
                    <div class="form-group">
                        <label><strong>Issue Date *</strong></label>
                        <input type="date" name="issue_date" class="form-control"
                            value="{{ date('Y-m-d') }}" required>
                    </div>

                </div>


                {{-- RIGHT COLUMN --}}
                <div class="col-md-6">
                    <div class="alert alert-info">
                        <strong>Note:</strong> Stock deduction follows FEFO (First Expiry First Out)
                    </div>
                </div>

            </div>




            <hr>

            <h4 class="header blue">Issue Items</h4>

            <table class="table table-bordered" id="itemsTable">
                <thead>
                    <tr>
                        <th width="30%">Medicine</th>
                        <th width="10%">Current</th>
                        <th width="10%">Qty</th>
                        <th width="15%">Rate</th>
                        <th width="15%">Amount</th>
                        <th width="5%"></th>
                    </tr>
                </thead>

                <tbody>

                    <tr>

                        {{-- Medicine --}}
                        <td>
                            <select name="medicine_id[]" class="form-control medicine-select" required>
                                <option value="">Select</option>
                                @foreach($medicines as $m)
                                <option value="{{ $m->id }}" data-rate="{{ $m->mrp }}">
                                    {{ $m->name }}
                                </option>
                                @endforeach
                            </select>
                        </td>

                        {{-- Current Stock --}}
                        <td>
                            <input type="text" class="form-control stock" name="current_stock[]" 
                                   value="0" readonly style="background:#eef;">
                        </td>

                        {{-- Quantity --}}
                        <td>
                            <input type="number" class="form-control qty" name="quantity[]" min="1" required>
                        </td>

                        {{-- Rate --}}
                        <td>
                            <input type="number" class="form-control rate" name="rate[]" readonly>
                        </td>

                        {{-- Amount --}}
                        <td>
                            <input type="number" class="form-control amount" name="amount[]" readonly>
                        </td>

                        {{-- Remove --}}
                        <td>
                            <button type="button" class="btn btn-danger btn-sm removeRow">X</button>
                        </td>

                    </tr>

                </tbody>
            </table>

            <button type="button" class="btn btn-secondary btn-sm" id="addRowBtn">
                <i class="fa fa-plus"></i> Add Item
            </button>


            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fa fa-check"></i> Issue Medicine
                </button>
            </div>

        </form>
    </div>
</div>




{{-- JS --}}
<script>
/* Utility: Color stock based on value */
function updateStockColor(stockInput) {
    let val = Number(stockInput.value);

    if (val <= 0) {
        stockInput.style.background = "#ffcccc";   // red
        stockInput.style.color = "#a00";
    } else if (val <= 50) {
        stockInput.style.background = "#ffe5b3";   // orange
        stockInput.style.color = "#b36b00";
    } else {
        stockInput.style.background = "#d9ffd9";   // green
        stockInput.style.color = "#006600";
    }
}

/* -------------------------------------------
   1️⃣ Fetch Current Stock (AJAX) + Reset Qty & Amount
----------------------------------------------*/
document.addEventListener("change", function (e) {
    if (e.target.classList.contains("medicine-select")) {

        let row = e.target.closest("tr");
        let medicineId = e.target.value;
        let selected = e.target.selectedOptions[0];
        let rate = selected ? selected.dataset.rate : 0;

        // Set rate
        row.querySelector(".rate").value = rate;

        // Reset qty and amount when medicine is changed
        row.querySelector(".qty").value = 0;
        row.querySelector(".amount").value = 0;

        let stockField = row.querySelector(".stock");

        if (!medicineId) {
            stockField.value = 0;
            updateStockColor(stockField);
            return;
        }

        // Fetch stock
        fetch(`/medicine-stock/${medicineId}`)
            .then(res => res.json())
            .then(data => {
                stockField.value = data.stock;
                updateStockColor(stockField);
            });
    }
});


/* -------------------------------------------
   2️⃣ Auto Calculate Amount + Prevent Qty > Stock
----------------------------------------------*/
document.addEventListener("input", function (e) {

    document.querySelectorAll("#itemsTable tbody tr").forEach(function (row) {

        let qtyInput = row.querySelector(".qty");
        let qty = Number(qtyInput.value || 0);
        let rate = Number(row.querySelector(".rate").value || 0);
        let stock = Number(row.querySelector(".stock").value || 0);

        // Auto-block: prevent qty > stock
        if (qty > stock) {
            qtyInput.value = stock;
            qty = stock;
        }

        row.querySelector(".amount").value = qty * rate;
    });
});


/* -------------------------------------------
   3️⃣ Add Row
----------------------------------------------*/
document.getElementById("addRowBtn").addEventListener("click", function () {

    let table = document.querySelector("#itemsTable tbody");
    let newRow = table.rows[0].cloneNode(true);

    // Reset inputs
    newRow.querySelectorAll("input").forEach(i => i.value = "");
    newRow.querySelector(".qty").value = 0;
    newRow.querySelector(".amount").value = 0;
    newRow.querySelector(".stock").value = 0;
    updateStockColor(newRow.querySelector(".stock"));

    // Reset select
    newRow.querySelector(".medicine-select").value = "";

    table.appendChild(newRow);
});


/* -------------------------------------------
   4️⃣ Remove Row
----------------------------------------------*/
document.addEventListener("click", function (e) {
    if (e.target.classList.contains("removeRow")) {
        let rows = document.querySelectorAll("#itemsTable tbody tr").length;
        if (rows > 1) e.target.closest("tr").remove();
    }
});
</script>
@endsection
