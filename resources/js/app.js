require('./bootstrap');

window.Vue = require('vue');
import { Form, HasError, AlertError } from 'vform'
window.Form = Form

import Snotify, { SnotifyPosition } from 'vue-snotify'

const snotifyOptions = {
  toast: {
    position: SnotifyPosition.rightTop
  }
}

Vue.use(Snotify, snotifyOptions)

Vue.component('account-component', require('./components/AccountComponent.vue').default);
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)


const app = new Vue({
    el: '#app',
});
