@extends ('layouts/mst_user')
@section('key','anu, Sanggar ABK, Anak berkebutuhan Khusus, SLB, Sekolah Luar Biasa, Terapi anak, autis, '.env('APP_NAME'))
@section('title','Kegiatan '.$class->name.' di '.env('APP_NAME'))
@section('img',$class->url)
@section('desc',$class->summary)
@section('url',(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http").'://'. "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}" )
@section('content')
    <!--Breadcrumb start-->
    <div class="ed_pagetitle" data-stellar-background-ratio="0.5" data-stellar-vertical-offset="0"
         style="background-image: url({{$parralax}});">
        <div class="ed_img_overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-4 col-sm-6">
                    <div class="page_title">
                        <h2>{{$title}}</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-8 col-sm-6">
                    <ul class="breadcrumb">
                        <li><a href="{{'welcome'}}">Beranda</a></li>
                        <li><i class="fa fa-chevron-left"></i></li>
                        <li><a href="{{route('course')}}">{{$menu}}</a></li>
                        <li><i class="fa fa-chevron-left"></i></li>
                        <li><a href="{{route('course.opsi',['class'=>$class->id])}}">{{$title}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--Breadcrumb end-->
    <!--Single content start-->
    <div class="ed_graysection ed_course_single ed_toppadder80 ed_bottompadder80">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div class="ed_course_single_item">
                        <div class="ed_course_single_image">
                            <img src="{{\Illuminate\Support\Facades\File::exists($class->url) ? asset($class->url) : asset('images/img_unvailable.png')}}"
                                 alt="event image"/>
                        </div>
                        <div class="ed_course_single_info">
                            <h2>Kegiatan {{$class->name}}</h2>

                                <i class="fa fa-clock-o" style="color: #3ABAC6"></i>
                                <span>Waktu : {{$class->time}} Menit / Pertemuan</span>

                        </div>
                        <div class="ed_course_single_tab">
                            <div role="tabpanel">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#description"
                                                                              aria-controls="description" role="tab"
                                                                              data-toggle="tab">Target</a></li>
                                    <li role="presentation"><a href="#news" aria-controls="news" role="tab"
                                                               data-toggle="tab">Ringkasan</a></li>

                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="description">
                                        <div class="ed_course_tabconetent">
                                            <h2>Target Kegiatan</h2>
                                            {!! $class->purpose !!}
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="news">
                                        <div class="ed_course_tabconetent">
                                            <h2>Ringkasan Kegiatan</h2>
                                            {!! $class->summary !!}

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--tab End-->
                    </div>
                </div>
                <!--Sidebar Start-->
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="sidebar_wrapper_upper">
                        <div class="sidebar_wrapper">
                            <aside class="widget widget_button">
                                <a href="{{route('order.step')}}" class="ed_btn ed_green">Daftar Sekarang</a>
                            </aside>
                            <aside class="widget widget_categories">
                                <h4 class="widget-title">Program Lain</h4>
                                <ul>
                                    @foreach($other as $row)
                                        <li><a href="{{route('course.opsi',['class'=>$row->id])}}"><i
                                                        class="fa fa-chevron-right"></i>{{$row->name}}</a></li>
                                    @endforeach
                                </ul>
                            </aside>
                            <aside class="widget widget_sharing">
                                <h4 class="widget-title">Bagikan program ini</h4>
                                <ul>
                                    <li>
                                        <a target="_blank"
                                           href="https://www.facebook.com/sharer/sharer.php?u={{route('course.opsi',$class->id)}}&amp;src=sdkpreparse"
                                           class="fb-xfbml-parse-ignore"><i class="fa fa-facebook"></i> facebook</a>
                                    </li>
                                    <li><a target="_blank"
                                           href="http://www.linkedin.com/shareArticle?mini=true&url={{route('course.opsi',$class->id)}}
                                                   &title={{'Kegiatan '.$class->name.' di '.env('APP_NAME')}}&source={{route('course.opsi',$class->id)}}"><i
                                                    class="fa fa-linkedin"></i> linkedin</a></li>
                                    <li><a target="_blank"
                                           href="https://twitter.com/intent/tweet?text=Sekarang%20saya%20mengunjungi%20{{route('course.opsi',$class->id)}}"><i
                                                    class="fa fa-twitter"></i> twitter</a></li>
                                    <li><a target="_blank"
                                           href="https://plus.google.com/share?url={{route('course.opsi',$class->id)}}"><i
                                                    class="fa fa-google-plus"></i> google+</a></li>
                                </ul>
                            </aside>
                        </div>
                    </div>
                </div>
                <!--Sidebar End-->
            </div>
        </div>
    </div>
    <!--Single content end-->
@endsection

@push('js')
    <script>
        $(function () {
            var menu = "{{$default[2]}}";
            // alert(menu);
        });
        $('.ed_parallax_section').css('background-image','url({{$parralax}}) !important');
    </script>
@endpush