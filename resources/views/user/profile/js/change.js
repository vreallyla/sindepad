$(function ($) {
    $('.image-upload').on('change', '#file-input', function () {
        $('#loading').show();
        var formData = new FormData();
        var imagefile = document.querySelector('#file-input');
        formData.append('img', imagefile.files[0]);
        axios.post('/api/profile/change-photo', formData)
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