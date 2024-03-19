<?php
    $title = "Admin Dashboard";
    $home = "active";
    include('admin_header.php');
    if(!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
        header('location: index.php');
    }
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Teacher\'s active and inactive'],
            ['Active',     11],
            ['Inactive',      2]
        ]);

        var options = {
            title: 'Teachers active and inactive'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }

    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChartStudent);

    function drawChartStudent() {

        var stdData = google.visualization.arrayToDataTable([
            ['Task', 'Student class wise count'],
            ['BCA-I', 11],
            ['BCA-II', 20],
            ['BCA-III', 12],
            ['MCA-I', 15],
            ['MCA-II', 10]
        ]);

        var options = {
            title: 'Student class wise count'
        };

        var chart = new google.visualization.PieChart(document.getElementById('studentchart'));

        chart.draw(stdData, options);
    }
</script>
<!-- Main Content Here -->
<div class="container-fluid "  style="position: relative; z-index: 10;">
    <div class="row">
        <div class="col-9 ms-3">
            <div class="d-flex mt-4">
                <div class="w-50 me-2 border-end">
                    <div id="piechart" style="height: 500px;"></div>
                </div>
                <div class="w-50 me-2">
                    <div id="studentchart" style="height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    include('footer.php');
?>