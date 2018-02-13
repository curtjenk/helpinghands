import { Doughnut } from 'vue-chartjs'
export default Doughnut.extend({
  name: "doughnut-chart",
  mounted () {
    // Overwriting base render method with actual data.
  },
  props : {
      labels: {
        type: Array,
        required: true
      },
      data: {
          type: Array,
          required: true
      },
      bgColors: {
          type: Array,
          required: false
      },
      hoverBgColors: {
          type: Array,
          required: false
      },
      options: {
          type: Object,
          required: false
      }
  },
  watch: {
    data () {
      this.renderChart({
        labels: this.labels,
        datasets: [{
          data: this.data,
          backgroundColor: this.bgColors
        //   hoverBackgroundColor: this.hoverBGColors
        }]
      },
      this.options
      )
    }
  }
})
