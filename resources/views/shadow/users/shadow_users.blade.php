@extends('layouts.shadow_side')
@section('content')
    <div id="mst-users">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title-content opsi-list away-luss">
            <div class="opsi-detail-right col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <label for="entity">Jumlah Baris:</label>
                <select name="entity" id="entity" class="form-control">
                    <option value="9">9 Baris</option>
                    <option value="27">27 Baris</option>
                    <option value="45">45 Baris</option>
                </select>
            </div>
            <div class="opsi-detail-right col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <label for="category">Kategori:</label>
                <select name="category" id="category" class="form-control">
                    @foreach($roleUser as $row)
                        <option value="{{$row}}">{{$row}}</option>
                    @endforeach
                    <option value="Peserta Didik">Peserta Didik</option>
                </select>
            </div>
            <div class="opsi-detail-right col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <label for="search">Cari:</label>
                <div class="input-group"><input class="form-control" name="search" id="search"
                                                placeholder="Cari disini..."> <span
                            class="input-group-btn"> <button class="btn btn-default btn-search" type="button"><i
                                    class="fa fa-search"></i></button> </span>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title-content add-margin-top add-margin-top-hp card-mod">
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 card-img">
                <div class="parent-card">
                    <div class="card-img-cover"><img src="https://media.timeout.com/images/101602611/image.jpg" alt="">
                    </div>
                    <div class="card-detail">
                        <h3 data-toggle="tooltip" data-placement="top"
                            title="Tooltip on right">name</h3>
                        <span>Admin</span>
                        <label>Selengkapnya</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paginated">
            <ul class="pagination pagination-responsive paginate fixed-right-page">
                <li><a href="javascript:void(0);">&laquo; <span class="hidden-sm hidden-md hidden-lg">Sebelumnya</span></a>
                </li>
                <li><a href="javascript:void(0);">
                        <span class="hidden-sm hidden-md hidden-lg">Halaman</span> 1</a></li>
                <li><a href="javascript:void(0);">
                        <span class="hidden-sm hidden-md hidden-lg">Halaman</span> 2</a></li>
                <li><a href="javascript:void(0);">
                        <span class="hidden-sm hidden-md hidden-lg">Halaman</span> 3</a></li>
                <li><a href="javascript:void(0);">
                        <span class="hidden-sm hidden-md hidden-lg">Halaman</span> 4</a></li>
                <li><a href="javascript:void(0);">
                        <span class="hidden-sm hidden-md hidden-lg">Halaman</span> 5</a></li>
                <li><a href="javascript:void(0);">
                        <span class="hidden-sm hidden-md hidden-lg">Halaman</span> 6</a></li>
                <li><a href="javascript:void(0);">
                        <span class="hidden-sm hidden-md hidden-lg">Selanjutnya</span> &raquo;</a>
                </li>
            </ul>
        </div>

        @include('admin.general.notice')
        @include('shadow.users.modalShadowUser')
    </div>
@endsection