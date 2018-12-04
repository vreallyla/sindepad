if ($('body').find('#aggrement').length > 0) {
    $(function () {
        const targetObj = $('#aggrement'),
            triggerBtn = targetObj.find('.btn-save-aggrement'),
            loadPart = $('#loading'),
            errNotice = 'terdapat kesalahan. silakan muat ulang / kontak admin',
            sucNotice = 'berhasil dibuat', placeRight = $('.place-right'),
            // urlPage = '/simdepad/admin/settings/aggrement',
            urlApi = '/api/v1/admin/settings/';

        triggerBtn.click(function () {
            let formD = new FormData(targetObj.find('form')[0]);
            formD.append('detail', tinyMCE.activeEditor.getContent());
            loadPart.show();
            axios.post(urlApi + 'aggrement-post', formD)
                .then(e => {
                    loadPart.hide();
                    swallCustom(sucNotice);
                })
                .catch(er => {
                    loadPart.hide();
                    swallCustom(errNotice);
                });
        })
    });
}