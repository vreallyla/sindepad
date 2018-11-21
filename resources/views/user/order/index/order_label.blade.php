@extends ('layouts.mst_user')
@section('desc','rahasia')
@section('key','anu')
@section('content')
    <!--Breadcrumb start-->
    <div class="ed_pagetitle" data-stellar-background-ratio="0.5" data-stellar-vertical-offset="0"
         style="background-image: url(http://placehold.it/921X533);">
        <div class="ed_img_overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-4 col-sm-6">
                    <div class="page_title">
                        <h2>Halaman Pendaftaran Siswa Baru</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-8 col-sm-6">
                    <ul class="breadcrumb">
                        <li><a href="index.html">home</a></li>
                        <li><i class="fa fa-chevron-left"></i></li>
                        <li><a href="course.html">Educo Courses</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--Breadcrumb end-->
    <!-- Section eleven start -->
    <div class="ed_courses ed_toppadder80 ed_bottompadder80">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <form id="signup" action="somewhere" method="POST">
                        <ul id="section-tabs">
                            <li class="active"><i class="fa fa-user-plus"></i>
                                <div class="content-step">Data Pendaftar</div>
                            </li>
                            <li><i class="fa fa-tasks"></i>
                                <div class="content-step">Opsional</div>
                            </li>
                            <li><i class="fa fa-credit-card"></i>
                                <div class="content-step">Pembayaran</div>
                            </li>
                            <li><i class="fa fa-clock-o"></i>
                                <div class="content-step">Proses</div>
                            </li>
                        </ul>
                        <div id="fieldsets">
                            <fieldset class="animated">
                                <div class="row">
                                    <div class="col-lg-12 order-adding">
                                        <div class="row">
                                            <h4>formulir pendaftaran</h4>
                                            <div class="pull-right">
                                                <div class="col-lg-12 add-min"><label
                                                            style="font-size: 17px;color: #7f7f7f;font-weight: normal">
                                                        Pendaftar(<span class="entity-order">{{$entity}}</span>)
                                                        :</label>
                                                    <button type="button" class="btn min-order"
                                                            style="height:34px; background: #dddddd;color: #535353"><i
                                                                class="fa fa-minus"></i></button>
                                                    <button type="button" class="btn add-order" style="height:34px;">
                                                        <i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="accordion" id="step1">
                                            <dl>
                                                @for($i=0;$i<$entity;$i++)
                                                    <dt>
                                                        <a href="#accordion{{$i+1}}" aria-expanded="false"
                                                           aria-controls="accordion{{$i+1}}"
                                                           class="accordion-title accordionTitle js-accordionTrigger">
                                                            <span class="content-accord">Pendaftar #{{$i+1}}{{session('order')&&array_key_exists('name',session('order')['data'][$i]) ? ' : '.session('order')['data'][$i]['name']:''}}</span>
                                                            <span class="pull-right remove-accordion"
                                                                  data-toggle="tooltip"
                                                                  data-placement="right" title="Tutup"
                                                                  style="display: none">
                                                        <i class="fa fa-times"></i>
                                                    </span>
                                                        </a>
                                                    </dt>
                                                    <dd class="accordion-content accordionItem is-collapsed"
                                                        id="accordion{{$i+1}}"
                                                        aria-hidden="true">
                                                        <div class="row">
                                                            <div class="col-lg-6 add-margin-bottom-sm">
                                                                <label for="name">Nama :</label>
                                                                <input type="text" name="name[]"
                                                                       placeholder="Nama siswa yang mendaftar"
                                                                       class="form-control modify-input change-tittle name"
                                                                       @if(session('order')&&array_key_exists('name',session('order')['data'][$i]))value="{{session('order')['data'][$i]['name']}}"
                                                                       @endif
                                                                       data-index="0">
                                                                <span class="help-block"
                                                                      style="display: none">
                                                                <strong></strong>
                                                            </span>
                                                            </div>
                                                            <div class="col-lg-6 add-margin-bottom-sm">
                                                                <label for="sex">Jenis Kelamin :</label>
                                                                <select name="sex[]" id="sex"
                                                                        class="form-control modify-input sex">
                                                                    <option value="" selected disabled>------ pilih
                                                                        jenis
                                                                        kelamin ------
                                                                    </option>
                                                                    @foreach($gender as $row)
                                                                        <option value="{{$row->id}}"
                                                                                @if(session('order')&&array_key_exists('sex',session('order')['data'][$i])&&session('order')['data'][$i]['sex']==$row->id)selected @endif>{{$row->ind}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="help-block"
                                                                      style="display: none">
                                                                <strong></strong>
                                                            </span>
                                                            </div>
                                                            <div class="col-lg-6 add-margin-bottom-sm">
                                                                <label for="packet">Paket :</label>
                                                                <select name="packet[]" id=""
                                                                        class="form-control packet">
                                                                    <option value="" disabled selected>-------- pilih
                                                                        Paket
                                                                        --------
                                                                    </option>
                                                                    @foreach($packet as $row)
                                                                        <option value="{{$row->id}}"
                                                                                @if(session('order')&&array_key_exists('packet',session('order')['data'][$i])&&session('order')['data'][$i]['packet']==$row->id)selected @endif>
                                                                            {{$row->name.' - Rp '.$row->regist.'+'.$row->amount.' Rb'}}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="help-block"
                                                                      style="display: none">
                                                                <strong></strong>
                                                            </span>
                                                            </div>
                                                            <div class="col-lg-6 add-margin-bottom-sm">
                                                                <label for="course">Program :</label>
                                                                <select name="course[]" id=""
                                                                        class="form-control course">
                                                                    <option value="" disabled>--- pilih ---</option>
                                                                    @foreach($default[1] as $row)
                                                                        <option value="{{$row->id}}"
                                                                                @if(session('order')&&array_key_exists('course',session('order')['data'][$i])&&session('order')['data'][$i]['course']==$row->id)selected @endif>{{$row->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="help-block"
                                                                      style="display: none">
                                                                <strong></strong>
                                                            </span>
                                                            </div>
                                                            <div class="col-lg-6 add-margin-bottom-sm">
                                                                <label for="rs">Hubungan dengan Anak :</label>
                                                                <select name="rs[]" id="" class="form-control rs">
                                                                    <option value="" disabled selected>------ pilih
                                                                        hubungan
                                                                        ------
                                                                    </option>
                                                                    @foreach($rs as $row)
                                                                        <option value="{{$row->id}}"
                                                                                @if(session('order')&&array_key_exists('rs',session('order')['data'][$i])&&session('order')['data'][$i]['rs']==$row->id)selected @endif>{{$row->ind}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="help-block"
                                                                      style="display: none">
                                                                <strong></strong>
                                                            </span>
                                                            </div>
                                                            <div class="col-lg-6 add-margin-bottom-sm">
                                                                <label for="needed">Kebutuhan :</label>
                                                                <select name="needed[{{$i}}][]" id=""
                                                                        class="form-control selectpicker needed"
                                                                        data-container="body" multiple>
                                                                    @foreach($dis as $row)
                                                                        <option value="{{$row->id}}"
                                                                        @if(session('order')&&array_key_exists('needed',session('order')['data'][$i]))
                                                                            @foreach (session('order')['data'][$i]['needed'] as $ra)
                                                                                {{$row->id==$ra? 'selected':''}}
                                                                                    @endforeach
                                                                                @endif
                                                                        >{{$row->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="help-block"
                                                                      style="display: none">
                                                                <strong></strong>
                                                            </span>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <label for="desc">Catatan :</label>
                                                                <textarea name="desc[]"
                                                                          placeholder="Jika ada tambahan tulis disini."
                                                                          class="form-control modify-input desc">{{session('order')&&array_key_exists('desc',session('order')['data'][$i])?session('order')['data'][$i]['desc']:''}}</textarea>
                                                                <span class="help-block"
                                                                      style="display: none">
                                                                <strong></strong>
                                                            </span>
                                                            </div>
                                                        </div>
                                                    </dd>
                                                @endfor
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="next animated">
                                <div class="row">
                                    <div class="col-lg-12" style="bottom: 24px">
                                        <h4>Pilih waktu pembelajaran</h4>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="accordion" id="step2">
                                            <dl>
                                                @for($i=0;$i<$entity;$i++)
                                                    <dt>
                                                        <a href="#accordion{{$i+1}}" aria-expanded="true"
                                                           aria-controls="accordion{{$i+1}}"
                                                           class="accordion-title accordionTitle js-accordionTrigger is-collapsed is-expanded">
                                                            <span class="content-accord">Pendaftar #{{$i+1}}{{session('order')&&array_key_exists('name',session('order')['data'][$i]) ? ' : '.session('order')['data'][$i]['name']:''}}</span>
                                                            {{--<span class="pull-right remove-accordion"
                                                                  data-toggle="tooltip"
                                                                  data-placement="right" title="" style="display: none"
                                                                  data-original-title="Tutup">
                                                        <i class="fa fa-times">--}}</i>
                                                            </span>
                                                        </a>
                                                    </dt>
                                                    <dd class="accordion-content accordionItem is-expanded animateIn"
                                                        id="accordion{{$i+1}}" aria-hidden="false">
                                                        <div class="row select-radio">
                                                            <div class="col-lg-12 center">
                                                                <label for="" day>Pilih Hari :</label>
                                                            </div>
                                                            <div class="col-lg-12 center radio-multiple"
                                                                 style="padding: 0px">
                                                                @foreach($day as $r)
                                                                    <label>
                                                                        <input type="checkbox" class="choose_days"
                                                                               name="day[]" value="{{$r->id}}"
                                                                                {{session('order')&&array_key_exists('day',session('order')['data'][$i])&&session('order')['data'][$i]['day']==$r->id?$daying[$i]='checked':''}}
                                                                        />
                                                                        <div class="back-end box zoom">
                                                                            <span>{{$r->ind}}</span>
                                                                        </div>
                                                                    </label>
                                                                @endforeach
                                                                <span class="help-block"
                                                                      style="padding-left: 9px;display: none">
                                                                <strong></strong>
                                                            </span>
                                                            </div>
                                                        </div>
                                                        <div class="row select-radio"
                                                             style="padding-top: 0px;@if(isset($daying)){{!array_key_exists($i,$daying)?'display: none':''}}@else display: none @endif">
                                                            <div class="col-lg-12 center">
                                                                <label for="">Pilih Waktu:</label>
                                                            </div>
                                                            <div class="col-lg-12 radio-multiple center"
                                                                 style="padding: 0px">
                                                                @foreach($time as $r)
                                                                    <label>
                                                                        <input type="checkbox" class="choose_times"
                                                                               name="time[]" value="{{$r->id}}"
                                                                                {{session('order')&&array_key_exists('time',session('order')['data'][$i])&&session('order')['data'][$i]['time']==$r->id?$daying[$i]='checked':''}}
                                                                        />
                                                                        <div class="back-end box zoom">
                                                                            <span>{{$r->start.' - '. $r->end.' WIB'}}</span>
                                                                        </div>
                                                                    </label>
                                                                @endforeach
                                                                <span class="help-block"
                                                                      style="padding-left: 9px;display: none">
                                                                <strong></strong>
                                                            </span>
                                                            </div>
                                                        </div>
                                                    </dd>
                                                @endfor
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="next animated">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row" id="step3">
                                            <div class="col-lg-6 payment-step">
                                                <div class="payment-header">
                                                    <div class="payment-code">
                                                        Detail Pembayaran
                                                    </div>
                                                    <div class="payment-content">
                                                        <div class="payment-title">
                                                            <strong style="font-size:17px;">Pendaftar #1</strong>
                                                            <span class="pull-right"
                                                                  style="margin: 1px 0">Dummy af</span>
                                                        </div>
                                                        <div class="payment-detail">
                                                            <div class="payment-list">
                                                                <label>Biaya Pendaftaran</label>
                                                                <span class="pull-right">Rp 70.000,00</span>
                                                            </div>
                                                            <div class="payment-list">
                                                                <label>Kelas Menari</label>
                                                                <span class="pull-right">Rp 280.000,00</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="payment-content">
                                                        <div class="payment-title">
                                                            <strong style="font-size:17px;">Pendaftar #1</strong>
                                                            <span class="pull-right"
                                                                  style="margin: 1px 0">Dummy af</span>
                                                        </div>
                                                        <div class="payment-detail">
                                                            <div class="payment-list">
                                                                <label>Biaya Pendaftaran</label>
                                                                <span class="pull-right">Rp 70.000,00</span>
                                                            </div>
                                                            <div class="payment-list">
                                                                <label>Kelas Menari</label>
                                                                <span class="pull-right">Rp 280.000,00</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="payment-content">
                                                        <div class="payment-title">
                                                            <strong style="font-size:17px;">Pendaftar #1</strong>
                                                            <span class="pull-right"
                                                                  style="margin: 1px 0">Dummy af</span>
                                                        </div>
                                                        <div class="payment-detail">
                                                            <div class="payment-list">
                                                                <label>Biaya Pendaftaran</label>
                                                                <span class="pull-right">Rp 70.000,00</span>
                                                            </div>
                                                            <div class="payment-list">
                                                                <label>Kelas Menari</label>
                                                                <span class="pull-right">Rp 280.000,00</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="payment-total">
                                                    <label>Total</label>
                                                    <span class="pull-right" style="color: #22918b;font-weight: 600">Rp 9.000.000,00
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="payment-code hidden-pc">
                                                    Informasi Pembayaran
                                                </div>
                                                <div class="form-group">
                                                    <label for="code">Kode Diskon:</label>
                                                    <div class="row">
                                                        <div class="col-lg-9 col-md-9 col-sm-9"
                                                             style="padding-right: 0px">
                                                            <input type="text" class="form-control" id="code"
                                                                   name="code" placeholder="*Tulis disini jika ada">
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-3"
                                                             style="padding-left: 0px;">
                                                            <button class="btn"
                                                                    style="border-radius: 0px; height: 34px;width: 100%">
                                                                cek
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <span class="help-block" style="padding-left: 9px;display: none">
                                                                <strong></strong>
                                                            </span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="code">A/N:</label>
                                                    <input type="text" class="form-control" id="an"
                                                           name="an"
                                                           placeholder="*Tulis nama pelaku transaksi">
                                                    <span class="help-block" style="padding-left: 9px;display: none">
                                                                <strong></strong>
                                                            </span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="code">Metode Pembayaran:</label><br>
                                                    <div class="row select-radio">
                                                        @foreach($method as $row)
                                                            <div class="col-lg-6">
                                                                <label>
                                                                    <input type="radio" name="paying_method"
                                                                           value="{{$row->id}}"/>
                                                                    <div class="back-end zoom">
                                                                        <img src="{{url($row->url)}}"
                                                                             alt="{{$row->name}}">
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <span class="help-block" style="padding-left: 9px;display: none">
                                                                <strong></strong>
                                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="next animated">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row" id="step4">
                                            <div class="col-lg-6 payment-step">
                                                <div class="payment-header">
                                                    <div class="payment-code">
                                                        Detail Pembayaran
                                                    </div>
                                                    <div class="payment-content">
                                                        <div class="payment-title">
                                                            <strong style="font-size:17px;">Pendaftar #1</strong>
                                                            <span class="pull-right"
                                                                  style="margin: 1px 0">Dummy af</span>
                                                        </div>
                                                        <div class="payment-detail">
                                                            <div class="payment-list">
                                                                <label>Biaya Pendaftaran</label>
                                                                <span class="pull-right">Rp 70.000,00</span>
                                                            </div>
                                                            <div class="payment-list">
                                                                <label>Kelas Menari</label>
                                                                <span class="pull-right">Rp 280.000,00</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="payment-content">
                                                        <div class="payment-title">
                                                            <strong style="font-size:17px;">Pendaftar #1</strong>
                                                            <span class="pull-right"
                                                                  style="margin: 1px 0">Dummy af</span>
                                                        </div>
                                                        <div class="payment-detail">
                                                            <div class="payment-list">
                                                                <label>Biaya Pendaftaran</label>
                                                                <span class="pull-right">Rp 70.000,00</span>
                                                            </div>
                                                            <div class="payment-list">
                                                                <label>Kelas Menari</label>
                                                                <span class="pull-right">Rp 280.000,00</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="payment-content">
                                                        <div class="payment-title">
                                                            <strong style="font-size:17px;">Pendaftar #1</strong>
                                                            <span class="pull-right"
                                                                  style="margin: 1px 0">Dummy af</span>
                                                        </div>
                                                        <div class="payment-detail">
                                                            <div class="payment-list">
                                                                <label>Biaya Pendaftaran</label>
                                                                <span class="pull-right">Rp 70.000,00</span>
                                                            </div>
                                                            <div class="payment-list">
                                                                <label>Kelas Menari</label>
                                                                <span class="pull-right">Rp 280.000,00</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="payment-total">
                                                    <label>Total</label>
                                                    <span class="pull-right" style="color: #22918b;font-weight: 600">Rp 9.000.000,00
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="title-detail">Potongan Harga :</label>
                                                    <strong class="desc-detail">70%</strong>
                                                </div>
                                                <div class="form-group">
                                                    <label class="title-detail">A/N :</label>
                                                    <strong class="desc-detail">dummy af</strong>
                                                </div>
                                                <div class="form-group">
                                                    <label class="title-detail">Metode Pembayaran :</label>
                                                    <strong class="desc-detail">Tranfer</strong>
                                                </div>
                                                <div class="form-group">
                                                    <label class="title-detail">Batas Waktu :</label>
                                                    <strong class="desc-detail">Senin, 27 Sep 2017 14.00 WIB (sisa
                                                        waktu:12:00:00)</strong>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <a class="btn btn-step" id="next">Next Section ▷</a>
                        <input type="submit" class="btn btn-step">
                    </form>
                </div>
            </div>
        </div><!-- /.container -->
    </div>
    <!-- Section eleven end -->
@endsection
@push('style')
    <link href="{{asset('css/new.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/accordion.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/countdown.css')}}" rel="stylesheet" type="text/css"/>

    <style>
        @import url(https://fonts.googleapis.com/css?family=Old+Standard+TT:400,400italic);

        .add-margin-bottom-sm {
            height: 72px;
            margin-bottom: 0.8em;
        }

        .center {
            text-align: center;
        }

        #signup h4 {
            color: #3c3d35;
            /*font-size: 200%;*/
            position: relative;
            top: 27px;
            letter-spacing: 0.2em;
            margin: 0;
            text-align: center;
            text-transform: uppercase;
        }

        #signup h4::after {
            background-color: #2cbab2;
            content: "";
            display: block;
            height: 2px;
            margin: 0.75rem auto 2.25rem;
            width: 6rem;
        }

        @media (max-width: 1199px) {
            .add-min {
                top: 18px;
            }
        }

        .select-radio input[type="radio"] {
            display: none;
        }

        .select-radio input[type="radio"]:checked + .zoom {
            border-left: 3px #22918b solid;
        }

        .select-radio input[type="radio"]:hover + .zoom {
            border-left: 3px #22918b solid;
            cursor: pointer;
        }

        .select-radio input[type="radio"][disabled] + .zoom {
            background: #cccccc30;
            color: #3a3a3a4f;
            /*border: #3a3a3a4f 2px solid;*/
            cursor: not-allowed;
        }

        .select-radio .box {
            border: #3a3a3a4f 1px solid;
            border-radius: 4px;
            padding: 3px 12px;
            margin: 3px 6px;
            background: white;
            position: relative;
            cursor: pointer;
        }

        .select-radio .box:hover {
            border: #2cbab2 1px solid;
            color: #2cbab2;
        }
    </style>

    {{--select-picker--}}
    <style>
        form .dropdown-toggle {
            background: #fff;
            border: #3a3a3a4f 1px solid;
            border-radius: 4px;
        }

        form .dropdown-toggle:hover {
            background: #fff;
            outline: none;
            border: 1px solid #22918b;
        }

        form .dropdown-toggle .filter-option-inner-inner {
            color: #2b2b2b;
        }

        form .dropdown-toggle[aria-expanded=true] + .dropdown-toggle {
            background: #fff;
            outline: none;
            border: 1px solid #22918b;
        }

        form .dropdown-menu li:hover {
            background: #22918b;
            color: white;
        }

    </style>

    {{--payment--}}
    <style>
        .payment-list {
            margin-left: 5px;
        }

        .payment-list label {
            font-weight: unset;
        }

        .payment-list .pull-right {
            font-weight: 600;
        }

        .payment-header {
            border-bottom: 1px #ccc solid;
            margin-bottom: 9px;
        }

        .payment-code {
            background: #2cbab2;
            padding: 4px 7px;
            color: #fff;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .payment-total {
            margin-bottom: 8px;
        }

        .payment-step {
            border-right: 1px #ccc solid;
            min-height: 242px;
        }

        @media (max-width: 1199px) {
            .payment-step {
                border-right: 0px #ccc solid;
                margin-bottom: 16px;
            }
        }

        @media (min-width: 1200px) {
            .hidden-pc {
                display: none;
            }
        }
    </style>

    {{--detail grid--}}
    <style>
        .title-detail {
            display: block;
            font-size: 12px;
        }

        .desc-detail {
            margin: 0 6px;
            font-size: 16px;
            font-weight: unset;
        }
    </style>
@endpush

@push('package')
    <script type="text/javascript" src="{{asset('js/new.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/accordion.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/tweenMax.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/countdown.js')}}"></script>
@endpush

@push('js')
    @include('user.order.index.js.partials')
    @include('user.order.index.js.async')
@endpush
