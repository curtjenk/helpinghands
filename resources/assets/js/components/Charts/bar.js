import { Bar } from 'vue-chartjs'
export default Bar.extend({
  mounted () {
    // Overwriting base render method with actual data.
    this.renderChart({
      labels: this.labels,
      datasets: this.datasets
    },
    this.options
    )
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
      this._chart.destroy()
      this.renderChart({
        labels: this.labels,
        datasets: this.datasets
      },
      this.options
      )
    }
  }

})
