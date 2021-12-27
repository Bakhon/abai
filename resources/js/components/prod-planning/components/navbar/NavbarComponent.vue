<template>
  <div class="main-block-nav">
    <div class="block-nav">
      <div class="nav-item pr-2"  @click="goToThisPage('main')" :class="{'active': currentPath === 'mon-plan-fact'}">
        <div class="nav-icon pl-2 pt-2">
          <img src="/img/prod-planning/icons/mon-plan-fact.svg" alt="">
        </div>
        <div class="nav-title pl-2 pt-2">
          {{ this.trans("prod-plan.plan-fact-monitoring") }}
        </div>
      </div>
      <div class="nav-item pr-2" @click="goToThisPage('base-prod')" :class="{'active': currentPath === 'base-prod-forecast'}">
        <div class="nav-icon pl-2 pt-2">
          <img src="/img/prod-planning/icons/forecast.svg" alt="">
        </div>
        <div class="nav-title pl-2 pt-2">
          {{ this.trans("prod-plan.base-production-forecast") }}
        </div>
      </div>
      <div class="nav-item pr-2" @click="goToThisPage('bus-plan')" :class="{'active': currentPath === 'bus-plan'}">
        <div class="nav-icon pl-2 pt-2">
          <img src="/img/prod-planning/icons/bus-plan.svg" alt="">
        </div>
        <div class="nav-title pl-2 pt-2">
          {{ this.trans("prod-plan.business-planning") }}
        </div>
      </div>
      <div class="nav-item pr-2" @click="goToThisPage('long-term-program')" :class="{'active': currentPath === 'long-term-program'}">
        <div class="nav-icon pl-2 pt-2">
          <img src="/img/prod-planning/icons/program.svg" alt="">
        </div>
        <div class="nav-title pl-2 pt-2">
          {{ this.trans("prod-plan.long-term-program") }}
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data: function () {
    return {
    }
  },
  computed: {
    currentPath() {
      let url = document.URL
      return url.substring(url.lastIndexOf("/") + 1, url.length)
    }
  },
  methods: {
    goToThisPage(link) {
      let last
      let url = document.URL
      let currentURL = url.substring(url.lastIndexOf("/") + 1, url.length);
      if(link === 'main') {
        last = 'mon-plan-fact'
      } else if(link === 'base-prod') {
        last = 'base-prod-forecast'
      } else if(link === 'bus-plan') {
        last = 'bus-plan'
      } else if(link === 'long-term-program') {
        last = 'long-term-program'
      }
      window.location.href = window.location.href.replace(`${currentURL}`, last)
    }
  },

}
</script>
