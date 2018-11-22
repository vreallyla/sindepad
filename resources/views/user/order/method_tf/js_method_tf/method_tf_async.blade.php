@include('user.order.general.order_general_js.swallCustom')
<script>
    const metodo = $('.pagamento-metodo'),
        submit = $('.btn-submit'), obj_submit = 'button',
        errNotice = 'Terdapat Kesalahan, coba muat ulang / kontak admin',
        inputNotice = 'harap memilih metode dengan benar.',
        sucNotice = 'Metode Berhasil diganti',
        loadi=$('#loading'),
        obj=$('.pagamento-cotenta'),
        emptyNotice = 'data tidak terdaftar.';
    window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + '{{$token}}';

    let getUrlParameter = function getUrlParameter(sParam) {
        let sPageURL = window.location.search.substring(1),
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

    metodo.click(function () {
        metodo.removeClass('activo');
        $(this).addClass('activo').find('input').prop('checked', true);
    });



    submit.on('click', obj_submit, e => {
        let valChoice = $('input[name=obj_metodo]:checked').val(),
            form = new FormData();
        loadi.show();
        form.append('choice', valChoice);
        form.append('q', getUrlParameter('q'));
        axios.post('{{route('api.order.methodChange')}}', form)
            .then(function (res) {
                loadi.hide();
                swallCustom(sucNotice);
                setTimeout(function () {
                    window.location="{{route('order.checkout')}}?tab=payment";
                },300)
            })
            .catch(function (er) {
                loadi.hide();
                er.response.status === 422 ?
                    swallCustom(inputNotice) :
                    (er.response.status === 404 ?
                        swallCustom(emptyNotice) :
                        swallCustom(errNotice));
            })
    });

</script>