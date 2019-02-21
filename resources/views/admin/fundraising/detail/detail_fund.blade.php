@extends('layouts.other_side')
@section('content')
    <div id="detail-fundraising">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title-content opsi-list away-luss">
            <div class="opsi-detail-right col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <button class="btn btn-default btn-li"><i class="fa fa-plus"></i> Tambah</button>
            </div>
            <div class="opsi-detail-right col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <label for="entity">Jumlah Baris:</label>
                <select name="entity" id="entity" class="form-control">
                    <option value="10">10 Baris</option>
                    <option value="30">30 Baris</option>
                    <option value="50">50 Baris</option>
                </select>
            </div>
            <div class="opsi-detail-right col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <label for="category">Kategori:</label>
                <select name="category" id="category" class="form-control">
                    @if(!empty($statuss))
                        @foreach($statuss as $row)
                            <option value="{{$checkStatus[$row]}}">{{$row}}</option>
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
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-register" style="display: block">
            <table class="table">
                <thead>
                <tr>
                    <th>Atas Nama</th>
                    <th>Obyek</th>
                    <th>Nominal</th>
                    <th>Email</th>
                    <th>Tanggal</th>
                    <th>status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody class="td-resize">
                <tr>
                    <th scope="row">lkf290837sj</th>
                    <td><span data-toggle="tooltip" data-placement="top"
                              title="Tooltip on right"> Anak</span></td>
                    <td style="width: 10em">{{number_format(2000000000,0,',','.')}}</td>
                    <td style="width: 10em">{{number_format(2000000000,0,',','.')}}</td>
                    <td>{{now()->toDateString()}}</td>
                    <td scope="row"
                        class="add"><span class="label label-info" data-toggle="tooltip" data-placement="top"
                                          title="Tooltip on right"> Belum</span>
                        <select class="selectpicker anu" data-container="body" name="stat">
                            <option data-tokens="" value="" selected disabled="true">Pilih Status</option>
                            @foreach($statuss as $row)
                                <option value="{{$checkStatus[$row]}}">{{$row}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-info">Edit</button>
                        <button class="btn btn-dark">Bukti</button>
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
        @include('admin.registerList.modalPhoto')
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 trigger-right">
            <i class="fa fa-plus"></i>
        </div>
    </div>
@endsection

@include('admin.fundraising.detail.modalRightCont')

@push('js')
    <script src="https://cdn.jsdelivr.net/autonumeric/2.0.0/autoNumeric.min.js"></script>
@endpush