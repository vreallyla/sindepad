if ($(document).width() > 451) {
    $(function () {
        const urlNotice = '/api/v1/admin/notice-check/'
            , audio = new Audio('/notif/unsure.mp3')
        ;

        let dataTrans = {qty: 0}, dataShadows = {qty: 0},
            getNoticeTrans = function (con) {
                const urlSide = 'transactions';
                axios.get(urlNotice + urlSide)
                    .then(res => {
                        let Dat = res.data, qty = 0, tol = '';

                        $.each(Dat, function (i, val) {
                            if (val.notice) {
                                qty += val.quantity;
                                tol += (i.indexOf(' ') > 0 ? i.substr(0, i.indexOf(' ')) : i) + ':  ' + val.quantity + ' Transaksi | '
                            }

                        });


                        if (dataTrans.qty !== qty) {

                            if (con && dataTrans.qty < qty) {
                                swallNotice('Ada Transaksi Baru', qty + ' transaksi belum di konfirmasi');
                                audio.play();
                            }
                            let newTrans = tol.substr(0, (tol.length - 3));

                            dataTrans.qty = qty;
                            $('.fa-briefcase').parent().next().text(qty).closest('.add-shorcut')
                                .attr('data-original-title', newTrans);
                        }
                    }).catch(er => {
                    erra(er.response);
                });
            }, getNoticeShadow = function (con) {
                const urlSide = 'shadow';
                axios.get(urlNotice + urlSide)
                    .then(res => {
                        let Dat = res.data;

                        if (dataShadows.qty !== Dat.quantity) {
                            if (con && dataShadows.qty < Dat.quantity) {
                                let newStudent = Dat.list[Dat.list.length - 1].name;
                                swallNotice('Ada Peserta Didik Baru', newStudent + ' baru ditambahkan.');
                                audio.play();
                            }
                            dataShadows.qty = Dat.quantity;
                            $('.fa-user-plus').parent().next().text(Dat.quantity).closest('.add-shorcut')
                                .attr('data-original-title', (Dat.quantity > 0 ? 'terdapat ' + Dat.quantity + ' perseta didik yang belum diatur' : ''));

                        }
                    }).catch(er => {
                    console.log(er);
                    erra(er.response);

                });
            }
        ;

        $(document).ready(function () {
            getNoticeTrans(false);
            getNoticeShadow(false);
            setInterval(function () {
                getNoticeTrans(true);
                getNoticeShadow(true);
            }, 7000)
        });
    });
}