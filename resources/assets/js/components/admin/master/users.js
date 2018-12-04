if ($('body').find('#mst-users').length > 0) {
    $(function () {
        const targetObj = $('#mst-users'),
            objnonModal = $('.title-content,.title-content,.paginated,.not-found-notice,.error-notice'),
            modalTarget = targetObj.find('.modal-full'), triggerHideModal = targetObj.find('.btn-back'),
            rowTarget = targetObj.find('select[name=entity]'),
            rowAvail = [10, 30, 50], catAvail = ['tf', 'cop'],
            modalOut = $('.title-content,.card-mod,.paginated'), targetList = targetObj.find('.card-mod'),
            fillList = targetList.children(),
            loadPart = $('#loading'),
            errNotice = 'terdapat kesalahan. silakan muat ulang / kontak admin',
            nullNotice = "Belum diisi",
            fillNotice = 'pastikan mengisi kolom dengan benar',
            sucNotice = 'berhasil dibuat',
            showModal = 'label', addUser = $('.add-user').children(), qTarget = targetObj.find('input[name=search]'),
            objMain = $('.card-mod,.paginated'), loadingMagnify = targetObj.find('.loading'),
            noticeGroup = $('.error-notice,.not-found-notice'),
            targetPage = targetObj.find('.paginate'),
            categoryTarget = targetObj.find('select[name=category]'),
            btnSearch = qTarget.next().children('button'),
            urlPage = '/simdepad/admin/data-master/users', urlApi = '/api/v1/admin/master/',
            arrCat = ['Admin', 'Pengajar', 'User', 'Peserta Didik', 'Hub'],
            relHub = targetObj.find('.rel-hub'),
            contentRight = $('.place-right');

        let data = {
                row: getUrlParameter('row') ? getUrlParameter('row') : rowTarget.val(),
                page: getUrlParameter('page') ? getUrlParameter('page') : 1,
                cat: getUrlParameter('cat') ? getUrlParameter('cat') : categoryTarget.val(),
                q: getUrlParameter('q') ? getUrlParameter('q') : qTarget.val(),
                modalUser: false
            },
            currentUrl = urlPage, /*current url*/

            /*------------------ for show full modal ------------------*/
            showModalFull = function () {
                objnonModal.addClass('animated slideOutDown');

                setTimeout(e => {
                    modalTarget.show();
                    objnonModal.removeClass('animated slideOutDown').hide();
                    anim('animated bounceInDown', modalTarget, 'animated bounceInDown');
                }, 300);
            },
            /*---------------- end for show full modal ----------------*/

            /*------------------ for hide full modal ------------------*/
            hideModalFull = function () {
                modalTarget.fadeOut(300);
                setTimeout(e => {
                    modalOut.fadeIn(300);
                }, 500);
            },
            /*---------------- end for hide full modal ----------------*/

            /*------------------ get list user with async ------------------*/
            getListAsync = function () {

                objMain.hide();
                loadingMagnify.show();
                noticeGroup.hide();

                axios.get(urlApi + 'users', {
                    params: data
                }).then(function (res) {
                    categoryTarget.val(data.cat);
                    qTarget.val(data.q);
                    let cloneTart = fillList.clone(),
                        writeClone = cloneTart.eq(0);
                    targetList.empty();
                    $.each(res.data.data, function (i, val) {
                        writeClone.find('img').prop('src', val.img).parent().next().children('h3')
                            .text(val.name.length > 12 ? val.name.substr(0, 12) + '..' : val.name)
                            .prop('title', val.name.length > 12 ? val.name : '').next().text(data.cat);

                        targetList.append('<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 card-img">' +
                            cloneTart[0].innerHTML +
                            '</div>');
                        targetList.children().eq(i).data('key', val.id);
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

            /*----------------  rel user ---------------- */
            modalFullAddRel = function (targetmodalLopp, dataRel) {
                targetmodalLopp.empty(); /*empty hub*/
                /*if have rel loop*/
                if (dataRel) {
                    $.each(dataRel, function (i, val) {
                        targetmodalLopp.append('<h5 data-toggle="tooltip" data-placement="top" title="' + val.notice + '" ' +
                            'class="label label-default add-margin-left-sm" style="cursor: pointer">\n' +
                            val.name +
                            '</h5>');
                        targetmodalLopp.children().eq(i).data('fill', {
                            key: val.key,
                            cat: val.status
                        });
                    });
                } else {
                    targetmodalLopp.append('<h5>' + nullNotice + '</h5>');
                }
            },
            /*----------------  end rel user ---------------- */

            /*----------- get detail user with showing modal full -----------*/
            getModalAsync = function (labelData) {

                let conStudent = labelData.cat === arrCat[3], /*for check cat student*/
                    targetmodalLopp = modalTarget.find('.header-card-profi-bg').children().prop('src', labelData.img) /*declare for looping*/

                        .parent().next().find('img').prop('src', labelData.img) /*change img*/
                        .parent().next().children('h3').text(labelData.name).next().text(labelData.cat) /*role*/
                        .closest('.radius-bottom-modif').next().children().eq(0).children('span').text(labelData.numb_regist) /*key*/
                        .parent().next().children().eq(0).children('h5').text(labelData.gender) /*gender*/
                        .parent().next().children('span').text(conStudent ? 'Kebutuhan' : 'Email') /*email/needed*/
                        .next().text(conStudent ? labelData.needed : (labelData.email ? labelData.email : nullNotice))
                        .closest('.fill-pers-info').next().children().eq(0).children('h5').text(labelData.dob ? labelData.dob : nullNotice) /*dob*/
                        .parent().next().children('h5').text(labelData.phone ? labelData.phone : nullNotice) /*phone numb*/
                        .closest('.fill-pers-info').next().children().eq(0).children('h5').text(labelData.status.notice) /*status*/
                        .prop('title', labelData.status.date ? moment(labelData.status.date.date).format("Do MMM YYYY") : nullNotice) /*date*/
                        .parent().next().children('.rel-hub'); /*hub*/

                if (modalTarget.is(':visible')) {
                    let bodyModal = modalTarget.find('.body-modal');
                    targetmodalLopp.empty().append('<h5>Kolom tidak tersedia</h5>');
                    bodyModal.hide().fadeIn(500);
                    anim('animated rubberBand', bodyModal, 'animated rubberBand');

                } else {
                    modalFullAddRel(targetmodalLopp, labelData.rel);
                    showModalFull(); /*trigger show modal*/

                }

                targetmodalLopp.closest('.fill-pers-info').next().children().eq(0) /*address*/.children('h5').text(labelData.address ? labelData.address : nullNotice);
            },
            /*--------- end get detail user with showing modal full ---------*/

            /*------------------ get async detail ------------------*/
            detailAsync = function (dataa) {
                axios.get(urlApi + 'user-detail', {
                    params: dataa
                })
                    .then(function (res) {
                        loadPart.hide();
                        getModalAsync(res.data);
                    })
                    .catch(function (er) {
                        loadPart.hide();
                        if (errNotice.response){
                            errSet(er.response.status);
                        }
                        else{
                            swallCustom(errNotice);
                        }
                    });
            },
            /*---------------- end get async detail ----------------*/

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
                    currentUrl = urlPage + (data.q !== '' ? '?q=' + data.q + '&cat=' : '?cat=') + data.cat + '&row=' + data.row + '&page=' + data.page;
                    history.pushState(data, "title", currentUrl);
                }
            };
        /*---------------- end handdler popstate looping ----------------*/

        $(document).ready(function () {
            currentUrl = urlPage +  (data.q !== '' ? '?q=' + data.q + '&cat=' : '?cat=') + data.cat + '&row=' + data.row + '&page=' + data.page;
            history.replaceState('', "", urlPage);
            history.pushState(data, "title", currentUrl);
            if (data.q !== qTarget.val()) {
                qTarget.val(data.q);
            }
            if (rowTarget.val() !== data.row && findInArray(rowAvail, data.row)) {
                rowTarget.val(data.row);
            }
            if (data.cat !== categoryTarget && findInArray(catAvail, data.cat)) {
                categoryTarget.val(data.cat);
            }
            getListAsync();
        });

        /*--------------set async history with pop---------*/
        window.addEventListener('popstate', e => {
            if (modalTarget.is(':visible')) {
                window.history.forward();
                hideModalFull();
            } else if (e.state !== '') {
                categoryTarget.val(e.state.cat);
                qTarget.val(e.state.q);
                data = e.state;
                getListAsync();

            } else {
                history.back();
            }
        });
        /*--------------end set async history with pop---------*/

        categoryTarget.on('change', function () {
            let changeCate = categoryTarget.val(),
                codition = changeCate === data.cat,
                codition2 = 1 === data.page;
            data.cat = changeCate;
            data.page = 1;
            changeVar(codition === true && codition2 === true ? true : null);
        });

        contentRight.on('submit', 'form', function (e) {
            e.preventDefault();
            let formFill = new FormData($(this)[0]);
            loadPart.show();
            contentRight.find('.help-block').text('');
            axios.post(urlApi + 'make-user', formFill)
                .then(function (res) {
                    loadPart.hide();
                    contentRight.find('input').val('');
                    contentRight.find('select').prop('selectedIndex', 0);
                    swallCustom(sucNotice);
                })
                .catch(function (er) {
                    let erNo = er.response.status;
                    loadPart.hide();
                    if (erNo === 422) {
                        swallCustom(fillNotice);
                        $.each(er.response.data, function (i, val) {
                            $('[name=' + i + ']').next().text(val);
                        })
                    } else {
                        swallCustom(errNotice);
                    }
                });
            return false;
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

        triggerHideModal.on('click', function () {
            hideModalFull();
        });

        relHub.on('click', 'h5', function () {
            let subData = $(this).data('fill');
            console.log(subData);
            if (subData) {
                detailAsync(subData);
            }
        });

        targetList.on('click', showModal, function () {
            loadPart.show();
            detailAsync({
                cat: data.cat,
                key: $(this).closest('.card-img').data('key')
            });
        });
        addUser.on('click', function () {
            showModalFull();
        });
        qTarget.keyup(function (e) {
            if (e.keyCode === 13) {
                btnSearch.trigger("click");
            }
        });


    });
}