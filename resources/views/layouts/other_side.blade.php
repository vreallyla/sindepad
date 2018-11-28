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
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
    @stack('package')
    @stack('style')

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
                    <li class="add-shorcut line-two">
                        <a href="{{route('welcome')}}" class="content-header-right"><span class="name-up"><i
                                        class="fa fa-calendar"></i></span> </a>
                    </li>
                    <li class="add-shorcut line">
                        <a href="#" class="content-header-right"><span class="name-up"><i
                                        class="fa fa-briefcase"></i></span> </a>
                    </li>
                    <li class="add-shorcut">
                        <a href="#" class="content-header-right"><span class="name-up"><i
                                        class="fa fa-user-plus"></i></span> </a>
                    </li>

                    <li class="profile-up add-sub-header">
                        <a href="#" class="content-header-right">
                            <label class="circular--portrait">
                                <img src="{{asset('images/img_unvailable.png')}}" alt="">
                            </label>
                            <span class="name-up">Sdr/i Fransiska</span></a>
                        <ul class="content-sub-header">
                            <li class="list-sub-header">
                                <a href="">
                                    Edit Profile
                                </a>
                            </li>
                            <li class="list-sub-header">
                                <a href="">
                                    Edit Profile
                                </a>
                            </li>
                            <li class="list-sub-header">
                                <a href="">
                                    Edit Profile
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
                        <a href="#" class="point-dot">Pengguna</a>
                    </div>

                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 menu-detail add-sub-menu">
                    <a href="javascript:void(0)">Tranksasi</a>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 content-sub-menu">
                    <div class="list-sub-menu">
                        <a href="{{route('admin.register')}}" class="point-dot">Pendaftar</a>
                    </div>
                    <div class="list-sub-menu">
                        <a href="#" class="point-dot">SPP</a>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 menu-detail add-sub-menu">
                    <a href="javascript:void(0)">Pengaturan</a>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 content-sub-menu">
                    <div class="list-sub-menu">
                        <a href="{{route('admin.settings.rpp')}}" class="point-dot">RPP</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-offset-3 col-lg-9 col-md-offset-4 col-md-8 col-sm-12 col-xs-12 content-up">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title-content">
                <h3>{{$title}}</h3>
                <span>{{$sub}}</span>
            </div>
            @yield('content')
        </div>

    </div>
</div>
<div id="loading"></div>
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/admin.js')}}"></script>
@stack('js')

</body>
</html>