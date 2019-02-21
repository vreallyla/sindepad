@extends ('layouts/mst_user')
@section('desc',substr(strip_tags($dataN->data->detail),0,50))
@section('key','children needed, autis, disability, anak berkebutuhan khusus, abk, children needed fundraising, '.$dataN->data->name.', '.env('APP_NAME'))
@section('content')

    <div class="ed_pagetitle" data-stellar-background-ratio="0.5" data-stellar-vertical-offset="0"
         style="background-image: url({{$parralax}});">
        <div class="ed_img_overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-4 col-sm-6">
                    <div class="page_title">
                        <h2>Detail Penggalangan Dana</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-8 col-sm-6">
                    <ul class="breadcrumb">
                        <li><a href="{{route('welcome')}}">Beranda</a></li>
                        <li><i class="fa fa-chevron-left"></i></li>
                        <li><a href="{{route('fundraising.all')}}">Bantuan</a></li>
                        <li><i class="fa fa-chevron-left"></i></li>
                        <li><a href="#">Detail</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="ed_graysection ed_course_single ed_toppadder80 ed_bottompadder80">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div class="ed_course_single_item">
                        <div class="ed_course_single_image ed_blog_image" style="height: 18em;">
                            <img src="{{$dataN->data->img}}"
                                 alt="event image"/>
                        </div>
                        <div class="ed_course_single_tab">
                            <div role="tabpanel">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#description"
                                                                              aria-controls="description" role="tab"
                                                                              data-toggle="tab">Deskripsi</a></li>
                                    <li role="presentation"><a href="#news" aria-controls="news" role="tab"
                                                               data-toggle="tab">Cara Menyumbang</a></li>
                                    <li role="presentation"><a href="#forms" aria-controls="news" role="tab"
                                                               data-toggle="tab">Form Penyumbang</a></li>

                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="description">
                                        <div class="ed_course_tabconetent">
                                            <h2>{{$dataN->data->name}}</h2>
                                            <i class="fa fa-calendar" style="color: #3ABAC6"></i>
                                            <span>Tanggal : {{\Carbon\Carbon::parse($dataN->data->created_at)->formatLocalized('%d %B %Y')}}</span>
                                            {!! $dataN->data->detail !!}
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="news">
                                        <div class="ed_course_tabconetent">
                                            <h2>Cara Menyumbang</h2>
                                            <ul class="make-accordion">
                                                <li>
                                                    <input type="checkbox" checked>
                                                    <i></i>
                                                    <h2 class="title-accordion">Melalui Transfer Bank</h2>
                                                    <p class="content-accordion">
                                                        - kamu dapat transfer sesuai informasi deskripsi. <br>
                                                        - Gunakan Kode "<strong>{{$dataN->data->code}}</strong>" pada
                                                        nomer refrensi <br>
                                                        - Jangan lupa masukkan informasi kedalam form penyumbang agar
                                                        sumbangan terdaftar.
                                                    </p>
                                                </li>
                                                <li>
                                                    <input type="checkbox" checked>
                                                    <i></i>
                                                    <h2 class="title-accordion">Opsional Lain</h2>
                                                    <p class="content-accordion">
                                                        Kamu dapat menghubungi kontak kami untuk opsional lain.
                                                    </p>
                                                </li>
                                            </ul>

                                        </div>
                                    </div>
                                    @include('fundraising.fundraisingForm')
                                </div>
                            </div>
                        </div><!--tab End-->
                    </div>
                </div>
                <!--Sidebar Start-->
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="sidebar_wrapper_upper">
                        <div class="sidebar_wrapper">

                            <aside class="widget widget_sharing">
                                <h4 class="widget-title">Bagikan penggalangan Dana ini</h4>
                                <ul>
                                    <li>
                                        <a target="_blank"
                                           href="https://www.facebook.com/sharer/sharer.php?u={{route('fundraising.single',$dataN->data->key)}}&amp;src=sdkpreparse"
                                           class="fb-xfbml-parse-ignore"><i class="fa fa-facebook"></i> facebook</a>
                                    </li>
                                    <li><a target="_blank"
                                           href="http://www.linkedin.com/shareArticle?mini=true&url={{route('course.opsi',$dataN->data->key)}}
                                                   &title={{'Bantu '.$dataN->data->name.' di '.env('APP_NAME')}}&source={{route('fundraising.single',$dataN->data->key)}}"><i
                                                    class="fa fa-linkedin"></i> linkedin</a></li>
                                    <li><a target="_blank"
                                           href="https://twitter.com/intent/tweet?text=Sekarang%20saya%20mengunjungi%20{{route('fundraising.single',$dataN->data->key)}}"><i
                                                    class="fa fa-twitter"></i> twitter</a></li>
                                    <li><a target="_blank"
                                           href="https://plus.google.com/share?url={{route('fundraising.single',$dataN->data->key)}}"><i
                                                    class="fa fa-google-plus"></i> google+</a></li>
                                </ul>
                            </aside>
                            <aside class="widget widget_search">
                                <h4 class="widget-title">Target Sumbangan</h4>
                                <div class="col-lg-12" style="padding: 0px">
                                    <span class="nominal-target">Rp{{$dataN->data->target>999?substr(number_format($dataN->data->target,0,',','.'),0,-4).'K':$dataN->data->target}}</span>
                                    <span class="percent-target">{{number_format($dataN->data->collected*100/$dataN->data->target,0)}}%</span>
                                    <div class="meter" style="width: 100%;" data-toggle="tooltip" data-placement="top" title="Dapat: Rp{{$dataN->data->collected>999?substr(number_format($dataN->data->collected,0,',','.'),0,-4).'K':$dataN->data->collected}}">
                                        <span style="width: {{ceil($dataN->data->collected*100/$dataN->data->target)}}%;"></span>
                                    </div>
                                </div>
                            </aside>
                        </div>
                    </div>
                </div>
                <!--Sidebar End-->
            </div>
        </div>
    </div>


