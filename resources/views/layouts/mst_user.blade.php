<!DOCTYPE html>
<!-- 
Template Name: Educo
Version: 2.0.0
Author: Kamleshyadav
Website: http://himanshusofttech.com/
Purchase: http://themeforest.net/user/kamleshyadav
-->
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<!-- Begin Head -->
<head>
    <meta charset="utf-8"/>
    <title>{{$title. ' | '. env('APP_NAME')}}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="description" content="@yield('desc')"/>
    <meta name="keywords" content="@yield('key')"/>
    <meta name="author" content="fahmi rizky"/>
    <meta name="MobileOptimized" content="320"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--srart theme style -->
    <link href="{{asset('css/main.css')}}" rel="stylesheet" type="text/css"/>

    <!-- end theme style -->
    <!-- favicon links -->
    <link rel="shortcut icon" type="image/png" href="images/header/favicon.png"/>
    <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">

    <style>
        .menu-active {
            color: #00A8FF;
        }

        .round-swall {
            border-radius: 25px;
        }

        .zoom {
            transition: transform .3s;
        }

        .zoom:hover {
            -ms-transform: scale(1.1);
            -webkit-transform: scale(1.1);
            transform: scale(1.1);
        }

        .ed_login_form form svg {
            height: 50px;
            width: 50px;
            margin: -21px -55px;
            margin-right: -73px;
        }

        /*after login sub menu*/
        .choose_one {
            text-align: left;
            margin-left: 10px;
            margin: 0px;
            font-size: 1.1em;
            padding: 5px 10px;
            min-width: 184px;
            color: rgba(0, 0, 0, 0.75);
            cursor: pointer;
        }

        .choose_one:hover {
            background: #3ABAC6;
        }

        .choose_one:hover > a, .choose_one a:hover {
            text-decoration: none;
            color: #fff;
        }

        .circular--portrait {
            position: relative;
            width: 10px;
            height: 10px;
            overflow: hidden;
            border-radius: 50%;
        }

        .asd {
            width: 22px;
            height: 22px;
            border-radius: 50%;
        }

        .name-user::before {
            content: " Sdr/i ";
            text-transform: none;
        }


    </style>

    @stack('style')
