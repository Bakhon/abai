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
          <span>{{ tab.title }}</span>
        </div>
      </template>
    </div>
    <keep-alive>
      <component :is="currentTabComponent"></component>
    </keep-alive>
  </div>
</template>

<script>
import Settings from 'components/Settings';

export default {
  name: 'DigitalRating',

  components: {
    Settings,
  },

  data() {
    return {
      tabs: [
        {
          title: 'Настройка карты',
          name: 'settings',
          icon: '/img/digital-rating/settings.svg',
        },
        {
          title: 'Карта секторов',
          name: 'sections',
          icon: '/img/digital-rating/sections.svg',
        },
        {
          title: 'Атлас скважины',
          name: 'atlas',
          icon: '/img/digital-rating/atlas.svg',
        },
        {
          title: 'Отчет по скважинам',
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
      console.log('tab', tab);
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
