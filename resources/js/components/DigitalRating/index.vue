<template>
  <div class="digital-rating">
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
import Settings from './components/Settings';
import Sections from './components/Sections';
import Atlas from './components/Atlas';
import Reports from './components/Reports';

export default {
  name: 'DigitalRating',

  components: {
    Settings,
    Sections,
    Atlas,
    Reports,
  },

  data() {
    return {
      tabs: [
        {
          title: 'digital_rating.mapSetup',
          name: 'settings',
          icon: '/img/digital-rating/settings.svg',
        },
        {
          title: 'digital_rating.sectorMap',
          name: 'sections',
          icon: '/img/digital-rating/sections.svg',
        },
        {
          title: 'digital_rating.wellAtlas',
          name: 'atlas',
          icon: '/img/digital-rating/atlas.svg',
        },
        {
          title: 'digital_rating.wellsReport',
          name: 'reports',
          icon: '/img/digital-rating/reports.svg',
        }
      ],
      currentTab: 'settings',
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
<style lang="scss" scoped>

</style>
