<template>
  <div>
    <b-navbar fixed="bottom" toggleable="md" type="dark" class="navfooter">

      <b-navbar-nav class="mx-auto">
        <b-nav-item href="#">Contact Us</b-nav-item>
        <b-nav-item href="#">Like Us On Facebook</b-nav-item>
      </b-navbar-nav>
      <!-- Right Side Of Navbar -->
      <b-navbar-nav class="mr-auto">
        <b-nav-item href="#">Contact Us</b-nav-item>
        <b-nav-item href="#">Like Us On Facebook</b-nav-item>
      </b-navbar-nav>


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
    // console.log('Component mounted.')
  },
  methods: {
    method1(event) {
    }
  }
}
</script>
