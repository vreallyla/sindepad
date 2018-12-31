<div id="confirm" class="tab-fill">
    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
        <div class="tarxeta">
            <div class="tarxeta-titulo">
                <input type="checkbox" id="checkall"/>
                <label for="checkall" data-toggle="tooltip"
                       data-placement="top" title="Pilih Semua"></label>
                <div class="titulo-contido titulo-contido-transaccion">
                    Daftar Transaksi
                </div>
            </div>
            <div class="tarxeta-contido">
                <div class="contido-lista">
                    <div class="contido-esquerda">
                        <input type="checkbox" id="checkout1" name="select_item"/>
                        <label for="checkout1"></label>
                    </div>
                    <div class="contido-ben">
                        <h5 class="cotido-titulo">Pendaftaran Kelas</h5>
                        <table class="cotido-numero">
                            <tr>
                                <td>Jumlah</td>
                                <td> &nbsp;: &nbsp;</td>
                                <td data-toggle="tooltip" class="entity_tab"
                                    data-placement="right" title="yukna, yuksri, nikma"> 3 Anak
                                </td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td> &nbsp;:&nbsp;</td>
                                <td data-toggle="tooltip" class="status_tab"
                                    data-placement="right"
                                    title="sisa waktu : {{now()->addDays(2)->diffForHumans()}}"
                                    style="cursor: pointer"> Menunggu
                                </td>
                            </tr>
                        </table>
                        <span class="contido-custo" data-toggle="tooltip"
                              data-placement="left" title="Rp8000.000/anak">400.000,00</span>
                        <div class="contido-boton">
                            <a href="#">Rubah</a>
                            <a href="{{route('order.info')}}">Rincian</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tarxeta" style="margin-top:20px">
            <div class="tarxeta-titulo">
                <div class="titulo-contido titulo-contido-metodo">
                    Metode Pembayaran
                </div>
            </div>
            <div class="tarxeta-contido">
                @foreach(\App\Model\order\payingMethod::where('method',"Bayar Ditempat")->get() as $row)
                    <div class="tarxeta-titulo pagamento-metodo deslizamento cod">
                        <input type="radio" name="metodo" id="metodo">
                        <label class="comprobar" for="metodo"></label>
                        <input type="radio" name="obj_metodo" id="metodo" value="{{$row->id}}">
                        {{$row->method}}
                    </div>
                    <div class="pagamento-contido">
                        {!!$row->desc!!}
                    </div>
                @endforeach
                <div class="tarxeta-titulo pagamento-metodo deslizamento tf">
                    <input type="radio" name="metodo" id="metodo1">
                    <label class="comprobar" for="metodo1"></label>
                    Transfer Bank
                </div>
                <div class="pagamento-contido">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            Pilih Bank
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                            @foreach(\App\Model\order\payingMethod::where('method',"Transfer")->get() as $i=>$row)
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pagamento-cotenta">
                                            <input type="radio" name="obj_metodo" id="radio{{$i}}" value="{{$row->id}}">
                                            <label for="radio{{$i}}" class="pagamento-radio"></label>
                                            <img class="pagamento-imaxe"
                                                 src="{{asset($row->url)}}"
                                                 alt="">
                                            <h4 class="pagamento-titulo">{{$row->name}}</h4>
                                            <h6 class="pagamento-aviso">Menerima transfer dari semua bank</h6>
                                            <h6 class="pagamento-aviso-ben">{!! $row->desc!!}</h6>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="tarxeta">
            <div class="tarxeta-titulo">
                <div class="titulo-contido titulo-contido-custo">
                    Detail Pembayaran
                </div>
            </div>
            <div class="tarxeta-contido">
                <div class="contido-lista">
                    <div class="pick-contido">
                        2 Transaksi dipilih
                        <span class="pull-right rpcontent">2.000,00</span>
                    </div>
                    <div>
                        potongan Harga
                        <span class="pull-right disc-content">0</span>
                    </div>
                </div>
                <span id="contido-voucher" class="button"
                      data-toggle="tooltip" data-placement="top"
                      title="klik disini jika punya kode voucher">voucher?</span>
                <h5 class="cotido-titulo" style="margin-bottom: 19px;">
                    Total Transaksi
                </h5>
                <span class="contido-custo-ben"> 0</span>

                <button class="btn-contido">Bayar Sekarang</button>
            </div>

        </div>

    </div>
</div>