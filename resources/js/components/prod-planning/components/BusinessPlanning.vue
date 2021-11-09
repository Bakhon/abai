<template>
  <div class="forecast-container">
    <div class="forecast-nav">
      <div v-if="selected" class="forecast-nav-back" @click="onGoBack(selected)">
        <img src="../../../../../public/img/prod-planning/icons/maximize.svg" alt="">
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
        <component :is="selected" @backToProdForecast="onChangePage()"></component>
      </keep-alive>
    </div>
  </div>
</template>
<script>
import basicProductionAndInjection from "./business-planning-components/BasicProductionAndInjection";
import choosingDrillingProgram from "./business-planning-components/ChoosingDrillingProgram";
import geologicalTechnicalMeasuresProgram from "./business-planning-components/GeologicalTechnicalMeasuresProgram";
import optimalScenario from "./business-planning-components/OptimalScenario";

export default {
  name: 'bus-plan',
  data: function () {
    return {
      tabs: [
        {
          title: this.trans("prod-plan.basic-production-and-injection"),
          component: basicProductionAndInjection,
        },
        {
          title: this.trans("prod-plan.geologica-technical-measures-program"),
          component: choosingDrillingProgram,
        },
        {
          title: this.trans("prod-plan.сhoosing-drilling-program"),
          component: geologicalTechnicalMeasuresProgram,
        },
        {
          title: this.trans("prod-plan.optimal-scenario"),
          component: optimalScenario,
        }
      ],
      activeItem: null,
      isComponentActive: true,
      selected: null
    }
  }, methods: {
    selectedNav(i, tab) {
      this.activeItem = i;
      this.selected = tab.component
      this.isComponentActive = false
      this.$emit(tab.title)
      console.log(i)
    },
    onGoBack(s) {
      s = !s
      this.isComponentActive = true
    },
  },
  created() {
    console.log('created hook')
  }
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