<?= $this->extend("layouts/base"); ?>

<?= $this->section("content"); ?>
<div class="container-fluid position-relative d-flex p-0">

    <!-- Sidebar Start -->
    <?= $this->include("partials/sidebar"); ?>
    <!-- Sidebar End -->

    <!-- Content Start -->
    <div class="content">
        <!-- Navbar Start -->
        <?= $this->include("partials/navbar"); ?>
        <!-- Navbar End -->

        <!-- <canvas id="documentChart" width="400" height="200"></canvas> -->


        <div class="bg-white">
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6 shadow">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">All Documents</h6>
                            <canvas id="documentChart"></canvas>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Incoming Documents</h6>
                            <canvas id="incomingDocumentChart"></canvas>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Users</h6>
                            <canvas id="usersByBarangayChart"></canvas>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Submissions Per Barangay</h6>
                            <canvas id="submissionsPerBarangayChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script>
            // All Documents
            var ctx1 = document.getElementById('documentChart').getContext('2d');
            var chartData = <?= $chartData ?>;
            var myChart1 = new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: chartData.labels, // Yearly labels
                    datasets: [{
                        label: '# of Documents',
                        data: chartData.data, // Yearly counts
                        backgroundColor: '#0596af',
                        borderColor: '#0596af',
                        borderWidth: 1,
                        // barThickness: 50
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // New "Incoming Documents" Chart
            var ctx2 = document.getElementById('incomingDocumentChart').getContext('2d');
            var incomingChartData = <?= $incomingChartData ?>;
            var myChart2 = new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: incomingChartData.labels,
                    datasets: [{
                        label: '# of Incoming Documents',
                        data: incomingChartData.data,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 2
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Users by Barangay Chart
            var ctx3 = document.getElementById('usersByBarangayChart').getContext('2d');
            var usersByBarangayData = <?= $usersByBarangayData ?>;
            var myChart3 = new Chart(ctx3, {
                type: 'pie', // Using a pie chart for visualizing proportions
                data: {
                    labels: usersByBarangayData.labels,
                    datasets: [{
                        label: '# of Users',
                        data: usersByBarangayData.data,
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 206, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(153, 102, 255)',
                            'rgb(255, 159, 64)',
                            'rgb(231, 233, 237)',
                            'rgb(180, 180, 180)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true
                }
            });

           // Submissions Per Barangay Chart
           var ctx4 = document.getElementById('submissionsPerBarangayChart').getContext('2d');
            var submissionsPerBarangayData = <?= $submissionsPerBarangayData ?>;
            var myChart4 = new Chart(ctx4, {
                type: 'bar',
                data: {
                    labels: submissionsPerBarangayData.labels,
                    datasets: [{
                        label: 'Submissions',
                        data: submissionsPerBarangayData.data,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    responsive: true
                }
            });
        </script>
        <?= $this->endSection(); ?>