<template>
  <div
    ref="approximation"
    class="scatter-graph-approximation"
    @click="closeApproximation"
  >
    <div class="approximation-content-holder">
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
                  v-model.number="polynomialDegree"
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
            <p
              :style="
                alreadyExists && approximationSelected
                  ? 'border-bottom: 3px solid red'
                  : ''
              "
            >
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
              :class="{
                error: alreadyExists && approximationNameType === 'custom',
              }"
              v-model="approximationCustomName"
              :disabled="approximationNameType !== 'custom'"
              type="text"
              placeholder="????????????"
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
            :graphType="graphType"
          />
          <ScatterGraphApproximationLabelInput
            style="margin-bottom: 10px"
            :inputText.sync="backwardPredict"
            labelTransKey="approximation_backward_predict"
            :graphType="graphType"
          />
          <div class="configure-intersection-holder">
            <ScatterGraphApproximationLabelCheckbox
              style="margin-bottom: 0"
              :graphType="graphType"
              :checkboxInput.sync="isConfigureIntersection"
              labelTransKey="configure_intersection"
              :disableCheckbox="
                approximationSelected !== 'linear' &&
                approximationSelected !== 'polynomial'
              "
            />
            <input
              v-show="isConfigureIntersection"
              type="number"
              step="0.1"
              placeholder="0.0"
              @blur="updateIntersection"
              v-model.number="intersection"
            />
          </div>
          <ScatterGraphApproximationLabelCheckbox
            :graphType="graphType"
            :checkboxInput.sync="isShowEquationOnChart"
            labelTransKey="show_equation_on_chart"
          />
          <ScatterGraphApproximationLabelCheckbox
            :graphType="graphType"
            :checkboxInput.sync="isPlaceValueOfR2"
            labelTransKey="place_value_of_approximation_reliability"
          />
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
            :isAxisInput="true"
            :initialValue="initialMinX"
          />
          <ScatterGraphApproximationLabelInput
            style="margin-bottom: 10px"
            :inputText.sync="abscissaTo"
            labelTransKey="to"
            :isAxisInput="true"
            :initialValue="initialMaxX"
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
            :isAxisInput="true"
            :initialValue="initialMinY"
          />
          <ScatterGraphApproximationLabelInput
            style="margin-bottom: 10px"
            :inputText.sync="ordinateTo"
            labelTransKey="to"
            :isAxisInput="true"
            :initialValue="initialMaxY"
          />
        </div>
      </div>
      <button
        :class="[
          'submit-button',
          approximationSelected.length > 0 || isAxisTyped ? 'rest' : 'disabled',
        ]"
        :disabled="!approximationSelected && !isAxisTyped"
        @click="drawApproximation"
      >
        {{ trans("plast_fluids.done") }}
      </button>
    </div>
    <BaseModal
      v-if="alreadyExists"
      v-show="baseModalOpen"
      @close-modal="baseModalOpen = false"
      @modal-response="baseModalOpen = false"
      :heading="trans('plast_fluids.approximation_name_cannot_be_repeated')"
      type="notify"
    />
  </div>
</template>

<script>
import ScatterGraphApproximationLabelCheckbox from "./ScatterGraphApproximationLabelCheckbox.vue";
import ScatterGraphApproximationLabelInput from "./ScatterGraphApproximationLabelInput.vue";
import BaseModal from "./BaseModal.vue";
import { getGraphApproximation } from "../services/graphService";

