<template>
  <div>
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
                  <div class="block-header pb-0 pl-2 pt-1 d-flex border-color fs-white">
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
      </div>
    </div>
  </div>
</template>
<script>
import basicProductionAndInjection from "./business-planning-components/BasicProductionAndInjection";
import choosingDrillingProgram from "./business-planning-components/ChoosingDrillingProgram";
import geologicalTechnicalMeasuresProgram from "./business-planning-components/GeologicalTechnicalMeasuresProgram";
import optimalScenario from "./business-planning-components/OptimalScenario";

export default {
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
    },
    onGoBack(s) {
      s = !s
      this.isComponentActive = true
    },
  }
}
</script>
