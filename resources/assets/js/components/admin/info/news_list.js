if ($('body').find('#news-list').length > 0) {
    $(function () {
        const targetObj = $('#news-list'),
            urlApi = '/api/v1/admin/news/record/',
            rowTarget = targetObj.find('select[name=entity]'),
            qTarget = targetObj.find('input[name=search]'),
            categoryTarget = targetObj.find('select[name=category]'),
            loadPart = $('#loading'),
            btnSearch = qTarget.next().children('button'),
            modalTarget = targetObj.find('.modal-full'),
            urlPage = '/simdepad/admin/news/list',
            showModal = 'label', delRecord = '.exc-btn-sud',
            rowAvail = [9, 27, 45],
            targetList = targetObj.find('.card-mod'),
            objMain = $('.card-mod,.paginated'), loadingMagnify = targetObj.find('.loading'),
            targetPage = targetObj.find('.paginate'),
            noticeGroup = $('.error-notice,.not-found-notice'),
            triggerHideModal = targetObj.find('.btn-back'),
            targetAddInfo = $('.opsi-list').find('.btn-li');


        let data = {
                page: getUrlParameter('page') ? getUrlParameter('page') : 1,
                row: getUrlParameter('row') ? getUrlParameter('row') : rowTarget.val(),
                cat: getUrlParameter('cat') ? getUrlParameter('cat') : categoryTarget.val(),
                q: getUrlParameter('q') ? getUrlParameter('q') : qTarget.val()
            }, catAvail = [], currentTable,
            maxTable,
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
                        $.each(res.data, function (i, val) {
                            catAvail.push(val.id);
                        });
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
                        let cloneTart = targetList.children().clone(),
                            writeClone = cloneTart.eq(0);
                        targetList.empty();
                        $.each(res.data.data, function (i, val) {
                            let creDiv = document.createElement("div");

                            writeClone.find('img').prop('src', val.img).parent().next().next().children('h3')
                                .text(val.name.length > 12 ? val.name.substr(0, 12) + '..' : val.name)
                                .prop('title', val.name.length > 12 ? val.name : '')
                                .next().text(moment(val.created_at.date).format("ddd, DD MMM YY"));

                            targetList.append('<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 card-img">' +
                                cloneTart[0].innerHTML +
                                '</div>');
                            targetList.children().eq(i).data('key', val.id);
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
            //add bug
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
                    swallCustom('Harap tidak merubah data');
                    setTimeout(e => {
                        location.reload();
                    }, 500);
                }
            }
        });

        targetAddInfo.click(function () {
            modalTarget.find('img').css('display', 'none');
            modalTarget.find('input').val('');
            modalTarget.find('select').selectpicker('val', '');
            tinymce.activeEditor.setContent('');
            removeHelpBlock(modalTarget);
            $('.modal-full').find('.add-img-modal').children().eq(0).removeClass().addClass('fa fa-plus-square').next().text('Tambah Gambar');
            modalTarget.find('.btn-add-sub').text('tambah informasi').data('key', '');
            showModalFull();
        });

        modalTarget.on('submit', 'form', function (e) {
            e.preventDefault();
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
            }
            formFunc.append('desc', tinyMCE.activeEditor.getContent());
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
            })
        });

        modalTarget.on('click', '.btn-add-sub', function () {
            modalTarget.find('form').trigger('submit');
        });


        triggerHideModal.on('click', function () {
            hideModalFull();
            setTimeout(function () {
                getListAsync();
            }, 500);
        });

        qTarget.keyup(function (e) {
            if (e.keyCode === 13) {
                btnSearch.trigger("click");
            }
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

        targetList.on('click', showModal, function () {

            const urlSide = 'edit';
            showLoading();
            removeHelpBlock(modalTarget);
            axios.get(urlApi + urlSide, {
                params: {
                    key: $(this).closest('.card-img').data('key')
                }
            }).then(res => {
                let arrCat = [];
                hideLoading();
                modalTarget.find('img').prop('src', res.data.img).css('display', 'block');
                modalTarget.find('.add-img-modal').children().eq(0).removeClass().addClass('fa fa-edit').next().text('Rubah Gambar');
                modalTarget.find('.btn-add-sub').text('Rubah informasi').data('key', res.data.id);
                modalTarget.find('[name="name"]').val(res.data.name);
                tinymce.activeEditor.setContent(res.data.desc);

                $.each(res.data.category, function (i, val) {
                    arrCat.push(val.id);
                });
                $('.selectpicker').selectpicker('val', arrCat);

                showModalFull();

            }).catch(er => {
                erra(er.response);
            });
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

