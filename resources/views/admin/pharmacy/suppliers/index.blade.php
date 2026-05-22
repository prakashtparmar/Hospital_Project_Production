@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="active">Suppliers</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4 class="page-title">Suppliers</h4>

    <a href="{{ route('suppliers.create') }}" class="btn btn-primary btn-sm">
        <i class="ace-icon fa fa-plus"></i> Add Supplier
    </a>
</div>

{{-- Success Message --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade in">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <i class="ace-icon fa fa-check"></i>
    {{ session('success') }}
</div>
@endif

<div class="row">
    <div class="col-xs-12">

        <div class="table-header">
            Supplier List & Contact Details
        </div>

        <div class="table-responsive">

            <table 
                class="table table-striped table-bordered table-hover datatable"
                data-page-length="10"
                data-disable-last-column="false">

                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Contact Person</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th class="text-center" width="150">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($suppliers as $s)
                    <tr>
                        <td>{{ $s->name }}</td>

                        <td>
                            @if($s->contact_person)
                                <span class="label label-info arrowed-in">{{ $s->contact_person }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                        <td>{{ $s->phone ?? '—' }}</td>

                        <td>{{ $s->email ?? '—' }}</td>

                        {{-- ACTION BUTTONS --}}
                        <td class="text-center">

                            {{-- Desktop Buttons --}}
                            <div class="hidden-sm hidden-xs action-buttons">

                                <a class="green" 
                                   href="{{ route('suppliers.edit', $s->id) }}">
                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                </a>

                                <form action="{{ route('suppliers.destroy', $s->id) }}"
                                      method="POST"
                                      class="d-inline-block"
                                      onsubmit="return confirm('Delete this supplier?');">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-link btn-sm red p-0"
                                            style="border:none;background:none;">
                                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                    </button>
                                </form>

                            </div>

                            {{-- Mobile Dropdown --}}
                            <div class="hidden-md hidden-lg">
                                <div class="inline pos-rel">

                                    <button class="btn btn-minier btn-primary dropdown-toggle"
                                            data-toggle="dropdown">
                                        <i class="ace-icon fa fa-cog icon-only bigger-110"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">

                                        {{-- Edit --}}
                                        <li>
                                            <a href="{{ route('suppliers.edit', $s->id) }}"
                                               class="tooltip-success"
                                               title="Edit">
                                                <span class="green">
                                                    <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>

                                        {{-- Delete --}}
                                        <li>
                                            <a href="#"
                                               title="Delete"
                                               class="tooltip-error"
                                               onclick="event.preventDefault();
                                                        if(confirm('Delete this supplier?'))
                                                        this.nextElementSibling.submit();">
                                                <span class="red">
                                                    <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                </span>
                                            </a>

                                            <form action="{{ route('suppliers.destroy', $s->id) }}"
                                                  method="POST"
                                                  style="display:none;">
                                                @csrf
                                                @method('DELETE')
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

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $suppliers->links() }}
        </div>

    </div>
</div>

@endsection
