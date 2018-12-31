@extends('layouts.shadow_side')
@section('content')
    <div id="sche-student">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title-content opsi-list away-luss">
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
                    <option value="Sudah Diatur">Sudah Diatur</option>
                    <option value="Belum Diatur">Belum Diatur</option>
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
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-register" style="display: block">
            <table class="table">
                <thead>
                <tr>
                    <th>No Induk</th>
                    <th>Nama</th>
                    <th>Kebutuhan</th>
                    <th>Jadwal</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody class="td-resize">
                <tr>
                    <th scope="row">lkf290837sj</th>
                    <td><span data-toggle="tooltip" data-placement="top"
                              title="Tooltip on right"> Anak</span></td>
                    <td style="width: 10em">{{number_format(2000000000,0,',','.')}}</td>
                    <td scope="row"
                        class="add"><span data-toggle="tooltip" data-placement="top" title="Tooltip on right"> Anak</span>
                        <select class="selectpicker anu" data-live-search="true" data-container="body">
                            <option data-tokens="" value="" selected disabled="true"></option>
                            @foreach($sche as $row)
                                <option data-tokens="{{$row->name}}" value="{{$row->id}}">{{$row->name}}</option>
                            @endforeach

                        </select>
                    </td>
                    <td><span class="label label-info" data-toggle="tooltip" data-placement="top"
                              title=""> Anak</span></td>
                    <td>
                        <button class="btn btn-info">Edit</button>
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
    </div>

@endsection