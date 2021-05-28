<template>
  <div class="d-flex flex-column flex-sm-row justify-content-between mb-1 mb-sm-2">
    <budget-execution-indicator
        v-bind:title="trans('visualcenter.getoil')"
        v-bind:indicatorValue="oilFact"
        v-bind:units="trans('visualcenter.thousand') + ' ' + 'тонн'"
        v-bind:hasProgressBar="true"
        v-bind:progressValue="oilFact"
        v-bind:progressMax="oilPlan"
        v-bind:prevPeriodValue="prevOilFact"
        v-bind:percents="oilPercents"
    ></budget-execution-indicator>
    <budget-execution-indicator
        v-bind:title="trans('visualcenter.ecoBlock1')"
        v-bind:indicatorValue="dataFact"
        v-bind:units="'млрд. тенге'"
        v-bind:hasProgressBar="true"
        v-bind:progressValue="dataFact"
        v-bind:progressMax="dataPlan"
        v-bind:prevPeriodValue="prevDataFact"
        v-bind:percents="dataPercents"
    ></budget-execution-indicator>
    <budget-execution-indicator
        v-bind:title="trans('visualcenter.eco2')"
        v-bind:indicatorValue="spendingFact"
        v-bind:units="'млрд. тенге'"
        v-bind:hasProgressBar="true"
        v-bind:progressValue="spendingFact"
        v-bind:progressMax="spendingPlan"
        v-bind:prevPeriodValue="prevSpendingFact"
        v-bind:percents="spendingPercents"
    ></budget-execution-indicator>
    <budget-execution-indicator
        v-bind:title="trans('visualcenter.ecoBlock2')"
        v-bind:indicatorValue="netProfitFact"
        v-bind:units="'млрд. тенге'"
        v-bind:hasProgressBar="true"
        v-bind:progressValue="netProfitFact"
        v-bind:progressMax="netProfitPlan"
        v-bind:prevPeriodValue="prevNetProfitFact"
        v-bind:percents="netProfitPercents"
    ></budget-execution-indicator>
    <budget-execution-indicator
        v-bind:title="trans('visualcenter.ecoBlock3')"
        v-bind:indicatorValue="capitalInvFact"
        v-bind:units="'млрд. тенге'"
        v-bind:hasProgressBar="true"
        v-bind:progressValue="capitalInvFact"
        v-bind:progressMax="capitalInvPlan"
        v-bind:prevPeriodValue="prevCapitalInvFact"
        v-bind:percents="capitalInvPercents"
    ></budget-execution-indicator>
    <budget-execution-indicator
        v-bind:title="trans('visualcenter.eco9')"
        v-bind:indicatorValue="cashFlowFact"
        v-bind:units="'млрд. тенге'"
        v-bind:hasProgressBar="false"
        v-bind:progressValue="cashFlowFact"
        v-bind:progressMax="cashFlowPlan"
        v-bind:prevPeriodValue="prevCashFlowFact"
        v-bind:percents="cashFlowPercents"
    ></budget-execution-indicator>
    <budget-execution-indicator
        v-bind:title="trans('visualcenter.oilPrice')"
        v-bind:indicatorValue="oilNow"
        v-bind:units="'$ / bbl'"
        v-bind:hasProgressBar="false"
        v-bind:progressValue="oilNow"
        v-bind:prevPeriodValue="'40'"
        v-bind:tableToChange="'2'"
        @changeTable="tableToChange => $emit('changeTable', tableToChange)"
        v-bind:percents="oilPercents"
    ></budget-execution-indicator>
    <budget-execution-indicator
        v-bind:title="trans('visualcenter.usdKurs')"
        v-bind:indicatorValue="currencyNow"
        v-bind:units="'kzt / $'"
        v-bind:hasProgressBar="false"
        v-bind:progressValue="currencyNow"
        v-bind:prevPeriodValue="currencyPrevPeriod"
        v-bind:tableToChange="'3'"
        @changeTable="tableToChange => $emit('changeTable', tableToChange)"
        v-bind:percents="oilPercents"
        v-bind:isLastBlock="true"
    ></budget-execution-indicator>
  </div>
</template>
<script src="./HorizontalIndicators.js"></script>