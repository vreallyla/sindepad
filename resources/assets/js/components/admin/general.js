/*--------------------- get params url ---------------------*/
window.getUrlParameter = function (sParam) {
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
/*------------------- end get params url -------------------*/
/*------------------- loading part -------------------*/
const loadPart = $('#loading'),
    errNotice = 'terdapat kesalahan. silakan muat ulang / kontak admin',
    nullNotice = "Belum diisi",
    manipNotice = "Harap tidak merubah data",
    fillNotice = 'pastikan mengisi kolom dengan benar',
    modalOut = $('.title-content,.card-mod,.paginate,.paginated'),
    objnonModal = $('.title-content,.title-content,.paginate,.not-found-notice,.error-notice'),
    objNotice = $('.not-found-notice, .error-notice'),
    loadingMagnify = $('.loading'),
    modalTarget = $('.modal-full'),
    sucNotice = 'berhasil dibuat', placeRight = $('.place-right'),
    stepContRight = $('.step-content-right'), stepPointRight = $('.step-pre'),
    Body = $('body'),
    triggerRight = $('.trigger-right');

/*------------------ for show full modal ------------------*/
window.showModalFull = function (tart) {
    objnonModal.addClass('animated slideOutDown');
    if (tart) {
        tart.addClass('animated slideOutDown');
    }

    setTimeout(e => {
        modalTarget.show();
        objnonModal.removeClass('animated slideOutDown').hide();
        if (tart) {
            tart.removeClass('animated slideOutDown').hide();
        }
        anim('animated bounceInDown', modalTarget, 'animated bounceInDown');
    }, 300);
};
/*---------------- end for show full modal ----------------*/

window.arColorChart = [
    {
        bg: 'rgba(255, 99, 132, 0.2)',
        border: 'rgba(255,99,132,1)'
    },
    {
        bg: 'rgba(42, 178, 123, 0.2)',
        border: 'rgba(42, 178, 123, 1)'
    }, {
        bg: 'rgba(0, 160, 209, 0.2)',
        border: 'rgba(0, 160, 209, 1)'
    }, {
        bg: 'rgba(113, 209, 87, 0.2)',
        border: 'rgba(113, 209, 87, 1)'
    }, {
        bg: 'rgba(209, 83, 197, 0.2)',
        border: 'rgba(209, 83, 197, 1)'
    }, {
        bg: 'rgba(194, 209, 34, 0.2)',
        border: 'rgba(194, 209, 34, 1)'
    }
    , {
        bg: 'rgba(209, 33, 54, 0.2)',
        border: ' rgba(209, 33, 54, 1)'
    }
    , {
        bg: 'rgba(209, 33, 54, 0.2)',
        border: ' rgba(209, 33, 54, 1)'
    }
    , {
        bg: 'rgb(164, 177, 209,0.2)',
        border: 'rgb(164, 177, 209,1)'
    }
    , {
        bg: 'rgb(164, 177, 209,0.2)',
        border: 'rgb(164, 177, 209,1)'
    }
    , {
        bg: 'rgb(164, 140, 209,0.2)',
        border: 'rgb(164, 140, 209,1)'
    }
    , {
        bg: 'rgb((206, 209, 134,0.2)',
        border: 'rgb((206, 209, 134,1)'
    }
];

/*------------------ for hide full modal ------------------*/
window.hideModalFull = function (tart) {
    modalTarget.fadeOut(300);
    setTimeout(e => {
        modalOut.fadeIn(300);
        if (tart) {
            tart.fadeIn(300);
        }
    }, 500);
};
/*---------------- end for hide full modal ----------------*/

/*------------------ obj notice ------------------*/
window.hideNoce = function () {
    objNotice.hide();
    loadingMagnify.show();
};
window.showObjN = function (objN) {
    loadingMagnify.hide();
    objN.fadeIn(300);
};
window.hideObjN = function (objN) {
    loadingMagnify.show();
    objN.hide();
    objNotice.hide();

};
/*---------------- end obj notice ----------------*/


/*------------------ for show modal anim ------------------*/
window.showModalAnim = function () {
    const buttonId = 'one';
    $('#modal-container').removeAttr('class').addClass(buttonId);
    $('body').addClass('preloader-site');
};
/*---------------- end for show modal anim ----------------*/

window.showLoading = function () {
    loadPart.show();
};
window.showLoadingObj = function (objN) {
    loadPart.show();
    objN.hide();
};

window.hideLoading = function () {
    loadPart.hide();
};
window.hideLoadingObj = function (objN) {
    loadPart.hide();
    objN.show();

};

window.hideContentRight = function () {
    placeRight.removeClass('activo');
    setTimeout(function () {
        triggerRight.removeClass('non')
    }, 300);
};
window.showContentRight = function () {
    triggerRight.addClass('non');
    setTimeout(function () {
        placeRight.addClass('activo');
    }, 300);
};
/*----------------- end loading part -----------------*/

/*-------------------- general -------------------------*/
$(function () {
    const menuDetail = $('.menu-detail'),
        addSubMenu = $('.add-sub-menu'),
        menuUp = $('.menu-up'),
        triggerMenu = $('.trigger-burger'),
        showMenu = 'geserMasukKiri',
        hideMenu = 'geserKeluarKiri',
        hideMenus = $('.content-up,.burgers');

    let changeMenu = false
        , changeStepRight = function (i) {
        stepContRight.hide().eq(i).fadeIn(300);
        stepPointRight.removeClass('activo').eq(i).addClass('activo');
    }
        , removClas = function (obj) {
        obj.hasClass(showMenu) ?
            obj.removeClass(showMenu) :
            (obj.hasClass(hideMenu) ?
                obj.removeClass(hideMenu) :
                '');
    }
        , respMenu = function (obj1, obj2, hidup, mati) {
        anim(hidup, obj1, mati);
        setTimeout(function () {
            anim(mati, obj2, hidup);
        }, 300);
    };

    Body.addClass('preloader-site');
    let imgA = $('.preloader img');
    imgA.show();
    anim('animated rubberBand', imgA, 'animated rubberBand');

    $(document).ready(function () {
        Body.tooltip({selector: '[data-toggle=tooltip]'});
        setTimeout(function () {
            $('.preloader-wrapper').remove();
            Body.removeClass('preloader-site');
        }, 500);
    });

    $('.content-sub-header').children().eq(1).on('click', function (e) {
        let targetN = $(e.target);
        loadPart.show();
        if (targetN.is('a')) {
            e.preventDefault();
        }

        let fragment = document.createDocumentFragment(),
            creForm = document.createElement("form");

        $(creForm).append('<input name="token" value="' + document.head.querySelector('meta[name="token-jwt"]').content + '"/>' +
            '<input name="_token" value="' + document.head.querySelector('meta[name="csrf-token"]').content + '"/>')
            .prop('action', '/signout').prop('method', 'post').hide();

        fragment.appendChild(creForm);

        $(this).append(fragment);

        $(this).find('form').submit();
    });


    if (stepContRight.length > 1) {
        stepContRight.on('click', 'button', function (e) {
            e.preventDefault();
            let stepActiveRight = $('.step-pre.activo');
            let indexActiveRight = stepContRight.index($(this).closest('.step-content-right'));
            if ($(this).text() === 'Selanjutnya' && indexActiveRight < stepContRight.length) {
                changeStepRight(indexActiveRight + 1);
            } else if ($(this).text() === 'Sebelumnya' && indexActiveRight > 0) {
                changeStepRight(indexActiveRight - 1);
            }
        });
    }

    $(window).resize(function () {
        if ($(window).width() >= 992 && changeMenu === true) {
            removClas(menuUp);
            removClas(triggerMenu);
        }
    });

    $('.pagination-responsive').each(function () {

        var listItems = $(this).children();

        if (listItems.length % 2 === 0) {
            $(this).addClass('even');
        } else {
            $(this).addClass('odd');
        }

    });

    triggerRight.click(function () {
        placeRight.addClass('activo');
        $(this).addClass('non');
        $('input[name=name]').focus();
        placeRight.find('input,textarea').val('');
        placeRight.find('button').data('key', '');
    });

    placeRight.on('click', '.fa-window-close', function () {
        hideContentRight();
    });

    for (let i = 1; i < menuDetail.length; i++) {
        menuDetail.eq(i).css('bottom', i);
    }

    triggerMenu.click(function () {
        changeMenu = true;
        respMenu(triggerMenu, menuUp, hideMenu, showMenu);
        setTimeout(e => {
            hideContentRight();
        }, 300);
    });

    hideMenus.click(function () {
        if ($(window).width() < 992) {
            changeMenu = true;
            respMenu(menuUp, triggerMenu, hideMenu, showMenu);
        }
    });


    menuDetail.click(function (e) {
        window.location = $(this).children('a').eq(0).prop('href');
    });

    addSubMenu.click(function () {
        addSubMenu.not(this).removeClass('activo').next().hide();
        $(this).toggleClass('activo').hasClass('activo') ?
            $(this).next().slideDown(150) :
            $(this).next().slideUp(150);
    });
});
/*-------------------- end general -------------------------*/

/*-------------------- pagination setting --------------------*/
let pagePrev = '&laquo; <span class="hidden-sm hidden-md hidden-lg">Sebelumnya</span>',
    pageNext = '<span class="hidden-sm hidden-md hidden-lg">Selanjutnya</span> &raquo;',
    pageLabel = '<span class="hidden-sm hidden-md hidden-lg">Halaman</span>',
    maxTable = 1, currentTable = 1;

window.setPagination = function (obj, max, curr) {
    maxTable = max = parseInt(max);
    currentTable = curr = parseInt(curr);
    let nextPagination = '<li class="next-page"><a href="javascript:void(0);">\n' + pageNext +
        '</a></li>',
        prevPagination = '<li class="prev-page"><a href="javascript:void(0);">\n' + pagePrev +
            '</a></li>',
        subNextPagination = '<li class="sub-next-page"><a href="javascript:void(0);">\n' + '...' +
            '</a></li>',
        subPrevPagination = '<li class="sub-prev-page"><a href="javascript:void(0);">\n' + '...' +
            '</a></li>',
        maxPagination = '<li class="page"><a href="javascript:void(0);">\n' + pageLabel + '<span class="hal">' + max + '</span>' +
            '</a></li>',
        minPagination = '<li class="page"><a href="javascript:void(0);">\n' + pageLabel + '<span class="hal">' + 1 + '</span>' +
            '</a></li>', paginationFill = '';

    if (max === 1) {
        obj.hide();
    } else {
        if (7 > max) {
            paginationFill = loopPaginate(1, max, curr);

        } else if (5 > curr) {
            paginationFill += loopPaginate(1, 4, curr);
            paginationFill += subNextPagination + maxPagination;

        } else if ((max - 3) < curr) {
            paginationFill = minPagination + subPrevPagination;
            paginationFill += loopPaginate((curr - 2), max, curr);
        } else if (5 <= curr) {
            paginationFill = minPagination + subPrevPagination;
            paginationFill += loopPaginate((curr - 2), (curr + 2), curr);
            paginationFill += subNextPagination + maxPagination;
        }
        obj.fadeIn(500);
        obj.empty().append(prevPagination + paginationFill + nextPagination);
    }

};

window.loopPaginate = function (start, end, curr) {
    let paginationFill = '';
    for (let i = start; i <= end; i++) {
        paginationFill += i === curr ? '<li class="active"><a href="javascript:void(0);">\n' + pageLabel + '<span class="hal">' + i + '</span>' +
            '</a></li>' : '<li class="page"><a href="javascript:void(0);">\n' + pageLabel + '<span class="hal">' + i + '</span>' +
            '</a></li>';
    }
    return paginationFill;
};

/*------------------ end pagination setting ------------------*/


/*-------------------- animate setting --------------------*/
window.anim = function (x, obj, i) {
    obj.removeClass(i).addClass(x).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
        $(this).removeClass(i);
    });
};

