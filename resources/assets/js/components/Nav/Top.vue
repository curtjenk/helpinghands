<template>
  <div>
    <b-navbar fixed="top" :sticky="true" toggleable="md" type="dark" variant="info">
      <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>
        <!-- Branding Image -->
      <b-navbar-brand href="/">
        Engage In Ministry
        <img src="https://placekitten.com/g/30/30" alt="BV">
      </b-navbar-brand>

      <b-collapse is-nav id="nav_collapse">

            <b-navbar-nav class="mx-auto" v-show="user!==null && !isVisitor">
              <b-nav-item v-if="canListEvents" href="/dashboard"><i class="fa fa-cog fa-tachometer"></i> Dashboard</b-nav-item>
              <b-nav-item v-if="canListMembers" href="/member"><i class="fa fa-cog fa-users"></i> Members</b-nav-item>
              <b-nav-item v-if="canListEvents" href="/event"><i class="fa fa-cog fa-list"></i> Events</b-nav-item>
              <b-nav-item v-if="canListEvents" href="/event/calendar"><i class="fa fa-cog fa-calendar"></i> Calendar</b-nav-item>
            </b-navbar-nav>
            <!-- Right Side Of Navbar -->
            <b-navbar-nav class="ml-auto mr-auto">
              <b-nav-item  v-if="!user" href="/login">Login</b-nav-item>
              <b-nav-item-dropdown v-if="user!==null && !isVisitor" right>
                <template slot="button-content">
                  <em>{{ user.name }}</em><span class="caret"></span>
                </template>
                <b-dropdown-item :href="'/member/'+user.id+'/edit'"><i class="fa fa-cog fa-fw"></i> Profile</b-dropdown-item>
                <b-dropdown-item v-if="canAdminister" href="/administrator"><i class="fa fa-th-large fa-fw"></i> Administrator</b-dropdown-item>
                <b-dropdown-item @click="logout">
                  <i class="fa fa-sign-out fa-fw"></i>Logout
                </b-dropdown-item>
              </b-nav-item-dropdown>
            </b-navbar-nav>
      </b-collapse>

    </b-navbar>

  </div>
</template>

<script>
import {commonMixins} from '../../mixins/common';
export default {
  mixins: [commonMixins],
  data () {
    return {

    }
  },
  props: {

    user: {
      type: Object, default: null
    },
    roles: {
      type: Array, default: []
    },
    permissions: {
      type: Array, default: []
    },

  },
  mounted() {
    console.log("mounted")
    // console.log('Component mounted.')
  },
  methods: {
    logout(event) {
       // alert(JSON.stringify(this.form));
       axios.post('/logout')
       .then(  (response) => {
         window.location.href="/"
       }).catch((error) => {
         console.log(error)
       });
    }
  }
}
</script>
