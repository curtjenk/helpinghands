<template>
  <div>
    <b-navbar fixed="top" :sticky="true" toggleable="md" type="light" class="navtop2">
      <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>
      <b-navbar-brand>
        Line 2 Nav
      </b-navbar-brand>

      <b-collapse is-nav id="nav_collapse">
        <!-- Right Side Of Navbar -->
        <b-navbar-nav class="ml-auto">
          <b-nav-item  href="#">Login</b-nav-item>
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

  },
  mounted() {
    console.log("line 2 mounted")
    // console.log('Component mounted.')
  },
  methods: {

  }
}
</script>
