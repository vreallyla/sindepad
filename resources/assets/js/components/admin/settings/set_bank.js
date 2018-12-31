if ($('body').find('#setting-banks').length > 0) {
    console.log('aa');
    $(function () {
        const targetObj = $('#setting-banks'),
            urlApi = '/api/v1/admin/settings/method-payment-set/',
            placeRight = $('.place-right'),
            triggerRight = $('.trigger-right'),
            targetFill = $('.card-mod'), loadingMagnify = targetObj.find('.loading'),
            noticeGroup = $('.error-notice,.not-found-notice'),
            loadPart = $('#loading')
        ;

        let clickEditAct = false, clickDelAct = false,
            getDataAsync = function () {
                const urlSide = 'list';
                targetFill.hide();
                noticeGroup.hide();
                loadingMagnify.show();
                axios.get(urlApi + urlSide)
                    .then(res => {
                        loadingMagnify.hide();
                        targetFill.fadeIn(300);
                        let cloneFunc = targetFill.clone(),
                            editCLone = cloneFunc.children().eq(0),
                            Dat = res.data.data,
                            fragment = document.createDocumentFragment();

                        $.each(Dat, function (i, val) {
                            let crediv = document.createElement("div");
                            editCLone.find('img').prop('src', val.img).parent().next().next().children().eq(0)
                                .text(val.name.length > 15 ? val.name.substr(0, 14) + '..' : val.name)
                                .prop('title', (val.name.length > 15 ? val.name : '')).next().text('');
                            $(crediv).append(cloneFunc.children()[0].innerHTML).addClass('col-lg-4 col-md-4 col-sm-6 col-xs-12 card-img')
                                .data('list', {
                                    key: val.key,
                                    bank: val.bank
                                });

                            fragment.appendChild(crediv);
                        });

                        targetFill.html(fragment);
                        clickEditAct ? showEditAcOp() : (clickDelAct ? showDelAcOp() : null);
                    }).catch(er => {
                    noticeListTable(er.response);
                })
            },
            showDelAcOp = function () {
                let imgList = targetObj.find('.card-img');
                for (let i = 0; i < imgList.length; i++) {
                    targetObj.find('.card-img').eq(i).find('.exc-btn-list').children().eq(0).fadeIn(300)
                }
            },

            showEditAcOp = function () {
                let imgList = targetObj.find('.card-img');
                for (let i = 0; i < imgList.length; i++) {
                    targetObj.find('.card-img').eq(i).find('.exc-btn-list').children().eq(1).fadeIn(300)
                }
            }
        ;

        $(document).ready(function () {
            $('[name="no_rek"]').mask('000 000 000 000 0000');
            getDataAsync();
        });

        placeRight.on('submit', 'form', function (e) {
            e.preventDefault();
            loadPart.show();
            let dataPage = placeRight.find('.btn-info').data('key'),
                urlSide, formFunc = new FormData($(this)[0]);
            if (dataPage) {
                formFunc.append('_method', 'PATCH');
                formFunc.append('key', dataPage);
                urlSide = 'update';
            } else {
                urlSide = 'create';
            }

            axios.post(urlApi + urlSide, formFunc)
                .then(res => {
                    loadPart.hide();
                    swallCustom(res.data.msg);
                    getDataAsync();
                    if (editAct){
                        hideContentRight();
                    }
                    resetFormN();
                }).catch(er => {
                erInput(er.response);
            })
        });

        targetObj.on('click', '.exc-btn-list', function (e) {
            let target = $(e.target),
                keyAct = $(this).closest('.card-img').data('list');
            if (target.is('.fa-edit')) {
                editAct(keyAct, $(this).next().children('h3').text());

            } else if (target.is('.fa-times-circle')) {
                if (permissionsDel()) {
                    removeAct(keyAct);
                }
            }

        });

        triggerRight.click(function () {
            resetFormN();
            placeRight.find('.btn-info').data('key', '').text('Daftarkan');
        });

        function editAct(id, name) {
            resetFormN();
            const  urlSide='edit';
            loadPart.show();
            axios.get(urlApi+urlSide+'?key='+id.key)
                .then(res=>{
                    let Dat=res.data;
                    loadPart.hide();
                    triggerRight.addClass('non');
                    placeRight.addClass('activo').find('[name="name"]').val(Dat.name);
                    placeRight.find('[name="no_rek"]').val(Dat.no_rek);
                    placeRight.find('[name="an"]').val(Dat.name_owner);
                    placeRight.find('[name="division"]').val(Dat.division);
                    placeRight.find('select').selectpicker('val', id.bank.key);
                    placeRight.find('.btn-info').data('key', id.key).text('Rubah');
                }).catch(er=>{
                erra(er.response);
            });

        }

        function removeAct(id) {
            loadPart.show();
            const subUrl = 'delete';
            axios.delete(urlApi + subUrl, {params: {key: id.key}})
                .then(res => {
                    swallCustom(res.data.msg);
                    getDataAsync();
                    loadPart.hide();

                }).catch(er => {
                erra(er.response);
            });
        }

        function resetFormN() {
            placeRight.find('input').val('');
            placeRight.find('select').selectpicker('val','');
        }


    });
}