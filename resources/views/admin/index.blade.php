@extends('layouts.other_side')
@section('content')
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 content-content">
        <div class="row">

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 box-card">
                <div class="box-detail">
                    <i class="fa fa-user-secret"></i>
                    <h2>{{$entity->pengajar}}</h2>
                    <h4>Pendamping</h4>
                </div>
                <div class="box-footer">
                    <a href="{{route('admin.master.users')}}?cat=Pengajar">Selengkapnya <i
                                class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 box-card">
                <div class="box-detail">
                    <i class="fa fa-users"></i>
                    <h2>{{$entity->user}}</h2>
                    <h4>Pengguna</h4>
                </div>
                <div class="box-footer">
                    <a href="{{route('admin.master.users')}}?cat=User">Selengkapnya <i
                                class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 box-card">
                <div class="box-detail">
                    <i class="fa fa-blind"></i>
                    <h2>{{$entity->student}}</h2>
                    <h4>Siswa Didik</h4>
                </div>
                <div class="box-footer">
                    <a href="{{route('admin.master.users')}}?cat=Peserta">Selengkapnya <i
                                class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- preparing a DOM with width and height for ECharts -->

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 graph">
                <canvas id="myChart" width="100%" height="30" style="background: #fff;"></canvas>
            </div>

        </div>

    </div>
@endsection
@push('js')
    <script type="text/javascript">
        var ctx = document.getElementById("myChart").getContext('2d');
        var lineData = {
            datasets: [
                {
                    label: 'Pengajar',
                    data: [
                            @foreach($graph['shadow'] as $row)
                        {
                            x: moment('{{$row->date}}','YYYY-MM-DD'), y: '{{$row->entity}}'
                        },
                        @endforeach
                    ],
                    showLine: true,
                    fill: false,
                    borderColor: 'rgba(0, 200, 0, 1)',

                },
                {
                    label: 'Pengguna',
                    data: [
                            @foreach($graph['user'] as $row)
                        {
                            x: moment('{{$row->date}}','YYYY-MM-DD'), y: '{{$row->entity}}'
                        },
                        @endforeach
                    ]
                    ,
                    showLine: true,
                    fill: false,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255,99,132,1)'
                }, {
                    label: 'Peserta Didik',
                    data: [
                            @foreach($graph['student'] as $row)
                        {
                            x: moment('{{$row->date}}','YYYY-MM-DD'), y: '{{$row->entity}}'
                        },
                        @endforeach
                    ]
                    ,
                    showLine: true,
                    fill: false,
                    backgroundColor: 'rgba(0, 160, 244, 0.2)',
                    borderColor: 'rgba(0, 160, 244, 0.73)'
                }

            ]
        };
        var myChart = new Chart(ctx, {
            type: 'scatter',
            data: lineData,
            options: {
                tooltips: {
                    mode: 'index',
                    intersect: false
                },
                events: ['click'],

                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                title: {
                    display: true,
                    text: 'Grafik Pendaftar',
                    fontSize: 18,
                    padding: 5
                },
                legend: {
                    display: true,
                    position: 'bottom'

                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }],
                    xAxes: [{
                        type: 'time',
                        distribution: 'linear',
                        time: {
                            displayFormats: {
                                'millisecond': 'YYYY-MM-DD',
                                'second': 'YYYY-MM-DD',
                                'minute': 'YYYY-MM-DD',
                                'hour': 'YYYY-MM-DD',
                                'day': 'YYYY-MM-DD',
                                'week': 'YYYY-MM-DD',
                                'month': 'YYYY-MM-DD',
                                'quarter': 'YYYY-MM-DD',
                                'year': 'YYYY-MM-DD',
                            }
                        },
                         ticks: {
                        callback: function(value) {
                        return moment(value).format('MMM DD');
                        },
                        },
// scaleLabel: {
//     display: true,
//     labelString: 'Date'
// }
                    }],

                },
            }
        });
    </script>
@endpush
