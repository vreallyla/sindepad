if ($('body').find('#student-activities').length > 0) {

    $(function () {
        const targetObj = $('#student-activities'),
            urlPage = '/simdepad/shadow/schedules/activities',
            urlApi = '/api/v1/shadow/activities/',
            errNotice = 'terdapat kesalahan. silakan muat ulang / kontak admin',
            nullNotice = "Data sub aktifitas belum diisi", showModal = 'label',
            btnTrigOpsi = $('.btn-handdle'),
            manipNotice = 'Harap tidak merubah data',
            modalpage = $('#modal-container'),
            modalTarget = targetObj.find('.modal-full'), triggerHideModal = targetObj.find('.btn-back'),
            targetFillModal = modalTarget.find('.act-fill-sub'),
            targetPage = targetObj.find('.paginate'),
            rowTarget = targetObj.find('select[name=entity]'),
            qTarget = targetObj.find('input[name=search]'),
            rowAvail = [9, 27, 45],
            btnSearch = qTarget.next().children('button'),
            objMain = $('.card-mod,.paginated'), loadingMagnify = targetObj.find('.loading'),
            noticeGroup = $('.error-notice,.not-found-notice'),
            loadPart = $('#loading'), targetList = targetObj.find('.card-mod'),
            fillList = targetList.children();


        let data = {
                row: getUrlParameter('row') ? getUrlParameter('row') : rowTarget.val(),
                page: getUrlParameter('page') ? getUrlParameter('page') : 1,
                q: getUrlParameter('q') ? getUrlParameter('q') : qTarget.val(),
                modalUser: false
            },
            keyActi,
            currentUrl = urlPage, /*current url*/

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
                            .next().text(dataDetail.code)
                            .parent().next().children().eq(0).children().eq(1).text(dataDetail.purpose)
                            .parent().next().children().eq(1).text(dataDetail.time+' Menit')
                            .parent().next().children().eq(1).text(dataDetail.summary);

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
                            targetFillModal.find('.act-sub-list').css('text-align', 'center');
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
                        writeClone.find('img').prop('src', val.img).parent().next().children('h3')
                            .text(val.name.length > 12 ? val.name.substr(0, 12) + '..' : val.name)
                            .prop('title', val.name.length > 12 ? val.name : '').next().text(val.code);

                        targetList.append('<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 card-img">' +
                            cloneTart[0].innerHTML +
                            '</div>');
                        targetList.children().eq(i).data('key', val.key);
                    });
                    setPagination(targetPage, res.data.max_page, res.data.current_page);

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
                }, 150);
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
            hideModalFull();
            setTimeout(function () {
                getListAsync();
            }, 500);
        });

        $('#modal-container .modal-background').parent().click(function (e) {
            let target = $(e.target);
            if (target.is('.modal-background')) {
                removeModal();
            } else if (target.is('button')) {
                e.preventDefault();
                removeModal();
            }

        });

        modalpage.find('.modal').on('click', '.fa-times', removeModal);

        modalTarget.on('click', '.btn-info', function () {
            let dataSubDetail = $(this).closest('.act-sub-list').data('key');
            showsubModalAsync(dataSubDetail);
        });

    });
}