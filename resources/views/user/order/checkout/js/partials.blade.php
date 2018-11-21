@include('user.order.general.order_general_js.swallCustom')
<script>
    $(function () {
        let totalConfirm = 0;
        const modalpage = $('#modal-container'),
            confrimObj = $('#confirm'),
            radioMethod = 'input[name="obj_metodo"], .cod',
            tab = '{{$tab}}',
            guia = $('.cabeza-guia'),
            voucher = 'input[name=select_item]',
            btnConfirm = $('.btn-contido'),
        paymentObj=$('#payment');

        guia.eq(0).data('tab', 'confirm');
        guia.eq(1).data('tab', 'payment');
        guia.eq(2).data('tab', 'waiting');
        guia.eq(3).data('tab', 'success');
        guia.eq(4).data('tab', 'failed');
        history.replaceState({num: ''}, "title", "/order/checkout");
        btnConfirm.prop('disabled', true);

        $(window).load(function () {
            if ($.trim(tab)) {
                $.each(guia, function (key, val) {
                    if (guia.eq(key).data('tab') === tab) {
                        guia.eq(key).click();
                    }
                });
            }
            else {
                $('.cabeza-guia').eq(0).click();
            }
        });

        {{--modal--}}
        $('.button').click(function () {
            if ($(voucher).is(':checked')) {
                var buttonId = 'one';
                $('#modal-container').removeAttr('class').addClass(buttonId);
                $('body').addClass('modal-active');
                $('.modal').find('input').val('').next().hide()
            }
            else {
                swallCustom2('Harap Pilih Transaksi Terlebih Dahulu')
            }
        });

        $('#modal-container .modal').click(function () {
            return false;
        });

        modalpage.click(removeModal);

        modalpage.find('.modal').on('click', '.button-failed', removeModal);
        {{--end modal--}}

        {{-- confirm - method select --}}
        confrimObj.on('click', '.pagamento-metodo', function () {
            $(this).children('input:radio').prop('checked', true);
        });
        {{-- end confirm - method select --}}

        {{-- confirm - tf select --}}
        confrimObj.on('click', '.pagamento-cotenta', function () {
            $(this).children('input:radio').prop('checked', true);
        });
        {{-- end confirm - tf select --}}

        {{-- confirm - condition confrimObj list are check all --}}
        confrimObj.on('change', voucher, function () {
            let otherObj = $('input[name=select_item]:checked'), objCheck = otherObj.size(),
                addVal = parseInt($(this).parent().next().find('.contido-custo').data('total'));

            totalConfirm = 0;

            for ($i = 0; $i < objCheck; $i++) {
                totalConfirm += otherObj.eq($i).parent().next().find('.contido-custo').data('total');
                console.log(otherObj.eq($i).parent().next().find('.contido-custo').data('total'))
            }


            objCheck === $('input[name=select_item]').length ?
                confrimObj.find('#checkall').prop('checked', true) :
                confrimObj.find('#checkall').prop('checked', false);
            excConfCheck(objCheck);
            countTotal()

        });

        {{-- confirm all checked --}}
        confrimObj.on('click', '#checkall', function () {
            let onjCheckAll = $(this).closest('.tarxeta-titulo').next().find('input[type=checkbox]');
            totalConfirm = 0;
            if ($(this).is(':checked')) {
                onjCheckAll.prop('checked', true);
                for ($i = 0; $i < onjCheckAll.length; $i++) {
                    totalConfirm += onjCheckAll.eq($i).parent().next().find('.contido-custo').data('total');
                }
            } else {
                $(this).closest('.tarxeta-titulo').next().find('input[type=checkbox]').prop('checked', false);
            }
            excConfCheck($('input[name=select_item]:checked').length);
            countTotal()
        });

        {{-- end confirm all checked --}}

            confrimObj.on('click', radioMethod,function () {

            excConfCheck($('input[name=select_item]:checked').length);

        });

        function excConfCheck(objCheck) {
            confrimObj.find('.pick-contido')
                .html(objCheck + ' Transaksi dipilih<span class="pull-right rpcontent">' +
                    convertRp(totalConfirm) + '</span>').hide().fadeIn(300).data('nominal', totalConfirm);

            objCheck > 0 && confrimObj.find('input[name="obj_metodo"]').is(':checked')?
                btnConfirm.prop('disabled', false) :
                btnConfirm.prop('disabled', true);
        }

        paymentObj.on('click', '.add-sub', function () {
            $(this).toggleClass('activo').next().toggle(300);
        });

        {{-- end confirm - condition confirm list are check all --}}

        {{--FUNC for close modal--}}
        function removeModal() {
            modalpage.addClass('out');
            $('body').removeClass('modal-active');
        }

        {{--end FUNC for close modal--}}

        function countTotal() {
            setTimeout(function () {
                let amountConf = confrimObj.find('.pick-contido').data('nominal'),
                    discObj = modalpage.data('val'),
                    endTotal = 0;
                const detailType = "Diskon";

                if ((typeof discObj !== "undefined") || discObj === '') {
                    let discTotal = amountConf * (100 - discObj.amount) / 100,
                        cutTotal = amountConf - discObj.amount;
                    endTotal = discObj.type === detailType ? discTotal : cutTotal;
                    confrimObj.find('.contido-custo-ben').text(convertRp(endTotal)).hide().fadeIn(300);
                }
                else {
                    confrimObj.find('.contido-custo-ben').text(convertRp(amountConf)).hide().fadeIn(300);
                }
            }, 100);
        }

    });
</script>