@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-body text-center">
        <h3>Welcome to the Admin Dashboard</h3>
        <p>You are logged in and viewing the dashboard.</p>

        <!-- Your Summary Stats Section -->
        <div class="summary-stats mt-4">
            <h4>Summary of Today’s Activities</h4>
            <ul class="list-group">
                <li class="list-group-item">
                    <strong>OPD Visits:</strong> {{ $opd_today }}
                </li>
                <li class="list-group-item">
                    <strong>IPD Admissions:</strong> {{ $ipd_today }}
                </li>
                <li class="list-group-item">
                    <strong>Appointments Today:</strong> {{ $appointments_today }}
                </li>
                <li class="list-group-item">
                    <strong>Total Patients:</strong> {{ $total_patients }}
                </li>
                <li class="list-group-item">
                    <strong>Today’s Revenue:</strong> {{ $today_revenue }}
                </li>
                <li class="list-group-item">
                    <strong>Low Stock Medicines:</strong> {{ $low_stock }}
                </li>
                <li class="list-group-item">
                    <strong>Pending Lab Requests:</strong> {{ $pending_lab }}
                </li>
                <li class="list-group-item">
                    <strong>Pending Radiology Requests:</strong> {{ $pending_radio }}
                </li>
            </ul>
        </div>

        <!-- OPD and IPD Chart Section -->
        <div class="chart-container mt-5">
            <h4>OPD vs IPD Visits</h4>
            <canvas id="opdIpdChart" height="80"></canvas>
        </div>

        <!-- Logout Button -->
        <form action="{{ route('logout') }}" method="POST" class="mt-4">
            @csrf
            <button class="btn btn-danger">Logout</button>
        </form>
    </div>
</div>

<script>
    // Fetching chart data (if applicable)
    fetch("{{ url('dashboard/api/opd-ipd') }}")
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
                            borderColor: 'blue',
                            fill: false
                        },
                        {
                            label: 'IPD',
                            data: data.ipd,
                            borderColor: 'red',
                            fill: false
                        }
                    ]
                }
            });
        });
</script>
@endsection
