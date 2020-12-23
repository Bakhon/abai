<template>
    <div class="indicatorCell mb-2 pt-2 w-100">
        <div class="d-flex flex-column text-left mb-1 mb-md-0 w-100">
            <h1 class="text-nowrap font-weight-bold mb-0">{{ value }}</h1>
            <div class="vc-wide-indicator-tooltip-text text-nowrap">
                {{ units }}
            </div>
            <h5 class="font-weight-bold m-0 d-flex mt-3">{{ title }}</h5>
        </div>
    </div>
</template>
<script src="./SimpleIndicator.js"></script>