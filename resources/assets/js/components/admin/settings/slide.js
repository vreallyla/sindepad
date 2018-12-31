if ($('body').find('#setting-slides').length > 0) {
    $(function () {
        const targetObj = $('#setting-slides')
            , placeRight = $('.place-right'), targetFill = targetObj.find('.detail-slides'),
            loadPart = $('#loading'),
            loadingMagnify = targetObj.find('.loading'),

            urlApi = '/api/v1/admin/settings/slides/';
        let getDataAs = function () {
            const urlSide = 'list';
            loadingMagnify.show();
            targetFill.hide();
            $('.not-found-notice,.error-notice').hide();
            axios.get(urlApi + urlSide)
                .then(res => {
                    targetFill.show();
                    loadingMagnify.hide();
                    let clonePart = targetFill.children().clone(),
                        editClone = clonePart.eq(0),
                        fragment = document.createDocumentFragment();

                    $.each(res.data, function (i, val) {
                        let makeDiv = document.createElement("div");
                        editClone.find('img').prop('src', '/' + val.img).next().text(val.desc);

                        $(makeDiv).addClass('col-lg-offset-1 col-lg-10 col-md-12 col-sm-12 col-xs-12 fill-slides')
                            .append(clonePart[0].innerHTML).data('key', val.key);
                        fragment.appendChild(makeDiv);
                    });
                    targetFill.html(fragment);
                }).catch(er => {
                loadingMagnify.hide();
                noticeListTable(er.response);
            })
        };

        $(document).ready(function () {
            getDataAs();
        });

        targetObj.on('click', '.fa-trash-o', function () {
            const urlSide = 'delete';
            if (permissionsDel()) {
                loadPart.show();
                axios.delete(urlApi + urlSide, {params: {'key': $(this).closest('.fill-slides').data('key')}})
                    .then(res => {
                        loadPart.hide();
                        swallCustom(res.data.msg);
                        getDataAs();
                    })
                    .catch(er => {
                        erra(er.response);
                    })
            }
        });


        $('.trigger-right').on('click', function () {
            placeRight.find('button').text('Daftarkan').data('key', '');
            placeRight.find('input,textarea').val('');
        });

        targetObj.on('click', '.fa-edit', function () {
            const urlSide = 'edit';
            let dataKey = $(this).closest('.fill-slides').data('key');
            loadPart.show();
            axios.get(urlApi + urlSide + '?key=' + dataKey)
                .then(res => {
                    loadPart.hide();
                    $.each(res.data, function (i, val) {
                        placeRight.addClass('activo').find('button').text('Rubah').data('key', dataKey);
                        targetObj.find('.trigger-right').addClass('non');
                        placeRight.find('[name="' + i + '"]').val(val);
                    });
                }).catch(er => {
                erra(er.response);
            });
        });


        placeRight.on('click', '[name=con]', function () {
            let TargetChan = placeRight.find('.input-group-addon');
            $(this).is(':checked') ? TargetChan.css('text-decoration', ' line-through') : TargetChan.css('text-decoration', ' unset');
        });


        placeRight.on('submit', 'form', function (e) {
            let formPost = new FormData($(this)[0]), urlSide,
                keyForm = placeRight.find('button').data('key');

            if (keyForm) {
                urlSide = 'update';
                formPost.append('_method', 'PATCH');
                formPost.append('key', keyForm);


            } else {
                urlSide = 'post';
            }
            e.preventDefault();
            loadPart.show();
            axios.post(urlApi + urlSide, formPost)
                .then(res => {
                    loadPart.hide();
                    swallCustom(res.data.msg);
                    getDataAs();
                    placeRight.find('input,textarea').val('');

                    if (keyForm) {
                        placeRight.removeClass('activo');
                        $('.trigger-right').removeClass('non');
                    }
                }).catch(er => {
                loadPart.hide();
                erInput(er.response);

            });
        });
    });
}