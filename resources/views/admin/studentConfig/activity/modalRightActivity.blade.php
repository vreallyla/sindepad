@section('title-right','Form Kegiatan')
@section('content-right')
    <form>
        <div class="form-group"><label class="control-label">Nama Kegiatan :</label> <input type="text"
                                                                                           class="form-control"
                                                                                           name="name"
                                                                                           placeholder="">
            <span class="help-block"></span>
        </div>
        <div class="form-group"><label class="control-label">Gambar :</label> <input type="file"
                                                                                    class="form-control"
                                                                                    name="img" accept="image/*">
            <span class="help-block"></span>
        </div>
        <div class="form-group"><label class="control-label">Tujuan :</label> <input type="text"
                                                                                    class="form-control"
                                                                                    name="purpose">
            <span class="help-block"></span>
        </div>
        <div class="form-group"><label class="control-label">Waktu (m) :</label> <input type="number" min="15"
                                                                                        max="120"
                                                                                    class="form-control"
                                                                                    name="span">
            <span class="help-block"></span>
        </div>
        <div class="form-group"><label class="control-label">Detail :</label>
            <textarea name="detail" id="" cols="30" rows="4" class="form-control"></textarea>
            <span class="help-block"></span>
        </div>

        <button type="submit" class="btn btn-info">Daftarkan</button>
    </form>
@endsection
