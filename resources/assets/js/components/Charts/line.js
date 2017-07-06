import { Line } from 'vue-chartjs'
export default Line.extend({
  mounted () {
    // Overwriting base render method with actual data.
  },
  props : {
      labels: {
        type: Array,
        required: true
      },
      datasets: {
          type: Array,
          required: true
      },
      options: {
          type: Object,
          required: false
      }
  },
  watch: {
    datasets () {
      this.renderChart({
        labels: this.labels,
        datasets: this.datasets
      },
      this.options
      )
    }
  }

})
