@extends ('layouts.mst_user')
@section('desc','rahasia')
@section('key','anu')
@section('content')
    <!--Breadcrumb start-->
    <div class="ed_pagetitle" data-stellar-background-ratio="0.5" data-stellar-vertical-offset="0"
         style="background-image: url({{$parralax}});">
        <div class="ed_img_overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-4 col-sm-6">
                    <div class="page_title">
                        <h2>Halaman Pendaftaran Siswa Baru</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-8 col-sm-6">
                    <ul class="breadcrumb">
                        <li><a href="index.html">home</a></li>
                        <li><i class="fa fa-chevron-left"></i></li>
                        <li><a href="course.html">Educo Courses</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--Breadcrumb end-->
    <!-- Section eleven start -->
    <div class="ed_courses ed_toppadder80 ed_bottompadder80">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <form id="signup" action="somewhere" method="POST">
                        <ul id="section-tabs">
                            <li class="active"><i class="fa fa-folder-open"></i>
                                <div class="content-step">Keterangan</div>
                            </li>
                            <li><i class="fa fa-user-plus"></i>
                                <div class="content-step">Opsional</div>
                            </li>
                            <li><i class="fa fa-check-circle"></i>
                                <div class="content-step">Konfirmasi</div>
                            </li>
                        </ul>
                        <div id="fieldsets">
                            <fieldset class="animated">
                                @include('user.order.index.aggrement')
                            </fieldset>
                            <fieldset class="next animated">
                                @include('user.order.index.form')
                            </fieldset>
                            <fieldset class="next animated">
                                @include('user.order.index.order_submit')
                            </fieldset>
                        </div>
                        <a class="btn btn-step" id="next">Selanjutnya ▷</a>
                        <input type="submit" class="btn btn-step">
                    </form>
                </div>
            </div>
        </div><!-- /.container -->
    </div>
    <!-- Section eleven end -->
@endsection
@push('style')
    <link href="{{asset('css/new.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/accordion.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/countdown.css')}}" rel="stylesheet" type="text/css"/>

    <style>
        .aggrement-content{
            border: 1px solid #eee;
            overflow: scroll;
            height: 13em;
            padding: 11px 24px;
        }
        .aggrement-box{
            margin:7px 0px;
        }
        .aggrement-box input{
            margin:0 10px;
        }
    </style>

    <style>
        @import url(https://fonts.googleapis.com/css?family=Old+Standard+TT:400,400italic);

        .add-margin-bottom-sm {
            height: 72px;
            margin-bottom: 0.8em;
        }

        .center {
            text-align: center;
        }

        #signup .title-tab {
            color: #3c3d35;
            /*font-size: 200%;*/
            position: relative;
            top: 27px;
            letter-spacing: 0.2em;
            margin: 0;
            text-align: center;
            text-transform: uppercase;
        }

        #signup .title-tab::after {
            background-color: #2cbab2;
            content: "";
            display: block;
            height: 2px;
            margin: 0.75rem auto 2.25rem;
            width: 6rem;
        }

        @media (max-width: 1199px) {
            .add-min {
                top: 18px;
            }
        }

        .select-radio input[type="radio"] {
            display: none;
        }

        .select-radio input[type="radio"]:checked + .zoom {
            border-left: 3px #22918b solid;
        }

        .select-radio input[type="radio"]:hover + .zoom {
            border-left: 3px #22918b solid;
            cursor: pointer;
        }

        .select-radio input[type="radio"][disabled] + .zoom {
            background: #cccccc30;
            color: #3a3a3a4f;
            /*border: #3a3a3a4f 2px solid;*/
            cursor: not-allowed;
        }

        .select-radio .box {
            border: #3a3a3a4f 1px solid;
            border-radius: 4px;
            padding: 3px 12px;
            margin: 3px 6px;
            background: white;
            position: relative;
            cursor: pointer;
        }

        .select-radio .box:hover {
            border: #2cbab2 1px solid;
            color: #2cbab2;
        }
    </style>

    {{--select-picker--}}
    <style>
        form .dropdown-toggle {
            background: #fff;
            border: #3a3a3a4f 1px solid;
            border-radius: 4px;
        }

        form .dropdown-toggle:hover {
            background: #fff;
            outline: none;
            border: 1px solid #22918b;
        }

        form .dropdown-toggle .filter-option-inner-inner {
            color: #2b2b2b;
        }

        form .dropdown-toggle[aria-expanded=true] + .dropdown-toggle {
            background: #fff;
            outline: none;
            border: 1px solid #22918b;
        }

        form .dropdown-menu li:hover {
            background: #22918b;
            color: white;
        }

    </style>

    {{--payment--}}
    <style>
        .payment-detail h5{
            text-align: right;
            font-size: 1.2em;
            margin: 0;
            margin-bottom: 6px;
        }
        .payment-detail span{
            margin-left: 5px;
        }
        .payment-list {
            margin-left: 5px;
        }

        .payment-list label {
            font-weight: unset;
        }

        .payment-list .pull-right {
            font-weight: 600;
        }

        .payment-header {
            border-bottom: 1px #ccc solid;
            margin-bottom: 9px;
        }

        .exc-pay button:hover{
            background: #29848d;
        }
        .exc-pay button{
            background: #3abac6;
            color: #fff;
            padding: 8px 12px;
            font-weight: bold;
        }
        .payment-code {
            background: #2cbab2;
            padding: 4px 7px;
            color: #fff;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .payment-total {
            margin-bottom: 8px;
        }

        .payment-step {
            border-right: 1px #ccc solid;
            min-height: 242px;
        }

        @media (max-width: 1199px) {
            .payment-step {
                border-right: 0px #ccc solid;
                margin-bottom: 16px;
            }
        }

        @media (min-width: 1200px) {
            .hidden-pc {
                display: none;
            }
        }
    </style>

    {{--detail grid--}}
    <style>
        .title-detail {
            display: block;
            font-size: 12px;
        }

        .desc-detail {
            margin: 0 6px;
            font-size: 16px;
            font-weight: unset;
        }
    </style>
@endpush

@push('package')
    <script type="text/javascript" src="{{asset('js/new.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/accordion.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/tweenMax.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/countdown.js')}}"></script>
@endpush

@push('js')
    @include('user.order.index.js.partials')
    @include('user.order.index.js.async')
@endpush
