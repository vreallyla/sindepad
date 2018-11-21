<script>
    $(function () {
        const cont_copy = $('.content-rec');
        cont_copy.children('h5').click(function () {
            var $temp = $("<input/>");
            $("body").append($temp);
            $temp.val(cont_copy.find('kode').text()).select();
            document.execCommand("copy");
            let statusCopy = document.execCommand("copy");
            statusCopy ? swallCustom('Berhasil Disalin') : swallCustom('Gagal Disalin');
            $temp.remove();
        });
    })
</script>