</head>
<body>
<!--Page main section start-->
<div id="educo_wrapper">
    <!--Header start-->
    <header id="ed_header_wrapper">
        <div class="ed_header_top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <p>Selamat Datang...</p>
                        <div class="ed_info_wrapper">
                            <a href="#" class="button_link" id="login_button">
                                @if(!empty($user_cookie))
                                    <img class="asd" src="{{asset($user_cookie->url)}}"/>&nbsp;
                                    <span class="name-user">{{$user_cookie->name}}</span>
                                @else
                                    Masuk
                                    @endif
                            </a>

                            <div id="login_one" class="ed_login_form">
                                @if($user_cookie)
                                    <div class="row" style="color: black">
                                        {{--<div class="choose_one">--}}
                                        {{--<a href="#">Laman Admin</a>--}}
                                        {{--</div>--}}
                                        <div class="choose_one">
                                            <a href="#">rubah profil</a>
                                        </div>
                                        {{--<div class="choose_one">--}}
                                        {{--<a href="#">Simdepad</a>--}}
                                        {{--</div>--}}
                                        {{--<div class="choose_one">--}}
                                        {{--<a href="#">Bayar SPP</a>--}}
                                        {{--</div>--}}
                                        <div class="choose_one">
                                            <a href="#">Keluar</a>
                                        </div>
                                    </div>
                                @else
                                    <h3>log in
                                        <div class="help-block" style="    font-size: 0.5em; margin: 6px 0;">We're
                                            excited
                                            to see you...
                                        </div>
                                    </h3>

                                    <form class="form" method="POST" action="{{ route('loginjwt') }}">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label class="control-label">Email :</label>
                                            <input type="text" class="form-control" name="email">
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Kata Sandi :</label>
                                            <input type="password" class="form-control" name="password">
                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                        {{--<div class="form-group">--}}
                                        {{--<div class="g-recaptcha" data-sitekey="{{env('CAPTCHA_KEY')}}"></div>--}}
                                        {{--@if($errors->has('g-recaptcha-response'))--}}
                                        {{--<div class="invalid-feedback" style="display: block">--}}
                                        {{--<strong>{{ $errors->first('g-recaptcha-response') }}</strong>--}}

                                        {{--</div>--}}
                                        {{--@endif--}}
                                        {{--</div>--}}
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox"
                                                           name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    Ingatkan
                                                    saya
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit">Masuk
                                            </button>
                                            <a class="a_sub" href="{{route('register')}}">sign up</a>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ed_header_bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <div class="educo_logo"><a href="{{route('welcome')}}"><img
                                        src="{{asset('images/header/Logo.png')}}"
                                        alt="Sanggar ABK"/></a></div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <div class="edoco_menu_toggle navbar-toggle" data-toggle="collapse" data-target="#ed_menu">Menu
                            <i class="fa fa-bars"></i>
                        </div>
                        <div class="edoco_menu">
                            <ul class="collapse navbar-collapse" id="ed_menu">
                                <li><a href="{{route('welcome')}}">Beranda</a></li>
                                <li><a href="{{route('course')}}">Program</a>
                                    <ul class="sub-menu">
                                        @foreach($default[1] as $row)
                                            <li>
                                                <a href="{{route('course.opsi',['class'=>$row->id])}}">{{$row->name}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li><a href="#">blog</a>
                                    <ul class="sub-menu">
                                        <li><a href="events.html">all events</a></li>
                                        <li><a href="event_single.html">events-single</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">FAQs</a>
                                    <ul class="sub-menu">
                                        <li><a href="courses.html">all courses</a></li>
                                        <li><a href="course_sidebar.html">course-sidebar</a></li>
                                        <li><a href="course_single.html">course-single</a></li>
                                        <li><a href="course_lesson.html">course-lesson</a></li>
                                    </ul>
                                </li>
                                <li><a href="{{route('about')}}">Tentang Kami</a></li>
                                <li><a href="{{route('contact')}}">Kontak</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <div class="educo_call"><i class="fa fa-phone"></i><a href="tel:{{$default[0]->phone}}"
                                                                              style="cursor: pointer"><span
                                        class="phone">{{$default[0]->phone}}</span></a></div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!--header end -->
@yield('content')
<!--Latest news end -->

    <!--Footer Top section start-->
    <div class="ed_footer_wrapper">
        <div class="ed_footer_top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="widget text-widget">
                            <p><a href="index.html"><img src="images/footer/F_Logo.png" alt="Footer Logo"/></a></p>
                            <p>Edution is an outstanding PSD template targeting educational institutions, helping them
                                establish strong identity on the internet without any real developing knowledge.
                            </p>
                            <div class="ed_sociallink">
                                <ul>
                                    <li><a href="#" data-toggle="tooltip" data-placement="bottom" title="Dribble"><i
                                                    class="fa fa-dribbble"></i></a></li>
                                    <li><a href="#" data-toggle="tooltip" data-placement="bottom" title="Retro"><i
                                                    class="fa fa-camera-retro"></i></a></li>
                                    <li><a href="#" data-toggle="tooltip" data-placement="bottom" title="Facebook"><i
                                                    class="fa fa-facebook-official"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="widget text-widget">
                            <h4 class="widget-title">find us</h4>
                            <p><i class="fa fa-safari"></i>{{$default[0]->address}}, Indonesia</p>
                            <p><i class="fa fa-envelope-o"></i><a href="#">info@edutioncollege.gov.co.uk</a> <a
                                        href="#">public@edutioncollege.gov.co.uk</a></p>
                            <p><i class="fa fa-phone"></i><a href="tel:{{$default[0]->phone}}" style="cursor: pointer">
                                    <span class="phone">{{$default[0]->phone}}</span>
                                </a></p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="widget text-widget">
                            <h4 class="widget-title">social media</h4>
                            <p><strong>@education </strong> How many students do you educate monthly? Open <a href="">
                                    http://t.co/KFDdzLSD9</a><br/>2 days ago</p>

                            <p><strong>@educationUK </strong> Web Design that works. Have a look at this masterpiece. <a
                                        href="">http://t.co/9j8DH93zrO</a><br/>5 days ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Footer Top section end-->
    <!--Footer Bottom section start-->
    <div class="ed_footer_bottom">
        <div class="container">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="ed_copy_right">
                            <p>&copy; Copyright 2016, All Rights Reserved, <a href="#">{{ config('app.name') }}</a></p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="ed_footer_menu">
                            <ul>
                                <li><a href="index.html">home</a></li>
                                <li><a href="private_policy.html">private policy</a></li>
                                <li><a href="about.html">about</a></li>
                                <li><a href="contact.html">contact us</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Footer Bottom section end-->
</div>
<!--Page main section end-->
<!--main js file start-->
<script type="text/javascript" src="{{asset('js/app.js')}}"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>--}}
<script type="text/javascript" src="{{asset('js/modernizr.js')}}"></script>
<script type="text/javascript" src="{{asset('js/owl.carousel.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.stellar.js')}}"></script>
<script type="text/javascript" src="{{asset('js/smooth-scroll.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/revel/jquery.themepunch.tools.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/revel/jquery.themepunch.revolution.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/revel/revolution.extension.layeranimation.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/revel/revolution.extension.navigation.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/revel/revolution.extension.slideanims.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/countto/jquery.countTo.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/countto/jquery.appear.js')}}"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
@stack('package')
<script type="text/javascript" src="{{asset('js/custom.js')}}"></script>
<script type="text/javascript" src="{{asset('js/phone.js')}}"></script>
<!--main js file end-->
<script>
    var title = document.getElementsByTagName("title")[0].innerHTML;
    (function titleScroller(text) {
        document.title = text;
        setTimeout(function () {
            titleScroller(text.substr(1) + text.substr(0, 1));
        }, 500);
    }(title + " ~ "));

    $(function ($) {
        $("[data-toggle=tooltip]").tooltip();
    });
