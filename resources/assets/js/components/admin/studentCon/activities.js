if ($('body').find('#student-activities').length > 0) {

    $(function () {
        const targetObj = $('#student-activities'),
            urlPage = '/simdepad/admin/student-config/activities',
            urlApi = '/api/v1/admin/student-config/',
            errNotice = 'terdapat kesalahan. silakan muat ulang / kontak admin',
            nullNotice = "Belum diisi", showModal = 'label',
            btnTrigOpsi = $('.btn-handdle'),
            triggerRight = $('.trigger-right'),
            manipNotice = 'Harap tidak merubah data',
            modalpage = $('#modal-container'),
            modalTarget = targetObj.find('.modal-full'), triggerHideModal = targetObj.find('.btn-back'),
            targetFillModal = modalTarget.find('.act-fill-sub'),
            targetPage = targetObj.find('.paginate'),
            rowTarget = targetObj.find('select[name=entity]'),
            qTarget = targetObj.find('input[name=search]'),
            rowAvail = [9, 27, 45],
            btnSearch = qTarget.next().children('button'),
            sucNotice = 'berhasil dibuat',
            objMain = $('.card-mod,.paginated'), loadingMagnify = targetObj.find('.loading'),
            noticeGroup = $('.error-notice,.not-found-notice'),
            loadPart = $('#loading'), targetList = targetObj.find('.card-mod'),
            fillList = targetList.children(),
            contentRight = $('.place-right');

        let data = {
                row: getUrlParameter('row') ? getUrlParameter('row') : rowTarget.val(),
                page: getUrlParameter('page') ? getUrlParameter('page') : 1,
                q: getUrlParameter('q') ? getUrlParameter('q') : qTarget.val(),
                modalUser: false
            },
            keyActi, clickEditAct = false, clickDelAct = false,
            currentUrl = urlPage, /*current url*/currentTable, maxTable,

            removeModal = function () {
                modalpage.addClass('out');
                $('body').removeClass('preloader-site');
            },

            showsubModalAsync = function (dataSubDetail) {
                const subDetailPage = 'sub-activity-detail';
                loadPart.show();
                axios.get(urlApi + subDetailPage + '?key=' + dataSubDetail)
                    .then(res => {
                        loadPart.hide();
                        showModalAnim();
                        modalpage.find('button').data('key', res.data.id);
                        $.each(res.data, function (i, val) {
                            if (i !== 'id') {
                                modalpage.find('[name=' + i + ']').val(val);
                            }
                        });
                    }).catch(er => {
                    if (er.response) {
                        er.response.status === 422 ? swallCustom(manipNotice) : swallCustom(errNotice);
                    } else {
                        swallCustom(errNotice);
                    }
                });
            },

            /*------------------ get async detail ------------------*/
            detailAsync = function (dataa) {
                const urlDetail = 'activity-detail';
                axios.get(urlApi + urlDetail, {
                    params: dataa
                })
                    .then(function (res) {
                        let cloneModalFull = targetFillModal.children().clone(),
                            editCloneModal = cloneModalFull.eq(0),
                            dataDetail = res.data;

                        modalTarget.find('img').prop('src', dataDetail.img).closest('.header-card-profil')
                        /*name activity*/
                            .next().children().eq(0).children().eq(0).text(dataDetail.name)
                        /*code activity*/
                            .next().text(dataDetail.code);

                        targetFillModal.empty();
                        if (dataDetail.list.length > 0) {
                            $.each(dataDetail.list, function (i, val) {
                                editCloneModal.children().eq(0).text(val.name).next().show();
                                targetFillModal.append('<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 fill-pers-info act-sub-list">' + cloneModalFull[0].innerHTML + ' </div>');
                                targetFillModal.children().eq(i).data('key', val.key);
                            });
                        } else {
                            editCloneModal.children().eq(0).text(nullNotice).next().hide();
                            targetFillModal.append('<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 fill-pers-info act-sub-list" >' + cloneModalFull[0].innerHTML + ' </div>');

                        }

                        showModalFull(); /*trigger show modal*/
                        loadPart.hide();
                    })
                    .catch(function (er) {
                        loadPart.hide();

                        if (errNotice.response) {
                            errSet(er.response.status);
                        } else {
                            swallCustom(errNotice);
                        }
                    });
            },
            /*---------------- end get async detail ----------------*/

            /*------------------ get list user with async ------------------*/
            getListAsync = function () {
                const urlSub = 'activity-list';
                objMain.hide();
                loadingMagnify.show();
                noticeGroup.hide();

                axios.get(urlApi + urlSub, {
                    params: data
                }).then(function (res) {
                    let cloneTart = fillList.clone(),
                        writeClone = cloneTart.eq(0);
                    targetList.empty();
                    $.each(res.data.data, function (i, val) {
                        writeClone.find('img').prop('src', val.img).parent().next().next().children('h3')
                            .text(val.name.length > 12 ? val.name.substr(0, 12) + '..' : val.name)
                            .prop('title', val.name.length > 12 ? val.name : '').next().text(val.code);

                        targetList.append('<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 card-img">' +
                            cloneTart[0].innerHTML +
                            '</div>');
                        targetList.children().eq(i).data('key', val.key);
                    });

                    currentTable = parseInt(res.data.current_page);
                    maxTable = parseInt(res.data.max_page);
                    setPagination(targetPage, res.data.max_page, res.data.current_page);
                    clickEditAct ? showEditAcOp() : (clickDelAct ? showDelAcOp() : null);
                    objMain.fadeIn(300);
                    loadingMagnify.hide();
                }).catch(function (er) {
                    loadingMagnify.hide();
                    if (er.response.status === 403 || er.response.status === 422) {
                        $('.not-found-notice').fadeIn(300);
                    } else {
                        $('.error-notice').fadeIn(300);
                    }
                });
            },
            /*---------------- end get list user with async ----------------*/


            /*------------- for check popstate when click page other -------------*/
            checkpop = function (clickPage) {
                let codition = clickPage === data.page;
                data.page = clickPage;
                changeVar(codition);
            },
            /*----------- end for check popstate when click page other -----------*/

            /*------------------ handdler popstate looping ------------------*/
            changeVar = function (codi) {
                getListAsync();
                if (!codi) {
                    currentUrl = urlPage + (data.q !== '' ? '?q=' + data.q + '&row=' : '?row=') + data.row + '&page=' + data.page;
                    history.pushState(data, "title", currentUrl);
                }
            };
        /*---------------- end handdler popstate looping ----------------*/

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
                hideModalFull();
                setTimeout(function () {
                    getListAsync()
                }, 100);
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

        contentRight.on('submit', 'form', function (e) {
            e.preventDefault();
            let formFill = new FormData($(this)[0]);
            loadPart.show();
            contentRight.find('.help-block').text('');

            if (contentRight.find('button').data('key')) {
                updateAct(formFill);

            } else {
                newAct(formFill);
            }

            return false;
        });

        function updateAct(formN) {
            const linkPage = 'activity-update';
            formN.append('key', contentRight.find('button').data('key'));
            formN.append('_method', 'PATCH');
            contentRight.find('.help-block').text('');
            axios.post(urlApi + linkPage, formN)
                .then(res => {
                    loadPart.hide();
                    clickEditAct = true;
                    getListAsync();
                    contentRight.find('input,textarea').val('');
                    contentRight.removeClass('activo');
                    setTimeout(function () {
                        triggerRight.removeClass('non')
                    }, 300);
                }).catch(er => {
                erPlaceRight(er.response);
            });
        }

        function newAct(formN) {
            const linkPage = 'activity-post';
            axios.post(urlApi + linkPage, formN)
                .then(function (res) {
                    loadPart.hide();
                    contentRight.find('input').val('');
                    contentRight.find('textarea').text('').val('');
                    swallCustom(sucNotice);
                    getListAsync();
                })
                .catch(function (er) {
                    erPlaceRight(er.response)
                });
        }

        function erPlaceRight(er) {
            loadPart.hide();
            anim('animated shake', contentRight.find('form'), 'animated shake');
            if (er) {
                let erNo = er.status;
                loadPart.hide();
                if (erNo === 422) {
                    $.each(er.data, function (i, val) {
                        $('[name=' + i + ']').next().text(val);
                    })
                } else if (erNo === 400) {
                    swallCustom('upload gambar gagal');

                } else {
                    swallCustom(errNotice);
                }
            }
        }

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
            if (!$(this).hasClass('active')) {
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
            }
        });

        targetList.on('click', showModal, function () {
            loadPart.show();
            keyActi = $(this).closest('.card-img').data('key');
            detailAsync({key: keyActi});
        });

        qTarget.keyup(function (e) {
            if (e.keyCode === 13) {
                btnSearch.trigger("click");
            }
        });

        triggerHideModal.on('click', function () {
            btnTrigOpsi.children().eq(0).fadeIn(300).next().fadeIn(300).next().fadeOut(300);
            clickEditAct = clickDelAct = false;
            hideModalFull();
            setTimeout(e => {
                getListAsync();
            }, 500);
        });

        $('#modal-container .modal-background').parent().click(function (e) {
            let target = $(e.target);
            if (target.is('.modal-background')) {
                removeModal();
            } else if (target.is('button')) {
                e.preventDefault();
                modalpage.find('button').data('key') ? editSubAct() : postSubAct();
            }

        });

        modalpage.find('.modal').on('click', '.fa-times', removeModal);

        modalTarget.on('click', '.fa-edit', function () {
            modalpage.find('button').text('Rubah');
            let dataSubDetail = $(this).closest('.act-sub-list').data('key');
            showsubModalAsync(dataSubDetail);
        });

        modalTarget.on('click', '.fa-trash', function () {

            if (permissionsDel()) {
                const subActDel = 'sub-activity-delete';
                loadPart.show();
                axios.put(urlApi + subActDel, {key: $(this).closest('.act-sub-list').data('key')})
                    .then(res => {
                        changeListSub(res.data.list);
                        loadPart.hide();
                    }).catch(er => {
                    loadPart.hide();
                    erra(er.response);
                });
            }
        });

        modalTarget.on('click', '.btn-add-sub', function () {
            showModalAnim();
            modalpage.find('button').data('key', '').text('Daftarkan');
            modalpage.find('input').val('');
            modalpage.find('textarea').val('');
        });


        function editSubAct() {
            let dataEditSub = {
                desc: modalpage.find('[name=desc]').val(),
                name: modalpage.find('[name=name]').val(),
                target: modalpage.find('[name=target]').val(),
                key: modalpage.find('button').data('key'),
                keyAc: keyActi
            };
            const urlEditSub = 'sub-activity-edit';
            loadPart.show();
            axios.put(urlApi + urlEditSub, dataEditSub)
                .then(res => {
                    loadPart.hide();
                    changeListSub(res.data.list);
                    removeModal();
                    swallCustom(sucNotice);
                }).catch(er => {
                loadPart.hide();
                erra(er.response);
            });
        }

        function postSubAct() {
            const urlPostSub = 'sub-activity-post';
            let formpostAc = new FormData(modalpage.find('form')[0]);
            formpostAc.append('keyAc', keyActi);
            loadPart.show();
            axios.post(urlApi + urlPostSub, formpostAc)
                .then(res => {
                    changeListSub(res.data.list);
                    loadPart.hide();
                    removeModal();
                    swallCustom(sucNotice);
                }).catch(er => {
                loadPart.hide();
                erra(er.response);
            });
        }

        function changeListSub(data) {
            let cloneModalFull = targetFillModal.children().clone(),
                editCloneModal = cloneModalFull.eq(0);

            targetFillModal.empty();
            if (data.length > 0) {
                $.each(data, function (i, val) {
                    editCloneModal.children().eq(0).text(val.name).next().show();
                    targetFillModal.append('<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 fill-pers-info act-sub-list">' + cloneModalFull[0].innerHTML + ' </div>');
                    targetFillModal.children().eq(i).data('key', val.key);
                });
            } else {
                editCloneModal.children().eq(0).text(nullNotice).next().hide();
                targetFillModal.append('<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 fill-pers-info act-sub-list" >' + cloneModalFull[0].innerHTML + ' </div>');

            }

        }


        btnTrigOpsi.children().eq(0).click(function () {
            clickEditAct = true;
            $(this).hide().next().hide().next().fadeIn(300);
            showEditAcOp();
        });
        btnTrigOpsi.children().eq(1).click(function () {
            clickDelAct = true;
            $(this).parent().children().eq(0).hide().next().hide().next().fadeIn(300);
            showDelAcOp();
        });
        btnTrigOpsi.children().eq(2).click(function () {
            $(this).hide().prev().fadeIn(300).prev().fadeIn(300);
            clickEditAct = clickDelAct = false;
            let imgList = targetObj.find('.card-img');
            for (let i = 0; i < imgList.length; i++) {
                targetObj.find('.card-img').eq(i).find('.exc-btn-list').children().fadeOut(300)
            }

        });

        function showDelAcOp() {
            let imgList = targetObj.find('.card-img');
            for (let i = 0; i < imgList.length; i++) {
                targetObj.find('.card-img').eq(i).find('.exc-btn-list').children().eq(0).fadeIn(300)
            }
        }

        function showEditAcOp() {
            let imgList = targetObj.find('.card-img');
            for (let i = 0; i < imgList.length; i++) {
                targetObj.find('.card-img').eq(i).find('.exc-btn-list').children().eq(1).fadeIn(300)
            }
        }

        targetObj.on('click', '.exc-btn-list', function (e) {
            let target = $(e.target),
                keyAct = $(this).closest('.card-img').data('key');
            if (target.is('.fa-edit')) {
                editAct(keyAct);

            } else if (target.is('.fa-times-circle')) {
                if (permissionsDel()) {
                    removeAct(keyAct);
                }
            }

        });

        function editAct(id) {
            loadPart.show();
            const subUrl = 'activity-edit';
            axios.get(urlApi + subUrl, {params: {key: id}})
                .then(res => {
                    loadPart.hide();
                    $.each(res.data, function (i, val) {
                        contentRight.find('[name=' + i + ']').val(val);
                    });
                    contentRight.addClass('activo').find('button').data('key', res.data.key).text('Rubah');
                    $(this).addClass('non');
                    $('input[name=name]').focus();

                }).catch(er => {
                loadPart.hide();
            });
        }

        triggerRight.on('click', function () {
            contentRight.addClass('activo').find('button').data('key', '').text('Daftarkan');
            contentRight.find('input,textarea').val('')
        });

        function removeAct(id) {
            loadPart.show();
            const subUrl = 'activity-delete';
            axios.delete(urlApi + subUrl, {params: {key: id}})
                .then(res => {
                    swallCustom(res.data.msg);
                    getListAsync();
                    loadPart.hide();

                }).catch(er => {
                loadPart.hide();
                erra(er.response);
            });
        }



    });
}