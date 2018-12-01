@section('title-right','Form Pendaftaran')
@section('content-right')
<form>
    <input type="hidden" name="_token" value="fg8CiCu06ytokSzRrgKhw8ZoEIJBOkW6ZjzbOop5">
    <div class="form-group"><label class="control-label">Nama Lengkap :</label> <input type="text"
                                                                                       class="form-control"
                                                                                       name="name"
                                                                                       placeholder="">
        <span class="help-block"></span>
    </div>
    <div class="form-group"><label class="control-label">Email :</label> <input type="email"
                                                                                class="form-control"
                                                                                name="email">
        <span class="help-block"></span>
    </div>
    <div class="form-group"><label class="control-label">Jenis Kelamin :</label>
        <select
                class="form-control" name="gender">
            <option value="" disabled="true" selected="true">pilih jenis kelamin</option>
            @foreach($gender as $row)
                <option value="{{$row->id}}">{{$row->ind}}</option>
            @endforeach
        </select>
        <span class="help-block"></span>

    </div>
    <div class="form-group"><label class="control-label">Hak Akses :</label>
        <select
                class="form-control" name="role">
            <option value="" disabled="true" selected="true">pilih Hak Akses</option>
            <option value="Admin">Admin</option>
            <option value="Pengajar">Pengajar</option>
        </select>
        <span class="help-block"></span>

    </div>

    <button type="submit" class="btn btn-info">Daftarkan</button>
</form>
@endsection
