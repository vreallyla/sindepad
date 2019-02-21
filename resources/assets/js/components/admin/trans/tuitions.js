if ($('body').find('#tuition').length > 0) {
    $(function () {
        const urlPage = '/simdepad/admin/transactions/monthly-tuition',
            targetObj = $('#tuition'),
            rowTarget = targetObj.find('select[name=entity]'),
            qTarget = targetObj.find('input[name=search]'),
            targetPage = targetObj.find('.paginate'),
            urlApi = '/api/v1/admin/transactions/tuitions/',
            loadPart = $('#loading'),
            objMain = $('.card-mod,.paginated'), loadingMagnify = targetObj.find('.loading'),
            tableLabel = targetObj.find('.table-register'),
            btnSearch = qTarget.next().children('button'),
            rowAvail = [10, 30, 50],
            noticeGroup = $('.error-notice,.not-found-notice'),
            targetTable = targetObj.find('tbody');


        let data = {
                page: getUrlParameter('page') ? getUrlParameter('page') : 1,
                row: getUrlParameter('row') ? getUrlParameter('row') : rowTarget.val(),
                q: getUrlParameter('q') ? getUrlParameter('q') : qTarget.val()
            }, currentTable, maxTable,

            getDataAsync = function () {
                const urlSub = 'list';

                tableLabel.hide();
                noticeGroup.hide();
                loadingMagnify.show();

                axios.get(urlApi + urlSub, {params: data})
                    .then(res => {
                        let
                            TargetClone = targetTable.children().clone(),
                            editCLone = TargetClone.eq(0),
                            fragment = document.createDocumentFragment();

                        tableLabel.fadeIn(300);
                        loadingMagnify.hide();

                        $.each(res.data.data, function (i, val) {
                            tr = document.createElement("tr");
                            editCLone.children().eq(0).text(val.ni).next().text(val.name)
                                .next().text(val.gender)
                                .next().text(moment(val.regist.date).format('ddd, Do MMM YY'))
                                .next().text(moment(val.exp_date.date).format('ddd, Do MMM YY'));

                            $(tr).append(TargetClone[0].innerHTML).data('key', val.key);
                            fragment.appendChild(tr);
                        });
                        //
                        targetTable.html(fragment);
                        currentTable = parseInt(res.data.current_page);
                        maxTable = parseInt(res.data.max_page);
                        setPagination(targetPage, res.data.max_page, res.data.current_page);
                    }).catch(er => {
                    loadingMagnify.hide();
                    if (er.response) {
                        if (er.response.status === 403 || er.response.status === 422) {
                            $('.not-found-notice').fadeIn(300);
                        } else {
                            $('.error-notice').fadeIn(300);
                        }
                    } else {
                        $('.error-notice').fadeIn(300);

                    }
                });
            },
            checkpop = function (clickPage) {
                let codition = clickPage === data.page;
                data.page = clickPage;
                changeVar(codition);
            },
            changeVar = function (codi) {
                getDataAsync();
                if (!codi) {
                    history.pushState(data, "title", urlPage + (data.q !== '' ? '?q=' + data.q + '&row=' : '?row=') + data.row + '&page=' + data.page);
                }
            }
        ;

        history.replaceState('', "", urlPage);
        history.pushState(data, "title", urlPage + (data.q !== '' ? '?q=' + data.q + '&row=' : '?row=') + data.row + '&page=' + data.page);

        $(document).ready(function () {
            if (data.q !== qTarget.val()) {
                qTarget.val(data.q);
            }
            if (rowTarget.val() !== data.row && findInArray(rowAvail, data.row)) {
                rowTarget.val(data.row);
            }

            getDataAsync();
        });

        /*--------------set async history with pop---------*/
        window.addEventListener('popstate', e => {
            /*if (modalTarget.is(':visible')) {
                window.history.forward();
                hideModalFull();
            } else*/
            if (e.state !== '') {
                rowTarget.val(e.state.row);
                qTarget.val(e.state.q);
                data = e.state;
                getDataAsync();

            } else {
                history.back();
            }
        });
        /*--------------end set async history with pop---------*/

        qTarget.keyup(function (e) {
            if (e.keyCode === 13) {
                btnSearch.trigger("click");
            }
        });

        btnSearch.on('click', function () {
            let clickSearch = qTarget.val(),
                codition = clickSearch === data.q, codition2 = 1 === data.page;

            data.q = clickSearch;
            data.page = 1;
            changeVar(codition === true && codition2 === true ? true : null);
        });

        targetObj.on('click', 'li', function () {
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

        rowTarget.on('change', function () {
            let changeCate = rowTarget.val(),
                codition = changeCate === data.row,
                codition2 = 1 === data.page;
            data.row = changeCate;
            data.page = 1;
            changeVar(codition === true && codition2 === true ? true : null);
        });


        targetTable.on('click', '.btn-info', function () {
            const urlSide = 'deal';
            loadPart.show();
            axios.put(urlApi + urlSide, {key: $(this).closest('tr').data('key')})
                .then(res => {
                    loadPart.hide();
                    swallCustom(res.data.msg);
                    getDataAsync();
                }).catch(er => {
                loadPart.hide();
                erra(er.response);
            });
        });

    });
}
