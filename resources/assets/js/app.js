
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import './user';
import './events';
import './calendar';
import './organization';
import './bs_common';
import './common';

Vue.component('example', require('./components/Example.vue'));
Vue.component('memberslist', require('./components/Members/MembersVuetable.vue'));
Vue.component('memberprofile', require('./components/Members/Profile.vue'));
Vue.component('eventslist', require('./components/Events/EventsVuetable.vue'));
Vue.component('dashboardcharts', require('./components/Charts/Dashboard.vue'));

const app = new Vue({
    el: '#app'
});
