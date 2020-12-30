export default {
  props: {
    title: {
      default: 'Данные по умолчанию',
    },
    mainTitle: {
      default: '',
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
    toolTipPorog: '',
    toolTipAim: '',
    toolTipVizov: '',
    showLink: false,
    isLastBlock: false,
  },
  data: function () {
    return {
      kpdIcon: 1,
    }
  }
}