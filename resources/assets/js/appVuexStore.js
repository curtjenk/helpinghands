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
    getUser: state => state.user,
    getRoles: state => state.roles,
    getPermissions: state => state.permissions
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