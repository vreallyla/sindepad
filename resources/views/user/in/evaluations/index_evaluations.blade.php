@extends('layouts.user_side')
@section('content')
    <div id="evaluations">
        <div class="col-lg-offset-1 col-lg-10 col-md-offset-1 col-md-10 col-sm-12 col-xs-12 title-content opsi-list">
            <div class="opsi-detail-right col-lg-offset-8 col-md-offset-8 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <label for="date">Tanggal:</label>
                <select name="date" id="date" class="form-control">
                </select>
            </div>
        </div>
        <article
                class="page-timeline col-lg-offset-1 col-lg-10 col-md-offset-1 col-md-10 col-sm-12 col-xs-12" style="margin-top: 12px;
    margin-top: 12px;
    background: #fff;
    padding: 20px 22px 32px 22px;
    border: 1px solid #eee;
    margin-bottom: 36px;">
            <h4>Evaluasi Darto Desember 2018</h4>
            <div class="content-eva">
                dasdkjasd
            </div>
        </article>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 trigger-right" style="z-index: 48">
            <i class="fa fa-list-ul"></i>
        </div>

        @include('admin.general.notice')
    </div>
@endsection

@include('user.in.home.modalRightUserHome')
