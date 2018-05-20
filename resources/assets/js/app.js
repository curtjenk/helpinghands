
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import './user';
import './events';

import './organization';
import './bs_common';
import './common';

import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue);
import ToggleButton from 'vue-js-toggle-button'
Vue.use(ToggleButton)
import VModal from 'vue-js-modal'
Vue.use(VModal)
import VuejsDialog from "vuejs-dialog"
Vue.use(VuejsDialog, {
    html: true,
    loader: true,
    okText: 'Proceed',
    cancelText: 'Cancel',
    animation: 'zoom',  //bounce, zoom, fade
})
import VueFloatLabel from 'vue-float-label'
Vue.use(VueFloatLabel)


// Vue.component('example', require('./components/Example.vue'));
Vue.component('nav-top', require('./components/Nav/Top.vue'));
Vue.component('nav-top-2', require('./components/Nav/TopLine2.vue'));
Vue.component('nav-footer', require('./components/Nav/Footer.vue'));
Vue.component('events-list', require('./components/Events/EventsVuetable.vue'));
Vue.component('events-calendar', require('./components/Events/EventsCalendar.vue'));
Vue.component('event-manager', require('./components/Events/EventManager.vue'));
Vue.component('dashboard', require('./components/Charts/Dashboard.vue'));
Vue.component('filter-bar', require('./components/FilterBar.vue'));
Vue.component('filter-memberships', require('./components/Organization/FilterMemberships.vue'));
Vue.component('members-list', require('./components/Members/MembersVuetable.vue'));
Vue.component('member-profile', require('./components/Members/Profile.vue'));
Vue.component('organizationslist', require('./components/Organization/OrganizationsVuetable.vue'));
Vue.component('organization-manager', require('./components/Organization/OrganizationManager.vue'));
Vue.component('teamslist', require('./components/Organization/Team/TeamsVuetable.vue'));
Vue.component('team-manager', require('./components/Organization/Team/TeamManager.vue'));

import { store } from './appVuexStore.js';
$(function() {
  const app = new Vue({
      el: '#app',
      // provide the store using the "store" option.
      // this will inject the store instance to all child components.
      store,
      mounted() {
        if (window.location.pathname == '/login' ||
            window.location.pathname == '/register'
          ) {
            ;
        } else {
          this.initialize();
        }

      },
      methods: {
        async initialize() {
          let config = {
            validateStatus: function (status) {
              return (status >= 200 && status < 300) || status == 401
            },
          }
          let user = null, roles = null, permissions = null
          await axios.get('/api/authmember', config)
          .then(  (response) => {
            // console.log('good', response.status)
            if (response.status != 401) {
              let data = response.data
              user = data.user
              roles = data.roles
              permissions = data.permissions
            }
            this.$store.commit('SETUSER',user)
            this.$store.commit('SETROLES',roles)
            this.$store.commit('SETPERMISSIONS',permissions)
          }).catch((error) => {
            console.log('error', error)
            this.$store.commit('SETUSER',null)
            this.$store.commit('SETROLES',null)
            this.$store.commit('SETPERMISSIONS',null)
          });
        }
      }
  })
})
