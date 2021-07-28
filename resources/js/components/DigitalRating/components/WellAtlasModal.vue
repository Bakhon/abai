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
        <keep-alive>
          <component :is="currentTabComponent"></component>
        </keep-alive>
      </div>
    </div>
  </modal>
</template>

<script>
import Overview from './Overview';
import Maps from './Maps';
import Scheme from "./Scheme";
import Indicators from "./Indicators";

export default {
  name: "WellAtlasModal",

  components: {
    Overview,
    Maps,
    Scheme,
    Indicators,
  },

  data() {
    return {
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
}
</style>
