
if ($('body').find('#evaluations').length > 0) {
    $(function () {
        const placeRight = $('.place-right'), listKids = placeRight.find('.user-list-right')
            , urlPage = '/simdepad/user/evaluations', urlApi = '/api/v1/user/evaluation/',
            dateTarget = $('#date'), targetOb = $('.page-timeline'), noticeN = $('.not-found-notice'),
            btnSave = $('.btn-default');

        let data = {
                date: getUrlParameter('date') ? getUrlParameter('date') : moment().format('MM-YYYY'),
                key: getUrlParameter('kid') ? getUrlParameter('kid') : listKids.eq(0).data('key'),
            },
            checkpop = function (clickPage) {
                let codition = clickPage === data.page;
                data.page = clickPage;
                changeVar(codition);
            },
            changeVar = function (codi) {
                getListAsync();
                if (!codi) {
                    history.pushState(data, "title", urlPage + '?kid=' + data.key + '&date=' + data.date);
                }
            }
            , getListAsync = function () {
                let urlSide = 'detail',stuSel=placeRight.find('[data-key="' + data.key + '"]');
                hideObjN(targetOb);
                hideContentRight();

                listKids.removeClass('activo');
                stuSel.addClass('activo');

                axios.get(urlApi + urlSide, {
                    params: data
                }).then(res => {
                    showObjN(targetOb);
                    checkDate(res.data.date);

                    $('article h4').html('Evaluasi '+stuSel.find('h5').text()+' '+dateTarget.children(':selected').text());
                    $('article div').html(res.data.data === null ? '<p>Belum diisi</p>' : res.data.data.detail);

                    if (dateTarget.val() !== data.date) {
                        dateTarget.val(data.date);
                    }

                }).catch(er => {
                    checkDate(er.response.data.date);
                    showObjN(noticeN);
                    noticeN.children('h3').text(er.response.data.msg);
                });
            },
            checkDate = function (dateN) {
                dateTarget.empty();
                if (dateN.list) {
                    $.each(dateN.list, function (i, val) {
                        let creOp = document.createElement("option");
                        $(creOp).prop('value', val.key).text(val.name).prop('selected', val.key === dateN.selected ? true : false);
                        dateTarget.append(creOp);
                    });
                } else {
                    dateTarget.append('<option value="" selected disabled>Belum Ada Rekaman</option>')
                }
            }
        ;

        $(document).ready(function () {
            history.replaceState('', "", urlPage);
            history.pushState(data, "title", urlPage + '?kid=' + data.key + '&date=' + data.date);
            getListAsync();
        });

        /*--------------set async history with pop---------*/
        window.addEventListener('popstate', e => {
            if (e.state !== '') {
                data = e.state;
                getListAsync();

            } else {
                history.back();
            }
        });
        /*--------------end set async history with pop---------*/


        listKids.click(function () {
            let changeCate = $(this).data('key'),
                codition = changeCate === data.key;

            data.key = changeCate;

            changeVar(codition === true ? true : null);
        });

        dateTarget.change(function () {
            let changeCate = $(this).val(),
                codition = changeCate === data.date;

            data.date = changeCate;

            changeVar(codition === true ? true : null);
        });
    });
}







