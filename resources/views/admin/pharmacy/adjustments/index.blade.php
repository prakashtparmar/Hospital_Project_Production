@extends('layouts.app')

@section('content')

<div class="page-header">
    <h1>
        <i class="fa fa-refresh"></i> Stock Adjustments

        @can('stock-adjustments.create')
            <a href="{{ route('stock-adjustments.create') }}" class="btn btn-primary btn-sm pull-right">
                <i class="fa fa-plus"></i> New Adjustment
            </a>
        @endcan
    </h1>
</div>

<div class="row">
    <div class="col-xs-12">

        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Adjustment History</h4>
            </div>

            <div class="widget-body">
                <div class="widget-main no-padding">

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Medicine</th>
                                <th>Adjustment Qty</th>
                                <th>Remarks</th>
                                <th>Date</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($adjustments as $adj)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $adj->medicine->name ?? '—' }}</td>
                                    <td>
                                        <span class="badge {{ $adj->adjust_quantity >= 0 ? 'badge-success' : 'badge-danger' }}">
                                            {{ $adj->adjust_quantity }}
                                        </span>
                                    </td>
                                    <td>{{ $adj->reason ?? '—' }}</td>

                                    <td>{{ $adj->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No adjustments found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="text-center">
                        {{ $adjustments->links() }}
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

@endsection
