require('./config/bootstrap');

import 'es6-promise/auto'
import axios from 'axios'
import Vue from 'vue'
import VueAuth from '@websanova/vue-auth'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import Index from './src/Index'
import auth from './config/auth'
import router from './src/router'
import store from './vuexStores';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';

// Set Vue globally
window.Vue = Vue
// Set Vue router
Vue.router = router


// Install BootstrapVue
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

Vue.use(VueRouter)
// Set Vue authentication
Vue.use(VueAxios, axios)

axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api/v1`

Vue.use(VueAuth, auth)
// Load Index
Vue.component('index', Index)

const app = new Vue({
  el: '#app',
  router,
  store
});