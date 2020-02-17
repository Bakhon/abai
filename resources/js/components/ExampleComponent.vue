<template>
<div class="container">
<center><h1>Vue laravel Chartjs</h1></center>
           <canvas ref="chart"></canvas>
       </div>
</template>
<script>
    export default{
        mounted() {
        let uri = 'http://localhost/ru/chartjs';
        axios.get(uri).then((response) => {
        var chart = this.$refs.chart;
            var ctx = chart.getContext("2d");
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: response.data.month,
                    datasets: [{
                        label: '# of Votes',
                        data: response.data.data,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        }).catch(error => {
        console.log(error)
        this.errored = true
      });
        }
    }
</script>