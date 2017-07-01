import { Bar } from 'vue-chartjs'
export default Bar.extend({
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
      label: {
        type: String,
        required: true
      }
  },
  watch: {
    data () {
      this.renderChart({
        labels: this.labels,
        datasets: [
          {
            backgroundColor: '#f87979',
            label: this.label,
            data: this.data
          }
        ]
      },{responsive: true, maintainAspectRatio: false})
    }
  }

})
