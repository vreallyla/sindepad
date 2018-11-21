@extends ('layouts.mst_user')
@section('desc','checkout sanggar abk')
@section('key','abk, disablitas, difabel, slb')
@section('content')
    @include('layouts.breadcumb_user')
    <div class="ed_courses ed_toppadder80 ed_bottompadder80">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 guia">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 cabeza-guia" style="width: 20%">
                        Konfirmasi
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 cabeza-guia" style="width: 20%">
                        Pembayaran
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 cabeza-guia" style="width: 20%">
                        Administrasi
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 cabeza-guia" style="width: 20%">
                        Berhasil
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 cabeza-guia" style="width: 20%">
                        Batal
                    </div>
                </div>

                <div id="empty-data">
                    <img src="{{asset('images/icons/cart.svg')}}" alt=""
                         style="width: 111px; position: relative; top: 33px;">
                    <h4>Data Belum Ada</h4>
                    <span>Silakan melakukan transaksi</span>
                </div>
                <div id="error-data">
                    <img src="{{asset('images/icons/cart.svg')}}" alt=""
                         style="width: 111px; position: relative; top: 33px;">
                    <h4>Ada Kesalahan</h4>
                    <span>harap muat ulang halaman / kontak admin</span>
                </div>

                @include('user.order.checkout.confirm')
                @include('user.order.checkout.payment')
                @include('user.order.checkout.waiting')
                @include('user.order.checkout.success')
                @include('user.order.checkout.failed')

                <div id="loading-tab">
                    <img src="{{asset('images/icons/magnify.svg')}}" alt="">
                    <h4>Mencari Data</h4>
                </div>


            </div>
        </div>
    </div>

    @include('user.order.checkout.modal')

@endsection

@push('js')
    @include('user.order.checkout.js.partials')
    @include('user.order.checkout.js.async')
@endpush

