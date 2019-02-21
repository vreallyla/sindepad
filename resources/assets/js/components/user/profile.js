if ($('body').find('#side-profile').length > 0) {
    $(function () {
        const targetObj = $('#side-profile'), inputTarget = $('.left-user-desc'),
            urlApi = '/api/v1/user/profile/', tabMenuN = $('.tab-menu'), kidsN = $('#kids'),
            targetEdit = kidsN.clone(), cardIMG = kidsN.find('.card-img'),
            loadingPart = $('#loading'), targetAcc = $('.target-menu');

        let imgOb = $('.pp-user').find('img'),
            descOb = $('.desc-user').children(),
            data = {
                img: '',
                name: '',
                code: '',
                role: '',
                key: ''
            };

        $(document).ready(function () {
            $('[name="phone"]').mask('000-0000-000000');

            $('.datepicker').datepicker({
                language: 'id',
                format: 'dd/mm/yyyy'
            });
        });

        $('[name="img"]').on('change', function () {
            let formFunc = new FormData(), urlSide;
            loadingPart.show();

            formFunc.append('img', $(this)[0].files[0]);
            formFunc.append('_method', 'PUT');

            if ($(this).hasClass('student-img-edit')) {
                urlSide = 'change-photo-student';
                formFunc.append('key', data.key);
            } else {
                urlSide = 'change-photo';
            }

            axios.post(urlApi + urlSide, formFunc)
                .then(res => {
                    loadingPart.hide();
                    swallCustom(res.data.msg);
                    $(this).next().prop('src', res.data.data.img);
                    if (!$(this).hasClass('student-img-edit')) {
                        $('.circular--portrait').children().prop('src', res.data.data.img);
                    }
                }).catch(er => {
                loadingPart.hide();
                anim('animated shake', targetObj, 'animated shake');
                if (er.response) {
                    if (er.response.status === 422) {
                        if (er.response.data.img)
                            swallCustom(er.response.data.img);
                        else
                            swallCustom(er.response.data.key);

                    } else {
                        swallCustom('Terjadi kesalahan, silakan refresh / kontak admin')
                    }
                } else {
                    swallCustom('Terjadi kesalahan, silakan refresh / kontak admin')
                }
            });

        });

        $('#biodata').on('submit', 'form', function (e) {
            e.preventDefault();
            const urlSide = 'update-profil';
            let formFunc = new FormData($(this)[0]);
            $(this).find('.help-block').text('');
            formFunc.append('_method', 'PUT');
            loadingPart.show();
            axios.post(urlApi + urlSide, formFunc)
                .then(res => {
                    loadingPart.hide();
                    swallCustom(res.data.msg);
                    let textFill = targetObj.find('[name="name"]').val();
                    targetObj.find('.desc-user').children().eq(0).children().eq(1).text(textFill);
                    $('.profile-up').find('.name-up').text(textFill.indexOf(' ') > 0 ? 'Sdr/i ' + textFill.substr(0, textFill.indexOf(' ')) : textFill);
                }).catch(er => {
                anim('animated shake', targetObj, 'animated shake');
                erInputCus(er.response, $(this));
            });
        });

        $('#password').on('submit', 'form', function (e) {
            e.preventDefault();
            const urlSide = 'change-password';
            let formFunc = new FormData($(this)[0]);
            formFunc.append('_method', 'PUT');
            $(this).find('.help-block').text('');
            loadingPart.show();
            axios.post(urlApi + urlSide, formFunc)
                .then(res => {
                    loadingPart.hide();
                    swallCustom(res.data.msg);
                    $(this).find('input').val('');
                }).catch(er => {
                anim('animated shake', targetObj, 'animated shake');
                erInputCus(er.response, $(this));
            });
        });

        $('input[type="checkbox"]').on('change', function () {
            const tartFunc = $(this).parent().prev();
            if ($(this).is(':checked')) {
                tartFunc.prop('type', 'text');
            } else {
                tartFunc.prop('type', 'password');
            }

        });

        tabMenuN.on('click', 'li', function () {
            let thiss = $(this), dataNa = thiss.data('target');
            if (!(dataNa === 'kids') && !thiss.hasClass('activo')) {
                changeLeftInfo();
                thiss.addClass('activo').siblings().removeClass('activo');
                targetAcc.children().not('.left-user-desc').hide();
                targetAcc.find('#' + dataNa).fadeIn(500);
            }
        });

        tabMenuN.on('click', '[data-target="kids"]', function () {
            getDataKids($(this).data('target'), $(this));

        });

        function getDataKids(dataNa, thiss) {
            let urlSide = 'kids';
            showLoading();
            axios.get(urlApi + urlSide)
                .then(res => {
                    let dataN = res.data,
                        targetNa = targetAcc.find('#' + dataNa),
                        cloneData = targetEdit,
                        cloneEdit = cloneData.eq(0)
                    ;

                    changeLeftInfo();
                    hideLoading();

                    targetNa.html('');

                    $.each(dataN, function (i, val) {
                        cloneEdit.find('img').prop('src', val.img).parent().next().children('h3')
                            .text(val.name.length > 12 ? val.name.substr(0, 12) + '..' : val.name)
                            .prop('title', val.name.length > 12 ? val.name : '')
                            .next().text(val.code_regist)
                            .next().text(val.status.ind)
                            .prop('title', 'Batas Waktu: ' + moment(val.date_exp.date).format("Do MMM YYYY"))
                            .removeClass().addClass('label ' + (val.status.ind === 'Aktif' ? 'label-info' : 'label-danger'))
                        ;

                        targetNa.append(cloneData[0].innerHTML);
                        targetNa.children().eq(i).data('key', val.key);
                    });

                    if (thiss) {
                        thiss.addClass('activo').siblings().removeClass('activo');
                    }
                    targetAcc.children().not('.left-user-desc').hide();

                    targetNa.fadeIn(500);
                })
                .catch(er => {
                    console.log(er);
                    hideLoading();
                    erra(er.response);
                });
        }

        function inputCus(valN, dec, place, type, textN, classAdd) {
            let inputN = document.createElement("input");

            $(inputN).prop('type', type).prop('placeholder', place)
                .prop('name', dec).prop('id', dec).addClass('form-control ' + classAdd)
                .val(valN);

            return anukan(inputN, textN, dec);
        }

        function selectCus(eachList, dec, textN, place, classAdd) {
            let opsia,
                selectN = document.createElement("select"),
                opsiN = document.createElement("option");
            if (place) {
                opsia = $(opsiN).clone().prop('value', '').text(place).prop('selected', true).prop('disabled', true);
                $(selectN).append(opsia);
            }

            $.each(eachList, function (i, val) {
                // let fragment = document.createDocumentFragment();

                opsia = $(opsiN).clone().prop('value', val.id).text(val.ind ? val.ind : val.name);

                $(selectN).append(opsia);
            });

            $(selectN).addClass('form-control ' + classAdd).prop('name', dec).prop('id', dec);


            return anukan(selectN, textN, dec);

        }

        kidsN.on('click', '.card-img', function (e) {
            let thiss = $(e.target);
            if (thiss.is('label')) {
                let thisss = $(this), keyN = thisss.data('key'),
                    urlSide = 'kid-detail';

                data.img = imgOb.prop('src');
                data.name = descOb.eq(0).children('h5').text();
                data.code = descOb.eq(1).children('h5').text();
                data.role = descOb.eq(2).children('h5').text();
                data.key = keyN;
                showLoading();

                axios.get(urlApi + urlSide + '?key=' + keyN)
                    .then(res => {
                        hideLoading();
                        console.log(res);

                        let formN = document.createElement("form"),
                            dataN = res.data,
                            fragment = document.createDocumentFragment();

                        kidsN.empty().html(formN);

                        let selectN = document.createElement("select"),
                            opsiN = document.createElement("option"),
                            textarea = document.createElement("textarea");

                        formGrupN(
                            inputCus(dataN.name, 'name', 'Isi Nama Lengkap', 'text', 'Nama'),
                            selectCus(dataN.gender.data, 'gender', 'Jenis Kelamin',
                                'pilih Jenis Kelamin'));
                        formGrupN(
                            inputCus(dataN.born_place, 'born_place', 'Isi Tempat Lahir', 'text', 'Tempat Lahir'),
                            inputCus(moment(dataN.dob).format('DD/MM/YYYY'), 'dob', 'dd/mm/yyyy', 'text', 'Tanggal Lahir'),
                        );

                        formGrupN(
                            selectCus(dataN.rel.data, 'rel', 'Hubungan', 'Pilih Hubungan'),
                            selectCus(dataN.needed.data, 'needed', 'Kebutuhan',
                                null, 'selectpicker')
                        );

                        formGrupN('<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"><label class="control-label">Alamat\n' +
                            '                :</label><textarea name="address" cols="10" rows="4" class="form-control"\n' +
                            '                      placeholder="jika ada tulis disini">' + (dataN.address === null ? '' : dataN.address) + '</textarea>' +
                            '<span class="help-block"></span></div>',
                            '<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"><label class="control-label">Detail\n' +
                            '                :</label><textarea name="detail" cols="10" rows="4" class="form-control"\n' +
                            '                      placeholder="jika ada tulis disini">' + dataN.detail + '</textarea>' +
                            '<span class="help-block"></span></div>');

                        formGrupN('<button class="btn btn-info" type="submit" style="margin-right: 4px;margin-left: 15px">Rubah</button>',
                            '<buton class="btn btn-dark" style="background: #eee;\n' +
                            '    border: 1px solid #dcd8d8;">Kembali</buton>');


                        kidsN.find('[name="rel"]').val(dataN.rel.selected);
                        kidsN.find('[name="gender"]').val(dataN.gender.selected);
                        kidsN.find('[name="dob"]').datepicker({
                            language: 'id',
                            format: 'dd/mm/yyyy',
                            value: moment(dataN.dob).format('DD/MM/YYYY')
                        });

                        kidsN.find('[name="phone"]').mask('000-0000-000000');

                        kidsN.find('#needed').prop('multiple', true).selectpicker('val', dataN.needed.selected).prop('data-container', 'body')
                            .prop('name', 'needed[]');

                        imgOb.prop('src', dataN.img).prev().addClass('student-img-edit');
                        descOb.eq(0).children('h5').text(dataN.name);
                        descOb.eq(1).children('h5').text(dataN.code_regist);
                        descOb.eq(2).children('h5').text(moment(dataN.date_exp).format("Do MMM YYYY")).prev().text('Masa Aktif :');
                        imgOb.closest('.left-user-desc').hide().fadeIn(500);
                        kidsN.hide().fadeIn(500);

                    }).catch(er => {
                    erra(er.response);
                });
            }
        });

        kidsN.on('submit', 'form', function (e) {
            e.preventDefault();
            let formFunc = new FormData($(this)[0]),
                urlSide = 'edit-student';

            formFunc.append('key', data.key);
            formFunc.append('_method', 'PUT');

            showLoading();
            kidsN.find('.help-block').text('');

            axios.post(urlApi + urlSide, formFunc)
                .then(res => {
                    hideLoading();
                    kidsN.find('.help-block').text('');
                    swallCustom(res.data.msg);
                    setTimeout(function () {
                        getDataKids('kids')
                    }, 500);
                }).catch(er => {
                hideLoading();
                erInputCus(er.response, $(this));
            });
        });

        kidsN.on('click', '.btn-dark', function () {
            getDataKids('kids')
        });

        function formGrupN(form1, form2) {
            let divCol = document.createElement("div");

            $(divCol).addClass('col-lg-12 col-md-12 col-sm-12 col-xs-12').append(form1).append(form2);

            kidsN.children('form').append(divCol);
        }

        function anukan(objN, textN, i) {
            let divGrup = document.createElement("div"),
                labelN = document.createElement("label"),
                spanN = document.createElement("span"),
                fragment = document.createDocumentFragment();

            $(labelN).addClass('control-label').text(textN).prop('for', i);
            $(spanN).addClass('help-block');
            $(divGrup).addClass('form-group col-lg-6 col-md-6 col-sm-12 col-xs-12')
                .append(labelN).append(objN).append(spanN);


            return fragment.appendChild(divGrup);

        }

        function changeLeftInfo() {
            if (data.key) {
                imgOb.prop('src', data.img).prev().removeClass();
                descOb.eq(0).children('h5').text(data.name);
                descOb.eq(1).children('h5').text(data.code);
                descOb.eq(2).children('h5').text(data.role).prev().text('Hak Akses');
                inputTarget.hide().fadeIn(500);
                data.key = data.img = data.name = data.code = data.role = '';
            }
        }

    });
}
