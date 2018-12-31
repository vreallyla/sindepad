@extends ('layouts/mst_user')
@section('desc','rahasia')
@section('key','anu')
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
                @foreach($dataN as $row)
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="ed_mostrecomeded_course">
                            <div class="ed_item_img">
                                <img src="{{\Illuminate\Support\Facades\File::exists($row->url) ? asset($row->url) : asset('images/img_unvailable.png')}}" alt="item1" class="img-responsive">
                            </div>
                            <div class="ed_item_description ed_most_recomended_data">
                                <h4 data-toggle="tooltip" data-placement="top"
                                    title="{{strlen('Kegiatan '.$row->name)>22?'Kegiatan '.$row->name:''}}">
                                    <a href="{{route('course.opsi',['class'=>$row->id])}}">{{strlen('Kegiatan '.$row->name)>22?substr('Kegiatan '.$row->name,0,22):'Kegiatan '.$row->name}} </a><span
                                            style="font-size: 12px;"><i class="fa fa-clock-o"> {{$row->time}} menit</i></span>
                                </h4>
                                <p>{{strlen(strip_tags($row->summary))>35?substr(strip_tags($row->summary),0,130).'...':strip_tags($row->summary)}} </p>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-lg-12">
                    <div class="ed_blog_bottom_pagination">
                        <nav>
                            {{$dataN->links()}}
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
            var menu = "{{$default[2]}}";
            // alert(menu);
        });

    </script>
@endpush