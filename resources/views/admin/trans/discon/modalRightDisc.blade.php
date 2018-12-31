@section('title-right','Form Diskon')
@section('content-right')
    <form>
        <div class="form-group"><label class="control-label" for="voucher">Kode Voucher :</label>
            <input type="text" name="voucher" id="voucher" class="form-control">
            <span class="help-block"></span>
        </div>
        <div class="form-group"><label class="control-label" for="amount">Nominal :</label>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0;">
                <input type="text" class="form-control input-rp" name="amount" id="amount" placeholder="nominal">
                <label>
                    <input type="checkbox" name="con">&nbsp;Nominal Persen
                </label>
            </div>
            <span class="help-block"></span>
        </div><div class="form-group"><label class="control-label" for="expired">Tanggal Kadaluarsa :</label>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0;">
                <input type="text" class="form-control datepicker" name="expired" id="expired">


            </div>
            <span class="help-block"></span>
        </div>

        <div class="form-group" style="padding-top:3em ;">
            <button type="submit" class="btn btn-info">Daftarkan</button>
        </div>
    </form>
@endsection
