@extends ('layouts/mst_user')
@section('desc',substr(strip_tags($dataN->data->desc),0,50))
@section('key','children needed, autis, disability, anak berkebutuhan khusus, abk, children needed articles, '.$dataN->data->name.', '.env('APP_NAME'))
@section('content')

    <div class="ed_pagetitle" data-stellar-background-ratio="0.5" data-stellar-vertical-offset="0"
         style="background-image: url({{$parralax}});">
        <div class="ed_img_overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-4 col-sm-6">
                    <div class="page_title">
                        <h2>Detail Artikel</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-8 col-sm-6">
                    <ul class="breadcrumb">
                        <li><a href="{{route('welcome')}}">Beranda</a></li>
                        <li><i class="fa fa-chevron-left"></i></li>
                        <li><a href="{{route('blog.all')}}">Artikel</a></li>
                        <li><i class="fa fa-chevron-left"></i></li>
                        <li><a href="#">Detail</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="ed_transprentbg ed_toppadder80 ed_bottompadder80">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="ed_blog_all_item">
                        <div class="ed_blog_item ed_bottompadder50">
                            <div class="ed_blog_image" style="height: 19em;">
                                <img src="{{\Illuminate\Support\Facades\File::exists($dataN->data->img) ? asset($dataN->data->img) : asset('images/img_unvailable.png')}}"
                                     alt="blog image"/>
                            </div>
                            <div class="ed_blog_info">
                                <h2>{{$dataN->data->name}}</h2>
                                <ul>
                                    <li><a href="#"><i class="fa fa-user"></i>{{env('APP_NAME')}}</a></li>
                                    <li><a href="#"><i class="fa fa-clock-o"></i> {{\Carbon\Carbon::parse($dataN->data->created_at)->formatLocalized('%A, %d %B %Y')}}</a></li>
                                </ul>
                                {!! $dataN->data->desc !!}
                            </div>
                            <div class="ed_blog_tags">
                                <ul>
                                    <li><i class="fa fa-tags"></i> <a href="{{route('blog.all')}}">tags: </a></li>
                                    @foreach($dataN->data->getRel as $i=>$row)
                                        <li><a href="{{route('blog.all').'?cat='.$row->category_id}}">{{$row->getSide->name}}
                                                {{count($dataN->data->getRel)===($i+1)?'':','}}</a></li>
                                    @endforeach

                                </ul>
                                <div><a href="javascript:;" id="ed_share_wrapper">Bagikan laman ini</a>
                                    <ul id="ed_social_share">
                                        <li><a target="_blank" href="https://twitter.com/intent/tweet?text=Sekarang%20saya%20mengunjungi%20{{route('course.opsi',$dataN->data->id)}}" data-toggle="tooltip" data-placement="bottom" title="twitter"><i
                                                        class="fa fa-twitter"></i></a></li>
                                        <li><a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url={{route('course.opsi',$dataN->data->id)}}
                                                    &title={{'artikel '.$dataN->data->name.' di '.env('APP_NAME')}}&source={{route('course.opsi',$dataN->data->id)}}" data-toggle="tooltip" data-placement="bottom"
                                               title="linkedin"><i class="fa fa-linkedin"></i></a></li>
                                        <li><a target="_blank" href="https://plus.google.com/share?url={{route('course.opsi',$dataN->data->id)}}" data-toggle="tooltip" data-placement="bottom"
                                               title="google-plus"><i class="fa fa-google-plus"></i></a></li>
                                        <li><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{route('course.opsi',$dataN->data->id)}}&amp;src=sdkpreparse" data-toggle="tooltip" data-placement="bottom"
                                               title="facebook"><i class="fa fa-facebook"></i></a></li>
                                    </ul>
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