@endsection

@push('js')
    @include('fundraising._script_search')
@endpush

@push('style')
    <style>
        /* PROGRESS BAR - BASE */
        .meter {
            height: 12px;
            position: relative;
            background: #DCE0E3;
            border-radius: 8px;
        }

        .dark {
            background: #4D575F;
        }

        .meter > span {
            display: block;
            height: 100%;
            -webkit-border-top-right-radius: 8px;
            -webkit-border-bottom-right-radius: 8px;
            -moz-border-radius-topright: 8px;
            -moz-border-radius-bottomright: 8px;
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
            -webkit-border-top-left-radius: 20px;
            -webkit-border-bottom-left-radius: 20px;
            -moz-border-radius-topleft: 20px;
            -moz-border-radius-bottomleft: 20px;
            border-top-left-radius: 20px;
            border-bottom-left-radius: 20px;
            background-color: #3abac6;
            position: relative;
            overflow: hidden;
            max-width: 100%;
        }

        .meter > span:after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            background-image: -o-linear-gradient(-45deg, #3abac6 25%, transparent 25%, transparent 50%, #3abac6 50%, #3abac6 75%, transparent 75%, transparent);
            z-index: 1;
            background-size: 20px 20px;
            -webkit-animation: move 2s linear infinite;
            -webkit-border-top-right-radius: 8px;
            -webkit-border-bottom-right-radius: 8px;
            -moz-border-radius-topright: 8px;
            -moz-border-radius-bottomright: 8px;
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
            -webkit-border-top-left-radius: 20px;
            -webkit-border-bottom-left-radius: 20px;
            -moz-border-radius-topleft: 20px;
            -moz-border-radius-bottomleft: 20px;
            border-top-left-radius: 20px;
            border-bottom-left-radius: 20px;
            overflow: hidden;
        }

        /* PROGRESS BAR - ANIMATION */
        .transition, .content-accordion, .make-accordion li i:before, .make-accordion li i:after {
            transition: all 0.25s ease-in-out;
        }

        .flipIn, .make-accordion li, #description, #forms {
            animation: flipdown 0.5s ease both;
        }

        .no-select, .title-accordion {
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .title-accordion {
            color: #4c4e4a;
            font-size: 22px !important;
        }


        .title-accordion {
            font-size: 26px;
            line-height: 34px;
            font-weight: 300;
            letter-spacing: 1px;
            display: block;
            background-color: #fefffa;
            margin: 0;
            cursor: pointer;
        }

        .content-accordion {
            color: rgba(48, 69, 92, 0.8);
            font-size: 17px;
            line-height: 26px;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
            max-height: 800px;
            opacity: 1;
            transform: translate(0, 0);
            margin-top: 14px;
            z-index: 2;
            float: unset !important;
        }

        .make-accordion {
            list-style: none;
            perspective: 900;
            padding: 0;
            margin: 0;
        }

        .make-accordion li {
            position: relative;
            padding: 0;
            margin: 0;
            padding-bottom: 4px;
            padding-top: 18px;
            border-top: 1px dotted #dce7eb;
        }

        /*.make-accordion li:nth-of-type(1) {*/
        /*animation-delay: 0.5s;*/
        /*}*/
        /*.make-accordion li:nth-of-type(2) {*/
        /*animation-delay: 0.75s;*/
        /*}*/
        /*.make-accordion li:nth-of-type(3) {*/
        /*animation-delay: 1s;*/
        /*}*/
        /*.make-accordion li:last-of-type {*/
        /*padding-bottom: 0;*/
        /*}*/
        .make-accordion li i {
            position: absolute;
            transform: translate(-6px, 0);
            margin-top: 16px;
            right: 0;
        }

        .make-accordion li i:before, .make-accordion li i:after {
            content: "";
            position: absolute;
            background-color: #3abac6;
            width: 3px;
            height: 9px;
        }

        .make-accordion li i:before {
            transform: translate(-2px, 0) rotate(45deg);
        }

        .make-accordion li i:after {
            transform: translate(2px, 0) rotate(-45deg);
        }

        .make-accordion li input[type=checkbox] {
            position: absolute;
            cursor: pointer;
            width: 100%;
            height: 100%;
            z-index: 1;
            opacity: 0;
        }

        .make-accordion li input[type=checkbox]:checked ~ p {
            margin-top: 0;
            max-height: 0;
            opacity: 0;
            transform: translate(0, 50%);
        }

        .make-accordion li input[type=checkbox]:checked ~ i:before {
            transform: translate(2px, 0) rotate(45deg);
        }

        .make-accordion li input[type=checkbox]:checked ~ i:after {
            transform: translate(-2px, 0) rotate(-45deg);
        }

        @keyframes flipdown {
            0% {
                opacity: 0;
                transform-origin: top center;
                transform: rotateX(-90deg);
            }
            5% {
                opacity: 1;
            }
            80% {
                transform: rotateX(8deg);
            }
            83% {
                transform: rotateX(6deg);
            }
            92% {
                transform: rotateX(-3deg);
            }
            100% {
                transform-origin: top center;
                transform: rotateX(0deg);
            }
        }

        /*accordion*/
    </style>
@endpush