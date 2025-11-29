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

@can('dashboard.view')

<div class="page-header">
    <h1>
        Dashboard
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Overview
        </small>
    </h1>
</div>

<div class="row">

    {{-- Today Summary Widgets --}}
    <div class="col-sm-12">
        <div class="row">

            @can('opd.view')
            <div class="col-sm-3">
                <div class="infobox infobox-blue">
                    <div class="infobox-icon">
                        <i class="ace-icon fa fa-stethoscope"></i>
                    </div>
                    <div class="infobox-data">
                        <span class="infobox-data-number">{{ $opd_today }}</span>
                        <div class="infobox-content">OPD Visits</div>
                    </div>
                </div>
            </div>
            @endcan

            @can('ipd.view')
            <div class="col-sm-3">
                <div class="infobox infobox-red">
                    <div class="infobox-icon">
                        <i class="ace-icon fa fa-bed"></i>
                    </div>
                    <div class="infobox-data">
                        <span class="infobox-data-number">{{ $ipd_today }}</span>
                        <div class="infobox-content">IPD Admissions</div>
                    </div>
                </div>
            </div>
            @endcan

            @can('appointments.view')
            <div class="col-sm-3">
                <div class="infobox infobox-green">
                    <div class="infobox-icon">
                        <i class="ace-icon fa fa-calendar"></i>
                    </div>
                    <div class="infobox-data">
                        <span class="infobox-data-number">{{ $appointments_today }}</span>
                        <div class="infobox-content">Appointments Today</div>
                    </div>
                </div>
            </div>
            @endcan

            @can('patients.view')
            <div class="col-sm-3">
                <div class="infobox infobox-orange2">
                    <div class="infobox-icon">
                        <i class="ace-icon fa fa-users"></i>
                    </div>
                    <div class="infobox-data">
                        <span class="infobox-data-number">{{ $total_patients }}</span>
                        <div class="infobox-content">Total Patients</div>
                    </div>
                </div>
            </div>
            @endcan

        </div>

        <div class="space-6"></div>

        <div class="row">

            @can('billing.view')
            <div class="col-sm-3">
                <div class="infobox infobox-purple">
                    <div class="infobox-icon">
                        <i class="ace-icon fa fa-inr"></i>
                    </div>
                    <div class="infobox-data">
                        <span class="infobox-data-number">{{ $today_revenue }}</span>
                        <div class="infobox-content">Today's Revenue</div>
                    </div>
                </div>
            </div>
            @endcan

            @can('pharmacy.view')
            <div class="col-sm-3">
                <div class="infobox infobox-brown">
                    <div class="infobox-icon">
                        <i class="ace-icon fa fa-medkit"></i>
                    </div>
                    <div class="infobox-data">
                        <span class="infobox-data-number">{{ $low_stock }}</span>
                        <div class="infobox-content">Low Stock Medicines</div>
                    </div>
                </div>
            </div>
            @endcan

            @can('lab.view')
            <div class="col-sm-3">
                <div class="infobox infobox-dark">
                    <div class="infobox-icon">
                        <i class="ace-icon fa fa-flask"></i>
                    </div>
                    <div class="infobox-data">
                        <span class="infobox-data-number">{{ $pending_lab }}</span>
                        <div class="infobox-content">Pending Lab Requests</div>
                    </div>
                </div>
            </div>
            @endcan

            @can('radiology.view')
            <div class="col-sm-3">
                <div class="infobox infobox-blue2">
                    <div class="infobox-icon">
                        <i class="ace-icon fa fa-x-ray"></i>
                    </div>
                    <div class="infobox-data">
                        <span class="infobox-data-number">{{ $pending_radio }}</span>
                        <div class="infobox-content">Pending Radiology</div>
                    </div>
                </div>
            </div>
            @endcan

        </div>
    </div>

    {{-- Graph --}}
    @can('charts.view')
    <div class="col-sm-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">OPD vs IPD Visits</h4>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <canvas id="opdIpdChart" height="120"></canvas>
                </div>
            </div>
        </div>
    </div>
    @endcan

</div>

{{-- Charts --}}
@can('charts.view')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    fetch("{{ url('admin/dashboard/api/opd-ipd') }}")
        .then(res => res.json())
        .then(data => {
            new Chart(document.getElementById('opdIpdChart'), {
                type: 'line',
                data: {
                    labels: data.months,
                    datasets: [
                        {
                            label: 'OPD',
                            data: data.opd,
                            borderColor: '#1e90ff',
                            backgroundColor: 'transparent',
                            tension: 0.4
                        },
                        {
                            label: 'IPD',
                            data: data.ipd,
                            borderColor: '#ff5733',
                            backgroundColor: 'transparent',
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        });
</script>
@endcan

@else
<div class="alert alert-danger">
    <i class="fa fa-lock"></i> You do not have permission to view the dashboard.
</div>
@endcan

@endsection
