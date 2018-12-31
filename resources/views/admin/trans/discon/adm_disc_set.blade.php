@extends('layouts.other_side')
@section('content')
    <div id="trans-disc">
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
                <label for="category">Jenis Diskon:</label>
                <select name="category" id="category" class="form-control">
                    <option value="percent">Persen</option>
                    <option value="cash">Tunai</option>
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
                    <th>Kode Voucher</th>
                    <th>Nominal</th>
                    <th>Dibuat</th>
                    <th>Kadaluarsa</th>
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
                    </td>
                    <td><span class="label label-info" data-toggle="tooltip" data-placement="top"
                              title="Tooltip on right"> Anak</span></td>
                    <td>
                        <i class="fa fa-edit" data-toggle="tooltip" data-placement="top"
                           title="edit"></i>
                        <i class="fa fa-trash-o" data-toggle="tooltip" data-placement="top"
                           title="hapus" style="padding-left: 8px"></i>
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
@include('admin.trans.discon.modalRightDisc')
@push('js')
    <script src="https://cdn.jsdelivr.net/autonumeric/2.0.0/autoNumeric.min.js"></script>
@endpush