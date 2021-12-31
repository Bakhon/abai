0<template>
  <div>
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
    <div class="index" v-if="activatedBlocks.isIndexActive">
      <div class="index-title pl-2">
        <div class="index-icon">
          <img src="../../../../../../public/img/prod-planning/icons/index-icon.svg" alt="">
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

    <!--  Редактирование по скважине  -->
    <div class="" v-if="activatedBlocks.isEditedParams">
      <div class="find-well-title pl-2">
        <div class="index-icon">
          <img src="../../../../../../public/img/prod-planning/icons/index-icon.svg" alt="">
        </div>
        <div class="pt-1 pl-2">
          Редактирование параметров
        </div>
      </div>
      <div class="find-well-block-select">
        <div class="find-well-select pl-1 pt-1">
          <div class="sidebar-button mt-1">
            <button class="sidebar-button mt-1" @click="openModal('editParams')">Редактировать</button>
          </div>
        </div>
      </div>
    </div>
    <!--  Основные показатели  -->
    <!--  Редактирование по скважине end  -->

    <div class="" v-if="activatedBlocks.isEditedParams">
      <div class="find-well-title pl-2">
        <div class="index-icon">
          <img src="../../../../../../public/img/prod-planning/icons/index-icon.svg" alt="">
        </div>
        <div class="pt-1 pl-2">
          Основные показатели
        </div>
      </div>
      <div class="find-well-block-select">
        <div class="find-well-select pl-1 pt-1">
          <div class="sidebar-button mt-1">
            <button class="sidebar-button mt-1" @click="openModal('basicIndicators')">Редактировать</button>
          </div>
        </div>
      </div>
    </div>
    <!--  Основные показатели end  -->

<!--    &lt;!&ndash;  Основные показатели  &ndash;&gt;-->
<!--    <div class="" v-if="activatedBlocks.isEditedParams">-->
<!--      <div class="find-well-title pl-2">-->
<!--        <div class="index-icon">-->
<!--          <img src="../../../../../../public/img/prod-planning/icons/index-icon.svg" alt="">-->
<!--        </div>-->
<!--        <div class="pt-1 pl-2">-->
<!--          Редактирование параметров-->
<!--        </div>-->
<!--      </div>-->
<!--      <div class="find-well-block-select">-->
<!--        <div class="find-well-select pl-1 pt-1">-->
<!--          <div class="sidebar-button mt-1">-->
<!--            <button class="sidebar-button mt-1" @click="openModal('editParams')">Редактировать</button>-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->
<!--    &lt;!&ndash;  Основные показатели end  &ndash;&gt;-->

    <!--   Поиск по скважине     -->
    <div class="find-well" v-if="activatedBlocks.isSearchWell">
      <div class="find-well-title pl-2">
        <div class="index-icon">
          <img src="../../../../../../public/img/prod-planning/icons/index-icon.svg" alt="">
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



    <!--  Сохранить расчет  -->
    <div class="search-well-block" v-if="activatedBlocks.isSearchWellButton">
      <div class="search-well-button pt-2">
        Сохранить расчет
      </div>
    </div>
    <!--  Сохарнить расчет end  -->
    <!--    Индикатор    -->
    <div class="well-indicator-block mt-2" v-if="activatedBlocks.isIndicatorActive">
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

    <modal class="modal-bign-wrapper" name="modalEditParams" draggable=".modal-bign-header" :width="500"
           :height="460"
           style="background: transparent;" :adaptive="true">
      <div class="modal-bign modal-bign-container">
        <div class="modal-bign-header">
          <div class="modal-bign-title">Настройки</div>

          <button type="button" class="modal-bign-button" @click="closeModal('modalTabs')">
            {{ trans('pgno.zakrit') }}
          </button>
        </div>

        <div class="Table">
          <edit-parameters></edit-parameters>
        </div>
      </div>
    </modal>


    <modal class="modal-bign-wrapper" name="modalBasicIndicators" draggable=".modal-bign-header" :width="500"
           :height="400"
           style="background: transparent;" :adaptive="true">
      <div class="modal-bign modal-bign-container">
        <div class="modal-bign-header">
          <div class="modal-bign-title">Настройки</div>

          <button type="button" class="modal-bign-button" @click="closeModal('modalTabs')">
            {{ trans('pgno.zakrit') }}
          </button>
        </div>

        <div class="Table">
          <basic-indicators></basic-indicators>
        </div>
      </div>
    </modal>
  </div>
</template>
<script>

import EditParameters from "./modals/EditParameters";
import BasicIndicators from "./modals/BasicIndicators";

export default {
  components: {
    'edit-parameters': EditParameters,
    'basic-indicators': BasicIndicators
  },
  props: {
    activatedBlocks: {},
  },
  data: function () {
    return {}
  },
  methods: {
    openModal(v) {
      if(v === 'editParams') {
        this.$modal.show('modalEditParams')
      } else if (v === 'basicIndicators') {
        this.$modal.show('modalBasicIndicators')
      }
    }
  }
}

</script>
<style scoped>
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

.search-well-block {
  padding-block: 10px;
  padding-inline: 6px;
}

.search-well-button {
  background-color: #293688;
  width: 100%;
  height: 40px;
  border: 0.5px solid #3366FF;
  text-align: center;
  border-radius: 6px;
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


</style>