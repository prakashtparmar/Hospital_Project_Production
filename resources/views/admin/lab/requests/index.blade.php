@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="active">Lab Requests</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <h4 class="page-title">Lab Test Requests</h4>

    {{-- ✅ PERMISSION FIX --}}
    @can('lab-requests.create')
        <a href="{{ route('lab-requests.create') }}" class="btn btn-primary btn-sm">
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
            <th>Status</th>
            <th>Requested On</th>
            <th width="240">Actions</th>
        </tr>
    </thead>

    <tbody>
    @forelse($requests as $req)
        <tr>
            <td>{{ $req->id }}</td>

            {{-- PATIENT --}}
            <td>
                {{ $req->patient->patient_id ?? '---' }}<br>
                <small class="text-muted">
                    {{ $req->patient->first_name ?? '' }}
                    {{ $req->patient->last_name ?? '' }}
                </small>
            </td>

            {{-- DOCTOR --}}
            <td>
                @if($req->doctor)
                    <strong>{{ $req->doctor->name }}</strong><br>
                    <small class="text-muted">Doctor</small>
                @else
                    <span class="text-muted">—</span>
                @endif
            </td>

            {{-- STATUS --}}
            <td>
                @switch($req->status)
                    @case('Pending')
                        <span class="label label-warning">Pending</span>
                        @break
                    @case('Sample Collected')
                        <span class="label label-info">Sample Collected</span>
                        @break
                    @case('Completed')
                        <span class="label label-success">Completed</span>
                        @break
                @endswitch
            </td>

            <td>{{ $req->created_at->format('d M, Y') }}</td>

            {{-- ACTIONS --}}
            <td>

                {{-- ✅ COLLECT SAMPLE --}}
                @can('lab-samples.collect')
                    @if($req->status === 'Pending')
                        <a href="{{ route('lab-requests.collect', $req->id) }}"
                           class="btn btn-xs btn-warning"
                           onclick="return confirm('Mark sample as collected?');">
                            <i class="fa fa-eyedropper"></i> Collect
                        </a>
                    @endif
                @endcan

                {{-- ✅ ENTER / VIEW RESULTS --}}
                @canany(['lab-results.create','lab-results.edit','lab-results.view'])
                    @if(in_array($req->status, ['Sample Collected','Completed']))
                        <a href="{{ route('lab-results.edit', $req->id) }}"
                           class="btn btn-xs btn-success">
                            <i class="fa fa-flask"></i>
                            {{ $req->status === 'Completed' ? 'View Results' : 'Enter Results' }}
                        </a>
                    @endif
                @endcanany

                {{-- ✅ PDF --}}
                @can('lab-reports.download')
                    @if($req->status === 'Completed')
                        <a href="{{ route('lab-results.pdf', $req->id) }}"
                           class="btn btn-xs btn-info">
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </a>
                    @endif
                @endcan

            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center text-muted">
                No lab requests found
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
