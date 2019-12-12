require('./bootstrap');

//window.Vue = require('vue');
import Vue from 'vue';
import { Form, HasError, AlertError } from 'vform'
window.Form = Form

import swal from 'sweetalert2'
window.swal = swal;

let toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
})
window.toast = toast;

Vue.component('account-component', require('./components/AccountComponent.vue').default);
Vue.component('pagination-component', require('./components/partials/PaginationComponent.vue').default);
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)


const app = new Vue({
    el: '#app',
});
