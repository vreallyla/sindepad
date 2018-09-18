@extends ('layouts/mst_user')
@section('desc','rahasia')
@section('key','anu')
@section('content')
    <!--Breadcrumb start-->
    <div class="ed_pagetitle" data-stellar-background-ratio="0.5" data-stellar-vertical-offset="0" style="background-image: url({{asset('images/parallax/1.jpg')}});">
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
                        <li><a href="{{route('welcome')}}">Beranda</a></li>
                        <li><i class="fa fa-chevron-left"></i></li>
                        <li><a href="{{route('course')}}">{{$menu}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--Breadcrumb end-->
    <!-- Section eleven start -->
    <div class="ed_courses ed_toppadder80 ed_bottompadder80">
        <div class="container">
            <div class="row">
                @foreach($default[1] as $row)
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="ed_mostrecomeded_course">
                        <div class="ed_item_img">
                            <img src="http://placehold.it/360X227" alt="item1" class="img-responsive">
                        </div>
                        <div class="ed_item_description ed_most_recomended_data">
                            <h4><a href="{{route('course.opsi',['class'=>$row->id])}}">Kelas {{$row->name}} </a><span>£25</span></h4>
                            <div class="row">
                                <div class="ed_rating">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                <div class="ed_stardiv">
                                                    <div class="star-rating"><span style="width:80%;"></span></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                <div class="row">
                                                    <p>(5 review)</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="ed_views">
                                            <i class="fa fa-users"></i>
                                            <span>35 students</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="course_detail">
                                <div class="course_faculty">
                                    <img src="http://placehold.it/32X32" alt=""> <a href="instructor_dashboard.html">Joanna Simpson</a>
                                </div>
                            </div>
                            <p>{{substr($row->detail,0,130)}} ...</p>
                            <a href="course_single.html" class="ed_getinvolved">Selengkapnya <i class="fa fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
               @endforeach
                <div class="col-lg-12">
                    <div class="ed_blog_bottom_pagination">
                        <nav>
                            <ul class="pagination">
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li class="active"><a href="#">Next <span class="sr-only">(current)</span></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div><!-- /.container -->
    </div>
    <!-- Section eleven end -->
@endsection

@push('js')
    <script>
        $(function () {
            var menu= "{{$default[2]}}";
            // alert(menu);
        });

    </script>
@endpush