@extends ('layouts.side_user')
@section('desc','checkout sanggar abk')
@section('key','abk, disablitas, difabel, slb')
@section('content')
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 card-notice title-conf">
        <span>Total Pembayaran</span>
        <h3 class="add-rp">{{number_format($data->total,0,',','.')}}</h3>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 card-notice bank-info deslizamento head-card">
        <span>Informasi Bank</span>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 card-notice sub-card">
        <div class="title-rec">
            <img src="{{$data->bank_detail->img}}" alt="{{$data->bank_detail->name}}">
            <h4>{{$data->bank_detail->name}}</h4>
        </div>
        <div class="content-rec">
            <span>Kode Bank: {{$data->bank_detail->code}}</span>
            <span>No. Rekening: <kode>{{$data->bank_detail->account_number}}</kode></span>
            @if($data->bank_detail->division)
                <span>Cabang: {{$data->bank_detail->division}}</span>
            @endif
            <span>Nama Rekening: {{$data->bank_detail->name_owner}}</span>
            <h5>Salin</h5>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 detail-conf">
        <p>Isi formulir dibawah ini sesuai dengan bukti pembayaran. {{env('APP_NAME')}} akan memeriksanya dalam waktu
            kurang dari 24 jam setelah anda
            melakukan konfirmasi pembayaran.</p>
    </div>
    <form id="confirm" {{--enctype="multipart/form-data"--}}>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 card-notice img-conf">
            <h4>Bukti Transfer</h4>
            <div class="image-upload-wrap">
                <input class="file-upload-input" name="img_" type='file' onchange="readURL(this);" accept="image/*"/>
                <div class="drag-text">
                    <i class="fa fa-cloud-upload"></i>
                    <h3>Klik untuk upload bukti pembayaran</h3>
                </div>
            </div>
            <div class="file-upload-content">
                <i type="button" onclick="removeUpload()" class="remove-image fa fa-times-circle">
                </i>
                <img class="file-upload-image" src="#" alt="your image"/>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 card-notice ex-invoice">
            <img src="{{asset('images/ex_invoices/bni.jpg')}}" alt="">
            <span>Contoh Bukti Pembayaran</span>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 card-notice form-label">
            <label>
                <span>Nama Lengkap</span>
                <input type="text" name="name" placeholder="Isi Nama Disini">
            </label>
            <label class="head-select">
                <span>Melalui Bank</span>
                <h5>Pilih Bank</h5>
            </label>
            <div class="sub-select">
                <div class="search-select">
                    <i class="fa fa-arrow-left"></i>
                    <input type="text" name="search_select" id="search_select" placeholder="Cari disini">
                    <i class="fa fa-search"></i>
                    <i class="fa fa-times-circle"></i>
                </div>
                <div class="content-select">
                    @foreach($bank as $i=>$r)
                        <label><input type="radio" name="bank" id="bank{{$i}}" value="{{$r->id}}">{{$r->name}}</label>
                    @endforeach
                    <h4 class="notice-null">Data bank tidak ada, jika yang dicari tidak ada pilih opsi lainnya</h4>
                </div>
            </div>

            <label>
                <span>Tanggal Transfer</span>
                <input class="datepicker" type="text" name="date" placeholder="{{now()->subMonth(2)->toDateString()}}">
            </label>
        </div>

        <div class="btn-submit">
            <button type="submit">Konfirmasi Sekarang</button>
        </div>
    </form>
    @include('user.order.confirm.order_conf_modal')
@endsection

