if ($('body').find('#evaluations').length > 0) {
    $(function () {
        const placeRight = $('.place-right'), listKids = placeRight.find('.user-list-right')
            , urlPage = '/simdepad/shadow/evaluations', urlApi = '/api/v1/shadow/evaluation/',
            dateTarget = $('#date'), targetOb = $('.page-timeline'), noticeN = $('.not-found-notice'),
            btnSave = $('.btn-default');

        let data = {
                date: getUrlParameter('date') ? getUrlParameter('date') : moment().format('MM-YYYY'),
                key: getUrlParameter('kid') ? getUrlParameter('kid') : listKids.eq(0).data('key'),
                key_eva: ''
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
                let urlSide = 'detail';
                hideObjN(targetOb);
                hideContentRight();

                listKids.removeClass('activo');
                placeRight.find('[data-key="' + data.key + '"]').addClass('activo');

                axios.get(urlApi + urlSide, {
                    params: data
                }).then(res => {
                    btnSave.show();
                    showObjN(targetOb);
                    data.key_eva = res.data.data === null ? '' : res.data.data.key;
                    checkDate(res.data.date);
                    tinymce.activeEditor.setContent(res.data.data === null ? '' : res.data.data.detail);

                    if (dateTarget.val() !== data.date) {
                        dateTarget.val(data.date);
                    }

                }).catch(er => {
                    btnSave.hide();
                    data.key_eva = '';
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

        btnSave.click(function () {
            let formD = new FormData();
            formD.append('detail', tinyMCE.activeEditor.getContent());
            formD.append('key_eva', data.key_eva);
            formD.append('key', data.key);
            formD.append('date', data.date);
            formD.append('_method', 'PUT');
            $('.help-block').text('');
            showLoading();
            axios.post(urlApi + 'save', formD)
                .then(res => {
                    hideLoading();
                    swallCustom(res.data.msg);
                    getListAsync();

                }).catch(er => {
                hideLoading();
                if (er.response) {
                    if (re.response.detail) {
                        $('.help-block').text(re.response.detail);
                    } else {
                        swallCustom('Terjadi kesalahan silakan refresh / kontak admin')
                    }
                } else {
                    swallCustom('Terjadi kesalahan silakan refresh / kontak admin')
                }
            })
        });


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
