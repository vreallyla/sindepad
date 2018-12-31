if ($('body').find('#news-categories').length > 0) {
    $(function () {
        const urlPage = '/simdepad/admin/news/categories',
            urlApi = '/api/v1/admin/news/categories/',
            targetObj = $('#news-categories'),
            placeRight = $('.place-right'),
            qTarget = targetObj.find('input[name=search]'),
            tableLabel = targetObj.find('.table-register'),
            rowTarget = targetObj.find('select[name=entity]'),
            triggerRight = $('.trigger-right'),
            btnSearch = qTarget.next().children('button'),
            rowAvail = [10, 30, 50],
            noticeGroup = $('.error-notice,.not-found-notice'),
            targetTable = targetObj.find('tbody'),
            targetPage = targetObj.find('.paginate'),
            loadingMagnify = targetObj.find('.loading'),
            loadPart = $('#loading');

        let data = {
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
                            .next().children().text(val.desc.length > 50 ? val.desc.substr(0, 48) + '..' : val.desc)
                            .prop('title', (val.desc.length > 50 ? val.desc : ''));

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
            /* if (modalTarget.is(':visible')) {
                 window.history.forward();
                 hideModalFull();
             } else*/
            if (e.state !== '') {
                rowTarget.val(e.state.row);
                qTarget.val(e.state.q);
                data = e.state;
                getListAsync();

            } else {
                history.back();
            }
        });
        /*--------------end set async history with pop---------*/

        placeRight.on('submit', 'form', function (e) {
            e.preventDefault();
            let urlSide;
            let formFunc = new FormData($(this)[0]),
                keyVal = placeRight.find('button').data('key');

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

        tableLabel.on('click', '.fa-edit', function () {
            const urlSide = 'edit';
            loadPart.show();
            axios.get(urlApi + urlSide + '?key=' + $(this).closest('tr').data('key'))
                .then(res => {
                    loadPart.hide();
                    $.each(res.data, function (i, val) {
                        placeRight.find('[name="' + i + '"]').val(val);
                    });
                    placeRight.find('button').data('key', res.data.id);
                    placeRight.addClass('activo');
                    triggerRight.addClass('non');
                }).catch(er => {
                erra(er.response);
            })
        });

        triggerRight.click(function () {
            placeRight.find('input,textarea').val('');
        });

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


    });

}
