<template>
  <div class="scatter-graph-approximation">
    <div
      class="approximation-content-holder"
      v-click-outside="closeApproximation"
    >
      <div class="approximation-header">
        <p>Формат линии тренда</p>
        <button @click="$emit('close-approximation')">
          <img src="/img/PlastFluids/close.svg" alt="close approximation" />
        </button>
      </div>
      <div class="approximation-dropdown-holder">
        <button
          class="approximation-dropdown-button subtitle"
          @click="isOpen = !isOpen"
        >
          <span>Настройка графиков</span>
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
                  /><label :for="'approximation-' + approximation + graphType">{{
                    trans(`plast_fluids.${approximation}`)
                  }}</label>
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
                  >Степень:</label
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
          <p>Название аппроксимирующей (сглаженной)</p>
        </div>
        <div class="approximation-title-content content">
          <div class="approximation-title-auto-div">
            <div>
              <input
                v-model="approximationNameType"
                value="auto"
                type="radio"
                id="approximation-title-auto"
              /><label for="approximation-title-auto">Автоматически</label>
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
                id="approximation-title-custom"
              /><label for="approximation-title-custom">Другое</label>
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
        <div class="subtitle"><p>Прогноз</p></div>
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
            /><label for="approximation-configure-intersection"
              >Настроить пересечение</label
            >
          </div>
          <div class="approximation-forecast-checkbox-holder">
            <input type="checkbox" id="approximation-show-equation" /><label
              for="approximation-show-equation"
              >Показывать уравнение на диаграмме</label
            >
          </div>
          <div class="approximation-forecast-checkbox-holder">
            <input type="checkbox" id="approximation-show-r2" /><label
              for="approximation-show-r2"
              >Поместить на диаграмму величину достоверной аппроксимации
              (R2)</label
            >
          </div>
        </div>
      </div>
      <div class="abscess-axis">
        <div class="subtitle"><p>Настройка оси абсцисс</p></div>
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
        <div class="subtitle"><p>Настройка оси ординат</p></div>
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
        Готово
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
      try {
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
        this.closeApproximation();
      } catch (error) {
      } finally {
      }
    },
  },
};
</script>

<style scoped>
label {
  margin: 0;
  font-size: 14px;
}

.scatter-graph-approximation {
  position: fixed;
  z-index: 1002;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  display: flex;
  justify-content: flex-end;
  align-items: flex-end;
  background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7));
}

.approximation-content-holder {
  position: absolute;
  right: 15px;
  bottom: 5px;
  width: 350px;
  height: 80%;
  display: flex;
  flex-flow: column;
  border: 2px solid #293688;
  background-color: #46498e;
  overflow-y: auto;
}

.approximation-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  height: 42px;
  padding: 13px 14px;
  background-color: #293688;
}

.approximation-header > p {
  margin: 0;
  font-size: 16px;
}

.approximation-header > button {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  height: 22px;
  width: 22px;
  background: none;
}

.approximation-header > button > img {
  width: 10px;
  height: 10px;
}

.approximation-dropdown-button {
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 30px;
  background: none;
}

.approximation-dropdown-button > img {
  transform: rotate(270deg);
  transition: 0.3s ease;
}

.approximation-dropdown {
  padding: 20px 12px;
}

.approximation-dropdown > div {
  display: flex;
  justify-content: space-between;
  width: 100%;
  margin-bottom: 20px;
}

.approximation-dropdown > div:last-child {
  margin-bottom: 0;
}

.approximation-radio-holder {
  display: flex;
  align-items: center;
}

.approximation-radio-holder > img {
  margin-right: 19px;
  width: 20px;
  height: 20px;
}

.approximation-radio-holder > div > input {
  margin-right: 10px;
}

.polynomial-degree-holder {
  display: flex;
  align-items: center;
}

.polynomial-degree-holder > label {
  margin-right: 10px;
}

.approximation-title {
  width: 100%;
}

.approximation-title-content {
  padding: 14px 12px;
}

.approximation-title-content > div {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.approximation-title-content > div > div {
  display: flex;
  align-items: center;
}

.approximation-title-content > div > div > label {
  margin-left: 10px;
}

.approximation-title-auto-div {
  margin-bottom: 10px;
}

.approximation-title-auto-div > p {
  margin: 0;
  font-size: 14px;
}

.approximation-title-custom-div > input {
  font-size: 14px;
  background-color: #1f2142;
  color: #a5a6b3;
  padding: 3px 10px;
  border: 0.5px solid #454fa1;
  border-radius: 4px;
}

.approximation-forecast-content {
  padding: 10px 12px;
}

.approximation-forecast-checkbox-holder {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
}

.approximation-forecast-checkbox-holder:last-child {
  margin-bottom: 0;
}

.approximation-forecast-checkbox-holder > input {
  margin-right: 10px;
}

.subtitle {
  width: 100%;
  background-color: #37408b;
  padding: 7px 12px;
}

.subtitle > p,
.subtitle > span {
  margin: 0;
  font-size: 14px;
}

.content {
  background-color: #4d5093;
  width: 100%;
  margin-bottom: 6px;
}

.submit-button {
  border-radius: 6px;
  font-size: 14px;
  letter-spacing: 2px;
  padding: 8px 30px;
  transition: 0.2s ease-in;
}

.rest:hover {
  background-color: #3366ff;
}

.rest {
  background-color: #2e50e9;
  cursor: pointer;
  font-weight: bold;
}

.disabled {
  background: rgba(101, 106, 138, 0.6);
  border: 1px solid #656a8a;
  cursor: not-allowed;
  font-weight: normal;
}

button {
  border: none;
  color: #fff;
}

.polynomial-degree-holder > input::-webkit-inner-spin-button,
.polynomial-degree-holder > input::-webkit-outer-spin-button {
  opacity: 1;
}

::-webkit-scrollbar {
  height: 4px;
  width: 4px;
}

::-webkit-scrollbar-track {
  background: #272953;
}

::-webkit-scrollbar-thumb {
  background: #656a8a;
}
</style>
