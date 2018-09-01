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
    <title>@yield('tittle')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="description" content="@yield('desc')"/>
    <meta name="keywords" content="@yield('key')"/>
    <meta name="author" content="fahmi rizky"/>
    <meta name="MobileOptimized" content="320"/>

    <!--srart theme style -->
    <link href="{{asset('css/main.css')}}" rel="stylesheet" type="text/css"/>

    <!-- end theme style -->
    <!-- favicon links -->
    <link rel="shortcut icon" type="image/png" href="images/header/favicon.png"/>

    <style>
        .menu-active {
            color: #00A8FF;
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
                        <p>welcome guest</p>
                        <div class="ed_info_wrapper">
                            <a href="#" id="login_button">Masuk</a>
                            <div id="login_one" class="ed_login_form">
                                <h3>log in</h3>
                                <form class="form"  method="POST" action="{{ route('login') }}">
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
                                    <div class="form-group">
                                        <div class="g-recaptcha" data-sitekey="{{env('CAPTCHA_KEY')}}"></div>
                                        @if($errors->has('g-recaptcha-response'))
                                            <div class="invalid-feedback" style="display: block">
                                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>

                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Ingatkan saya
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit">login</button>
                                        <a href="{{route('register')}}">sign up</a>
                                    </div>
                                </form>
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
                        <div class="educo_logo"><a href="index.html"><img src="{{asset('images/header/Logo.png')}}"
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
                                            <li><a href="{{route('course.opsi',['class'=>$row->id])}}">{{$row->name}}</a>
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
                        <div class="educo_call"><i class="fa fa-phone"></i><a href="#"><span
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
                            <p><i class="fa fa-phone"></i><span class="phone">{{$default[0]->phone}}</span></p>
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
<script type="text/javascript" src="{{asset('js/jquery-1.12.2.js')}}"></script>
<script type="text/javascript" src="{{asset('js/main.js')}}"></script>
{{--<script type="text/javascript" src="{{asset('js/bootstrap.js')}}"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>
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

<script>
    $('.phone').text(function (i, text) {
        return text.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
    });
</script>
<!--main js file end-->
@stack('js')
</body>
</html>