<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    {{--<link rel="stylesheet" href="{{asset('css/helpers.css')}}">--}}
    {{--<link rel="stylesheet" href="{{asset('css/debug.css')}}">--}}
    <link rel="stylesheet" href="{{asset('css/grid.css')}}">
    <style>

        /*hidden*/
        .is-hidden {
            display: none;
        }

        /*hidden*/

        /*loading input*/
        .loading-input {
            position: relative;
            display: flex;
            background-color: #ffffff;
            background-image: url("http://loadinggif.com/images/image-selection/3.gif");
            background-size: 1.2em 1.2em;
            background-position: right center;
            background-repeat: no-repeat;
        }

        /*loading input*/

        /*add scroll*/
        .scroll-add {
            /*float:left;*/
            /*width:1000px;*/
            overflow-y: auto;
            height: 300px;
        }

        /*add scroll*/

        /*remove border*/
        .is-borderless-right {
            border-left: none;
            border-right: none;
        }

        /*remove border*/

        /*line vertical*/
        .border-vertical {
            border-left: 1px solid #D0D1CD;
            border-right: 1px solid #D0D1CD;
        }

        /*end line vertical*/

        /*back to top button*/
        .back-top {
            /*width: 50px;*/
            /*height: auto;*/
            padding: 10px;
            border-radius: 2px;
            position: fixed;
            z-index: 1000;
            right: 25px;
            /*box-shadow: 0 0 1px #666d;*/
            cursor: pointer;
            /*border: 2px grey;*/
            /*font: arial 20px;*/
            bottom: 40px;
        }

        /*end back to top*/
        /*set pointer*/

        .is-pointer {
            cursor: pointer;
        }

        /*end set pointer*/

        /*card modify*/
        .padding-reduce {
            padding-top: 0.85em;
            padding-bottom: 0.85em;
            padding-left: 0.75em;
        }

        /*end card modify*/
        .center {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .is-paddingless-horizontal {
            padding-left: 0;
            padding-right: 0;
        }

        .hero {
        {{--background: black url({{asset('images/hero-1.jpg')}}) center / cover;--}}


        }

        {{--@media (max-width: 1024px) { .hero { background: black url({{asset('images/hero-2.jpg')}}) center / cover; } }--}}
        {{--@media (max-width:  768px) { .hero { background: black url({{asset('images/hero-3.jpg')}}) center / cover; } }--}}

    </style>
    <title>Document</title>
</head>
<body>
<div class="upper"></div>
<nav class="navbar is-transparent has-shadow is-fixed-top is-transparent animated slideInDown">
    <div class="navbar-brand ">
        <a class="navbar-item" href="https://bulma.io">
            <img src="{{asset('images/sanggar_abk/logo-side.png')}}"
                 alt="Bulma: a modern CSS framework based on Flexbox" width="auto" height="112">
        </a>
        <div class="navbar-burger burger" data-target="navbarExampleTransparentExample">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <div id="navbarExampleTransparentExample" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item" href="https://bulma.io/">
                Home
            </a>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link" href="/documentation/overview/start/">
                    Programs
                </a>
                <div class="navbar-dropdown is-boxed">
                    <a class="navbar-item" href="/documentation/overview/start/">
                        Overview
                    </a>
                    <a class="navbar-item" href="https://bulma.io/documentation/modifiers/syntax/">
                        Modifiers
                    </a>
                    <a class="navbar-item" href="https://bulma.io/documentation/columns/basics/">
                        Columns
                    </a>
                    <a class="navbar-item" href="https://bulma.io/documentation/layout/container/">
                        Layout
                    </a>
                    <a class="navbar-item" href="https://bulma.io/documentation/form/general/">
                        Form
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item" href="https://bulma.io/documentation/elements/box/">
                        Elements
                    </a>
                    <a class="navbar-item is-active" href="https://bulma.io/documentation/components/breadcrumb/">
                        Components
                    </a>
                </div>
            </div>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link" href="/documentation/overview/start/">
                    Blogs
                </a>
                <div class="navbar-dropdown is-boxed">
                    <a class="navbar-item" href="/documentation/overview/start/">
                        Overview
                    </a>
                    <a class="navbar-item" href="https://bulma.io/documentation/modifiers/syntax/">
                        Modifiers
                    </a>
                    <a class="navbar-item" href="https://bulma.io/documentation/columns/basics/">
                        Columns
                    </a>
                    <a class="navbar-item" href="https://bulma.io/documentation/layout/container/">
                        Layout
                    </a>
                    <a class="navbar-item" href="https://bulma.io/documentation/form/general/">
                        Form
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item" href="https://bulma.io/documentation/elements/box/">
                        Elements
                    </a>
                    <a class="navbar-item is-active" href="https://bulma.io/documentation/components/breadcrumb/">
                        Components
                    </a>
                </div>
            </div>

            <a class="navbar-item" href="https://bulma.io/">
                Contact
            </a>
            <a class="navbar-item" href="https://bulma.io/">
                About Us
            </a>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link" href="/documentation/overview/start/">
                    Docs
                </a>
                <div class="navbar-dropdown is-boxed">
                    <a class="navbar-item" href="/documentation/overview/start/">
                        Overview
                    </a>
                    <a class="navbar-item" href="https://bulma.io/documentation/modifiers/syntax/">
                        Modifiers
                    </a>
                    <a class="navbar-item" href="https://bulma.io/documentation/columns/basics/">
                        Columns
                    </a>
                    <a class="navbar-item" href="https://bulma.io/documentation/layout/container/">
                        Layout
                    </a>
                    <a class="navbar-item" href="https://bulma.io/documentation/form/general/">
                        Form
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item" href="https://bulma.io/documentation/elements/box/">
                        Elements
                    </a>
                    <a class="navbar-item is-active" href="https://bulma.io/documentation/components/breadcrumb/">
                        Components
                    </a>
                </div>
            </div>
        </div>

        <div class="navbar-end">
            <div class="navbar-item">
                <div class="field is-grouped">
                    <p class="control" style="margin-right: 1.25em">
                        <a class="button is-warning"
                           href="https://github.com/jgthms/bulma/releases/download/0.7.1/bulma-0.7.1.zip">
              <span class="icon">
                <i class="fas fa-sign-in-alt"></i>
              </span>
                            <span><b>Masuk | Daftar</b></span>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</nav>
<div class="back-top has-text-centered has-background-warning icon is-large animated has-shadow">
    <i class="fas fa-2x fa-angle-double-up "></i>
</div>
<section class="section">
    <div class="container is-paddingless-horizontal is-fluid has-background-white border-vertical">
        <div class="section ">
            <div class="columns">
                <div class="hero column is-8">
                    <div class="columns is-multiline">
                        <div class="column is-full">
                            <div class='carousel carousel-animated carousel-animate-slide animated bounceIn'
                                    {{--data-autoplay="true"
                                    data-delay="5000"--}}>
                                <div class='carousel-container'>
                                    <div class='carousel-item has-background is-active'>
                                        <img class="is-background" src="{{asset('images/hero-1.jpg')}}" alt=""
                                             width="640" height="310"/>
                                        <div class="title">Merry Christmas</div>
                                    </div>
                                    <div class='carousel-item has-background'>
                                        <img class="is-background" src="https://wikiki.github.io/images/singer.jpg"
                                             alt=""
                                             width="640" height="310"/>
                                        <div class="title">Original Gift: Offer a song with <a
                                                    href="https://lasongbox.com"
                                                    target="_blank">La Song Box</a>
                                        </div>
                                    </div>
                                    <div class='carousel-item has-background'>
                                        <img class="is-background" src="https://wikiki.github.io/images/sushi.jpg"
                                             alt=""
                                             width="640" height="310"/>
                                        <div class="title">Sushi time</div>
                                    </div>
                                    <div class='carousel-item has-background'>
                                        <img class="is-background" src="https://wikiki.github.io/images/life.jpg" alt=""
                                             width="640"
                                             height="310"/>
                                        <div class="title">Life</div>
                                    </div>
                                </div>
                                <div class="carousel-navigation is-overlay">
                                    <div class="carousel-nav-left">
                                        <i class="fa fa-chevron-left" aria-hidden="true"></i>
                                    </div>
                                    <div class="carousel-nav-right">
                                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="columns is-multiline">
                                <div class="column is-full">
                                    <div class="card animated bounceIn">
                                        <div
                                                class="card-header padding-reduce has-text-black-bis has-background-warning">
                                            <div class="media">
                                                <div class="media-left">
                                                    <span class="icon is-small">
                                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                </span>
                                                </div>
                                                <div class="media-content">
                                                    <p class="title is-5">Program Kelas</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-content is-paddingless">
                                            <section class="accordions ">
                                                <article class="accordion">
                                                    <div
                                                            class="accordion-header is-radiusless has-background-white-ter is-pointer">
                                                        <div class="media">
                                                            <div class="media-left has-text-grey-dark">
                                                                <span class="icon is-small">
                                                                    <i class="fas fa-arrow-alt-circle-right"></i>
                                                                </span>
                                                            </div>
                                                            <div class="media-content">
                                                                <p class="subtitle is-6">Menari</p>
                                                            </div>
                                                        </div>
                                                        <div class="icon accordion-icon  has-text-grey-dark">
                                                            <i class="fa fa-plus-square" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-body has-background-white">
                                                        <div class="accordion-content">
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                            <strong>Pellentesque
                                                                risus mi</strong>, tempus quis placerat ut, porta nec
                                                            nulla.
                                                            Vestibulum rhoncus ac ex sit amet fringilla. Nullam gravida
                                                            purus
                                                            diam, et dictum <a>felis venenatis</a> efficitur. Aenean ac
                                                            <em>eleifend
                                                                lacus</em>, in mollis lectus. Donec sodales, arcu et
                                                            sollicitudin porttitor, tortor urna tempor ligula, id
                                                            porttitor mi
                                                            magna a neque. Donec dui urna, vehicula et sem eget,
                                                            facilisis
                                                            sodales sem.
                                                            <button class="button is-black-bis is-outlined is-fullwidth"
                                                                    style="margin-top: 1.5em">
                                                                Daftar Sekarang
                                                            </button>
                                                        </div>
                                                    </div>
                                                </article>
                                                <article class="accordion">
                                                    <div
                                                            class="accordion-header is-radiusless has-background-white-ter is-pointer">
                                                        <div class="media">
                                                            <div class="media-left has-text-grey-dark">
                                                                <span class="icon is-small">
                                                                    <i class="fas fa-arrow-alt-circle-right"></i>
                                                                </span>
                                                            </div>
                                                            <div class="media-content">
                                                                <p class="subtitle is-6">Menari</p>
                                                            </div>
                                                        </div>
                                                        <div class="icon accordion-icon  has-text-grey-dark">
                                                            <i class="fa fa-plus-square" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-body has-background-white">
                                                        <div class="accordion-content">
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                            <strong>Pellentesque
                                                                risus mi</strong>, tempus quis placerat ut, porta nec
                                                            nulla.
                                                            Vestibulum rhoncus ac ex sit amet fringilla. Nullam gravida
                                                            purus
                                                            diam, et dictum <a>felis venenatis</a> efficitur. Aenean ac
                                                            <em>eleifend
                                                                lacus</em>, in mollis lectus. Donec sodales, arcu et
                                                            sollicitudin porttitor, tortor urna tempor ligula, id
                                                            porttitor mi
                                                            magna a neque. Donec dui urna, vehicula et sem eget,
                                                            facilisis
                                                            sodales sem.
                                                            <button class="button is-black-bis is-outlined is-fullwidth"
                                                                    style="margin-top: 1.5em">
                                                                Daftar Sekarang
                                                            </button>
                                                        </div>
                                                    </div>
                                                </article>
                                                <article class="accordion">
                                                    <div
                                                            class="accordion-header is-radiusless has-background-white-ter is-pointer">
                                                        <div class="media">
                                                            <div class="media-left has-text-grey-dark">
                                                                <span class="icon is-small">
                                                                    <i class="fas fa-arrow-alt-circle-right"></i>
                                                                </span>
                                                            </div>
                                                            <div class="media-content">
                                                                <p class="subtitle is-6">Menari</p>
                                                            </div>
                                                        </div>
                                                        <div class="icon accordion-icon  has-text-grey-dark">
                                                            <i class="fa fa-plus-square" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-body has-background-white">
                                                        <div class="accordion-content">
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                            <strong>Pellentesque
                                                                risus mi</strong>, tempus quis placerat ut, porta nec
                                                            nulla.
                                                            Vestibulum rhoncus ac ex sit amet fringilla. Nullam gravida
                                                            purus
                                                            diam, et dictum <a>felis venenatis</a> efficitur. Aenean ac
                                                            <em>eleifend
                                                                lacus</em>, in mollis lectus. Donec sodales, arcu et
                                                            sollicitudin porttitor, tortor urna tempor ligula, id
                                                            porttitor mi
                                                            magna a neque. Donec dui urna, vehicula et sem eget,
                                                            facilisis
                                                            sodales sem.
                                                            <button class="button is-black-bis is-outlined is-fullwidth"
                                                                    style="margin-top: 1.5em">
                                                                Daftar Sekarang
                                                            </button>
                                                        </div>
                                                    </div>
                                                </article>
                                                <article class="accordion">
                                                    <div
                                                            class="accordion-header is-radiusless has-background-white-ter is-pointer">
                                                        <div class="media">
                                                            <div class="media-left has-text-grey-dark">
                                                                <span class="icon is-small">
                                                                    <i class="fas fa-arrow-alt-circle-right"></i>
                                                                </span>
                                                            </div>
                                                            <div class="media-content">
                                                                <p class="subtitle is-6">Menari</p>
                                                            </div>
                                                        </div>
                                                        <div class="icon accordion-icon  has-text-grey-dark">
                                                            <i class="fa fa-plus-square" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-body has-background-white">
                                                        <div class="accordion-content">
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                            <strong>Pellentesque
                                                                risus mi</strong>, tempus quis placerat ut, porta nec
                                                            nulla.
                                                            Vestibulum rhoncus ac ex sit amet fringilla. Nullam gravida
                                                            purus
                                                            diam, et dictum <a>felis venenatis</a> efficitur. Aenean ac
                                                            <em>eleifend
                                                                lacus</em>, in mollis lectus. Donec sodales, arcu et
                                                            sollicitudin porttitor, tortor urna tempor ligula, id
                                                            porttitor mi
                                                            magna a neque. Donec dui urna, vehicula et sem eget,
                                                            facilisis
                                                            sodales sem.
                                                            <button class="button is-black-bis is-outlined is-fullwidth"
                                                                    style="margin-top: 1.5em">
                                                                Daftar Sekarang
                                                            </button>
                                                        </div>
                                                    </div>
                                                </article>
                                                <article class="accordion">
                                                    <div
                                                            class="accordion-header is-radiusless has-background-white-ter is-pointer">
                                                        <div class="media">
                                                            <div class="media-left has-text-grey-dark">
                                                                <span class="icon is-small">
                                                                    <i class="fas fa-arrow-alt-circle-right"></i>
                                                                </span>
                                                            </div>
                                                            <div class="media-content">
                                                                <p class="subtitle is-6">Menari</p>
                                                            </div>
                                                        </div>
                                                        <div class="icon accordion-icon  has-text-grey-dark">
                                                            <i class="fa fa-plus-square" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-body has-background-white">
                                                        <div class="accordion-content">
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                            <strong>Pellentesque
                                                                risus mi</strong>, tempus quis placerat ut, porta nec
                                                            nulla.
                                                            Vestibulum rhoncus ac ex sit amet fringilla. Nullam gravida
                                                            purus
                                                            diam, et dictum <a>felis venenatis</a> efficitur. Aenean ac
                                                            <em>eleifend
                                                                lacus</em>, in mollis lectus. Donec sodales, arcu et
                                                            sollicitudin porttitor, tortor urna tempor ligula, id
                                                            porttitor mi
                                                            magna a neque. Donec dui urna, vehicula et sem eget,
                                                            facilisis
                                                            sodales sem.
                                                            <button class="button is-black-bis is-outlined is-fullwidth"
                                                                    style="margin-top: 1.5em">
                                                                Daftar Sekarang
                                                            </button>
                                                        </div>
                                                    </div>
                                                </article>
                                                <article class="accordion">
                                                    <div
                                                            class="accordion-header is-radiusless has-background-white-ter is-pointer">
                                                        <div class="media">
                                                            <div class="media-left has-text-grey-dark">
                                                                <span class="icon is-small">
                                                                    <i class="fas fa-arrow-alt-circle-right"></i>
                                                                </span>
                                                            </div>
                                                            <div class="media-content">
                                                                <p class="subtitle is-6">Menari</p>
                                                            </div>
                                                        </div>
                                                        <div class="icon accordion-icon  has-text-grey-dark">
                                                            <i class="fa fa-plus-square" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-body has-background-white">
                                                        <div class="accordion-content">
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                            <strong>Pellentesque
                                                                risus mi</strong>, tempus quis placerat ut, porta nec
                                                            nulla.
                                                            Vestibulum rhoncus ac ex sit amet fringilla. Nullam gravida
                                                            purus
                                                            diam, et dictum <a>felis venenatis</a> efficitur. Aenean ac
                                                            <em>eleifend
                                                                lacus</em>, in mollis lectus. Donec sodales, arcu et
                                                            sollicitudin porttitor, tortor urna tempor ligula, id
                                                            porttitor mi
                                                            magna a neque. Donec dui urna, vehicula et sem eget,
                                                            facilisis
                                                            sodales sem.
                                                            <button class="button is-black-bis is-outlined is-fullwidth"
                                                                    style="margin-top: 1.5em">
                                                                Daftar Sekarang
                                                            </button>
                                                        </div>
                                                    </div>
                                                </article>
                                                <article class="accordion">
                                                    <div
                                                            class="accordion-header is-radiusless has-background-white-ter is-pointer">
                                                        <div class="media">
                                                            <div class="media-left has-text-grey-dark">
                                                                <span class="icon is-small">
                                                                    <i class="fas fa-arrow-alt-circle-right"></i>
                                                                </span>
                                                            </div>
                                                            <div class="media-content">
                                                                <p class="subtitle is-6">Menari</p>
                                                            </div>
                                                        </div>
                                                        <div class="icon accordion-icon  has-text-grey-dark">
                                                            <i class="fa fa-plus-square" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-body has-background-white">
                                                        <div class="accordion-content">
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                            <strong>Pellentesque
                                                                risus mi</strong>, tempus quis placerat ut, porta nec
                                                            nulla.
                                                            Vestibulum rhoncus ac ex sit amet fringilla. Nullam gravida
                                                            purus
                                                            diam, et dictum <a>felis venenatis</a> efficitur. Aenean ac
                                                            <em>eleifend
                                                                lacus</em>, in mollis lectus. Donec sodales, arcu et
                                                            sollicitudin porttitor, tortor urna tempor ligula, id
                                                            porttitor mi
                                                            magna a neque. Donec dui urna, vehicula et sem eget,
                                                            facilisis
                                                            sodales sem.
                                                            <button class="button is-black-bis is-outlined is-fullwidth"
                                                                    style="margin-top: 1.5em">
                                                                Daftar Sekarang
                                                            </button>
                                                        </div>
                                                    </div>
                                                </article>
                                                <article class="accordion">
                                                    <div
                                                            class="accordion-header is-radiusless has-background-white-ter is-pointer">
                                                        <div class="media">
                                                            <div class="media-left has-text-grey-dark">
                                                                <span class="icon is-small">
                                                                    <i class="fas fa-arrow-alt-circle-right"></i>
                                                                </span>
                                                            </div>
                                                            <div class="media-content">
                                                                <p class="subtitle is-6">Menari</p>
                                                            </div>
                                                        </div>
                                                        <div class="icon accordion-icon  has-text-grey-dark">
                                                            <i class="fa fa-plus-square" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-body has-background-white">
                                                        <div class="accordion-content">
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                            <strong>Pellentesque
                                                                risus mi</strong>, tempus quis placerat ut, porta nec
                                                            nulla.
                                                            Vestibulum rhoncus ac ex sit amet fringilla. Nullam gravida
                                                            purus
                                                            diam, et dictum <a>felis venenatis</a> efficitur. Aenean ac
                                                            <em>eleifend
                                                                lacus</em>, in mollis lectus. Donec sodales, arcu et
                                                            sollicitudin porttitor, tortor urna tempor ligula, id
                                                            porttitor mi
                                                            magna a neque. Donec dui urna, vehicula et sem eget,
                                                            facilisis
                                                            sodales sem.
                                                            <button class="button is-black-bis is-outlined is-fullwidth"
                                                                    style="margin-top: 1.5em">
                                                                Daftar Sekarang
                                                            </button>
                                                        </div>
                                                    </div>
                                                </article>
                                                <article class="accordion">
                                                    <div
                                                            class="accordion-header is-radiusless has-background-white-ter is-pointer">
                                                        <div class="media">
                                                            <div class="media-left has-text-grey-dark">
                                                                <span class="icon is-small">
                                                                    <i class="fas fa-arrow-alt-circle-right"></i>
                                                                </span>
                                                            </div>
                                                            <div class="media-content">
                                                                <p class="subtitle is-6">Menari</p>
                                                            </div>
                                                        </div>
                                                        <div class="icon accordion-icon  has-text-grey-dark">
                                                            <i class="fa fa-plus-square" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-body has-background-white">
                                                        <div class="accordion-content">
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                            <strong>Pellentesque
                                                                risus mi</strong>, tempus quis placerat ut, porta nec
                                                            nulla.
                                                            Vestibulum rhoncus ac ex sit amet fringilla. Nullam gravida
                                                            purus
                                                            diam, et dictum <a>felis venenatis</a> efficitur. Aenean ac
                                                            <em>eleifend
                                                                lacus</em>, in mollis lectus. Donec sodales, arcu et
                                                            sollicitudin porttitor, tortor urna tempor ligula, id
                                                            porttitor mi
                                                            magna a neque. Donec dui urna, vehicula et sem eget,
                                                            facilisis
                                                            sodales sem.
                                                            <button class="button is-black-bis is-outlined is-fullwidth"
                                                                    style="margin-top: 1.5em">
                                                                Daftar Sekarang
                                                            </button>
                                                        </div>
                                                    </div>
                                                </article>
                                                <article class="accordion">
                                                    <div
                                                            class="accordion-header is-radiusless has-background-white-ter is-pointer">
                                                        <div class="media">
                                                            <div class="media-left has-text-grey-dark">
                                                                <span class="icon is-small">
                                                                    <i class="fas fa-arrow-alt-circle-right"></i>
                                                                </span>
                                                            </div>
                                                            <div class="media-content">
                                                                <p class="subtitle is-6">Menari</p>
                                                            </div>
                                                        </div>
                                                        <div class="icon accordion-icon  has-text-grey-dark">
                                                            <i class="fa fa-plus-square" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-body has-background-white">
                                                        <div class="accordion-content">
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                            <strong>Pellentesque
                                                                risus mi</strong>, tempus quis placerat ut, porta nec
                                                            nulla.
                                                            Vestibulum rhoncus ac ex sit amet fringilla. Nullam gravida
                                                            purus
                                                            diam, et dictum <a>felis venenatis</a> efficitur. Aenean ac
                                                            <em>eleifend
                                                                lacus</em>, in mollis lectus. Donec sodales, arcu et
                                                            sollicitudin porttitor, tortor urna tempor ligula, id
                                                            porttitor mi
                                                            magna a neque. Donec dui urna, vehicula et sem eget,
                                                            facilisis
                                                            sodales sem.
                                                            <button class="button is-black-bis is-outlined is-fullwidth"
                                                                    style="margin-top: 1.5em">
                                                                Daftar Sekarang
                                                            </button>
                                                        </div>
                                                    </div>
                                                </article>
                                                <article class="accordion">
                                                    <div
                                                            class="accordion-header is-radiusless has-background-white-ter is-pointer">
                                                        <div class="media">
                                                            <div class="media-left has-text-grey-dark">
                                                                <span class="icon is-small">
                                                                    <i class="fas fa-arrow-alt-circle-right"></i>
                                                                </span>
                                                            </div>
                                                            <div class="media-content">
                                                                <p class="subtitle is-6">Menari</p>
                                                            </div>
                                                        </div>
                                                        <div class="icon accordion-icon  has-text-grey-dark">
                                                            <i class="fa fa-plus-square" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-body has-background-white">
                                                        <div class="accordion-content">
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                            <strong>Pellentesque
                                                                risus mi</strong>, tempus quis placerat ut, porta nec
                                                            nulla.
                                                            Vestibulum rhoncus ac ex sit amet fringilla. Nullam gravida
                                                            purus
                                                            diam, et dictum <a>felis venenatis</a> efficitur. Aenean ac
                                                            <em>eleifend
                                                                lacus</em>, in mollis lectus. Donec sodales, arcu et
                                                            sollicitudin porttitor, tortor urna tempor ligula, id
                                                            porttitor mi
                                                            magna a neque. Donec dui urna, vehicula et sem eget,
                                                            facilisis
                                                            sodales sem.
                                                            <button class="button is-black-bis is-outlined is-fullwidth"
                                                                    style="margin-top: 1.5em">
                                                                Daftar Sekarang
                                                            </button>
                                                        </div>
                                                    </div>
                                                </article>
                                                <article class="accordion is-hidden">
                                                    <div
                                                            class="accordion-header is-radiusless has-background-white-ter is-pointer">
                                                        <div class="media">
                                                            <div class="media-left has-text-grey-dark">
                                                                <span class="icon is-small">
                                                                    <i class="fas fa-arrow-alt-circle-right"></i>
                                                                </span>
                                                            </div>
                                                            <div class="media-content">
                                                                <p class="subtitle is-6">a</p>
                                                            </div>
                                                        </div>
                                                        <div class="icon accordion-icon  has-text-grey-dark">
                                                            <i class="fa fa-plus-square" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-body has-background-white">
                                                        <div class="accordion-content">
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                            <strong>Pellentesque
                                                                risus mi</strong>, tempus quis placerat ut, porta nec
                                                            nulla.
                                                            Vestibulum rhoncus ac ex sit amet fringilla. Nullam gravida
                                                            purus
                                                            diam, et dictum <a>felis venenatis</a> efficitur. Aenean ac
                                                            <em>eleifend
                                                                lacus</em>, in mollis lectus. Donec sodales, arcu et
                                                            sollicitudin porttitor, tortor urna tempor ligula, id
                                                            porttitor mi
                                                            magna a neque. Donec dui urna, vehicula et sem eget,
                                                            facilisis
                                                            sodales sem.
                                                            <button class="button is-black-bis is-outlined is-fullwidth"
                                                                    style="margin-top: 1.5em">
                                                                Daftar Sekarang
                                                            </button>
                                                        </div>
                                                    </div>
                                                </article>
                                            </section>
                                        </div>
                                        <div class="card-footer">
                                            <button
                                                    class="button is-black-bis is-outlined is-fullwidth is-radiusless is-show">
                                                Lihat Lebih Banyak
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="columns is-multiline">
                        <div class="column is-full">
                            <nav class="panel animated bounceInRight">
                                <p class="panel-heading has-background-warning is-radiusless">
                            <span class="level">
                                <span class="level-left" style="text-align: center">
                                    <span class="level-item title is-5 has-text-centered">Announcement</span>
                                </span>
                                <span class="level-right">
                                    <span class="level-item icon">
                                        <i class="fa fa-bullhorn faa-wrench"></i>
                                    </span>
                                </span>
                            </span>
                                </p>
                                <div class="panel-block has-background-light">
                                    <p class="control has-icons-left">
                                        <input class="input is-small loading-input" type="text"
                                               placeholder="cari sesuatu disini...">
                                        <span class="icon is-small is-left">
                                    <i class="fas fa-search" aria-hidden="true"></i>
                                </span>
                                    </p>
                                </div>
                                <p class="panel-tabs has-background-light">
                                    <a class="is-active">semua</a>
                                    <a>info</a>
                                    <a>bantuan</a>
                                    <a>kegiatan</a>
                                </p>
                                <div class="has-background-white-bis scroll-add border-vertical">
                                    <a class="panel-block is-borderless-right">
                            <span class="panel-icon">
                                <i class="fas fa-arrow-alt-circle-right"></i>
                            </span>
                                        <span class="panel-content">
                                marksheet
                                </span>
                                        <span
                                                style="position:relative; right: -5em; display: flex; font-size:12px; align-items: center;"
                                                class="has-text-grey">
                                    <span class="icon">
                                        <i class="far fa-clock"></i>
                                    </span>
                                    12/12/2012
                                </span>
                                    </a>
                                    <a class="panel-block is-borderless-right">
                            <span class="panel-icon">
                                <i class="fas fa-arrow-alt-circle-right"></i>
                            </span>
                                        <span class="panel-content">
                                marksheet
                                </span>
                                        <span
                                                style="position:relative; right: -11.5em; display: flex; font-size:12px; align-items: center;"
                                                class="has-text-grey">
                                    <span class="icon">
                                        <i class="far fa-clock"></i>
                                    </span>
                                    12/12/2012
                                </span>
                                    </a>
                                    <a class="panel-block is-borderless-right">
                            <span class="panel-icon">
                                <i class="fas fa-arrow-alt-circle-right"></i>
                            </span>
                                        <span class="panel-content">
                                marksheet
                                </span>
                                        <span
                                                style="position:relative; right: -11.5em; display: flex; font-size:12px; align-items: center;"
                                                class="has-text-grey">
                                    <span class="icon">
                                        <i class="far fa-clock"></i>
                                    </span>
                                    12/12/2012
                                </span>
                                    </a>
                                    <a class="panel-block is-borderless-right">
                            <span class="panel-icon">
                                <i class="fas fa-arrow-alt-circle-right"></i>
                            </span>
                                        <span class="panel-content">
                                marksheet
                                </span>
                                        <span
                                                style="position:relative; right: -11.5em; display: flex; font-size:12px; align-items: center;"
                                                class="has-text-grey">
                                    <span class="icon">
                                        <i class="far fa-clock"></i>
                                    </span>
                                    12/12/2012
                                </span>
                                    </a>
                                    <a class="panel-block is-borderless-right">
                            <span class="panel-icon">
                                <i class="fas fa-arrow-alt-circle-right"></i>
                            </span>
                                        <span class="panel-content">
                                marksheet
                                </span>
                                        <span
                                                style="position:relative; right: -11.5em; display: flex; font-size:12px; align-items: center;"
                                                class="has-text-grey">
                                    <span class="icon">
                                        <i class="far fa-clock"></i>
                                    </span>
                                    12/12/2012
                                </span>
                                    </a>
                                    <a class="panel-block is-borderless-right">
                            <span class="panel-icon">
                                <i class="fas fa-arrow-alt-circle-right"></i>
                            </span>
                                        <span class="panel-content">
                                marksheet
                                </span>
                                        <span
                                                style="position:relative; right: -11.5em; display: flex; font-size:12px; align-items: center;"
                                                class="has-text-grey">
                                    <span class="icon">
                                        <i class="far fa-clock"></i>
                                    </span>
                                    12/12/2012
                                </span>
                                    </a>
                                    <a class="panel-block is-borderless-right">
                            <span class="panel-icon">
                                <i class="fas fa-arrow-alt-circle-right"></i>
                            </span>
                                        <span class="panel-content">
                                marksheet
                                </span>
                                        <span
                                                style="position:relative; right: -11.5em; display: flex; font-size:12px; align-items: center;"
                                                class="has-text-grey">
                                    <span class="icon">
                                        <i class="far fa-clock"></i>
                                    </span>
                                    12/12/2012
                                </span>
                                    </a>
                                    <a class="panel-block is-borderless-right">
                            <span class="panel-icon">
                                <i class="fas fa-arrow-alt-circle-right"></i>
                            </span>
                                        <span class="panel-content">
                                marksheet
                                </span>
                                        <span
                                                style="position:relative; right: -11.5em; display: flex; font-size:12px; align-items: center;"
                                                class="has-text-grey">
                                    <span class="icon">
                                        <i class="far fa-clock"></i>
                                    </span>
                                    12/12/2012
                                </span>
                                    </a>

                                </div>
                                <div class="panel-block has-background-white-bis" style="border-top:1px solid #D0D1CD ">
                                    <button class="button is-black-bis is-outlined is-fullwidth">
                                        Lihat Lebih Banyak
                                    </button>
                                </div>
                            </nav>
                        </div>
                        <div class="column is-full">
                            <div class="card">
                                <header class="card-header has-background-warning">
                                    <p class="card-header-title">
                                        Donasi
                                    </p>
                                    <a href="#" class="card-header-icon" aria-label="more options">
                                        <span class="icon has-text-black-ter">
                                            <i class="fas fa-piggy-bank" aria-hidden="true"></i>
                                        </span>
                                    </a>
                                </header>
                                <div class="card-content">
                                    <div class="content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec iaculis
                                        mauris.
                                        <a href="#">@bulmaio</a>. <a href="#">#css</a> <a href="#">#responsive</a>
                                        <br>
                                        <time datetime="2016-1-1">11:09 PM - 1 Jan 2016</time>

                                        <button class="button is-black-bis is-outlined is-fullwidth"
                                                style="margin-top: 1em">
                                            Donasi
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column is-full">
                            <div class="card">
                                <header class="card-header has-background-warning">
                                    <p class="card-header-title">
                                        Kontak
                                    </p>
                                    <a href="#" class="card-header-icon" aria-label="more options">
                                        <span class="icon has-text-black-ter">
                                            <i class="fas fa-map-marked-alt" aria-hidden="true"></i>
                                        </span>
                                    </a>
                                </header>
                                <div class="card-content">
                                    <div class="content">
                                        <table class="is-borderless">
                                            <tr>
                                                <td style="width: 5em">No Telp. </td>
                                                <td >:</td>
                                                <td><a href="tel:1-562-867-5309">1-562-867-5309</a></td>
                                            </tr>
                                            <tr>
                                                <td>Email </td>
                                                <td>:</td>
                                                <td><a href="mailto:vreallyla@gmail.com">vreallyla@gmail.com</a> </td>
                                            </tr>
                                            <tr>
                                                <td>Alamat </td>
                                                <td>:</td>
                                                <td><a href="">Jalan Pesona Alam Gunung Anyar I B 12 No.25, Gunung Anyar, Surabaya City, East Java 60294</a></td>
                                            </tr>
                                        </table>

                                        <button class="button is-black-bis is-outlined is-fullwidth"
                                                style="margin-top: 1em">
                                            Kirim Pesan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<footer class="footer has-background-black-ter">
    <div class="content has-text-centered has-text-white-ter">
        <p>
            <strong class="has-text-white-ter title">Bulma</strong> by <a href="https://jgthms.com">Jeremy Thomas</a>.
            The source code is licensed
            <a href="http://opensource.org/licenses/mit-license.php">MIT</a>. The website content
            is licensed <a href="http://creativecommons.org/licenses/by-nc-sa/4.0/">CC BY NC SA 4.0</a>.
        </p>
    </div>
</footer>

<script src="{{asset('js/app.js')}}"></script>


<script>

    (function () {
        var carousels = bulma_ext.bulmaCarousel.attach(); // carousels now contains an array of all Carousel instances
        var accordions = bulma_ext.bulmaAccordion.attach(); //bulma's accordion
        jQuery(carousels).on('carousel:slide:before', function (item) {
            console.log(item);
        });
    })();

    function set_time_add($content, $el, $timer) {
        setTimeout(function () {
            $($el).addClass($content);
        }, $timer);
    }

    function set_time_remove($content, $el, $timer) {
        setTimeout(function () {
            $el.removeClass($content);
        }, $timer);
    }

    // click
    (function () {
        var backtop = $('.back-top');
        var toggle_program = $('.accordions');

        backtop.hover(function () {
            $(this).addClass('bounce');
            set_time_remove('bounce', $(this), 1000);
        });
        backtop.click(function () {
            $('html, body').animate({
                scrollTop: 0
            }, 1000);
        });

        toggle_program.on('click', '.accordion-header', function () {
            $fa = $(this).find('.fa');
            $fa_contents = $('.fa-minus-square');
            if ($(this).parent().hasClass('is-active')) {
                if ($.trim($fa_contents)) {
                    $fa_contents.removeClass('fa-minus-square').addClass('fa-plus-square');
                    console.log($fa_contents);
                }
                $fa.removeClass('fa-plus-square').addClass('fa-minus-square');

            }
            else {
                $fa_contents.removeClass('fa-minus-square').addClass('fa-plus-square');
            }
        });

        $('.panel-block').on('focus', '.input', function () {
            $bullhorn = $(this).closest('.panel-block').prev().find('i');
            $bullhorn.addClass('animated');
            set_time_remove('animated', $bullhorn, 900);
        })
    })();
    // end click

</script>
</body>
</html>
