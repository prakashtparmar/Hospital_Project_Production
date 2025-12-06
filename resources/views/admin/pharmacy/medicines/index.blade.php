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

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4 class="page-title">Medicine Master</h4>

    <a href="{{ route('medicines.create') }}" class="btn btn-primary btn-sm">
        <i class="ace-icon fa fa-plus"></i> Add Medicine
    </a>
</div>

{{-- SEARCH --}}
<form method="GET" class="mb-3" style="max-width:450px;">
    <div class="input-group">
        <input type="text" name="search" value="{{ request('search') }}"
               class="form-control" placeholder="Search by name, SKU, barcode...">
        <span class="input-group-btn">
            <button class="btn btn-info" type="submit">
                <i class="ace-icon fa fa-search"></i>
            </button>
        </span>
    </div>
</form>

<div class="row">
<div class="col-xs-12">

    <div class="table-header">Medicine List</div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover datatable"
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
                    <td>{{ $m->name }}</td>
                    <td>{{ $m->category->name }}</td>
                    <td>{{ $m->unit->name }}</td>
                    <td>{{ $m->strength ?? '—' }}</td>
                    <td>{{ $m->manufacturer ?? '—' }}</td>
                    <td>{{ $m->sku }}</td>
                    <td>{{ $m->barcode ?? '—' }}</td>

                    <td>₹{{ number_format($m->mrp,2) }}</td>
                    <td>₹{{ number_format($m->purchase_rate,2) }}</td>
                    <td>{{ $m->margin_percent ?? '0' }}%</td>
                    <td>{{ $m->tax_percent }}%</td>

                    <td>{{ $m->current_stock }}</td>
                    <td>{{ $m->reorder_level }}</td>

                    <td>{{ $m->batch_no ?? '—' }}</td>

                    <td>
                        {{ $m->expiry_date ? \Carbon\Carbon::parse($m->expiry_date)->format('d-m-Y') : '—' }}

                    </td>

                    <td>{{ $m->drug_type }}</td>
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

                            <form action="{{ route('medicines.destroy', $m->id) }}"
                                  method="POST" class="d-inline-block"
                                  onsubmit="return confirm('Delete this medicine?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-link btn-sm red p-0">
                                    <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                </button>
                            </form>

                        </div>

                        {{-- MOBILE --}}
                        <div class="hidden-md hidden-lg">
                            <div class="inline pos-rel">
                                <button class="btn btn-minier btn-primary dropdown-toggle"
                                        data-toggle="dropdown">
                                    <i class="ace-icon fa fa-cog icon-only bigger-110"></i>
                                </button>

                                <ul class="dropdown-menu dropdown-only-icon dropdown-menu-right dropdown-yellow dropdown-caret dropdown-close">

                                    <li>
                                        <a href="{{ route('medicines.edit', $m->id) }}"
                                           class="tooltip-success" title="Edit">
                                            <span class="green">
                                                <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                            </span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#" class="tooltip-error" title="Delete"
                                           onclick="event.preventDefault();
                                                if(confirm('Delete this medicine?'))
                                                    this.nextElementSibling.submit();">
                                            <span class="red">
                                                <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                            </span>
                                        </a>

                                        <form method="POST"
                                              action="{{ route('medicines.destroy', $m->id) }}"
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
