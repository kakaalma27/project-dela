@extends('layouts.main')
@section('main')
<div class="container">

<div class="box-container">
         <div class="box box1">
            <div class="text">
                <h2 class="topic-heading">{{ $totalDocuments }}</h2>
                <h2 class="topic">Total Document</h2>
            </div>
        </div>

        <div class="box box2">
            <div class="text">
                <h2 class="topic-heading">{{ $validDocuments }}</h2>
                <h2 class="topic">Validasi Document</h2>
            </div>   
        </div>

        <div class="box box3">
            <div class="text">
                <h2 class="topic-heading">{{ $pendingDocuments }} </h2>
                <h2 class="topic">Pending Document</h2>
            </div>        
        </div>

        <div class="box box4">
            <div class="text">
                <h2 class="topic-heading">{{ $invalidDocuments }}</h2>
                <h2 class="topic">Invalid Document</h2>
            </div>
        </div>
</div>
        <div id="piechart" class="chart"></div>

</div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable({{ Js::from($result) }});

        var options = {
            fontSize: 16,
            width: '80%', 
            height: '80%',
            borderRadius: 20,
            chartArea: {
                width: '70%', 
                height: '90%',
                borderRadius: 20
            },
            borderRadius: 20
        };
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>

@endsection