/*------------------ animate setting ------------------*/

/*--convert currency rp--*/
window.convertRp = function (val) {
    return currency(val, {
        separator: '.',
        precision: 0
    }).format();
};

/*--end convert currency rp--*/

// function to search array using for loop
window.findInArray = function (ar, val) {
    for (var i = 0, len = ar.length; i < len; i++) {
        if (ar[i] === val) { // strict equality test
            return i;
        }
    }
    return false;
};

window.erra = function (no) {
    loadPart.hide();
    if (no) {
        no.status === 422 ? swallCustom(manipNotice) : swallCustom(errNotice);
    } else {
        swallCustom(errNotice);
    }
};

window.erInput = function (er) {
    loadPart.hide();
    if (er) {
        if (er.status === 422) {
            anim('animated shake', placeRight.find('form'), 'animated shake');
            $.each(er.data, function (i, val) {
                placeRight.find('[name="' + i + '"]').closest('.form-group').find('.help-block').text(val);
            });
        } else {
            swallCustom(errNotice);
        }
    } else {
        swallCustom(errNotice);
    }
};

window.erInputCus = function (er, objn) {
    loadPart.hide();
    if (er) {
        if (er.status === 422) {
            anim('animated shake', objn.find('form'), 'animated shake');
            $.each(er.data, function (i, val) {
                if (i==='needed'){
                    objn.find('[name="' + i + '[]"]').closest('.form-group').find('.help-block').text(val);
                } else{
                    objn.find('[name="' + i + '"]').closest('.form-group').find('.help-block').text(val);
                }

            });
        } else {
            swallCustom(errNotice);
        }
    } else {
        swallCustom(errNotice);
    }
};

