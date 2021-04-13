/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import VCalendar from 'v-calendar';
import store from './store';
import * as Sentry from '@sentry/vue';
import {Integrations} from '@sentry/tracing';
import Reservations from './components/Reservations';
import Tables from './components/Tables';
import Restaurants from './components/Restaurants';
import EditRestaurant from './components/EditRestaurant';

// Localization
import {Lang} from 'laravel-vue-lang';

// VueRouter
Vue.use(VueRouter);
const router = new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/reservations',
      name: 'reservations',
      component: Reservations,
    },
    {
      path: '/tables',
      name: 'tables',
      component: Tables,
    },
    {
      path: '/restaurants',
      name: 'restaurants',
      component: Restaurants,
    },
    {
      path: '/restaurants/:id',
      name: 'edit-restaurant',
      component: EditRestaurant,
    },
    {
      path: '/users/:id',
      name: 'edit-user',
      component: EditRestaurant,
    },
  ],
});

// Use v-calendar & v-date-picker components
Vue.use(VCalendar);
Vue.use(require('vue-moment'));
Vue.use(Lang, {
  locale: 'de',
  fallback: 'en',
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
const files = require.context('./', true, /\.vue$/i);
files.keys().map(key =>
  Vue.component(
    key
      .split('/')
      .pop()
      .split('.')[0],
    files(key).default,
  ),
);

/**
 * Add Sentry integration
 */
Sentry.init({
  Vue,
  dsn: process.env.MIX_SENTRY_VUE_DSN,
  integrations: [new Integrations.BrowserTracing()],

  // Set tracesSampleRate to 1.0 to capture 100%
  // of transactions for performance monitoring.
  // We recommend adjusting this value in production
  tracesSampleRate: 1.0,
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
  el: '#app',
  store,
  router,
});
