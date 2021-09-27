<template>
  <div class="scatter-graph-approximation">
    <div
      class="approximation-content-holder"
      v-click-outside="closeApproximation"
    >
      <div class="approximation-header">
        <p>{{ trans("plast_fluids.trendline_format") }}</p>
        <button @click="$emit('close-approximation')">
          <img src="/img/PlastFluids/close.svg" alt="close approximation" />
        </button>
      </div>
      <div class="approximation-dropdown-holder">
        <button
          class="approximation-dropdown-button subtitle"
          @click="isOpen = !isOpen"
        >
          <span>{{ trans("plast_fluids.charts_approximation_settings") }}</span>
          <img
            :style="isOpen ? 'transform: rotate(90deg);' : ''"
            src="/img/PlastFluids/backArrow.svg"
          />
        </button>
        <transition
          name="fade"
          mode="out-in"
          :duration="{ enter: 500, leave: 100 }"
        >
          <div class="approximation-dropdown content" v-show="isOpen">
            <div v-for="(approximation, index) in approximations" :key="index">
              <div class="approximation-radio-holder">
                <img
                  :src="
                    '/img/PlastFluids/' + approximation + 'Approximation.svg'
                  "
                />
                <div>
                  <input
                    type="radio"
                    :id="'approximation-' + approximation + graphType"
                    :value="approximation"
                    v-model="approximationSelected"
                  /><label
                    :for="'approximation-' + approximation + graphType"
                    >{{ trans(`plast_fluids.${approximation}`) }}</label
                  >
                </div>
              </div>
              <div
                class="polynomial-degree-holder"
                :style="!isPolynomialSelected ? 'cursor: not-allowed' : ''"
                v-if="approximation === 'polynomial'"
              >
                <label
                  :style="
                    !isPolynomialSelected
                      ? 'opacity: .5; cursor: not-allowed;'
                      : ''
                  "
                  for="polynomial-degree"
                  >{{ trans("plast_fluids.degree") }}:</label
                >
                <input
                  type="number"
                  @blur="updatePolynomialDegreeValue"
                  v-model="computedPolynomialDegree"
                  :style="!isPolynomialSelected ? 'cursor: not-allowed;' : ''"
                  :disabled="!isPolynomialSelected"
                  id="polynomial-degree"
                  min="2"
                  max="3"
                />
              </div>
            </div>
          </div>
        </transition>
      </div>
      <div class="approximation-title">
        <div class="approximation-title-heading subtitle">
          <p>{{ trans("plast_fluids.approximation_name") }}</p>
        </div>
        <div class="approximation-title-content content">
          <div class="approximation-title-auto-div">
            <div>
              <input
                v-model="approximationNameType"
                value="auto"
                type="radio"
                :id="'approximation-title-auto' + graphType"
              /><label :for="'approximation-title-auto' + graphType">{{
                trans("plast_fluids.auto")
              }}</label>
            </div>
            <p>
              {{
                approximationSelected
                  ? trans(`plast_fluids.${approximationSelected}`)
                  : ""
              }}
            </p>
          </div>
          <div class="approximation-title-custom-div">
            <div>
              <input
                v-model="approximationNameType"
                value="custom"
                type="radio"
                :id="'approximation-title-custom' + graphType"
              /><label :for="'approximation-title-custom' + graphType">{{
                trans("plast_fluids.other")
              }}</label>
            </div>
            <input
              v-model="approximationCustomName"
              :disabled="approximationNameType !== 'custom'"
              type="text"
              placeholder="другое"
            />
          </div>
        </div>
      </div>
      <div class="approximation-forecast">
        <div class="subtitle">
          <p>{{ trans("plast_fluids.predict") }}</p>
        </div>
        <div class="approximation-forecast-content content">
          <ScatterGraphApproximationLabelInput
            :inputText.sync="aheadPredict"
            labelTransKey="approximation_ahead_predict"
          />
          <ScatterGraphApproximationLabelInput
            style="margin-bottom: 10px;"
            :inputText.sync="backwardPredict"
            labelTransKey="approximation_backward_predict"
          />
          <div class="approximation-forecast-checkbox-holder">
            <input
              type="checkbox"
              id="approximation-configure-intersection"
            /><label for="approximation-configure-intersection">{{
              trans("plast_fluids.configure_intersection")
            }}</label>
          </div>
          <div class="approximation-forecast-checkbox-holder">
            <input type="checkbox" id="approximation-show-equation" /><label
              for="approximation-show-equation"
              >{{ trans("plast_fluids.show_equation_on_chart") }}</label
            >
          </div>
          <div class="approximation-forecast-checkbox-holder">
            <input type="checkbox" id="approximation-show-r2" /><label
              for="approximation-show-r2"
              >{{
                trans("plast_fluids.place_value_of_approximation_reliability")
              }}</label
            >
          </div>
        </div>
      </div>
      <div class="abscess-axis">
        <div class="subtitle">
          <p>{{ trans("plast_fluids.abscissa_axis_settings") }}</p>
        </div>
        <div class="approximation-forecast-content content">
          <ScatterGraphApproximationLabelInput
            :inputText.sync="abscissaFrom"
            labelTransKey="from"
          />
          <ScatterGraphApproximationLabelInput
            style="margin-bottom: 10px;"
            :inputText.sync="abscissaTo"
            labelTransKey="to"
          />
        </div>
      </div>
      <div class="ordinate-axis">
        <div class="subtitle">
          <p>{{ trans("plast_fluids.ordinate_axis_settings") }}</p>
        </div>
        <div class="approximation-forecast-content content">
          <ScatterGraphApproximationLabelInput
            :inputText.sync="ordinateFrom"
            labelTransKey="from"
          />
          <ScatterGraphApproximationLabelInput
            style="margin-bottom: 10px;"
            :inputText.sync="ordinateTo"
            labelTransKey="to"
          />
        </div>
      </div>
      <button
        :class="[
          'submit-button',
          approximationSelected.length > 0 || isAxisTyped ? 'rest' : 'disabled',
        ]"
        :disabled="approximationSelected.length === 0 && !isAxisTyped"
        @click="drawApproximation"
      >
        {{ trans("plast_fluids.done") }}
      </button>
    </div>
  </div>
