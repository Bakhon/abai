<template>
  <div>
    <gtm-main-menu
        :parentType="this.parentType"
        :mainMenu="menu"
        @menuClick="menuClick"
    />
    <div class="rating-report">
      <div class="rating-report__title">
        {{ trans('digital_rating.wellsReport') }}
        <img src="/img/icons/link.svg" alt="">
      </div>
      <table class="table text-center text-white rating-table">
        <thead>
          <tr>
            <th class="align-middle" v-for="col in cols" :key="col">
              {{ trans(col) }}
            </th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
      <button class="btn-button btn-button--thm-blue minw-400 mb-10px d-block m-auto">
        {{ trans('app.download') }}
      </button>
    </div>
  </div>
</template>

<script>
import mainMenu from "../GTM/mock-data/main_menu.json";

export default {
  name: "DigitalRatingReport",

  data() {
    return {
      parentType: '',
      menu: mainMenu,
    }
  },

  computed: {
    cols() {
      return [
        'digital_rating.number',
        'digital_rating.wellNumber',
        'X',
        'Y',
        'digital_rating.horizon',
        'digital_rating.liquidFlowRate',
        'digital_rating.waterCut',
        'digital_rating.oilFlowRate',
        'PI',
      ]
    },
  },

  methods: {
    menuClick(data) {
      const path = window.location.pathname.slice(3);
      if (data?.url && data.url !== path) {
        window.location.href = this.localeUrl(data.url);
      }
    }
  }
}
</script>

<style scoped lang="scss">
.rating-report {
  width: 100%;
  background-color: #272953;
  padding: 10px;
  color: #fff;
  margin-top: 3rem;
}
.rating-report__title {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 10px;
}
</style>
