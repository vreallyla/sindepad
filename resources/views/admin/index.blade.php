@extends('layouts.other_side')
@section('content')
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 content-content">
        <div class="row">

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 box-card">
                <div class="box-detail">
                    <i class="fa fa-user-secret"></i>
                    <h2>140</h2>
                    <h4>Pendamping</h4>
                </div>
                <div class="box-footer">
                    <span>Selengkapnya</span>
                    <i class="fa fa-arrow-circle-right"></i>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 box-card">
                <div class="box-detail">
                    <i class="fa fa-users"></i>
                    <h2>140</h2>
                    <h4>Pengguna</h4>
                </div>
                <div class="box-footer">
                    <span>Selengkapnya</span>
                    <i class="fa fa-arrow-circle-right"></i>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 box-card">
                <div class="box-detail">
                    <i class="fa fa-blind"></i>
                    <h2>140</h2>
                    <h4>Siswa Didik</h4>
                </div>
                <div class="box-footer">
                    <span>Selengkapnya</span>
                    <i class="fa fa-arrow-circle-right"></i>
                </div>
            </div>
            <!-- preparing a DOM with width and height for ECharts -->

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 graph">
                <div id="chartContainer" style="height: 300px; width: 100%;"></div>
            </div>

        </div>

    </div>
@endsection
@push('js')
    <script type="text/javascript">
        window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "Arus Data Pengguna"
                },
                axisX: {
                    valueFormatString: "DD MMM",
                    crosshair: {
                        enabled: true,
                        snapToDataPoint: true
                    }
                },
                axisY: {
                    title: "Jumlah Pengguna",
                    crosshair: {
                        enabled: true
                    }
                },
                toolTip: {
                    shared: true
                },
                legend: {
                    cursor: "pointer",
                    verticalAlign: "bottom",
                    horizontalAlign: "left",
                    dockInsidePlotArea: true,
                    itemclick: toogleDataSeries
                },
                data: [{
                    type: "line",
                    showInLegend: true,
                    name: "Total Visit",
                    markerType: "square",
                    xValueFormatString: "DD MMM, YYYY",
                    color: "#F08080",
                    dataPoints: [
                        {x: new Date(2017, 0, 3), y: 650},
                        {x: new Date(2017, 0, 4), y: 700},
                        {x: new Date(2017, 0, 5), y: 710},
                        {x: new Date(2017, 0, 6), y: 658},
                        {x: new Date(2017, 0, 7), y: 734},
                        {x: new Date(2017, 0, 8), y: 963},
                        {x: new Date(2017, 0, 9), y: 847},
                        {x: new Date(2017, 0, 10), y: 853},
                        {x: new Date(2017, 0, 11), y: 869},
                        {x: new Date(2017, 0, 12), y: 943},
                        {x: new Date(2017, 0, 13), y: 970},
                        {x: new Date(2017, 0, 14), y: 869},
                        {x: new Date(2017, 0, 15), y: 890},
                        {x: new Date(2017, 0, 16), y: 930}
                    ]
                },
                    {
                        type: "line",
                        showInLegend: true,
                        name: "Unique Visit",
                        lineDashType: "dash",
                        dataPoints: [
                            {x: new Date(2017, 0, 3), y: 510},
                            {x: new Date(2017, 0, 4), y: 560},
                            {x: new Date(2017, 0, 5), y: 540},
                            {x: new Date(2017, 0, 6), y: 558},
                            {x: new Date(2017, 0, 7), y: 544},
                            {x: new Date(2017, 0, 8), y: 693},
                            {x: new Date(2017, 0, 9), y: 657},
                            {x: new Date(2017, 0, 10), y: 663},
                            {x: new Date(2017, 0, 11), y: 639},
                            {x: new Date(2017, 0, 12), y: 673},
                            {x: new Date(2017, 0, 13), y: 660},
                            {x: new Date(2017, 0, 14), y: 562},
                            {x: new Date(2017, 0, 15), y: 643},
                            {x: new Date(2017, 0, 16), y: 570},
                            {x: new Date(2017, 0, 18), y: 570},
                            {x: new Date(2017, 0, 19), y: 570},
                            {x: new Date(2017, 0, 30), y: 570},
                            {x: new Date(2017, 1, 1), y: 570},
                            {x: new Date(2017, 1, 9), y: 570},
                        ]
                    }]
            });
            chart.render();

            function toogleDataSeries(e) {
                if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }
                chart.render();
            }

        }
    </script>
@endpush
@push('style')

@endpush