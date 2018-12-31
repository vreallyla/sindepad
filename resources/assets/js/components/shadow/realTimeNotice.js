if ($(document).width() > 451) {
    $(function () {
        const urlReal = '/api/v1/shadow/check-notice/',
            noticeTitleStudent = 'Ada Peserta Didik Baru', noticeMsgStudent = 'ditambah dalam pengawasan anda'
            , audio = new Audio('/notif/unsure.mp3')

        ;

        let noticeStudent = {quantity: '', data: {}}, noticeMonitoring = {qty: 0, data: []},
            getNoticeStudent = function (con) {
                const urlSide = 'student';
                axios.get(urlReal + urlSide)
                    .then(res => {

                        let Dat = res.data;

                        if (noticeStudent.quantity !== Dat.quantity) {
                            if (con && noticeStudent.quantity < Dat.quantity) {
                                let newStudent = Dat.list[Dat.list.length - 1].name;
                                swallNotice(noticeTitleStudent, newStudent + noticeMsgStudent);
                                audio.play();
                            }
                            noticeStudent.quantity = Dat.quantity;
                            let tol = $('.fa-user-plus').parent().next().text(Dat.quantity).closest('.add-shorcut')
                                .attr('data-original-title', (Dat.quantity > 0 ? 'terdapat ' + Dat.quantity + ' perseta didik yang belum diatur' : ''));

                        }

                    }).catch(er => {
                    erra(er.response);
                });
            },
            getNoticeMonitoring = function (con) {
                const urlSide = 'monitoring';
                axios.get(urlReal + urlSide)
                    .then(res => {
                        let Dat = res.data, qty = 0, tol = '';

                        $.each(Dat, function (i, val) {
                            if (val.status) {
                                qty += val.quantity;
                                tol += (i.indexOf(' ') > 0 ? i.substr(0, i.indexOf(' ')) : i) + ':  ' + val.quantity + ' Kegiatan | '
                            }

                        });


                        if (noticeMonitoring.qty !== qty) {

                            if (con && noticeMonitoring.qty < qty) {
                                swallNotice('Ada Monitoring Baru', qty + ' kegiatan belum diisi');
                                audio.play();
                            }
                            let newMonitoring = tol.substr(0, (tol.length - 3));

                            noticeMonitoring.qty = qty;
                            $('.fa-calendar').parent().next().text(qty).closest('.add-shorcut')
                                .attr('data-original-title', newMonitoring);
                        }


                    }).catch(er => {
                    erra(er.response);
                });
            }
        ;

        $(document).ready(function () {
            getNoticeStudent(false);
            getNoticeMonitoring(false);
            setInterval(function () {
                getNoticeStudent(true);
                getNoticeMonitoring(true);
            }, 10000);
        });
    });
}