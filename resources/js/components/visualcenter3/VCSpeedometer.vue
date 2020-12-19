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
                step="0.1"
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
                :min="min"
                :max="max"
                step="0.1"
                :tooltip-format="tooltipFormat"
            />
        </div>
    </div>
</template>

<script>
import RoundSlider from 'vue-round-slider';

Vue.component("round-slider", RoundSlider);
export default {
    props: {
        sliderValue: {
            default: function () {
                return [1, 0, 50, 100, 48]
            }
        }
    },
    data: function () {
        return {
            slider1Value: [0, 100],
            slider2Value: 50,
            rangeColor: '#fe5c5c',
            min: 0,
            max: 100,
            tooltipValue: 0,
        };
    },
    methods: {
        tooltipFormat: function () {
            return this.tooltipValue;
        }
    },
    mounted() {
        let item = this.sliderValue;
        let rangeColor = '#fe5c5c';
        let slider1Value = [0, 33];
        let slider2Value = item[4];
        if (slider2Value >= item[2]) {
            slider1Value = [33, 74]
            rangeColor = '#237deb';
        }
        if (slider2Value >= item[3]) {
            slider1Value = [75, 100]
            rangeColor = '#009846';
        }
        this.slider1Value = slider1Value;
        this.slider2Value = slider2Value;
        this.tooltipValue = item[2];
        this.rangeColor = rangeColor;
        this.min = item[1];
        this.max = item[3];
    }
};
</script>
