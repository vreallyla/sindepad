
try {
    window.$ = window.jQuery = require('jquery');
    require('bootstrap-sass');
    require('../assets/datepicker');
    require('bootstrap-datepicker/js/locales/bootstrap-datepicker.id');
    window.currency = require('./assets/currency');
} catch (e) {
}
window.selectpicker = require('bootstrap-select');
require('bootstrap-select/dist/js/i18n/defaults-id_ID');

window.axios = require('axios');
window.currency=require('../assets/currency');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

//sweetalert
window.swal = require('sweetalert2');

//moment date
require('../moment');


let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
