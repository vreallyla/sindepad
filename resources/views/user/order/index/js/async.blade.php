<script>
    $(function () {
        const dataInput12 = ['fullName', 'sex', 'packet', 'course', 'rs', 'needed', 'desc'];
        let currIndex = $("fieldset.current").index(),
            tabSelect = $('#signup').find('li'),
            spanTarget = currIndex;
        window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + '{{$token}}';

        $("body").on("keyup", "form", function (e) {
            if (e.which == 13) {
                if ($("#next").is(":visible") && $("fieldset.current").find("input, textarea").valid()) {
                    e.preventDefault();
                    checkAsync();
                    return false;
                }
            }
        });

        $('#signup').on('submit', function () {
            sendAsync();
            return false;
        });

        $("#next").on("click", function (e) {
            checkAsync();
        });

        $("#section-tabs li").on("click", function (e) {
            contentClick($(this).index());
        });

        function sendAsync(methodSend, step) {
            let FormLenght = $('#step1 dd').length,
                formData = new FormData($('#signup')[0]),
                tabIndex = $("fieldset.current").index();
            formData.append('length', FormLenght);
            formData.append('step', step);
            formData.append('indexForm', tabIndex);
            $('#loading').toggle();

            axios.post('{{route('api.order.register.save')}}', formData)
                .then(function (response) {
                    noticeHanddler();
                    window.history.replaceState('', '', '/');
                    swallCustom2('Pendaftaran Berhasil');
                    setTimeout(function () {
                        window.location = "{{route('order.checkout')}}"
                    }, 300)
                })
                .catch(function (error) {
                    noticeHanddler();
                    catchHanddler(error.response.data);
                })
        }

        function checkAsync() {
            let FormLenght = $('#step1 dd').length,
                formData = new FormData($('#signup')[0]),
                tabIndex = $("fieldset.current").index();
            formData.append('length', FormLenght);
            formData.append('indexForm', tabIndex);
            $('#loading').show();

            axios.post('{{route('api.order.register.check')}}', formData)
                .then(function (res) {
                    noticeHanddler();
                    nextSection();
                    currIndex = currIndex + 1;
                })
                .catch(function (er) {
                    noticeHanddler();
                    catchHanddler(er.response.data);
                })

        }

        function conditionHanddler(objk, par, key, val, fill, value) {
            if (key === val) {
                $(objk).closest(par).find('.' +
                    'help-block').show().children().text(value);
                spanTarget = spanTarget > fill ? fill : spanTarget;
            }
        }

        function catchHanddler(er) {
            var FormLenght = $('#step1 dd').length;
            var timer = 300;
            spanTarget = currIndex;
            $.each(er, function (key, value) {

                $.each(dataInput12, function (i, val) {
                    // conditionHanddler('.choose_days', '.radio-multiple', key, 'day', 1, value);
                    // conditionHanddler('.choose_times', '.radio-multiple', key, 'time', 1, value);
                    let objAll = $('#step1 ').find('.' + key);

                    if (key === val) {
                        objAll.parent().children('.help-block').show().children().text(value);
                        spanTarget = spanTarget > 0 ? 1 : 0;
                    }

                    for ($i = 0; $i < FormLenght; $i++) {
                        if (key === val + '.' + $i) {
                            $('.' + val).eq($i).closest('.add-margin-bottom-sm').find('.help-block').show().children().text(value);
                            spanTarget = spanTarget > 0 ? 1 : 0;
                        }
                    }
                });
                if (key === 'aggrement') {
                    spanTarget = 0;
                }
            });
            spanTarget === 0 ? swallCustom2('Harap centang setuju untuk mendaftar') : swallCustom2('Harap lengkapi formulir');
            clickTab(spanTarget, 300);
        }


        function noticeHanddler() {
            $('#loading').hide();
            $('#step1').find('.help-block').hide().children().text('');
            $('#step2').find('.help-block').hide().children().text('');
        }

        function clickTab(i, timer) {
            setTimeout(function () {
                if (!tabSelect.eq(i).hasClass('current')) {
                    contentClick(i);
                }
            }, timer);
        }

        function contentClick(i) {
            if (tabSelect.eq(i).hasClass("active")) {
                if (currIndex !== i) {
                    currIndex = i;
                    $("fieldset.current").addClass('bounceOutLeft');
                    goToSection(i);
                }
            } else {
                swallCustom2('isi form yang tersedia terlebih dahulu!');
            }
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