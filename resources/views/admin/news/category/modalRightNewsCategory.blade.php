@section('title-right','Form Kategori')
@section('content-right')
    <form>
        <div class="form-group"><label class="control-label">Nama Kategori :</label> <input type="text"
                                                                                            class="form-control"
                                                                                            name="name"
                                                                                            placeholder="">
            <span class="help-block"></span>
        </div>
        <div class="form-group"><label class="control-label">Detail :</label>
            <textarea name="desc" id="" cols="30" rows="4" class="form-control"></textarea>
            <span class="help-block"></span>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-info">Daftarkan</button>
        </div>
    </form>
@endsection
