<div class="row">
    <div class="col-lg-12">
        <div class="row" id="step3">
            <div class="col-lg-6 payment-step">
                <div class="payment-header">
                    <div class="payment-code">
                        Detail Pembayaran
                    </div>
                    <div class="payment-detail">
                        <span>Jumlah Pendaftaran Awal</span>
                        <h5>Rp{{number_format($sub_total,0,',','.')}}</h5>
                    </div>
                    <div class="payment-detail">
                        <span>Jumlah Pendaftar</span>
                        <h5>1x</h5>
                    </div>
                </div>
                <div class="payment-total">
                    <label>Total</label>
                    <span class="pull-right" style="color: #22918b;font-weight: 600">Rp{{number_format($sub_total,0,',','.')}}
                                                    </span>
                </div>
            </div>
            <div class="col-lg-6 exc-pay">
                <div class="payment-code hidden-pc">
                    Konfirmasi Pendaftaran
                </div>
                <div>
                    <p>Jika selesai mengisi semua formulir dan persetujuan silakan klik dibawah ini</p>
                    <button type="submit">Daftar Sekarang</button>
                </div>
            </div>
        </div>
    </div>
</div>