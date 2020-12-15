<template>
  <div class="d-flex flex-column flex-sm-row justify-content-between mb-1 mb-sm-2">
    <indicator
        v-bind:title="'Добыча нефти'"
        v-bind:indicatorValue="oil_fact"
        v-bind:units="'тыс. тонн'"
        v-bind:hasProgressBar="true"
        v-bind:progressPercents="oil_factDayProgressBar"
        v-bind:progressValue="oil_factDay"
        v-bind:progressMax="oil_planDay"
        v-bind:lastPeriod="'vs ' + lastMonth"
        v-bind:prevPeriodValue="oil_factDayPercent"
    ></indicator>
    <indicator
        v-bind:title="'Выручка/Доход'"
        v-bind:indicatorValue="proceeds"
        v-bind:units="'млрд. тенге'"
        v-bind:hasProgressBar="true"
        v-bind:progressPercents="oil_factDayProgressBar"
        v-bind:progressValue="oil_factDay"
        v-bind:progressMax="oil_planDay"
        v-bind:lastPeriod="'от плана'"
        v-bind:prevPeriodValue="oil_factDayPercent"
    ></indicator>
    <indicator
        v-bind:title="'Расходы'"
        v-bind:indicatorValue="costs"
        v-bind:units="'млрд. тенге'"
        v-bind:hasProgressBar="true"
        v-bind:progressPercents="oil_factDayProgressBar"
        v-bind:progressValue="oil_factDay"
        v-bind:progressMax="oil_planDay"
        v-bind:lastPeriod="'от плана'"
        v-bind:prevPeriodValue="oil_factDayPercent"
    ></indicator>
    <indicator
        v-bind:title="'Чистая прибыль'"
        v-bind:indicatorValue="net_profit"
        v-bind:units="'млрд. тенге'"
        v-bind:hasProgressBar="true"
        v-bind:progressPercents="oil_factDayProgressBar"
        v-bind:progressValue="oil_factDay"
        v-bind:progressMax="oil_planDay"
        v-bind:lastPeriod="'от плана'"
        v-bind:prevPeriodValue="oil_factDayPercent"
    ></indicator>
    <indicator
        v-bind:title="'Капиталовложения'"
        v-bind:indicatorValue="capital_investment"
        v-bind:units="'млрд. тенге'"
        v-bind:hasProgressBar="true"
        v-bind:progressPercents="oil_factDayProgressBar"
        v-bind:progressValue="oil_factDay"
        v-bind:progressMax="oil_planDay"
        v-bind:lastPeriod="'от плана'"
        v-bind:prevPeriodValue="oil_factDayPercent"
    ></indicator>
    <indicator
        v-bind:title="'Свободный денежный поток'"
        v-bind:indicatorValue="cash_flow"
        v-bind:units="'млрд. тенге'"
        v-bind:hasProgressBar="true"
        v-bind:progressPercents="oil_factDayProgressBar"
        v-bind:progressValue="oil_factDay"
        v-bind:progressMax="oil_planDay"
        v-bind:lastPeriod="'от плана'"
        v-bind:prevPeriodValue="oil_factDayPercent"
    ></indicator>
    <indicator
        v-bind:title="'Цена на нефть'"
        v-bind:indicatorValue="oilNow"
        v-bind:units="'$ / bbl'"
        v-bind:hasProgressBar="false"
        v-bind:progressValue="oilNow"
        v-bind:lastPeriod="'vs пр. пер.'"
        v-bind:prevPeriodValue="'40'"
    ></indicator>
    <indicator
        v-bind:title="'Курс доллара'"
        v-bind:indicatorValue="currencyNow"
        v-bind:units="'kzt / $'"
        v-bind:hasProgressBar="false"
        v-bind:progressValue="currencyNow"
        v-bind:lastPeriod="'vs вчера'"
        v-bind:prevPeriodValue="currencyPrevPeriod"
    ></indicator>
  </div>
</template>
<script src="./HorizontalIndicators.js"></script>