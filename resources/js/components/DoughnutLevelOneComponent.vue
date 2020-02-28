<template>
  <div>
    <div class="Chart">
      <DoughnutExample
        ref="skills_chart"
        :chart-data="chartData"
        :options="options">
        dfgdg
      </DoughnutExample>
    </div>
  </div>
</template>

<script>
import DoughnutExample from './Doughnut'

const options = {
  responsive: true, 
  maintainAspectRatio: false, 
  animation: {
    animateRotate: false
  }
}

export default {
  name: "App",
  components: { DoughnutExample },
  data() {
    return {
      options, 
        chartData: {
        labels: ['skill1'],
        datasets: [
          {
            backgroundColor: ["yellow"],
            data: [1]
          }
        ]
      }
    }
  },
  computed: {
    currentDataSet () {
      return this.chartData.datasets[0].data
    }
  },
  methods: {
    updateChart () {
      this.$refs.skills_chart.update();
    },
    updateAmount (amount, index) {
      this.chartData.datasets[0].data.splice(index, 1, amount)
      this.updateChart();
    },
    updateName (text, index) {
      this.chartData.labels.splice(index, 1, text)
      this.updateChart();
    },
    addExperience() {
      const currentDataset = this.chartData.datasets[0]
      this.chartData.labels.push(`Skill ${currentDataset.data.length + 1}`)
      currentDataset.data.push(2)
      currentDataset.backgroundColor.push("blue")
      this.updateChart();
    },
    remove (index) {
      const currentDataset = this.chartData.datasets[0]
      currentDataset.data.splice(index, 1)
      this.chartData.labels.splice(index, 1)
      currentDataset.backgroundColor.splice(index, 1)
      this.updateChart()
    }
  }
};
</script>

<style>
</style>
