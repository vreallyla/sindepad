<div id="waiting" class="tab-fill">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 tarxeta payment-fill"
         style="background: #fff">
        <div class="payment-title">
            <h4>pendaftaran Kelas</h4>
            <span class="display-pc" data-toggle="tooltip"
                  data-placement="right" title="yukna, yuksri, nikma">3 Anak</span>
            <p>Menunggu</p>
        </div>
        <div class="payment-content">
            <div class="payment-ava display-phone">
                <span>Jumlah Pendaftar</span>
                <h6>3</h6>
            </div>
            <div class="payment-ava">
                <span>Sub Total</span>
                <h6 class="rpcontent">Rp30.0000.000,00</h6>
            </div>
            <div class="payment-ava">
                <span>Potongan Harga</span>
                <h6>20%</h6>
            </div>
        </div>
        <div class="payment-footer">
            <div class="payment-total"><span>Total Pembayaran : &nbsp;</span>
                <h3 class="rpcontent">Rp30.0000.000,00</h3></div>


            <p>Berhasil pada {{now()->toDayDateTimeString()}}</p>
            <div class="btn-right">
                <a class="btn-payment" href="{{route('order.info')}}">Tampilkan Rincian</a>
            </div>
        </div>

    </div>
</div>