</script>
@stack('js')

<script>
    $(function ($) {
        var formLogin = $('#login_one form');
        var svg_loader = '<svg version="1.1" id="L5" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"\n' +
            '  viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">\n' +
            '  <circle fill="#fff" stroke="none" cx="6" cy="50" r="6">\n' +
            '    <animateTransform\n' +
            '       attributeName="transform"\n' +
            '       dur="1s"\n' +
            '       type="translate"\n' +
            '       values="0 15 ; 0 -15; 0 15"\n' +
            '       repeatCount="indefinite"\n' +
            '       begin="0.1"/>\n' +
            '  </circle>\n' +
            '  <circle fill="#fff" stroke="none" cx="30" cy="50" r="6">\n' +
            '    <animateTransform\n' +
            '       attributeName="transform"\n' +
            '       dur="1s"\n' +
            '       type="translate"\n' +
            '       values="0 10 ; 0 -10; 0 10"\n' +
            '       repeatCount="indefinite"\n' +
            '       begin="0.2"/>\n' +
            '  </circle>\n' +
            '  <circle fill="#fff" stroke="none" cx="54" cy="50" r="6">\n' +
            '    <animateTransform\n' +
            '       attributeName="transform"\n' +
            '       dur="1s"\n' +
            '       type="translate"\n' +
            '       values="0 5 ; 0 -5; 0 5"\n' +
            '       repeatCount="indefinite"\n' +
            '       begin="0.3"/>\n' +
            '  </circle>\n' +
            '</svg>';

        formLogin.on('submit', function (e) {

            formLogin.find('input').attr('readonly', true);
            formLogin.find('button').attr('disabled', true);
            formLogin.find('a').css('pointer-events', 'none');
            formLogin.find('button[type="submit"]').html(svg_loader);

            if (!e.isDefaultPrevented()) {
                urlLogin = formLogin.attr('action');
                axios.post(urlLogin, new FormData(formLogin[0]))
                    .then(function (res) {
                        create_token(res);
                    })
                    .catch(function (er) {
                        login_done(er.response.data.error)
                    });

                return false;
            }

        });


        function create_token(res) {
            axios.get('/kreu-token', {
                params: {
                    'token': res.data.access_token,
                    'name': res.data.data.name,
                    'url': res.data.data.url
                }
            })
                .then(function (res) {
                    login_done();
                    console.log('aku');
                    $('#login_button').click().html(' <img class="asd" src="'+res.data.url+'">&nbsp;\n' +
                        '                                <span class="name-user">'+res.data.name+'</span></a>');
                    $('#login_one').html('<div class="row" style="color: black">\n' +
                        '                                        <div class="choose_one">\n' +
                        '                                            <a href="#">rubah profil</a>\n' +
                        '                                        </div>\n' +
                        '                                        <div class="choose_one">\n' +
                        '                                            <a href="#">Logout</a>\n' +
                        '                                        </div>\n' +
                    '                                    </div>');
                })
                .catch(function (er) {
                    login_done('login gagal, coba lagi')
                })

        }

        function login_done(e) {
            formLogin.find('input').removeAttr('readonly');
            formLogin.find('button').removeAttr('disabled');
            formLogin.find('button[type="submit"]').html('Masuk');
            formLogin.find('a').css('pointer-events', '');
            if ($.trim(e)) {
                notice_login = $('#login_one');
                notice_login.find('.help-block').html(e);
                notice_login.find('h3, form').addClass('shake' + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                    $(this).removeClass('shake animated');
                });
            }
        }


    });
</script>
</body>
</html>