window.erInputCusOthersa = function (er, objn) {
    loadPart.hide();
    if (er) {
        if (er.status === 422) {
            anim('animated shake', objn.find('form'), 'animated shake');
            $.each(er.data, function (i, val) {
                objn.find('[name="' + i + '"]').closest('.for-input').find('.help-block').text(val);
            });
        } else {
            swallCustom(errNotice);
        }
    } else {
        swallCustom(errNotice);
    }
};

window.permissionsDel = function () {
    if (confirm("Data akan hilang, hapus?")) {
        return true;
    } else {
        return false;
    }
};

window.permissionsDelWithRel = function () {
    if (confirm("Data yang terhubung akan hilang, hapus?")) {
        return true;
    } else {
        return false;
    }
};

window.removeHelpBlock=function(obj){
    obj.find('.help-block').text('');
};

window.noticeListTable = function (er) {
    loadPart.hide();
    loadingMagnify.hide();
    if (er) {
        if (er.status === 403 || er.status === 422) {
            $('.not-found-notice').fadeIn(300);
        } else {
            $('.error-notice').fadeIn(300);
        }
    } else {
        $('.error-notice').fadeIn(300);

    }
};

/*------------------- swall custom ------------------- */
window.swallNotice = function (title, msg) {
    swal({
        position: 'bottom-end',
        title: title,
        text: msg,
        showConfirmButton: false,
        timer: 2000
    });
    $('.swal2-popup').css('border-radius', '7px');
    $('.swal2-popup').css('margin-bottom', '20px');
    $('.swal2-popup').css('margin-right', '20px');
    $('.swal2-popup').css('background', '#4b4444');
    $('.swal2-title').css('top', '7px');
    $('.swal2-title').css('color', '#fff');
    $('.swal2-title').css('font-weight', 'normal');
    $('.swal2-container').css('background-color', 'transparent');
    $('.swal2-content').css('color', '#fff');
};

window.swallCustom = function (msg) {
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
};

window.errSet = function (statusEr) {
    statusEr === 422 ? swallCustom(manipNotice) : (statusEr === 404 ? swallCustom(nullNotice) : swallCustom(errNotice));
};

/*----------------- end swall custom ----------------- */

/*----------------- token jwt -------------------------*/
let tokenJWT = document.head.querySelector('meta[name="token-jwt"]');

if (tokenJWT) {
    window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + tokenJWT.content;
} else {
    console.error('token jwt not found');
}

/*----------------- end token jwt -------------------------*/

