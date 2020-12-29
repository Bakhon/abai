<template>
    <div class="col first-string mb-1 mb-sm-0"
         v-bind:class="{'cursor-pointer': showLink, 'mr-2': !isLastBlock}"
         @click="$emit('changeTable', tableToChange)"
    >
        <div class="d-flex flex-row justify-sm-content-center text-sm-left text-center h-50">
            <div class="mt-0 mt-sm-4 ml-1 ml-sm-3 w-50 mr-0 mr-sm-0">
                <h1 class="txt7 display-sm-3 m-0">
                    <span v-if="mainTitle">{{ mainTitle }}</span>
                    <span v-else>{{ new Intl.NumberFormat("ru-RU").format(mainValue[4]) }}</span>
                </h1>
                <div class="txt7 in-work">{{ units }}</div>
            </div>
            <div class="d-block ml-0 ml-sm-3 mr-0 mr-sm-5">
                <div class="speedometer-border h-100 mt-0 mt-sm-2"></div>
            </div>
            <div class="mt-0 mt-sm-4 ml-2 ml-sm-2 w-75 mt-2 mt-sm-0">
                <visual-center-speedometer
                    v-bind:sliderValue="mainValue"
                    v-bind:sliderTooltip="sliderTooltip"
                    @changeKpdIcon="newKpdIcon => kpdIcon = newKpdIcon"
                ></visual-center-speedometer>
            </div>
            <div class="mt-1" v-if="showLink">
                <img src="/img/icons/link.svg">
            </div>
        </div>
        <div class="d-none d-sm-flex flex-column flex-sm-row justify-content-center h-25">
            <div class="mt-0 mt-sm-4 ml-0 ml-sm-3 w-50 d-flex align-items-center">
                <div class="mr-2">
                    <img src="/img/icons/success-icon.svg">
                </div>
                <div>
                    Исполнение<br />за&nbsp;отчётный период
                </div>
            </div>
            <div class="d-none d-sm-block ml-0 ml-sm-3 mr-0 mr-sm-3">
                <div class="h-100 mt-0 mt-sm-2"></div>
            </div>
            <div class="mt-0 mt-sm-3 ml-0 ml-sm-2 w-75 d-flex align-items-center">
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
        <div class="d-flex align-items-end h-25">
            <div class="text-center text-sm-left ml-sm-3 mt-2 mt-sm-5">
                <h4 class="txt7">{{ title }}</h4>
            </div>
        </div>
    </div>
</template>
<script src="./VCSpeedometerBlock.js"></script>