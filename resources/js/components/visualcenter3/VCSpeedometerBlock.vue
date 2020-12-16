<template>
    <div class="first-string flex-grow-1 mb-1 mb-sm-0 mr-0 mr-sm-2 ml-0 ml-sm-2"  @click="changeTable('4')" :style="`${tableHover4}`">
        <div class="d-flex flex-row justify-sm-content-center text-sm-left text-center">
            <div class="mt-0 mt-sm-4 ml-1 ml-sm-4 w-50 mr-2 mr-sm-0">
                <h1 class="txt7 display-3 m-0">
                    {{ new Intl.NumberFormat("ru-RU").format(mainValue) }}
                </h1>
                <div class="txt7 in-work">{{ units }}</div>
            </div>
            <div class="d-block ml-0 ml-sm-4 mr-0 mr-sm-4">
                <div class="speedometer-border h-100 mt-0 mt-sm-2"></div>
            </div>
            <div class="mt-0 mt-sm-4 ml-2 ml-sm-2 w-75 mt-2 mt-sm-0">
                <visual-center-speedometer1 v-bind:sliderValue="speedometerValue"></visual-center-speedometer1>
            </div>
        </div>
        <div class="d-none d-sm-flex flex-column flex-sm-row justify-content-center">
            <div class="mt-0 mt-sm-4 ml-0 ml-sm-4 w-50">
                Исполнение<br />за&nbsp;отчётный период
            </div>
            <div class="d-none d-sm-block ml-0 ml-sm-4 mr-0 mr-sm-4">
                <div class="h-100 mt-0 mt-sm-2"></div>
            </div>
            <div class="mt-0 mt-sm-4 ml-0 ml-sm-2 w-75">
                Текущее исполнение КПД
            </div>
        </div>
        <div class="text-center text-sm-left ml-sm-4 mt-2 mt-sm-3">
            <h4 class="txt7">{{ title }}</h4>
        </div>
    </div>
</template>
<script src="./VCSpeedometerBlock.js"></script>