<template>
  <div>
    <apexchart
      type="area"
      height="150"
      width="320"
      :options="chartOptions"
      :series="series"
    ></apexchart>
  </div>
</template>

<script>
import VueApexCharts from "vue-apexcharts";

Vue.component("apexchart", VueApexCharts);
export default {
  name: "mix-chart",
  props: ["postTitles"],
  data: function () {
    return {
      chartOptions: {
        chart: {
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
          name: "Курс",
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
    var data = this.postTitles;
    var dates = [];
    var value = [];
    _.forEach(data.data, function (item) {
      dates.push(item.dates);
      value.push(new Intl.NumberFormat('ru-RU').format(item.value));
    });

    this.chartOptions = { labels: dates };
    this.series = [
      {
        data: value,
      },
    ];
  },
};
</script>
