<script>
    $(function ($) {
        let labelFirst = $('#step1'),
            tab_step = getUrlParameter('tab'),
            get_step = 1,
            selpick = [];

        const step3 = $('#step3'),
            sub_list = step3.find('.payment-step').children('.payment-header')
                .find('.payment-detail'),
            sub_nominal = sub_list.eq(0).children('h5'),
            total_all = step3.find('.payment-total').children('span'),
            sub_entity = sub_list.eq(1).children('h5');

        sub_nominal.data('nominal',{{isset($sub_total)?$sub_total:0}});
        targetTab = $('#section-tabs').children('li'),
            targetFieldset = $('#fieldsets fieldset'),
            $titleContent = [
                '{{session('reg')['name']?session('reg')['name']:''}}',
            ];

        $.each([1, 2, 3], function (key, val) {
            get_step = tab_step == val ? val : get_step;
        });

        for ($i = 0; $i < get_step; $i++) {
            targetTab.eq($i).addClass('active');
            targetFieldset.eq($i).addClass('active').addClass('next');
        }

        targetTab.eq(get_step - 1).addClass('current').addClass('active').siblings().removeClass('current');
        targetFieldset.eq(get_step - 1).addClass('current').removeClass('next').siblings().removeClass('current');


        $(document).ready(function () {
            $('.accordion-title')[0].click();

            $('body,html').animate({
                scrollTop: $('#signup').offset().top - 80
            }, 1000);
            @foreach(session('reg')['needed']?session('reg')['needed']:[] as $row)
            selpick.push('{{$row}}');
            @endforeach
            $('select.selectpicker').selectpicker('val', selpick);
        });

        {{--trigger add accordion on step1 n step2--}}
        $('.add-order').on('click', function () {
            changeEntity(parseInt($('.entity-order').html()) + 1);
        });
        {{--trigger reduce accordion on step1 n step2--}}
        $('.min-order').on('click', function () {
            changeEntity(parseInt($('.entity-order').html()) - 1);
        });
        {{--change tittle accordion when name field required--}}
        $('dl').on('keyup', '.change-tittle', function () {
            targetTittle = $(this).closest('dd').prev();
            indexInput = $('#step1 dt').index(targetTittle);
            valTittle = $(this).val();

            if (!$.trim(valTittle)) {
                targetTittle.find('.content-accord').text('Pendaftaran#' + (indexInput + 1));
                $('#step2 dt:eq(' + indexInput + ')').find('.content-accord').text('Pendaftaran#' + (indexInput + 1));
                $titleContent[indexInput] = '';

            } else {
                targetTittle.find('.content-accord').text('Pendaftaran#' + (indexInput + 1) + ' : ' + valTittle);
                $('#step2 dt:eq(' + indexInput + ')').find('.content-accord').text('Pendaftaran#' + (indexInput + 1) + ' : ' + valTittle);
                $titleContent[indexInput] = valTittle;
            }

        });

        $('#step1').on('click', '.remove-accordion', function () {
            dtLable = $('#step1 dt');
            contentRemove = $(this).closest('dt');
            indexRemove = dtLable.index(contentRemove);
            contentRemove2 = $('#step2 dt').eq(indexRemove);
            entityOrder = dtLable.length;
            let anukan = $('#step1 dd');
            contentRemove.next().remove();
            contentRemove.remove();
            contentRemove2.next().remove();
            contentRemove2.remove();
            $('.entity-order').text(entityOrder - 1).hide().fadeIn('slow');
            $titleContent.splice((indexRemove), 1);

            flattenTitleAccord('#step1');
            flattenTitleAccord('#step2');
            changeNominal(anukan.length-1);

            showCloseAccord(anukan.length);
        });

        function flattenTitleAccord(target) {
            $(target).find('dt').each(function (i) {
                if (!$.trim($titleContent[i])) {
                    $(this).find('.content-accord').text('Pendaftar #' + (i + 1));
                } else {
                    $(this).find('.content-accord').text('Pendaftar #' + (i + 1) + ' : ' + $titleContent[i]);
                }
                // $(this).next().find('.change-tittle').attr('data-index', i)
            });
        }

        {{--manipulate accordion entity on step 1 n step2 --}}
        function changeEntity(i) {
            $('.selectpicker').selectpicker();
            valEntity = parseInt($('#step1 dd').length);
            $titleContent.push('');

            if (1 <= i && valEntity < i && valEntity < 3) {
                textAccord = 'Pendaftar #' + i;

                $('.entity-order').text(i).hide().fadeIn('slow');
                addAccordOnFirst(i);
                showCloseAccord(i);
                changeNominal(i);
            } else if (1 <= i && valEntity > i && valEntity <= 3) {
                reduceOrder(i);
                changeNominal(i);
            } else if (i < 1) {
                swallCustom2('minimal 1 pendaftar.');
            } else {
                swallCustom2('maksimal 3 pendaftar.');
            }
            setTimeout(() => {
                $('.selectpicker').selectpicker();
            }, 500);


        }

        function changeNominal(i) {
            total_all.text('Rp' + convertRp(parseInt(sub_nominal.data('nominal')) * i));
            sub_entity.text(i + 'x')
        }

        {{--adding or reducing accordion on step1--}}
        function addAccordOnFirst(i) {

            tittleAccord = labelFirst.find('dt').clone();
            contentAccord = labelFirst.find('dd').clone();
            contentAccord.find('.help-block').children().text('');

            labelFirst.find('dl').append('<dt>\n' +
                tittleAccord[0].innerHTML + '\n' +
                '</dt>\n' +
                '<dd class="accordion-content accordionItem is-expanded animateIn" id="accordion' + i + '" aria-hidden="false">\n' +
                contentAccord[0].innerHTML + '\n' +
                '</dd>');

            changeTitle(i, '#step1');
            changeContentOnFirst(i)

        }

        {{--changes content step1 ps:step1 n step2 not same--}}
        function changeContentOnFirst(i) {
            valContent = labelFirst.find('dd').eq(i - 1);
            valContent.find('input').val('');
            valContent.find('option:disabled').removeProp('disabled').prop('selected', 'selected').prop('disabled');
            valContent.find('.selectpicker').attr('name', 'needed[' + (i - 1) + '][]').next().css('display', 'none')
        }

        {{--reduce entity accordion on step1 n step2--}}
        function reduceOrder(i) {
            $('.entity-order').text(i).hide().fadeIn('slow');
            labelFirst.find('dt').eq(i).remove();
            labelFirst.find('dd').eq(i).remove();
            $titleContent.splice(i, 1);
            showCloseAccord(i);
        }

        {{--reset title accordion in step1 an step2--}}
        function changeTitle(i, target) {
            titleContent = $(target).find('dt').eq(i - 1);

            titleContent.find('a')
                .attr('href', '#accordion' + i)
                .attr('aria-expanded', 'true')
                .attr('aria-controls', 'accordion' + i)
                .not('.is-collapsed, .is-expanded')
                .addClass('is-collapsed is-expanded');

            titleContent.find('.content-accord')
                .html(textAccord);
        }

        {{--toggle close accordion when entity more than one--}}
        function showCloseAccord(i) {

            i > 1 ?
                $('#step1').find('.remove-accordion').fadeIn('slow') :
                $('#step1').find('.remove-accordion').fadeOut('slow');
        }

    });

    let getUrlParameter = $.getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
    };

</script>