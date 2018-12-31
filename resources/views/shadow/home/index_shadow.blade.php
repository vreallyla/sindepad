@extends('layouts.shadow_side')
@section('content')
    <div id="shadow-home">
        <div class="col-lg-offset-1 col-md-offset-1 col-lg-10 col-md-10 col-sm-12 col-xs-12">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 header-card-dash">
                <h5>Trafik Perkembangan</h5>
                <span>Samsul</span>
                <i class="fa fa-times"></i>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 content-card-dash">
                <canvas id="graph" width="100%"></canvas>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 header-card-dash" style="margin-top: 1em;">
                <h5>Perbandingan Nilai</h5>
                <span>Samsul</span>
                <i class="fa fa-times"></i>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 content-card-dash">
                <canvas id="canvas" width="100%" height="60"></canvas>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 trigger-right">
            <i class="fa fa-list-ul"></i>
        </div>
        @include('admin.general.notice')
    </div>
@endsection

@include('shadow.home.modalRightIndexShadow')

@push('js')
    @endpush
