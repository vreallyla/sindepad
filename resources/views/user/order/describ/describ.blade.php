@extends ('layouts.side_user')
@section('desc','checkout sanggar abk')
@section('key','abk, disablitas, difabel, slb')
@section('content')
    <div class="col-lg-12 card-notice radius-bottom {{$array['notice']['status']==='batal'?'trans-notice-failed':'trans-notice-success'}}">
        <h4>{{$array['notice']['title']}}</h4>
        <p>{{$array['notice']['content']}}</p>
        <span>waktu pendaftaran : {{$array['date']['created_at']['date_str']}}</span>
    </div>
    <div class="col-lg-12 card-notice radius-top botton-option">
        <div class="fill-content">
            <div class="list-total">
                <span>Sub Total</span>
                <h5 class="add-rp">{{number_format($array['total'], 0, ',', '.')}}</h5>
            </div>
            <div class="list-total">
                <span>Potongan Harga</span>
                <h5 class="{{array_key_exists('voucher',$array)?
                ($array['voucher']['type']==='Diskon'?'add-percent-minus':'add-rp-minum'):
                ''}}">
                    {{array_key_exists('voucher',$array)?
                    ($array['voucher']['type']==='Diskon'?$array['voucher']['amount']:number_format($array['voucher']['amount'],0,',','.')):
                    0}}</h5>
            </div>
            <div class="list-total">
                <span>Jumlah Harus Bayar</span>
                <h5 class="highlight add-rp">{{number_format((array_key_exists('voucher',$array)?
                ($array['voucher']['type']==='Diskon'?$array['total']*(100-$array['voucher']['amount'])/100:
                $array['total']-$array['voucher']['amount']):
                $array['total']), 0, ',', '.')
                }}</h5>
            </div>
            @if(array_key_exists('method',$array))
                <div class="list-total">
                    <span>Metode Pembayaran</span>
                    <h5 data-toggle="tooltip" data-placement="left"
                        title="{{$array['method']['desc']}}">{{$array['method']['name']}}</h5>
                </div>
            @endif
        </div>
        @if($array['notice']['status']==='confirm')
            <button class="btn-suc" onclick="window.location='{{route('order.info').'?q='.$code}}';">Rubah
                Transaksi
            </button>
        @elseif($array['notice']['status']==='payment')
            @if($array['method']['method']==='Bayar Ditempat')
                <button class="btn-suc" onclick="window.location='{{route('order.info').'?q='.$code}}';">Info Pembayaran
                </button>
            @else
                <button class="btn-suc" onclick="window.location='{{route('order.info').'?q='.$code}}';">Transfer
                    Sekarang
                </button>
            @endif
            <button class="btn-oth delete-trans">Batalkan Pesanan</button>
            <button class="btn-oth" onclick="window.location='{{route('order.method').'?q='.$code}}';">Rubah Metode
            </button>
        @elseif($array['notice']['status']==='failed')
            <button class="btn-suc" onclick="window.location='{{route('order.info').'?q='.$code}}';">Hapus Transaksi
            </button>
        @endif
    </div>
    <div class="col-lg-12 card-notice content-notice">
        <div class="title-notice">
            <h4>Pendaftaran Kelas</h4>
            <span>{{$array['code']}}</span>
        </div>
        <div class="row describ-notice">
            @foreach($array['list'] as $row)
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 detail-notice">
                    <div class="title-describ">
                        <h4>Pendaftar #1</h4>
                        <p class="show-pc">: {{$row['FullName']}}</p>
                        <p class="show-tablet-hp">
                            : {{strlen($row['FullName'])>14?substr($row['FullName'],0,14).'...':$row['FullName']}}</p>
                        <span class="unshow-hp" data-toggle="tooltip" data-placement="left"
                              title="{{$row['needed']}}"><i class="fa fa-compass"></i>&nbsp;Kebutuhan</span>
                    </div>
                    <div class="content-describ">
                        <div class="col-lg-12 col-md-12 col-sm-12  col-xs-12 content-fill show-hp">
                            <span>Kebutuhan</span><h5>{{$row['needed']}}</h5>
                        </div>
                        @foreach($row['bills'] as $r)
                            <div class="col-lg-12 col-md-12 col-sm-12  col-xs-12 content-fill">
                                <span>{{$r['name']}}</span><h5
                                        class="add-rp">{{number_format($r['amount'],0,',','.')}}</h5>
                            </div>
                        @endforeach
                        <div class="col-lg-12 col-md-12 col-sm-12  col-xs-12 content-fill">
                            <span>Total</span><h5
                                    class="add-rp highlight-sm">{{number_format($row['total'],0,',','.')}}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@push('js')
    @include('user.order.general.order_general_js.swallCustom')
    <script>
        $(function () {
            const loading = $('#loading '), errNotice = 'terjadi kesalahan silakan, harap refresh /  kontak admin',
                noticeEmpty = 'data tidak ditemukan, harap muat ulang';
            let getUrlParameter = function getUrlParameter(sParam) {
                let sPageURL = window.location.search.substring(1),
                    sURLVariables = sPageURL.split('&'),
                    sParameterName,
                    i;

                for (i = 0; i < sURLVariables.length; i++) {
                    sParameterName = sURLVariables[i].split('=');

                    if (sParameterName[0] === sParam) {
                        return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                    }
                }
            };

            window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + '{{$token}}';

            $(window).load(e => {
                $('[data-toggle="tooltip"]').tooltip();
            });

            $('.delete-trans').click(function () {
                if (confirm("Hapus Transaksi?")) {
                    console.log(getUrlParameter('q'));
                    let formDel = new FormData();
                    formDel.append('q', getUrlParameter('q'));
                    loading.show();
                    axios.post('{{route('api.order.transDelete')}}', formDel)
                        .then(function (res) {
                            loading.hide();
                            swallCustom('Transaksi berhasil dihapus');
                            setTimeout(e => {
                                window.location = "{{route('order.checkout')}}?tab=payment"
                            }, 300);
                        })
                        .catch(function (er) {
                            loading.hide();
                            er.response.status === 404 ? swallCustom(noticeEmpty) : swallCustom(errNotice);

                        })
                }
            })
        })
    </script>
