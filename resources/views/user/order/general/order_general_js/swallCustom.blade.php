<script>
    function swallCustom(msg) {
        swal({
            defaultStyling: false,
            html: '<h5 style="color: #' + 'fff' + ';font-size:1.7em">' + msg + '</h5>',
            animation: false,
            showConfirmButton: false,
            background: '#555454',
            customClass: 'animated rubberBand',
            timer: 2500

        });
        $('.swal2-popup').css('border-radius', '7px');
        $('.swal2-container').css('background-color', 'transparent');
    }
</script>