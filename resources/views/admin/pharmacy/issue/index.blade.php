@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="active">Issued Medicines</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4 class="page-title">Issued Medicines</h4>

    <a href="{{ route('issue-medicines.create') }}" class="btn btn-primary btn-sm">
        <i class="ace-icon fa fa-plus"></i> Issue Medicines
    </a>
</div>

<div class="row">
    <div class="col-xs-12">

        <div class="table-header">
            OPD / IPD Medicine Issue Records
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover datatable" data-page-length="10">

                <thead>
                    <tr>
                        <th>Issue No</th>
                        <th>Date</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Total Items</th>
                        <th>Total Qty</th>
                        <th>Total Amount</th>
                        <th width="120" class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($issues as $i)
                    <tr>
                        {{-- ISSUE NO --}}
                        <td>
                            <span class="label label-info arrowed-right">
                                {{ $i->issue_no }}
                            </span>
                        </td>

                        {{-- ISSUE DATE --}}
                        <td>{{ date('d-m-Y', strtotime($i->issue_date)) }}</td>

                        {{-- PATIENT NAME --}}
                        <td>{{ $i->patient->first_name ?? '' }} {{ $i->patient->last_name ?? '' }}</td>


                        {{-- DOCTOR NAME --}}
                        <td>{{ $i->doctor->name ?? 'N/A' }}</td>

                        {{-- TOTAL ITEMS --}}
                        <td>{{ $i->items->count() }}</td>

                        {{-- TOTAL QUANTITY --}}
                        <td>{{ $i->items->sum('quantity') }}</td>

                        {{-- TOTAL AMOUNT --}}
                        <td>
                            <span class="label label-success arrowed-in-right">
                                ₹ {{ number_format($i->total_amount, 2) }}
                            </span>
                        </td>

                        <td class="text-center">

                            {{-- Desktop Buttons --}}
                            <div class="hidden-sm hidden-xs action-buttons">
                                <a class="blue" href="{{ route('issue-medicines.show', $i->id) }}">
                                    <i class="ace-icon fa fa-eye bigger-130"></i>
                                </a>
                            </div>

                            {{-- Mobile Dropdown --}}
                            <div class="hidden-md hidden-lg">
                                <div class="inline pos-rel">
                                    <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
                                        <i class="ace-icon fa fa-cog icon-only bigger-110"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                        <li>
                                            <a href="{{ route('issue-medicines.show', $i->id) }}" class="tooltip-info" title="View">
                                                <span class="blue">
                                                    <i class="ace-icon fa fa-eye bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        <div class="mt-3">
            {{ $issues->links() }}
        </div>

    </div>
</div>

@endsection
