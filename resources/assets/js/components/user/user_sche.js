if ($('body').find('#user-schedules').length > 0) {
    $(function () {
        const targetDay = $('.grid'), targetAct = targetDay.find('.accord-con-detail'),
            urlApi = '/api/v1/user/schedules/',
            placeRight = $('.place-right'),
            targetStudent = '.user-list-right',
            noticeEl = $('.not-found-notice,.error-notice'),
            loadMagnify = $('.loading'), not_found = $('.not-found-notice'),
            loadPart = $('#loading')
        ;

        let dataLabel, manS = $('.grid').masonry({
                // options
                itemSelector: '.grid-item',
                columnWidth: 2
            })
            , getDataAsync = function () {
                const urlSide = 'list';
                let cloneEl = targetDay.children().clone(),
                    cloneList = targetAct.children().clone(),
                    editCloneList = cloneList.eq(0),
                    editCloneEl = cloneEl.eq(0);
                loadMagnify.show();
                targetDay.hide();
                noticeEl.hide();
                placeRight.find(targetStudent).removeClass('activo');
                axios.get(urlApi + urlSide, {
                    params: {
                        'key': dataLabel.data('key')
                    }
                }).then(res => {
                    dataLabel.addClass('activo');
                    loadMagnify.hide();
                    targetDay.show();
                    hideContentRight();
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
                    manS.masonry('appended', $(elems)).masonry('layout');
                }).catch(er => {
                    noticeListTable(er.response);
                })
            }

        ;

        $(document).ready(function () {
            dataLabel = placeRight.find(targetStudent).eq(0);
            getDataAsync();
        });

        placeRight.on('click',targetStudent,function () {
            dataLabel = $(this);
            getDataAsync();
        });

    });



}