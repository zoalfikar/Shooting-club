// require('./bootstrap');
import jQuery from 'jquery';
import router from './routes';
import vuetify from './vuetify';
import store from './store';
window.$ = jQuery;
window.Vue = require('vue').default;
const vueAppOptions = {
    vuetify,
    store,
    router,
}
window.vueAppOptions = vueAppOptions;

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('navbar', require('./components/appLayout/navbar/navbar.vue').default);
Vue.component('sidebar', require('./components/appLayout/sidebar/sidebar.vue').default);
Vue.component('board', require('./components/appLayout/resturant/board.vue').default);
Vue.component('board-modal', require('./components/appLayout/resturant/boardModal.vue').default);

const app = new Vue({
    vuetify,
    store,
    router,

}).$mount('#app');