export default {
  name: "ScatterGraphApproximation",
  props: {
    series: Array,
    graphType: String,
    seriesNames: Array,
    initialMinY: [String, Number],
    initialMaxY: [String, Number],
    initialMaxX: [String, Number],
    initialMinX: [String, Number],
    defaultIntersection: Number,
    minY: [String, Number],
    maxY: [String, Number],
  },
  components: {
    ScatterGraphApproximationLabelCheckbox,
    ScatterGraphApproximationLabelInput,
    BaseModal,
  },
  data() {
    return {
      isOpen: true,
      baseModalOpen: false,
      aheadPredict: "",
      backwardPredict: "",
      isConfigureIntersection: false,
      isShowEquationOnChart: false,
      isPlaceValueOfR2: false,
      abscissaFrom: "",
      abscissaTo: "",
      intersection: "",
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
      alreadyExists: false,
    };
  },
  computed: {
    isAxisTyped() {
      return [
        this.abscissaFrom,
        this.abscissaTo,
        this.ordinateFrom,
        this.ordinateTo,
      ].some((val) => typeof val === "number");
    },
    isPolynomialSelected() {
      return this.approximationSelected === "polynomial";
    },
    isNameRepeated() {
      if (
        this.approximationNameType === "custom" &&
        !Boolean(this.approximationCustomName)
      ) {
        return true;
      } else {
        return this.seriesNames.includes(
          this.approximationNameType === "custom"
            ? this.approximationCustomName
            : this.trans("plast_fluids." + this.approximationSelected)
        );
      }
    },
  },
  watch: {
    series: {
      handler(data) {
        this.x = [];
        this.y = [];
        data.forEach((item) => {
          this.x.push(item.x);
          this.y.push(item.y);
        });
      },
      immediate: true,
    },
    isConfigureIntersection() {
      this.intersection = this.defaultIntersection ?? "";
    },
    approximationSelected(value) {
      if (value === "linear" || value === "polynomial") {
        this.isConfigureIntersection =
          typeof this.defaultIntersection === "number";
        return;
      }
      this.isConfigureIntersection = false;
    },
  },
  methods: {
    resetState() {
      this.approximationSelected = "";
      this.isPlaceValueOfR2 = false;
      this.isShowEquationOnChart = false;
      this.approximationNameType = "auto";
      this.approximationCustomName = "";
    },
    updatePolynomialDegreeValue(e) {
      if (e.target.value >= 3) {
        this.polynomialDegree = 3;
      }
      if (e.target.value <= 2) {
        this.polynomialDegree = 2;
      }
    },
    updateIntersection(e) {
      if (e.target.value < this.minY) this.intersection = this.minY;
      if (e.target.value > this.maxY) this.intersection = this.maxY;
    },
    closeApproximation(e) {
      e.stopPropagation();
      if (e.target.innerHTML === this.$refs.approximation.innerHTML)
        this.$emit("close-approximation");
    },
    async drawApproximation() {
      const emitData = {};
      if (this.approximationSelected && !this.isNameRepeated) {
        if (typeof this.backwardPredict === "number") {
          const min = Math.min(...this.x);
          this.x.push(min - this.backwardPredict);
          this.y.push(0);
        }
        if (typeof this.aheadPredict === "number") {
          const maxY = Math.max(...this.y);
          const maxX = Math.max(...this.x);
          this.x.push(maxX + this.aheadPredict);
          this.y.push(maxY);
        }
        const requestData = {
          x: this.x,
          y: this.y,
          type:
            this.approximationSelected === "polynomial"
              ? "polynomial_" + this.polynomialDegree
              : this.approximationSelected,
          y0:
            this.isConfigureIntersection &&
            typeof this.intersection === "number"
              ? this.intersection
              : "",
        };
        const {
          approximation_data,
          type,
          function: func,
          r2,
          ...rest
        } = await getGraphApproximation(JSON.stringify(requestData));
        emitData.approximation = {
          data: approximation_data,
          name:
            this.approximationNameType === "auto"
              ? this.trans("plast_fluids." + this.approximationSelected)
              : this.approximationCustomName,
          approximationType: type,
          type: "line",
        };
        if (this.isPlaceValueOfR2) emitData.approximation.r2 = r2;
        if (this.isShowEquationOnChart) {
          const approximationFunction = func
            .split(" ")
            .reduce((prev, polynomial) => {
              Object.keys(rest).forEach((key) =>
                rest[key] == polynomial ? (polynomial = key) : ""
              );
              return `${prev} ${polynomial}`;
            }, "");
          emitData.approximation.function = approximationFunction;
        }
      }
      if (this.isAxisTyped) {
        emitData.graphOptions = {
          abscissaFrom: this.abscissaFrom,
          abscissaTo: this.abscissaTo,
          ordinateFrom: this.ordinateFrom,
          ordinateTo: this.ordinateTo,
        };
      }
      if (
        this.approximationSelected ? !this.isNameRepeated : this.isAxisTyped
      ) {
        this.$emit("get-approximation", emitData);
        this.resetState();
        this.alreadyExists = false;
        this.$emit("close-approximation");
      } else {
        this.alreadyExists = true;
        this.baseModalOpen = true;
      }
    },
  },
};
</script>

<style scoped lang="scss" src="./ScatterGraphApproximationStyles.scss"></style>
