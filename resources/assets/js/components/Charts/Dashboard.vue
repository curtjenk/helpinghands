<template>
    <div>
        <bar1></bar1>
    </div>
</template>

<script>
import Bar1 from './dashboard_bar1'
export default {
  components: {
    Bar1
  },
  mounted () {
    console.log("mounted. call Bar1.render()")
    this.$events.fire('render');
  }
}
</script>
