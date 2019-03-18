
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('ejemplo', require('./components/Ejemplo.vue'));
Vue.component('unidad', require('./components/Unidad.vue'));
Vue.component('conquistador', require('./components/Conquistador.vue'));
Vue.component('tipospagos', require('./components/TiposPagos.vue'));
Vue.component('pago', require('./components/Pago.vue'));
Vue.component('pagosfiltros', require('./components/PagosFiltros.vue'));
Vue.component('roles', require('./components/Roles.vue'));
Vue.component('user', require('./components/User.vue'));
Vue.component('asistencia', require('./components/Asistencia.vue'));


const app = new Vue({
    el: '#app',
    data:{
        menu: 0
    }
});
