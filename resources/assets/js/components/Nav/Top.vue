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
        <!-- <div class="flex-row"> -->
          <b-navbar-nav>
            <template v-show="user!==null && !isVisitor" class="mr-auto ml-auto">
              <b-nav-item v-if="canListEvents" href="/dashboard"><i class="fa fa-cog fa-tachometer"></i> Dashboard</b-nav-item>
              <b-nav-item v-if="canListMembers" href="/member"><i class="fa fa-cog fa-users"></i> Members</b-nav-item>
              <b-nav-item v-if="canListEvents" href="/event"><i class="fa fa-cog fa-list"></i> Events</b-nav-item>
              <b-nav-item v-if="canListEvents" href="/event/calendar"><i class="fa fa-cog fa-calendar"></i> Calendar</b-nav-item>
            </template>
            <template class="d-flex justify-content-end">
              <b-nav-item class="ml-5" v-if="user==null" href="/login">Login</b-nav-item>
              <b-nav-item-dropdown v-if="user!==null && !isVisitor" right>
                <template slot="button-content">
                  <em class="ml-5">{{ user.name }}</em><span class="caret"></span>
                </template>
                <b-dropdown-item v-if="!isSuperUser" :href="'/member/'+user.id+'/edit'"><i class="fa fa-cog fa-fw"></i> Profile</b-dropdown-item>
                <b-dropdown-item v-if="canAdminister" href="/administrator"><i class="fa fa-th-large fa-fw"></i> Administrator</b-dropdown-item>
                <b-dropdown-item @click="logout"><i class="fa fa-sign-out fa-fw"></i>Logout</b-dropdown-item>
              </b-nav-item-dropdown>
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
    // user0: {
    //   type: Object, default: null
    // },
    // roles0: {
    //   type: Array, default: ()=>[]
    // },
    // permissions0: {
    //   type: Array, default: ()=>[]
    // },

  },
  // mounted() {
  //   // this.$store.commit('SETUSER',this.user0)
  //   // this.$store.commit('SETROLES',this.roles0)
  //   // this.$store.commit('SETPERMISSIONS',this.permissions0)
  //  // console.log( "<"+window.location.pathname+">");
  //   let config = {
  //     validateStatus: function (status) {
  //       return (status >= 200 && status < 300) || status == 401
  //     },
  //   }
  //   let user = null, roles = null, permissions = null
  //   axios.get('/api/authmember', config)
  //   .then(  (response) => {
  //     // console.log('good', response.status)
  //     if (response.status != 401) {
  //       let data = response.data
  //       user = data.user
  //       roles = data.roles
  //       permissions = data.permissions
  //     }
  //     this.$store.commit('SETUSER',user)
  //     this.$store.commit('SETROLES',roles)
  //     this.$store.commit('SETPERMISSIONS',permissions)
  //   }).catch((error) => {
  //     console.log('error', error)
  //     this.$store.commit('SETUSER',null)
  //     this.$store.commit('SETROLES',null)
  //     this.$store.commit('SETPERMISSIONS',null)
  //   });
  //
  // },
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
