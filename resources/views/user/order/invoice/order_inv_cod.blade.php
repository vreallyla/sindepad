@extends('layouts.side_user')
@section('desc','invoice sanggar abk')
@section('key','abk, disablitas, difabel, slb')
@section('content')
    <div class="col-lg-12 card-notice payment-detail">
        <h5>Total Pembayaran</h5>
        <h3 class="add-rp">{{number_format(($data->disc?
        ($data->disc->type==='Diskon'?
        $data->total*(100-$data->disc->amount)/100:$data->total-$data->disc->amount
        ):$data->total),0,',','.')}}</h3>
        <span>Bayar pendaftaran sesuai nominal</span>
        <p>Silakan melakukan pembayaran di tempat {{env('APP_NAME')}} sebelum batas waktu yang telah ditentukan. kami
            akan menunggu kedatangan anda.</p>
        <h4>Batas Waktu: {{$data->date_end}}</h4>
    </div>
    <div class="col-lg-12 invoice-info">
        <h3 class="numb-circle">1</h3>
        <span>
            jika belum mengetahui lokasi {{env('APP_NAME')}}, klik lihat lokasi untuk membuka mengetahui lokasi kami melalui Google maps.
        </span>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 card-notice obj-prinf">
        <div class="title-rec">
            <h4>Pendaftaran Kelas</h4>
        </div>
        <div class="content-rec">
            <h5>SG1809200001PK</h5>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 obj-detail">
                <span>Sub Total: </span><h4 class="add-rp">{{number_format($data->total,0,',','.')}}</h4>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 obj-detail">
                <span>Diskon: </span><h4 class="{{$data->disc->type==='Diskon'?'add-percent-minus':'add-rp-minus'}}">
                    {{$data->disc->type==='Diskon'?$data->disc->amount:number_format($data->disc->amount,0,',','.')}}</h4>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 obj-detail delimiter">
                <span>Total: </span><h4 class="hightlight add-rp">{{number_format(($data->disc?
        ($data->disc->type==='Diskon'?
        $data->total*(100-$data->disc->amount)/100:$data->total-$data->disc->amount
        ):$data->total),0,',','.')}}</h4>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 obj-footer">
                <a href="https://www.google.co.id/maps/place/QIS+English+Surabaya/@-7.3414069,112.7930309,15z/data=!4m5!3m4!1s0x0:0xe3dfd696e1ca8f30!8m2!3d-7.3414069!4d112.7930309?hl=id"
                   target="_blank" class="pull-right">Lihat lokasi</a>
            </div>

        </div>
    </div>
    <div class="col-lg-12 invoice-info">
        <h3 class="numb-circle">2</h3>
        <span>
            Harap tunjukan laman ini ketika melakukan konfirmasi pembayaran atau klik tombol cetak bukti pendaftaran sekarang untuk mencetak bukti pendaftaran.
        </span>
    </div>
    <div class="col-lg-12 invoice-info">
        <h3 class="numb-circle">3</h3>
        <span>
            Demi keamanan transaksi, mohon untuk tidak membagikan halaman ini atau hasil cetakan bukti pendaftaran kepada
            siapapun, selain untuk melakukan pembayaran ke {{env('APP_NAME')}} .
        </span>
    </div>
    <div class="col-lg-12 btn-confirm">
        <button class="btn-conti">Cetak Bukti Pendaftaran sekarang</button>
        <button class="btn-canc">Cetak Bukti Pendaftaran Nanti</button>
    </div>
@endsection

@push('style')
    <style>
        .btn-confirm {
            margin-top: 3px;
            padding: 0;
        }

        .obj-footer a:hover {
            background: #257c83;
            cursor: pointer;
            text-decoration: none;
        }

        .obj-footer a {
            background: #3abac6;
            color: #FFF;
            margin: 13px 0 0px 0px;
            padding: 9px 20px;
        }

        .obj-footer {
            padding: 0;
            z-index: 1;
        }

        .btn-confirm button {
            display: block;
            width: 100%;
            margin: 9px 0 !important;
            padding: 10px 0 !important;
        }

        .btn-confirm .btn-conti {
            background: #3ABAC6;
            color: #fff;
            border: 1px solid #eee;
        }

        .btn-confirm .btn-conti:hover {
            background: #288794;
        }

        .btn-confirm .btn-canc {
            background: #edf2f6;
            border: 1px solid #bcafaf;
            color: #5c5252;

        }

        .btn-confirm .btn-canc:hover {
            border: 1px solid #3ABAC6;
            color: #3ABAC6;

        }

        .invoice-info, .card-notice {
            margin: 6px 0;
        }

        .invoice-info span {
            display: inline;
            padding-left: 4px;
            color: #757f89;
            position: relative;
            top: 1px;

        }

        .invoice-info .numb-circle {
            margin: 3px 0;
            color: #edf2f6;
            background: #96a0a8;
            padding: 6px 16px 6px 8px;
            border-radius: 16px;
            width: 22px;
            font-size: 12px;
            display: inline-block;
        }

        .title-rec h4 {
            display: inline-block;
            font-size: 1.5em;
            margin: 0 0 0 5px;
        }

        .delimiter {
            margin-bottom: 1px;
            border-bottom: 1px dashed #eee;
        }

        .hightlight {
            color: #3abac6;
            font-weight: bold;
        }

        .title-rec {
            border-bottom: 1px solid #eee;
            padding: 6px 0;
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

        @media (max-width: 382px) {
            .content-rec h5 {
                font-size: 0.8em;
                top: 14px;
            }

            .title-rec {
                padding: 5px 0;
            }

            .title-rec h4 {
                font-size: 1.1em;
            }
        }

        .content-rec, .card-notice {
            margin: 6px 0;
        }

        .content-rec .obj-detail h4 {
            position: absolute;
            top: -9px;
            right: 2px;
        }

        .content-rec .obj-detail span {
            display: block;
            padding-left: 4px;
        }

        .content-rec .obj-detail {
            padding: 0;
            padding-bottom: 8px;
        }

        .payment-detail h4 {
            font-size: 1.2em;
        }

        .obj-total h4 {
            display: inline-block;
            margin-left: 4px;
        }

        .obj-total {
            text-align: right;
            padding: 0;
        }

        .payment-detail h5 {
            margin: 7px 0px;
        }

        .payment-detail span {
            font-size: 1.1em;
            position: absolute;
            top: 19px;
            right: 25px;
            color: #3abac6;
        }

        .payment-detail h3 {
            margin: 0;
            color: #3abac6;
            margin-bottom: 5px;
            font-size: 1.8em;
        }

        .card-notice {
            background: #fff;
            padding: 14px 23px;
            border: 1px solid #e5e3e3;
        }

        .add-rp:before {
            content: 'Rp'
        }

        .add-rp-minus:before {
            content: '-Rp'
        }

        .add-percent-minus:before {
            content: '-';
        }

        .add-percent-minus:after {
            content: '%';
        }

        @media (max-width: 444px) {
            .payment-detail span {
                display: none;
            }
        }

        @media (max-width: 397px) {
            .payment-detail h4 {
                font-size: 1em;
                font-weight: bold;
            }
        }
    </style>
@endpush

@push('js')
    <script>
        $(function () {
            const objHide = $('.btn-confirm,.obj-footer a,.fa-arrow-left');

            $('.btn-conti').click(e => {
                objHide.hide();
                window.print();
                setTimeout(e => {
                    objHide.show();
                }, 300)
            });

            $('.btn-canc').click(e => {
                history.back();
            });
        })
    </script>
@endpush