@endpush
@push('style')
    <style>
        .show-pc {
            display: block;
        }

        .show-tablet {
            display: none;
        }

        .show-hp {
            display: none;
        }

        @media (max-width: 673px) {
            .show-pc {
                display: none;
            }

            .show-tablet-hp {
                display: block;

            }

            .show-tablet {
                display: block;
            }

            .show-hp {
                display: none !important;
            }
        }

        @media (max-width: 520px) {
            .show-pc {
                display: none;
            }

            .unshow-hp {
                display: none;
            }

            .show-tablet {
                display: none;
            }

            .show-hp {
                display: block !important;
            }
        }

        .btn-oth:hover {
            background: #d3d3d3;
        }

        .btn-oth {
            background: #fff;
        }

        .btn-suc:hover {
            background: #2f8995;
        }

        .btn-suc {
            background: #3abac6;
            color: #fff;
        }

        .highlight-sm {
            font-size: 1.3em !important;
            top: -2px !important;
            color: #3abac6;
            font-weight: bold;
        }

        .highlight {
            font-size: 1.5em !important;
            color: #3abac6;
        }

        .add-rp:before {
            content: 'Rp ';
        }

        .add-rp-minum:before {
            content: '-Rp ';
        }

        .add-percent-minus:before {
            content: '-';
        }

        .add-percent-minus:after {
            content: '%';
        }

        .list-total h5 {
            display: inline-block;
            min-width: 157px;
            font-size: 1.2em;
            margin: 6px 0;
            margin-left: 1em;
        }

        .botton-option button {
            border: 1px solid #EEE;
            margin-top: 18px;
            padding: 10px 0;
            margin-right: 9px;
            width: 10em;
            text-align: center;
        }

        .botton-option {
            background: #fafafa;
            text-align: right;
        }

        .radius-bottom {
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 4px;
        }

        .radius-top {
            border-top-left-radius: 4px;
            border-top-right-radius: 5px;
            border-top: 1px dashed #b0a7a7;
        }

        .detail-notice, .fill-content {
            border-bottom: 1px dashed #d5d5d5;
        }

        .content-fill span {
            bottom: 1px;
            position: relative;
            font-size: small;
        }

        .content-fill h5 {
            position: absolute;
            top: 1px;
            right: 0;
            width: 12em;
            margin: 0 6px;
            font-size: 1.2em;
            text-align: right;
        }

        .content-fill {
            padding: 0;
            margin: 3px 0;
        }

        .describ-notice .title-describ h4 {
            font-weight: bold;
        }

        .describ-notice .title-describ span {
            border: 1px solid #e1e3e5;
            padding: 2px 12px;
            position: absolute;
            top: 5px;
            right: 16px;
        }

        .describ-notice .title-describ p {
            position: absolute;
            top: 7px;
            left: 7.3em;
            font-size: 1.2em;
        }

        .describ-notice .title-describ {
            margin-top: 7px;
        }

        .card-notice {
            padding: 10px 22px 28px 22px;
        }

        .content-notice {
            background: #fafafa;
            border: 1px solid #eee;
            margin-top: 12px;
        }

        .title-notice {
            border-bottom: 1px solid #eee;
        }

        .title-notice h4 {
            font-weight: bold;
        }

        .title-notice span {
            position: absolute;
            right: 22px;
            top: 20px;
            color: #3abac6;
            font-weight: bold;
        }

        .trans-notice-success {
            background: rgb(142, 189, 153);
            color: #302e2e;
        }

        .trans-notice-warning {
            background: rgb(201, 220, 135);
            color: #302e2e;
        }

        .trans-notice-failed {
            background: #c64757;
            color: #fff;
        }
    </style>
@endpush