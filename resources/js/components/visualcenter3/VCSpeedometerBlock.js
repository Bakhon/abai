export default {
  props: {
    title: {
      default: 'Данные по умолчанию',
    },
    mainValue: {
      default: '777',
    },
    units: {
      default: 'млрд. тенге',
    },
    tableToChange: {
      default: 1,
    },
  },
  data: function () {
    return {}
  },
  mounted() {
    console.log(this.mainValue)
  }
}