@push('style')
    {{--<link href="{{asset('css/checkout.css')}}" rel="stylesheet" type="text/css"/>--}}
    <style>
        #empty-data, #error-data {
            display: none;
            text-align: center;
        }

        .ed_toppadder80 {
            padding-top: 50px;
        }

        #loading-tab {
            text-align: center;
            padding-top: 7em;
            padding-bottom: 4em;
            display: none;
        }

        #loading-tab > h4 {
            margin: 0;
            position: relative;
            top: -7px;
            font-size: 1.4em;
        }

        #loading-tab > img {
            width: 150px;
        }

        .tab-fill {
            display: none;
        }

        .payment-title {
            border-bottom: 1px solid #c8ced3;
            margin-bottom: 7px;
        }

        .payment-title > h4 {
            text-transform: uppercase;
            margin-top: 19px;
            margin-bottom: 12px;
        }

        .payment-title > span {
            position: absolute;
            top: 16px;
            left: 15.9em;
            border: 1px solid #c8ced3;
            border-radius: 2px;
            text-align: center;
            padding: 1px 10px;
            color: #75777a;
        }

        .payment-title > span:before {
            content: '\F007';
            font-family: FontAwesome;
            font-weight: normal;
            font-style: normal;
            text-decoration: none;
            display: inline-block;
            padding-right: 7px;
        }

        .payment-title > p {
            position: absolute;
            right: 17px;
            top: 20px;
            text-transform: uppercase;
            color: #3abac6;
            font-weight: bold;
        }

        .payment-ava > span {
            font-size: 16px;
        }

        .payment-ava > h6 {
            float: right !important;
            display: inline-block;
            margin: 0;
            font-size: 19px;
        }

        .payment-footer {
            padding-top: 0;
            border-top: 1px #d5d5d5 dashed;
        }

        .payment-footer > .payment-total {
            text-align: right;
        }

        .payment-footer > .payment-total > h3 {
            display: inline-block;
            margin-top: 13px;
            color: #3abac6;
        }

        .payment-footer > .btn-right {
            position: absolute;
            right: 5px;
            top: 11.4em;
        }

        .payment-footer > p {
            padding-top: 4px;
            margin-bottom: 18px;
        }

        .btn-payment:hover {
            background: #267681;
            text-decoration: none;
            color: #fff;
        }

        .btn-payment {
            margin-right: 10px;
            background: #3abac6;
            color: #fff;
            border-radius: 3px;
            padding: 6px 15px;
            border: 0;
            -webkit-transition: all 0.2s ease;
            transition: all 0.2s ease;
            cursor: pointer;
            padding: 9px 12px;
        }

        .btn-payment-support:hover {
            border: 1px solid #3ABAC6;
            color: #3ABAC6;
            text-decoration: none;
        }

        .btn-payment-support {
            margin-right: 10px;
            border: 1px solid #c8ced3;
            border-radius: 3px;
            color: #7a7272;
            background: #fff;
            padding: 6px 15px;
            cursor: pointer;
            padding: 9px 12px;
        }

        .display-phone {
            display: none;
        }
        @media (max-width: 399px){
            .guia{
                font-size: 11px;
            }
        }

        @media (max-width: 427px) {
            .display-phone {
                display: unset;
            }

            .display-pc {
                display: none;
            }

            .payment-title > h4 {
                margin-bottom: 6px;
            }
        }

        @media (max-width: 681px) {
            .btn-payment-support {
                display: none;
            }
        }

        @media (min-width: 992px) {
            .payment-fill {
                margin-bottom: 20px;
            }
        }

        @media (min-width: 300px) and (max-width: 427px) {
            .payment-title > h4 {
                font-size: 112%;
            }

            .payment-title > p {
                top: 18px;
            }

            .payment-footer > .payment-total > h3 {
                font-size: 127%;
            }

            .payment-footer > .btn-right {
                top: 12.5em;
            }

            .payment-footer > p {
                width: 51%;
                margin-bottom: 5px;

            }
        }

        .guia {
            text-align: center;
            background-color: #fafafa;
            background-clip: border-box;
            border: 1px solid #c8ced3;
            border-radius: .25rem;
            padding: 0;
            margin-bottom: 20px;
        }

        .cabeza-guia {
            padding: 13px 0;
            font-size: 100%;
            cursor: pointer;
        }

        .cabeza-guia.activo {
            border-bottom: 3px solid #3ABAC6;
            color: #3ABAC6;
            font-weight: bold;
        }

        .tarxeta {
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid #c8ced3;
            border-radius: .25rem;
        }

        .tarxeta-titulo {
            padding: 7px 19px 6px 19px;
            background-color: #fafafa;
            border-bottom: 1px solid #eee;
        }

        .tarxeta-contido {
            margin: 16px 17px 18px 17px;
        }

        .titulo-contido {
            font-weight: bold !important;
            font-size: 1.25em;
        }

        .titulo-contido-transaccion:before {
            background-image: url("/images/icons/todo.png");
            background-size: 21px 21px;
            display: inline-block;
            width: 21px;
            height: 21px;
            content: "";
            position: relative;
            bottom: -4px;
            right: 4px;
        }

        .titulo-contido-custo:before {
            background-image: url("/images/icons/cost.png");
            background-size: 21px 21px;
            display: inline-block;
            width: 21px;
            height: 21px;
            content: "";
            position: relative;
            bottom: -6px;
            right: 4px;
        }

        .titulo-contido-metodo:before {
            background-image: url("/images/icons/trans.png");
            background-size: 21px 21px;
            display: inline-block;
            width: 21px;
            height: 21px;
            content: "";
            position: relative;
            bottom: -4px;
            right: 4px;
        }

        .contido-esquerda {
            position: relative;
            top: 5px;
        }

        .contido-ben {
            position: relative;
            left: 38px;
        }

        .contido-lista {
            border-bottom: 1px solid #eee;
            padding-bottom: 8px;
        }

        #contido-voucher {
            position: absolute;
            right: 32px;
            top: 13px;
            color: #3ABAC6;
            cursor: pointer;
        }

        #contido-voucher:hover {
            -webkit-transition: -webkit-transform .2s;
            transition: -webkit-transform .2s;
            transition: transform .2s;
            transition: transform .2s, -webkit-transform .2s; /* Animation */
            font-weight: bold;
        }

        .cotido-titulo {
            font-weight: bold;
            margin-bottom: 8px;
        }

        .cotido-numero {
            color: #6c6c6c;;
            margin: 4px 0px;
        }

        .cotido-numero tr:hover {
            color: #3a3a3a;
            cursor: pointer;
        }

        .contido-custo {
            position: absolute;
            right: 35px;
            top: 0px;
            font-weight: bold;
            color: #3ABAC6;
        }

        .contido-custo-ben {
            position: absolute;
            right: 32px;
            bottom: 72px;
            font-weight: bold;
            color: #3ABAC6;
        }

        .contido-custo-ben::before, .contido-custo::before, .rpcontent::before, add-rp {
            content: "Rp";
        }

        .add-percent::after,.disc-perc:after {
            content: "%";

        }

        .disc-perc::before {
            content: "-";

        }
        .disc-rp::before{
            content: '-Rp';
        }

        .contido-boton {
            margin-top: 5px;
        }

        .btn-contido {
            width: 100%;
            background-color: #3ABAC6;
            border: 1px solid #eee;
            padding: 7px 0px;
            color: #fff;
            font-weight: bold;
        }

        .btn-contido:hover {
            width: 100%;
            background-color: #338d9a;
            border: 1px solid #eee;
            padding: 7px 0px;
            color: #fff;
            font-weight: bold;
        }

        .btn-contido:disabled {
            width: 100%;
            background-color: rgba(21, 79, 88, 0.54);
            border: 1px solid #eee;
            padding: 7px 0px;
            color: #e0e0e0;
            font-weight: bold;
            cursor: not-allowed;
        }

        .contido-boton a {
            text-decoration: none;
            -webkit-transition: -webkit-transform .2s;
            transition: -webkit-transform .2s;
            transition: transform .2s;
            transition: transform .2s, -webkit-transform .2s; /* Animation */
            margin-right: 10px;
        }

        .contido-boton a:hover {
            color: #3ABAC6;
            -webkit-transform: scale(1.1);
            transform: scale(1.1);
        }

        [type="checkbox"]:checked,
        [type="checkbox"]:not(:checked) {
            position: absolute;
            left: -9999px;
        }

        [type="checkbox"]:checked + label,
        [type="checkbox"]:not(:checked) + label {
            position: absolute;
            cursor: pointer;
            line-height: 20px;
            display: inline-block;
            color: #666;
        }

        [type="checkbox"]:checked + label[for=checkall],
        [type="checkbox"]:not(:checked) + label[for=checkall] {
            top: 12px;
            right: 54px;
        }

        [type="checkbox"]:checked + label:before,
        [type="checkbox"]:not(:checked) + label:before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 21px;
            height: 21px;
            border: 1px solid #ddd;
            background: #fff;
        }

        [type="checkbox"]:checked + label:after,
        [type="checkbox"]:not(:checked) + label:after {
            content: '';
            width: 10px;
            height: 10px;
            background: #00a69c;
            position: absolute;
            top: 6px;
            left: 6px;
            -webkit-transition: all 0.2s ease;
            transition: all 0.2s ease;
        }

        [type="checkbox"]:not(:checked) + label:after {
            opacity: 0;
            -webkit-transform: scale(0);
            transform: scale(0);
        }

        [type="checkbox"]:checked + label:after {
            opacity: 1;
            -webkit-transform: scale(1);
            transform: scale(1);
        }

        [type="checkbox"]:disabled:checked + label:before,
        [type="checkbox"]:disabled:not(:checked) + label:before {
            border-color: #ccc;
            background-color: #eee;
        }

        [type="checkbox"]:disabled:checked + label:after {
            background: #aaa;
        }

        input[name="obj_metodo"]:checked + label,
        input[name="obj_metodo"]:not(:checked) + label {
            margin-right: 6px;
        }

        input[name="obj_metodo"]:checked + label:before,
        input[name="obj_metodo"]:not(:checked) + label:before {
            content: '';
            display: inline-block;
            position: relative;
            right: 0px;
            top: 4px;
            width: 16px;
            height: 16px;
            border: 1px solid #ddd;
            background: #fff;
            border-radius: 8px;
            -webkit-transition: all 0.8s ease;
            transition: all 0.8s ease;
        }

        input[name="obj_metodo"]:checked + label:after,
        input[name="obj_metodo"]:not(:checked) + label:after {
            content: '\F00C';
            font-family: FontAwesome;
            font-weight: normal;
            font-style: normal;
            text-decoration: none;
            display: inline-block;
            color: #00a69c;
            position: absolute;
            left: 16px;
            bottom: 1px;
            font-size: 19px;
            -webkit-transition: all 0.8s ease;
            transition: all 0.8s ease;
            border-radius: 4px;
        }

        input[name="obj_metodo"]:not(:checked) + label:after {
            opacity: 0;
            -webkit-transform: scaleZ(0);
            transform: scaleZ(0);
        }

        input[name="obj_metodo"]:checked + label:before {
            border: 2px solid #00a69c;
        }

        input[name="obj_metodo"] + label:before {
            border: 1px solid #ddd;
        }

        input[name="obj_metodo"]:checked + label:after {
            opacity: 1;
            -webkit-transform: scaleZ(1);
            transform: scaleZ(1);
        }

        .pagamento-metodo {
            cursor: pointer;
        }

        .comprobar {
            margin-left: 5px;
        }

        input[name="metodo"]:checked + .comprobar:after,
        input[name="metodo"]:not(:checked) + .comprobar:after {
            content: '';
            width: 10px;
            display: inline-block;
            height: 10px;
            background: #00a69c;
            position: relative;
            right: 20px;
            -webkit-transition: all 0.2s ease;
            transition: all 0.2s ease;
            border-radius: 4px;

        }

        input[name="metodo"]:checked + .comprobar:before,
        input[name="metodo"]:not(:checked) + .comprobar:before {
            content: '';
            display: inline-block;
            position: relative;
            right: 5px;
            top: 5px;
            width: 21px;
            height: 21px;
            border: 1px solid #ddd;
            background: #fff;
            border-radius: 8px;
        }

        input[name="metodo"]:not(:checked) + .comprobar:after {
            opacity: 0;
            -webkit-transform: scale(0);
            transform: scale(0);
        }

        input[name="metodo"]:checked + .comprobar:after {
            opacity: 1;
            -webkit-transform: scale(1);
            transform: scale(1);
        }

        .deslizamento:before {
            content: '\F138';
            font-family: FontAwesome;
            font-weight: normal;
            font-style: normal;
            text-decoration: none;
            position: absolute;
            right: 53px;
            font-size: 22px;
            color: #9ea9a7;
            -webkit-transition: all 0.2s ease;
            transition: all 0.2s ease;
        }

        .pagamento-metodo.deslizamento:before {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        .pagamento-metodo.activo.deslizamento:before {
            -webkit-transform: rotate(90deg);
            transform: rotate(90deg);
        }

        .pagamento-contido {
            border-bottom: 1px solid #eee;
            border-left: 1px solid #eee;
            border-right: 1px solid #eee;
            padding: 15px 25px;
            -webkit-transition: all 1s ease;
            transition: all 1s ease;
        }

        .pagamento-metodo + .pagamento-contido {
            display: none;
            opacity: 0;
            -webkit-transform: scaleY(0);
            transform: scaleY(0);
        }

        .pagamento-metodo.activo + .pagamento-contido {
            display: block;
            opacity: 1;
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }

        .pagamento-cotenta {
            margin-bottom: 21px;
            cursor: pointer;
        }

        .pagamento-imaxe {
            width: 70px;
        }

        .pagamento-titulo {
            position: absolute;
            left: 118px;
            top: -12px;
        }

        .pagamento-aviso {
            position: absolute;
            left: 118px;
            top: 11px;
            color: #6c6c6c;
        }

        .pagamento-aviso-ben {
            position: absolute;
            right: 6px;
            bottom: 2px;
            color: #3abac6;
        }

        [type="radio"]:checked,
        [type="radio"]:not(:checked) {
            position: absolute;
            left: -9999px;
        }

        html.modal-active, body.modal-active {
            overflow: hidden;
        }

        #modal-container {
            position: fixed;
            display: table;
            height: 100%;
            width: 100%;
            top: 0;
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

        #modal-container .modal-background .modal span {
            display: inline;
            position: relative;
            bottom: 16px;
            font-weight: bold;
            display: none;
        }
        #modal-container .modal-background .modal input {
            width: 100%;
            height: 40px;
            margin-top: 18px;
            margin-bottom: 19px;
            text-align: center;
        }

        #modal-container .modal-background .modal input:hover {
            border: 1px solid #3ABAC6;
        }

        #modal-container .modal-background .modal .button-success {
            margin-right: 19px;
            width: 6em;
            padding: 8px 0px;
            background-color: #3ABAC6;
            border: 1px solid #727272;
            color: #fff;
            min-height: 37px;
            cursor: pointer;
            text-decoration: none;
        }

        #modal-container .modal-background .modal .button-success.wait-btn {
            padding: 12.6px 0px;
        }

        #modal-container .modal-background .modal .button-success.wait-btn > svg {
            position: absolute;
            top: 9.1em;
            right: 18.1em;
        }

        #modal-container .modal-background .modal .button-success:hover {
            background-color: #2c808c;
            border: 1px solid #eee;
        }

        #modal-container .modal-background .modal .button-failed {
            margin-right: 19px;
            width: 6em;
            padding: 8px 0px;
            background-color: #ddd;
            border: 1px solid #727272;
            text-decoration: none;
        }

        #modal-container .modal-background .modal .button-failed:hover {
            background-color: #9c9c9c;
            border: 1px solid #fafafa;
        }

        #modal-container .modal-background .modal h2 {
            font-size: 25px;
            line-height: 25px;
            margin-bottom: 15px;
        }

        #modal-container .modal-background .modal p {
            font-size: 18px;
            line-height: 22px;
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
    </style>
    <style>
        .add-sub.activo {
            border: 1px solid #3abac6;
            color: #3abac6;
        }

        .add-sub:after {
            content: '\f107';
            font-family: FontAwesome;
            padding-left: 3px;
        }

        .add-sub + ul > a:hover > li {
            border-bottom: 1px solid #eee;
            background: #fafafa;
        }

        .add-sub + ul > a:hover {
            color: #3abac6;
            text-decoration: none;

        }

        .add-sub + ul > a > li {
            margin-bottom: 6px;
            padding: 1px 14px;
            cursor: pointer;
            width: 100%;
            margin-top: 5px;

        }

        .add-sub + ul {
            z-index: 1;
            display: none;
            list-style-type: none;
            position: absolute;
            right: 10px;
            top: 31px;
            border: 1px solid #3abac6;
            background: #fff;
            padding: 0;
            border-radius: 4px;
            font-size: small;
            padding-top: 7px;
            padding-bottom: 6px;
        }
    </style>
@endpush