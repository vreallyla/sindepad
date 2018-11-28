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
errNotice= 'terdapat kesalahan. silakan muat ulang / kontak admin';

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
        burgerss = $('.burgers'),
        Body = $('body');

    let changeMenu = false;
    Body.addClass('preloader-site');
    $('.preloader img').show();
    anim('animated rubberBand', $('.preloader img'), 'animated rubberBand');

    $(window).on('load', function () {
        setTimeout(e => {
            $('.preloader-wrapper').fadeOut();
            $('body').removeClass('preloader-site');
        }, 300);
    });

    $(document).ready(function () {
        $("body").tooltip({selector: '[data-toggle=tooltip]'});
    });

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

    function removClas(obj) {
        obj.hasClass(showMenu) ?
            obj.removeClass(showMenu) :
            (obj.hasClass(hideMenu) ?
                obj.removeClass(hideMenu) :
                '');
    }

    for (let i = 1; i < menuDetail.length; i++) {
        menuDetail.eq(i).css('bottom', i);
    }

    triggerMenu.click(function () {
        changeMenu = true;
        respMenu(triggerMenu, menuUp, hideMenu, showMenu);

    });
    burgerss.click(function () {
        changeMenu = true;
        respMenu(menuUp, triggerMenu, hideMenu, showMenu);
    });

    function respMenu(obj1, obj2, hidup, mati) {
        anim(hidup, obj1, mati);
        setTimeout(function () {
            anim(mati, obj2, hidup);
        }, 300);
    }

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

function setPagination(obj, max, curr) {
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

function loopPaginate(start, end, curr) {
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
function anim(x, obj, i) {
    obj.removeClass(i).addClass(x).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
        $(this).removeClass(i);
    });
}

/*------------------ animate setting ------------------*/

/*--convert currency rp--*/
function convertRp(val) {
    return currency(val, {
        separator: '.',
        precision: 0
    }).format();
}

/*--end convert currency rp--*/

// function to search array using for loop
function findInArray(ar, val) {
    for (var i = 0, len = ar.length; i < len; i++) {
        if (ar[i] === val) { // strict equality test
            return i;
        }
    }
    return false;
}

/*------------------- swall custom ------------------- */
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

/*----------------- end swall custom ----------------- */

/*----------------- token jwt -------------------------*/
let tokenJWT = document.head.querySelector('meta[name="token-jwt"]');

if (tokenJWT) {
    window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + tokenJWT.content;
} else {
    console.error('token jwt not found');
}

/*----------------- end token jwt -------------------------*/