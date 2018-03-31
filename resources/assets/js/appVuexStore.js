import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

export const store = new Vuex.Store({
  state: {
    user: {},
    roles: [],
    permissions: []
  },
  getters: {
    user: state => state.user,
    roles: state => state.roles,
    permissions: state => state.permissions
  },
  mutations: {
    SETUSER (state, newUser) {
      state.user = newUser;
    },
    SETROLES (state, newRoles) {
      state.roles = newRoles;
    },
    SETPERMISSIONS (state, newPermissions) {
      state.permissions = newPermissions;
    }
  }
});