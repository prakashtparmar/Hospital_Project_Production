<canvas id="opdIpdChart" height="80"></canvas>

<script>
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
