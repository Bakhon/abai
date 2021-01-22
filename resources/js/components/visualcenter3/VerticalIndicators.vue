<template>
    <div class="vertical-indicators-block">
        <wide-indicator
            v-bind:leftNumbers="[{title: trans('visualcenter.plan'), value: udIncomePlan}, {title: trans('visualcenter.fact'), value: udIncomeFact}]"
            v-bind:rightNumbers="[{title: trans('visualcenter.plan'), value: udIncomeBblPlan}, {title: trans('visualcenter.fact'), value: udIncomeBblFact}]"
            v-bind:leftUnits="leftUnits"
            v-bind:rightUnits="rightUnits"
            v-bind:title="trans('visualcenter.ecoBlock4')"
            v-bind:isUpArrow="udIncomeFact > udIncomePlan"
            v-bind:progressPercents="Math.abs((udIncomePlan - udIncomeFact) / udIncomePlan * 100).toFixed(0)"
        ></wide-indicator>
        <!-- 'Удельные доходы' -->
        <wide-indicator
            v-bind:leftNumbers="[{title: trans('visualcenter.plan'), value: udSpendingPlan}, {title: trans('visualcenter.fact'), value: udSpendingFact}]"
            v-bind:rightNumbers="[{title: trans('visualcenter.plan'), value: udSpendingBblPlan}, {title: trans('visualcenter.fact'), value: udSpendingBblFact}]"
            v-bind:leftUnits="leftUnits"
            v-bind:rightUnits="rightUnits"
            v-bind:title="trans('visualcenter.ecoBlock5')"
            v-bind:isUpArrow="udSpendingFact > udSpendingPlan"
            v-bind:progressPercents="Math.abs((udSpendingPlan - udSpendingFact) / udIncomePlan * 100).toFixed(0)"
        ></wide-indicator>
        <!-- 'Удельные расходы' -->
        <wide-indicator
            v-bind:leftNumbers="[{title: trans('visualcenter.plan'), value: kvlPlan}]"
            v-bind:rightNumbers="[{title: trans('visualcenter.fact'), value: kvlFact}]"
            v-bind:leftUnits="leftUnits"
            v-bind:rightUnits="'тенге/тонна'"
            v-bind:title="trans('visualcenter.ecoBlock6')"
            v-bind:isUpArrow="kvlFact > kvlPlan"
            v-bind:progressPercents="Math.abs((kvlPlan - kvlFact) / udIncomePlan * 100).toFixed(0)"
        ></wide-indicator>
        <!-- 'КВЛ на тонну' -->
        <wide-indicator
            v-bind:leftNumbers="[{title: trans('visualcenter.rent'), value: rentGtm}]"
            v-bind:rightNumbers="[{title: trans('visualcenter.nerent'), value: neRentGtm}]"
            v-bind:leftUnits="trans('visualcenter.skvs')"
            v-bind:rightUnits="trans('visualcenter.skvs')"
            v-bind:title="trans('visualcenter.ecoBlock7')"
            v-bind:hidePercents="true"
        ></wide-indicator>
        <!-- 'Фактическая эффективность ГТМ' -->
        <wide-indicator
            v-bind:leftNumbers="[{title: trans('visualcenter.rent'), value: rentBurenie}]"
            v-bind:rightNumbers="[{title: trans('visualcenter.nerent'), value: neRentBurenie}]"
            v-bind:leftUnits="trans('visualcenter.skvs')"
            v-bind:rightUnits="trans('visualcenter.skvs')"
            v-bind:title="trans('visualcenter.ecoBlock8')"
            v-bind:hidePercents="true"
        ></wide-indicator>
        <!-- 'Фактическая эффективность бурения' -->
        <simple-indicator
            v-bind:title="trans('visualcenter.ecoBlock9')"
            v-bind:units="'млн.тенге'"
            v-bind:value="fines"
        ></simple-indicator>
        <!-- 'Штрафы и пени' -->
    </div>
</template>
<script src="./VerticalIndicators.js"></script>