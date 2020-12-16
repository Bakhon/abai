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
    tableToChange: {
      default: "1",
    },
  },
  data: function () {
    return {
      isActive: false,
    };
  },
  methods: {
    onClick() {
      let tableToChange = this.tableToChange
      this.isActive = !this.isActive;
      if (!this.isActive) {
        tableToChange = "1";
      }
      this.$emit('changeTable', tableToChange);
    }
  }
}