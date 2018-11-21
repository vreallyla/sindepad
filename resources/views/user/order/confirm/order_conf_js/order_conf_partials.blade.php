@include('user.order.general.order_general_js.swallCustom')
@include('user.order.general.order_general_js.copyNoRek')
<script>
    $(document).ready(function () {
        $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                language: 'id'
            }
        );

    });

    $(function () {
        const modalpage = $('#modal-container'),
            accord = $('.side-content').find('.deslizamento'),
            headSel = $('.head-select'),
            contSel = headSel.next();
        {{--accordion trigger--}}
        accord.click(function () {
            $(this).toggleClass('activo').hasClass('activo') ?
                $(this).next().slideDown(300) :
                $(this).next().slideUp(300);
        });
        {{--end accordion trigger--}}

        {{---set select custom--}}
        contSel.children('.content-select').find('input').on('change', function () {
            headSel.click();
        });
        headSel.on('click', function () {
            $(this).toggleClass('pick').hasClass('pick') ?
                $(this).next().slideDown(300) :
                $(this).next().slideUp(300)
                    .find('.fa-arrow-left').hide()
                    .next().hide().val('')
                    .next().fadeIn(700)
                    .next().hide()
                    .closest('.sub-select').removeClass('search-mode');
            excSearch('');
        });

        contSel.find('input[name="bank"]').on('change', function () {
            contSel.children('.content-select').children('label').removeClass('check');
            let changeSel = $(this).parent().addClass('check').text();
            headSel.children('h5').text(changeSel.length > 12 ?
                changeSel.substr(0, 11) + '..' :
                changeSel).hide().fadeIn(300);
        });
        {{---set end select custom--}}

        {{---set select custom search--}}
        contSel.on('click', '.fa-search', function () {
            $(this).hide().prev().fadeIn(300).focus().prev().fadeIn(300).closest('.sub-select').addClass('search-mode');
        });
        contSel.children('.search-select').on('blur', 'input', function () {
            $(this).prop('placeholder', 'Cari disini');
        });
        contSel.children('.search-select').on('focus', 'input', function () {
            $(this).prop('placeholder', '');
        });
        contSel.children('.search-select').on('keyup', 'input', function () {
            let closSel = $(this).siblings('.fa-times-circle');

            $.trim($(this).val()) ? closSel.show() : closSel.hide();
            excSearch($(this).val().toLowerCase());
        });
        contSel.find('.fa-arrow-left').click(function () {
            $(this).hide().next().hide().val('').next().fadeIn(300).next().hide().closest('.sub-select').removeClass('search-mode');
            excSearch('');
        });
        contSel.find('.fa-times-circle').click(function () {
            $(this).hide().siblings('input[name="search_select"]').val('').focus();
            excSearch('');
        });

        function excSearch(objSel) {
            let selLabel = contSel.children('.content-select').children('label'),
                entitySel = 0;
            selLabel.filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(objSel) > -1);
                if (!$(this).is(":visible")) {
                    entitySel += 1;
                }
            });
            entitySel === selLabel.length ?
                contSel.find('h4').show() :
                contSel.find('h4').hide();


        }

        {{---end set select custom search--}}


        {{--modal--}}
        $('.ex-invoice').click(function () {
            var buttonId = 'one';
            $('#modal-container').removeAttr('class').addClass(buttonId);
            $('body').addClass('modal-active');
        });

        $('#modal-container .modal').click(function () {
            return false;
        });

        modalpage.click(removeModal);

        modalpage.find('.modal').on('click', 'a', removeModal);

        {{--end modal--}}

        {{--FUNC for close modal--}}
        function removeModal() {
            modalpage.addClass('out');
            $('body').removeClass('modal-active');
        }
        {{--end FUNC for close modal--}}

    });

    function readURL(input) {
        if (input.files && input.files[0]) {

            var reader = new FileReader();

            reader.onload = function (e) {
                $('.image-upload-wrap').hide();

                $('.file-upload-image').attr('src', e.target.result)
                    .prop('alt', input.files[0].name);
                $('.file-upload-content').show();

            };
            reader.readAsDataURL(input.files[0]);

        } else {
            removeUpload();
        }
    }

    function removeUpload() {
        $('.file-upload-input').replaceWith($('.file-upload-input').clone().val(''));
        $('.file-upload-content').hide();
        $('.image-upload-wrap').show();
    }

    $('.image-upload-wrap').bind('dragover', function () {
        $('.image-upload-wrap').addClass('image-dropping');
    });
    $('.image-upload-wrap').bind('dragleave', function () {
        $('.image-upload-wrap').removeClass('image-dropping');
    });

</script>