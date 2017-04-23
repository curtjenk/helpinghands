
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import './user';
import './event';
import './calendar';
import './organization';
import './bs_common';
import './common';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('memberslist', require('./components/Members/MembersVuetable.vue'));
Vue.component('eventslist', require('./components/Events/EventsVuetable.vue'));

const app = new Vue({
    el: '#app'
});
