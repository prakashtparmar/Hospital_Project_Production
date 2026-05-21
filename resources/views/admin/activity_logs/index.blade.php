@extends('layouts.app')

@section('title', 'Activity Logs')

@section('breadcrumbs')
<ul class="breadcrumb">
    <li><i class="ace-icon fa fa-home home-icon"></i>
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="active">Activity Logs</li>
</ul>
@endsection

@section('content')

<div class="page-header">
    <h1 class="text-primary">Activity Logs</h1>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="bg-primary text-white">
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>User (Causer)</th>
                <th>Subject</th>
                <th>Properties</th>
                <th>Date</th>
            </tr>
        </thead>

        <tbody>
            @forelse($logs as $log)
            <tr>
                <td>{{ $log->id }}</td>

                <td>{{ $log->description }}</td>

                <td>
                    {{ $log->causer?->name ?? 'System' }}
                </td>

                <td>
                    {{ $log->subject ? class_basename($log->subject_type) : '-' }}
                    {{ $log->subject_id ? '(ID: '.$log->subject_id.')' : '' }}
                </td>

                <td style="max-width: 300px; overflow: auto;">
                    <pre>{{ json_encode($log->properties, JSON_PRETTY_PRINT) }}</pre>
                </td>

                <td>{{ $log->created_at->format('d M Y h:i A') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No logs found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $logs->links() }}
</div>

@endsection
