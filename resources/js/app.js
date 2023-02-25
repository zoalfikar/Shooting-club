// require('./bootstrap');
// import jQuery from 'jquery';
import router from './routes';
import vuetify from './vuetify';
import store from './store';
import { v4 as uuidv4 } from 'uuid';
// window.$ = jQuery;
window.Vue = require('vue').default;
const vueAppOptions = {
    vuetify,
    store,
    router,
}
const npmDependencies = {
    uuidv4
}
window.vueAppOptions = vueAppOptions;
window.npmDependencies = npmDependencies;
// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('navbar', require('./components/appLayout/navbar/navbar.vue').default);
Vue.component('sidebar', require('./components/appLayout/sidebar/sidebar.vue').default);
Vue.component('page-footer', require('./components/appLayout/footer/pageFooter.vue').default);
Vue.component('board', require('./components/appLayout/resturant/board.vue').default);
Vue.component('boards', require('./components/appLayout/resturant/boards.vue').default);
Vue.component('board-modal', require('./components/appLayout/resturant/boardModal.vue').default);
Vue.component('info-modal', require('./components/appLayout/resturant/infoModel.vue').default);
Vue.component('resturant-menu', require('./components/appLayout/resturant/menu.vue').default);
Vue.component('setting', require('./components/appLayout/setting/index.vue').default);

const app = new Vue({
    vuetify,
    store,
    router,

}).$mount('#app');
// var app = new Vue({
//     vuetify,
//     store,
//     router,

// }).$mount('#app');
// window.vueApp = app;