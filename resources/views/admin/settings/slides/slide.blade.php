@extends('layouts.other_side')
@section('content')
    <div id="setting-slides">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 content-slides">
            <div class="detail-slides">
                <div class="col-lg-offset-1 col-lg-10 col-md-12 col-sm-12 col-xs-12 fill-slides">
                    <div class="pg-img-slide">
                        <img src="https://cdn.mos.cms.futurecdn.net/FUE7XiFApEqWZQ85wYcAfM.jpg" alt="">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        <span class="ex-btn">Selengkapnya</span>
                    </div>
                    <div class="hover-slide">
                        <i class="fa fa-edit"></i>
                        <i class="fa fa-trash-o"></i>
                    </div>
                </div>
                <div class="col-lg-offset-1 col-lg-10 col-md-12 col-sm-12 col-xs-12 fill-slides">
                    <div class="pg-img-slide">
                        <img src="https://cdn.mos.cms.futurecdn.net/FUE7XiFApEqWZQ85wYcAfM.jpg" alt="">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        <span class="ex-btn">Selengkapnya</span>
                    </div>
                    <div class="hover-slide">
                        <i class="fa fa-edit"></i>
                        <i class="fa fa-trash-o"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.general.notice')
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 trigger-right">
        <i class="fa fa-plus"></i>
    </div>
@endsection

@include('admin.settings.slides.modalRightSlides')