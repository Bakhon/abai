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
<style scoped lang="scss">
.rating-tabs {
  display: flex;
  align-items: center;
  justify-content: space-evenly;
  margin-bottom: 10px;
}

.rating-tabs__item {
  background-color: #333975;
  color: #fff;
  padding: 13px 20px;
  width: 100%;
  margin-right: 10px;
  border-radius: 4px;
  display: flex;
  align-items: center;

  &:last-child {
    margin-right: 0;
  }

  &:hover, &:focus {
    cursor: pointer;
  }

  &.is-active {
    background-color: #2E50E9;
  }

  img {
    margin-right: 10px;
  }

  span {
    font-size: 16px;
  }
}
</style>
