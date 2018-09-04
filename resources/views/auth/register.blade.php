@extends ('layouts/mst_user')
@section('tittle','Home')
@section('desc','rahasia')
@section('key','anu')

@section('content')

    <!--Breadcrumb start-->
    <div class="ed_pagetitle" data-stellar-background-ratio="0.5" data-stellar-vertical-offset="0"
         style="background-image: url(http://placehold.it/921X533);">
        <div class="ed_img_overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-4 col-sm-6">
                    <div class="page_title">
                        <h2>Pendaftaran Pengguna</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-8 col-sm-6">
                    <ul class="breadcrumb">
                        <li><a href="{{route('welcome')}}">beranda</a></li>
                        <li><i class="fa fa-chevron-left"></i></li>
                        <li><a href="{{route('register')}}">pendaftaran</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--Breadcrumb end-->
    <div class="ed_transprentbg ed_toppadder80 ed_bottompadder80">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-lg-offset-3 col-md-offset-3">
                    <div class="ed_teacher_div">
                        <div class="ed_heading_top">
                            <h3>Halaman Pendaftaran</h3>
                        </div>
                        <form class="ed_contact_form ed_toppadder40" method="POST" action="{{route('register')}}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label class="control-label">Nama Lengkap :</label>
                                <input type="text" class="form-control" name="name">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="control-label">Email :</label>
                                <input type="email" class="form-control" name="email">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="control-label">Kata Sandi :</label>
                                <input type="password" class="form-control" name="password">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="control-label">Jenis Kelamin :</label>
                                <select class="form-control" name="gender">
                                    <option value="" disabled="true" selected></option>
                                    @foreach($default[3] as $row)
                                        <option value="{{$row->id}}">{{$row->ind}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('gender'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="{{env('CAPTCHA_KEY')}}"></div>
                                @if($errors->has('g-recaptcha-response'))
                                    <div class="invalid-feedback" style="display: block">
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>

                                    </div>
                                @endif
                            </div>
                            <button type="submit" class="btn ed_btn ed_orange pull-right">Daftar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
