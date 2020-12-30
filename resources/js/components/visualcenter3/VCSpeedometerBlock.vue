<template>
    <div class="col first-string mb-1 mb-sm-0 mr-2 ml-2"
         v-bind:class="{'cursor-pointer': showLink}"
         @click="$emit('changeTable', tableToChange)"
    >
        <div class="d-flex flex-row justify-sm-content-center text-sm-left text-center vc-speedometer-title-block">
            <div class="mt-0 mt-sm-4 ml-1 ml-sm-3 w-50 mr-0 mr-sm-0 speedometer-border">
                <h1 class="txt7 vc-speedometer-title m-0">
                    <span v-if="mainTitle">{{ mainTitle }}</span>
                    <span v-else>{{ new Intl.NumberFormat("ru-RU").format(mainValue[4]) }}</span>
                </h1>
                <div class="txt7 in-work">{{ units }}</div>
            </div>
            <div class="mt-0 mt-sm-4 ml-3 w-50 mt-2 mt-sm-0">
                <visual-center-speedometer
                    v-bind:sliderValue="mainValue"
                    v-bind:toolTipPorog="toolTipPorog"
                    v-bind:toolTipAim="toolTipAim"
                    v-bind:toolTipVizov="toolTipVizov"
                    @changeKpdIcon="newKpdIcon => kpdIcon = newKpdIcon"
                ></visual-center-speedometer>
            </div>
            <div class="mt-1 position-absolute" v-if="showLink" style="top:0; right: 0.2rem;">
                <img src="/img/icons/link.svg">
            </div>
        </div>
        <div class="d-none d-sm-flex flex-column flex-sm-row justify-content-center h-25">
            <div class="ml-0 ml-sm-3 w-50 d-flex align-items-center speedometer-border">
                <div class="mr-2">
                    <img src="/img/icons/success-icon.svg">
                </div>
                <div>
                    Исполнение<br />за&nbsp;отчётный период
                </div>
            </div>
            <div class="ml-3 w-50 d-flex align-items-center">
                <div class="mr-2">
                    <img v-if="kpdIcon === 3" src="/img/icons/success-icon.svg">
                    <img v-else-if="kpdIcon === 2" src="/img/icons/blue-circle-icon.svg">
                    <img v-else src="/img/icons/error-icon.svg">
                </div>
                <div>
                    Текущее исполнение КПД
                </div>
            </div>
        </div>
        <div class="d-none d-sm-flex flex-column flex-sm-row justify-content-center vc-speedometer-weight-block">
            <div class="ml-0 ml-sm-3 w-50 d-flex align-items-center speedometer-border">
                <div class="mr-2 in-work">
                    Вес:
                </div>
                <div>
                    {{ new Intl.NumberFormat("ru-RU").format(mainValue[6].toFixed(1)) }}%
                </div>
            </div>
            <div class="ml-3 w-50 d-flex align-items-center">
                <div class="mr-2" v-if="(mainValue[5].toFixed(1) - 100) !== 0">
                    <div v-if="(mainValue[5].toFixed(1) - 100) < 0" class="arrow2"></div>
                    <div v-else class="arrow3"></div>
                </div>
                <div v-if="(mainValue[5].toFixed(1) - 100) !== 0">
                    {{ new Intl.NumberFormat("ru-RU").format(Math.abs(mainValue[5].toFixed(1) - 100)) }}%
                </div>
            </div>
        </div>
        <div class="d-flex align-items-end">
            <div class="text-center text-sm-left ml-sm-3 mt-2 mt-sm-4">
                <h4 class="txt7">{{ title }}</h4>
            </div>
        </div>
    </div>
</template>
<script src="./VCSpeedometerBlock.js"></script>