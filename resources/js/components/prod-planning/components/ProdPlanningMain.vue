<template>
  <div>
    <div class="main-block-nav">
<!--   Навигация   -->
      <div class="block-nav">
        <div class="nav-item pr-2" v-for="tab in tabs" @click="selected = tab.component;">
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
<!--    Период    -->
        <div class="period-well">
          <div class="period-title pl-2 pt-2">
            Период
          </div>
          <div class="period-date pt-2 pb-2 pl-2">
            <div class="begin-date pl-2 pt-1">
              01.08.2018
            </div>
            <div class="end-date pl-2 pt-1">
              01.08.2018
            </div>
            <div class="period-icon">
              *
            </div>
          </div>
        </div>
<!--    end Период    -->

<!--   Выбор скважин     -->
        <div class="select-well">
          <div class="select-well-block pl-2 pt-1">
            <div class="pb-1 pt-1">
              <select class="selection-well">
                <option value="">Выберите ДЗО</option>
              </select>
            </div>

            <div class="pb-1">
              <select class="selection-well">
                <option value="">Выберите месторождение</option>
              </select>
            </div>

            <div class="pb-1">
              <select class="selection-well">
                <option value="">Выберите объект</option>
              </select>
            </div>

            <div class="pb-1">
              <select class="selection-well">
                <option value="">Выберите структуру</option>
              </select>
            </div>

            <div class="pb-1">
              <select class="selection-well">
                <option value="">Выберите ГУ</option>
              </select>
            </div>
          </div>
        </div>

<!--    Выбор скважин end    -->
<!--    Показатель    -->
        <div class="index">
          <div class="index-title pl-2">
            <div class="index-icon">
              <img src="./icons/index-icon.svg" alt="">
            </div>
            <div class="pt-1 pl-2">
              Показатель
            </div>
          </div>

          <div class="index-block">
            <div class="index-block-select">
              <div class="pl-2 pt-1">
                Валовая доля
              </div>
              <div class="pl-1 pt-1">
                <select class="index-selection-well">
                  <option value="">Выберите ГУ</option>
                </select>
              </div>
            </div>
            <div class="index-block-select mt-6">
              <div class="pl-2 pt-1">
                Валовая доля
              </div>
              <div class="pl-1 pt-1">
                <select class="index-selection-well">
                  <option value="">Выберите ГУ</option>
                </select>
              </div>
            </div>
            <div class="index-block-select mt-6">
              <div class="pl-2 pt-1">
                Валовая доля
              </div>
              <div class="pl-1 pt-1">
                <select class="index-selection-well">
                  <option value="">Выберите ГУ</option>
                </select>
              </div>
            </div>
            <div class="index-block-select mt-6">
              <div class="pl-2 pt-1">
                Валовая доля
              </div>
              <div class="pl-1 pt-1">
                <select class="index-selection-well">
                  <option value="">Выберите ГУ</option>
                </select>
              </div>
            </div>
          </div>
        </div>
<!--    Показатель end    -->
<!--   Поиск по скважине     -->
        <div class="find-well">
          <div class="find-well-title pl-2">
            <div class="index-icon">
              <img src="./icons/index-icon.svg" alt="">
            </div>
            <div class="pt-1 pl-2">
              Поиск по скважине
            </div>
          </div>
          <div class="find-well-block-select">
            <div class="find-well-select pl-1 pt-1">
              <div>
                <select class="index-selection-well">
                  <option value="">Выберите ГУ</option>
                </select>
              </div>
            </div>
          </div>
        </div>
<!--   Поиск по скважине end     -->
<!--    Индикатор    -->
        <div class="well-indicator-block">
          <div class="flex-row pl-2">
            <div class="percent-indicator">
              +25
            </div>
            <div class="pt-4 pl-2 percent-unit">
              тыс.тонн
            </div>
          </div>
          <div class=" pl-2 additional-percent pt-1">
            +0,5%
          </div>
          <div class="pl-2">
            Выполнение плана по добыче нефти
          </div>
        </div>
      </div>
      <div class="right-block d-flex">
        <div>
          <component :is="selected"></component>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import businessPlan from "./BusinessPlanning";
import monitorPlanFact from "./MonitoringPlanFact";
import baseProdForecast from "./BaseProdForecast";

export default {
  name: 'prod-plan',
  data: function () {
    return{
      // tabs: ["BusPlan", "MonPlanFact"],
      selected: monitorPlanFact,
      tabs: [
        {
          id: 1,
          title: "Мониторинг план-факт",
          component: monitorPlanFact,
          icon: require('./icons/mon-plan-fact.svg')
        },
        {
          id: 2,
          title: "Прогноз базовой добычи",
          component: businessPlan,
          icon: require('./icons/forecast.svg')
        },
        {
          id: 3,
          title: "Бизнес-планирование",
          component: baseProdForecast,
          icon: require('./icons/bus-plan.svg')
        },
        {
          id: 4,
          title: "Долгосрочная программа",
          component: 'BusPlan',
          icon: require('./icons/program.svg')
        }
      ]
    }
  },
  components: {
    businessPlan,
    monitorPlanFact,
    baseProdForecast
  },
  created() {
    console.log(this.$options.name)
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
  background: #2C44BD;;
}

.nav-title {
  color: white;
  font-size: 16px;
  font-weight: bold;
}

.left-block{
  background-color: #0c2e5a;
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
  background-color: #272953;
  width: 100%;
  height: 936px;

}

.period-well {
  width: 300px;
  height: 74px;
  background-color: #363B68;
}

.period-date {
  display: flex;
  flex-direction: row;
  gap: 10px;
}

.begin-date, .end-date {
  width: 116px;
  height: 30px;
  background: #5D5F7F;
  border: 0.4px solid #454FA1;
  box-sizing: border-box;
  border-radius: 4px;
}

.period-icon {
  width: 32px;
  height: 30px;
  background: #5D5F7F;
  border: 0.4px solid #454FA1;
  box-sizing: border-box;
  border-radius: 4px;
}

.select-well-block {
  width: 300px;
  height: 186px;
  background-color: #30325A;
}

.selection-well {
  width: 288px;
  background: #323370;
  border: 1px solid #272953;
  outline: none;
  height: 30px;
  color: white;
  box-sizing: border-box;
  border-radius: 2px;
}

.index-title, .find-well-title {
  display: flex;
  width: 300px;
  height: 30px;
  background-color: #323370;
  border: 0.5px solid #545580;
  flex-direction: row;
}

.index-block {
  background-color: #30325A;
  padding: 6px;
  width: 300px;
  height: 306px;
}

.index-block-select, .find-well-block-select {
  width: 288px;
  height: 69px;
  background-color: #363B68;
}

.index-selection-well {
  width: 276px;
  background: #24264A;
  border: 1px solid #454FA1;
  outline: none;
  height: 30px;
  color: white;
  box-sizing: border-box;
  border-radius: 4px;
}

.find-well-block-select {
  width: 300px;
  height: 52px;
  padding: 6px;
  background-color: #30325A
}

.find-well-select {
  width: 288px;
  height: 40px;
  background-color: #363B68;
}

.find-well-title {

}

.well-indicator-block {
  width: 300px;
  height: 102px;
  background-color: #30325A;
}

.percent-indicator {
  width: 73px;
  height: 40px;
  font-size: 40px;
  font-weight: 700;
}

.percent-unit {
  color: #82BAFF;
  font-size: 16.4px;
  font-weight: 700;
}

.additional-percent {
  color: #82BAFF;
  font-size: 14px;
  font-weight: 400;
}

</style>