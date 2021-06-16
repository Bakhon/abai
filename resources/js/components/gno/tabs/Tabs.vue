<template>
  <div>
      <ul class="nav nav-tabs">
          <li class="nav-item">
              <a class="nav-link active" @click="selectTab(1)" href="#">{{trans('pgno.shgn')}}</a>
          </li>
          <li class="nav-item">
              <a class="nav-link disabled" @click="selectTab(2)" href="#">{{trans('pgno.ecn')}}</a>
          </li>
          <li class="nav-item">
              <a class="nav-link disabled" @click="selectTab(3)" href="#">{{trans('pgno.fon')}}</a>
          </li>
          <li class="nav-item">
              <a class="nav-link disabled" @click="selectTab(4)" href="#">{{trans('pgno.develop')}}</a>
          </li>
          <li class="nav-item">
              <a class="nav-link disabled" @click="selectTab(5)" href="#">{{trans('pgno.economic')}}</a>
          </li>
      </ul>

    <div v-if="currentTab == 1">
        <shgn @on-submit-params="onPushParams()"></shgn>
    </div>

    <div v-if="currentTab == 2">
        <ecn></ecn>
    </div>

    <div v-if="currentTab == 3">
        <fon></fon>
    </div>

    <div v-if="currentTab == 4">
        <develop></develop>
    </div>

    <div v-if="currentTab == 5">
        <economic></economic>
    </div>

  </div>
</template>

<script>
import Economic from './components/Economic.vue'
import Shgn from './components/Shgn.vue'
import Ecn from './components/Ecn.vue'
import Develop from './components/Develop.vue'
import Fon from './components/Fon.vue'
export default {
    components: { Shgn, Ecn, Fon, Develop, Economic },
    props: {
        value: String
    },
    data: function() {
        return {
            currentTab: 1,
            hover: false
        }
    },
    methods: {
        selectTab(selectedTab) {
            this.currentTab = selectedTab
        },
        onPushParams() {
            this.$emit('onPushParams')
        }
    }
}
</script>

<style scoped>
.nav-link {
    color: white;
    outline: none !important;
}

.tab__content {
    color: white;
}

.nav-link.active {
    color: white;
    background-color: transparent;
    border-color: #dee2e6 #dee2e6 white;
}

</style>