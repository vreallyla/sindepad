@extends('layouts.shadow_side')
@section('content')
    <div id="side-profile" class="col-lg-offset-1 col-lg-10 col-md-12 col-sm-12 col-xs-12">
        <ul class="tab-menu col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <li data-target="biodata" class="activo">Biodata</li>
            <li data-target="password">Kata Sandi</li>
        </ul>
        <div class="target-menu col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 left-user-desc">
                <div class="pp-user" data-toggle="tooltip" data-placement="bottom"
                     title="Rubah Photo">
                    <input type="file" name="img" id="upload-img" accept="image/*">
                    <img src="{{$data->url}}" alt="{{$data->name}}">
                </div>
                <div class="desc-user ">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label class="control-label">Nama : </label>
                        <h5>{{isset($other->personal->name)?$other->personal->name:'belum diisi'}}</h5>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label class="control-label">NIP : </label>
                        <h5>{{isset($other->personal->ni)?$other->personal->ni:'belum terdaftar'}}</h5>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label class="control-label">Hak Akses : </label>
                        <h5>{{isset($other->personal->status)?$other->personal->status:'belum terdaftar'}}</h5>
                    </div>
                </div>
            </div>
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
                            <label class="control-label">Status
                                :</label> <select class="form-control"
                                                  name="rel">
                                <option value="" selected disabled>pilih Status</option>
                                @foreach($other->rel as $row)
                                    <option value="{{$row->id}}"
                                            @if((isset($other->personal->rel)?$other->personal->rel:'')===$row->id) selected @endif>{{$row->ind}}</option>
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

            <div id="password" style="display: none" class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <form>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label class="control-label">Kata Sandi Lama
                            :</label> <input type="password" placeholder="Masukkan Kata Sandi Lama"
                                             class="form-control"
                                             name="old_pass">
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label class="control-label">Kata Sandi Baru
                            :</label> <input type="password" placeholder="Masukkan Kata Sandi Baru"
                                             class="form-control"
                                             name="new_pass">
                        <label><input type="checkbox" name="show_pass"> Tampilkan Kata Sandi</label>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button class="btn btn-info">Rubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection