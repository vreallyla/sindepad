<script>
    $(function () {
        const modalpage = $('#modal-container'), errNotice = 'terjadi kesalahan silakan, harap refresh /  kontak admin',
            showLoading = $('#loading'), manipNotice = 'Harap tidak merubah data', tabActive = 'activo',
            detailType = 'Diskon', successContent = '#success', noticeSuccess = 'Pembayaran di Konfirmasi: ',
            failedContent = $('#failed'), targetFailed = failedContent.children('.payment-fill'),
            waitingContent = '#waiting', noticeWaiting = 'Konfirmasi Pembayaran: ',
            targetTab = '.payment-fill',
            discCont = $('.disc-content'), codeCheck = 'checkout', radioTrans = 'input[name="select_item"]',
            confrimObj = $('#confirm'), btn_succ = $('.modal .button-success'), code = $('#code'),
            radioMethod = 'input[name="obj_metodo"], .cod', checkTab = $('.guia'), metodo = $('.pagamento-metodo'),
            guia = $('.cabeza-guia'), paymentContent = $('#payment'),
            paymentFill = paymentContent.children('.payment-fill'),
            loading = $('#loading-tab'), tabContent = $('.tab-fill'), btnSend = '.btn-contido',
            svg_loader = '<svg width="29px"  height="29px"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="lds-ellipsis" style="background: none;">' +
                '<!--circle(cx="16",cy="50",r="10")-->' +
                '<circle cx="84" cy="50" r="0" fill="#ffff">' +
                '<animate attributeName="r" values="10;0;0;0;0" keyTimes="0;0.25;0.5;0.75;1" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" calcMode="spline" dur="1s" repeatCount="indefinite" begin="0s">' +
                '</animate>' +
                '<animate attributeName="cx" values="84;84;84;84;84" keyTimes="0;0.25;0.5;0.75;1" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" calcMode="spline" dur="1s" repeatCount="indefinite" begin="0s">' +
                '</animate>' +
                '</circle>' +
                '<circle cx="84" cy="50" r="2.95432" fill="#ffffff">' +
                '<animate attributeName="r" values="0;10;10;10;0" keyTimes="0;0.25;0.5;0.75;1" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" calcMode="spline" dur="1s" repeatCount="indefinite" begin="-0.5s">' +
                '</animate>' +
                '<animate attributeName="cx" values="16;16;50;84;84" keyTimes="0;0.25;0.5;0.75;1" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" calcMode="spline" dur="1s" repeatCount="indefinite" begin="-0.5s">' +
                '</animate>' +
                '</circle>' +
                '<circle cx="73.9553" cy="50" r="10" fill="#ffffff">' +
                '<animate attributeName="r" values="0;10;10;10;0" keyTimes="0;0.25;0.5;0.75;1" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" calcMode="spline" dur="1s" repeatCount="indefinite" begin="-0.25s">' +
                '</animate>' +
                '<animate attributeName="cx" values="16;16;50;84;84" keyTimes="0;0.25;0.5;0.75;1" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" calcMode="spline" dur="1s" repeatCount="indefinite" begin="-0.25s">' +
                '</animate>' +
                '</circle>' +
                '<circle cx="39.9553" cy="50" r="10" fill="#ffffff">' +
                '<animate attributeName="r" values="0;10;10;10;0" keyTimes="0;0.25;0.5;0.75;1" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" calcMode="spline" dur="1s" repeatCount="indefinite" begin="0s"></animate><animate attributeName="cx" values="16;16;50;84;84" keyTimes="0;0.25;0.5;0.75;1" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" calcMode="spline" dur="1s" repeatCount="indefinite" begin="0s"></animate></circle><circle cx="16" cy="50" r="7.04568" fill="#ffff"><animate attributeName="r" values="0;0;10;10;10" keyTimes="0;0.25;0.5;0.75;1" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" calcMode="spline" dur="1s" repeatCount="indefinite" begin="0s"></animate><animate attributeName="cx" values="16;16;16;50;84" keyTimes="0;0.25;0.5;0.75;1" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" calcMode="spline" dur="1s" repeatCount="indefinite" begin="0s"></animate></circle></svg>';

        let urlPage = true,
            contentTab = checkTab.find('.activo').data('tab'),
            formCode = new FormData(),
            urlPrev;

        window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + '{{$token}}';
        modalpage.find('.modal').on('click', '.button-success', checkCode);

        {{--trigger tab click--}}
        guia.click(function () {
            tabContent.hide();
            guia.removeClass('activo');
            contentTab = $(this).addClass('activo').data('tab');
            urlPage = urlPrev === contentTab ? null : 'aa';
            loading.show();
            $('#empty-data, #error-data').hide();
            if ($(this).index() === 0 || $(this).index() === 1 || $(this).index() === 2 || $(this).index() === 3 || $(this).index() === 4) {
                getConfirm()
            }
            else {
                getOther()

            }
        });

        {{--end trigger tab click--}}

        {{--re run tooltip--}}
        function runTooltip() {
            $('body').tooltip({
                selector: '[data-toggle="tooltip"]',
                container: 'body'
            });
        }

        {{--end re run tooltip--}}

        {{--content tab confirm--}}
        function getConfirm() {
            axios.get('{{route('api.order.checkout')}}?tab=' + contentTab)
                .then(function (res) {
                    if (guia.eq(0).hasClass(tabActive)) {
                        succesConfirmTab(res);
                    }
                    else if (guia.eq(1).hasClass(tabActive)) {
                        successPaymentTab(res)
                    }
                    else if (guia.eq(2).hasClass(tabActive)) {
                        successBerhasilTab(res, waitingContent, noticeWaiting)
                    } else if (guia.eq(3).hasClass(tabActive)) {
                        successBerhasilTab(res, successContent, noticeSuccess)
                    }
                    else if (guia.eq(4).hasClass(tabActive)) {
                        successFaileTab(res)
                    }
                    runTooltip();
                    getOther()
                })
                .catch(function (er) {
                    if (er.response.status === 403) {
                        showEl('#empty-data');
                    }
                    else {
                        showEl('#error-data');
                    }
                });
        }

        function successBerhasilTab(res, fillTab, noticeTabb) {

            let cloneSuccess = $(fillTab).find(targetTab).clone(),
                targetFillSuccess = cloneSuccess.eq(0);
            $(fillTab).empty();
            $.each(res.data, function (key, val) {

                targetFillSuccess.children('.payment-title').children('span').text(val.entity + ' Anak').prop('title', loopShortName(val.list))
                    .parent().next().children('.display-phone').children('h6').text(val.entity + 'x')
                    .parent().next().children('h6').text(convertRp(val.total))
                    .parent().next().children('h6').text(0)
                    .closest('.payment-content').next().children('p').text(noticeTabb + moment(val.end_date.date).format("ddd, Do MMM YYYY, HH:mm") + ' WIB')
                    .next().children().eq(0).prop('href', '{{route('order.describe')}}?q=' + val.id)
                    .closest('.payment-footer').children().eq(0).children('h3').text(convertRp(val.total));

                if ($.trim(val.voucher)) {
                    targetFillSuccess.children('.payment-content').children().eq(2).children('h6').text(val.voucher.type === detailType ? '-' + val.voucher.amount + '%' : '-Rp' + convertRp(val.voucher.amount))
                        .closest('.payment-content').next().children().eq(0).children('h3').text(convertRp(val.voucher.type === detailType ? (val.total * (100 - val.voucher.amount) / 100) : (val.total - val.voucher.amount)))
                }

                $(fillTab).append('<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 tarxeta payment-fill" style="background: #fff">' +
                    cloneSuccess[0].innerHTML
                    + '</div>');
            })

        }

        function successFaileTab(res) {
            let cloneFailed = targetFailed.clone(),
                targetFillFailed = cloneFailed.eq(0);
            failedContent.empty();
            $.each(res.data, function (key, val) {

                targetFillFailed.children('.payment-title').children('span').text(val.entity + ' Anak').prop('title', loopShortName(val.list))
                    .parent().next().children('.display-phone').children('h6').text(val.entity + 'x')
                    .parent().next().children('h6').text(convertRp(val.total))
                    .parent().next().children('h6').text(0)
                    .closest('.payment-content').next().children('p').text('Transaksi dibatalkan: ' + moment(val.end_date.date).format("ddd, Do MMM YYYY, HH:mm") + ' WIB')
                    .next().children().eq(0).prop('href', '{{route('order.describe')}}?q=' + val.id)
                    .next().data('code', val.id)
                    .closest('.payment-footer').children().eq(0).children('h3').text(convertRp(val.total));

                // if ($.trim(val.voucher)) {
                //     targetFillFailed.children('.payment-content').children().eq(2).children('h6').text(val.voucher.type === detailType ? '-' + val.voucher.amount + '%' : '-Rp' + convertRp(val.voucher.amount))
                //         .closest('.payment-content').next().children().eq(0).children('h3').text(convertRp(val.voucher.type === detailType ? (val.total * (100 - val.voucher.amount) / 100) : (val.total - val.voucher.amount)))
                // }

                failedContent.append('<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 tarxeta payment-fill" style="background: #fff">' +
                    cloneFailed[0].innerHTML
                    + '</div>');
            })
        }

        function succesConfirmTab(res) {
            let objConfirm = confrimObj.find('.tarxeta-contido').eq(0).find('.contido-lista').clone(),
                targetConfirm = objConfirm.eq(0),
                subTotal = '',
                objNow = $('#' + contentTab).find('.tarxeta-contido').eq(0);
            objNow.html('');
            confrimObj.find('.pick-contido')
                .html('0 Transaksi dipilih<span class="pull-right rpcontent">0</span>')
                .parent().find('.disc-content')
                .closest('.tarxeta-contido').find('.btn-contido').prop('disabled', true)
                .prev().text(0);

            $.each(res.data, function (key, val) {
                console.log(targetConfirm.find(radioTrans).prop('id', codeCheck + key).prop('checked', false)
                    .next().prop('for', codeCheck + key)
                    .parent().next().find('.contido-custo').text(convertRp(val.total))
                    .prop('title', 'Rp ' + convertRp(subTotal) + '/Anak')
                    .prev().find('.entity_tab').prop('title', loopShortName(val.list))
                    .text(val.entity + ' Anak').closest('.cotido-numero').find('.status_tab')
                    .text(capitalizeFirstLetter(val.status)).prop('title', 'Harap konfirmasi sebelum ' +
                        moment(val.end_date.date).format("dddd, Do MMMM YYYY, HH:mm") + ' WIB')
                    .closest('table').parent().find('.contido-boton').children().eq(1).attr('href', '{{route('order.describe')}}?q=' + val.id));

                confrimObj.find('#checkall').prop('checked', false);

                objNow.append('<div class="contido-lista">' +
                    objConfirm[0].innerHTML +
                    '</div>');

                confrimObj.find('.tarxeta-contido').eq(0).find('.contido-lista').eq(key)
                    .find(radioTrans).data('id', val.id)
                    .parent().next().find('.contido-custo').data('total', val.total);

            });
        }

        function successPaymentTab(res) {
            let clonePayment = paymentFill.clone(),
                targetFillPayment = clonePayment.eq(0);
            paymentContent.empty();
            console.log(res)
            $.each(res.data, function (key, val) {

                targetFillPayment.children('.payment-title').children('span').text(val.entity + ' Anak').prop('title', loopShortName(val.list))
                    .parent().next().children('.display-phone').children('h6').text(val.entity + 'x')
                    .parent().next().children('h6').text(convertRp(val.total))
                    .parent().next().children('h6').text(0)
                    .closest('.payment-content').next().children('p').text('Harap Bayar Sebelum ' + moment(val.end_date.date).format("ddd, Do MMM YYYY, HH:mm") + ' WIB')
                    .next().children().eq(0).prop('href', '{{route('order.info')}}?q=' + val.id)
                    .text(val.method.method === "Bayar Ditempat" ? 'Info Pembayaran' : 'Transfer Sekarang')
                    .next().prop('href', '{{route('order.describe')}}?q=' + val.id)
                    .parent().children('ul').children().eq(0).prop('href', '{{route('order.method')}}?q=' + val.id)
                    .next().data('code', val.id)
                    .closest('.payment-footer').children().eq(0).children('h3').text(convertRp(val.total));

                if ($.trim(val.voucher)) {
                    targetFillPayment.children('.payment-content').children().eq(2).children('h6').text(val.voucher.type === detailType ? '-' + val.voucher.amount + '%' : '-Rp' + convertRp(val.voucher.amount))
                        .closest('.payment-content').next().children().eq(0).children('h3').text(convertRp(val.voucher.type === detailType ? (val.total * (100 - val.voucher.amount) / 100) : (val.total - val.voucher.amount)))
                }

                paymentContent.append('<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 tarxeta payment-fill" style="background: #fff">' +
                    clonePayment[0].innerHTML
                    + '</div>');
            })
        }

        function loopShortName(ulang) {
            let fillNames = '';
            $.each(ulang, function (i, side) {
                fillNames += side.shortName + ', ';
                subTotal = side.total;
            });

            return fillNames.substr(0, (fillNames.length - 2));
        }

        {{--end content tab confirm--}}

        {{--set first p upperchase--}}
        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        {{--end set first p upperchase--}}

        {{--show some element--}}
        function showEl(obj) {
            setTimeout(function () {
                loading.hide();
                $(obj).hide().fadeIn(300);
            });
        }

        {{--end show some element--}}

        {{--show content tab--}}
        function getOther() {
            setTimeout(function () {
                loading.hide();
                $('#' + contentTab).fadeIn('slow');

                let stateObj = {
                    num: guia.index(checkTab.find('.activo')),
                    obj: contentTab
                };
                if (urlPage) {
                    history.pushState(stateObj, "title", "/order/checkout?tab=" + contentTab);
                    urlPage = true;
                }
            }, 1000);
        }

        {{--end show content tab--}}

        {{--set async history with pop--}}
        window.addEventListener('popstate', e => {
            // console.log(e.state);
            urlPrev = e.state.obj;
            if (e.state.num !== '') {
                urlPage = false;
                guia.eq(e.state.num).click();
            }
            else {
                history.back();
            }
        });
        {{--end set async history with pop--}}

        {{--triger select method--}}
        metodo.click(function () {
            metodo.removeClass('activo');
            $(this).addClass('activo');
        });

        {{--end triger select method--}}

        {{--validate code voucher--}}
        function checkCode() {
            let objNotice = $('.modal .help-block');
            formCode = new FormData();
            formCode.append('code', code.val());
            btn_succ.addClass('wait-btn').html(svg_loader);
            objNotice.hide();

            axios.post('{{route('api.order.voucher')}}', formCode)
                .then(function (res) {
                    res.data.type === detailType ?
                        discCont.addClass('disc-perc').text(res.data.amount).removeClass('disc-rp') :
                        discCont.addClass('disc-rp').text(convertRp(res.data.amount)).removeClass('disc-perc');
                    setTimeout(function () {
                        modalpage.click().data("val", {
                            code: res.data.id,
                            type: res.data.type,
                            amount: res.data.amount
                        });
                        countTotal();
                        endCheckCode();
                        swallCustom2('voucher dapat digunakan');
                    }, 500);
                }).catch(function (er) {
                res = er.response;
                if (res.status === 422) {
                    objNotice.text(res.code).hide().fadeIn(300)
                }
                else {
                    objNotice.text(errNotice).hide().fadeIn(300)

                }
                endCheckCode()
            });
        }

        function endCheckCode() {
            btn_succ.addClass('wait-btn').html('Gunakan')
        }

        function countTotal() {
            let amountConf = confrimObj.find('.pick-contido').data('nominal'),
                discObj = modalpage.data('val'),
                discTotal = amountConf * (100 - discObj.amount) / 100,
                cutTotal = amountConf - discObj.amount,
                endTotal = 0;

            endTotal = discObj.type === detailType ? discTotal : cutTotal;
            confrimObj.find('.contido-custo-ben').text(convertRp(endTotal));
        }

        {{--end validate code voucher--}}

        confrimObj.on('click', btnSend, function () {
            let checkTrans = confrimObj.find('input[name=select_item]:checked'),
                checkMethod = confrimObj.find('input[name=obj_metodo]:checked'),
                countTrans = checkTrans.length,
                discObj = modalpage.data('val'),
                valTrans = [];
            showLoading.show();

            if (countTrans > 0 && confrimObj.find(radioMethod).is(':checked')) {
                for ($i = 0; $i < countTrans; $i++) {
                    valTrans.push(checkTrans.eq($i).data('id'));
                }

                axios.post('{{route('api.order.confirmPost')}}', {
                    trans: valTrans,
                    met: checkMethod.val(),
                    disc: (typeof discObj !== "undefined") ? discObj.code : ''
                })
                    .then(function (res) {
                        hideAlert('Transaksi berhasil dikonfirmasi');
                        guia.eq(1).click();
                    }).catch(function (er) {
                    hideAlert(er.response.status === 422 ? manipNotice : errNotice);
                });
            }
        })

        function hideAlert(alert) {
            showLoading.hide();
            swallCustom2(alert);

        }

    });

    {{--convert currency rp--}}
    function convertRp(val) {
        return currency(val, {
            separator: '.',
            precision: 0
        }).format();
    }
    {{--end convert currency rp--}}
</script>
