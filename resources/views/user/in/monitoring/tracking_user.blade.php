@extends('layouts.user_side')
@section('content')
    <div id="user-monitoring">
        <div class="col-lg-offset-1 col-lg-10 col-md-offset-1 col-md-10 col-sm-12 col-xs-12 title-content opsi-list">

            <div class="opsi-detail-right col-lg-offset-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <label for="category">Peserta didik:</label>
                <select name="category" id="category" class="form-control">
                    @foreach($child as $row)
                        <option value="{{$row->key}}">{{$row->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="opsi-detail-right col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <label for="search">Tanggal:</label>
                <div class="input-group"><input class="form-control datepicker" name="search" id="search"
                                                placeholder="Cari disini..." value="{{now()->format('d/m/Y')}}"> <span
                            class="input-group-btn"> <button class="btn btn-default btn-search" type="button"><i
                                    class="fa fa-search"></i></button> </span>
                </div>
            </div>

        </div>

        <article
                class="page-timeline col-lg-offset-1 col-lg-10 col-md-offset-1 col-md-10 col-sm-12 col-xs-12 ">
            <ul class="timeline">

                <li class="timeline-milestone  is-completed ">
                    <div class="timeline-action is-expandable expanded">
                        <h2 class="title">Initial planning</h2>
                        <span class="date">Second quarter 2013</span>
                        <div class="content">

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0">
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label class="control-label">Sub Kegiatan :</label>
                                        <input type="text" class="form-control selectN" name="sub" id="sub" readonly style="
background: #fff">
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label class="control-label">Nilai :</label>
                                        <input type="number" class="form-control" name="score" id="score" step=0.1 min="0.1" max="4" readonly style="
background: #fff">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group" style="padding: 0 15px">
                                    <label class="control-label">Kemajuan :</label>
                                    <textarea name="achievement" id="" cols="10" rows="3" class="form-control" readonly style="
background: #fff"></textarea>
                                    <span class="help-block"></span>
                                </div>
                                <div class="form-group" style="padding: 0 15px">
                                    <label class="control-label">Catatan :</label>
                                    <textarea name="note" id="" cols="10" rows="3" class="form-control" readonly style="
background: #fff"></textarea>
                                    <span class="help-block"></span>
                                </div>
                        </div>
                    </div>
                </li>
                <li class="timeline-milestone is-future">
                    <div class="timeline-action is-expandable">
                        <h2 class="title">Start construction</h2>
                        <span class="date">Fourth quarter 2013</span>
                        <div class="content">

                        </div>
                    </div>
                </li>
                <li class="timeline-milestone is-future timeline-end">
                    <div class="timeline-action">
                        <h2 class="title">Test and verify</h2>
                        <span class="date">Second quarter 2014</span>
                        <div class="content">

                        </div>
                    </div>
                </li>
            </ul>
        </article>
        @include('admin.general.notice')
    </div>
@endsection