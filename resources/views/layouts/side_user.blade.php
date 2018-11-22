<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$title. ' | '. env('APP_NAME')}}</title>
    <link href="{{asset('css/side.css')}}" rel="stylesheet" type="text/css"/>
    @stack('style')

    <style>
        body {
            margin: 0;
            background: #edf2f6;
            background-size: cover;
        }

        .container-notice {
            display: none;
        }

        #loading {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            width: 100vw;
            height: 100vh;
            background-color: rgba(192, 192, 192, 0.5);
            background-image: url({{asset('images/elipse_color_loader.svg')}});
            background-repeat: no-repeat;
            background-position: center;

        }

        .side-header {
            border-bottom: 1px solid #e3d9d9;
            text-align: center;
            background: #fafafa;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .side-header .col-lg-8 h4 {
            font-size: 1.6em;
        }

        .side-header .col-lg-8 h4 > .fa-arrow-left {
            position: absolute;
            left: 12px;
            color: #3abac6;
            cursor: pointer;
        }

        .title-content h4 {
            margin: 0;
            font-weight: 100;
            padding: 11px 0;
            font-size: 1.7em;
        }

        .side-content {
            padding: 4em 0;
            width: 100%;
        }

        .side-content .col-lg-8 {
            padding: 0;
        }
    </style>
</head>
<body>

<div class="container-notice">
    <div class="side-header">
        <div class="col-lg-offset-2 col-lg-8 col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
            <h4><i class="fa fa-arrow-left" title="kembali"></i>{{$title}}</h4>
        </div>
    </div>

    <div class="side-content">
        <div class="col-lg-offset-3 col-lg-6 col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10">
            @yield('content')
        </div>
    </div>
</div>
<div id="loading"></div>
<script src="{{asset('js/side.js')}}" type="text/javascript"></script>

<script>
    $(function () {
        $('.side-header').find('.fa-arrow-left').on('click', e => {
            history.back();
        });
        $(window).load(e => {
            $('.container-notice').removeClass().addClass('bounceInUp' + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                $(this).removeClass();
            });
        });
    })
</script>
@stack('js')
</body>
</html>