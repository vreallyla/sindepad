if ($('Body').find('#setting-shadows').length > 0) {
    $(function () {
        const targetObj = $('#setting-shadows'),
            rowTarget = targetObj.find('select[name=entity]'),
            categoryTarget = targetObj.find('select[name=category]'),
            qTarget = targetObj.find('input[name=search]'),
            btnSearch = qTarget.next().children('button'),
            targetTable = targetObj.find('tbody'),
            loadPart = $('#loading'),
            errNotice = 'terdapat kesalahan. silakan muat ulang / kontak admin',
            nullNotice = "Belum diisi",
            manipNotice = "Harap tidak merubah data",
            fillTable = targetTable.children('tr'),
            rowAvail = [10, 30, 50], catAvail = ['Belum Diatur', 'Sudah Diatur'],
            targetPage = targetObj.find('.paginate'),
            loadingMagnify = targetObj.find('.loading'),
            tableLabel = targetObj.find('.table-register'),
            urlPage = '/simdepad/admin/student-config/shadow',
            urlApi = '/api/v1/admin/settings/';

        let data = {
                page: getUrlParameter('page') ? getUrlParameter('page') : 1,
                row: getUrlParameter('row') ? getUrlParameter('row') : rowTarget.val(),
                cat: getUrlParameter('cat') ? getUrlParameter('cat') : categoryTarget.val(),
                q: getUrlParameter('q') ? getUrlParameter('q') : qTarget.val()
            },currentTable, maxTable,
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
                axios.get(urlApi + 'shadows-list', {
                    params: data
                }).then(res => {
                    loadingMagnify.hide();
                    let tableClone = fillTable.clone(),
                        editClone = tableClone.eq(0),
                        datalist = res.data.data;
                    targetTable.empty();
                    $.each(datalist, function (i, val) {
                        editClone.children().eq(0).text(val.numb_regist)
                            .next().children().text(val.name.length > 10 ? val.name.substr(0, 9) + '..' : val.name)
                            .prop('title', val.name.length > 10 ? val.name : '').parent()
                            .next().text(val.needed)
                            .next().find('[data-toggle="tooltip"]').text(val.shadow ? (val.shadow.name.length > 17 ? val.shadow.name.substr(0, 15) + '..' : val.shadow.name) : nullNotice)
                            .prop('title', val.shadow ? (val.shadow.name.length > 10 ? val.shadow.name : '') : nullNotice)
                            .next().hide().closest('td')
                            .next().find('span').text(val.status ? val.status.notice : nullNotice)
                            .prop('title', val.status.date ? moment(val.status.date.date).format("Do MMM YYYY") : nullNotice)
                        ;
                        targetTable.append('<tr>' + tableClone[0].innerHTML + '</tr>');
                        $('.selectpicker').selectpicker("refresh");
                        targetObj.find('tbody').children().eq(i).data('key', val.key).find('select.selectpicker').selectpicker('refresh');

                        targetTable.children().eq(i).find('.add').children().eq(1).hide();
                    });

                    for (let i = 0; i < datalist.length; i++) {
                        if (datalist[i].shadow) {
                            let targetSelSearch = targetObj.find('tbody').children().eq(i).find('.add'),
                                selValSearch = targetSelSearch.find('option[value=' + (datalist[i].shadow ? datalist[i].shadow.key : '') + ']');
                            targetSelSearch.find('.filter-option-inner-inner').text(selValSearch.text());
                            selValSearch.parent().val(datalist[i].shadow ? datalist[i].shadow.key : '');
                        }
                    }
                    tableLabel.fadeIn(300);

                    currentTable = parseInt(res.data.current_page);
                    maxTable = parseInt(res.data.max_page);
                    setPagination(targetPage, res.data.max_page, res.data.current_page);
                }).catch(function (er) {
                    loadingMagnify.hide();
                    noticeListTable(er.response);
                });
            };

        $(window).ready(e => {
            if (data.q !== qTarget.val()) {
                qTarget.val(data.q);
            }
            if (rowTarget.val() !== data.row && findInArray(rowAvail, data.row)) {
                rowTarget.val(data.row);
            }
            if (data.cat !== categoryTarget && findInArray(catAvail, data.cat)) {
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
                    key_student: dataStident,
                    key_shadow: valStudent
                };
            loadPart.show();
            axios.put(urlApi + 'shadows-change', dataStu)
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