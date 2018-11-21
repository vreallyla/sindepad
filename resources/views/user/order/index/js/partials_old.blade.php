<script>
    $(function ($) {
        var labelFirst = $('#step1');
        var labelSecond = $('#step2');
        var targetTab = $('#section-tabs').children('li');
        var targetFieldset = $('#fieldsets fieldset');
        var $titleContent = [
            @if(session('order'))
                    @foreach(session('order')['data'] as $i=> $row)
                '{{array_key_exists('name',$row) ? ' : '.session('order')['data'][$i]['name']:''}}',
            @endforeach
            @endif];

        @for($i=0;$i<$step;$i++)
        targetTab.eq({{$i}}).addClass('active');
        targetFieldset.eq({{$i}}).addClass('active').addClass('next');
        @endfor

        targetTab.eq({{$step-1}}).addClass('current').addClass('active').siblings().removeClass('current');
        targetFieldset.eq({{$step-1}}).addClass('current').removeClass('next').siblings().removeClass('current');

        $(window).on('load', function () {
            $('.accordion-title')[0].click();

            $('body,html').animate({
                scrollTop: $('#signup').offset().top - 80
            }, 1000);

        });
        {{--trigger add accordion on step1 n step2--}}
        $('.add-order').on('click', function () {
            changeEntity(parseInt($('.entity-order').html()) + 1);
        });
        {{--trigger reduce accordion on step1 n step2--}}
        $('.min-order').on('click', function () {
            changeEntity(parseInt($('.entity-order').html()) - 1);
        });
        {{--set checkbox on step2 to once choice--}}
        $('#step2').on('click', '.choose_days', function () {
            $(this).prop('checked', true).closest('.radio-multiple').find('.choose_days').not(this).prop('checked', false);
            $(this).prop('checked', true);
        });
        $('#step2').on('click', '.choose_times', function () {
            $(this).prop('checked', true).closest('.radio-multiple').find('.choose_times').not(this).prop('checked', false);
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

            contentRemove.next().remove();
            contentRemove.remove();
            contentRemove2.next().remove();
            contentRemove2.remove();
            $('.entity-order').text(entityOrder - 1).hide().fadeIn('slow');
            $titleContent.splice((indexRemove), 1);

            flattenTitleAccord('#step1');
            flattenTitleAccord('#step2');

            showCloseAccord($('#step1 dd').length);
        });

        function flattenTitleAccord(target) {
            $(target).find('dt').each(function (i) {
                if (!$.trim($titleContent[i])) {
                    $(this).find('.content-accord').text('Pendaftar #' + (i + 1));
                }
                else {
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
                addAccordOnSecond(i);
                showCloseAccord(i);
            }
            else if (1 <= i && valEntity > i && valEntity <= 3) {
                reduceOrder(i);
            }
            else if (i < 1) {
                swalcustom('minimal 1 pendaftar.', 'B9F448', '3C3C3C');
            }
            else {
                swalcustom('maksimal 3 pendaftar.', 'B9F448', '3C3C3C');
            }
            setTimeout(() => {
                $('.selectpicker').selectpicker();
            }, 500);
        }

        {{--adding or reducing accordion on step1--}}
        function addAccordOnFirst(i) {

            tittleAccord = labelFirst.find('dt').clone();
            contentAccord = labelFirst.find('dd').clone();

            labelFirst.find('dl').append('<dt>\n' +
                tittleAccord[0].innerHTML + '\n' +
                '</dt>\n' +
                '<dd class="accordion-content accordionItem is-expanded animateIn" id="accordion' + i + '" aria-hidden="false">\n' +
                contentAccord[0].innerHTML + '\n' +
                '</dd>');

            changeTitle(i, '#step1');
            changeContentOnFirst(i)

        }

        {{--adding or reducing accordion on step2--}}
        function addAccordOnSecond(i) {
            tittleAccordSecond = labelSecond.find('dt').clone();
            contentAccordSecond = labelSecond.find('dd').clone();
            contentAccordSecond.find('.select-radio').eq(1).hide();
            labelSecond.find('dl').append('<dt>\n' +
                tittleAccordSecond[0].innerHTML + '\n' +
                '</dt>\n' +
                '<dd class="accordion-content accordionItem is-expanded animateIn" id="accordion' + i + '" aria-hidden="false">\n' +
                contentAccordSecond[0].innerHTML + '\n' +
                '</dd>');

            changeTitle(i, '#step2');
            changeContentOnSecond(i)
        }

        {{--changes content step1 ps:step1 n step2 not same--}}
        function changeContentOnFirst(i) {
            valContent = labelFirst.find('dd').eq(i - 1);
            valContent.find('input').val('');
            valContent.find('option:disabled').removeProp('disabled').prop('selected', 'selected').prop('disabled');
            valContent.find('.selectpicker').attr('name', 'needed[' + (i - 1) + '][]').next().css('display', 'none')
        }

        {{--changes content step2 ps:step1 n step2 not same--}}
        function changeContentOnSecond(i) {
            valContent = labelSecond.find('dd').eq(i - 1);
            valContent.find('input:checkbox').prop('checked', false);
        }

        {{--reduce entity accordion on step1 n step2--}}
        function reduceOrder(i) {
            $('.entity-order').text(i).hide().fadeIn('slow');
            labelFirst.find('dt').eq(i).remove();
            labelFirst.find('dd').eq(i).remove();
            labelSecond.find('dt').eq(i).remove();
            labelSecond.find('dd').eq(i).remove();

            // $titleIndex.splice(i, 1);
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
            if (i > 1) {
                $('#step1').find('.remove-accordion').fadeIn('slow');
            } else {
                $('#step1').find('.remove-accordion').fadeOut('slow');
            }
        }

    });

</script>