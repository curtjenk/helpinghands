
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

import ToggleButton from 'vue-js-toggle-button'
Vue.use(ToggleButton)
import VueFloatLabel from 'vue-float-label'
Vue.use(VueFloatLabel)
import Tooltip from 'vue-directive-tooltip';
import 'vue-directive-tooltip/css/index.css';
Vue.use(Tooltip, {
    delay: 200,
    placement: 'right',
    class: 'tooltip-small',
    triggers: ['hover'],
    offset: 2
});

// Vue.component('example', require('./components/Example.vue'));
Vue.component('eventslist', require('./components/Events/EventsVuetable.vue'));
Vue.component('dashboardcharts', require('./components/Charts/Dashboard.vue'));
Vue.component('filter-memberships', require('./components/Organization/FilterMemberships.vue'));
Vue.component('memberslist', require('./components/Members/MembersVuetable.vue'));
Vue.component('memberprofile', require('./components/Members/Profile.vue'));
Vue.component('organizationslist', require('./components/Organization/OrganizationsVuetable.vue'));
Vue.component('organization-manager', require('./components/Organization/OrganizationManager.vue'));

const app = new Vue({
    el: '#app'
});
