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

        <div class="container">
            <div class="mb-5 mt-5">
                <div id="GoogleLineChart" style="height: 400px; width: 100%"></div>
            </div>
            <div class="mb-5">
                <div id="GoogleBarChart" style="height: 400px; width: 100%"></div>
            </div>
        </div>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script>
            google.charts.load('current', {
                'packages': ['corechart', 'bar']
            });
            google.charts.setOnLoadCallback(drawChart);
            google.charts.setOnLoadCallback(drawBarChart);
            // Line Chart
            // function drawLineChart() {
            //     var data = google.visualization.arrayToDataTable([
            //         ['Day', 'Files Count'],
            //         <?php
            //         foreach ($filess as $row) {
            //             echo "['" . $row['date_formatted'] . "'," . $row['subject'] . "],";
            //         } ?>
            //     ]);
            //     var options = {
            //         title: 'Line chart product sell wise',
            //         curveType: 'function',
            //         legend: {
            //             position: 'top'
            //         }
            //     };
            //     var chart = new google.visualization.LineChart(document.getElementById('GoogleLineChart'));
            //     chart.draw(data, options);
            // }

            function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Month', 'File Count'],
                <?php foreach($chart_data as $row): ?>
                    ['<?php echo $row['month']; ?>', <?php echo $row['file_count']; ?>],
                <?php endforeach; ?>
            ]);

            var options = {
                title: 'Document Count by Month',
                curveType: 'function',
                legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('GoogleLineChart'));

            chart.draw(data, options);
        }


            // Bar Chart
            // google.charts.setOnLoadCallback(showBarChart);

            // function drawBarChart() {
            //     var data = google.visualization.arrayToDataTable([
            //         ['Day', 'Files Count'],
            //         <?php
            //         foreach ($filess as $row) {
            //             echo "['" . $row['date_formatted'] . "'," . $row['subject'] . "],";
            //         }
            //         ?>
            //     ]);
            //     var options = {
            //         title: ' Bar chart products sell wise',
            //         is3D: true,
            //     };
            //     var chart = new google.visualization.BarChart(document.getElementById('GoogleBarChart'));
            //     chart.draw(data, options);
            // }
        </script>



        <?= $this->endSection(); ?>