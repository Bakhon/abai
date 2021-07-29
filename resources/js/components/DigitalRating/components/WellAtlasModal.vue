<template>
  <modal
    class="modal-bign-wrapper"
    name="modalAtlas"
    :draggable="false"
    :width="1000"
    :height="800"
    :adaptive="true">
    <div class="modal-bign-container">
      <div class="modal-bign-header justify-content-end">
        <button type="button" class="modal-bign-button" @click="$emit('close')">
          {{ trans('pgno.zakrit') }}
        </button>
      </div>
      <div class="rating-tabs">
        <template v-for="(tab, tabIdx) in tabs">
          <div
            :key="tabIdx"
            class="rating-tabs__item"
            :class="{
              'is-active': tab.name === currentTab
            }"
            @click="handleSelectTab(tab.name)"
          >
            <span>{{ trans(tab.title) }}</span>
          </div>
        </template>
      </div>
      <div class="content">
        <div class="sector-form">
          <div class="sector-form__label">
            {{ trans('digital_rating.sectorNumber') }}
          </div>
          <input
            type="text"
            class="sector-form__input"
            v-model="sectorNumber"
          />
        </div>
        <keep-alive>
          <component :is="currentTabComponent"></component>
        </keep-alive>
        <div class="modal__footer mb-10px">
          <button type="button" class="btn-button btn-button--thm-blue mr-20px minw-200">
            {{ trans('digital_rating.markCandidate') }}
          </button>
          <button type="button" class="btn-button btn-button--thm-green minw-200">
            {{ trans('digital_rating.agreeCandidate') }}
          </button>
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
import Overview from './Overview';
import Maps from './Maps';
import Scheme from "./Scheme";
import Indicators from "./Indicators";
import History from "./History";

export default {
  name: "WellAtlasModal",

  components: {
    Overview,
    Maps,
    Scheme,
    Indicators,
    History,
  },

  data() {
    return {
      sectorNumber: '7777',
      currentTab: 'overview',
      tabs: [
        {
          title: 'digital_rating.overview',
          name: 'overview'
        },
        {
          title: 'digital_rating.developmentMaps',
          name: 'maps'
        },
        {
          title: 'digital_rating.correlationScheme',
          name: 'scheme'
        },
        {
          title: 'digital_rating.environmentIndicators',
          name: 'indicators'
        },
        {
          title: 'digital_rating.matchingHistory',
          name: 'history'
        }
      ],
    }
  },

  computed: {
    currentTabComponent() {
      return this.currentTab.toLowerCase();
    }
  },

  methods: {
    handleSelectTab(tab) {
      this.currentTab = tab;
    }
  }
}
</script>

<style scoped lang="scss">
.content {
  background: #363B68;
  border: 1px solid #545580;
  padding: 10px;
  border-top: none;
  overflow: auto;
  height: calc(100% - 75px);
}
.sector-form {
  display: flex;
  align-items: center;
  font-size: 16px;
  margin: 10px 0 20px 0;

  &__label {
    padding: 5px 30px;
    background: #323370;
  }

  &__input {
    background: #1F2142;
    border: none;
    outline: none;
    padding: 5px 10px;
    color: #fff;
  }
}
</style>
