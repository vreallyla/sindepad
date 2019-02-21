@extends('layouts.shadow_side')
@section('content')
    <div id="evaluations">
        <div class="col-lg-offset-1 col-lg-10 col-md-offset-1 col-md-10 col-sm-12 col-xs-12 title-content opsi-list">
            <div class="opsi-detail-right col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <button class="btn btn-default btn-li"><i class="fa fa-paper-plane-o"></i> Simpan</button>
            </div>
            <div class="opsi-detail-right col-lg-offset-5 col-md-offset-5 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <label for="date">Tanggal:</label>
                <select name="date" id="date" class="form-control">
                </select>
            </div>
        </div>
        <article
                class="page-timeline col-lg-offset-1 col-lg-10 col-md-offset-1 col-md-10 col-sm-12 col-xs-12"  style="margin-top: 12px">
            <textarea id="description" name="desc"></textarea>
<span class="help-block"></span>
        </article>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 trigger-right" style="z-index: 48">
            <i class="fa fa-list-ul"></i>
        </div>

        @include('admin.general.notice')
    </div>
@endsection

@include('shadow.home.modalRightIndexShadow')
