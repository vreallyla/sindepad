/*--------------------- get params url ---------------------*/
let getUrlParameter = function getUrlParameter(sParam) {
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
    sucNotice = 'berhasil dibuat', placeRight = $('.place-right'),
    stepContRight = $('.step-content-right'), stepPointRight = $('.step-pre');

let showLoading = function showLoading() {
    loadPart.show();
};

let hideLoading = function hideLoading() {
    loadPart.hide();
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
        Body = $('body'),
        hideMenus = $('.content-up,.burgers'),
        triggerRight = $('.trigger-right');

    let changeMenu = false
        , changeStepRight = function (i) {
        stepContRight.hide().eq(i).fadeIn(300);
        stepPointRight.removeClass('activo').eq(i).addClass('activo');
    }
        , hideContentRight = function () {
        placeRight.removeClass('activo');
        setTimeout(function () {
            triggerRight.removeClass('non')
        }, 300);
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
    $('.preloader img').show();
    anim('animated rubberBand', $('.preloader img'), 'animated rubberBand')

    $(document).ready(function () {
        $("body").tooltip({selector: '[data-toggle=tooltip]'});
        setTimeout(function () {
            $('.preloader-wrapper').remove();
            $('body').removeClass('preloader-site');
        }, 500);
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
    maxTable = 1, currentTable = 1

    , setPagination = function (obj, max, curr) {
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

    }

    , loopPaginate = function (start, end, curr) {
        let paginationFill = '';
        for (let i = start; i <= end; i++) {
            paginationFill += i === curr ? '<li class="active"><a href="javascript:void(0);">\n' + pageLabel + '<span class="hal">' + i + '</span>' +
                '</a></li>' : '<li class="page"><a href="javascript:void(0);">\n' + pageLabel + '<span class="hal">' + i + '</span>' +
                '</a></li>';
        }
        return paginationFill;
    }

    /*------------------ end pagination setting ------------------*/


    /*-------------------- animate setting --------------------*/
    , anim = function (x, obj, i) {
        obj.removeClass(i).addClass(x).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
            $(this).removeClass(i);
        });
    }

    /*------------------ animate setting ------------------*/

    /*--convert currency rp--*/
    , convertRp = function (val) {
        return currency(val, {
            separator: '.',
            precision: 0
        }).format();
    }

    /*--end convert currency rp--*/

// function to search array using for loop
    , findInArray = function (ar, val) {
        for (var i = 0, len = ar.length; i < len; i++) {
            if (ar[i] === val) { // strict equality test
                return i;
            }
        }
        return false;
    }

    /*------------------- swall custom ------------------- */
    , swallCustom = function (msg) {
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

    , errSet = function (statusEr) {
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

