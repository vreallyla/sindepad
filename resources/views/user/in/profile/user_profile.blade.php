@extends('layouts.user_side')
@section('content')
    <div id="side-profile" class="col-lg-offset-1 col-lg-10 col-md-12 col-sm-12 col-xs-12">
        <ul class="tab-menu col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <li data-target="biodata" class="activo">Biodata</li>
            <li data-target="password">Kata Sandi</li>
            <li data-target="kids">Data Anak</li>
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
                        <label class="control-label">No Daftar : </label>
                        <h5>{{isset($other->personal->ni)?$other->personal->ni:'belum terdaftar'}}</h5>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label class="control-label">Hak Akses : </label>
                        <h5>{{isset($other->personal->status)?$other->personal->status:'belum terdaftar'}}</h5>
                    </div>
                </div>
            </div>
            @include('user.in.profile.editprofile')
            @include('user.in.profile.passwordChange')
            @include('user.in.profile.kidEdit')
        </div>
    </div>
@endsection