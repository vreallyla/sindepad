if ($('body').find('#student-schedule').length > 0) {
    $(function () {
        const targetObj = $('#student-schedule'),
            urlPage = '/simdepad/admin/student-config/schedules',
            urlApi = '/api/v1/admin/student-config/schedules/',
            placeRight = $('.place-right'),
            modalTarget = $('.modal-full'),
            targetDay = modalTarget.find('.grid'),
            targetAct = targetDay.find('.accord-con-detail'),
            qTarget = targetObj.find('input[name=search]'),
            tableLabel = targetObj.find('.table-register'),
            rowTarget = targetObj.find('select[name=entity]'),
            triggerRight = $('.trigger-right'),
            triggerHideModal = targetObj.find('.btn-back'),
            btnSearch = qTarget.next().children('button'),
            rowAvail = [10, 30, 50],
            noticeGroup = $('.error-notice,.not-found-notice'),
            targetTable = targetObj.find('tbody'),
            targetPage = targetObj.find('.paginate'),
            loadingMagnify = targetObj.find('.loading'),
            formSec = placeRight.find('form').eq(1),
            timeEnd = formSec.find('[name="time_end"]'),
            loadPart = $('#loading');

        let dataLabel, manS = $('.grid').masonry({
                // options
                itemSelector: '.grid-item',
                columnWidth: 2
            })
            , data = {
                row: getUrlParameter('row') ? getUrlParameter('row') : rowTarget.val(),
                page: getUrlParameter('page') ? getUrlParameter('page') : 1,
                q: getUrlParameter('q') ? getUrlParameter('q') : qTarget.val(),
                modalUser: false
            }, currentUrl = urlPage /*current url*/
            /*------------------ get list user with async ------------------*/
            , getListAsync = function () {
                const urlSub = 'list';
                tableLabel.hide();
                loadingMagnify.show();
                noticeGroup.hide();

                axios.get(urlApi + urlSub, {
                    params: data
                }).then(function (res) {
                    let cloneTart = targetTable.children().clone(),
                        writeClone = cloneTart.eq(0),
                        fragment = document.createDocumentFragment();
                    targetTable.empty();
                    $.each(res.data.data, function (i, val) {
                        let creTr = document.createElement("tr");

                        writeClone.children().eq(0).text(val.name.length > 13 ? val.name.substr(0, 12) + '..' : val.name)
                            .prop('title', (val.name.length > 13 ? val.name : ''))
                            .next().text(val.desc.length > 28 ? val.desc.substr(0, 25) + '..' : val.desc);

                        $(creTr).append(cloneTart[0].innerHTML).data('key', val.id);

                        fragment.appendChild(creTr);
                    });

                    targetTable.html(fragment);

                    setPagination(targetPage, res.data.max_page, res.data.current_page);

                    tableLabel.fadeIn(300);
                    loadingMagnify.hide();

                }).catch(function (er) {
                    noticeListTable(er.response);
                });
            }
            /*---------------- end get list user with async ----------------*/

            , checkpop = function (clickPage) {
                let codition = clickPage === data.page;
                data.page = clickPage;
                changeVar(codition);
            }
            /*----------- end for check popstate when click page other -----------*/

            /*------------------ handdler popstate looping ------------------*/
            , changeVar = function (codi) {
                getListAsync();
                if (!codi) {
                    currentUrl = urlPage + (data.q !== '' ? '?q=' + data.q + '&row=' : '?row=') + data.row + '&page=' + data.page;
                    history.pushState(data, "title", currentUrl);
                }
            }
            /*---------------- end handdler popstate looping ----------------*/
        ;

        $(document).ready(function () {
            currentUrl = urlPage + (data.q !== '' ? '?q=' + data.q + '&row=' : '?row=') + data.row + '&page=' + data.page;
            history.replaceState('', "", urlPage);
            history.pushState(data, "title", currentUrl);

            if (data.q !== qTarget.val()) {
                qTarget.val(data.q);
            }
            if (rowTarget.val() !== data.row && findInArray(rowAvail, data.row)) {
                rowTarget.val(data.row);
            }
            getListAsync();
        });

        /*--------------set async history with pop---------*/
        window.addEventListener('popstate', e => {
            if (modalTarget.is(':visible')) {
                window.history.forward();
                placeRight.removeClass('activo');
                hideModalFull();
                setTimeout(function () {
                    getListAsync()
                }, 100);
                triggerRight.removeClass('non');
            } else if (e.state !== '') {
                rowTarget.val(e.state.row);
                qTarget.val(e.state.q);
                data = e.state;
                getListAsync();

            } else {
                history.back();
            }
        });
        /*--------------end set async history with pop---------*/

        placeRight.find('form').eq(0).submit(function (e) {
            e.preventDefault();
            let urlSide;
            let formFunc = new FormData($(this)[0]),
                keyVal = placeRight.find('form').eq(0).find('button').data('key');

            if (keyVal) {
                urlSide = 'update';
                formFunc.append('key', keyVal);
                formFunc.append('_method', 'PUT');
            } else {
                urlSide = 'post';
            }
            loadPart.show();
            axios.post(urlApi + urlSide, formFunc)
                .then(res => {
                    loadPart.hide();
                    placeRight.find('input,textarea').val('');
                    swallCustom(res.data.msg);
                    if (keyVal) {
                        placeRight.removeClass('activo');
                        triggerRight.removeClass('non');
                    }
                    getListAsync();
                }).catch(er => {
                erInput(er.response);
            })
        });

        targetTable.on('click', '.fa-edit', function () {
            placeRight.find('form').eq(0).show().next().hide();

            const urlSide = 'edit';

            axios.get(urlApi + urlSide, {
                params: {
                    'key': $(this).closest('tr').data('key')
                }
            }).then(res => {
                loadPart.hide();
                const TargetFormRIght = placeRight.find('form').eq(0);
                $.each(res.data, function (i, val) {
                    TargetFormRIght.find('[name="' + i + '"]').val(val);
                });
                TargetFormRIght.find('button').data('key', res.data.id);
                placeRight.addClass('activo');
                triggerRight.addClass('non');
            }).catch(er => {
                erra(er.response);
            })
        });

        tableLabel.on('click', '.fa-eye', function () {
            const urlSide = 'detail';
            let cloneEl = targetDay.children().clone(),
                cloneList = targetAct.children().clone(),
                editCloneList = cloneList.eq(0),
                editCloneEl = cloneEl.eq(0);

            axios.get(urlApi + urlSide, {
                params: {
                    'key': $(this).closest('tr').data('key')
                }
            }).then(res => {
                placeRight.removeClass('activo');
                showModalFull(tableLabel);
                triggerRight.addClass('non');
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
                setTimeout(function () {
                    manS.masonry('appended', $(elems)).masonry('layout');
                }, 500);
                // targetOb.find('.grid').masonry('reloadItems');
                modalTarget.data('key', $(this).closest('tr').data('key'));
            }).catch(er => {
                erra(er.response);
            })
        });

        function refAct() {
            const urlSide = 'detail';
            let cloneEl = targetDay.children().clone(),
                cloneList = targetAct.children().clone(),
                editCloneList = cloneList.eq(0),
                editCloneEl = cloneEl.eq(0);

            axios.get(urlApi + urlSide, {
                params: {
                    'key': modalTarget.data('key')
                }
            }).then(res => {
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
                erra(er.response);
            })
        }

        tableLabel.on('click', '.fa-trash-o', function () {
            if (permissionsDel()) {
                loadPart.show();
                const subUrl = 'delete';
                axios.delete(urlApi + subUrl, {params: {key: $(this).closest('tr').data('key')}})
                    .then(res => {
                        swallCustom(res.data.msg);
                        getListAsync();
                        loadPart.hide();
                    }).catch(er => {
                    erra(er.response);
                });
            }
        });

        triggerRight.click(function () {
            placeRight.find('.title-place-right ').children().eq(0).text('Form Jadwal');
            placeRight.find('form').eq(0).show().next().hide();
        });

        modalTarget.on('click', '.fa-plus', function () {
            placeRight.addClass('activo').find('.title-place-right ').children().eq(0).text('Form Kegiatan Jadwal');
            placeRight.find('form').eq(0).hide().next().show();
            placeRight.find('form').eq(1).find('.btn-info').text('Daftarkan').data('key', '');
            placeRight.find('input').val('');
            dataLabel = $(this).closest('.schedule-list').data();
            formSec.find('.btn-info').text('Daftarkan').data('key', '');
            remInp();
        });

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

        function remInp() {
            $('.selectpicker').selectpicker('val', '');
            formSec.find('input').val('');
        }

        formSec.on('change', '[name=con]', function () {
            let manipEl = $(this).closest('.form-group').find('[name=act_other]');
            $(this).is(':checked') ? manipEl.fadeIn(300).closest('.form-group').find('div.dropdown.bootstrap-select').hide() :
                manipEl.hide().closest('.form-group').find('div.dropdown.bootstrap-select').fadeIn(300);
        });

        formSec.on('change', '[name=time_start]', function () {
            if (!formSec.find('[name=con]').is(':checked')) {

                let valFunc = $(this).val, t = moment($(this).val(), 'HH:mm'),
                    rangeFunc = $(this).closest('form').find('select').find(":selected").data('time');

                $(this).closest('.form-group').find('[name="time_end"]').val(t.add(parseInt(rangeFunc), 'minutes').format("HH:mm"));

            }
        });

        formSec.find('[name="time_start"]').hover(function () {
            if (!formSec.find('[name=con]').is(':checked')) {
                if (formSec.find('select').val() === null) {
                    $(this).prop('readonly', true).css('cursor', 'not-allowed');
                } else {
                    $(this).prop('readonly', false).css('cursor', 'unset');

                }
            } else {
                $(this).prop('readonly', false).css('cursor', 'unset');

            }
        });
        formSec.find('[name="time_start"]').click(function () {
            if (!formSec.find('[name=con]').is(':checked')) {
                if (formSec.find('select').val() === null) {
                    swallCustom('Harap pilih kegiatan terlebih dahulu')
                }
            }
        });

        formSec.on('submit', function (e) {
            e.preventDefault();
            let dataFunc = new FormData($(this)[0]),
                checkMe = formSec.find('.btn-info').data('key');

            let urlSide = checkMe ? 'update-act' : 'post-act';
            if (checkMe.obj) {
                dataFunc.append('key', checkMe.obj);
                dataFunc.append('_method', 'PUT');
                dataFunc.append('rs_key', checkMe.rs);
            } else {
                dataFunc.append('key', dataLabel.key);
            }
            dataFunc.append('key_sche', modalTarget.data('key'));

            loadPart.show();
            placeRight.find('.help-block').text('');
            axios.post(urlApi + urlSide, dataFunc)
                .then(res => {
                    loadPart.hide();
                    swallCustom(res.data.msg);
                    remInp();
                    if (checkMe.obj) {
                        placeRight.removeClass('activo');
                    }

                    refAct();

                }).catch(er => {
                erInput(er.response);
            });

        });

        targetDay.on('click', '.fa-trash-o', function () {
            let targetFun = $(this).closest('.schedule-list'),
                dataFunc = targetFun.data('list'),
                indexFun = $(this).closest('.accord-con-fill').prevAll().length,
                speDataFun = dataFunc[indexFun];
            if (permissionsDel()) {
                loadPart.show();
                const subUrl = 'delete-act';
                axios.delete(urlApi + subUrl, {params: {key: speDataFun.rs_key}})
                    .then(res => {
                        swallCustom(res.data.msg);
                        refAct();
                        loadPart.hide();
                    }).catch(er => {
                    loadPart.hide();
                    erra(er.response);
                });
            }

        });

        formSec.on('change','select',function () {

            let timeSt=formSec.find('[name="time_start"]');
            if ($.trim(timeSt.val())){
                let  t = moment(timeSt.val(), 'HH:mm'),
                    rangeFunc = timeSt.closest('form').find('select').find(":selected").data('time');

                formSec.find('[name="time_end"]').val(t.add(parseInt(rangeFunc), 'minutes').format("HH:mm"));
            }
        });

        targetDay.on('click', '.fa-edit', function () {
            placeRight.find('form').eq(0).hide().next().show();
            console.log('das');
            let targetFun = $(this).closest('.schedule-list'),
                dataFunc = targetFun.data('list'),
                indexFun = $(this).closest('.accord-con-fill').prevAll().length,
                speDataFun = dataFunc[indexFun],
                objSelect = formSec.find('select'),
                conEdit = formSec.find('[name="con"]');

            if (speDataFun.key) {
                let selectText = objSelect.val(speDataFun.key).find(':selected').text();
                objSelect.parent().fadeIn(300);
                formSec.find('[name="act_other"]').hide();
                objSelect.next()
                    .prop('title', selectText)
                    .find('.filter-option-inner-inner').text(selectText);
                conEdit.prop('checked', false);

            } else {
                formSec.find('[name="act_other"]').val(speDataFun.name).fadeIn(300);
                conEdit.prop('checked', true);
                objSelect.parent().hide();

            }
            formSec.find('[name="time_start"]').val(speDataFun.time_start.substr(0, (speDataFun.time_start.length - 3)));
            formSec.find('[name="time_end"]').val(speDataFun.time_end.substr(0, (speDataFun.time_end.length - 3)));
            formSec.find('.btn-info').text('Rubah')
                .data('key', {
                    obj: targetFun.data('key'),
                    rs: speDataFun.rs_key
                });
            dataLabel = targetFun.data();

            placeRight.addClass('activo');
        });




        placeRight.on('click', '.fa-window-close', function () {
            if (modalTarget.is(":visible")) {
                $(window).unbind('load', hideContentRight);
                setTimeout(function () {
                    triggerRight.addClass('non');
                }, 300);
            }
        });


        triggerHideModal.click(function () {
            hideModalFull(tableLabel);
            placeRight.removeClass('activo');
            triggerRight.removeClass('non');
            setTimeout(function () {
                getListAsync()
            }, 500);
        });


        rowTarget.on('change', function () {
            let changeCate = rowTarget.val(),
                codition = changeCate === data.row,
                codition2 = 1 === data.page;
            data.row = changeCate;
            data.page = 1;
            changeVar(codition === true && codition2 === true ? true : null);
        });
        btnSearch.on('click', e => {
            let clickSearch = qTarget.val(),
                codition = clickSearch === data.q, codition2 = 1 === data.page;

            data.q = clickSearch;
            data.page = 1;
            changeVar(codition === true && codition2 === true ? true : null);
        });
        targetPage.on('click', 'li', function () {
            if ($(this).hasClass('prev-page')) {
                checkpop(currentTable === 1 ? maxTable : (currentTable - 1));
            } else if ($(this).hasClass('page')) {
                checkpop($(this).children().children('.hal').text());
            } else if ($(this).hasClass('next-page')) {
                checkpop(currentTable === maxTable ? 1 : currentTable + 1);
            } else if ($(this).hasClass('sub-next-page')) {
                checkpop(parseInt($(this).prev().children().children('.hal').text()) + 1);
            } else if ($(this).hasClass('sub-prev-page')) {
                checkpop(parseInt($(this).next().children().children('.hal').text()) - 1);
            } else {
                swallCustom('Harap tidak merubah data');
                setTimeout(e => {
                    location.reload();
                }, 500);
            }
        });
        qTarget.keyup(function (e) {
            if (e.keyCode === 13) {
                btnSearch.trigger("click");
            }
        });

    });
}