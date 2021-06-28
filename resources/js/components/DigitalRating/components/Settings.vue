<template>
  <div class="rating-settings">
    <div class="rating-content">
      <div class="rating-content__title">
        <div>Диаграмма</div>
        <img src="/img/icons/link.svg" alt="">
      </div>
      <div class="rating-content__wrapper">
        <el-divider direction="vertical"></el-divider>
        <el-divider direction="vertical"></el-divider>
        <el-divider direction="vertical"></el-divider>
      </div>
      <button type="button" class="btn-button btn-button--thm-green ol-w-100 mb-10px">
        Построить карту
      </button>
    </div>
    <div class="rating-panel">
      <div
        class="rating-dropdown"
        :class="{ 'is-active': dropdownTitle === 'field' }"
      >
        <div class="rating-dropdown__header" @click="handleToggle('field')">
          <div class="rating-dropdown__title">Месторождение</div>
          <div class="rating-dropdown__icon"></div>
        </div>
        <transition-expand duration="100">
          <div v-show="dropdownTitle === 'field'" class="rating-dropdown__body">
            <ul class="list">
              <li>Месторождение</li>
              <li>Месторождение</li>
              <li>Месторождение</li>
            </ul>
          </div>
        </transition-expand>
      </div>
      <div
        class="rating-dropdown"
        :class="{ 'is-active': dropdownTitle === 'sector' }"
      >
        <div class="rating-dropdown__header" @click="handleToggle('sector')">
          <div class="rating-dropdown__title">Размер сектора</div>
          <div class="rating-dropdown__icon"></div>
        </div>
        <transition-expand duration="100">
          <div v-show="dropdownTitle === 'sector'" class="rating-dropdown__body">
            <ul class="list">
              <li>100x100</li>
              <li>150x150</li>
              <li>200x200</li>
            </ul>
          </div>
        </transition-expand>
      </div>
      <div
        class="rating-dropdown"
        :class="{ 'is-active': dropdownTitle === 'fund' }"
      >
        <div class="rating-dropdown__header" @click="handleToggle('fund')">
          <div class="rating-dropdown__title">Фонд</div>
          <div class="rating-dropdown__icon"></div>
        </div>
        <transition-expand duration="100">
          <div v-show="dropdownTitle === 'fund'" class="rating-dropdown__body">
            <ul class="list">
              <li>Действующий</li>
              <li>Контрольный</li>
            </ul>
          </div>
        </transition-expand>
      </div>
      <div
        class="rating-dropdown"
        :class="{ 'is-active': dropdownTitle === 'ranking' }"
      >
        <div class="rating-dropdown__header" @click="handleToggle('ranking')">
          <div class="rating-dropdown__title">Сценарий ранжирования</div>
          <div class="rating-dropdown__icon"></div>
        </div>
        <transition-expand duration="100">
          <div v-show="dropdownTitle === 'ranking'" class="rating-dropdown__body">
            <ul class="list">
              <li>Максимум NPV</li>
              <li>Максимум запасов</li>
            </ul>
          </div>
        </transition-expand>
      </div>
      <div
        class="rating-dropdown"
        :class="{ 'is-active': dropdownTitle === 'output' }"
      >
        <div class="rating-dropdown__header" @click="handleToggle('output')">
          <div class="rating-dropdown__title">Выработка</div>
          <div class="rating-dropdown__icon"></div>
        </div>
        <transition-expand duration="100">
          <div v-show="dropdownTitle === 'output'" class="rating-dropdown__body">
            <ul class="list">
              <li>0-25</li>
              <li>25-50</li>
              <li>50-75</li>
            </ul>
          </div>
        </transition-expand>
      </div>
      <button type="button" class="btn-button btn-button--thm-blue ol-w-100 mb-10px">
        Принять настройки
      </button>
      <button type="button" class="btn-button btn-button--thm-blue ol-w-100 mb-10px">
        Сохранить настройки
      </button>
    </div>
  </div>
</template>

<script>
import { TransitionExpand } from 'vue-transition-expand';

export default {
  name: "Settings",

  components: {
    TransitionExpand
  },

  data() {
    return {
      isOpen: false,
      dropdownTitle: 'field',
    }
  },

  methods: {
    handleToggle(title) {
      this.dropdownTitle = title;
    },
  }
}
</script>

<style lang="scss">
.rating-settings {
  color: #fff;
  display: flex;
}

.rating-panel {
  width: 100%;
  max-width: 24.4%;
}

.expand-enter-active, .expand-leave-active {
  -webkit-transition: height 0.3s ease-in-out, margin 0.3s ease-in-out, padding 0.3s ease-in-out;
  transition: height 0.3s ease-in-out, margin 0.3s ease-in-out, padding 0.3s ease-in-out;
  overflow: hidden;
}

.expand-enter, .expand-leave-to {
  height: 0;
  margin-top: 0 !important;
  margin-bottom: 0 !important;
  padding-top: 0 !important;
  padding-bottom: 0 !important
}
</style>
