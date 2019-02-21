if ($('body').find('#side-profile').length > 0) {
    $(function () {
        const targetObj = $('#side-profile'), inputTarget = $('.left-user-desc'),
            urlApi = '/api/v1/shadow/profile/',
            loadingPart = $('#loading'), targetAcc = $('.target-menu');

        $(document).ready(function () {
            $('[name="phone"]').mask('000-0000-000000');

            $('.datepicker').datepicker({
                language: 'id',
                format: 'dd/mm/yyyy'
            });
        });

        $('[name="img"]').on('change', function () {
            const urlSide = 'change-photo';
            let formFunc = new FormData();
            loadingPart.show();

            formFunc.append('img', $(this)[0].files[0]);
            formFunc.append('_method', 'PUT');

            axios.post(urlApi + urlSide, formFunc)
                .then(res => {
                    loadingPart.hide();
                    swallCustom(res.data.msg);
                    $(this).next().prop('src', res.data.data.img);
                    $('.circular--portrait').children().prop('src', res.data.data.img);
                }).catch(er => {
                loadingPart.hide();
                anim('animated shake', targetObj, 'animated shake');
                if (er.response) {
                    if (er.response.status === 422) {
                        swallCustom(er.response.data.img);
                    } else {
                        swallCustom('Terjadi kesalahan, silakan refresh / kontak admin')
                    }
                } else {
                    swallCustom('Terjadi kesalahan, silakan refresh / kontak admin')
                }

            });

        });

        $('#biodata').on('submit', 'form', function (e) {
            e.preventDefault();
            const urlSide = 'update-profil';
            let formFunc = new FormData($(this)[0]);
            $(this).find('.help-block').text('');
            formFunc.append('_method', 'PUT');
            loadingPart.show();
            axios.post(urlApi + urlSide, formFunc)
                .then(res => {
                    loadingPart.hide();
                    swallCustom(res.data.msg);
                    let textFill = targetObj.find('[name="name"]').val();
                    targetObj.find('.desc-user').children().eq(0).children().eq(1).text(textFill);
                    $('.profile-up').find('.name-up').text(textFill.indexOf(' ')>0?'Sdr/i '+textFill.substr(0,textFill.indexOf(' ')):textFill);
                }).catch(er => {
                anim('animated shake', targetObj, 'animated shake');
                erInputCus(er.response, $(this));
            });
        });

        $('#password').on('submit', 'form', function (e) {
            e.preventDefault();
            const urlSide = 'change-password';
            let formFunc = new FormData($(this)[0]);
            formFunc.append('_method', 'PUT');
            $(this).find('.help-block').text('');
            loadingPart.show();
            axios.post(urlApi + urlSide, formFunc)
                .then(res => {
                    loadingPart.hide();
                    swallCustom(res.data.msg);
                    $(this).find('input').val('');
                }).catch(er => {
                anim('animated shake', targetObj, 'animated shake');
                erInputCus(er.response, $(this));
            });
        });

        $('input[type="checkbox"]').on('change', function () {
            const tartFunc = $(this).parent().prev();
            if ($(this).is(':checked')) {
                tartFunc.prop('type', 'text');
            } else {
                tartFunc.prop('type', 'password');
            }

        });

        $('.tab-menu').on('click', 'li', function () {
            $(this).addClass('activo').siblings().removeClass('activo');
            // console.log($(this).data('target'));
            targetAcc.children().not('.left-user-desc').hide();
            targetAcc.find('#' + $(this).data('target')).fadeIn(500);
        });

    });
}
