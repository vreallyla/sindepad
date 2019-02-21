<div id="biodata" class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
    <form>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0">
            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label class="control-label">Nama : </label>
                <input type="text" placeholder="Masukkan Nama"
                       class="form-control"
                       value="{{isset($other->personal->name)?$other->personal->name:''}}"
                       name="name">
                <span class="help-block"></span>
            </div>

            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label class="control-label">Email
                    :</label> <input type="email" placeholder="Masukkan Email"
                                     class="form-control"
                                     value="{{isset($other->personal->email)?$other->personal->email:''}}"
                                     name="email">
                <span class="help-block"></span>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0">
            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label class="control-label">Jenis
                    Kelamin
                    :</label>
                <select class="form-control"
                        name="sex">
                    <option value="" selected disabled>pilih Jenis Kelamin</option>
                    @foreach($other->sex as $row)
                        <option value="{{$row->id}}"
                                @if((isset($other->personal->gender_key)?$other->personal->gender_key:'')===$row->id) selected @endif>{{$row->ind}}</option>
                    @endforeach
                </select>
                <span class="help-block"></span>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label class="control-label">No Telp.
                    :</label> <input type="text" placeholder="Masukkan No Telp."
                                     class="form-control"
                                     value="{{isset($other->personal->phone)?$other->personal->phone:''}}"
                                     name="phone">
                <span class="help-block"></span>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0">
            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label class="control-label">Tempat
                    Lahir
                    :</label> <input type="text" placeholder="Masukkan Tempat Lahir"
                                     class="form-control"
                                     value="{{isset($other->personal->born_place)?$other->personal->born_place:''}}"
                                     name="born_place">
                <span class="help-block"></span>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label class="control-label">Tanggal
                    Lahir
                    :</label> <input type="text" placeholder="Masukkan Tanggal Lahir"
                                     class="form-control datepicker"
                                     name="dob"
                                     value="{{isset($other->personal->dob)?\Carbon\Carbon::parse($other->personal->dob)->format('d/m/Y'):''}}">
                <span class="help-block"></span>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0">
            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label class="control-label">Pendidikan
                    Terakhir
                    :</label> <select class="form-control"
                                      name="last_edu">
                    <option value="" selected disabled>pilih Pendidikan Terakhir</option>
                    @foreach($other->edu as $row)
                        <option value="{{$row->id}}"
                                @if((isset($other->personal->edu)?$other->personal->edu:'')===$row->id) selected @endif>{{$row->ind}}</option>
                    @endforeach

                </select>
                <span class="help-block"></span>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label class="control-label">Profesi
                    :</label> <select class="form-control"
                                      name="profession">
                    <option value="" selected disabled>pilih Status</option>
                    @foreach($other->profesion as $row)
                        <option value="{{$row->id}}"
                                @if((isset($other->personal->profession)?$other->personal->profession:'')===$row->id) selected @endif>{{$row->ind}}</option>
                    @endforeach
                </select>
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label class="control-label">Alamat
                :</label>
            <textarea name="address" id="" cols="10" rows="4" class="form-control"
                      placeholder="jika ada tulis disini">{{isset($other->personal->address)?$other->personal->address:''}}</textarea>
            <span class="help-block"></span>
        </div>
        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <button type="submit" class="btn btn-info">Rubah</button>
        </div>
    </form>
</div>