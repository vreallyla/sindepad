@if(!empty($user_cookie))
    <script>
        window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + '{{$token}}';

        //change photo profil
        $(function ($) {
            $('.image-upload').on('change', '#file-input', function () {
                $('#loading').show();
                var formData = new FormData();
                var imagefile = document.querySelector('#file-input');
                formData.append('img', imagefile.files[0]);
                axios.post('{{route('edit.photo')}}', formData)
                    .then(function (res) {
                        obj = '.ed_profile_img img';
                        $('#loading').fadeOut('slow');
                        $(obj).attr('src', res.data.url).hide().fadeIn('slow');
                    })
                    .catch(function (error) {
                        $('#loading').fadeOut('slow');
                        error.response.data.img[0] ? swalcustom(error.response.data.img[0], 'fff', '202020f2') : swalcustom('ada kesalahan, coba muat ulang / kontak admin', 'fff', '202020f2');
                        testAnim('shake', '.image-upload img')
                    })
            });

        });

        //edit profil
        $(function ($) {
            $('#save_personal').click(function () {
                $('#form-personal-change form').submit(save_personal_data());
            });

            function save_personal_data() {
                $('#loading').toggle();

                axios.post('{{route('edit.profile')}}', new FormData($('#form-personal-change form')[0]))
                    .then(function (res) {
                        console.log(res);
                        $('#loading').fadeOut('slow');
                        change_personal_data(res.data.data);
                        $('.personal-change').click();
                    })
                    .catch(function (error) {
                        $('#loading').fadeOut('slow');
                        console.log(error.response.data);
                        notice_personal_notice(error.response.data);
                        testAnim('shake', '#personal-data ul, #personal-data .tab-content')
                    });
                return false;
            }

            function change_personal_data(res) {
                console.log(res.name);
                $('.aj_name').text(res.name);
                $('.aj_ttl').text(res.ttl);
                $('.aj_sex').text(res.sex);
                $('.aj_phone').text(res.phone);
                $('.aj_address').text(res.address);
                $('#form-personal-change .help-block').css('display', 'none').children().text('');

                $('.ed_sidebar_wrapper h3').text(res.name);
                $('#login_button .name-user').text(res.stad_name);
            }

            function notice_personal_notice(er) {
                console.log(er);
                if (er.name) {
                    $('input[name=name]').next().css('display', 'block').children().text(er.name[0]);
                }
                if (er.born_place) {
                    $('input[name=born_place]').next().css('display', 'block').children().text(er.born_place[0]);
                }
                if (er.date_birth) {
                    $('input[name=date_birth]').next().css('display', 'block').children().text(er.date_birth[0]);
                }
                if (er.sex) {
                    $('select[name=sex]').next().css('display', 'block').children().text(er.sex[0]);
                }
                if (er.email) {
                    $('input[name=email]').next().css('display', 'block').children().text(er.email[0]);
                }
                if (er.phone) {
                    $('input[name=phone]').next().css('display', 'block').children().text(er.phone[0]);
                }
                if (er.address) {
                    $('textarea[name=address]').next().css('display', 'block').children().text(er.address[0]);
                }

            }
        });

        //changes password
        $(function ($) {
            $('#password-change').on('change', 'input[type=checkbox]', function () {
                $(this).is(":checked") ? $(this).prev().attr('type', 'text') : $(this).prev().attr('type', 'password');
            });

            $('#password-change #save_password').click(function () {
                $('#password-change form').submit(post_password());
            });

            function post_password() {
                $('#loading').toggle();
                axios.post('{{route('edit.password')}}', new FormData($('#password-change form')[0]))
                    .then(function (res) {
                        $('#loading').fadeOut('slow');
                        swalcustom(res.data.msg, 'fff', '202020f2');
                        $('#password-change input[name=old_password], #password-change input[name=new_password]').val('');
                        $('#password-change input[type=checkbox]').prop('checked', false);
                    })
                    .catch(function (er) {
                        console.log(er.response);
                        $('#loading').fadeOut('slow');
                        swalcustom(er.response.data.error, 'fff', '202020f2');
                        testAnim('shake', '#personal-data ul, #personal-data .tab-content')
                    });

                return false;
            }
        });

        //data anak
        $(function ($) {
            var profile = $('.profile-child');

            profile.click(function () {
                $('#loading').toggle();
                axios.get('{{route('get.kid')}}?key=' + profile.index(this))
                    .then(function (res) {
                        console.log(res);
                        $('#loading').fadeOut('slow');
                        // swalcustom(res.data.msg, 'fff', '202020f2');
                        // $('#password-change input[name=old_password], #password-change input[name=new_password]').val('');
                        // $('#password-change input[type=checkbox]').prop('checked', false);
                    })
                    .catch(function (er) {
                        console.log(er.response);
                        $('#loading').fadeOut('slow');
                        // swalcustom(er.response.data.error, 'fff', '202020f2');
                        // testAnim('shake', '#personal-data ul, #personal-data .tab-content')
                    });

                return false;
            });
        })

    </script>
@endif