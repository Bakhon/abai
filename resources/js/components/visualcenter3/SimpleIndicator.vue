<template>
    <div class="indicatorCell mb-2 pt-2 w-100">
        <div class="d-flex flex-column text-left mb-1 mb-md-0 w-100">
            <div class="txt4 text-nowrap font-weight-bold mb-0">{{ value }}</div>
            <div class="vc-wide-indicator-tooltip-text text-nowrap">
                {{ units }}
            </div>
            <div class="txt1 font-weight-bold m-0 d-flex mt-3">{{ title }}</div>
        </div>
    </div>
</template>
<script src="./SimpleIndicator.js"></script>