@extends('layouts.other_side')
@section('content')
    <div id="register-list">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title-content opsi-list">
            <div class="opsi-detail-right col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <label for="entity">Jumlah Baris:</label>
                <select name="entity" id="entity" class="form-control">
                    <option value="10">10 Baris</option>
                    <option value="30">30 Baris</option>
                    <option value="50">50 Baris</option>
                </select>
            </div>
            <div class="opsi-detail-right col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <label for="category">Kategori:</label>
                <select name="category" id="category" class="form-control">
                    <option value="tf">Transfer</option>
                    <option value="cop">Bayar Ditempat</option>
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

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-register">
            <table class="table">
                <thead>
                <tr>
                    <th>Kode</th>
                    <th>Pendaftar</th>
                    <th>Total Akhir</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">lkf290837sj</th>
                    <td><span class="label label-info" data-toggle="tooltip" data-placement="right"
                              title="Tooltip on right"> Anak</span></td>
                    <td class="add-rp">{{number_format(2000000000,0,',','.')}}</td>
                    <td scope="row">Bayar ditempat</td>
                    <td><span data-toggle="tooltip" data-placement="left" title="Tooltip on right"> Anak</span></td>
                    <td scope="row">{{now()->toDateString()}}</td>
                    <td>
                        <button class="btn btn-info">Detail</button>
                    </td>
                </tr>
                </tbody>
            </table>

            <ul class="pagination pagination-responsive paginate">
                <li><a href="javascript:void(0);">&laquo; <span class="hidden-sm hidden-md hidden-lg">Sebelumnya</span></a>
                </li>
                <li><a href="javascript:void(0);"><span class="hidden-sm hidden-md hidden-lg">Halaman</span> 1</a></li>
                <li><a href="javascript:void(0);"><span class="hidden-sm hidden-md hidden-lg">Halaman</span> 2</a></li>
                <li><a href="javascript:void(0);"><span class="hidden-sm hidden-md hidden-lg">Halaman</span> 3</a></li>
                <li><a href="javascript:void(0);"><span class="hidden-sm hidden-md hidden-lg">Halaman</span> 4</a></li>
                <li><a href="javascript:void(0);"><span class="hidden-sm hidden-md hidden-lg">Halaman</span> 5</a></li>
                <li><a href="javascript:void(0);"><span class="hidden-sm hidden-md hidden-lg">Halaman</span> 6</a></li>
                <li><a href="javascript:void(0);"><span class="hidden-sm hidden-md hidden-lg">Selanjutnya</span> &raquo;</a>
                </li>
            </ul>
        </div>
        @include('admin.general.notice')
        @include('admin.registerList.modal')
        @include('admin.registerList.modalPhoto')
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 trigger-right">
            <i class="fa fa-plus"></i>
        </div>
    </div>
@endsection
{{--@section('title-right','Form Pendaftaran')--}}
{{--@section('content-right')--}}
@include('admin.registerList.modalRight')
{{--@endsection--}}

