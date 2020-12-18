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
                showTooltip="false"
                max="125"
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
                max="125"
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
        let slider1Value = [0, 49];
        let slider2Value = this.sliderValue ?? 0
        let rangeColor = '#fe5c5c';
        if (slider2Value > 49) {
            slider1Value = [50, 99]
            rangeColor = '#237deb';
        }
        if (slider2Value > 100) {
            slider1Value = [100, 125]
            rangeColor = '#009846';
        }
        return {
            slider1Value: slider1Value,
            slider2Value: slider2Value,
            mainText: this.sliderValue,
            rangeColor: rangeColor,
        };
    },
};
</script>
