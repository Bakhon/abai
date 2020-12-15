export default {
  props: {
    title: {
      default: 'Добыча нефти',
    },
    indicatorValue: {
      default: 0,
    },
    hasProgressBar: {
      default: false,
    },
    units: {
      default: 'тыс. тонн',
    },
    progressPercents: {
      default: 0,
    },
    progressValue: {
      default: 0,
    },
    progressMax: {
      default: 0,
    },
    lastPeriod: {
      default: "прошл. период",
    },
    prevPeriodValue: {
      default: 0,
    },
  },
  data: function () {
    return {};
  }
}