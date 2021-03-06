@extends('layouts.other_side')
@section('content')
    <div id="news-list">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title-content opsi-list">
            <div class="opsi-detail-right col-lg-3 col-md-3 col-sm-12 col-xs-12">
              <button class="btn btn-default btn-li"><i class="fa fa-plus"></i> Tambah</button>
            </div>
            <div class="opsi-detail-right col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <label for="entity">Jumlah Baris:</label>
                <select name="entity" id="entity" class="form-control">
                    <option value="9">9 Baris</option>
                    <option value="27">27 Baris</option>
                    <option value="45">45 Baris</option>
                </select>
            </div>
            <div class="opsi-detail-right col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <label for="category">Kategori:</label>
                <select name="category" id="category" class="form-control">
                    @if(!$category->isEmpty())
                        @foreach($category as $row)
                            <option value="{{$row->id}}">{{$row->name}}</option>
                        @endforeach
                    @else
                        <option value="" disabled="disabled" selected>Data belum diisi</option>
                    @endif
                </select>
            </div>
            <div class="opsi-detail-right col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <label for="search">Cari:</label>
                <div class="input-group"><input class="form-control" name="search" id="search"
                                                placeholder="Cari disini..."> <span
                            class="input-group-btn"> <button class="btn btn-default btn-search" type="button"><i
                                    class="fa fa-search"></i></button> </span>
                </div>
            </div>

        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title-content add-margin-top
    add-margin-top-hp card-mod" style="display: block">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 card-img">
                <div class="parent-card">
                    <div class="card-img-cover"><img src="http://localhost:8000/images/img_unvailable.png" alt=""></div>
                    <div class="exc-btn-sud">
                        <i class="fa fa-times-rectangle"></i>
                    </div>
                    <div class="card-detail"><h3 data-toggle="tooltip" data-placement="top" title="Ihsan Adriansyah">
                            Ihsan
                            Adrian..</h3> <span>MT9823fd</span> <label>Selengkapnya</label></div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paginated" style="">
            <ul class="pagination pagination-responsive paginate fixed-right-page even">
                <li><a href="javascript:void(0);">« <span class="hidden-sm hidden-md hidden-lg">Sebelumnya</span></a>
                </li>
                <li><a href="javascript:void(0);"><span class="hidden-sm hidden-md hidden-lg">Halaman</span> 1</a></li>
                <li><a href="javascript:void(0);"><span class="hidden-sm hidden-md hidden-lg">Halaman</span> 2</a></li>
                <li><a href="javascript:void(0);"><span class="hidden-sm hidden-md hidden-lg">Halaman</span> 3</a></li>
                <li><a href="javascript:void(0);"><span class="hidden-sm hidden-md hidden-lg">Halaman</span> 4</a></li>
                <li><a href="javascript:void(0);"><span class="hidden-sm hidden-md hidden-lg">Halaman</span> 5</a></li>
                <li><a href="javascript:void(0);"><span class="hidden-sm hidden-md hidden-lg">Halaman</span> 6</a></li>
                <li><a href="javascript:void(0);"><span class="hidden-sm hidden-md hidden-lg">Selanjutnya</span> »</a>
                </li>
            </ul>
        </div>
        @include('admin.general.notice')
        @include('admin.news.list.modalFullNewsList')
    </div>

@endsection