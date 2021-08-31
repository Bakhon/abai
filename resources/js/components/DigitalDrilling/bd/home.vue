<template>
    <div class="digitalDrillingWindow">
        <window-head />
        <div class="windowBody">
            <div id="map"></div>
            <div class="controlButtons">
                <button onclick="$($('div#map_zoom path')[0]).trigger('click');">+</button>
                <button onclick="$($('div#map_zoom path')[2]).trigger('click');">-</button>
            </div>
        </div>
        <div class="WindowFooter">
            <div class="row">
                <div class="col-sm-5 borderRightGrey">
                    <div class="footBlock">
                        <p><img src="/img/digital-drilling/foot5.svg" alt=""><span>{{ trans('digital_drilling.home.operating_oil_pipeline') }}</span></p>
                        <p><img src="/img/digital-drilling/foot6.svg" alt=""><span>{{ trans('digital_drilling.home.operating_gas_pipeline') }}</span></p>
                    </div>
                </div>
                <div class="col-sm-5 borderRightGrey">
                    <div class="footBlock">
                        <p><img src="/img/digital-drilling/foot1.svg" alt=""><img src="/img/digital-drilling/foot2.svg" alt=""><span>{{ trans('digital_drilling.home.exploration_production') }}</span></p>
                        <p><img src="/img/digital-drilling/foot3.svg" alt=""><span>{{ trans('digital_drilling.home.processing') }}</span></p>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="footBlock">
                        <p><img src="/img/digital-drilling/foot4.svg" alt=""><span>{{ trans('digital_drilling.home.DZO') }}</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "home"
    }
</script>

<style scoped>

</style>