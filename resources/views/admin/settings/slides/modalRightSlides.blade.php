@section('title-right','Form Slide')
@section('content-right')
    <form>
        <div class="form-group"><label class="control-label" for="img">Gambar :</label>
            <input type="file" name="img" id="img" data-toggle="tooltip" data-placement="top" accept="image/*"
                   title="harap menggunakan gambar 1800x597px">
            <span class="help-block"></span>
        </div>
        <div class="form-group"><label class="control-label" for="link">Alamat :</label>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0;">
                <input type="text" class="form-control" name="link" id="link" placeholder="url">
            </div>
                <span class="help-block"></span>
        </div>
        <div class="form-group"><label class="control-label" for="url_slide">Keterangan :</label>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0;">
                <textarea name="desc" id="" cols="30" rows="3" style="width: 100%"></textarea>
            </div>
            <span class="help-block"></span>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-info">Daftarkan</button>
        </div>
    </form>
@endsection
