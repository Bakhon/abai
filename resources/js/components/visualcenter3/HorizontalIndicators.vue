<template>
  <div class="d-flex flex-column flex-sm-row justify-content-between mb-1 mb-sm-2">
    <indicator
        v-bind:title="'Добыча нефти'"
        v-bind:indicatorValue="oil_fact"
        v-bind:units="'тыс. тонн'"
        v-bind:hasProgressBar="true"
        v-bind:progressValue="oil_fact"
        v-bind:progressMax="oil_plan"
        v-bind:prevPeriodValue="prev_oil_fact"
    ></indicator>
    <indicator
        v-bind:title="'Выручка/Доход'"
        v-bind:indicatorValue="proceeds"
        v-bind:units="'млрд. тенге'"
        v-bind:hasProgressBar="false"
        v-bind:progressPercents="oil_factDayProgressBar"
        v-bind:progressValue="oil_factDay"
        v-bind:progressMax="oil_planDay"
        v-bind:prevPeriodValue="oil_factDayPercent"
    ></indicator>
    <indicator
        v-bind:title="'Расходы'"
        v-bind:indicatorValue="costs"
        v-bind:units="'млрд. тенге'"
        v-bind:hasProgressBar="false"
        v-bind:progressPercents="oil_factDayProgressBar"
        v-bind:progressValue="oil_factDay"
        v-bind:progressMax="oil_planDay"
        v-bind:prevPeriodValue="oil_factDayPercent"
    ></indicator>
    <indicator
        v-bind:title="'Чистая прибыль'"
        v-bind:indicatorValue="net_profit"
        v-bind:units="'млрд. тенге'"
        v-bind:hasProgressBar="false"
        v-bind:progressPercents="oil_factDayProgressBar"
        v-bind:progressValue="oil_factDay"
        v-bind:progressMax="oil_planDay"
        v-bind:prevPeriodValue="oil_factDayPercent"
    ></indicator>
    <indicator
        v-bind:title="'Капиталовложения'"
        v-bind:indicatorValue="capital_investment"
        v-bind:units="'млрд. тенге'"
        v-bind:hasProgressBar="false"
        v-bind:progressPercents="oil_factDayProgressBar"
        v-bind:progressValue="oil_factDay"
        v-bind:progressMax="oil_planDay"
        v-bind:prevPeriodValue="oil_factDayPercent"
    ></indicator>
    <indicator
        v-bind:title="'Свободный денежный поток'"
        v-bind:indicatorValue="cash_flow"
        v-bind:units="'млрд. тенге'"
        v-bind:hasProgressBar="false"
        v-bind:progressPercents="oil_factDayProgressBar"
        v-bind:progressValue="oil_factDay"
        v-bind:progressMax="oil_planDay"
        v-bind:prevPeriodValue="oil_factDayPercent"
    ></indicator>
    <indicator
        v-bind:title="'Цена на нефть'"
        v-bind:indicatorValue="oilNow"
        v-bind:units="'$ / bbl'"
        v-bind:hasProgressBar="false"
        v-bind:progressValue="oilNow"
        v-bind:prevPeriodValue="'40'"
        v-bind:tableToChange="'2'"
        @changeTable="tableToChange => $emit('changeTable', tableToChange)"
    ></indicator>
    <indicator
        v-bind:title="'Курс доллара'"
        v-bind:indicatorValue="currencyNow"
        v-bind:units="'kzt / $'"
        v-bind:hasProgressBar="false"
        v-bind:progressValue="currencyNow"
        v-bind:prevPeriodValue="currencyPrevPeriod"
        v-bind:tableToChange="'3'"
        @changeTable="tableToChange => $emit('changeTable', tableToChange)"
    ></indicator>
  </div>
</template>
<script src="./HorizontalIndicators.js"></script>