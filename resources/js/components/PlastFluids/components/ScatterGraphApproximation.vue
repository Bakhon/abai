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
      <div class="approximation-dropdown content" v-show="isOpen">
        <div v-for="(approximation, index) in approximations" :key="index">
          <div class="approximation-radio-holder">
            <img
              :src="'/img/PlastFluids/' + approximation + 'Approximation.svg'"
            />
            <div>
              <input
                type="radio"
                :id="'approximation-' + approximation"
              /><label :for="'approximation-' + approximation">{{
                trans(`plast_fluids.${approximation}`)
              }}</label>
            </div>
          </div>
          <div
            class="polynomial-degree-holder"
            v-if="approximation === 'polynomial'"
          >
            <label for="polynomial-degree">Степень:</label>
            <input
              type="number"
              @blur="updatePolynomialDegreeValue"
              v-model="computedPolynomialDegree"
              id="polynomial-degree"
              min="2"
              max="3"
            />
          </div>
        </div>
      </div>
      <div class="approximation-title">
        <div class="approximation-title-heading subtitle">
          <p>Название аппроксимирующей (сглаженной)</p>
        </div>
        <div class="approximation-title-content content">
          <div class="approximation-title-auto-div">
            <div>
              <input type="radio" id="approximation-title-auto" /><label
                for="approximation-title-auto"
                >Автоматически</label
              >
            </div>
            <p>Линейный</p>
          </div>
          <div class="approximation-title-custom-div">
            <div>
              <input type="radio" id="approximation-title-custom" /><label
                for="approximation-title-custom"
                >Другое</label
              >
            </div>
            <input type="text" placeholder="другое" />
          </div>
        </div>
      </div>
      <div class="approximation-forecast">
        <div class="subtitle"><p>Прогноз</p></div>
        <div class="approximation-forecast-content content">
          <div class="approximation-forecast-space-input">
            <label for="">Вперед на</label
            ><input type="number" step="0.1" id="" placeholder="0,0" />
          </div>
          <div class="approximation-forecast-space-input">
            <label for="">Назад на</label
            ><input type="number" step="0.1" id="" placeholder="0,0" />
          </div>
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
    </div>
  </div>
</template>

<script>
export default {
  name: "ScatterGraphApproximation",
  data() {
    return {
      isOpen: true,
      polynomialDegree: 2,
      approximations: [
        "exponential",
        "linear",
        "logarithmic",
        "polynomial",
        "power",
      ],
      children: ["polynomial_2", "polynomial_3"],
    };
  },
  computed: {
    computedPolynomialDegree: {
      get() {
        return Number(this.polynomialDegree);
      },
      set(value) {
        this.polynomialDegree = Number(value);
      },
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
  z-index: 2;
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
  justify-content: center;
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
  margin-bottom: 6px;
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
  margin-bottom: 6px;
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

.approximation-forecast-space-input {
  display: flex;
  justify-content: space-between;
}

.approximation-forecast-space-input > input {
  font-size: 14px;
  background-color: #1f2142;
  color: #a5a6b3;
  padding: 3px 10px;
  border: 0.5px solid #454fa1;
  border-radius: 4px;
}

.approximation-forecast-space-input > input::-webkit-outer-spin-button,
.approximation-forecast-space-input > input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

.approximation-forecast-space-input > input[type="number"] {
  -moz-appearance: textfield;
}

.approximation-forecast-space-input:nth-of-type(1) {
  margin-bottom: 6px;
}

.approximation-forecast-space-input:nth-of-type(2) {
  margin-bottom: 10px;
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
  padding: 12px 7px;
}

.subtitle > p,
.subtitle > span {
  margin: 0;
  font-size: 14px;
}

.content {
  background-color: #4d5093;
  width: 100%;
}

button {
  border: none;
  color: #fff;
}

.polynomial-degree-holder > input::-webkit-inner-spin-button,
.polynomial-degree-holder > input::-webkit-outer-spin-button {
  opacity: 1;
}
</style>
