@extends ('layouts/mst_user')
@section('desc','rahasia')
@section('key','anu')
@section('content')
    <div class="ed_pagetitle" data-stellar-background-ratio="0.5" data-stellar-vertical-offset="0"
         style="background-image: url({{$parralax}});">
        <div class="ed_img_overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-4 col-sm-6">
                    <div class="page_title">
                        <h2>Profil Anda</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-8 col-sm-6">
                    <ul class="breadcrumb">
                        <li><a href="{{route('welcome')}}">beranda</a></li>
                        <li><i class="fa fa-chevron-left"></i></li>
                        <li><a href="#">Profil</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--Breadcrumb end-->
    <!--single student detail start-->
    <div class="ed_dashboard_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="ed_sidebar_wrapper">
                        <form method="post" class="personal-data" enctype="multipart/form-data">
                            <div class="ed_profile_img image-upload">
                                <label for="file-input">
                                    <img src="{{$user_cookie->url}}" alt="Dashboard Image" data-placement="bottom"
                                         data-toggle="tooltip" class="zoom"
                                         title="klik disini untuk ganti gambar"/>
                                </label>
                                {{ csrf_field() }}
                                {{ method_field('post') }}
                                <input id="file-input" name="ava" type="file" accept="image/*">
                            </div>
                        </form>
                        <h3>{{$more->name}}</h3>
                        <div class="ed_tabs_left">
                            <ul class="nav nav-tabs">
                                <li class="zoom-card active"><a href="#personal-data" data-toggle="tab">Data Personal</a></li>
                                <li class="zoom-card"><a href="#courses" data-toggle="tab">Data Anak<span>4</span></a></li>
                                <li class="zoom-card"><a href="#activity" data-toggle="tab">Pemberitahuan <span>0</span></a></li>
                                <li class="zoom-card"><a href="#setting" data-toggle="tab">Blog</a></li>
                                <li class="zoom-card"><a href="#forums" data-toggle="tab">Pengaturan</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                    <div class="ed_dashboard_tab">
                        <div class="tab-content">
                            <div class="tab-pane active" id="personal-data">
                                <div class="ed_dashboard_inner_tab">
                                    <div role="tabpanel">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#view" aria-controls="view"
                                                                                      role="tab" data-toggle="tab">Profil
                                                    Personal</a></li>
                                            <li role="presentation">
                                                <a href="#password-change" aria-controls="result" role="tab"
                                                   data-toggle="tab" aria-expanded="true">
                                                    Kata Sandi
                                                </a>
                                            </li>
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="view">
                                                <div class="ed_inner_dashboard_info personal-data">
                                                    <h2 style="margin-bottom: 0px">
                                                        <i class="fa fa-user-secret"></i>
                                                        Rincian Data <span class="pull-right zoom personal-change"
                                                                           data-placement="left"
                                                                           data-toggle="tooltip"
                                                                           id="edit_personal"
                                                                           title="klik disini untuk merubah profil"
                                                                           style="cursor: pointer">
                                                            <i class="fa fa-edit"></i>
                                                            </span>
                                                        <span class="pull-right zoom"
                                                              data-placement="left"
                                                              data-toggle="tooltip"
                                                              id="save_personal"
                                                              title="klik disini untuk menyimpan data"
                                                              style="cursor: pointer ; display: none;color: #746b6b">
                                                            <i class="fa fa-save"></i>
                                                        </span>
                                                    </h2>
                                                    <hr class="hr-divider" style="margin-bottom: 20px; margin-top: 8px">

                                                    <div class="row">
                                                        <div id="personal-content">
                                                            <div class="col-lg-5">
                                                                <table style="font-size: 14px; margin-top: 0"
                                                                       id="stats">
                                                                    <tr>
                                                                        <td>Name</td>
                                                                        <td>:</td>
                                                                        <td class="aj_name">{{isset($more->name) ? $more->name : 'Data belum diisi'}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>TTL</td>
                                                                        <td>:</td>
                                                                        <td class="aj_ttl">{{isset($more->born_place) && isset($more->dob) ?
                                                                        $more->born_place.', '.\Illuminate\Support\Carbon::createFromFormat('Y-m-d', $more->dob)->formatLocalized('%d %B %Y'):'Data belum diisi'}}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Jenis Kelamin</td>
                                                                        <td>:</td>
                                                                        <td class="aj_sex">{{isset($more->gender_id) ?\App\Model\sideGender::findOrFail($more->gender_id)->ind: 'Data belum diisi'}}</td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div class="col-lg-7">
                                                                <table style="font-size: 14px; margin-top: 0"
                                                                       id="stats">
                                                                    <tr>
                                                                        <td>Email</td>
                                                                        <td>:</td>
                                                                        <td class="aj_email">{{isset($more->email)?$more->email: 'Data belum diisi'}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>No Telp</td>
                                                                        <td>:</td>
                                                                        <td class="aj_phone">{{isset($more->phone)?$more->phone: 'Data belum diisi'}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td valign="top">Alamat</td>
                                                                        <td>:</td>
                                                                        <td class="aj_address">{{isset($more->address)?$more->address: 'Data belum diisi'}}</td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div id="form-personal-change" style="display: none">
                                                            <form>
                                                                <div class="col-lg-6">
                                                                    <small>Nama</small>
                                                                    <div class="row form-group has-feedback">
                                                                        <div class="col-md-12">
                                                                            {{csrf_field()}}
                                                                            {{ method_field('post') }}
                                                                            <input type="text" class="form-control"
                                                                                   name="name"
                                                                                   placeholder="Masukkan Nama Lengkap"
                                                                                   value="{{isset($more->name) ? $more->name : ''}}">
                                                                            <span class="help-block"
                                                                                  style="display: none">
                                                                                <strong></strong>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <small>Tempat Lahir</small>
                                                                    <div class="row form-group has-feedback">
                                                                        <div class="col-md-12">
                                                                            <input type="text" class="form-control"
                                                                                   name="born_place"
                                                                                   placeholder=" Masukkan Tempat Lahir"
                                                                                   value="{{isset($more->born_place) ? $more->born_place : ''}}">
                                                                            <span class="help-block"
                                                                                  style="display: none">
                                                                                <strong></strong>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <small>Tanggal Lahir</small>
                                                                    <div class="row form-group has-feedback">
                                                                        <div class="col-md-12">
                                                                            <input type="text" name="date_birth"
                                                                                   class="form-control datepicker"
                                                                                   value="{{isset($more->dob) ? $more->dob : ''}}">
                                                                            <span class="help-block"
                                                                                  style="display: none">
                                                                                <strong></strong>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <small>Jenis Kelamin</small>
                                                                    <div class="row form-group has-feedback">
                                                                        <div class="col-md-12">
                                                                            <select name="sex" id="sex"
                                                                                    class="form-control modify-input">
                                                                                <option value="" selected="selected"
                                                                                        disabled="disabled">------ pilih
                                                                                    jenis
                                                                                    kelamin ------
                                                                                </option>
                                                                                @foreach($jk as $row)
                                                                                    <option value="{{$row->id}}" {{isset($more->gender_id) && $more->gender_id==$row->id ? 'selected=true':''}}>{{$row->ind}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            <span class="help-block"
                                                                                  style="display: none">
                                                                                <strong></strong>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <small>Email</small>
                                                                    <div class="row form-group has-feedback">
                                                                        <div class="col-md-12">
                                                                            <input type="text" class="form-control"
                                                                                   name="email"
                                                                                   placeholder="Masukkan Email"
                                                                                   value="{{isset($more->email) ? $more->email : ''}}"
                                                                                   readonly="true" data-placement="top"
                                                                                   data-toggle="tooltip"
                                                                                   title="email tidak dapat dirubah"
                                                                                   style="cursor: not-allowed">
                                                                            <span class="help-block"
                                                                                  style="display: none">
                                                                                <strong></strong>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <small>No Telp</small>
                                                                    <div class="row form-group has-feedback">
                                                                        <div class="col-md-12">
                                                                            <input type="number" class="form-control"
                                                                                   name="phone"
                                                                                   placeholder="Masukkan No Telp"
                                                                                   value="{{isset($more->phone) ? $more->phone : ''}}">
                                                                            <span class="help-block"
                                                                                  style="display: none">
                                                                                <strong></strong>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <small>Alamat</small>
                                                                    <div class="row form-group has-feedback">
                                                                        <div class="col-md-12">
                                                                        <textarea name="address"
                                                                                  placeholder="Jika ada tambahan tulis disini."
                                                                                  style="    height: 117px;"
                                                                                  class="form-control modify-input">{{isset($more->address) ? $more->address : ''}}</textarea>
                                                                            <span class="help-block"
                                                                                  style="display: none">
                                                                                <strong></strong>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="password-change">
                                                <div class="ed_dashboard_inner_tab">
                                                    <h2 style="margin-bottom: 0px">
                                                        <i class="fa fa-lock"></i>
                                                        Rubah Kata Sandi
                                                        <span class="pull-right zoom"
                                                              data-placement="left"
                                                              data-toggle="tooltip"
                                                              id="save_password"
                                                              title="klik disini untuk menyimpan data"
                                                              style="cursor: pointer;color: #746b6b">
                                                            <i class="fa fa-save"></i>
                                                        </span>
                                                    </h2>
                                                    <hr class="hr-divider" style="margin-bottom: 20px; margin-top: 8px">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <form>
                                                                {{csrf_field()}}
                                                                {{ method_field('post') }}
                                                                <small>Kata Sandi Lama</small>
                                                                <div class="row form-group has-feedback">
                                                                    <div class="col-md-12">
                                                                        <input type="password" class="form-control"
                                                                               name="old_password"
                                                                               placeholder="Masukkan Kata Sandi Lama">
                                                                        <span class="help-block" style="display: none">
                                                                                <strong></strong>
                                                                            </span>
                                                                    </div>
                                                                </div>
                                                                <small>Kata Sandi Baru</small>
                                                                <div class="row form-group has-feedback">
                                                                    <div class="col-md-12">
                                                                        <input type="password" class="form-control"
                                                                               name="new_password"
                                                                               placeholder="Masukkan Kata Sandi Lama">
                                                                        <input type="checkbox" name="check_password">Tampilkan
                                                                        Kata Sandi Baru
                                                                        <span class="help-block" style="display: none">
                                                                                <strong></strong>
                                                                            </span>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--tab End-->
                                </div>
                            </div>
                            <div class="tab-pane" id="courses">
                                <div class="ed_dashboard_inner_tab">
                                    <div role="tabpanel">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="active">
                                                <a href="#my" aria-controls="my" role="tab" data-toggle="tab">
                                                    Data Anak
                                                </a>
                                            </li>
                                            <li role="presentation"><a href="#result" aria-controls="result" role="tab"
                                                                       data-toggle="tab">Profil Anak</a></li>
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="my">
                                                <div class="ed_inner_dashboard_info">
                                                    @if(!$kids)
                                                    <div id="child-not-found">
                                                        <h2>Untuk sekarang belum ada data pendaftaran</h2>
                                                    </div>
                                                    @else
                                                    <div id="child-found">
                                                        <h2 style="margin-bottom: 0px">
                                                            <i class="fa fa-users"></i>
                                                            Rincian Data
                                                            </span>
                                                        </h2>
                                                        <hr class="hr-divider" style="margin-bottom: 20px; margin-top: 8px">
                                                        <div class="row">
                                                            @foreach($kids as $row)
                                                            <div class="col-lg-6 add-col-margin zoom-card">
                                                                <div class="bs-callout bs-callout-info">
                                                                    <div class="row">
                                                                        <div class="col-lg-5 text-center">
                                                                            <img src="{{asset('images/img_unvailable.png')}}"
                                                                                 alt="">
                                                                        </div>
                                                                        <div class="col-lg-6 text-center-tablet">
                                                                            <h4 class="remove-margin-bottom">{{$row->name}}</h4>
                                                                            <small>Program {{\App\Model\mstClass::findOrFail($row->class_id)->name}}</small>
                                                                            <div class="row">
                                                                                <div class="col-lg-12">
                                                                                    <div class="progress progress-main">
                                                                                        <div class="bar"
                                                                                             style="width:57%;background-position:0 57%"></div>
                                                                                    </div>
                                                                                    <span class="detail-bar">97%</span>
                                                                                </div>
                                                                                <div class="col-lg-12 text-center">
                                                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 profile-child user-footer-card"
                                                                                         style="border-right: 1px solid #eee" data-placement="top" data-toggle="tooltip"
                                                                                    title="klik untuk melihat profil anak">
                                                                                        <i class="fa fa-user"></i>
                                                                                    </div>
                                                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 chart-child user-footer-card"
                                                                                         data-placement="top" data-toggle="tooltip"
                                                                                         title="klik untuk melihat perkembangan anak">
                                                                                        <i class="fa fa-bar-chart"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                                @endforeach


                                                        </div>
                                                    </div>
                                                        @endif

                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="result">
                                                <div class="ed_dashboard_inner_tab">
                                                    <h2 style="margin-bottom: 0px">
                                                        <i class="fa fa-child"></i>
                                                        Rincian Profil <span class="pull-right zoom profile-change" data-placement="left" data-toggle="tooltip" id="edit_personal" title="" style="cursor: pointer" data-original-title="klik disini untuk merubah profil">
                                                            <i class="fa fa-edit"></i>
                                                            </span>
                                                        <span class="pull-right zoom" data-placement="left" data-toggle="tooltip" id="save_personal" title="" style="cursor: pointer ; display: none;color: #746b6b" data-original-title="klik disini untuk menyimpan data">
                                                            <i class="fa fa-save"></i>
                                                        </span>
                                                    </h2>
                                                    <hr class="hr-divider" style="margin-bottom: 20px; margin-top: 8px">
                                                    <p>Nam id ligula tristique, porta dolor ac, pretium leo. Maecenas
                                                        scelerisque vulputate dapibus. Quisque sodales tincidunt sapien,
                                                        eu consequat erat tempus et. Nullam ipsum est, interdum quis
                                                        posuere sed, imperdiet quis nisi. Proin quis justo est.
                                                        Vestibulum imperdiet leo sit amet tortor suscipit, id cursus
                                                        ligula pharetra. Uctus ac eros a, faucibus iaculis quam. Nam non
                                                        iaculis justo. Donec maximus varius velit.</p>
                                                </div>
                                            </div>
                                        </div>

                                    </div><!--tab End-->
                                </div>
                            </div>
                            <div class="tab-pane" id="activity">
                                <div class="ed_dashboard_inner_tab">
                                    <div role="tabpanel">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#personal"
                                                                                      aria-controls="personal"
                                                                                      role="tab" data-toggle="tab">personal</a>
                                            </li>
                                            <li role="presentation"><a href="#mentions" aria-controls="mentions"
                                                                       role="tab" data-toggle="tab">mentions</a></li>
                                            <li role="presentation"><a href="#favourites" aria-controls="favourites"
                                                                       role="tab" data-toggle="tab">favourites</a></li>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="personal">
                                                <div class="ed_dashboard_inner_tab">
                                                    <h2>What's new, andrehouse@123 ?</h2>
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <form class="ed_tabpersonal">
                                                                <div class="form-group">
                                                                    <textarea name="whats_new" class="form-control"
                                                                              id="whats_new" cols="50"
                                                                              rows="5"></textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <button class="btn ed_btn ed_green">post update
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="mentions">
                                                <div class="ed_dashboard_inner_tab">
                                                    <h2>sorry, there was no mentions event found. please try a different
                                                        filter</h2>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="favourites">
                                                <div class="ed_dashboard_inner_tab">
                                                    <h2>sorry, there was no favourites event found. please try a
                                                        different filter</h2>
                                                </div>
                                            </div>
                                        </div>

                                    </div><!--tab End-->
                                </div>
                            </div>
                            <div class="tab-pane" id="notification">
                                <div class="ed_dashboard_inner_tab">
                                    <div role="tabpanel">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#unread"
                                                                                      aria-controls="unread" role="tab"
                                                                                      data-toggle="tab">unread</a></li>
                                            <li role="presentation"><a href="#read" aria-controls="read" role="tab"
                                                                       data-toggle="tab">read</a></li>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="unread">
                                                <div class="ed_dashboard_inner_tab">
                                                    <h2>you have no unread notifications</h2>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="read">
                                                <div class="ed_dashboard_inner_tab">
                                                    <h2>you have no notifications</h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--tab End-->
                                </div>
                            </div>
                            <div class="tab-pane" id="profile">
                                <div class="ed_dashboard_inner_tab">
                                    <div role="tabpanel">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#view" aria-controls="view"
                                                                                      role="tab"
                                                                                      data-toggle="tab">view</a></li>
                                            <li role="presentation"><a href="#edit" aria-controls="edit" role="tab"
                                                                       data-toggle="tab">edit</a></li>
                                            <li role="presentation"><a href="#change" aria-controls="change" role="tab"
                                                                       data-toggle="tab">change profile photo</a></li>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="view">
                                                <div class="ed_dashboard_inner_tab">
                                                    <h2>your profile</h2>
                                                    <table id="profile_view_settings">
                                                        <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Id</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>
                                                        <tr>
                                                            <td>Andre House</td>
                                                            <td><a href="#">andrehouse@123</a></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="edit">
                                                <div class="ed_dashboard_inner_tab">
                                                    <h2>edit profile</h2>
                                                    <form class="ed_tabpersonal">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control"
                                                                   placeholder="Your Name">
                                                        </div>
                                                        <div class="form-group">
                                                            <p>This field can be seen by: <strong>Everyone</strong></p>
                                                        </div>
                                                        <div class="form-group">
                                                            <button class="btn ed_btn ed_green">save changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="change">
                                                <div class="ed_dashboard_inner_tab">
                                                    <h2>change photo</h2>
                                                    <form class="ed_tabpersonal">
                                                        <div class="form-group">
                                                            <p>Click below to select a JPG, GIF or PNG format photo from
                                                                your computer and then click 'Upload Image' to
                                                                proceed.</p>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="file" name="photo" accept="image/*">
                                                        </div>
                                                        <div class="form-group">
                                                            <button class="btn ed_btn ed_green">upload image</button>
                                                        </div>
                                                        <div class="form-group">
                                                            <p>If you'd like to delete your current avatar but not
                                                                upload a new one, please use the delete avatar
                                                                button.</p>
                                                        </div>
                                                        <div class="form-group">
                                                            <button class="btn ed_btn ed_orange">delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--tab End-->
                                </div>
                            </div>
                            <div class="tab-pane" id="setting">
                                <div class="ed_dashboard_inner_tab">
                                    <div role="tabpanel">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#general"
                                                                                      aria-controls="general" role="tab"
                                                                                      data-toggle="tab">general</a></li>
                                            <li role="presentation"><a href="#email" aria-controls="email" role="tab"
                                                                       data-toggle="tab">email</a></li>
                                            <li role="presentation"><a href="#visibility" aria-controls="visibility"
                                                                       role="tab" data-toggle="tab">profile
                                                    visibility</a></li>
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="general">
                                                <div class="ed_dashboard_inner_tab">
                                                    <h2>general setting</h2>
                                                    <form class="ed_tabpersonal">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control"
                                                                   placeholder="Your Account Email">
                                                        </div>
                                                        <div class="form-group">
                                                            <p>Change Password <strong>(leave blank for no
                                                                    change)</strong></p>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="password" class="form-control"
                                                                   placeholder="New Password">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="password" class="form-control"
                                                                   placeholder="Repeat New Password">
                                                        </div>
                                                        <div class="form-group">
                                                            <button class="btn ed_btn ed_green">save changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="email">
                                                <div class="ed_dashboard_inner_tab">
                                                    <h2>email notification</h2>
                                                    <span>Send an email notice when:</span>
                                                    <table id="notification_settings">
                                                        <thead>
                                                        <tr>
                                                            <th class="title">Activity</th>
                                                            <th class="yes">Yes</th>
                                                            <th class="no">No</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>
                                                        <tr>
                                                            <td>A member mentions you in an update using
                                                                "@andrehouse123"
                                                            </td>
                                                            <td class="yes"><input type="radio" name="activity1"
                                                                                   value="yes" checked="checked"></td>
                                                            <td class="no"><input type="radio" name="activity1"
                                                                                  value="no"></td>
                                                        </tr>

                                                        <tr>
                                                            <td>A member replies to an update or comment you've posted
                                                            </td>
                                                            <td><input type="radio" name="activity2" value="yes"
                                                                       checked="checked"></td>
                                                            <td><input type="radio" name="activity2" value="no"></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <button class="btn ed_btn ed_green">save changes</button>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="visibility">
                                                <div class="ed_dashboard_inner_tab">
                                                    <h2>profile visibility</h2>
                                                    <table id="visibility_settings">
                                                        <thead>
                                                        <tr>
                                                            <th class="title">Name</th>
                                                            <th class="yes">Visibility</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>
                                                        <tr>
                                                            <td>Andre House</td>
                                                            <td>Everyone</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <button class="btn ed_btn ed_green">save setting</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div><!--tab End-->
                                </div>
                            </div>
                            <div class="tab-pane" id="forums">
                                <div class="ed_dashboard_inner_tab">
                                    <div role="tabpanel">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#started"
                                                                                      aria-controls="started" role="tab"
                                                                                      data-toggle="tab">topics
                                                    started</a></li>
                                            <li role="presentation"><a href="#replies" aria-controls="replies"
                                                                       role="tab" data-toggle="tab">replies created</a>
                                            </li>
                                            <li role="presentation"><a href="#favourite" aria-controls="favourite"
                                                                       role="tab" data-toggle="tab">favourite</a></li>
                                            <li role="presentation"><a href="#subscribed" aria-controls="subscribed"
                                                                       role="tab" data-toggle="tab">subscribed</a></li>
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="started">
                                                <div class="ed_dashboard_inner_tab">
                                                    <h2>forum topics started</h2>
                                                    <span>You have not created any topics.</span>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="replies">
                                                <div class="ed_dashboard_inner_tab">
                                                    <h2>forum replies created</h2>
                                                    <span>You have not replied to any topics.</span>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="favourite">
                                                <div class="ed_dashboard_inner_tab">
                                                    <h2>favorite forum topics</h2>
                                                    <span>You currently have no favourite topics.</span>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="subscribed">
                                                <div class="ed_dashboard_inner_tab">
                                                    <h2>subscribed forums</h2>
                                                    <span>You are not currently subscribed to any forums.</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div><!--tab End-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <!--single student detail end-->
@endsection

@push('js')
    @include('user.profile.js.movement_partials')
    @include('user.profile.js.personal')
@endpush

@push('style')
    <style>
        .bs-callout + .bs-callout {
            margin-top: -5px;
        }

        .bs-callout-info {
            border-left-color: #1b809e;
        }

        .bs-callout {
            padding: 8px 15px;
            border: 1px solid #eee;
            border-left-width: 5px;
            border-radius: 3px;
        }

        .add-col-margin {
            margin-bottom: 2.2%;
        }

        .remove-margin-bottom {
            margin-bottom: 0px;
        }

        @media (max-width: 1199px) {
            .text-center-tablet {
                text-align: center;
            }
        }
    </style>
    {{--progress bar--}}
    <style>
        .progress {
            height: 10px;
            box-sizing: border-box;
        }

        .progress .bar {
            box-sizing: border-box;
            background-image: -moz-linear-gradient(90deg, #53d769 0%, #fcff00 50%, #fc3d39 100%);
            background-image: -webkit-linear-gradient(90deg, #53d769 0%, #fcff00 50%, #fc3d39 100%);
            background-image: -ms-linear-gradient(90deg, #53d769 0%, #fcff00 50%, #fc3d39 100%);
            background-size: 1px 2000px;
            background-position: top left;
            background-repeat: repeat-x;
            transition: all 0.5s ease-in-out;
        }

        .progress-main {
            margin-bottom: 20px;
            background: #eee;
            box-shadow: rgba(0, 0, 0, 0.15) 0 2px 3px -1px;
        }

        .progress-main .bar {
            height: 10px;
        }

        .progress-small {
            background: #eee;
            display: inline-block;
            width: 100px;
        }

        .detail-bar {
            position: absolute;
            right: -17px;
            top: -4px
        }

        .user-footer-card {
            cursor: pointer;
            color: #746b6b;
            font-size: 16px;
        }

        .user-footer-card:hover {
            color: #3ABAC6
        }

        .zoom-card {
            transition: transform .3s;
        }

        .zoom-card:hover {
            -ms-transform: scale(1.05);
            -webkit-transform: scale(1.05);
            transform: scale(1.05);
        }

        @media (max-width: 1199px) {
            .detail-bar {
                position: absolute;
                right: 7px;
                top: -4px
            }

            .progress-main {
                width: 96%;
            }

            .user-footer-card {
                margin: 18px 0px 11px 0px;
            }

            .profile-child:after {
                content: ' Profil';
            }

            .chart-child:after {
                content: ' Perkembangan';
            }
        }

    </style>
@endpush
