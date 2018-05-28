<template>
  <div>
    <b-navbar fixed="top" toggleable="md" type="dark" class="navtop">
      <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>
        <!-- Branding Image -->
      <b-navbar-brand href="/">
        Engage In Ministry
        <!-- <img src="https://placekitten.com/g/30/30" alt="BV"> -->
      </b-navbar-brand>

      <b-collapse is-nav id="nav_collapse" class="flex-column">
          <b-navbar-nav>
            <template v-if="!eviteResp && user!==null && !isVisitor" class="mr-auto ml-auto">
              <b-nav-item v-if="canListEvents" href="/dashboard"><i class="fa fa-cog fa-tachometer"></i> Dashboard</b-nav-item>
              <b-nav-item v-if="canListMembers" href="/member"><i class="fa fa-cog fa-users"></i> Members</b-nav-item>
              <b-nav-item v-if="canListEvents" href="/event"><i class="fa fa-cog fa-list"></i> Events</b-nav-item>
              <b-nav-item v-if="canListEvents" href="/event/calendar"><i class="fa fa-cog fa-calendar"></i> Calendar</b-nav-item>
            </template>
            <template v-if="!eviteResp" class="d-flex justify-content-end">
              <b-nav-item class="ml-5" v-if="isObjectEmpty(user)" href="/register">Sign Up</b-nav-item>
              <b-nav-item class="ml-5" v-if="isObjectEmpty(user)" href="/login">Login</b-nav-item>
              <b-nav-item-dropdown v-if="!isObjectEmpty(user)" right>
                <template slot="button-content">
                  <em class="ml-5">{{ user.name }}</em><span class="caret"></span>
                </template>
                <b-dropdown-item v-if="!isSuperUser" :href="'/member/'+user.id+'/edit'"><i class="fa fa-cog fa-fw"></i> Profile</b-dropdown-item>
                <b-dropdown-item v-if="canAdminister" href="/administrator"><i class="fa fa-th-large fa-fw"></i> Administrator</b-dropdown-item>
                <b-dropdown-item @click="logout"><i class="fa fa-sign-out fa-fw"></i>Logout</b-dropdown-item>
              </b-nav-item-dropdown>
            </template>
            <template v-if="eviteResp" class="d-flex justify-content-end">
              <b-nav-item class="ml-5" href="/login">Login</b-nav-item>
            </template>
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
      // items: ['Link A', 'Link B', 'Link C']
    }
  },
  props: {
    eviteResp: {type: Boolean, required: false},
    canAdminister: {type: Boolean, required: false},
    canListEvents: {type: Boolean, required: false},
    canListMembers: {type: Boolean, required: false},
    isVisitor: {type: Boolean, required: false},
    isSuperUser: {type: Boolean, required: false},
  },
  mounted() {
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
