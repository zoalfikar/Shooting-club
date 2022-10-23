/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');
import jQuery from 'jquery';
window.$ = jQuery;
window.Vue = require('vue').default;
import vuetify from './vuetify';
window.vuetify = vuetify;
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('navbar', require('./components/appLayout/navbar/navbar.vue').default);
Vue.component('sidebar', require('./components/appLayout/sidebar/sidebar.vue').default);
Vue.component('board', require('./components/appLayout/resturant/board.vue').default);
Vue.component('board-modal', require('./components/appLayout/resturant/boardModal.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    vuetify,
}).$mount('#app');
const app1 = new Vue({
    vuetify,
});

window.VueApp = app1;