</template>

<script>
import ScatterGraphApproximationLabelInput from "./ScatterGraphApproximationLabelInput.vue";
import { getGraphApproximation } from "../services/graphService";

export default {
  name: "ScatterGraphApproximation",
  props: {
    series: Array,
    graphType: String,
  },
  components: {
    ScatterGraphApproximationLabelInput,
  },
  data() {
    return {
      isOpen: true,
      aheadPredict: "",
      backwardPredict: "",
      abscissaFrom: "",
      abscissaTo: "",
      ordinateFrom: "",
      ordinateTo: "",
      polynomialDegree: 2,
      approximationSelected: "",
      approximations: [
        "exponential",
        "linear",
        "logarithmic",
        "polynomial",
        "power",
      ],
      x: [],
      y: [],
      approximationNameType: "auto",
      approximationCustomName: "",
    };
  },
  computed: {
    isAxisTyped() {
      const isSingleWritten =
        this.abscissaFrom ||
        this.abscissaTo ||
        this.ordinateFrom ||
        this.ordinateTo;
      return isSingleWritten ? true : false;
    },
    computedPolynomialDegree: {
      get() {
        return Number(this.polynomialDegree);
      },
      set(value) {
        this.polynomialDegree = Number(value);
      },
    },
    isPolynomialSelected() {
      return this.approximationSelected === "polynomial";
    },
  },
  watch: {
    series: {
      handler(data) {
        data.forEach((item) => {
          this.x.push(item.x);
          this.y.push(item.y);
        });
      },
      immediate: true,
    },
  },
  methods: {
    updatePolynomialDegreeValue(e) {
      if (e.target.value >= 3) {
        this.polynomialDegree = 3;
      }
      if (e.target.value <= 2) {
        this.polynomialDegree = 2;
      }
    },
    closeApproximation() {
      this.$emit("close-approximation");
    },
    async drawApproximation() {
      const emitData = {};
      if (this.approximationSelected) {
        if (this.backwardPredict) {
          const min = Math.min(...this.x);
          this.x.push(Number(min - this.backwardPredict));
          this.y.push(0);
        }
        if (this.aheadPredict) {
          const maxY = Math.max(...this.y);
          const maxX = Math.max(...this.x);
          this.x.push(Number(maxX + this.aheadPredict));
          this.y.push(maxY);
        }
        const requestData = {
          x: this.x,
          y: this.y,
          type:
            this.approximationSelected === "polynomial"
              ? "polynomial_" + this.computedPolynomialDegree
              : this.approximationSelected,
        };
        const data = await getGraphApproximation(JSON.stringify(requestData));
        emitData.approximation = {
          ...data,
          data: data.approximation_data,
          name:
            this.approximationNameType === "auto"
              ? this.trans("plast_fluids." + this.approximationSelected)
              : this.approximationCustomName,
          approximationType: data.type,
          type: "line",
        };
        delete emitData.approximation.approximation_data;
      }
      if (this.isAxisTyped) {
        emitData.graphOptions = {
          abscissaFrom: this.abscissaFrom,
          abscissaTo: this.abscissaTo,
          ordinateFrom: this.ordinateFrom,
          ordinateTo: this.ordinateTo,
        };
      }
      this.$emit("get-approximation", emitData);
      this.approximationSelected = "";
      this.closeApproximation();
    },
  },
};
</script>

<style scoped lang="scss" src="./ScatterGraphApproximationStyles.scss"></style>