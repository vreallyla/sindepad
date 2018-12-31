@extends('layouts.other_side')
@section('content')
    <div id="setting-banks">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title-content add-margin-top
    add-margin-top-hp card-mod">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 card-img">
                <div class="parent-card" >
                    <div class="card-img-cover img-bank"><img src="http://localhost:8000/images/img_unvailable.png" alt=""></div>
                    <div class="exc-btn-list todo-bank">
                        <i class="fa fa-times-circle" style="left: 49%; display: block"></i>
                        <i class="fa fa-edit" style="left: 27%; display: block"></i>
                    </div>

                </div>
            </div>
        </div>

        @include('admin.general.notice')
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 trigger-right">
            <i class="fa fa-plus"></i>
        </div>
    </div>
@endsection
@include('admin.settings.bank_set.modalRightBankSet')
