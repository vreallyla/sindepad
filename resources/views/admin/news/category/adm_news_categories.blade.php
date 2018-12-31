@extends('layouts.other_side')
@section('content')
    <div id="news-categories">
        <div class="col-lg-10 col-lg-offset-1 col-md-12 col-sm-12 col-xs-12 title-content opsi-list">
            <div class="opsi-detail-right col-lg-offset-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <label for="entity">Jumlah Baris:</label>
                <select name="entity" id="entity" class="form-control">
                    <option value="10">10 Baris</option>
                    <option value="30">30 Baris</option>
                    <option value="50">50 Baris</option>
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

        <div class="col-lg-10 col-lg-offset-1 col-md-12 col-sm-12 col-xs-12 table-register" style="display: block">
            <table class="table">
                <thead>
                <tr>
                    <th>Nama</th>
                    <th>detail</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><span class="label label-info" data-toggle="tooltip" data-placement="right"
                              title="Tooltip on right"> Anak</span></td>
                    <td><span data-toggle="tooltip" data-placement="bottom"
                              title="Tooltip on right"> Anak</span></td>

                    <td>
                        <i class="fa fa-edit" data-toggle="tooltip" data-placement="top"
                              title="edit"></i>
                        <i class="fa fa-trash-o" data-toggle="tooltip" data-placement="top"
                              title="hapus"></i>
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
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 trigger-right">
            <i class="fa fa-plus"></i>
        </div>
    </div>
@endsection

@include('admin.news.category.modalRightNewsCategory')