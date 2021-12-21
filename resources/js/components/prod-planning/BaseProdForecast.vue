<template>
  <div class="d-flex main-block pt-2 pb-2">
    <div class="left-block d-flex flex-dir-column">
      <prod-plan-sidebar :activatedBlocks="activatedBlocks"/>
    </div>
    <div class="right-block pl-1">

      <div class="forecast-container fs-white">
        <div class="forecast-nav">
          <div v-if="selected" class="forecast-nav-back" @click="onGoBack(selected)">
            <img src="/img/prod-planning/icons/maximize.svg" alt="">
          </div>
          <div class="forecast-nav-item" :class="{ active: i === activeItem, 'not-active':  isComponentActive }"
               v-for="(tab, i) in tabs" :key="i"
               @click="selectedNav(i, tab)">
            {{ tab.title }}
          </div>
        </div>

        <div class="main-border-block">
          <div class="forecast-container-block" v-if="isComponentActive">
            <div class="top-block">
              <div class="plan-block">
                <div class="block-header pb-0 pl-2 pt-1 d-flex border-color">
                  <div>
                    {{ this.trans("prod-plan.days-base-mining") }}
                  </div>
                  <div class="d-flex">
                    <div class="pr-3 pb-1">
                      <img src="/img/GTM/download.svg" alt="">
                    </div>
                    <div class="pr-3 pb-1">
                      <img src="/img/GTM/full-screen.svg" alt="">
                    </div>
                  </div>
                </div>
                <div class="border-block-out">
                  <div class="border-block-in">
                    <div class="p-3 data-block">
                      {{ this.trans("paegtm.empty-well-chart") }}
                    </div>
                  </div>
                </div>
              </div>

              <div class="factor-plan-block">
                <div class="block-header pb-0 pl-2 pt-1 d-flex border-color">
                  <div>
                    {{ this.trans("prod-plan.plan-fact-base-production") }}
                  </div>
                  <div class="d-flex">
                    <div class="pr-3 pb-1">
                      <img src="/img/GTM/download.svg" alt="">
                    </div>
                    <div class="pr-3 pb-1">
                      <img src="/img/GTM/full-screen.svg" alt="">
                    </div>
                  </div>
                </div>
                <div class="border-block-out">
                  <div class="border-block-in">
                    <div class="p-3 data-block">
                      {{ this.trans("paegtm.empty-well-chart") }}
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="bottom-block">
              <div class="debit-plan-block">
                <div class="block-header pb-0 pl-2 pt-1 d-flex border-color">
                  <div>
                    {{ this.trans("prod-plan.reasons-for-deviation") }}
                  </div>
                  <div class="d-flex">
                    <div class="pr-3 pb-1">
                      <img src="/img/GTM/download.svg" alt="">
                    </div>
                    <div class="pr-3 pb-1">
                      <img src="/img/GTM/full-screen.svg" alt="">
                    </div>
                  </div>
                </div>
                <div class="border-block-out">
                  <div class="border-block-in">
                    <div class="p-3 data-block">
                      {{ this.trans("paegtm.empty-well-chart") }}
                    </div>
                  </div>
                </div>
              </div>

              <div class="gtm-vns-block">
                <div class="block-header pb-0 pl-2 pt-1 d-flex border-color">
                  <div>
                    {{ this.trans("prod-plan.reasons-for-drop") }}
                  </div>
                  <div class="d-flex">
                    <div class="pr-3 pb-1">
                      <img src="/img/GTM/download.svg" alt="">
                    </div>
                    <div class="pr-3 pb-1">
                      <img src="/img/GTM/full-screen.svg" alt="">
                    </div>
                  </div>
                </div>
                <div class="border-block-out">
                  <div class="border-block-in">
                    <div class="p-3 data-block">
                      {{ this.trans("paegtm.empty-well-chart") }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <keep-alive v-else>
            <component :is="selected"></component>
          </keep-alive>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import fluidPredictionMethod from "./base-prod-forecast-components/FluidPredictionMethod";
import lysenkoCalculations from "./base-prod-forecast-components/LysenkoCalculations";
import machineLearningMethods from "./base-prod-forecast-components/MachineLearningMethods";
import waterCutPredictionMethod from "./base-prod-forecast-components/WaterCutPredictionMethod";


export default {
  name: 'monitoring-plan-fact',
  data: function () {
    return {
      activatedBlocks: {
        isIndexActive: true,
        isSearchWell: true,
        isIndicatorActive: true,
        isSearchWellButton: false
      },
      tabs: [
        {
          title: this.trans("prod-plan.basic-production-and-injection"),
          component: fluidPredictionMethod,
        },
        {
          title: this.trans("prod-plan.water-cut-prediction-method"),
          component: waterCutPredictionMethod,
        },
        {
          title: this.trans("prod-plan.lysenko-calculations"),
          component: lysenkoCalculations,
        },
        {
          title: this.trans("prod-plan.machine-learning-methods"),
          component: machineLearningMethods,
        }
      ],
      activeItem: null,
      isComponentActive: true,
      selected: null
    }
  },
  methods: {
    selectedNav(i, tab) {
      this.activeItem = i;
      this.selected = tab.component
      this.isComponentActive = false
      this.$emit(tab.title)
    },
    onGoBack(s) {
      s = !s
      this.isComponentActive = true
    },
  },
}
</script>
<style scoped>
.forecast-container {
  display: flex;
  width: 100%;
  height: auto;
  flex-direction: column;
}

.forecast-nav {
  background-color: #272953;
  width: 100%;
  height: 42px;
  margin-bottom: 10px;
  gap: 6px;
  display: flex;
  padding: 6px;
}

.forecast-nav-item {
  width: 100%;
  height: 30px;
  border-radius: 5px;
  background-color: #333975;
  padding-top: 5px;
  text-align: center;
}

.forecast-container-block {
  display: flex;
  flex-direction: column;
  flex: 100%;
  gap: 6px;
}

.top-block {
  display: flex;
  flex: 100%;
  gap: 6px;
}

.bottom-block {
  display: flex;
  flex: 100%;
  gap: 6px;
}

.main-border-block {
  display: flex;
  width: 100%;
  height: 100%;
  border: 6px solid #272953;
  padding: 4px;
}

.right-block {
  display: flex;
  width: 100%;
  height: auto;
}

.left-block {
  background-color: #272953;
  width: 300px;
  height: 936px;
  gap: 10px;
  flex: 1;
}

.fs-white {
  color: white;
}

/**/
.plan-block {
  flex: 50%;
  background-color: #1A214A;
}

.factor-plan-block {
  flex: 50%;
  background-color: #1A214A;
}

.debit-plan-block {
  flex: 50%;
  background-color: #1A214A;
}

.gtm-vns-block {
  flex: 50%;
  background-color: #1A214A;
}

/* block-of-forth */
.block-header {
  height: 8%;
}

.border-block-out {
  height: 92%;
  border: 8px solid #363B68;
}

.border-block-in {
  height: 100%;
  border: 8px solid #1A214A;
}

.border-color {
  background-color: #323370
}

.data-block {
  height: 100%;
}

.active {
  background: #2C44BD;
}


.not-active {
  background: #333975;
}


/**/
</style>