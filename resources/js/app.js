require('./bootstrap');

window.Vue = require('vue').default;
window.Fire = new Vue();
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

Vue.use(BootstrapVue)

Vue.use(IconsPlugin)

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('role', require('./components/role.vue').default);
Vue.component('user', require('./components/user.vue').default);
Vue.component('loading', require('./components/loading.vue').default);



// ES6 Modules or TypeScript
import Swal from 'sweetalert2'
window.swal = Swal;

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
});

window.toast = Toast;
import moment from 'moment';

Vue.filter('date', function(created){
  return moment(created).format('MMMM Do YYYY, h:mm:ss a');;
});

// import { Form, HasError, AlertError } from 'vform'
// window.Form = Form;
// Vue.component(HasError.name, HasError)
// Vue.component(AlertError.name, AlertError)

import  Form from 'vform'
import  HasError from 'vform'
import  AlertError from 'vform'

window.Form = Form;

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

const app = new Vue({
    el: '#app',
});