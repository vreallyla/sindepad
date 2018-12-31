if ($('body').find('#settings-price').length > 0) {
    $(function () {
        const targetFill = $('tbody'), loadingMagnify = $('.loading'),
            urlApi = '/api/v1/admin/settings/prices/'
            , tableLabel = $('.table-register'),
            myOptions = {
                digitGroupSeparator: '.',
                decimalCharacter: ',',
                maximumValue: '999999999999999',
                minimumValue: '0',
                currencySymbol: 'Rp. '
            }
        ;

        let getDataAsync = function () {
            const urlSide = 'list';
            loadingMagnify.show();
            tableLabel.hide();
            $('.not-found-notice,.error-notice').hide();
            axios.get(urlApi + urlSide)
                .then(res => {
                    loadingMagnify.hide();
                    tableLabel.show();
                    let cloneFun = targetFill.children().clone(),
                        cloneEdit = cloneFun.eq(0)
                    ;
                    targetFill.empty();

                    $.each(res.data, function (i, val) {
                        let creTr = document.createElement("tr"),

                            fragment = document.createDocumentFragment();

                        cloneEdit.children().eq(0).text(val.name)
                            .next().children().eq(0).text(convertRp(val.amount));

                        $(creTr).append(cloneFun[0].innerHTML).data('key', val.id);

                        fragment.appendChild(creTr);
                        targetFill.append(fragment);
                        targetFill.children().eq(i).find('input').val(val.amount);
                        targetFill.find('.input-rp').autoNumeric('init', myOptions);

                    });


                }).catch(er => {
                noticeListTable(er.response);
            });
        };

        $(document).ready(function () {
            getDataAsync();
        });

        targetFill.on('click', '.btn-info', function () {
            $(this).removeClass().addClass('btn btn-danger').text('Simpan').blur().closest('tr').find('input').fadeIn(300).prev().hide();
        });

        targetFill.on('click', '.btn-danger', function () {
            const metFunc = 'PUT', urlSide = 'update';
            $(this).removeClass().addClass('btn btn-info').text('Rubah').closest('tr').find('input').hide().prev().fadeIn(300);
            let self = targetFill.find('input'), keyFun = $(this).closest('tr').data('key'), formFunc = new FormData();

            try {
                var v = self.autoNumeric('get');
                self.autoNumeric('destroy');
                self.val(v);
            } catch (err) {
                console.log("Not an autonumeric field: " + self.attr("name"));
            }

            formFunc.append('key', keyFun);
            formFunc.append('amount', self.val());
            formFunc.append('_method', metFunc);
            showLoading();
            axios.post(urlApi + urlSide, formFunc)
                .then(res => {
                    hideLoading();
                    getDataAsync();
                    swallCustom(res.data.msg);
                }).catch(er => {
                erra(er.response);
            });

        });

    });
}