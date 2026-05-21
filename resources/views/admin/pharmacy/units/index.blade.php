@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="active">Medicine Units</li>
    </ul>
</div>
@endsection


@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4 class="page-title">Medicine Units</h4>

    <a href="{{ route('medicine-units.create') }}" class="btn btn-primary btn-sm">
        <i class="ace-icon fa fa-plus"></i> Add Unit
    </a>
</div>

{{-- SUCCESS MESSAGE --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade in">
    <button class="close" data-dismiss="alert">&times;</button>
    <i class="ace-icon fa fa-check"></i> {{ session('success') }}
</div>
@endif

{{-- SEARCH BOX --}}
<form method="GET" action="" class="mb-3" style="max-width:350px;">
    <div class="input-group">
        <input type="text" name="search" value="{{ request('search') }}"
               class="form-control" placeholder="Search units...">
        <span class="input-group-btn">
            <button class="btn btn-info" type="submit">
                <i class="ace-icon fa fa-search"></i>
            </button>
        </span>
    </div>
</form>


<div class="row">
<div class="col-xs-12">

    <div class="table-header">
        Medicine Units List
    </div>

    <div class="table-responsive">

        <table class="table table-striped table-bordered table-hover datatable"
               data-page-length="10" data-disable-last-column="true">

            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th width="140" class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
            @foreach($units as $u)
                <tr>
                    <td>{{ $u->name }}</td>

                    <td>
                        <span class="label label-info">{{ $u->slug }}</span>
                    </td>

                    <td>{{ $u->type ?? '—' }}</td>

                    <td>{{ $u->description ?? '—' }}</td>

                    <td>
                        @if($u->status)
                            <span class="label label-success arrowed">Active</span>
                        @else
                            <span class="label label-danger arrowed-in">Inactive</span>
                        @endif
                    </td>

                    {{-- ACTIONS --}}
                    <td class="text-center">

                        {{-- DESKTOP ACTIONS --}}
                        <div class="hidden-sm hidden-xs action-buttons">

                            {{-- Edit --}}
                            <a class="green" href="{{ route('medicine-units.edit', $u->id) }}">
                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                            </a>

                            {{-- Delete --}}
                            <form action="{{ route('medicine-units.destroy', $u->id) }}"
                                  method="POST" class="d-inline-block"
                                  onsubmit="return confirm('Delete this unit?');">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-link btn-sm red p-0"
                                        style="border:none;background:none;">
                                    <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                </button>
                            </form>

                        </div>

                        {{-- MOBILE DROPDOWN --}}
                        <div class="hidden-md hidden-lg">
                            <div class="inline pos-rel">

                                <button class="btn btn-minier btn-primary dropdown-toggle"
                                        data-toggle="dropdown">
                                    <i class="ace-icon fa fa-cog icon-only bigger-110"></i>
                                </button>

                                <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">

                                    {{-- Edit --}}
                                    <li>
                                        <a href="{{ route('medicine-units.edit', $u->id) }}"
                                           class="tooltip-success" title="Edit">
                                            <span class="green">
                                                <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                            </span>
                                        </a>
                                    </li>

                                    {{-- Delete --}}
                                    <li>
                                        <a href="#"
                                           class="tooltip-error" title="Delete"
                                           onclick="event.preventDefault();
                                               if(confirm('Delete this unit?'))
                                                   this.nextElementSibling.submit();">
                                            <span class="red">
                                                <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                            </span>
                                        </a>

                                        <form action="{{ route('medicine-units.destroy', $u->id) }}"
                                              method="POST" style="display:none;">
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

    <div class="mt-3">
        {{ $units->links() }}
    </div>

</div>
</div>

@endsection
