<template>
  <div class="rating-settings">
    <div class="rating-content">
      <div class="rating-content__title">
        <div>{{ trans('digital_rating.diagram') }}</div>
        <img src="/img/icons/link.svg" alt="">
      </div>
      <div class="rating-content__wrapper">
        <el-divider direction="vertical"></el-divider>
        <el-divider direction="vertical"></el-divider>
        <el-divider direction="vertical"></el-divider>
      </div>
      <button type="button" class="btn-button btn-button--thm-green w-100 mb-10px">
        {{ trans('digital_rating.buildMap') }}
      </button>
    </div>
    <div class="rating-panel">
      <div
        class="rating-dropdown"
        :class="{ 'is-active': dropdownTitle === 'field' }"
      >
        <div class="rating-dropdown__header" @click="handleToggle('field')">
          <div class="rating-dropdown__title">{{ trans('digital_rating.field') }}</div>
          <div class="rating-dropdown__icon"></div>
        </div>
        <transition-expand duration="100">
          <div v-show="dropdownTitle === 'field'" class="rating-dropdown__body">
            <ul class="list">
              <li v-for="(field, index) in fields" :key="index">
                {{ field.title }}
              </li>
            </ul>
          </div>
        </transition-expand>
      </div>
      <div
        class="rating-dropdown"
        :class="{ 'is-active': dropdownTitle === 'sector' }"
      >
        <div class="rating-dropdown__header" @click="handleToggle('sector')">
          <div class="rating-dropdown__title">{{ trans('digital_rating.sectorSize') }}</div>
          <div class="rating-dropdown__icon"></div>
        </div>
        <transition-expand duration="100">
          <div v-show="dropdownTitle === 'sector'" class="rating-dropdown__body">
            <ul class="list">
              <li v-for="(sector, index) in sectors" :key="index">
                {{ sector.title }}
              </li>
            </ul>
          </div>
        </transition-expand>
      </div>
      <div
        class="rating-dropdown"
        :class="{ 'is-active': dropdownTitle === 'fund' }"
      >
        <div class="rating-dropdown__header" @click="handleToggle('fund')">
          <div class="rating-dropdown__title">{{ trans('digital_rating.fund') }}</div>
          <div class="rating-dropdown__icon"></div>
        </div>
        <transition-expand duration="100">
          <div v-show="dropdownTitle === 'fund'" class="rating-dropdown__body">
            <ul class="list">
              <li v-for="(fund, index) in funds" :key="index">
                {{ fund.title }}
              </li>
            </ul>
          </div>
        </transition-expand>
      </div>
      <div
        class="rating-dropdown"
        :class="{ 'is-active': dropdownTitle === 'ranking' }"
      >
        <div class="rating-dropdown__header" @click="handleToggle('ranking')">
          <div class="rating-dropdown__title">{{ trans('digital_rating.rankingScript') }}</div>
          <div class="rating-dropdown__icon"></div>
        </div>
        <transition-expand duration="100">
          <div v-show="dropdownTitle === 'ranking'" class="rating-dropdown__body">
            <ul class="list">
              <li v-for="(ranking, index) in rankings" :key="index">
                {{ ranking.title }}
              </li>
            </ul>
          </div>
        </transition-expand>
      </div>
      <div
        class="rating-dropdown"
        :class="{ 'is-active': dropdownTitle === 'output' }"
      >
        <div class="rating-dropdown__header" @click="handleToggle('output')">
          <div class="rating-dropdown__title">{{ trans('digital_rating.output') }}</div>
          <div class="rating-dropdown__icon"></div>
        </div>
        <transition-expand duration="100">
          <div v-show="dropdownTitle === 'output'" class="rating-dropdown__body">
            <ul class="list">
              <li v-for="(output, index) in outputs" :key="index">
                {{ output.title }}
              </li>
            </ul>
          </div>
        </transition-expand>
      </div>
      <button type="button" class="btn-button btn-button--thm-blue w-100 mb-10px">
        {{ trans('digital_rating.acceptSettings') }}
      </button>
      <button type="button" class="btn-button btn-button--thm-blue w-100 mb-10px">
        {{ trans('digital_rating.saveSettings') }}
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
      fields: [
        { title: 'Месторождение 1' },
        { title: 'Месторождение 2' },
      ],
      sectors: [
        { title: '100x100' },
        { title: '150x150' }
      ],
      funds: [
        { title: 'Действующий' },
        { title: 'Контрольный' },
      ],
      rankings: [
        { title: 'Максимум NPV' },
        { title: 'Максимум запасов' }
      ],
      outputs: [
        { title: '0-25' },
        { title: '25-50' },
        { title: '50-75' }
      ],
    }
  },

  methods: {
    handleToggle(title) {
      this.dropdownTitle = title;
    },
  }
}
</script>

<style lang="scss" scoped>
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
