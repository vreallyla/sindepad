@extends('layouts.user_side')
@section('content')
    <div id="user-schedules">
        <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-bottom: 3em;">
            <div class="schedules- grid">
                <div class="grid-item grid-item-schedules schedule-list">
                    <div class="accord-con-tile">
                        <h3>Senin</h3>
                    </div>
                    <div class="accord-con-detail">
                        <div class="accord-con-fill">
                            <div class="accord-con-content">
                                <h4 data-toggle="tooltip" data-placement="top" title="Ihsan Adriansyah">Renang</h4>
                                <h5>Waktu: <span>09:30 - 11:00 WIB</span></h5>
                                <strong>123812837</strong>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="grid-item grid-item-schedules schedule-list">
                    <div class="accord-con-tile">
                        <h3>Selasa</h3>
                    </div>
                    <div class="accord-con-detail">
                        <div class="accord-con-fill">
                            <div class="accord-con-content">
                                <h4 data-toggle="tooltip" data-placement="top" title="Ihsan Adriansyah">Renang</h4>
                                <h5>Waktu: <span>09:30 - 11:00 WIB</span></h5>
                                <strong>123812837</strong>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="grid-item grid-item-schedules schedule-list">
                    <div class="accord-con-tile">
                        <h3>Rabu</h3>
                    </div>
                    <div class="accord-con-detail">
                        <div class="accord-con-fill">
                            <div class="accord-con-content">
                                <h4 data-toggle="tooltip" data-placement="top" title="Ihsan Adriansyah">Renang</h4>
                                <h5>Waktu: <span>09:30 - 11:00 WIB</span></h5>
                                <strong>123812837</strong>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="grid-item grid-item-schedules schedule-list">
                    <div class="accord-con-tile">
                        <h3>Kamis</h3>
                    </div>
                    <div class="accord-con-detail">
                        <div class="accord-con-fill">
                            <div class="accord-con-content">
                                <h4 data-toggle="tooltip" data-placement="top" title="Ihsan Adriansyah">Renang</h4>
                                <h5>Waktu: <span>09:30 - 11:00 WIB</span></h5>
                                <strong>123812837</strong>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="grid-item grid-item-schedules schedule-list">
                    <div class="accord-con-tile">
                        <h3>Jum'at</h3>
                    </div>
                    <div class="accord-con-detail">
                        <div class="accord-con-fill">
                            <div class="accord-con-content">
                                <h4 data-toggle="tooltip" data-placement="top" title="Ihsan Adriansyah">Renang</h4>
                                <h5>Waktu: <span>09:30 - 11:00 WIB</span></h5>
                                <strong>123812837</strong>
                            </div>
                        </div>

                    </div>
                </div>



            </div>
        </div>
        @include('admin.general.notice')
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 trigger-right">
            <i class="fa fa-list-ul"></i>
        </div>
    </div>
@endsection
@include('user.in.home.modalRightUserHome')
