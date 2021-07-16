<template>
  <div>
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
          <img :src="tab.icon" alt="">
          <span>{{ trans(tab.title) }}</span>
        </div>
      </template>
    </div>
    <keep-alive>
      <component v-bind:is="currentTabComponent"></component>
    </keep-alive>
  </div>
</template>

<script>
import Maps from './Maps';
import Indicators from "./Indicators";
import Scheme from "./Scheme";

export default {
  name: "Atlas",

  components: {
    Maps,
    Indicators,
    Scheme,
  },

  data() {
    return {
      tabs: [
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
        }
      ],
      currentTab: 'maps',
    };
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

<style scoped>

</style>
