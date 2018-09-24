@extends ('layouts/mst_user')
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
                            <li class="current active"><i class="fa fa-user-plus"></i>
                                <div class="content-step">Data Pendaftar</div>
                            </li>
                            <li><i class="fa fa-tasks"></i>
                                <div class="content-step">Opsional</div>
                            </li>
                            <li><i class="fa fa-credit-card"></i>
                                <div class="content-step">Pembayaran</div>
                            </li>
                            <li><i class="fa fa-clock-o"></i>
                                <div class="content-step">Proses</div>
                            </li>
                        </ul>
                        <div id="fieldsets">
                            <fieldset class="current animated">
                                <div class="row">
                                    <div class="col-lg-12 order-adding">
                                        <div class="row pull-right">
                                            <div class="col-lg-12"><label
                                                        style="font-size: 17px;color: #7f7f7f;font-weight: normal">
                                                    Pendaftar(<span class="entity-order">1</span>) :</label>
                                                <button type="button" class="btn min-order"
                                                        style="height:34px; background: #dddddd;color: #535353"><i
                                                            class="fa fa-minus"></i></button>
                                                <button type="button" class="btn add-order" style="height:34px;">
                                                    <i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="accordion" id="step1">
                                            <dl>
                                                <dt>
                                                    <a href="#accordion1" aria-expanded="false"
                                                       aria-controls="accordion1"
                                                       class="accordion-title accordionTitle js-accordionTrigger">
                                                        <span class="content-accord">Pendaftar #1</span>
                                                        <span class="pull-right remove-accordion" data-toggle="tooltip"
                                                              data-placement="right" title="Tutup"
                                                              style="display: none">
                                                        <i class="fa fa-times"></i>
                                                    </span>
                                                    </a>
                                                </dt>
                                                <dd class="accordion-content accordionItem is-collapsed" id="accordion1"
                                                    aria-hidden="true">
                                                    <div class="row">
                                                        <div class="col-lg-6 add-margin-bottom-sm">
                                                            <label for="name">Nama :</label>
                                                            <input type="text" name="name[]"
                                                                   placeholder="Nama siswa yang mendaftar"
                                                                   class="form-control modify-input change-tittle"
                                                                   @if(session('order')&&array_key_exists('name',session('order')[0]))value="{{session('order')[0]['name']}}"
                                                                   @endif
                                                                   data-index="0">
                                                        </div>
                                                        <div class="col-lg-6 add-margin-bottom-sm">
                                                            <label for="sex">Jenis Kelamin :</label>
                                                            <select name="sex[]" id="sex"
                                                                    class="form-control modify-input">
                                                                <option value="" selected disabled>------ pilih jenis
                                                                    kelamin ------
                                                                </option>
                                                                @foreach($gender as $row)
                                                                    <option value="{{$row->id}}"
                                                                            @if(session('order')&&array_key_exists('sex',session('order')[0])&&session('order')[0]['sex']==$row->id)selected @endif>{{$row->ind}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6 add-margin-bottom-sm">
                                                            <label for="relligion">Agama :</label>
                                                            <select name="relligion[]" id="" class="form-control">
                                                                <option value="" disabled selected>-------- pilih agama
                                                                    --------
                                                                </option>
                                                                @foreach($religion as $row)
                                                                    <option value="{{$row}}"
                                                                            @if(session('order')&&array_key_exists('relligion',session('order')[0])&&session('order')[0]['relligion']==$row)selected @endif>{{$row}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6 add-margin-bottom-sm">
                                                            <label for="course">Program :</label>
                                                            <select name="course[]" id="" class="form-control">
                                                                <option value="" disabled>--- pilih ---</option>
                                                                @foreach($default[1] as $row)
                                                                    <option value="{{$row->id}}"
                                                                            @if(session('order')&&array_key_exists('course',session('order')[0])&&session('order')[0]['course']==$row->id)selected @endif>{{$row->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6 add-margin-bottom-sm">
                                                            <label for="rs">Hubungan dengan Anak :</label>
                                                            <select name="rs[]" id="" class="form-control">
                                                                <option value="" disabled selected>------ pilih hubungan
                                                                    ------
                                                                </option>
                                                                @foreach($rs['id'] as $row)
                                                                    <option value="{{$row}}">{{$row}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6 add-margin-bottom-sm">
                                                            <label for="needed">Kebutuhan :</label>
                                                            <select name="needed[]" id=""
                                                                    class="form-control selectpicker"
                                                                    data-container=".ed_courses" multiple>
                                                                <option value="" disabled>--- pilih kebutuhan ---
                                                                </option>
                                                                @foreach($dis as $row)
                                                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <label for="desc">Catatan :</label>
                                                            <textarea name="desc[]"
                                                                      placeholder="Jika ada tambahan tulis disini."
                                                                      class="form-control modify-input"></textarea>
                                                        </div>
                                                    </div>
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="next animated">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="accordion" id="step2">
                                            <dl>
                                                <dt>
                                                    <a href="#accordion1" aria-expanded="false"
                                                       aria-controls="accordion1"
                                                       class="accordion-title accordionTitle js-accordionTrigger">
                                                        <span class="content-accord">Pendaftar #1</span>
                                                        <span class="pull-right remove-accordion" data-toggle="tooltip"
                                                              data-placement="right" title="Tutup"
                                                              style="display: none">
                                                        <i class="fa fa-times"></i>
                                                    </span>
                                                    </a>
                                                </dt>
                                                <dd class="accordion-content accordionItem is-collapsed" id="accordion1"
                                                    aria-hidden="true">
                                                    <div class="row select-radio">
                                                        <div class="col-lg-2">
                                                            <label for="" day>Pilih Hari :</label>
                                                        </div>
                                                        <div class="col-lg-10">
                                                            @foreach($day as $r)
                                                                <label>
                                                                    <input type="radio" name="day" value="{{$r->id}}"
                                                                           disabled/>
                                                                    <div class="back-end box zoom">
                                                                        <span>{{$r->ind}}</span>
                                                                    </div>
                                                                </label>
                                                            @endforeach

                                                        </div>
                                                    </div>
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="next animated">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row" id="step3">
                                            <div class="col-lg-6 payment-step">
                                                <div class="payment-header">
                                                    <div class="payment-code">
                                                        Detail Pembayaran
                                                    </div>
                                                    <div class="payment-content">
                                                        <div class="payment-title">
                                                            <strong style="font-size:17px;">Pendaftar #1</strong>
                                                            <span class="pull-right"
                                                                  style="margin: 1px 0">Dummy af</span>
                                                        </div>
                                                        <div class="payment-detail">
                                                            <div class="payment-list">
                                                                <label>Biaya Pendaftaran</label>
                                                                <span class="pull-right">Rp 70.000,00</span>
                                                            </div>
                                                            <div class="payment-list">
                                                                <label>Kelas Menari</label>
                                                                <span class="pull-right">Rp 280.000,00</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="payment-content">
                                                        <div class="payment-title">
                                                            <strong style="font-size:17px;">Pendaftar #1</strong>
                                                            <span class="pull-right"
                                                                  style="margin: 1px 0">Dummy af</span>
                                                        </div>
                                                        <div class="payment-detail">
                                                            <div class="payment-list">
                                                                <label>Biaya Pendaftaran</label>
                                                                <span class="pull-right">Rp 70.000,00</span>
                                                            </div>
                                                            <div class="payment-list">
                                                                <label>Kelas Menari</label>
                                                                <span class="pull-right">Rp 280.000,00</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="payment-content">
                                                        <div class="payment-title">
                                                            <strong style="font-size:17px;">Pendaftar #1</strong>
                                                            <span class="pull-right"
                                                                  style="margin: 1px 0">Dummy af</span>
                                                        </div>
                                                        <div class="payment-detail">
                                                            <div class="payment-list">
                                                                <label>Biaya Pendaftaran</label>
                                                                <span class="pull-right">Rp 70.000,00</span>
                                                            </div>
                                                            <div class="payment-list">
                                                                <label>Kelas Menari</label>
                                                                <span class="pull-right">Rp 280.000,00</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="payment-total">
                                                    <label>Total</label>
                                                    <span class="pull-right" style="color: #22918b;font-weight: 600">Rp 9.000.000,00
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="payment-code hidden-pc">
                                                    Informasi Pembayaran
                                                </div>
                                                <div class="form-group">
                                                    <label for="code">Kode Diskon:</label>
                                                    <input type="text" class="form-control" id="code"
                                                           name="code" placeholder="*Tulis disini jika ada">
                                                </div>
                                                <div class="form-group">
                                                    <label for="code">A/N:</label>
                                                    <input type="text" class="form-control" id="code"
                                                           name="code"
                                                           placeholder="*Tulis nama pelaku transaksi">
                                                </div>
                                                <div class="form-group">
                                                    <label for="code">Metode Pembayaran:</label><br>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="optionsRadios"
                                                                   id="optionsRadios1" value="option1" checked>
                                                            Transfer
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="optionsRadios"
                                                                   id="optionsRadios2" value="option2">
                                                            Bayar ditempat
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="next animated">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row" id="step4">
                                            <div class="col-lg-6 payment-step">
                                                <div class="payment-header">
                                                    <div class="payment-code">
                                                        Detail Pembayaran
                                                    </div>
                                                    <div class="payment-content">
                                                        <div class="payment-title">
                                                            <strong style="font-size:17px;">Pendaftar #1</strong>
                                                            <span class="pull-right"
                                                                  style="margin: 1px 0">Dummy af</span>
                                                        </div>
                                                        <div class="payment-detail">
                                                            <div class="payment-list">
                                                                <label>Biaya Pendaftaran</label>
                                                                <span class="pull-right">Rp 70.000,00</span>
                                                            </div>
                                                            <div class="payment-list">
                                                                <label>Kelas Menari</label>
                                                                <span class="pull-right">Rp 280.000,00</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="payment-content">
                                                        <div class="payment-title">
                                                            <strong style="font-size:17px;">Pendaftar #1</strong>
                                                            <span class="pull-right"
                                                                  style="margin: 1px 0">Dummy af</span>
                                                        </div>
                                                        <div class="payment-detail">
                                                            <div class="payment-list">
                                                                <label>Biaya Pendaftaran</label>
                                                                <span class="pull-right">Rp 70.000,00</span>
                                                            </div>
                                                            <div class="payment-list">
                                                                <label>Kelas Menari</label>
                                                                <span class="pull-right">Rp 280.000,00</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="payment-content">
                                                        <div class="payment-title">
                                                            <strong style="font-size:17px;">Pendaftar #1</strong>
                                                            <span class="pull-right"
                                                                  style="margin: 1px 0">Dummy af</span>
                                                        </div>
                                                        <div class="payment-detail">
                                                            <div class="payment-list">
                                                                <label>Biaya Pendaftaran</label>
                                                                <span class="pull-right">Rp 70.000,00</span>
                                                            </div>
                                                            <div class="payment-list">
                                                                <label>Kelas Menari</label>
                                                                <span class="pull-right">Rp 280.000,00</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="payment-total">
                                                    <label>Total</label>
                                                    <span class="pull-right" style="color: #22918b;font-weight: 600">Rp 9.000.000,00
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="title-detail">Potongan Harga :</label>
                                                    <strong class="desc-detail">70%</strong>
                                                </div>
                                                <div class="form-group">
                                                    <label class="title-detail">A/N :</label>
                                                    <strong class="desc-detail">dummy af</strong>
                                                </div>
                                                <div class="form-group">
                                                    <label class="title-detail">Metode Pembayaran :</label>
                                                    <strong class="desc-detail">Tranfer</strong>
                                                </div>
                                                <div class="form-group">
                                                    <label class="title-detail">Batas Waktu :</label>
                                                    <strong class="desc-detail">Senin, 27 Sep 2017 14.00 WIB (sisa waktu:12:00:00)</strong>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <a class="btn btn-step" id="next">Next Section ▷</a>
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
        .select-radio input[type="radio"] {
            display: none;
        }

        .select-radio input[type="radio"]:checked + .box {
            background: #2cbab2;
            border: none;
            color: #fff;
        }

        .select-radio input[type="radio"][disabled] + .box {
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

        @media (min-width:1200px){
            .hidden-pc{
                display: none;
            }
        }
    </style>

    {{--detail grid--}}
    <style>
        .title-detail{
            display: block;
            font-size: 12px;
        }
        .desc-detail{
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
    <script>
        $(function ($) {
            var $titleIndex = ['Pendaftar #1'];
            var $titleContent = ['kosong'];

            $(window).on('load', function () {
                $('.accordion-title')[0].click();

                $('body,html').animate({
                    scrollTop: $('#signup').offset().top - 80
                }, 1000);

            });

            $('.add-order').on('click', function () {
                changeEntity(parseInt($('.entity-order').html()) + 1);
            });

            $('.min-order').on('click', function () {
                changeEntity(parseInt($('.entity-order').html()) - 1);
            });

            function changeEntity(i) {
                tittleAccord = $('dt').clone();
                contentAccord = $('dd').clone();
                awalan = $('#step1');
                valEntity = parseInt($('.entity-order').text());

                if (1 <= i && valEntity < i && valEntity < 3) {
                    textAccord = 'Pendaftar #' + i;
                    $('.entity-order').text(i).hide().fadeIn('slow');

                    awalan.find('dl').append('<dt>\n' +
                        tittleAccord[0].innerHTML + '\n' +
                        '</dt>\n' +
                        '<dd class="accordion-content accordionItem is-expanded animateIn" id="accordion' + i + '" aria-hidden="false">\n' +
                        contentAccord[0].innerHTML + '\n' +
                        '</dd>');

                    titleContent = awalan.find('dt').eq(i - 1);

                    titleContent.find('a')
                        .attr('href', '#accordion' + i)
                        .attr('aria-expanded', 'true')
                        .attr('aria-controls', 'accordion' + i)
                        .not('.is-collapsed, .is-expanded')
                        .addClass('is-collapsed is-expanded');

                    titleContent.find('.content-accord')
                        .html(textAccord);

                    awalan.find('dd').eq(i - 1).find('.change-tittle').attr("data-index", (i - 1));

                    $titleIndex.push(textAccord);
                    $titleContent.push('kosong');
                    showCloseAccord(i);
                }
                else if (1 <= i && valEntity > i && valEntity <= 3) {
                    $('.entity-order').text(i).hide().fadeIn('slow');
                    awalan.find('dt').eq(i).remove();
                    awalan.find('dd').eq(i).remove();

                    $titleIndex.splice(i, 1);
                    $titleContent.splice(i, 1);
                    showCloseAccord(i);
                }
                else if (i < 1) {
                    swalcustom('minimal 1 pendaftar.', 'B9F448', '3C3C3C');
                }
                else {
                    swalcustom('maksimal 3 pendaftar.', 'B9F448', '3C3C3C');
                }

            }

            $('#step1').on('click', '.remove-accordion', function () {
                contentRemove = $(this).closest('dt');
                indexRemove = contentRemove.index();
                entityOrder = $('.entity-order');

                contentRemove.next().remove();
                contentRemove.remove();
                entityOrder.text(entityOrder.text() - 1).hide().fadeIn('slow');
                $titleContent.splice($(this).closest('dt').next().find('.change-tittle').attr('data-index'), 1);

                $('#step1').find('dt').each(function (i) {
                    if ($titleContent[i] === 'kosong') {
                        $(this).find('.content-accord').text($titleIndex[i]);
                    }
                    else {
                        $(this).find('.content-accord').text($titleIndex[i] + ' : ' + $titleContent[i]);
                    }
                    $(this).next().find('.change-tittle').attr('data-index', i)
                });
                console.log($titleContent);
                console.log($titleIndex);

                showCloseAccord($('dd').length);
            });

            $('dl').on('keyup', '.change-tittle', function () {
                targetTittle = $(this).closest('dd').prev();
                aaaa = $(this).attr('data-index');
                console.log(aaaa);
                valTittle = $(this).val();

                if (!$.trim(valTittle)) {
                    targetTittle.find('.content-accord').text($titleIndex[aaaa]);
                    $titleContent[aaaa] = '';

                } else {
                    targetTittle.find('.content-accord').text($titleIndex[aaaa] + ' : ' + valTittle);
                    $titleContent[aaaa] = valTittle;
                }
                console.log($titleContent);
            })
        });

        function showCloseAccord(i) {
            if (i > 1) {
                $('#step1').find('.remove-accordion').fadeIn('slow');
            } else {
                $('#step1').find('.remove-accordion').fadeOut('slow');
            }
        }

        $('#signup').on('click', '#next', function () {
            axios.post('{{route('api.order.overwrite')}}', new FormData($('#signup')[0]))
                .then(function (response) {
                    console.log(response)
                })
                .catch(function (error) {
                    console.log(error.response)
                })
                .then(function () {
                    // $('#ed_submit').attr('disabled');
                });
            return false;
        })
    </script>
@endpush
