@section('title-right','Form Metode Pembayaran')
@section('content-right')
    <form>
        <div class="form-group"><label class="control-label">Nama Metode :</label> <input type="text"
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
        <div class="form-group"><label class="control-label" for="bank">Bank :</label>
            <select name="bank" id="bank" data-live-search="true"
                    class="form-control selectpicker category"
                    data-container="body">
                <option value="" selected disabled></option>
            @foreach($bank as $row)
                    <option value="{{$row->id}}">{{$row->name}}</option>
                @endforeach
            </select>
            <span class="help-block"></span>
        </div>
        <div class="form-group"><label class="control-label">No Rekening :</label> <input type="text"
                                                                                          class="form-control"
                                                                                          name="no_rek"
                                                                                          placeholder="">
            <span class="help-block"></span>
        </div>
        <div class="form-group"><label class="control-label">Atas Nama :</label> <input type="text"
                                                                                          class="form-control"
                                                                                          name="an"
                                                                                          placeholder="">
            <span class="help-block"></span>
        </div>

        <div class="form-group"><label class="control-label">Bagian :</label> <input type="text"
                                                                                          class="form-control"
                                                                                          name="division"
                                                                                          placeholder="">
            <span class="help-block"></span>
        </div>


        <button type="submit" class="btn btn-info">Daftarkan</button>
    </form>
@endsection
