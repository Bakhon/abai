<template>
    <div class="d-flex justify-content-center">
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
        <div>
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
                tooltipColor="#fefefe"
                showTooltip="false"
            />
        </div>
        <div class="d-flex align-items-end position-absolute vc-speedometer-absolute-values">
            <div class="w-25 text-center">{{ toolTipPorogValue }}</div>
            <div class="w-50 text-center align-self-start pt-5 vc-speedometer-aim">{{ toolTipAimValue }}</div>
            <div class="w-25 text-center">{{ toolTipVizovValue }}</div>
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
        },
        toolTipPorog: '',
        toolTipAim: '',
        toolTipVizov: '',
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
    computed: {
        toolTipPorogValue: function () {
            console.log(this.toolTipPorog);
            return this.toolTipPorog ?? this.sliderValue[1]
        },
        toolTipAimValue: function () {
            return this.toolTipAim ?? this.sliderValue[2]
        },
        toolTipVizovValue: function () {
            return this.toolTipVizov ?? this.sliderValue[3]
        },
    },
    mounted() {
        let item = this.sliderValue;
        let slider1Value = [0, 33];
        let slider2Value = item[4];
        let sortValues = [Math.abs(item[1]), Math.abs(item[2]), Math.abs(item[3])];
        let inverse = item[1] > item[2];
        let rangeColor = inverse ? '#009846' : '#fe5c5c';
        let kpdIcon = inverse ? 3 : 1;
        sortValues = sortValues.sort(function (a, b) {
            return a - b;
        });
        if (slider2Value >= sortValues[1] || (inverse && slider2Value < sortValues[1])) {
            slider1Value = [33, 75]
            rangeColor = '#237deb';
            kpdIcon = 2;
        }
        if (slider2Value >= sortValues[2] || (inverse && slider2Value < sortValues[0])) {
            slider1Value = [66, 100]
            rangeColor = '#009846';
            kpdIcon = 3;
        }
        this.slider1Value = slider1Value;
        this.slider2Value = slider2Value;
        this.tooltipValue = item[2];
        this.rangeColor = rangeColor;
        this.min = item[1];
        this.max = item[3];
        this.$emit('changeKpdIcon', kpdIcon)
    }
};
</script>
