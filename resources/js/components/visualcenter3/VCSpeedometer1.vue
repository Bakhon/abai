<template>
    <div>
        <div class="position-absolute">
            <round-slider
                v-model="slider1Value"
                start-angle="0"
                end-angle="+180"
                line-cap="round"
                radius="80"
                :rangeColor="rangeColor"
                readOnly="true"
                sliderType="range"
                pathColor="#323370"
                width="15"
                handle-size="0"
                showTooltip	="false"
            />
        </div>
        <div class="position-absolute">
            <round-slider
                v-model="slider2Value"
                start-angle="0"
                end-angle="+180"
                line-cap="round"
                radius="80"
                readOnly="true"
                sliderType="default"
                pathColor="transparent"
                width="15"
            />
        </div>
    </div>
</template>

<script>
import RoundSlider from 'vue-round-slider';

Vue.component("round-slider", RoundSlider);
export default {
    props: ['sliderValue'],
    data: function () {
        let slider1Value = [0, 33];
        let slider2Value = this.sliderValue ?? 0
        let rangeColor = '#fe5c5c';
        if (slider2Value > 33) {
            slider1Value = [34, 66]
            rangeColor = '#237deb';
        }
        if (slider2Value > 66) {
            slider1Value = [66, 100]
            rangeColor = '#009846';
        }
        return {
            slider1Value: slider1Value,
            slider2Value: slider2Value,
            rangeColor: rangeColor,
        };
    },
};
</script>
