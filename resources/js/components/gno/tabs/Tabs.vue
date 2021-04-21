<template>
  <div>
      <ul class="nav nav-tabs">
          <li class="nav-item">
              <a class="nav-link" @click="selectTab(1)" href="#">ШГН</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" @click="selectTab(2)" href="#">ЭЦН</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" @click="selectTab(3)" href="#">ФОН</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" @click="selectTab(4)" href="#">Разработка</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" @click="selectTab(5)" href="#">Экономика</a>
          </li>
      </ul>

    <div v-if="currentTab == 1">
        <h2>ШГН</h2>
    </div>

    <div v-if="currentTab == 2">
        <h2>ЭЦН</h2>
    </div>

    <div v-if="currentTab == 3">
        <h2>ФОН</h2>
    </div>

    <div v-if="currentTab == 4">
        <h2>Разработка</h2>
    </div>

    <div v-if="currentTab == 5">
        <h2>Экономика</h2>
    </div>

  </div>
</template>

<script>
export default {
    props: {
        value: String
    },
    data: function() {
        return {
            currentTab: 1
        }
    },
    methods: {
        selectTab(selectedTab) {
            this.currentTab = selectedTab
        }
    }
}
</script>

<style>
.nav-link {
    color: white;
    outline: none !important;
}

.tab__content {
    color: white;
}
</style>