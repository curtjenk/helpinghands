<template>
  <div style="margin: 3em 0em 1em 0em;">
    <b-navbar  toggleable="md" type="dark" class="navtop">
      <b-navbar-toggle target="nav2_collapse"></b-navbar-toggle>
      <b-collapse is-nav id="nav2_collapse">
        <b-navbar-nav class="mx-auto">
          <b-navbar-brand class="mr-4">{{ title }}</b-navbar-brand>
          <template v-for="link in links">
            <b-nav-item v-if="hasPermission(link.perm)"
              :href="link.href"><i v-if="link.icon" :class="'fa '+link.icon "></i> {{ link.name }}
            </b-nav-item>
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
    user: {
      type: Object, default: null
    },
    roles: {
      type: Array, default: ()=>[]
    },
    permissions: {
      type: Array, default: ()=>[]
    },
  },
  mounted() {
    // console.log('Component mounted.')
  },
  methods: {

  }
}
</script>
