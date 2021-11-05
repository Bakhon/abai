<template>
  <div>
    <div class="main-block-nav">
      <!--   Навигация   -->
      <div class="block-nav">
        <div class="nav-item pr-2" :class="{ active: i === activeItem}" v-for="(tab, i) in tabs" :key="i"
             @click="selectedNav(i, tab)">
          <div class="nav-icon pl-2 pt-2">
            <img :src="tab.icon" alt="">
          </div>
          <div class="nav-title pl-2 pt-2">
            {{ tab.title }}
          </div>
        </div>
      </div>
    </div>
    <!--  end навигация  -->
    <div class="d-flex main-block pt-2 pb-2">
      <div class="left-block d-flex flex-dir-column">
        <prod-plan-sidebar :activatedBlocks="activatedBlocks"/>
      </div>
      <div class="right-block">
        <monitoring-plan-fact v-if="!selected"></monitoring-plan-fact>
        <keep-alive>
          <component :is="selected"/>
        </keep-alive>
      </div>
    </div>
  </div>
</template>
<script>
import businessPlan from "./components/BusinessPlanning";
import monitorPlanFact from "./components/MonitoringPlanFact";
import baseProdForecast from "./components/BaseProdForecast";
import {baseProdForecastSidebar, monitoringPlanFactSidebar} from "./components/helpers/sideBarObjects";

export default {
  name: 'prod-plan',
  data: function () {
    return {
      activatedBlocks1: {
        isIndexActive: true,
        isSearchWell: true,
        isIndicatorActive: true,
        isSearchWellButton: false
      },
      activeItem: '0',
      selected: null,
      tabs: [
        {
          title: this.trans("prod-plan.plan-fact-monitoring"),
          component: monitorPlanFact,
          icon: require('../../../../public/img/prod-planning/icons/mon-plan-fact.svg'),
        },
        {
          title: this.trans("prod-plan.base-production-forecast"),
          component: baseProdForecast,
          icon: require('../../../../public/img/prod-planning/icons/forecast.svg'),
        },
        {
          title: this.trans("prod-plan.business-planning"),
          component: businessPlan,
          icon: require('../../../../public/img/prod-planning/icons/bus-plan.svg'),
        },
        {
          title: this.trans("prod-plan.long-term-program"),
          component: 'BusPlan',
          icon: require('../../../../public/img/prod-planning/icons/program.svg'),
        }
      ]
    }
  },
  methods: {
    selectedNav(i, tab) {
      this.activeItem = i;
      console.log(i)
      this.selected = tab.component
    },
    onChangePage(e) {
      console.log(e)
    }
  },
  computed: {
    activatedBlocks() {
      if (this.activeItem == 0) {
        return monitoringPlanFactSidebar
      } else if (this.activeItem == 1) {
        return baseProdForecastSidebar
      }
    },
  },
  components: {
    navbarComponents: () => this.busPlan && this.monPlanFact && this.baseProd
  },
  created() {
    console.log(this.$options.name, 'component name')
  }
}
</script>
<style scoped>
.main-block-nav {
  display: flex;
  width: 100%;
}

.mt-6 {
  margin-top: 6px;
}

.flex-row {
  display: flex;
  flex-direction: row;
}

.h-150 {
  height: 150px;
}

.block-nav {
  display: flex;
  justify-content: space-between;
  gap: 10px;
  width: 100%;
}

.nav-item {
  background: #333975;
  width: 100%;
  height: 40px;
  border-radius: 5px;
  display: flex;
  cursor: pointer;
}

.nav-item:hover {
  background: #2C44BD;
}

.active {
  background: #2C44BD;
}

.nav-title {
  color: white;
  font-size: 16px;
  font-weight: bold;
}

.left-block {
  background-color: #272953;
  width: 300px;
  height: 936px;
  gap: 10px;
  flex: 1;
}

.main-block {
  gap: 10px;
  width: 100%;
  color: white;
}

.right-block {
  display: flex;
  width: 100%;
  height: auto;
}


</style>