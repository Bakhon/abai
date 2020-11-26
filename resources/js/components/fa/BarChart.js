import { Bar } from 'vue-chartjs'

export default {
  extends: Bar,
  mounted () {
    // Overwriting base render method with actual data.
    this.renderChart({
      labels: ['January', 'February', 'March', 'April'],
      datasets: [
        {
          label: ['January', 'February', 'March', 'April'],
          backgroundColor: '#0070ff',
          data: [40, -20, 12, -39]
        }
      ]
    })
  }
}
