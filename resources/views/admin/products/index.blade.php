@extends('layouts.app')

@section('title', 'Health Records')

@push('styles')
<style>
    #simple-table th, #simple-table td { white-space: nowrap; }
    .dataTables_wrapper { overflow-x: auto; width: 100%; }
    table.dataTable { width: 100% !important; }
    .page-content { padding: 10px 20px; }
</style>
@endpush

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li>Health Management</li>
        <li class="active">Manage Health Records</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <h4 class="page-title">
        Manage Health Records
        <small class="text-muted">Employees Health Record List</small>
    </h4>

    @can('product-create')
    <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
        <i class="fa fa-plus"></i> Add Record
    </a>
    @endcan
</div>

<div class="card">
    <div class="table-header">Employees Health Record Management</div>

    <div class="table-responsive">
        <table id="simple-table" class="table table-striped table-bordered table-hover">

            <thead>
                <tr>
                    @can('product-delete')
                    <th class="center"><input type="checkbox" class="ace" id="select-all"></th>
                    @endcan

                    <th>ID</th>
                    <th>Employee No</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>DOB</th>
                    <th>Sex</th>
                    <th>Mobile</th>
                    <th>Company</th>
                    <th>Designation</th>
                    <th>Exam Date</th>
                    <th>Height</th>
                    <th>Weight</th>
                    <th>BP</th>
                    <th>Pulse</th>
                    <th>SpO2</th>
                    <th>Doctor</th>

                    @canany(['product-list','product-edit','product-delete','product-print'])
                    <th class="text-center">Actions</th>
                    @endcanany
                </tr>
            </thead>

            <tbody>
                @foreach ($products as $product)
                <tr>

                    {{-- Checkbox --}}
                    @can('product-delete')
                    <td class="center"><input type="checkbox" class="ace row-checkbox"></td>
                    @endcan

                    {{-- Table Data --}}
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->EmployeeNo }}</td>
                    <td>{{ $product->EmployeeName }}</td>
                    <td>{{ $product->Department }}</td>
                    <td>{{ $product->DateOfBirth }}</td>
                    <td>{{ $product->Sex }}</td>
                    <td>{{ $product->Mobile }}</td>
                    <td>{{ $product->Company }}</td>
                    <td>{{ $product->Designation }}</td>

                    <td>
                        {{ $product->DateOfExamination 
                        ? \Carbon\Carbon::parse($product->DateOfExamination)->format('d M Y')
                        : '' }}
                    </td>

                    <td>{{ $product->Height }}</td>
                    <td>{{ $product->Weight }}</td>
                    <td>{{ $product->BP }}</td>
                    <td>{{ $product->Pulse }}</td>
                    <td>{{ $product->SpO2 }}</td>
                    <td>{{ $product->NameOfDoctor }}</td>

                    {{-- ACTIONS --}}
                    @canany(['product-list','product-edit','product-delete','product-print'])
                    <td class="text-center">

                        <div class="hidden-sm hidden-xs action-buttons">

                            {{-- PDF --}}
                            @can('product-print')
                            <div class="btn-group">
                                <button class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-file-pdf-o"></i> PDF
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a target="_blank" href="{{ route('products.pdf',[$product->id,'mypdf']) }}">Medical Report</a></li>
                                    <li><a target="_blank" href="{{ route('products.pdf',[$product->id,'form32']) }}">Form 32</a></li>
                                    <li><a target="_blank" href="{{ route('products.pdf',[$product->id,'form33']) }}">Form 33</a></li>
                                </ul>
                            </div>
                            @endcan

                            {{-- VIEW --}}
                            @can('product-list')
                            <a class="blue" href="{{ route('products.show', $product->id) }}">
                                <i class="ace-icon fa fa-eye bigger-130"></i>
                            </a>
                            @endcan

                            {{-- EDIT --}}
                            @can('product-edit')
                            <a class="green" href="{{ route('products.edit', $product->id) }}">
                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                            </a>
                            @endcan

                            {{-- DELETE --}}
                            @can('product-delete')
                            <a href="#" class="red delete-btn" data-id="{{ $product->id }}">
                                <i class="ace-icon fa fa-trash-o bigger-130"></i>
                            </a>

                            <form id="delete-form-{{ $product->id }}"
                                  action="{{ route('products.destroy', $product->id) }}"
                                  method="POST" style="display:none;">
                                @csrf @method('DELETE')
                            </form>
                            @endcan

                        </div>

                    </td>
                    @endcanany

                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>

{{-- DELETE CONFIRMATION --}}
<div id="confirm-delete-dialog" class="hide">
    <div class="alert alert-info bigger-110">
        <p>This action cannot be undone.</p>
    </div>
    <p class="bolder center grey">
        <i class="fa fa-exclamation-triangle red"></i>
        Are you sure you want to delete this record?
    </p>
</div>

@endsection




@push('scripts')
<script>
jQuery(function ($) {

    // Initialize DataTable
    var table = $('#simple-table').DataTable({
        pageLength: 10,
        scrollX: true
    });

    // ✅ DELETE WITH SIMPLE CONFIRM ALERT
    $(document).on('click', '.delete-btn', function (e) {
        e.preventDefault();

        let id = $(this).data('id');

        if (confirm("Are you sure you want to delete this record?")) {
            $('#delete-form-' + id).submit();
        }
    });

});
</script>
@endpush
