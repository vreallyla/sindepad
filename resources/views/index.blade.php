@extends ('layouts/mst_user')
@section('desc','rahasia')
@section('key','anu')

@section('content')
    <div class="ed_slider_form_section">
        <!--Slider start-->
        <section class="ed_mainslider">
            <article class="content">
                <div class="rev_slider_wrapper">
                    <!-- START REVOLUTION SLIDER 5.0 auto mode -->
                    <div id="rev_slider_4_1_wrapper" class="rev_slider_wrapper fullwidthbanner-container"
                         data-alias="classicslider1"
                         style="margin:0px auto;background-color:transparent;padding:0px;margin-top:0px;margin-bottom:0px;">
                        <div id="rev_slider" class="rev_slider " data-version="5.0">
                            <ul>
                                <!-- SLIDE  -->
                                @foreach( $slide as $row)
                                    <li data-transition="slotslide-horizontal">

                                        <!-- MAIN IMAGE -->
                                        <img src="{{asset($row->img)}}" alt="">
                                        <div class="ed_course_single_image_overlay"></div>

                                        <!-- LAYER NR. 1 -->
                                        <div class="tp-caption NotGeneric-Title   tp-resizeme rs-parallaxlevel-0"

                                             data-x="['left','left','left','left']" data-hoffset="['45','60','60','40']"
                                             data-y="['top','top','top','top']" data-voffset="['170','175','155','115']"


                                             data-width="none"
                                             data-height="none"
                                             data-whitespace="nowrap"
                                             data-transform_idle="o:1;"

                                             data-transform_in="x:-50px;skX:100px;opacity:0;s:2000;e:Power4.easeInOut;"
                                             data-transform_out="s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;"
                                             data-start="1510"
                                             data-splitin="none"
                                             data-splitout="none"
                                             data-responsive_offset="on"

                                             data-elementdelay="0.05"

                                             style="z-index: 5; white-space: nowrap; font-size: 50px; color:#fff;     font-family: 'Roboto Slab', serif;">
                                            {{$row->desc}}
                                        </div>

                                        <!-- LAYER NR. 2 -->
                                        <div class="tp-caption NotGeneric-CallToAction ed_btn ed_green tp-resizeme rs-parallaxlevel-0"

                                             data-x="['left','left','left','left']" data-hoffset="['50','65','65','45']"
                                             data-y="['top','top','top','top']" data-voffset="['350','276','226','151']"

                                             data-whitespace="nowrap"
                                             data-transform_idle="o:1;"

                                             data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;"
                                             data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;"
                                             data-mask_in="x:0px;y:[100%];s:inherit;e:inherit;"
                                             data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;"
                                             data-start="2000"
                                             data-splitin="none"
                                             data-splitout="none"
                                             data-responsive_offset="on"

                                             style="z-index: 7; white-space: nowrap; "
                                             onclick="window.location='{{$row->link}}';">Selengkapnya
                                        </div>

                                    </li>
                            @endforeach

                            <!-- SLIDE  -->

                            </ul>
                        </div><!-- END REVOLUTION SLIDER -->
                    </div><!-- END  -->
                </div><!-- END REVOLUTION SLIDER WRAPPER -->
            </article>
        </section>
        <!--Slider end-->
        <!--Slider form start-->
        <div class="ed_form_box">
            <div class="container">
                <div class="ed_search_form">
                    <form class="form-inline" method="post" action="{{route('order.first')}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input type="text" placeholder="Nama Lengkap Pendaftar" class="form-control" name="name"
                                   value="{{ old('name') }}">
                            @if (isset($errors)&&$errors->has('name'))
                                <span class="help-block" style="color: #fff;">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="sex">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                @foreach($gender as $row)
                                    <option value="{{$row->id}}"
                                            @if(old('sex')===$row->id)selected @endif>{{$row->ind}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('sex'))
                                <span class="help-block" style="color: #fff;">
                                        <strong>{{ $errors->first('sex') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="rel">
                                <option value="" selected disabled>-- Pilih Hubungan --</option>
                                @foreach($hub as $row)
                                    <option value="{{$row->id}}"
                                            @if(old('rel')===$row->id)selected @endif>{{$row->ind}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('rel'))
                                <span class="help-block" style="color: #fff;">
                                        <strong>{{ $errors->first('rel') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <select class="selectpicker anu" data-container="body" name="needed[]" multiple>

                                @foreach($needed as $row)
                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('needed'))
                                <span class="help-block" style="color: #fff;">
                                        <strong>{{ $errors->first('needed') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="ed_dots"><p><span class="glyphicon glyphicon-option-horizontal"
                                                          aria-hidden="true"></span></p></div>
                            <button type="submit" class="btn ed_btn pull-right ed_orange">Daftar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--Slider form end-->
    </div>

    <!--Our expertise section one start -->
    <div class="ed_transprentbg ed_toppadder100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="ed_heading_top ed_toppadder50">
                        <h3>Daftar Program Kami</h3>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="ed_populer_areas_slider">
                        <div class="owl-carousel owl-theme">
                            @foreach($default[1] as $row)
                                <div class="item">
                                    <div class="ed_item_img">
                                        <img src="{{asset($row->url)}}" alt="item1"
                                             class="img-responsive">
                                    </div>
                                    <div class="ed_item_description">
                                        <h4>{{$row->name}}</h4>
                                        <p>{{strlen(strip_tags($row->summary))>60?substr(strip_tags($row->summary),0,60).'...':strip_tags($row->summary)}}</p>
                                        <a href="{{route('course.opsi',$row->id)}}" class="ed_getinvolved">Selengkapnya
                                            <i
                                                    class="fa fa-long-arrow-right"></i></a>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container -->
    </div>
    <!--Our expertise section one end -->


    <!--skill section start -->

    <div class="ed_graysection ed_toppadder90 ed_bottompadder90">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="skill_section">
                        <h4><a href="#">Informasi</a></h4>
                        <p>Tanya apa saja terkait {{env('APP_NAME')}}, kami akan membalas segera mungkin.</p>
                        <span><i class="fa fa-map-signs"></i></span>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="skill_section">
                        <h4><a href="#">Penerimaan Peserta Didik</a></h4>
                        <p>Segera daftar dan jadilah bagian dari {{env('APP_NAME')}} yang terus berkembang.</p>
                        <span><i class="fa fa-user-plus"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--skill section end -->
    <!--video_section Section three start -->
    <div class="ed_parallax_section" data-stellar-background-ratio="0.5" data-stellar-vertical-offset="100"
         style="background-image: url({{$parralax}});">
        <div class="ed_img_overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="ed_video_section">
                        <div class="embed-responsive embed-responsive-16by9">
                            <div class="ed_video">
                                <img src="{{asset('images/video.jpg')}}" style="cursor:pointer" alt="1"/>
                                <div class="ed_img_overlay">
                                    <a href="#"><i class="fa fa-chevron-right"></i></a>
                                </div>
                            </div>
                            <iframe id="educo_video" class="embed-responsive-item"
                                    src="https://www.youtube.com/embed/0kKQ1JRmWS8" allowfullscreen></iframe>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="ed_video_section_discription">
                        <h4>Profil Perusahaan</h4>
                        <p>Ketahui {{env('APP_NAME')}} lebih dalam melalui video profil kami. {{env('APP_NAME')}}
                            merupakan bagian dari QIS (Kampung inggris Surabaya) yang terletak
                            di {{$default[0]->address}}.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--video_section Section three end -->
    <!-- Most recomended Courses Section four start -->
    <div class="ed_transprentbg ed_toppadder80 ed_bottompadder80">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="ed_heading_top ed_bottompadder80">
                        <h3>Lihat Artikel</h3>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="ed_mostrecomeded_course_slider ed_mostrecomededcourseslider">
                        <div id="owl-demo3" class="owl-carousel owl-theme">
                            @foreach($news as $i=>$new)
                                <div class="item">
                                    <div class="ed_item_img">
                                        <img src="{{\Illuminate\Support\Facades\File::exists($new->img) ? asset($new->img) : asset('images/img_unvailable.png')}}"
                                             alt="item{{$i}}" class="img-responsive">
                                    </div>
                                    <div class="ed_item_description ed_most_recomended_data">
                                        <h4><a href="{{route('blog.single',$new->id)}}">{{$new->name}}</a></h4>
                                        <p>{{strlen(strip_tags($new->desc))>150?substr(strip_tags($new->desc),0,148).'...':strip_tags($new->desc)}}</p>
                                    </div>
                                </div>
                                @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container -->
    </div>
    <!--Most recomended Courses Section four end -->


@endsection

@push('js')
    <script>
        $(function () {
            var menu = "{{$default[2]}}";
            var success = "{{(session('success') ? session('success') : '')}}";
            var warning = "{{(session('warning') ? session('warning') : '')}}";

            $(window).on("load", function () {
                if (warning) {
                    $('#login_button').click();
                    $('#login_one .help-block').text(warning);
                }
            });

        });
    </script>
@endpush

@push('style')
    <style>
        .ratakan-first-order {
            padding-bottom: 0px;
            margin-bottom: -22px;
        }
    </style>
    <style>
        .bootstrap-select .filter-option {
            top: 4px !important;
            font-size: 12px;
        }

        .bootstrap-select button {
            height: 3em !important;
            background: #3abac6 !important;
            border: 2.4px solid #fff !important;
            color: #fff !important;
        }

        .bootstrap-select {
            width: 100% !important;
        }

        .bootstrap-select.bs-container .dropdown-menu.inner li a {
            color: #fff;
            font-size: 12px;
        }

        .bootstrap-select.bs-container .dropdown-menu {
            background: #3abac6;
        }

        .bootstrap-select.bs-container {
            width: 220px !important;
        }

        .dropdown-menu > .active > a, .dropdown-menu > .active > a:focus, .dropdown-menu > .active > a:hover {
            background-color: #358eda !important;
        }

        .dropdown-menu > li > a:focus, .dropdown-menu > li > a:hover {
            background-color: #358eda !important;

        }

        .dropdown-menu > .disabled > a:hover, .dropdown-menu > .disabled > a:focus {
            background-color: #ced4da !important;
            color: #8a8d87 !important;
        }

        .dropdown-menu > .active.disabled > a, .dropdown-menu > .active.disabled > a:focus, .dropdown-menu > .active > a:hover {
            background-color: #ced4da !important;
            color: #8a8d87 !important;
        }
    </style>

@endpush