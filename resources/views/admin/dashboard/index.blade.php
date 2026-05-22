@extends('layouts.app')
@section('title', 'Dashboard')

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="#">Home</a>
        </li>
        <li class="active">Dashboard</li>
    </ul>
@endsection

@section('content')
    @php
        $monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $monthlyOpdData = collect(range(1, 12))->map(fn ($month) => (int) ($monthly_opd[$month] ?? 0))->values();
        $monthlyIpdData = collect(range(1, 12))->map(fn ($month) => (int) ($monthly_ipd[$month] ?? 0))->values();
        $monthlyRevenueData = collect(range(1, 12))->map(fn ($month) => (float) ($monthly_revenue[$month] ?? 0))->values();
        $bedPercent = $total_beds > 0 ? min(100, max(0, ($occupied_beds / $total_beds) * 100)) : 0;
    @endphp

    <style>
        .dashboard-table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        .dashboard-chart {
            width: 100%;
            height: 220px;
        }

        @media (min-width: 992px) {
            .modal-xl {
                width: 1100px;
            }
        }
    </style>

    <div class="page-header d-flex justify-content-between">
        <h1 class="text-primary">
            Hospital Dashboard
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Real-Time Overview
            </small>
        </h1>
    </div>

    {{-- ======================== TOP SUMMARY KPIs ======================== --}}
    <div class="row">

        {{-- OPD --}}
        <div class="col-sm-3">
            <div class="infobox infobox-blue">
                <div class="infobox-icon"><i class="fa fa-stethoscope"></i></div>
                <div class="infobox-data">
                    <span class="infobox-data-number">{{ $opd_today }}</span>
                    <div class="infobox-content">OPD Today</div>

                    <button class="btn btn-info btn-xs mt-1" data-toggle="modal" data-target="#opdModal">
                        View Details
                    </button>
                </div>
            </div>
        </div>

        {{-- IPD --}}
        <div class="col-sm-3">
            <div class="infobox infobox-red">
                <div class="infobox-icon"><i class="fa fa-bed"></i></div>
                <div class="infobox-data">
                    <span class="infobox-data-number">{{ $ipd_today }}</span>
                    <div class="infobox-content">IPD Admissions</div>

                    <button class="btn btn-danger btn-xs mt-1" data-toggle="modal" data-target="#ipdModal">
                        View Details
                    </button>
                </div>
            </div>
        </div>

        {{-- Appointments --}}
        <div class="col-sm-3">
            <div class="infobox infobox-green">
                <div class="infobox-icon"><i class="fa fa-calendar"></i></div>
                <div class="infobox-data">
                    <span class="infobox-data-number">{{ $appointments_today }}</span>
                    <div class="infobox-content">Appointments</div>

                    <button class="btn btn-success btn-xs mt-1" data-toggle="modal" data-target="#appointmentModal">
                        View Details
                    </button>
                </div>
            </div>
        </div>

        {{-- Patients --}}
        <div class="col-sm-3">
            <div class="infobox infobox-orange2">
                <div class="infobox-icon"><i class="fa fa-users"></i></div>
                <div class="infobox-data">
                    <span class="infobox-data-number">{{ $total_patients }}</span>
                    <div class="infobox-content">Total Patients</div>
                </div>
            </div>
        </div>

    </div>

    <div class="space-8"></div>

    {{-- =================== PHARMACY / LAB / RADIOLOGY =================== --}}
    <div class="row">

        {{-- Pharmacy --}}
        <div class="col-sm-4">
            <div class="widget-box">
                <div class="widget-header bg-warning">
                    <h5 class="widget-title text-white"><i class="fa fa-medkit"></i> Pharmacy</h5>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <p>Total Medicines: <b>{{ $total_medicines }}</b></p>
                        <p>
                            Low Stock:
                            <b class="text-danger">{{ $low_stock }}</b>
                            <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#stockModal">
                                View
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Lab --}}
        <div class="col-sm-4">
            <div class="widget-box">
                <div class="widget-header bg-primary">
                    <h5 class="widget-title text-white"><i class="fa fa-flask"></i> Lab Diagnostics</h5>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <p>
                            Pending Lab Requests:
                            <b class="text-danger">{{ $pending_lab }}</b>
                            <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#labModal">
                                View
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Radiology --}}
        <div class="col-sm-4">
            <div class="widget-box">
                <div class="widget-header bg-purple">
                    <h5 class="widget-title text-white"><i class="fa fa-film"></i> Radiology</h5>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <p>
                            Pending Radiology:
                            <b class="text-danger">{{ $pending_radio }}</b>
                            <button class="btn btn-purple btn-xs" data-toggle="modal" data-target="#radioModal">
                                View
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="space-8"></div>

    {{-- ======================== BED MANAGEMENT ======================== --}}
    <div class="row">

        <div class="col-sm-4">
            <div class="widget-box">
                <div class="widget-header bg-dark">
                    <h5 class="widget-title text-white"><i class="fa fa-hospital-o"></i> Bed Management</h5>
                </div>
                <div class="widget-body">
                    <div class="widget-main">

                        <p>Total Wards: <b>{{ $total_wards }}</b></p>
                        <p>Total Rooms: <b>{{ $total_rooms }}</b></p>
                        <p>Total Beds: <b>{{ $total_beds }}</b></p>

                        <p>
                            Occupied Beds:
                            <b class="text-danger">{{ $occupied_beds }}</b> /
                            <b>{{ $total_beds }}</b>
                        </p>

                        <div class="progress">
                            <div class="progress-bar progress-bar-danger" style="width: {{ $bedPercent }}%">
                                {{ round($bedPercent) }}%
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- Revenue --}}
        <div class="col-sm-4">
            <div class="widget-box">
                <div class="widget-header bg-success">
                    <h5 class="widget-title text-white"><i class="fa fa-inr"></i> Revenue</h5>
                </div>
                <div class="widget-body">
                    <div class="widget-main text-center">
                        <h2 class="text-success"><b>₹{{ number_format($today_revenue, 2) }}</b></h2>
                        <p class="text-muted">Today's Revenue</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Doctors --}}
        <div class="col-sm-4">
            <div class="widget-box">
                <div class="widget-header bg-info">
                    <h5 class="widget-title text-white"><i class="fa fa-user-md"></i> Doctors</h5>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <p>Total Doctors: <b>{{ $available_doctors }}</b></p>
                        <p>Doctors On Duty: <b class="text-success">{{ $on_duty_doctors }}</b></p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="space-10"></div>

    {{-- ======================== TOP DOCTORS ======================== --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="widget-box">
                <div class="widget-header bg-primary">
                    <h4 class="widget-title text-white"><i class="fa fa-star"></i> Top OPD Doctors Today</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main">

                        @if($top_doctors->count() == 0)
                            <p class="text-muted">No OPD visits today.</p>
                        @else
                            <div class="dashboard-table-wrap">
                                <table class="table table-bordered table-striped">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Doctor</th>
                                            <th>Patients Seen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($top_doctors as $doc)
                                            <tr>
                                                <td>{{ optional($doc->doctor)->name ?? 'N/A' }}</td>
                                                <td><b>{{ $doc->total }}</b></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="space-12"></div>

    {{-- ======================== CHARTS ======================== --}}
    <div class="row">

        <div class="col-sm-6">
            <div class="widget-box">
                <div class="widget-header bg-info">
                    <h5 class="widget-title text-white"><i class="fa fa-line-chart"></i> OPD vs IPD (Monthly)</h5>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <div id="opdIpdChart" class="dashboard-chart"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="widget-box">
                <div class="widget-header bg-success">
                    <h5 class="widget-title text-white"><i class="fa fa-bar-chart"></i> Revenue Trend (Monthly)</h5>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <div id="revenueChart" class="dashboard-chart"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    {{-- ================================================================ --}}
    {{-- ======================== MODALS SECTION ========================= --}}
    {{-- ================================================================ --}}

    {{-- -------- REUSABLE TABLE HEADER STYLE -------- --}}
    @php
        $thead = 'class="bg-dark text-white"';
    @endphp


    {{-- ======================= APPOINTMENT MODAL ======================= --}}
    <div id="appointmentModal" class="modal fade">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header bg-success text-white">
                    <h4 class="modal-title">Today's Appointments – Doctor Wise</h4>
                    <button class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    @forelse($today_appointments_grouped as $doctorId => $apps)

                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h5 class="m-0">
                                    <i class="fa fa-user-md text-success"></i>
                                    {{ optional($apps->first()->doctor)->name ?? 'Unknown Doctor' }}
                                    <span class="badge badge-success ml-2">
                                        {{ $apps->count() }} Appointments
                                    </span>
                                </h5>
                            </div>

                            <div class="card-body p-2">
                                <table class="table table-bordered table-sm mb-0">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>Token</th>
                                            <th>Patient</th>
                                            <th>Time</th>
                                            <th>Status</th>
                                            <th>Reason</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($apps as $a)
                                            <tr>
                                                <td>{{ $a->token_no }}</td>
                                                <td>{{ optional($a->patient)->full_name ?? 'N/A' }}</td>
                                                <td>{{ $a->appointment_time }}</td>
                                                <td>{{ ucfirst($a->status) }}</td>
                                                <td>{{ $a->reason }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    @empty
                        <p class="text-muted mb-0">No appointments found for today.</p>
                    @endforelse

                </div>

            </div>
        </div>
    </div>


    {{-- ======================= OPD MODAL ======================= --}}
    <div id="opdModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header bg-info text-white">
                    <h4 class="modal-title">Today's OPD Visits</h4>
                    <button class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="dashboard-table-wrap">
                        <table class="table table-bordered table-striped table-sm">
                            <thead {!! $thead !!}>
                                <tr>
                                    <th>ID</th>
                                    <th>Patient</th>
                                    <th>Doctor</th>
                                    <th>Visit Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($today_opd_visits as $o)
                                    <tr>
                                        <td>{{ $o->id }}</td>
                                        <td>{{ optional($o->patient)->full_name ?? 'N/A' }}</td>
                                        <td>{{ optional($o->doctor)->name ?? 'N/A' }}</td>
                                        <td>{{ $o->visit_date }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No OPD visits found for today.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>


    {{-- ======================= IPD MODAL ======================= --}}
    <div id="ipdModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header bg-danger text-white">
                    <h4 class="modal-title">Today's IPD Admissions</h4>
                    <button class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="dashboard-table-wrap">
                        <table class="table table-bordered table-striped table-sm">
                            <thead {!! $thead !!}>
                                <tr>
                                    <th>ID</th>
                                    <th>Patient</th>
                                    <th>Doctor</th>
                                    <th>Ward</th>
                                    <th>Room</th>
                                    <th>Bed</th>
                                    <th>Admission Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($today_ipd_admissions as $i)
                                    <tr>
                                        <td>{{ $i->id }}</td>
                                        <td>{{ optional($i->patient)->full_name ?? 'N/A' }}</td>
                                        <td>{{ optional($i->doctor)->name ?? 'N/A' }}</td>
                                        <td>{{ optional($i->ward)->name ?? '-' }}</td>
                                        <td>{{ optional($i->room)->room_no ?? '-' }}</td>
                                        <td>{{ optional($i->bed)->bed_no ?? '-' }}</td>
                                        <td>{{ $i->admission_date }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No IPD admissions found for today.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>


    {{-- ======================= LOW STOCK MEDICINES ======================= --}}
    <div id="stockModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header bg-warning text-white">
                    <h4 class="modal-title">Low Stock Medicines</h4>
                    <button class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="dashboard-table-wrap">
                        <table class="table table-bordered table-striped table-sm">
                            <thead {!! $thead !!}>
                                <tr>
                                    <th>Name</th>
                                    <th>Current Stock</th>
                                    <th>Reorder Level</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($today_low_stock_medicines as $m)
                                    <tr>
                                        <td>{{ $m->name }}</td>
                                        <td>{{ $m->current_stock }}</td>
                                        <td>{{ $m->reorder_level }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No low stock medicines found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>


    {{-- ======================= LAB PENDING ======================= --}}
    <div id="labModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title">Pending Lab Requests</h4>
                    <button class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="dashboard-table-wrap">
                        <table class="table table-bordered table-striped table-sm">
                            <thead {!! $thead !!}>
                                <tr>
                                    <th>ID</th>
                                    <th>Patient</th>
                                    <th>Tests</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($today_pending_lab as $l)
                                    <tr>
                                        <td>{{ $l->id }}</td>
                                        <td>{{ optional($l->patient)->full_name ?? 'N/A' }}</td>
                                        <td>
                                            {{ $l->items->pluck('test.name')->filter()->implode(', ') ?: 'N/A' }}
                                        </td>
                                        <td>{{ ucfirst($l->status) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No pending lab requests found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>


    {{-- ======================= RADIOLOGY PENDING ======================= --}}
    <div id="radioModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header bg-purple text-white">
                    <h4 class="modal-title">Pending Radiology Requests</h4>
                    <button class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="dashboard-table-wrap">
                        <table class="table table-bordered table-striped table-sm">
                            <thead {!! $thead !!}>
                                <tr>
                                    <th>ID</th>
                                    <th>Patient</th>
                                    <th>Tests</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($today_pending_radio as $r)
                                    <tr>
                                        <td>{{ $r->id }}</td>
                                        <td>{{ optional($r->patient)->full_name ?? 'N/A' }}</td>
                                        <td>
                                            {{ $r->items->pluck('test.name')->filter()->implode(', ') ?: 'N/A' }}
                                        </td>
                                        <td>{{ ucfirst($r->status) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No pending radiology requests found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('ace/assets/js/jquery.flot.min.js') }}"></script>
    <script src="{{ asset('ace/assets/js/jquery.flot.resize.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof $ === 'undefined' || typeof $.plot === 'undefined') {
                return;
            }

            const monthLabels = @json($monthLabels);
            const monthlyOpdData = @json($monthlyOpdData);
            const monthlyIpdData = @json($monthlyIpdData);
            const monthlyRevenueData = @json($monthlyRevenueData);
            const monthTicks = monthLabels.map(function (label, index) {
                return [index + 1, label];
            });
            const toSeries = function (values) {
                return values.map(function (value, index) {
                    return [index + 1, Number(value) || 0];
                });
            };

            const opdIpdChart = $('#opdIpdChart');
            if (opdIpdChart.length) {
                $.plot(opdIpdChart, [
                    {
                        label: 'OPD',
                        data: toSeries(monthlyOpdData),
                        color: '#6fb3e0',
                        lines: { show: true, fill: true, fillColor: 'rgba(111, 179, 224, 0.15)' },
                        points: { show: true }
                    },
                    {
                        label: 'IPD',
                        data: toSeries(monthlyIpdData),
                        color: '#d15b47',
                        lines: { show: true, fill: true, fillColor: 'rgba(209, 91, 71, 0.12)' },
                        points: { show: true }
                    }
                ], {
                    xaxis: { ticks: monthTicks },
                    yaxis: { min: 0, tickDecimals: 0 },
                    grid: { hoverable: true, borderWidth: 1, borderColor: '#ddd' },
                    legend: { position: 'ne' }
                });
            }

            const revenueChart = $('#revenueChart');
            if (revenueChart.length) {
                $.plot(revenueChart, [
                    {
                        label: 'Revenue',
                        data: toSeries(monthlyRevenueData),
                        color: '#87b87f',
                        bars: { show: true, barWidth: 0.55, align: 'center', fill: true, fillColor: '#87b87f' }
                    }
                ], {
                    xaxis: { ticks: monthTicks },
                    yaxis: { min: 0 },
                    grid: { hoverable: true, borderWidth: 1, borderColor: '#ddd' },
                    legend: { show: false }
                });
            }
        });
    </script>
@endpush
