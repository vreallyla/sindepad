<script>
    $(function () {
        const dataInput12 = ['name', 'sex', 'packet', 'course', 'rs', 'needed', 'desc', 'day', 'time'];
        const dataInput3 = ['code', 'an', 'paying_method'];
        var codeVoucher = $('#step3 input[name=code]');
        var stepTwo = $('#step2');
        var currIndex = $("fieldset.current").index();
        var tabSelect = $('#signup').find('li');
        var spanTarget = currIndex;
        window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + '{{$token}}';

        $("body").on("keyup", "form", function (e) {
            if (e.which == 13) {
                if ($("#next").is(":visible") && $("fieldset.current").find("input, textarea").valid()) {
                    e.preventDefault();
                    sendForm();
                    return false;
                }
            }
        });

        $("#next").on("click", function (e) {
            sendForm();
        });

        $("#section-tabs li").on("click", function (e) {
            contentClick($(this).index());
        });

        codeVoucher.closest('.form-group').on('click', 'button', function () {
            checkCode();
        });

        $('#step2').on('change', '.choose_days', function () {
            var dayIndex = $('#step2').find('dd').index($(this).closest('dd'));
            var courseVal = $('#step1').find('dd').eq(dayIndex).find('.course').val();
            var timeObj = $(this).closest('dd').find('.select-radio').eq(1);
            var timeContent = timeObj.find('.radio-multiple').children().clone();
            var dataWaktu = '';
            var timeNotice = '<span class="help-block" style="padding-left: 9px"\n' +
                '                                                                      style="display: none">\n' +
                '                                                                <strong></strong>\n' +
                '                                                            </span>';
            $('#loading').show();
            axios.get('{{route('order.checkDay')}}?day=' + $(this).val() + '&course=' + courseVal)
                .then(function (res) {

                    $('#loading').hide();

                    $.each(res.data, function (key, value) {
                        var timeInputObj = timeContent.eq(0).find('input').val(value.datras.code);
                        value.status ? timeInputObj.prop('disabled', false) : timeInputObj.prop('disabled', true);
                        timeContent.eq(0).find('span').text(value.datras.content);
                        dataWaktu += '<label>\n' +
                            timeContent[0].innerHTML + '\n' +
                            '</label>';
                    });
                    timeObj.find('.radio-multiple').empty().append(dataWaktu + '\n' + timeNotice);
                    timeObj.hide().fadeIn('slow');
                })
                .catch(function (er) {
                    $('#loading').hide();
                    timeObj.hide();
                    if (er.response.data.course) {
                        $('#signup').find('li').eq(0).click();
                        swalcustom('Harap mengisi data', 'B9F448', '3C3C3C');
                    } else {
                        $.each(er.response.data, function (key, val) {
                            swalcustom(val, 'B9F448', '3C3C3C');
                            return false;
                        });
                    }

                });
        });

        $('#step1').on('change', '.course', function () {
            var scheIndex = $('#step1').find('dd').index($(this).closest('dd'));
            var dayVal = $('#step2').find('dd').eq(scheIndex).find('.choose_days:checked').val();
            var objTime = $('#step2').find('dd').eq(scheIndex).find('.select-radio').eq(1).find('.radio-multiple').find('input');
            // console.log(dayVal);
            var scheTarget = $('#step2').find('dd').eq(scheIndex);
            $('#loading').toggle();
            axios.get('{{route('order.checkProgram')}}?course=' + $(this).val() + '&day=' + dayVal)
                .then(function (res) {
                    $('#loading').hide();
                    console.log(res)
                    $.each(res.data, function (key, val) {
                        val.status ? objTime.eq(key).prop('disabled', false) : objTime.eq(key).prop('disabled', true);
                    })
                })
                .catch(function (er) {
                    $('#loading').hide();
                    console.log(er.response.data)
                })
        });


        function sendAsync(methodSend, step) {
            var FormLenght = $('#step1 dd').length;
            var formData = new FormData($('#signup')[0]);
            var tabIndex = $("fieldset.current").index();
            formData.append('length', FormLenght);
            formData.append('step', step);
            formData.append('sendType', methodSend);
            $('#loading').toggle();

            axios.post('{{route('order.overwrite')}}', formData)
                .then(function (response) {
                    noticeHanddler();
                    console.log(response);
                    nextSection();
                    currIndex = currIndex + 1;
                })
                .catch(function (error) {
                    noticeHanddler();
                    console.log(error.response.data);
                    catchHanddler(error.response.data);
                })
        }

        function checkAsync() {
            var FormLenght = $('#step1 dd').length;
            var formData = new FormData($('#signup')[0]);
            var tabIndex = $("fieldset.current").index();
            formData.append('length', FormLenght);
            formData.append('indexForm', tabIndex);
            formData.append('sendType', 'next');
            $('#loading').show();

            axios.post('{{route('order.validate')}}', formData)
                .then(function (res) {
                    console.log(res);
                    $('#loading').hide();
                    nextSection();
                    currIndex = currIndex + 1;
                })
                .catch(function (er) {
                    $('#loading').hide();
                    console.log(er.response.data);
                    catchHanddler(er.response.data);
                })

        }

        function conditionHanddler(objk, par, key, val, fill, value) {
            if (key === val) {
                console.log(key+ ' = = '+ val);
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
                $.each(dataInput3, function (z, vals) {
                    conditionHanddler('#step3 input[name=' + key + ']', '.form-group', key, vals, 2, value)
                });
                $.each(dataInput12, function (i, val) {
                    conditionHanddler('.choose_days', '.radio-multiple', key, 'day', 1, value);
                    conditionHanddler('.choose_times', '.radio-multiple', key, 'time', 1, value);
                    if (key === val && val !== 'day' && val !== 'time') {
                        $('#step1 .' + key).closest('.add-margin-bottom-sm').find('.help-block').show().children().text(value);
                        spanTarget = spanTarget < 0 ? 0 : spanTarget;
                    }
                    for ($i = 0; $i < FormLenght; $i++) {
                        conditionHanddler('.choose_days', '.radio-multiple', key, 'day.' + $i, 1, value);
                        conditionHanddler('.choose_times', '.radio-multiple', key, 'time.' + $i, 1, value);
                        if (key === val + '.' + $i && val !== 'day' + $i && val !== 'time' + $i) {
                            $('.' + val).eq($i).closest('.add-margin-bottom-sm').find('.help-block').show().children().text(value);
                            spanTarget = spanTarget < 0 ? 0 : spanTarget;
                        }
                    }
                });
            });
            clickTab(spanTarget, 300);
        }


        function noticeHanddler() {
            $('#loading').hide();
            $('#step1').find('.help-block').hide().children().text('');
            $('#step2').find('.help-block').hide().children().text('');
        }

        function checkCode(e) {
            formCode = new FormData();
            formCode.append('code', codeVoucher.val());
            $('#loading').toggle();

            axios.post('{{route('order.voucher')}}', formCode)
                .then(function (res) {
                    noticeCheckVoucher('Voucher telah diaplikasikan');
                }).catch(function (er) {
                noticeCheckVoucher(er.response.data.code);
            })
        }

        function noticeCheckVoucher(e) {
            $('#loading').hide();
            codeVoucher.closest('.form-group').find('.help-block').css('display', 'unset').children().text(e);
        }

        function sendForm() {
            if ($("#signup li").eq(currIndex + 1).hasClass('active')) {
                checkAsync();
            }
            else {
                sendAsync('next', (currIndex + 1));
            }
        }

        function clickTab(i, timer) {
            setTimeout(function () {
                if (!tabSelect.eq(i).hasClass('current')) {
                    contentClick(i);
                }
            }, timer);
        }

        function contentClick(i) {
            console.log(currIndex + ' dasda ' + i);
            if (tabSelect.eq(i).hasClass("active")) {
                if (currIndex !== i) {
                    currIndex = i;
                    $("fieldset.current").addClass('bounceOutLeft');
                    goToSection(i);
                }
            } else {
                swalcustom('isi form yang tersedia terlebih dahulu!', 'B9F448', '3C3C3C');
            }
        }

    });

</script>