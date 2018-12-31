if ($('body').find('#student-schedule').length > 0) {
    $(function () {
        const targetOb = $('#student-schedule'),
            targetDay = targetOb.children().eq(0).children(),
            placeRight = $('.place-right'),
            targetAct = targetDay.find('.accord-con-detail'),
            loadPart = $('#loading'),
            errNotice = 'terdapat kesalahan. silakan muat ulang / kontak admin',
            timeEnd = placeRight.find('[name="time_end"]'),
            urlApi = '/api/v1/admin/student-config/schedules/';

        let dataLabel, manS = $('.grid').masonry({
                // options
                itemSelector: '.grid-item',
                columnWidth: 2
            }),

            getDataAsync = function () {
                const urlPage = 'list';
                let cloneEl = targetDay.children().clone(),
                    cloneList = targetAct.children().clone(),
                    editCloneList = cloneList.eq(0),
                    editCloneEl = cloneEl.eq(0);

                axios.get(urlApi + urlPage)
                    .then(res => {
                        let ser = manS.find('.grid-item'),
                            elems = [];
                        for (let i = 0; i < ser.length; i++) {
                            manS.masonry('remove', ser.eq(i)).masonry('layout');
                        }
                        $.each(res.data, function (i, key) {
                            let targetList = editCloneEl.children().eq(1),
                                fragment = document.createDocumentFragment();

                            editCloneEl.find('h3').text(key.name).parent().next().empty();
                            if (key.list.length > 0) {
                                $.each(key.list, function (z, val) {
                                    let crediv2 = document.createElement("div");
                                    editCloneList.find('h4').text(val.name.length > 13 ? val.name.substr(0, 12) + '..' : val.name)
                                        .prop('title', (val.name.length > 13 ? val.name : ''))
                                        .next().text('Waktu:' + val.time_start.substr(0, val.time_start.length - 3) +
                                        '-' + val.time_end.substr(0, val.time_end.length - 3) + ' WIB')
                                        .next().text(val.code ? val.code : 'Tambahan');

                                    $(crediv2).addClass('accord-con-fill').append(cloneList[0].innerHTML).data('list', 'dasd');

                                    targetList.append('<div class="accord-con-fill" data-key="' + z + '">' + cloneList[0].innerHTML + '</div>');
                                });
                            } else {
                                targetList.append('<div class="accord-con-fill" style="padding: 15px 19px">' + 'Data belum disi' + '</div>');
                            }
                            var creDiv = document.createElement("div");


                            $(creDiv).addClass('grid-item grid-item-schedules schedule-list').append(cloneEl[0].innerHTML)
                                .data('key', key.key).data('list', key.list);
                            fragment.appendChild(creDiv);
                            elems.push(creDiv);
                            targetDay.append(fragment);

                        });
                        manS.masonry('appended', $(elems)).masonry('layout');
                        // targetOb.find('.grid').masonry('reloadItems');

                    }).catch(er => {
                    console.log(er)
                    erra(er.response);
                });
            };

        targetDay.on('click', '.fa-trash-o', function () {
            let targetFun = $(this).closest('.schedule-list'),
                dataFunc = targetFun.data('list'),
                indexFun = $(this).closest('.accord-con-fill').prevAll().length,
                speDataFun = dataFunc[indexFun];
            if (permissionsDel()) {
                loadPart.show();
                const subUrl = 'delete';
                axios.delete(urlApi + subUrl, {params: {key: speDataFun.rs_key}})
                    .then(res => {
                        swallCustom(res.data.msg);
                        getDataAsync();
                        loadPart.hide();
                    }).catch(er => {
                    loadPart.hide();
                    erra(er.response);
                });
            }

        });

        targetDay.on('click', '.fa-edit', function () {
            let targetFun = $(this).closest('.schedule-list'),
                dataFunc = targetFun.data('list'),
                indexFun = $(this).closest('.accord-con-fill').prevAll().length,
                speDataFun = dataFunc[indexFun],
                objSelect = placeRight.find('select'),
                conEdit = placeRight.find('[name="con"]');

            if (speDataFun.key) {
                let selectText = objSelect.val(speDataFun.key).find(':selected').text();
                objSelect.parent().fadeIn(300);
                placeRight.find('[name="act_other"]').hide();
                objSelect.next()
                    .prop('title', selectText)
                    .find('.filter-option-inner-inner').text(selectText);
                conEdit.prop('checked', false);

            } else {
                placeRight.find('[name="act_other"]').val(speDataFun.name).fadeIn(300);
                conEdit.prop('checked', true);
                objSelect.parent().hide();

            }
            placeRight.find('[name="time_start"]').val(speDataFun.time_start.substr(0, (speDataFun.time_start.length - 3)));
            placeRight.find('[name="time_end"]').val(speDataFun.time_end.substr(0, (speDataFun.time_end.length - 3)));
            placeRight.find('.btn-info').text('Rubah')
                .data('key', {
                    obj: targetFun.data('key'),
                    rs: speDataFun.rs_key
                });
            dataLabel = targetFun.data();

            placeRight.addClass('activo');
        });

        $(window).ready(function () {
            getDataAsync();
        });

        placeRight.on('click', '.fa-window-close', function () {
            placeRight.removeClass('activo');
            $(document).unbind('load', hideContentRight);


        });
        targetDay.on('click', '.fa-plus', function () {
            if (!placeRight.hasClass('activo')) {
                placeRight.addClass('activo').find('input').val('');
                placeRight.find('select').val(0).next().prop('title', 'tidak ada yang dipilih')
                    .prop('aria-expanded', true).find('.filter-option-inner-inner').text('tidak ada yang dipilih');
            }
            removeA();
            placeRight.find('.btn-info').text('Daftarkan').data('key', '');
            dataLabel = $(this).closest('.schedule-list').data();
        });

        placeRight.on('change', '[name=con]', function () {
            let manipEl = $(this).closest('.form-group').find('[name=act_other]');
            $(this).is(':checked') ? manipEl.fadeIn(300).closest('.form-group').find('div.dropdown.bootstrap-select').hide() :
                manipEl.hide().closest('.form-group').find('div.dropdown.bootstrap-select').fadeIn(300);
        });

        placeRight.on('change', '[name=time_start]', function () {
            if (!placeRight.find('[name=con]').is(':checked')) {

                let valFunc = $(this).val, t = moment($(this).val(), 'HH:mm'),
                    rangeFunc = $(this).closest('form').find('select').find(":selected").data('time');

                $(this).closest('.form-group').find('[name="time_end"]').val(t.add(parseInt(rangeFunc), 'minutes').format("HH:mm"));

            }
        });

        placeRight.find('[name="time_start"]').hover(function () {
            if (!placeRight.find('[name=con]').is(':checked')) {
                if (placeRight.find('select').val() === null) {
                    $(this).prop('readonly', true).css('cursor', 'not-allowed');
                } else {
                    $(this).prop('readonly', false).css('cursor', 'unset');

                }
            } else {
                $(this).prop('readonly', false).css('cursor', 'unset');

            }
        });
        placeRight.find('[name="time_start"]').click(function () {
            if (!placeRight.find('[name=con]').is(':checked')) {
                if (placeRight.find('select').val() === null) {
                    swallCustom('Harap pilih kegiatan terlebih dahulu')
                }
            }
        });

        placeRight.on('submit', 'form', function (e) {
            e.preventDefault();
            let dataFunc = new FormData($(this)[0]),
                checkMe = placeRight.find('.btn-info').data('key');

            let urlSide = checkMe ? 'update' : 'post';
            if (checkMe.obj) {
                dataFunc.append('key', checkMe.obj);
                dataFunc.append('_method', 'PUT');
                dataFunc.append('rs_key', checkMe.rs);
            } else {
                dataFunc.append('key', dataLabel.key);
            }
            loadPart.show();
            placeRight.find('.help-block').text('');
            axios.post(urlApi + urlSide, dataFunc)
                .then(res => {
                    loadPart.hide();
                    swallCustom(res.data.msg);
                    placeRight.removeClass('activo');
                    removeA();
                    getDataAsync();

                }).catch(er => {
                catchErAct(er);
            });

        });

        function removeA() {
            placeRight.find('input').val('');
            placeRight.find('select').val(0).next().removeClass()
                .addClass('btn dropdown-toggle bs-placeholder btn-default')
                .prop('title', 'tidak ada yang dipilih')
                .find('.filter-option-inner-inner').text('tidak ada yang dipilih');
        }


        function catchErAct(er) {
            loadPart.hide();
            anim('animated shake', placeRight.find('form'), 'animated shake');
            if (er) {
                let erNo = er.status;
                if (erNo === 422) {
                    $.each(er.data, function (i, val) {
                        $('[name=' + i + ']').closest('.form-group').find('.help-block').text(val);
                    })
                }
            } else {
                swallCustom(errNotice);
            }
        }


        timeEnd.click(function () {
            if (!placeRight.find('[name=con]').is(':checked')) {
                swallCustom('pada mode ini tidak bisa diganti')
            }

        });
        timeEnd.hover(function () {
            handTimeEnd();
        });

        function handTimeEnd() {
            if (!placeRight.find('[name=con]').is(':checked')) {
                timeEnd.prop('readonly', true).css('cursor', 'not-allowed');
            } else {
                timeEnd.prop('readonly', false).css('cursor', 'unset');

            }
        }
    });
}