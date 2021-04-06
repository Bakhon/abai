<template>
    <div class="mb-2">
        <div class="indicatorCell flex-grow-1 mb-1 mb-md-0 w-100">
            <div class="d-flex text-right text-sm-left">
                <div class="w-50 d-flex flex-column mr-2">
                    <div v-for="item in leftNumbers">
                        <div class="txt3 font-weight-bold">
                            {{ item.title }}
                        </div>
                        <div class="txt4 text-nowrap font-weight-bold mb-0">{{ new Intl.NumberFormat("ru-RU").format(item.value) }}</div>
                    </div>
                    <div class="vc-wide-indicator-tooltip-text text-nowrap">{{ leftUnits }}</div>
                </div>
                <div class="w-50 wide-indicator-border pl-3">
                    <div class="w-50 d-flex flex-column">
                        <div v-for="item in rightNumbers">
                            <div class="txt3 font-weight-bold">
                                {{ item.title }}
                            </div>
                            <div class="txt4 text-nowrap font-weight-bold mb-0">{{ new Intl.NumberFormat("ru-RU").format(item.value) }}</div>
                        </div>
                    </div>
                    <div class="vc-wide-indicator-tooltip-text text-nowrap">{{ rightUnits }}</div>
                </div>
            </div>
            <div class="d-flex d-flex-row mt-3 justify-content-between">
                <div>
                    <div class="txt1 font-weight-bold m-0 d-flex">{{ title }}</div>
                </div>
                <div v-if="!hidePercents" class="txt2-2 d-flex justify-content-end font-weight-bold align-items-center">
                    <div v-if="isUpArrow" class="arrow3"></div>
                    <div v-else class="arrow2"></div>
                    {{ progressPercents }}%
                </div>
            </div>
        </div>
    </div>
</template>
<script src="./WideIndicator.js"></script>