if ($('body').find('#register-list').length > 0) {
    $(function () {
        const targetObj = $('#register-list'),
            rowTarget = targetObj.find('select[name=entity]'),
            categoryTarget = targetObj.find('select[name=category]'),
            qTarget = targetObj.find('input[name=search]'),
            targetTable = targetObj.find('tbody'),
            fillTable = targetTable.children('tr'),
            rowAvail = [10, 30, 50], catAvail = ['tf', 'cop'],
            targetPage = targetObj.find('.paginate'),
            loadingMagnify = targetObj.find('.loading'),
            tableLabel = targetObj.find('.table-register'),
            btnSearch = qTarget.next().children('button'),
            btnDetail = '.btn-info', modalTarget = targetObj.find('.modal-full'),
            objnonModal = $('.title-content,.table-register,.not-found-notice,.error-notice,.loading'),
            triggerHideModal = targetObj.find('.btn-back'),
            modalpage = $('#modal-container'),
            urlPage = '/admin/transactions/register-list',
            urlApi = '/api/v1/admin/transactions/';

        let data = {
            page: getUrlParameter('page') ? getUrlParameter('page') : 1,
            row: getUrlParameter('row') ? getUrlParameter('row') : rowTarget.val(),
            cat: getUrlParameter('cat') ? getUrlParameter('cat') : categoryTarget.val(),
            q: getUrlParameter('q') ? getUrlParameter('q') : qTarget.val()
        };

        history.replaceState('', "", urlPage);
        history.pushState(data, "title", urlPage + (data.q !== '' ? '?q=' + data.q + '&cat=' : '?cat=') + data.cat + '&row=' + data.row + '&page=' + data.page);


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
            getRegisterList();
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

        function checkpop(clickPage) {
            let codition = clickPage === data.page;
            data.page = clickPage;
            changeVar(codition);
        }

        function changeVar(codi) {
            getRegisterList();
            if (!codi) {
                history.pushState(data, "title", urlPage + (data.q !== '' ? '?q=' + data.q + '&cat=' : '?cat=') + data.cat + '&row=' + data.row + '&page=' + data.page);
            }
        }

        /*--------------set async history with pop---------*/
        window.addEventListener('popstate', e => {
            if (e.state !== '') {
                rowTarget.val(e.state.row);
                categoryTarget.val(e.state.cat);
                qTarget.val(e.state.q);
                data = e.state;
                getRegisterList();
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

        function getRegisterList() {
            let tableClone = fillTable.clone(),
                editClone = tableClone.eq(0);
            loadingMagnify.show();
            tableLabel.hide();
            $('.not-found-notice, .error-notice').hide();
            axios.get(urlApi + 'register-list', {
                params: data
            })
                .then(function (res) {
                    loadingMagnify.hide();
                    tableLabel.fadeIn(500);
                    targetTable.empty();
                    $.each(res.data.data, function (i, val) {
                        editClone.children().eq(0).text(val.code);
                        editClone.children().eq(1).children().text(val.quantity).prop('title', val.student);
                        editClone.children().eq(2).text(convertRp(val.total));
                        editClone.children().eq(3).text(val.method);
                        editClone.children().eq(4).children('span').removeClass()
                            .addClass(val.status === 'Gagal' ? 'label-danger' : 'label-info')
                            .addClass('label').text(val.status).prop('title', moment(val.ex_create.date).format("ddd, Do MMM YYYY, HH:mm") + ' WIB');
                        editClone.children().eq(5).text(moment(val.date_create.date).format("DD/MM/YYYY"));

                        targetTable.append('<tr>' + tableClone[0].innerHTML +
                            '</tr>').children().eq(i).data('key', val.key);

                    });
                    setPagination(targetPage, res.data.max_page, res.data.current_page);
                })
                .catch(function (er) {
                    loadingMagnify.hide();
                    if (er.response.status === 403 || er.response.status === 422) {
                        $('.not-found-notice').fadeIn(300);
                    } else {
                        $('.error-notice').fadeIn(300);
                    }
                });
        }

        /*---------------- modal photo ----------------*/
        $('.ex-invoice').click(function () {
            var buttonId = 'one';
            $('#modal-container').removeAttr('class').addClass(buttonId);
            $('body').addClass('preloader-site');
        });

        $('#modal-container .modal').click(function () {
            return false;
        });

        modalpage.click(removeModal);

        modalpage.find('.modal').on('click', 'a', removeModal);

        function removeModal() {
            modalpage.addClass('out');
            $('body').removeClass('preloader-site');
        }

        /*-------------- end modal photo --------------*/

        /*----------------  confirm trans ----------------*/
        modalTarget.on('click','button',function () {
            let formDAta=new FormData(),
                keyConfirm=$(this).data('key');
            formDAta.append('key',keyConfirm);
            axios.post(urlApi+'register-confirm',formDAta)
                .then(function (res) {
                    swallCustom(res.data.msg);
                    hideModalFull();
                    setTimeout(function () {
                        getRegisterList();
                    },500);
                })
                .catch(function (err) {
                    swallCustom(errNotice);
                })
        });
        /*--------------  end confirm trans --------------*/

        /*----------------  modal full async ----------------*/
        targetTable.on('click', btnDetail, function () {
            showLoading();
            axios.get(urlApi + 'register-detail?key=' + $(this).closest('tr').data('key'))
                .then(function (res) {
                    hideLoading();
                    manipulateModal(res.data);
                    manipulateModal2(res.data);
                    showModalFull();
                }).catch(function (er) {
                hideLoading();
                swallCustom('Terdapat Kesalahan. Harap refresh / kontak admin');
            })
        });

        function manipulateModal2(data) {
            let targetListDetail = modalTarget.find('.describ-notice'),
                clonelistCost = targetListDetail.children().clone(),
                changeListCost = clonelistCost.eq(0),
                fillaa = '';

            $.each(data.list, function (i, val) {
                changeListCost.children().eq(0).children().eq(1).text(': ' + val.name).next().text(': ' + val.shorName)
                    .next().prop('title', val.needed)
                    .parent().next().find('.content-fill').eq(0).children().eq(1).text(val.needed)
                    .closest('.content-describ').find('.highlight-sm').text(convertRp(val.sub_total));
                $.each(val.detail, function (i, val) {
                    changeListCost.children().eq(1).find('.content-fill').eq(i + 1).children().eq(0).text(val.name).next().text(convertRp(val.amount));
                });
                fillaa += '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 detail-notice">' + clonelistCost[0].innerHTML + '</div>';
            });
            targetListDetail.html(fillaa);
        }

        function manipulateModal(data) {
            modalpage.find('img').prop('src', data.invoice ? data.invoice.img : '');

            modalTarget.find('.radius-bottom').removeClass()
                .addClass('col-lg-12 card-notice radius-bottom ' + (data.status === 'Menunggu Konfirmasi' ? 'trans-notice-success' : 'trans-notice-failed'))
                .children().eq(0).text(data.status)
                .next().text('Waktu Konfirmasi: ' + moment(data.date_create.date).format("ddd, Do MMM YYYY, HH:mm") + ' WIB')
                .parent().next().find('.list-total').eq(0).children('h5').text(convertRp(data.sub_total))
                .parent().next().children('h5').text(data.voucher ?
                (data.voucher.type === 'Diskon' ?
                    data.voucher.amount :
                    convertRp(data.voucher.amount)) :
                0).removeClass()
                .addClass(data.voucher ? (data.voucher.type === 'Diskon' ? 'add-percent-minus' : 'add-rp-minum') : '')
                .parent().next().children('h5').text(convertRp(data.total))
                .parent().next().children('h5').text(data.method)
                .closest('.fill-content').next().data('key', data.key)
                .closest('.botton-option').next().css('display', (data.invoice ? 'block' : 'none'))
                .find('.fill-tf-info').eq(0).children('h5').text(data.invoice ? data.invoice.name : '')
                .parent().next().children('h5').text(data.invoice ? data.invoice.bank : '')
                .parent().next().children('h5').text(data.invoice ? data.invoice.date_send : '')
                .closest('.img-conf').next().children('img').attr('src', data.invoice ? data.invoice.img : '')
                .parent().next().children().eq(0).children('span').text(data.code);
        }

        triggerHideModal.on('click', function () {
            hideModalFull();
        });

        function showModalFull() {
            objnonModal.addClass('animated slideOutDown');

            setTimeout(e => {
                modalTarget.show();
                objnonModal.removeClass('animated slideOutDown').hide();
                anim('animated bounceInDown', modalTarget, 'animated bounceInDown');
            }, 300);
        }

        function hideModalFull() {
            modalTarget.fadeOut(300);
            setTimeout(e => {
                $('.title-content,.table-register').fadeIn(300);
            }, 500);
        }

        /*-------------- end modal full async --------------*/


    });
}
