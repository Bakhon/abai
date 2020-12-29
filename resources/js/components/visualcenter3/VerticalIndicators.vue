<template>
    <div>
        <wide-indicator
            v-bind:leftNumbers="[{title: 'план', value: udIncomePlan}, {title: 'факт', value: udIncomeFact}]"
            v-bind:rightNumbers="[{title: 'план', value: udIncomeBblPlan}, {title: 'факт', value: udIncomeBblFact}]"
            v-bind:leftUnits="leftUnits"
            v-bind:rightUnits="rightUnits"
            v-bind:title="'Удельные доходы'"
            v-bind:isUpArrow="udIncomeFact > udIncomePlan"
            v-bind:progressPercents="Math.abs((udIncomePlan - udIncomeFact) / udIncomePlan * 100).toFixed(0)"
        ></wide-indicator>
        <wide-indicator
            v-bind:leftNumbers="[{title: 'план', value: udSpendingPlan}, {title: 'факт', value: udSpendingFact}]"
            v-bind:rightNumbers="[{title: 'план', value: udSpendingBblPlan}, {title: 'факт', value: udSpendingBblFact}]"
            v-bind:leftUnits="leftUnits"
            v-bind:rightUnits="rightUnits"
            v-bind:title="'Удельные расходы'"
            v-bind:isUpArrow="udSpendingFact > udSpendingPlan"
            v-bind:progressPercents="Math.abs((udSpendingPlan - udSpendingFact) / udIncomePlan * 100).toFixed(0)"
        ></wide-indicator>
        <wide-indicator
            v-bind:leftNumbers="[{title: 'план', value: kvlPlan}]"
            v-bind:rightNumbers="[{title: 'факт', value: kvlFact}]"
            v-bind:leftUnits="leftUnits"
            v-bind:rightUnits="'тенге/тонна'"
            v-bind:title="'КВЛ на тонну'"
            v-bind:isUpArrow="kvlFact > kvlPlan"
            v-bind:progressPercents="Math.abs((kvlPlan - kvlFact) / udIncomePlan * 100).toFixed(0)"
        ></wide-indicator>
        <wide-indicator
            v-bind:leftNumbers="[{title: 'рентабельные', value: rentGtm}]"
            v-bind:rightNumbers="[{title: 'нерентабельные', value: neRentGtm}]"
            v-bind:leftUnits="'скважины'"
            v-bind:rightUnits="'скважины'"
            v-bind:title="'Фактическая эффективность ГТМ'"
            v-bind:hidePercents="true"
        ></wide-indicator>
        <wide-indicator
            v-bind:leftNumbers="[{title: 'рентабельные', value: rentBurenie}]"
            v-bind:rightNumbers="[{title: 'нерентабельные', value: neRentBurenie}]"
            v-bind:leftUnits="'скважины'"
            v-bind:rightUnits="'скважины'"
            v-bind:title="'Фактическая эффективность бурения'"
            v-bind:hidePercents="true"
        ></wide-indicator>
        <simple-indicator
            v-bind:title="'Штрафы и пени'"
            v-bind:units="'млн.тенге'"
            v-bind:value="fines"
        ></simple-indicator>
    </div>
</template>
<script src="./VerticalIndicators.js"></script>