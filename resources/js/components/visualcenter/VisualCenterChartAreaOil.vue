<template>
  <div>
    <apexchart
      type="area"
      height="150"
      width="320"
      :options="chartOptions"
      :series="series"
    ></apexchart>
    <div class="begin">{{ begin }}</div>
    <div class="">{{oilPeriod}}</div>
    <div class="end">{{ end }}</div>
  </div>
</template>

<script>
import VueApexCharts from "vue-apexcharts";

export default {
  name: "mix-chart",
  components: {
    "apexchart": VueApexCharts
  },
  props: ["postTitle"],
  data: function () {
    return {
      oilPeriod:"",
      begin: "",
      end: "",
      chartOptions: {
        yaxis: {
          labels: {
            formatter: function (val) {
              return val.toFixed(0);
            },
          },
        },
        chart: {
          scaleIntegersOnly: true,
          toolbar: {
            show: false,
            autoSelected: "pan",
          },
          zoom: {
            enabled: false,
          },
          foreColor: "#FFFFFF",
          height: 150,
          type: "area",
        },
        stroke: {
          curve: "smooth",
        },
        plotOptions: {
          bar: {
            columnWidth: "50%",
          },
        },

        dataLabels: {
          enabled: false,
        },
        labels: [""],
        xaxis: {
          labels: {
            show: false,
          },
        },

        tooltip: {
          enabled: true,
          enabledOnSeries: undefined,
          shared: true,
          followCursor: false,
          intersect: false,
          inverseOrder: false,
          custom: undefined,
          fillSeriesColor: false,
          theme: false,
          style: {
            fontSize: "12px",
            fontFamily: undefined,
          },
          x: {
            show: false,
            format: "dd MMM",
            formatter: undefined,
          },
          y: {
            show: false,
            formatter: undefined,
            title: {
              formatter: (seriesName) => seriesName,
            },
          },
          z: {
            show: false,
            formatter: undefined,
            title: "Size: ",
          },

          marker: {
            show: false,
          },
          fixed: {
            enabled: false,
            position: "topRight",
            offsetX: 0,
            offsetY: 0,
          },
        },
      },
      series: [
        {
          name: "",
          type: "area",
          stroke: {
            curve: "smooth",
          },
          data: [11, 32, 45, 32, 34, 52, 41],
        },
      ],
    };
  },

  mounted() {
    var data = this.postTitle;
    var dates = [];
    var value = [];
    _.forEach(data, function (item) {
      dates.push(item.date);
      value.push(item.value);
    });
    this.begin = dates[0];
    var end = _.takeRight(dates, 1);
    this.end = end[0];
console.log(dates);
    this.chartOptions = { labels: dates };
    this.series = [
      {
        data: value,
      },
    ];
  },
};
</script>
