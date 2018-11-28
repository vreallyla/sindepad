<script>
    $(function () {
        const errInput = 'Harap mengisi formulir dengan benar',
            errServ = 'Terdapat kesalahan, harap muat ulang / kontak admin',
            limitImg = 'Ukuran gambar maks 2 mb.',
            noticeSucc='Bukti Pembayaran berhasil dikirim.',
            loadingCont = $('#loading');
        window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + '{{$token}}';

        $('#confirm').on('submit', function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            loadingCont.show();
            formData.append('q', '{{$data->code}}');
            axios.post('{{route('api.order.confirmPayment')}}', formData)
                .then(function (response) {
                    loadingCont.hide();
                    swallCustom(noticeSucc);
                    setTimeout(e=>{
                       window.location="{{route('order.checkout').'?tab=waiting'}}";
                    });
                    console.log(response);
                })
                .catch(function (er) {
                    loadingCont.hide();
                    er.response.status === 422 ?
                        (er.response.data.img_ ? swallCustom(limitImg) :
                            swallCustom(errInput)) :
                        swallCustom(errServ);
                    console.log(er.response);
                });
            return false;
        })
    })
</script>