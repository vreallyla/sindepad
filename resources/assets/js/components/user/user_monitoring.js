if ($('body').find('#user-monitoring').length > 0) {
    $(function () {
        let $timelineExpandableTitle = $('.timeline-action.is-expandable'),
            targetLine = '.title';

        const targetObj = $('#user-monitoring'),
            categoryTarget = targetObj.find('select[name=category]'),
            qTarget = targetObj.find('input[name=search]'),
            loadingMagnify = targetObj.find('.loading'), targeFill = targetObj.find('.timeline'),
            urlPage = '/simdepad/user/monitoring', targetCLik = $('.timeline'),
            urlApi = '/api/v1/user/monitoring/', dataTart = $('article'),
            nonTart = $('article,.not-found-notice,.error-notice,.loading'),
            btnSearch = qTarget.next().children('button');

        let data = {
            cat: getUrlParameter('cat') ? getUrlParameter('cat') : categoryTarget.val(),
            q: getUrlParameter('q') ? getUrlParameter('q') : qTarget.val()
        }
            , checkpop = function (clickPage) {
            let codition = clickPage === data.page;
            data.page = clickPage;
            changeVar(codition);
        }
            , changeVar = function (codi) {
            getDataAsync();
            if (!codi) {
                history.pushState(data, "title", urlPage + (data.q !== '' ? '?q=' + data.q + '&cat=' : '?cat=') + data.cat + '&row=' + data.row + '&page=' + data.page);
            }
        }
            , getDataAsync = function () {
            const urlSide = 'list';
            nonTart.hide();
            loadingMagnify.show();
            dataTart.hide();
            axios.get(urlApi + urlSide, {
                params: data
            })
                .then(res => {
                    loadingMagnify.hide();
                    dataTart.show();
                    let cloneFunc = targeFill.children().clone(),
                        editClone = cloneFunc.eq(0), datass = res.data,
                        fragment = document.createDocumentFragment();

                    targeFill.empty();
                    $.each(datass, function (i, val) {
                        let creDiv = document.createElement("li"),
                            conTime = moment(qTarget.val() + " " + val.time_end, "DD/MM/YYYY HH:mm:ss").isBefore(moment());

                        editClone.find('.title').text(val.name).next().text(val.time_start + '-' + val.time_end + ' WIB');

                        if (conTime) {
                            editClone.find('.selectN').text('aaaaaa');
                        }

                        $(creDiv).addClass('timeline-milestone ' + (val.data ? 'is-completed' :
                            conTime ? 'is-current' : 'is-future')).append(cloneFunc[0].innerHTML);

                        fragment.appendChild(creDiv);
                        targeFill.append(fragment);

                        targeFill.children().eq(i).find('.selectN').val(val.data ? val.data.select.name : '').parent()
                            .next().children('input').val(val.data ? val.data.value : '').parent().parent()
                            .next().children('textarea').val(val.data ? val.data.achievement : '').parent()
                            .next().children('textarea').val(val.data ? val.data.note : '').parent()
                        ;
                    });
                    let hasil = targeFill.children();
                    hasil.eq(0).addClass('timeline-start');
                    hasil.eq(hasil.length - 1).addClass('timeline-end');


                    $($timelineExpandableTitle).find(targetLine).attr('tabindex', '0');


                    // Give timelines ID's
                    $('.timeline').each(function (i, $timeline) {
                        var $timelineActions = $($timeline).find('.timeline-action.is-expandable');

                        $($timelineActions).each(function (j, $timelineAction) {
                            var $milestoneContent = $($timelineAction).find('.content');
                            $($timelineAction).removeClass('is-expanded');
                            $($milestoneContent).attr('id', 'timeline-' + i + '-milestone-content-' + j).attr('role', 'region');
                            $($milestoneContent).attr('aria-expanded', $($timelineAction).hasClass('expanded'));

                            $($timelineAction).find('.title').attr('aria-controls', 'timeline-' + i + '-milestone-content-' + j);
                        });
                    });

                }).catch(er => {
                loadingMagnify.hide();
                noticeListTable(er.response);
            })
        };

        targetCLik.on('click', targetLine, function () {
            if (!$(this).closest('li').hasClass('is-future')) {
                $('.timeline').find(targetLine).parent().removeClass('is-expanded');
                $(this).parent().toggleClass('is-expanded');
                $(this).siblings('.content').attr('aria-expanded', $(this).parent().hasClass('is-expanded'));
            } else {
                swallCustom('Waktu belum terlewati')
            }
        });

        // Expand or navigate back and forth between sections
        targetCLik.on('keyup', targetLine, function (e) {
            if (e.which == 13) { //Enter key pressed
                $(this).click();
            } else if (e.which == 37 || e.which == 38) { // Left or Up
                $(this).closest('.timeline-milestone').prev('.timeline-milestone').find('.timeline-action .title').focus();
            } else if (e.which == 39 || e.which == 40) { // Right or Down
                $(this).closest('.timeline-milestone').next('.timeline-milestone').find('.timeline-action .title').focus();
            }
        });

        $(document).ready(function () {
            history.replaceState('', "", urlPage);
            history.pushState(data, "title", urlPage + (data.q !== '' ? '?q=' + data.q + '&cat=' : '?cat=') + data.cat + '&row=' + data.row + '&page=' + data.page);
            if (data.q !== qTarget.val()) {
                qTarget.val(data.q);
            }
            if (data.cat !== categoryTarget) {
                categoryTarget.val(data.cat);
            }

            $('.datepicker').datepicker({
                language: 'id',
                format: 'dd/mm/yyyy'
            });

            getDataAsync();

        });

        /*--------------set async history with pop---------*/
        window.addEventListener('popstate', e => {
            if (e.state !== '') {
                rowTarget.val(e.state.row);
                categoryTarget.val(e.state.cat);
                qTarget.val(e.state.q);
                data = e.state;
                getDataAsync();

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


    });
}
