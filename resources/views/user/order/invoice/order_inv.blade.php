@extends('layouts.side_user')
@section('desc','invoice sanggar abk')
@section('key','abk, disablitas, difabel, slb')
@section('content')
    <div class="col-lg-12 card-notice payment-detail">
        <h5>Total Pembayaran</h5>
        <h3 class="add-rp">{{number_format($data->total,0,',','.')}}</h3>
        <span>Bayar pendaftaran sesuai nominal</span>
        <p>Setelah melakukan konfirmasi pendaftaran akan dicek maksimal 24 jam. Harap bayar sesuai dengan total
            pembayaran sebelum batas waktu</p>
        <h4>Batas Waktu: {{$data->date_end}}</h4>
    </div>
    <div class="col-lg-12 invoice-info">
        <h3 class="numb-circle">1</h3>
        <span>
            Lakukan pembayaran via ATM / iBanking / mBanking / setor tunai untuk transfer ke
            rekening {{env('APP_NAME')}} berikut ini:
        </span>
    </div>
    <div class="col-lg-12 card-notice">
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
    <div class="col-lg-12 invoice-info">
        <h3 class="numb-circle">2</h3>
        <span>
            Harap foto / <i>screenshot</i> kwitansi transfer untuk bukti pembayaran
        </span>
    </div>
    <div class="col-lg-12 invoice-info">
        <h3 class="numb-circle">3</h3>
        <span>
            Demi keamanan transaksi, mohon untuk tidak membagikan bukti atau konfirmasi pembayaran pesanan kepada
            siapapun, selain mengunggahnya via aplikasi {{env('APP_NAME')}} .
        </span>
    </div>
    <div class="col-lg-12 btn-confirm">
        <button class="btn-conti">Upload Bukti Pembayaran Sekarang</button>
        <button class="btn-canc">Upload Bukti Pembayaran Nanti</button>
    </div>
    @endsection

@push('style')
    <style>
        .btn-confirm{
            margin-top: 3px;
            padding: 0;
        }
        .btn-confirm button{
            display: block;
            width: 100%;
            margin: 9px 0 !important;
            padding: 10px 0 !important;
        }
        .btn-confirm .btn-conti{
            background: #3ABAC6;
            color: #fff;
            border: 1px solid #eee;
        }
        .btn-confirm .btn-conti:hover{
            background: #288794;
        }
        .btn-confirm .btn-canc{
            background: #edf2f6;
            border: 1px solid #bcafaf;
            color: #5c5252;

        }
        .btn-confirm .btn-canc:hover{
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
            margin-left: 5px;

        }

        .title-rec img {
            width: 50px;
            position: relative;
            bottom: 3px;
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

        .payment-detail h4 {
            font-size: 1.2em;
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
            content: 'Rp '
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

        @media (max-width: 398px) {
            .title-rec h4 {
                font-size: 1em;
                font-weight: bold;
            }
            .content-rec h5{
                font-size: 12px;
                top: 18px;
            }
        }
    </style>
@endpush

@push('js')
    @include('user.order.invoice.order_inv_js.order_inv_partials')
    @endpush