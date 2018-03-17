<template>
  <div class="mt-5 mb-3" style="margin-left: -15px; margin-right: -15px;">
    <b-navbar  toggleable="sm"  class="navtop2">

      <b-navbar-toggle target="nav2_collapse"></b-navbar-toggle>

      <b-collapse is-nav id="nav2_collapse">
        <b-navbar-nav class="mx-auto">
          <b-navbar-brand class="mr-4">{{ title }}</b-navbar-brand>
          <template v-for="link in links">
            <template v-if="link.click && typeof link.click == 'function'">
              <b-nav-item v-if="hasPermission(link.perm)"
                @click="link.click"
              >
                <i v-if="link.icon" :class="'fa '+link.icon "></i>
                {{ link.name }}
              </b-nav-item>
            </template>
            <template v-else>
              <b-nav-item v-if="hasPermission(link.perm)"
                :href="link.href"
              >
                <i v-if="link.icon" :class="'fa '+link.icon "></i>
                  {{ link.name }}
              </b-nav-item>
            </template>
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

    }
  },
  props: {
    title: {
      type: String, default: ''
    },
    links: {
      type: Array, default: ()=>[ {name:'Link A'}, {name:'Link B'}, {name:'Link C'}]
    },
    // user: {
    //   type: Object, default: null
    // },
    // roles: {
    //   type: Array, default: ()=>[]
    // },
    // permissions: {
    //   type: Array, default: ()=>[]
    // },
  },
  mounted() {
    // console.log('Component mounted.')
  },
  methods: {
  },
  computed: {
    // user () {
    //   return this.$store.state.user;
    // },
    // roles () {
    //   return this.$store.state.roles;
    // },
    // permissions () {
    //   return this.$store.state.permissions;
    // }
  }
}
</script>
