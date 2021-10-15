<template>
  <div class="main-page">
    <div class="main-page__inner">
      <div class="main-page__logo">
        <img src="/img/icons/main_logo.svg" alt="" />
      </div>
      <div class="main-page__search">
        <input placeholder="Введите текст" type="text" v-model="query" />
        <button>
          <span>Поиск</span>
        </button>
      </div>
      <div class="blocks-holder d-flex justify-content-start w-100">
        <MainPageModuleBlock
          v-for="(block, index) in filteredBlocks"
          :key="index"
          :block="block"
        />
      </div>
    </div>
  </div>
</template>

<script>
import MainPageModuleBlock from "./MainPageModuleBlock";

export default {
  name: "main-page",
  components: {
    MainPageModuleBlock,
  },
  data() {
    return {
      query: "",
      blocks: [
        {
          name: "База данных",
          icon: "bigdata.svg",
          url: this.localeUrl("/bigdata"),
          children: [
            {
              name: "Формы ввода",
              icon: "wells.svg",
              url: this.localeUrl("/bigdata/wells"),
            },
            {
              name: "Регистрация скважины",
              icon: "wells_create.svg",
              url: this.localeUrl("/bigdata/wells/create"),
            },
            {
              name: "Карточка скважины",
              icon: "well_card.svg",
              url: this.localeUrl("/bigdata/well-card"),
            },
          ],
        },
        {
          name: "Центр визуализации",
          icon: "visual_center.svg",

          url: this.localeUrl("/visualcenter3"),
        },
        {
          name: "Технологический режим",
          icon: "tr.svg",
          url: this.localeUrl("/tr"),
        },
        {
          name: "Подбор ГНО",
          icon: "podborgno.svg",
          url: this.localeUrl("/podborgno"),
        },
        {
          name: "Мониторинг осложнений",
          icon: "monitor.svg",
          url: this.localeUrl("/monitor"),
        },
        {
          name: "Подбор и АЭГТМ",
          icon: "paegtm.svg",
          url: this.localeUrl("/paegtm"),
        },
        {
          name: this.trans("economic_reference.economic_module_short"),
          icon: "nrs.svg",
          url: this.localeUrl("/economic/nrs"),
        },
        {
          name: "Цифровое бурение",
          icon: "digital-drilling.svg",

          url: this.localeUrl("/digital-drilling/"),
        },
        {
          name: this.trans("economy_pf.economy"),
          icon: "economy-kenje.svg",
          url: this.localeUrl("/module_economy/proactive-factors/"),
        },
        {
          name: this.trans("plast_fluids.pf"),
          icon: "plastFluidsMain.svg",
          url: this.localeUrl("/pf"),
        },
      ],
    };
  },
  computed: {
    filteredBlocks() {
      if (this.query.length > 0) {
        return this.blocks.filter((block) => {
          return (
            block.name.toLowerCase().indexOf(this.query.toLowerCase()) > -1
          );
        });
      }
      return this.blocks;
    },
  },
};
</script>
<style lang="scss" scoped>
.blocks-holder {
  flex-wrap: wrap;
}

.blocks-holder > div {
  margin-right: 60px;
}

.blocks-holder > div:nth-of-type(9n) {
  margin-right: 0;
}

.toggle-btn {
  display: block;
  margin-top: -18px;
}

.inverted {
  transform: rotate(-180deg);
}
</style>
