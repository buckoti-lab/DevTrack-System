<!-- <div class="container-fluid"> -->

<div class="container">

    <!-- ================= KPI CARDS ================= -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow">
                <div class="card-body">
                    <h6>Total Projects</h6>
                    <h3>{{ $totalProjects }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow">
                <div class="card-body">
                    <h6>Active Projects</h6>
                    <h3>{{ $activeProjects }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow">
                <div class="card-body">
                    <h6>Total Revenue</h6>
                    <h3>TZS {{ number_format($totalRevenue) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow">
                <div class="card-body">
                    <h6>Overdue Tasks</h6>
                    <h3>{{ $overdueTasks }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= CHARTS ================= -->

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header">Project Status</div>
                <div class="card-body">
                    <canvas id="projectStatusChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header">Monthly Projects</div>
                <div class="card-body">
                    <canvas id="monthlyProjectsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header">Quote Status</div>
                <div class="card-body">
                    <canvas id="quoteStatusChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header">Developer Workload</div>
                <div class="card-body">
                    <canvas id="developerChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

<script>

    // PROJECT STATUS BAR
    new Chart(document.getElementById('projectStatusChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($projectStatus->keys()) !!},
            datasets: [{
                label: 'Projects',
                data: {!! json_encode($projectStatus->values()) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.7)'
            }]
        }
    });

    // MONTHLY PROJECTS LINE
    new Chart(document.getElementById('monthlyProjectsChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyProjects->keys()) !!},
            datasets: [{
                label: 'Projects per Month',
                data: {!! json_encode($monthlyProjects->values()) !!},
                borderColor: 'rgba(75, 192, 192, 1)',
                fill: false
            }]
        }
    });

    // QUOTE STATUS PIE
    new Chart(document.getElementById('quoteStatusChart'), {
        type: 'pie',
        data: {
            labels: {!! json_encode($quoteStatus->keys()) !!},
            datasets: [{
                data: {!! json_encode($quoteStatus->values()) !!},
                backgroundColor: [
                    '#ffc107',
                    '#28a745',
                    '#dc3545'
                ]
            }]
        }
    });

    // DEVELOPER WORKLOAD
    new Chart(document.getElementById('developerChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($developerWorkload->keys()) !!},
            datasets: [{
                label: 'Tasks',
                data: {!! json_encode($developerWorkload->values()) !!},
                backgroundColor: '#6f42c1'
            }]
        }
    });

</script>
