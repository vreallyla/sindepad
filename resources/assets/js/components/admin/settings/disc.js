if ($('body').find('#trans-disc').length > 0) {

    $(function () {
        const targetObj = $('#trans-disc'), placeRight = $('.place-right'),
            con = 'percent',
            urlApi = '/api/v1/admin/settings/voucher/',
            rowTarget = targetObj.find('select[name=entity]'),
            categoryTarget = targetObj.find('select[name=category]'),
            qTarget = targetObj.find('input[name=search]'),
            rowAvail = [10, 30, 50], catAvail = ['percent', 'cash'],
            targetPage = targetObj.find('.paginate'),
            tableLabel = targetObj.find('.table-register'),
            tableTarget = tableLabel.find('tbody'),
            triggerRight = $('.trigger-right'),
            btnSearch = qTarget.next().children('button'),
            urlPage = '/simdepad/admin/settings/discon-set',
            setDatePicker = $('.datepicker'), percentOp = {
                // digitGroupSeparator: '.',
                // decimalCharacter: ',',
                maximumValue: '100',
                minimumValue: '0',
                // currencySymbol: 'Rp. ',
                currencySymbol: '%',
                currencySymbolPlacement: 's'
            }, rpOp = {
                digitGroupSeparator: '.',
                decimalCharacter: ',',
                maximumValue: '999999999',
                minimumValue: '0',
                currencySymbol: 'Rp. ',
                currencySymbolPlacement: 'p'
            },
            loadingMagnify = targetObj.find('.loading'),
            loadPart = $('#loading');

        let data = {
                page: getUrlParameter('page') ? getUrlParameter('page') : 1,
                row: getUrlParameter('row') ? getUrlParameter('row') : rowTarget.val(),
                cat: getUrlParameter('cat') ? getUrlParameter('cat') : categoryTarget.val(),
                q: getUrlParameter('q') ? getUrlParameter('q') : qTarget.val()
            }
            ,
            checkpop = function (clickPage) {
                let codition = clickPage === data.page;
                data.page = clickPage;
                changeVar(codition);
            },
            changeVar = function (codi) {
                getDataAsync();
                if (!codi) {
                    history.pushState(data, "title", urlPage + (data.q !== '' ? '?q=' + data.q + '&cat=' : '?cat=') + data.cat + '&row=' + data.row + '&page=' + data.page);
                }
            }
            , getDataAsync = function () {
                const urlSide = 'list';
                loadingMagnify.show();
                tableLabel.hide();
                hideNoce();
                axios.get(urlApi + urlSide, {
                    params: data
                }).then(res => {
                    let cloneEl = tableTarget.clone(),
                        editCLone = cloneEl.children().eq(0),
                        fragment = document.createDocumentFragment(),
                        dataN = res.data;
                    $.each(dataN.data, function (i, val) {
                        let creTr = document.createElement("tr");
                        editCLone.children().eq(0).text(val.voucher)
                            .next().addClass(val.tag === con ? 'add-percentage' : 'add-rp')
                            .text(val.tag === con ? val.amount : convertRp(val.amount))
                            .next().text(moment(val.created_at).format('ddd, D MMM YYYY'))
                            .next().text(moment(val.expired).format('ddd, D MMM YYYY'))
                            .next().children().text(val.status).prop('title', val.remaining)
                            .removeClass().addClass('label '+(val.status==='Aktif'?'label-info':'label-danger'));

                        $(creTr).append(cloneEl.children()[0].innerHTML).data('key', val.key);
                        fragment.appendChild(creTr);
                    });

                    tableTarget.html(fragment);
                    showObjN(tableLabel);
                    setPagination(targetPage, res.data.last_page, res.data.current_page);

                }).catch(er => {
                    noticeListTable(er.response);
                });
            }
        ;
        $(document).ready(function () {
            history.replaceState('', "", urlPage);
            history.pushState(data, "title", urlPage + (data.q !== '' ? '?q=' + data.q + '&cat=' : '?cat=') + data.cat + '&row=' + data.row + '&page=' + data.page);
            placeRight.find('.input-rp').autoNumeric('init', rpOp);

            setDatePicker.datepicker({
                language: 'id',
                format: "yyyy-mm-dd",
                keyboardNavigation: false,
            });

            if (data.q !== qTarget.val()) {
                qTarget.val(data.q);
            }
            if (rowTarget.val() !== data.row && findInArray(rowAvail, data.row)) {
                rowTarget.val(data.row);
            }
            if (data.cat !== categoryTarget && findInArray(catAvail, data.cat)) {
                categoryTarget.val(data.cat);
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
                categoryTarget.val(e.state.cat);
                qTarget.val(e.state.q);
                data = e.state;
                getDataAsync();

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
        categoryTarget.on('change', function () {
            let changeCate = categoryTarget.val(),
                codition = changeCate === data.cat,
                codition2 = 1 === data.page;
            data.cat = changeCate;
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

        targetObj.on('click', 'li', function () {
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

        triggerRight.click(function () {
            placeRight.find('input').val('');
            placeRight.find('.btn-info').data('key', '').text('Daftarkan');
        });

        tableTarget.on('click', '.fa-edit', function () {
            const urlSide = 'edit';
            let $x = $(this), dataKey = $x.closest('tr').data();
            showLoading();
            axios.get(urlApi + urlSide, {
                params: dataKey
            }).then(res => {
                let dataN = res.data, triggerCon = placeRight.find('[name="con"]');
                hideLoading();
                placeRight.find('[name="voucher"]').val(dataN.voucher);
                placeRight.find('[name="amount"]').val(dataN.amount);
                placeRight.find('[name="expired"]').datepicker('update', moment(dataN.expired).format('YYYY-MM-DD'));
                placeRight.find('.btn-info').data('key', dataKey.key).text('Rubah');
                showContentRight();

                setTimeout(function () {
                    if (dataN.tag === con) {
                        if (!triggerCon.is(':checked')) {
                            triggerCon.trigger('click');
                        }
                    } else {
                        if (triggerCon.is(':checked')) {
                            triggerCon.trigger('click');
                        }
                    }
                }, 300);
                console.log(placeRight.find('.btn-info').data());

            }).catch(er => {
                console.log(er);
                console.log(er.response);
            });
        });
        tableTarget.on('click', '.fa-trash-o', function () {
            if (permissionsDel()) {
                const urlSide = 'delete';
                let $x = $(this), dataKey = $x.closest('tr').data('key');

                axios.delete(urlApi + urlSide, {params: {key: dataKey}})
                    .then(res => {
                        swallCustom(res.data.msg);
                        getDataAsync();
                    }).catch(er => {
                    erra(er.response);
                });
            }

        });


        placeRight.on('submit', 'form', function (e) {
            e.preventDefault();
            let $x = $(this), urlSide, formFunc = new FormData($x[0]),
                nominalN = $x.find('[name="amount"]').autoNumeric('get'),
                dataKey = $x.find('.btn-info').data('key');

            if (dataKey) {
                formFunc.append('_method', 'PUT');
                formFunc.append('key', dataKey);
                urlSide = 'update';
            } else {
                urlSide = 'create';
            }
            formFunc.set('amount', nominalN);
            showLoading();
            $x.find('.help-block').text('');

            axios.post(urlApi + urlSide, formFunc)
                .then(res => {
                    hideLoading();
                    swallCustom(res.data.msg);
                    getDataAsync();
                    if (dataKey) {
                        hideContentRight();
                    }
                }).catch(er => {
                console.log(er);
                erInput(er.response);
            })
        });
        placeRight.on('change', '[name="con"]', function () {
            let $this = $(this), targetEl = $this.closest('.form-group').find('[name="amount"]'),
                valInput = targetEl.autoNumeric('get');

            if ($this.is(':checked')) {
                targetEl.autoNumeric('set', valInput > 100 ? 100 : valInput);
                targetEl.autoNumeric('update', percentOp);
            } else {
                targetEl.autoNumeric('update', rpOp);
            }
        });

    });
}