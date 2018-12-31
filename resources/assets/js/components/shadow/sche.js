if ($('body').find('#student-schedule').length > 0) {
    $(function () {
        const targetObj = $('#student-schedule'),
            urlPage = '/simdepad/shadow/schedules/list',
            urlApi = '/api/v1/shadow/schedules/',
            placeRight = $('.place-right'),
            modalTarget = $('.modal-full'),
            targetDay = modalTarget.find('.grid'),
            targetAct = targetDay.find('.accord-con-detail'),
            qTarget = targetObj.find('input[name=search]'),
            tableLabel = targetObj.find('.table-register'),
            rowTarget = targetObj.find('select[name=entity]'),
            triggerRight = $('.trigger-right'),
            triggerHideModal = targetObj.find('.btn-back'),
            btnSearch = qTarget.next().children('button'),
            rowAvail = [10, 30, 50],
            noticeGroup = $('.error-notice,.not-found-notice'),
            targetTable = targetObj.find('tbody'),
            targetPage = targetObj.find('.paginate'),
            loadingMagnify = targetObj.find('.loading'),
            formSec = placeRight.find('form').eq(1),
            timeEnd = formSec.find('[name="time_end"]'),
            loadPart = $('#loading');

        let dataLabel, manS = $('.grid').masonry({
                // options
                itemSelector: '.grid-item',
                columnWidth: 2
            })
            , data = {
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
                            .next().children().text(val.desc.length > 28 ? val.desc.substr(0, 25) + '..' : val.desc)
                            .prop('title', (val.desc.length > 28 ? val.desc : ''));

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
            if (modalTarget.is(':visible')) {
                window.history.forward();
                hideModalFull();
                setTimeout(function () {
                    getListAsync();
                }, 200);
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

        tableLabel.on('click', '.btn-info', function () {
            const urlSide = 'detail';
            let cloneEl = targetDay.children().clone(),
                cloneList = targetAct.children().clone(),
                editCloneList = cloneList.eq(0),
                editCloneEl = cloneEl.eq(0);
            loadPart.show();
            axios.get(urlApi + urlSide, {
                params: {
                    'key': $(this).closest('tr').data('key')
                }
            }).then(res => {
                loadPart.hide();
                placeRight.removeClass('activo');
                showModalFull(tableLabel);
                triggerRight.addClass('non');
                let ser = manS.find('.grid-item'),
                    elems = [];
                for (let i = 0; i < ser.length; i++) {
                    manS.masonry('remove', ser.eq(i)).masonry('layout');
                }
                $.each(res.data, function (i, key) {
                    let targetList = editCloneEl.children().eq(1),
                        fragment = document.createDocumentFragment();

                    editCloneEl.find('h3').text(key.name).parent().next().empty();
                    if (key.list.length > 0) {
                        $.each(key.list, function (z, val) {
                            let crediv2 = document.createElement("div");
                            editCloneList.find('h4').text(val.name.length > 13 ? val.name.substr(0, 12) + '..' : val.name)
                                .prop('title', (val.name.length > 13 ? val.name : ''))
                                .next().text('Waktu:' + val.time_start.substr(0, val.time_start.length - 3) +
                                '-' + val.time_end.substr(0, val.time_end.length - 3) + ' WIB')
                                .next().text(val.code ? val.code : 'Tambahan');

                            $(crediv2).addClass('accord-con-fill').append(cloneList[0].innerHTML).data('list', 'dasd');

                            targetList.append('<div class="accord-con-fill" data-key="' + z + '">' + cloneList[0].innerHTML + '</div>');
                        });
                    } else {
                        targetList.append('<div class="accord-con-fill" style="padding: 15px 19px">' + 'Data belum disi' + '</div>');
                    }
                    var creDiv = document.createElement("div");


                    $(creDiv).addClass('grid-item grid-item-schedules schedule-list').append(cloneEl[0].innerHTML)
                        .data('key', key.key).data('list', key.list);
                    fragment.appendChild(creDiv);
                    elems.push(creDiv);
                    targetDay.append(fragment);

                });
                setTimeout(function () {
                    manS.masonry('appended', $(elems)).masonry('layout');
                }, 500);
                // targetOb.find('.grid').masonry('reloadItems');
                modalTarget.data('key', $(this).closest('tr').data('key'));
            }).catch(er => {
                erra(er.response);
            })
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
        qTarget.keyup(function (e) {
            if (e.keyCode === 13) {
                btnSearch.trigger("click");
            }
        });
        triggerHideModal.click(function () {
            hideModalFull(tableLabel);
            setTimeout(function () {
                getListAsync()
            }, 500);
        });

    });
}