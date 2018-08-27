/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue'
import VueResource from 'vue-resource'
import VueRouter from 'vue-router'
import menuplatos from './components/menuplatos.vue'
import estadisticas from './components/estadisticas.vue'
import chartline from './components/ChartLine.vue'
import chartbar from './components/ChartBar.vue'
import chartDou from './components/ChartDoughnut.vue'
import chartpie from './components/ChartPie.vue'
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
import Notificaciones from './components/notificacionesall.vue'

require('./bootstrap');
require('push.js');
require('jquery-validation');

window.Vue = require('vue');
Vue.use(VueResource);
Vue.use(VueRouter);
import AppCliente from './components/AppCliente.vue'
import Menu from './components/Menu.vue'
import Platos from './components/Platos.vue'
const router = new VueRouter({
    mode: 'history',
    /*
     We just add one route
     */
    routes: [{
        path: '/cliente/app/menu',
        name: 'menu',
        component: Menu
    }, {
        path: '/cliente/app/platos',
        name: 'platos',
        component: Platos
    }]
});
import VueTimeago from 'vue-timeago'
Vue.use(VueTimeago, {
    name: 'timeago', // component name, `timeago` by default
    locale: 'es-ES',
    locales: {
        // you will need json-loader in webpack 1
        'es-ES': require('vue-timeago/locales/es-ES.json')
    }
});
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
//Vue.component('timeago', require('./components/timeago.vue'));
Vue.component('NotificationsDemo', require('./components/NotificationsDemo.vue'));
Vue.component('NotificationsDropdown', require('./components/NotificationsDropdown.vue'));
Vue.component('CocinaHome', require('./components/Cocina.vue'));
Vue.component('Caja', require('./components/Caja.vue'));
Vue.component('MenuPlatos', menuplatos);
Vue.component('ClientePedido', require('./components/ClientePedido.vue'));
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('AppCliente', AppCliente);
Vue.component('LoadingBar', require('vue2-loading-bar'));
Vue.component('Estadisticas', estadisticas);
Vue.component('ChartLine', chartline);
Vue.component('ChartBar', chartbar);
Vue.component('ChartDou', chartDou);
Vue.component('ChartPie', chartpie);
Vue.component('PulseLoader', PulseLoader);
Vue.component('NotificacionesAll', Notificaciones);

const app = new Vue({
    el: '#app',
    router,
    data: {
        progress: 0,
        error: false,
        direction: 'right'
    },
    methods: {},
    mounted: function() {}
});