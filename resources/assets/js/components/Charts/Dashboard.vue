<template>
    <div class="">
        <bar-chart id="b1" :data="datab1"
            :labels="labelsb1"
            :label="labelb1">
        </bar-chart>
        <bar-chart id="b1" :data="datab1"
            :labels="labelsb1"
            :label="labelb1">
        </bar-chart>
    </div>
</template>

<script>
import BarChart from './bar'
Vue.component('bar-chart', BarChart)
export default {
  // components: {
  //   BarChart
  // },
  data () {
    return {
        datab1: [],
        labelsb1: [],
        labelb1: '',
    }
  },
  mounted () {
    console.log("mounted.")
    this.datab1 = [40, 20, 12, 39, 10, 40, 39, 80, 40, 20, 12, 11];
    this.labelsb1 = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    this.labelb1 = 'Average Per Month';
  }
}
</script>
