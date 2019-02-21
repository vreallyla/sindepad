if ($('body').find('#detail-fundraising').length > 0) {
    $(function () {
        const targetObj = $('#detail-fundraising'),
            rowTarget = targetObj.find('select[name=entity]'),
            categoryTarget = targetObj.find('select[name=category]'),
            qTarget = targetObj.find('input[name=search]'),
            btnSearch = qTarget.next().children('button'),
            targetTable = targetObj.find('tbody'),
            loadPart = $('#loading'),
            errNotice = 'terdapat kesalahan. silakan muat ulang / kontak admin',
            nullNotice = "Belum diisi",
            manipNotice = "Harap tidak merubah data",
            fillTable = targetTable.children('tr'),placeRight = $('.place-right'),
            rowAvail = [10, 30, 50], modalpage = $('#modal-container'),
            targetPage = targetObj.find('.paginate'),
            loadingMagnify = targetObj.find('.loading'),
            tableLabel = targetObj.find('.table-register'),
            urlPage = '/simdepad/admin/fundraising/contributor',
            urlApi = '/api/v1/admin/fundraising/'
            , myOptions = {
                digitGroupSeparator: '.',
                decimalCharacter: ',',
                maximumValue: '999999999999999',
                minimumValue: '0',
                currencySymbol: 'Rp. '
            }, curentRp = $('.input-rp')
            , catN = [
                'belum',
                'sudah'
            ], enN = [
                'unverified',
                'verified'
            ];

        let data = {
                page: getUrlParameter('page') ? getUrlParameter('page') : 1,
                row: getUrlParameter('row') ? getUrlParameter('row') : rowTarget.val(),
                cat: getUrlParameter('cat') ? getUrlParameter('cat') : categoryTarget.val(),
                q: getUrlParameter('q') ? getUrlParameter('q') : qTarget.val()
            }, currentTable, maxTable,
            removeModal = function () {
                modalpage.addClass('out');
                $('body').removeClass('preloader-site');
            },
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
            },
            getListAsync = function () {
                let tableClone = fillTable.clone(),
                    editClone = tableClone.eq(0);
                loadingMagnify.show();
                tableLabel.hide();
                $('.not-found-notice, .error-notice').hide();
                axios.get(urlApi + 'list', {
                    params: data
                }).then(res => {
                    loadingMagnify.hide();
                    let tableClone = fillTable.clone(),
                        editClone = tableClone.eq(0),
                        datalist = res.data.data;
                    targetTable.empty();
                    $.each(datalist, function (i, val) {

                        editClone.children().eq(0).text(val.pp)
                            .next().text(val.source.substr(0, 9) + '...').prop('title', val.source)
                            .next().text('Rp' + convertRp(val.nominal > 999 ? val.nominal.substr(0, (val.nominal.length - 3)) : val.nominal) + 'K')
                            .prop('title', 'Rp' + convertRp(val.nominal))
                            .next().text(val.email.substr(0, 9) + '...')
                            .prop('title', val.email)
                            .next().text(moment(val.date).format("Do MMM YYYY"))
                            .next().children('span').text(catN[enN.indexOf(val.category)]);

                        targetTable.append('<tr>' + tableClone[0].innerHTML + '</tr>');
                        $('.selectpicker').selectpicker("refresh");
                        targetObj.find('tbody').children().eq(i).data('key', val.key)
                            .data('img', val.img)
                            .find('.selectpicker').selectpicker('val', val.category);

                        targetTable.children().eq(i).find('.add').children().eq(1).hide();
                    });
                    tableLabel.fadeIn(300);

                    currentTable = parseInt(res.data.current_page);
                    maxTable = parseInt(res.data.max_page);
                    setPagination(targetPage, res.data.max_page, res.data.current_page);
                }).catch(function (er) {
                    loadingMagnify.hide();
                    console.log(er);
                    noticeListTable(er.response);
                });
            };

        $(document).ready(function () {
            $('.datepicker').datepicker({
                language: 'id',
                format: 'yyyy-mm-dd'
            });
            curentRp.autoNumeric('init', myOptions);
            if (data.q !== qTarget.val()) {
                qTarget.val(data.q);
            }
            if (rowTarget.val() !== data.row && findInArray(rowAvail, data.row)) {
                rowTarget.val(data.row);
            }
            if (data.cat !== categoryTarget) {
                categoryTarget.val(data.cat);
            }
            history.replaceState('', "", urlPage);
            history.pushState(data, "title", urlPage + (data.q !== '' ? '?q=' + data.q + '&cat=' : '?cat=') + data.cat + '&row=' + data.row + '&page=' + data.page);
            getListAsync();
        });

        /*--------------set async history with pop---------*/
        window.addEventListener('popstate', e => {
            if (e.state !== '') {
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

        targetTable.on('click', '.btn-info', function () {
            $(this).removeClass('btn-info').addClass('btn-danger').hide().fadeIn(300).text('save').blur().closest('tr')
                .find('.add').children().eq(0).hide().next().fadeIn(300);
        });

        targetTable.on('click', '.btn-danger', function () {
            let labelStudent = $(this).closest('tr'),
                dataStident = labelStudent.data('key'),
                valStudent = labelStudent.find('select').val(),
                dataStu = {
                    key_cont: dataStident,
                    key_status: valStudent
                };
            loadPart.show();
            axios.put(urlApi + 'change', dataStu)
                .then(res => {
                    loadPart.hide();
                    swallCustom(res.data.msg);
                    $(this).removeClass('btn-danger').addClass('btn-info').hide().fadeIn(300).text('edit').blur().closest('tr')
                        .find('.add').children().eq(0).fadeIn(300).next().hide();
                    getListAsync();
                }).catch(er => {
                loadPart.hide();
                er.response.status === 422 ? swallCustom(manipNotice) : swallCustom(errNotice);
            });
        });

        placeRight.on('submit', 'form', function (e) {
            e.preventDefault();
            let v = curentRp.autoNumeric('get');
            curentRp.val(v);
            let urlSide = 'post'
                , formFunc = new FormData($(this)[0])
            ;

            removeHelpBlock(placeRight);
            showLoading();

            axios.post(urlApi + urlSide, formFunc)
                .then(res => {
                    hideLoading();
                    swallCustom(res.data.msg);
                    hideContentRight();
                    setTimeout(function () {
                        getListAsync();
                    }, 500);

                    $(this)[0].reset();
                    $(this).find('.selecpicker').selectpicker('val','');
                }).catch(er => {
                console.log(er);
                erInputCus(er.response, placeRight);
            });
            // curentRp.autoNumeric('init', myOptions);
        });


        /*---------------- modal photo ----------------*/
        targetTable.on('click', '.btn-dark', function () {
            var buttonId = 'one';
            modalpage.removeAttr('class').addClass(buttonId).find('img').prop('src', $(this).closest('tr').data('img'));
            $('body').addClass('preloader-site');
        });

        modalpage.on('click', '.modal', function () {
            return false;
        });

        modalpage.click(removeModal);

        modalpage.find('.modal').on('click', 'a', removeModal);

        /*-------------- end modal photo --------------*/

        qTarget.keyup(function (e) {
            if (e.keyCode === 13) {
                btnSearch.trigger("click");
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

    });
}
