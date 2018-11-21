@include('user.order.general.order_general_js.swallCustom')
@include('user.order.general.order_general_js.copyNoRek')
<script>
    $(function () {
        $('.btn-canc').click(e=>{
            history.back();
        });
        $('.btn-conti').click(e=>{
           window.location='{{route('order.confirm').'?q='.$data->code}}'
        });
    })
</script>