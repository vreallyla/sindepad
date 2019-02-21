if ($('body').find('#fundraising').length > 0) {
    $(function () {
        const targetAddInfo = $('.opsi-list').find('.btn-li')
            , targetObj = $('#fundraising')
            , modalTarget = targetObj.find('.modal-full')
            , urlApi = '/api/v1/admin/fundraising/record/'
            , urlPage = '/simdepad/admin/fundraising/list'
            , rowTarget = targetObj.find('select[name=entity]')
            , qTarget = targetObj.find('input[name=search]')
            , categoryTarget = targetObj.find('select[name=category]')
            , btnSearch = qTarget.next().children('button')
            , showModal = 'label', delRecord = '.exc-btn-sud'
            , rowAvail = [9, 27, 45], objMain = $('.card-mod,.paginated'), loadingMagnify = targetObj.find('.loading')
            , noticeGroup = $('.error-notice,.not-found-notice')
            , targetList = targetObj.find('.card-mod')
            , targetPage = targetObj.find('.paginate')
            , triggerHideModal = targetObj.find('.btn-back'), myOptions = {
                digitGroupSeparator: '.',
                decimalCharacter: ',',
                maximumValue: '999999999999999',
                minimumValue: '0',
                currencySymbol: 'Rp. '
            }, curentRp = $('.input-rp')
        ;

        let data = {
                page: getUrlParameter('page') ? getUrlParameter('page') : 1,
                row: getUrlParameter('row') ? getUrlParameter('row') : rowTarget.val(),
                cat: getUrlParameter('cat') ? getUrlParameter('cat') : categoryTarget.val(),
                q: getUrlParameter('q') ? getUrlParameter('q') : qTarget.val()
            }, catAvail = [], currentTable, maxTable,
            checkpop = function (clickPage) {
                let codition = clickPage === data.page;
                data.page = clickPage;
                changeVar(codition);
            },
            changeVar = function (codi) {
                getListAsync();
                if (!codi) {
                    history.pushState(data, "title", urlPage + (data.q !== '' ? '?q=' + data.q + '&cat=' : '?cat=') + data.cat + '&row=' + data.row + '&page=' + data.page);
                }
            }
            , getCate = function () {
                const urlSide = 'key';
                axios.get(urlApi + urlSide)
                    .then(res => {
                        catAvail = res.data;
                    }).catch(er => {
                    erra(er.response);
                })
            }
            , getListAsync = function () {
                const urlSide = 'list';
                objMain.hide();
                loadingMagnify.show();
                noticeGroup.hide();
                axios.get(urlApi + urlSide, {params: data})
                    .then(res => {
                        console.log(res);
                        let cloneTart = targetList.children().clone(),
                            writeClone = cloneTart.eq(0);
                        targetList.empty();
                        $.each(res.data.data, function (i, val) {
                            let rpNom = convertRp(val.target),
                                rpGet = convertRp(val.collected);
                            writeClone.find('img').prop('src', val.img).parent().next().next().children('h3')
                                .text(val.name.length > 12 ? val.name.substr(0, 12) + '..' : val.name)
                                .prop('title', val.name.length > 12 ? val.name : '')
                                .next().children('h5').text('Target: Rp ' + (val.target > 999 ? rpNom.substr(0, (rpNom.length - 4)) + 'K' : rpNom))
                                .next().prop('title', 'Dapat: Rp ' + (val.collected > 999 ? rpGet.substr(0, (rpGet.length - 4)) + 'K' : rpGet))
                                .children('.determinate').css('width', (val.collected * 100 / val.target) + '%');

                            targetList.append('<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 card-img">' +
                                cloneTart[0].innerHTML +
                                '</div>');
                            targetList.children().eq(i).data('key', val.key);
                        });
                        currentTable = parseInt(res.data.current_page);
                        maxTable = parseInt(res.data.max_page);
                        setPagination(targetPage, maxTable, currentTable);
                        objMain.fadeIn(300);
                        loadingMagnify.hide();
                    }).catch(er => {
                    noticeListTable(er.response);
                })
            }
        ;

        $(document).ready(function () {
            console.log(rowTarget);
            history.replaceState('', "", urlPage);
            history.pushState(data, "title", urlPage + (data.q !== '' ? '?q=' + data.q + '&cat=' : '?cat=') + data.cat + '&row=' + data.row + '&page=' + data.page);
            if (data.q !== qTarget.val()) {
                qTarget.val(data.q);
            }
            if (rowTarget.val() !== data.row && findInArray(rowAvail, data.row)) {
                rowTarget.val(data.row);
            }
            if (data.cat !== categoryTarget) {
                categoryTarget.val(data.cat);
            }
            curentRp.autoNumeric('init', myOptions);
            getCate();
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
                categoryTarget.val(e.state.cat);
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

        btnSearch.on('click', function () {
            let clickSearch = qTarget.val(),
                codition = clickSearch === data.q, codition2 = 1 === data.page;

            data.q = clickSearch;
            data.page = 1;
            changeVar(codition === true && codition2 === true ? true : null);
        });

        categoryTarget.on('change', function () {
            let changeCate = categoryTarget.val(),
                codition = changeCate === data.cat,
                codition2 = 1 === data.page;
            data.cat = changeCate;
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
                    checkpop(currentTable === maxTable ? 1 : (currentTable + 1));
                } else if ($(this).hasClass('sub-next-page')) {
                    checkpop(parseInt($(this).prev().children().children('.hal').text()) + 1);
                } else if ($(this).hasClass('sub-prev-page')) {
                    checkpop(parseInt($(this).next().children().children('.hal').text()) - 1);
                } else {
                    swallCustom('Harap tidak merubah dataa');
                    setTimeout(e => {
                        location.reload();
                    }, 500);
                }
            }
        });

        qTarget.keyup(function (e) {
            if (e.keyCode === 13) {
                btnSearch.trigger("click");
            }
        });

        targetAddInfo.click(function () {
            modalTarget.find('img').css('display', 'none');
            modalTarget.find('input').val('');
            tinymce.activeEditor.setContent('');
            $('.modal-full').find('.add-img-modal').children().eq(0).removeClass().addClass('fa fa-plus-square').next().text('Tambah Gambar');
            modalTarget.find('.btn-add-sub').text('Tambah Penggalangan').data('key', '');
            showModalFull();
            removeHelpBlock(modalTarget);
            curentRp.autoNumeric('set', '');
        });

        modalTarget.on('click', '.btn-add-sub', function () {
            modalTarget.find('form').trigger('submit');
        });

        targetList.on('click', delRecord, function () {
            if (permissionsDel()) {
                showLoading();
                const urlSide = 'delete';
                axios.delete(urlApi + urlSide, {params: {key: $(this).closest('.card-img').data('key')}})
                    .then(res => {
                        hideLoading();
                        swallCustom(res.data.msg);
                        getListAsync()
                    }).catch(er => {
                    erra(er.response);
                })
            }
        });

        modalTarget.on('submit', 'form', function (e) {
            e.preventDefault();
            let v = curentRp.autoNumeric('get');
            curentRp.val(v);
            let urlSide = ''
                , formFunc = new FormData($(this)[0])
                , funKet = modalTarget.find('.btn-add-sub').data('key')
            ;
            removeHelpBlock(modalTarget);
            if (funKet) {
                urlSide = 'update';
                formFunc.append('_method', 'PATCH');
                formFunc.append('key', funKet);
            } else {
                urlSide = 'post';
                data.page = 1;
            }
            formFunc.append('detail', tinyMCE.activeEditor.getContent());
            showLoading();
            axios.post(urlApi + urlSide, formFunc)
                .then(res => {
                    hideLoading();
                    swallCustom(res.data.msg);
                    hideModalFull();
                    setTimeout(function () {
                        getListAsync();
                    }, 500);
                }).catch(er => {
                erInputCusOthersa(er.response, modalTarget.find('form'));
            });
            // curentRp.autoNumeric('init', myOptions);
        });


        targetList.on('click', showModal, function () {

            const urlSide = 'edit';
            showLoading();
            removeHelpBlock(modalTarget);
            axios.get(urlApi + urlSide, {
                params: {
                    key: $(this).closest('.card-img').data('key')
                }
            }).then(res => {
                hideLoading();
                modalTarget.find('img').prop('src', res.data.img).css('display', 'block');
                modalTarget.find('.add-img-modal').children().eq(0).removeClass().addClass('fa fa-edit').next().text('Rubah Gambar');
                modalTarget.find('.btn-add-sub').text('Rubah informasi').data('key', res.data.key);
                modalTarget.find('[name="name"]').val(res.data.name);
                modalTarget.find('[name="status"]').val(res.data.category);
                tinymce.activeEditor.setContent(res.data.detail);
                $('.input-rp').autoNumeric('set', res.data.target);
                showModalFull();
            }).catch(er => {
                console.log(er);
                erra(er.response);
            });
        });

        triggerHideModal.on('click', function () {
            hideModalFull();
            setTimeout(function () {
                getListAsync();
            }, 500);
        });

    });
    window.readURL = function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.modal-full').find('img').prop('src', e.target.result).css('display', 'block');
                $('.modal-full').find('.add-img-modal').children().eq(0).removeClass().addClass('fa fa-edit').next().text('Rubah Gambar');

            };
            reader.readAsDataURL(input.files[0]);

        }
    }
}
