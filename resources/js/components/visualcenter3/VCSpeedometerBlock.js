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
    planWeight: 0,
  },
  data: function () {
    return {
      kpdIcon: 1,
    }
  }
}