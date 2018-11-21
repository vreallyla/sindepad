<script>
   $(function () {
       const errInput='Harap mengisi formulir dengan benar',
           errServ='Terdapat kesalahan, harap muat ulang / kontak admin';
       window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + '{{$token}}';

       $('#confirm').on('submit',function (e) {
           e.preventDefault();
           let formData = new FormData(this);
           formData.append('code','{{$data->code}}');
           axios.post('{{route('api.order.confirmPayment')}}', formData)
               .then(function (response) {
                   console.log(response);
               })
               .catch(function (er) {
                   er.response.status===422?swallCustom(errInput):swallCustom(errServ);
                   console.log(error.response);
               });
           return false;
       })
   })
</script>