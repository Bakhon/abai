<template>
    <div class="first-string flex-grow-1 mb-1 mb-sm-0 mr-0 mr-sm-2 ml-0 ml-sm-2">
        <div class="d-flex flex-row justify-sm-content-center text-sm-left text-center">
            <div class="mt-0 mt-sm-4 ml-1 ml-sm-3 w-50 mr-0 mr-sm-0">
                <p class="txt7 display-4 display-sm-3 m-0">
                    {{ new Intl.NumberFormat("ru-RU").format(mainValue) }}
                </p>
                <div class="txt7 in-work">{{ units }}</div>
            </div>
            <div class="d-block ml-0 ml-sm-3 mr-0 mr-sm-4">
                <div class="speedometer-border h-100 mt-0 mt-sm-2"></div>
            </div>
            <div class="mt-0 mt-sm-4 ml-2 ml-sm-2 w-75 mt-2 mt-sm-0">
                <visual-center-speedometer v-bind:sliderValue="speedometerValue"></visual-center-speedometer>
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
            <p class="txt7">{{ title }}</p>
        </div>
    </div>
</template>
<script src="./VCSpeedometerBlock.js"></script>