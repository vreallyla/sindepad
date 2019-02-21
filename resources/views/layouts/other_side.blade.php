<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="vreallyla"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="token-jwt" content="{{$token}}">
    <title>{{$title. ' | '. env('PLUG_APP_SIDE')}}</title>
    <link rel="stylesheet" href="{{asset('css/addedAd.css')}}">
{{--        <link rel="stylesheet" href="{{asset('css/adminE.css')}}">--}}
    {{--@stack('package')--}}
    {{--@stack('style')--}}

</head>
<body>
<div class="preloader-wrapper">
    <div class="preloader">
        <img src="{{asset('images/loader/clock.svg')}}" alt="NILA">
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 header-up">
            <a href="#"><img src="{{asset('images/logo/full.png')}}" alt="SIMDEPAD" class="logo-up"></a>
            <div class="pull-right header-right">
                <ul>
                    <li class="add-shorcut line-two" data-toggle="tooltip" data-placement="bottom"
                              title="">
                        <a href="{{route('admin.register')}}" class="content-header-right"><span class="name-up"><i
                                        class="fa fa-briefcase"></i></span>
                            <span class="notice-count">0</span>
                        </a>
                    </li>
                    <li class="add-shorcut line" data-toggle="tooltip" data-placement="bottom"
                              title="">
                        <a href="{{route('admin.student.shadow')}}" class="content-header-right"><span class="name-up"><i
                                        class="fa fa-user-plus"></i></span>
                            <span class="notice-count">0</span>
                        </a>
                    </li>
                    <li class="add-shorcut" data-toggle="tooltip" data-placement="bottom"
                              title="Lihat Website">
                        <a href="{{route('welcome')}}" target="_blank" class="content-header-right"><span class="name-up"><i
                                        class="fa fa-eye"></i></span>
                        </a>
                    </li>

                    <li class="profile-up add-sub-header">
                        <a href="#" class="content-header-right">
                            <label class="circular--portrait">
                                <img src="{{$data->url}}" alt="">
                            </label>
                            <span class="name-up">Sdr/i {{$data->name}}</span></a>
                        <ul class="content-sub-header">
                            <li class="list-sub-header">
                                <a href="{{route('admin.profile')}}">
                                    Profil
                                </a>
                            </li>
                            <li class="list-sub-header">
                                <a href="">
                                    Keluar
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 trigger-burger">
            <i class="fa fa-bars"></i>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-7 menu-up">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 burgers pull">
                <i class="fa fa-bars pull-right"></i>
            </div>
            <div class="menu-content">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 menu-detail">
                    <a href="{{route('admin.index')}}">Beranda</a>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 menu-detail add-sub-menu">
                    <a href="javascript:void(0)">Data Master</a>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 content-sub-menu">
                    <div class="list-sub-menu">
                        <a href="{{route('admin.master.users')}}" class="point-dot">Pengguna</a>
                    </div>

                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 menu-detail add-sub-menu">
                    <a href="javascript:void(0)">Informasi</a>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 content-sub-menu">
                    <div class="list-sub-menu">
                        <a href="{{route('admin.news.list')}}" class="point-dot">Daftar</a>
                        <a href="{{route('admin.news.category')}}" class="point-dot">Kategori</a>
                    </div>

                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 menu-detail add-sub-menu">
                    <a href="javascript:void(0)">Pengaturan</a>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 content-sub-menu">
                    <div class="list-sub-menu">
                        <a href="{{route('admin.discon')}}" class="point-dot">Diskon</a>
                        <a href="{{route('admin.settings.price')}}" class="point-dot">Harga</a>
                        <a href="{{route('admin.settings.bank')}}" class="point-dot">Metode Pembayaran</a>
                        <a href="{{route('admin.settings.aggre')}}" class="point-dot">Persetujuan</a>
                        <a href="{{route('admin.settings.slide')}}" class="point-dot">Slide</a>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 menu-detail add-sub-menu">
                    <a href="javascript:void(0)">Penggalangan Dana</a>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 content-sub-menu">
                    <div class="list-sub-menu">
                        <a href="{{route('admin.fundraising.list')}}" class="point-dot">Daftar</a>
                        <a href="{{route('admin.fundraising.contributor')}}" class="point-dot">Penyumbang</a>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 menu-detail add-sub-menu">
                    <a href="javascript:void(0)">Peserta Didik</a>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 content-sub-menu">
                    <div class="list-sub-menu">
                        <a href="{{route('admin.student.activity')}}" class="point-dot">Kegiatan</a>
                        <a href="{{route('admin.student.schedule')}}" class="point-dot">Jadwal</a>
                        <a href="{{route('admin.student.shadow')}}" class="point-dot">Pendamping</a>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 menu-detail add-sub-menu">
                    <a href="javascript:void(0)">Tranksasi</a>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 content-sub-menu">
                    <div class="list-sub-menu">
                        <a href="{{route('admin.register')}}" class="point-dot">Pendaftar</a>
                        <a href="{{route('admin.trans.tuition')}}" class="point-dot">SPP</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-offset-3 col-lg-9 col-md-offset-4 col-md-8 col-sm-12 col-xs-12 content-up" style="padding-bottom: 3em">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title-content">
                <h3>{{$title}}</h3>
                <span>{{$sub}}</span>
            </div>
            @yield('content')
            <footer>
                <div class="col-lg-offset-3 col-lg-9 col-md-offset-4 col-md-8 col-sm-12 col-xs-12">
                    <span>© 2018. Design and Develop by <a href="#">vreallyla</a></span>
                </div>
            </footer>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-7 place-right">
            <div class="title-place-right col-lg-12 col-md-12 col-sm-12 col-xs-12 remove-padding text-center">
                <h4>@yield('title-right')</h4>
                <i class="fa fa-window-close"></i>
                @yield('step-right')
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                @yield('content-right')
            </div>
        </div>
    </div>
</div>
<div id="loading"></div>
<script src="{{asset('js/addedAd.js')}}"></script>
{{--<script src="{{asset('js/adminE.js')}}"></script>--}}
@stack('js')
</body>
</html>