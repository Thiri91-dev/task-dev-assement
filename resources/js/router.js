import Vue from 'vue';
import Router from 'vue-router';
import BookListing from './components/BookListing.vue';
import EditBook from './components/EditBook.vue';

Vue.use(Router);

export default new Router({
    routes: [
        {
            path: '/',
            component: BookListing
        },
        {
            path: '/book/:id',
            name: 'edit-book', 
            component: EditBook
        }
    ], 
    mode: 'history',
});
