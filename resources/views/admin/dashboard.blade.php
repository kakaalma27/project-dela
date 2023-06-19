@extends('layouts.main')
@section('title','Dashboard')
@section('main')
<div class="container">
    <div class="card-suss">
        <div class="card-body-suss">
            @if(session('success'))
                <div id="notification" class="notification">
                    <label class="sus">{{ session('success') }} {{ Auth::user()->name }}</label>
                </div>
            @endif

        </div>
    </div>
<div class="box-container mt-3">
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
<div class="pie-container mt-3">
    <div class="card-pie">
        <div class="card-body-pie">
            <div id="piechart" class="chart"></div>
        </div>
    </div>
</div>

</div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable({{ Js::from($result) }});
        var options = {
            fontSize: 16,
            width: '95%', 
            height: '95%',
            borderRadius: 20,
            chartArea: {
                width: '100%', 
                height: '100%',
            },
            backgroundColor: {
        fill: 'transparent'  // Mengatur latar belakang menjadi transparan
    }
        };
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
    <script>
        // Ambil elemen notifikasi
        var notification = document.getElementById('notification');
    
        // Fungsi untuk menutup notifikasi setelah 3 detik
        function closeNotification() {
            notification.style.display = 'none';
        }
    
        // Setelah halaman dimuat, tunggu 3 detik dan tutup notifikasi
        window.onload = function() {
            setTimeout(closeNotification, 5000);
        }
    </script>
@endsection