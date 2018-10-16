
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');
    require('jquery-datepicker');

    require('bootstrap/dist/js/bootstrap.min');

    $.fn.datetimepicker = require('bootstrap-datepicker');
    // require('bootstrap-datepicker/js/locales/bootstrap-datepicker.id')
} catch (e) {}
$.fn.selectpicker =require('bootstrap-select/dist/js/bootstrap-select.min');
require('bootstrap-select/dist/js/i18n/defaults-id_ID');
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

//sweetalert
window.swal = require('sweetalert2');

//moment date
window.moment= require('./moment');

// //bulma-extentions
// window.bulma_ext=require('bulma-extensions');

// require('../../../public/js/bootstrap');
// require('../../../public/js/modernizr');
// require('../../../public/js/owl.carousel');
// require('../../../public/js/jquery-1.12.2');

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */
//
// let token = document.head.querySelector('meta[name="csrf-token"]');
//
// if (token) {
//     window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
// } else {
//     console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
// }

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });
