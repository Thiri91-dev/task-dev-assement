import './bootstrap';
import Vue from 'vue';
import VueRouter from 'vue-router'; // Import Vue Router
import router from './router'; // Import the router instance from router.js

Vue.use(VueRouter);

/**
 * Vue Components
 *
 * The individual elements of the Cerberus UI. These are all individually loaded on a page by
 * page basis to reduce bundle size and prevent loading unwanted components on each page.
 *
 */
Vue.component('BookListing', () => import('./components/BookListing.vue'));
Vue.component('EditBook', () => import('./components/EditBook.vue'));




/**
 * Bootstrapping
 *
 * Build the Vue instance, import the Core Services at the point of creation and register all
 * of our Vue instance to the #root tag.
 */
const app = new Vue({
    el: '#app',
    router,
});
