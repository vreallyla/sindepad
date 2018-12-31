// window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');
    require('bootstrap-sass');
    // $.fn._ = require('lodash');
    require('./assets/datepicker');
    require('bootstrap-datepicker/js/locales/bootstrap-datepicker.id');
    window.currency = require('./assets/currency');
} catch (e) {
}
window.selectpicker = require('bootstrap-select');
require('bootstrap-select/dist/js/i18n/defaults-id_ID');

window.axios = require('axios');
// window.currency=require('./assets/currency');

require('masonry-layout/dist/masonry.pkgd.min');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

//sweetalert
window.swal = require('sweetalert2');

//moment date
require('./moment');

//mask phone http://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js
require('./assets/mask_plugin');

require('chart.js/dist/Chart.min');

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

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
