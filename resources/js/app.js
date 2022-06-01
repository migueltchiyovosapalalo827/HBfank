


import { createApp, h, computed  } from 'vue';
require('./bootstrap');
import moment from 'moment';
import App from './Pages/App.vue';
import Main from './Layouts/Main.vue';
import router from '../js/Router';
import store from './store';
import Swal from 'sweetalert2';
import Form from 'vform';
import LaravelVuePagination from 'laravel-vue-pagination';
import VueProgressBar from 'vue-progressbar';
import Table from '@/components/Table';
import {serialize} from 'object-to-formdata/src/index';
import vSelect from 'vue-select';
window.Form = Form;
window.serialize = serialize;
moment.locale("pt-br");

  const formatDate = function formatData(params) {
    if (params) {
        return moment(params).format('DD/MM/YYYY HH:mm');
    }
}

function yesno(value) {
    return (value ? '<i class="fas fa-check green">sim</i>' : '<i class="fas fa-times red">não</i>');
}
const auth = window.Laravel.jsPermissions;
 const can = function (params) {

       return auth.permissions.includes(params);
 }

 const is = function (params) {
    return auth.roles.includes(params);
}
const truncate = function (text, length, suffix) {
    return text.substring(0, length) + suffix;
}

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })
  let numberFormat = function(value) {
    let val = (value / 1).toFixed(0).replace('.', ',')
    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
}
  window.Swal = Swal;
  window.Toast = Toast;
const app = createApp(App);
app.component('Main',Main);
app.component('Pagination', LaravelVuePagination);
app.component("Table",Table);
app.component("vSelect",vSelect);
app.use(store);
app.use(router);
app.mixin({ methods: {formatDate ,yesno,can,is,truncate,numberFormat} });
app.mount('#app');
