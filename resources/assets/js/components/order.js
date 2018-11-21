try {
    window.$ = window.jQuery = require('jquery');
    // require('jquery-datepicker');
    require('bootstrap/dist/js/bootstrap.min');
    require('../assets/datepicker');
    require('bootstrap-datepicker/js/locales/bootstrap-datepicker.id');
} catch (e) {
}
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.swal = require('sweetalert2');
window.moment = require('../moment');

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
