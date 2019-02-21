@section('title-right','Form Penggalangan')
@section('content-right')
    <form>
        <div class="form-group">
            <label for="imgUp">Bukti Transfer</label>
            <input type="file" id="imgUp" name="imgUp" class="form-control" accept="image/*">
            <span class="help-block"></span>
        </div>

        <div class="form-group">
            <label for="name">Atas Nama</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Nama sesuikan dengan Bukti Transfer" >
            <span class="help-block"></span>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="example@example.com" >
            <span class="help-block"></span>
        </div>

        <div class="form-group">
            <label for="fund">Sumbang Ke</label>
            <select name="fund" id="fund"
                    class="form-control selectpicker"
                    data-container="body"
                    data-live-search="true">
                <option value="" selected disabled="true">Pilih Obyek</option>
            @foreach($mst as $row)
                    <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
            </select>
            <span class="help-block"></span>
        </div>

        <div class="form-group">
            <label for="nominal">Jumlah Transfer</label>
            <input type="text" id="nominal" name="nominal" class="form-control input-rp" placeholder="Rp 1000.000">
            <span class="help-block"></span>
        </div>

        <div class="form-group">
            <label for="date_trans">Tanggal Transfer</label>
            <input type="text" id="date_trans" name="date_trans" class="form-control datepicker" placeholder="yyy-mm-dd">
            <span class="help-block"></span>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-info">Daftarkan</button>
        </div>
    </form>
@endsection
