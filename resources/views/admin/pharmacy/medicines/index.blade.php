@extends('layouts.app')

@section('breadcrumbs')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <ul class="breadcrumb">
            <li><i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="active">Medicine Master</li>
        </ul>
    </div>
@endsection


@section('content')

    <style>
        .medicine-master-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
        }

        .medicine-master-header h4 {
            margin: 0;
            font-weight: 600;
        }

        .medicine-table-wrap {
            border: 1px solid #ddd;
            border-top: 0;
            background: #fff;
        }

        .medicine-table {
            margin-bottom: 0;
            min-width: 1500px;
        }

        .medicine-table th {
            white-space: nowrap;
            background: #f8f8f8;
            color: #555;
            font-size: 12px;
            vertical-align: middle !important;
        }

        .medicine-table td {
            vertical-align: middle !important;
            white-space: nowrap;
        }

        .medicine-name {
            font-weight: 600;
            color: #2b5f8a;
        }

        .medicine-muted {
            color: #777;
        }

        .medicine-money {
            text-align: right;
            font-weight: 600;
        }

        .medicine-stock-low {
            color: #a94442;
            font-weight: 600;
        }

        #medicines-table_wrapper .dataTables_filter {
            display: none;
        }
    </style>

    <div class="page-header medicine-master-header">
        <h4 class="page-title">
            <i class="ace-icon fa fa-medkit"></i> Medicine Master
        </h4>

        <a href="{{ route('medicines.create') }}" class="btn btn-primary btn-sm">
            <i class="ace-icon fa fa-plus"></i> Add Medicine
        </a>
    </div>

    <div class="row">
        <div class="col-xs-12">

            <div class="table-header">
                <i class="ace-icon fa fa-list"></i> Medicine List
            </div>

            <div class="table-responsive medicine-table-wrap">
                <table id="medicines-table"
                       class="table table-striped table-bordered table-hover datatable medicine-table"
                       data-page-length="10">

                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Unit</th>
                            <th>Strength</th>
                            <th>Manufacturer</th>
                            <th>SKU</th>
                            <th>Barcode</th>
                            <th>MRP</th>
                            <th>Purchase</th>
                            <th>Margin %</th>
                            <th>Tax %</th>
                            <th>Stock</th>
                            <th>Reorder Level</th>
                            <th>Batch</th>
                            <th>Expiry</th>
                            <th>Drug Type</th>
                            <th>Storage</th>
                            <th>Status</th>
                            <th width="120" class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($medicines as $m)
                            <tr>
                                <td class="medicine-name">{{ $m->name }}</td>
                                <td>{{ optional($m->category)->name ?? '—' }}</td>
                                <td>{{ optional($m->unit)->name ?? '—' }}</td>
                                <td class="medicine-muted">{{ $m->strength ?? '—' }}</td>
                                <td class="medicine-muted">{{ $m->manufacturer ?? '—' }}</td>
                                <td>{{ $m->sku ?? '—' }}</td>
                                <td>{{ $m->barcode ?? '—' }}</td>

                                <td class="medicine-money">₹{{ number_format($m->mrp, 2) }}</td>
                                <td class="medicine-money">₹{{ number_format($m->purchase_rate, 2) }}</td>
                                <td class="text-right">{{ $m->margin_percent ?? '0' }}%</td>
                                <td class="text-right">{{ $m->tax_percent }}%</td>

                                <td>
                                    <span class="{{ $m->current_stock <= $m->reorder_level ? 'medicine-stock-low' : '' }}">
                                        {{ $m->current_stock }}
                                    </span>

                                    @if($m->current_stock <= $m->reorder_level)
                                        <span class="label label-danger">Low</span>
                                    @endif
                                </td>

                                <td>{{ $m->reorder_level }}</td>

                                <td>{{ $m->batch_no ?? '—' }}</td>

                                <td>
                                    {{ $m->expiry_date ? \Carbon\Carbon::parse($m->expiry_date)->format('d-m-Y') : '—' }}

                                </td>

                                <td>{{ $m->drug_type ?? '—' }}</td>
                                <td>{{ $m->storage_condition ?? '—' }}</td>

                                <td>
                                    @if($m->status)
                                        <span class="label label-success arrowed">Active</span>
                                    @else
                                        <span class="label label-danger arrowed-in">Inactive</span>
                                    @endif
                                </td>

                                {{-- ACTIONS --}}
                                <td class="text-center">

                                    <div class="hidden-sm hidden-xs action-buttons">

                                        <a class="green" href="{{ route('medicines.edit', $m->id) }}">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>

                                        <form action="{{ route('medicines.destroy', $m->id) }}" method="POST"
                                            class="d-inline-block" onsubmit="return confirm('Delete this medicine?');">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-link btn-sm red p-0">
                                                <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                            </button>
                                        </form>

                                    </div>

                                    {{-- MOBILE --}}
                                    <div class="hidden-md hidden-lg">
                                        <div class="inline pos-rel">
                                            <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
                                                <i class="ace-icon fa fa-cog icon-only bigger-110"></i>
                                            </button>

                                            <ul
                                                class="dropdown-menu dropdown-only-icon dropdown-menu-right dropdown-yellow dropdown-caret dropdown-close">

                                                <li>
                                                    <a href="{{ route('medicines.edit', $m->id) }}" class="tooltip-success"
                                                        title="Edit">
                                                        <span class="green">
                                                            <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                        </span>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="#" class="tooltip-error" title="Delete" onclick="event.preventDefault();
                                                        if(confirm('Delete this medicine?'))
                                                            this.nextElementSibling.submit();">
                                                        <span class="red">
                                                            <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                        </span>
                                                    </a>

                                                    <form method="POST" action="{{ route('medicines.destroy', $m->id) }}"
                                                        style="display:none;">
                                                        @csrf @method('DELETE')
                                                    </form>
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
                {{ $medicines->links() }}
            </div>

        </div>
    </div>

@endsection
