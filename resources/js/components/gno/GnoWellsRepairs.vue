<template>
  <div>
    <Plotly :data="chart" :layout="layout" :display-mode-bar="false"></Plotly>
  </div>
</template>
<script>
import {Plotly} from "vue-plotly";

Vue.component("Plotly", Plotly);

var x = ["2015-01-01", "2015-02-01", "2015-03-01", "2015-04-01",
  "2015-05-01", "2015-06-01", "2015-07-01", "2015-08-01", "2015-09-01", "2015-10-01", "2015-11-01", "2015-12-01"];

var y = [1.5, 2.3, 3.5, 1.2, 0.4, 3.1, 1.5, 2.3, 3.5, 1.2, 0.4, 3.1,];


export default {
data: function(){
    return {
        data: [trace],
        chart: null,
        layout: {

        },
        height: 350,
        x: ["2015-01-01", "2015-02-01", "2015-03-01", "2015-04-01",
  "2015-05-01", "2015-06-01", "2015-07-01", "2015-08-01", "2015-09-01", "2015-10-01", "2015-11-01", "2015-12-01"],
        y: [1.5, 2.3, 3.5, 1.2, 0.4, 3.1, 1.5, 2.3, 3.5, 1.2, 0.4, 3.1],
        title: 'Some stocks'

    }
}
}
</script>