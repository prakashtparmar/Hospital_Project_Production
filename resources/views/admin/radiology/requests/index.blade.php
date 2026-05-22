@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="active">Radiology Requests</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <h4 class="page-title">Radiology Requests</h4>

    {{-- ✅ CREATE --}}
    @can('radiology-requests.create')
        <a href="{{ route('radiology-requests.create') }}" class="btn btn-primary btn-sm">
            <i class="fa fa-plus"></i> New Request
        </a>
    @endcan
</div>

<div class="table-responsive">
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>#ID</th>
            <th>Patient</th>
            <th>Doctor</th>
            <th>Tests</th>
            <th>Status</th>
            <th>Requested On</th>
            <th width="260">Actions</th>
        </tr>
    </thead>

    <tbody>
    @forelse($requests as $req)
        <tr>
            <td>{{ $req->id }}</td>

            {{-- ✅ PATIENT --}}
            <td>
                {{ $req->patient?->patient_id ?? '---' }}<br>
                <small class="text-muted">
                    {{ $req->patient?->full_name ?? $req->patient?->name ?? 'N/A' }}
                </small>
            </td>

            {{-- ✅ DOCTOR --}}
            <td>
                @if($req->doctor)
                    <strong>{{ $req->doctor->name }}</strong><br>
                    <small class="text-muted">Doctor</small>
                @else
                    <span class="text-muted">—</span>
                @endif
            </td>

            {{-- ✅ TESTS --}}
            <td>
                @foreach($req->items as $item)
                    <span class="label label-grey">
                        {{ $item->test?->name }}
                    </span>
                @endforeach
                @if($req->items->isEmpty())
                    <span class="text-muted">—</span>
                @endif
            </td>

            {{-- ✅ STATUS --}}
            <td>
                @switch($req->status)
                    @case('Pending')
                        <span class="label label-warning">Pending</span>
                        @break

                    @case('In Progress')
                        <span class="label label-info">In Progress</span>
                        @break

                    @case('Completed')
                        <span class="label label-success">Completed</span>
                        @break
                @endswitch
            </td>

            <td>{{ $req->created_at?->format('d M, Y') }}</td>

            {{-- ✅ ACTIONS --}}
            <td>

                {{-- ▶ START TEST --}}
                @can('radiology-tests.start')
                    @if($req->status === 'Pending')
                        <a href="{{ route('radiology-requests.start',$req->id) }}"
                           class="btn btn-xs btn-warning"
                           onclick="return confirm('Start radiology process?');">
                            <i class="fa fa-play"></i> Start
                        </a>
                    @endif
                @endcan

                {{-- 📝 REPORT ENTRY / VIEW --}}
                @canany(['radiology-results.create','radiology-results.edit'])
                    @if(in_array($req->status, ['In Progress','Completed']))
                        <a href="{{ route('radiology-reports.edit',$req->id) }}"
                           class="btn btn-xs btn-success">
                            <i class="fa fa-file-text-o"></i>
                            {{ $req->status === 'Completed' ? 'View Report' : 'Enter Report' }}
                        </a>
                    @endif
                @endcanany

                {{-- 📄 PDF --}}
                @can('radiology-reports.download')
                    @if($req->status === 'Completed')
                        <a href="{{ route('radiology-reports.pdf',$req->id) }}"
                           class="btn btn-xs btn-info">
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </a>
                    @endif
                @endcan

                @can('radiology-requests.delete')
                    <form action="{{ route('radiology-requests.destroy', $req->id) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Delete this radiology request?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-xs btn-danger">
                            <i class="fa fa-trash-o"></i> Delete
                        </button>
                    </form>
                @endcan

            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center text-muted">
                No radiology requests found
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
</div>

<div class="text-center">
    {{ $requests->links() }}
</div>

@endsection
