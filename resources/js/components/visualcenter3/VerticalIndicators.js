export default {
  data: function () {
    return {
      specificIncomePlanTG:'',
      specificIncomeFactTG:'',
      specificIncomePlanUSD:'',
      specificIncomeFactUSD:'',
      unitCostsPlanTG:'',
      unitCostsFactTG:'',
      unitCostsPlanUSD:'',
      unitCostsFactUSD:'',
      kvlPerTonPlan:'',
      kvlPerTonFact:'',
      actualEfficiencyGTMP:'',
      actualEfficiencyGTMUN:'',
      actualDrillingEfficiencyP:'',
      actualDrillingEfficiencyUN:'',
    };
  },
  methods: {
    getDefaultData() {
      this.specificIncomeFactTG = '127567';
      this.specificIncomePlanUSD = '49.98';
      this.specificIncomeFactUSD = '46.68';
      this.unitCostsPlanTG = '105864';
      this. unitCostsFactTG = '101854';
      this.unitCostsPlanUSD = '38.74';
      this.unitCostsFactUSD = '37.27';
      this.kvlPerTonPlan = '16517';
      this.kvlPerTonFact = '14432';
      this.actualEfficiencyGTMP = '2560';
      this.actualEfficiencyGTMUN = '575';
      this.actualDrillingEfficiencyP = '211';
      this.actualDrillingEfficiencyUN = '32';
    },
  },
  mounted() {
    this.getDefaultData();
  }
}