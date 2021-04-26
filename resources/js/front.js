/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

 require('./bootstrap');

 window.Vue = require('vue');

import Vue from 'vue';
import VueRouter from 'vue-router';
import router from './router';
import store from './store';
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import VeeValidate from 'vee-validate';
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import {
  faHome,
  faUser,
  faUserPlus,
  faSignInAlt,
  faSignOutAlt
} from '@fortawesome/free-solid-svg-icons';
library.add(faHome, faUser, faUserPlus, faSignInAlt, faSignOutAlt);
import Toasted from 'vue-toasted';
import {toast} from './helpers/toastHandler';
import axiosSetup from "./helpers/axiosInterceptors";

Vue.use(Toasted);
Vue.prototype.$toast = toast;

Vue.component('font-awesome-icon', FontAwesomeIcon);
Vue.component('nav-bar', require('./views/components/NavBar.vue').default);

Vue.use(VeeValidate);
Vue.use(VueRouter);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
//

Vue.config.productionTip = false;

axiosSetup();

const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
    },
    data: {
    },
    methods: {
    },
});
