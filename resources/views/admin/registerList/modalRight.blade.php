@section('title-right','Form Pendaftaran')
@section('content-right')
    <form>
        <div class="step-content-right" style="display: block">
            <div class="form-group"><label class="control-label">Nama Lengkap :</label> <input type="text"
                                                                                               class="form-control"
                                                                                               name="nameUser"
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
                        class="form-control" name="genderUser">
                    <option value="" disabled="true" selected="true">pilih jenis kelamin</option>
                    @foreach($gender as $row)
                        <option value="{{$row->id}}">{{$row->ind}}</option>
                    @endforeach
                </select>
                <span class="help-block"></span>

            </div>
            <button type="submit" class="btn btn-info">Selanjutnya</button>
        </div>
        <div class="step-content-right">
            <div class="form-group">
                <label class="control-label">Nama Lengkap :
                </label> <input type="text" class="form-control" name="nameStudent" placeholder="">
                <span class="help-block"></span>
            </div>
            <div class="form-group"><label class="control-label">Jenis Kelamin :</label>
                <select class="form-control" name="genderStudent">
                    <option value="" disabled="true" selected="true">pilih jenis kelamin</option>
                    @foreach($gender as $row)
                        <option value="{{$row->id}}">{{$row->ind}}</option>
                    @endforeach
                </select>
                <span class="help-block"></span>

            </div>
            <div class="form-group"><label class="control-label">Hubungan :</label>
                <select class="form-control" name="rs">
                    <option value="" disabled="true" selected="true">Pilih Hubungan</option>
                    @foreach($rs as $row)
                        <option value="{{$row->id}}">
                            {{$row->ind}}
                        </option>
                    @endforeach
                </select>
                <span class="help-block"></span>

            </div>
            <div class="form-group">
                <label for="needed" class="control-label">Kebutuhan :</label>
                <select name="needed[]" id="needed"
                        class="form-control selectpicker needed"
                        data-container="body" multiple>
                    @foreach($dis as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </select>
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <label for="desc">Catatan :</label>
                <textarea name="desc" id="desc"
                          placeholder="Jika ada tambahan tulis disini."
                          class="form-control modify-input desc"></textarea>
                <span class="help-block"></span>
            </div>

            <button class="btn btn-default">Sebelumnya</button>
            <button type="submit" class="btn btn-info">Daftarkan</button>
        </div>
    </form>
@endsection
@section('step-right')
    <div class="step-right">
        <i class="step-pre activo"></i>
        <i class="step-pre"></i>
    </div>
@endsection