@push('style')
    <style>
        .btn-submit button:hover {
            background: #297c87;
        }

        .btn-submit button {
            width: 100%;
            margin: 1.4em 0;
            padding: 11px 0px;
            font-size: 1em;
            color: #fff;
            background: #3abac6;
        }

        .img-conf, .img-conf h4 {
            margin: 0;
        }

        .form-label input[name="name"], .form-label input[name="date"] {
            outline: unset;
            border: unset;
            float: right;
            text-align: right;
            font-size: 1.1em;
            position: relative;
            top: 2px;
            width: 50%;
            color: #757575;
        }

        .sub-select .content-select label.check:after {
            content: '\F058';
            font-family: FontAwesome;
            font-style: normal;
            text-decoration: none;
            color: #3abac6;
            position: relative;
            top: 2px;
            margin-left: 5px;
        }

        .sub-select .content-select label input {
            visibility: hidden;
        }

        .form-label .sub-select .search-select > .fa-times-circle:hover,
        .form-label .sub-select .search-select > .fa-arrow-left:hover,
        .form-label .sub-select .search-select > .fa-search:hover {
            -ms-transform: scale(1.1);
            -webkit-transform: scale(1.1);
            transform: scale(1.1);
            cursor: pointer;
        }

        .form-label .sub-select .search-select > .fa-arrow-left:hover,
        .form-label .sub-select .search-select > .fa-search:hover {
            color: #25b7be;
        }

        .form-label .sub-select .search-select > input {
            display: none;
            width: 100%;
            padding: 9px 0;
            position: absolute;
            bottom: 202px;
            left: 0;
            text-align: center;
            outline: none;
            border: unset;
            border-bottom: 2px solid #3abac6;
            z-index: 1;
        }

        .form-label .sub-select .search-select > .fa-times-circle {
            z-index: 1;
            display: none;
            position: absolute;
            bottom: 10.8em;
            font-size: 1.4em;
            right: 22px;
            color: #d92929;
            transition: transform .3s !important;
        }

        .form-label .sub-select .search-select > .fa-arrow-left {
            display: none;
            font-size: 1.3em;
            position: absolute;
            bottom: 11.7em;
            z-index: 2;
            left: 13px;
            transition: transform .3s !important;
            color: #746c6c;
        }

        .form-label .sub-select .search-select > .fa-search {
            position: absolute !important;
            top: 3.8em !important;
            right: 23px !important;
            font-size: 1.9em !important;
            transition: transform .3s !important;
            color: #3ABAC6;
        }

        .form-label .sub-select.search-mode {
            margin-top: 41px;
            height: 11em;
        }

        .form-label .sub-select {
            border-bottom: 1px solid #e5e3e3;
            height: 9em;
            overflow: scroll;
        }

        .form-label .sub-select .content-select h4 {
            width: 100%;
            text-align: center;
            display: none;
            padding: 7px 0;
        }

        .form-label .sub-select .content-select label {
            font-weight: unset;
            padding: 6px 21px;
            cursor: pointer;
        }

        label.head-select h5:after {
            content: '\F107';
            font-family: FontAwesome;
            font-style: normal;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.3em;
            position: relative;
            top: 2px;
            margin-left: 4px;
            -webkit-transition: all 2s ease;
            transition: all 2s ease;
        }

        .form-label label.head-select h5 {
            display: inline-block;
            margin: 0;
            float: right;
            position: relative;
            top: 0;
            font-size: 1.1em;
            font-weight: bold;
            color: #757575;
            cursor: pointer;
        }

        .form-label label {
            padding: 13px 21px;
            display: block;
            border-bottom: 1px solid #e5e3e3;
            margin: 0;
        }

        .form-label {
            border-bottom: unset;
            margin-top: 8px;
            padding: 0 !important;
        }

        .sub-select {
            display: none;
        }

        .detail-conf {
            margin: 12px 0 2px 0;
        }

        .content-rec h5 {
            text-transform: uppercase;
            position: absolute;
            top: 19px;
            right: 28px;
            font-weight: bold;
            color: #3abac6;
            cursor: pointer;
        }

        .content-rec span {
            display: block;
            padding-left: 58px;
        }

        .title-rec h4 {
            display: inline-block;
            font-size: 1.5em;
            margin-left: 5px;

        }

        .title-rec img {
            width: 50px;
            position: relative;
            bottom: 3px;
        }

        .card-notice span {
            font-size: 1.1em;
        }

        .card-notice {
            background: #fff;
            padding: 14px 23px;
            border: 1px solid #e5e3e3;
        }

        .title-conf h3 {
            position: absolute;
            margin: 0;
            top: 14px;
            font-size: 1.4em;
            right: 23px;
            color: #3ABAC6;
        }

        .add-rp:before {
            content: 'Rp '
        }

        .sub-card {
            display: none;
            border-top: unset;
        }

        .bank-info, .ex-invoice {
            border-top: unset;
            cursor: pointer;
        }

        .ex-invoice:hover > span {
            color: #3ABAC6;
        }

        .ex-invoice img {
            width: 17px;
            margin-right: 6px;
        }

        .ex-invoice span {
            position: relative;
            top: 3px;
        }

        .deslizamento:before {
            content: '\F138';
            font-family: FontAwesome;
            font-weight: normal;
            font-style: normal;
            text-decoration: none;
            position: absolute;
            right: 23px;
            bottom: 8px;
            font-size: 22px;
            color: #9ea9a7;
            -webkit-transition: all 0.2s ease;
            transition: all 0.2s ease;
        }

        .bank-info.deslizamento:before {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        .bank-info.activo.deslizamento:before {
            -webkit-transform: rotate(90deg);
            transform: rotate(90deg);
        }
    </style>
    <style>
        .file-upload-btn {
            width: 100%;
            margin: 0;
            color: #fff;
            background: #1FB264;
            border: none;
            padding: 10px;
            border-radius: 4px;
            border-bottom: 4px solid #15824B;
            transition: all .2s ease;
            outline: none;
            text-transform: uppercase;
            font-weight: 700;
        }

        .file-upload-btn:hover {
            background: #1AA059;
            color: #ffffff;
            transition: all .2s ease;
            cursor: pointer;
        }

        .file-upload-btn:active {
            border: 0;
            transition: all .2s ease;
        }

        .file-upload-content {
            display: none;
            text-align: center;
        }

        .file-upload-input {
            position: absolute;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            outline: none;
            opacity: 0;
            cursor: pointer;
        }

        .image-upload-wrap {
            margin: 9px auto;
            width: 10em;
            height: 9em;
            border: 2px dashed;
            text-align: center;
            position: relative;
        }

        .image-dropping,
        .image-upload-wrap:hover {
            background-color: #3ABAC6;
            border: 4px dashed #ffffff;
        }

        .image-upload-wrap:hover > .drag-text > i,
        .image-upload-wrap:hover > .drag-text > h3 {
            color: #3c3c3c;
        }

        .image-title-wrap {
            padding: 0 15px 15px 15px;
            color: #222;
        }

        .drag-text {
            text-align: center;
            color: #676161;
        }

        .drag-text i {
            font-size: 4em;
            margin-top: 10px;
        }

        .drag-text h3 {
            font-weight: 100;
            color: #676161;
            font-size: 15px;
            margin: 8px 0;
        }

        .file-upload-image {
            max-height: 200px;
            max-width: 200px;
            margin: auto;
            padding: 20px;
        }

        .remove-image {
            display: inline-block;
            position: relative;
            font-size: 23px;
            bottom: 29px;
            left: 177px;
            color: #cd4535;
            transition: transform .3s;
        }

        .remove-image:hover {
            color: #939393;
            transition: all .2s ease;
            -ms-transform: scale(1.1);
            -webkit-transform: scale(1.1);
            transform: scale(1.1);
            cursor: pointer;
        }

        .remove-image:active {
            border: 0;
            transition: all .2s ease;
        }
    </style>

    <style>
        html.modal-active, body.modal-active {
            overflow: hidden;
        }

        #modal-container {
            position: fixed;
            display: table;
            height: 100%;
            width: 100%;
            top: 28px;
            left: 0;
            -webkit-transform: scale(0);
            transform: scale(0);
            z-index: 1;
        }

        #modal-container.one {
            -webkit-transform: scaleY(0.01) scaleX(0);
            transform: scaleY(0.01) scaleX(0);
            -webkit-animation: unfoldIn 1s cubic-bezier(0.165, 0.84, 0.44, 1) forwards;
            animation: unfoldIn 1s cubic-bezier(0.165, 0.84, 0.44, 1) forwards;
        }

        #modal-container.one .modal-background .modal {
            padding: 15px;
            -webkit-transform: scale(0);
            transform: scale(0);
            -webkit-animation: zoomIn 0.5s 0.8s cubic-bezier(0.165, 0.84, 0.44, 1) forwards;
            animation: zoomIn 0.5s 0.8s cubic-bezier(0.165, 0.84, 0.44, 1) forwards;
        }

        #modal-container.one.out {
            -webkit-transform: scale(1);
            transform: scale(1);
            -webkit-animation: unfoldOut 1s 0.3s cubic-bezier(0.165, 0.84, 0.44, 1) forwards;
            animation: unfoldOut 1s 0.3s cubic-bezier(0.165, 0.84, 0.44, 1) forwards;
        }

        #modal-container.one.out .modal-background .modal {
            -webkit-animation: zoomOut 0.5s cubic-bezier(0.165, 0.84, 0.44, 1) forwards;
            animation: zoomOut 0.5s cubic-bezier(0.165, 0.84, 0.44, 1) forwards;
        }

        #modal-container .modal-background {
            display: table-cell;
            background: rgba(0, 0, 0, 0.8);
            text-align: center;
            vertical-align: middle;
        }

        #modal-container .modal-background .modal {
            background: white;
            padding: 0px 20px 28px 20px;
            display: inline-block;
            border-radius: 3px;
            font-weight: 300;
            position: relative;
        }

        #modal-container .modal-background .modal a {
            display: block;
            margin-top: 12px;
            color: #3abac6;
            cursor: pointer;
        }

        #modal-container .modal-background .modal .modal-svg {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            border-radius: 3px;
        }

        #modal-container .modal-background .modal .modal-svg rect {
            stroke: #fff;
            stroke-width: 2px;
            stroke-dasharray: 778;
            stroke-dashoffset: 778;
        }

        @media (max-width: 991px ) {
            .col-sm-12 {
                margin-bottom: 20px;
            }
        }

        @media (max-width: 453px) {
            .pagamento-aviso-ben {
                display: none;
            }

        }

        @media (min-width: 320px ) {
            #modal-container .modal-background .modal {
                width: 90%;
            }
        }

        @media (min-width: 481px ) {
            #modal-container .modal-background .modal {
                width: 80%;
            }
        }

        @media (min-width: 768px ) {
            #modal-container .modal-background .modal {
                width: 60%;
            }
        }

        @media (min-width: 1025px ) {
            #modal-container .modal-background .modal {
                width: 30%;
            }
        }

        @-webkit-keyframes unfoldIn {
            0% {
                -webkit-transform: scaleY(0.005) scaleX(0);
                transform: scaleY(0.005) scaleX(0);
            }
            50% {
                -webkit-transform: scaleY(0.005) scaleX(1);
                transform: scaleY(0.005) scaleX(1);
            }
            100% {
                -webkit-transform: scaleY(1) scaleX(1);
                transform: scaleY(1) scaleX(1);
            }
        }

        @keyframes unfoldIn {
            0% {
                -webkit-transform: scaleY(0.005) scaleX(0);
                transform: scaleY(0.005) scaleX(0);
            }
            50% {
                -webkit-transform: scaleY(0.005) scaleX(1);
                transform: scaleY(0.005) scaleX(1);
            }
            100% {
                -webkit-transform: scaleY(1) scaleX(1);
                transform: scaleY(1) scaleX(1);
            }
        }

        @-webkit-keyframes unfoldOut {
            0% {
                -webkit-transform: scaleY(1) scaleX(1);
                transform: scaleY(1) scaleX(1);
            }
            50% {
                -webkit-transform: scaleY(0.005) scaleX(1);
                transform: scaleY(0.005) scaleX(1);
            }
            100% {
                -webkit-transform: scaleY(0.005) scaleX(0);
                transform: scaleY(0.005) scaleX(0);
            }
        }

        @keyframes unfoldOut {
            0% {
                -webkit-transform: scaleY(1) scaleX(1);
                transform: scaleY(1) scaleX(1);
            }
            50% {
                -webkit-transform: scaleY(0.005) scaleX(1);
                transform: scaleY(0.005) scaleX(1);
            }
            100% {
                -webkit-transform: scaleY(0.005) scaleX(0);
                transform: scaleY(0.005) scaleX(0);
            }
        }

        @-webkit-keyframes zoomIn {
            0% {
                -webkit-transform: scale(0);
                transform: scale(0);
            }
            100% {
                -webkit-transform: scale(1);
                transform: scale(1);
            }
        }

        @keyframes zoomIn {
            0% {
                -webkit-transform: scale(0);
                transform: scale(0);
            }
            100% {
                -webkit-transform: scale(1);
                transform: scale(1);
            }
        }

        @-webkit-keyframes zoomOut {
            0% {
                -webkit-transform: scale(1);
                transform: scale(1);
            }
            100% {
                -webkit-transform: scale(0);
                transform: scale(0);
            }
        }

        @keyframes zoomOut {
            0% {
                -webkit-transform: scale(1);
                transform: scale(1);
            }
            100% {
                -webkit-transform: scale(0);
                transform: scale(0);
            }
        }

        /* width */
        ::-webkit-scrollbar {
            width: 10px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            z-index: 1000;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #3ABAC6;
            z-index: 1000;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #216e77;
        }
    </style>
@endpush
@push('js')
    @include('user.order.confirm.order_conf_js.order_conf_partials')
    @include('user.order.confirm.order_conf_js.order_conf_async')
@endpush