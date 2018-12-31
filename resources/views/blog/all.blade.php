@extends ('layouts/mst_user')
@section('desc','')
@section('key','children needed, autis, disability, anak berkebutuhan khusus, abk, children needed articles, '.env('APP_NAME'))
@section('content')
    <div class="ed_pagetitle" data-stellar-background-ratio="0.5" data-stellar-vertical-offset="0"
         style="background-image: url({{$parralax}});">
        <div class="ed_img_overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-4 col-sm-6">
                    <div class="page_title">
                        <h2>Daftar Artikel</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-8 col-sm-6">
                    <ul class="breadcrumb">
                        <li><a href="{{route('welcome')}}">Beranda</a></li>
                        <li><i class="fa fa-chevron-left"></i></li>
                        <li><a href="#">Artikel</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="ed_transprentbg ed_toppadder80 ed_bottompadder80">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="row">
                        <div class="ed_blog_all_item ed_blog_all_item_second">
                            @if(isset($dataN)?!$dataN->data->isEmpty():false)
                                @foreach($dataN->data as $row)
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="ed_blog_item ed_bottompadder50">
                                            <div class="ed_blog_image">
                                                <a href="{{route('blog.single',$row->id)}}"><img
                                                            src="{{\Illuminate\Support\Facades\File::exists($row->img) ? asset($row->img) : asset('images/img_unvailable.png')}}"
                                                            alt="blog image"/></a>
                                            </div>
                                            <div class="ed_blog_info">
                                                <h2><a href="{{route('blog.single',$row->id)}}">{{$row->name}}</a></h2>
                                                <ul>
                                                    <li><a href="{{route('blog.single',$row->id)}}"><i
                                                                    class="fa fa-user"></i>{{env('APP_NAME')}}</a></li>
                                                    <li><a href="{{route('blog.single',$row->id)}}"><i
                                                                    class="fa fa-clock-o"></i>{{\Carbon\Carbon::parse($row->created_at)->formatLocalized('%a,%d %b %y')}}
                                                        </a></li>
                                                </ul>
                                                <p class="ed_bottompadder10">{{strlen(strip_tags($row->desc))>150?substr(strip_tags($row->desc),0,148).'...':strip_tags($row->desc)}}</p>
                                                <a href="{{route('blog.single',$row->id)}}"
                                                   class="btn ed_btn ed_orange">Selengkapnya</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 not-found-notice">
                                    <img src="{{asset('images/icons/notfound.svg')}}" alt="">
                                    <h3>Data Tidak Ditemukan. Coba gunakan
                                        kunci lain</h3>
                                </div>
                            @endif
                            <div class="col-lg-12">
                                <div class="ed_blog_bottom_pagination">
                                    <nav>
                                        {{$dataN->data->links()}}
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('blog.sideRight')
            </div>
        </div>
    </div>
@endsection

@push('js')
    @include('blog.part_search')
@endpush