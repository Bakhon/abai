<template>
  <div class="data-analysis-tab">
    <div class="data-analysis-tab__item">
      Давление и температура
    </div>
    <div class="data-analysis-tab__item active">
      <div class="data-analysis-dropdown" :class="{ 'is-active': isOpen }">
        <div class="data-analysis-dropdown__header" @click="handleToggle">
          <div class="data-analysis-dropdown__title">
            Анализ проб пластовой нефти
          </div>
          <div class="data-analysis-dropdown__icon" />
        </div>
        <div v-show="isOpen" class="data-analysis-dropdown__body">
          <ul class="list">
            <li
              v-for="(item, index) in fields"
              :key="index"
              @click="openLeftDrop(index)"
            >
              <img :src="'/img/PlastFluids/' + item.img" alt="" />
              <div>{{ item.name }}</div>
              <div v-show="isOpenLeft == index" class="drop-left">
                <ul class="list">
                  <li
                    v-for="(item, index) in leftFields"
                    :key="index"
                    @click="clickLeftDrop(item)"
                  >
                    <img :src="'/img/PlastFluids/' + item.img" alt="" />
                    <div>{{ item.name }}</div>
                  </li>
                </ul>
              </div>
            </li>
          </ul>
        </div>
      </div>

      <!--Анализ проб пластовой нефти-->
      <!--<img src="/img/PlastFluids/row_bottom.svg" alt="">-->
    </div>
    <div class="data-analysis-tab__item">
      Утвержденные параметры
    </div>
  </div>
</template>

<script>
export default {
  name: "DataAnalysisTab",
  components: {},
  data() {
    return {
      fields: [
        {
          name: "Нефть",
          img: "Oil.svg",
        },
        {
          name: "Газоконденсат",
          img: "GasCondensate.svg",
        },
      ],
      leftFields: [
        {
          name: "Изученность",
          img: "Oil.svg",
          component: {
            name: "main-table",
            template: "<data-analysis-study></data-analysis-study>",
          },
          leftPanel: {
            name: "main-table",
            template: "<data-analysis-study-panel></data-analysis-study-panel>",
          },
        },
        {
          name: "Карты и таблицы",
          img: "Oil.svg",
          component: {
            name: "main-table",
            template:
              "<data-analysis-property-map img='/img/PlastFluids/mapTable.svg'></data-analysis-property-map>",
          },
          leftPanel: {
            name: "main-table",
            template:
              "<data-analysis-map-table-panel></data-analysis-map-table-panel>",
          },
        },
        {
          name: "Карта свойств",
          img: "Oil.svg",
          component: {
            name: "main-table",
            template:
              "<data-analysis-property-map img='/img/PlastFluids/mapProperty.svg'></data-analysis-property-map>",
          },
          leftPanel: {
            name: "main-table",
            template: "<data-analysis-panel></data-analysis-panel>",
          },
        },
        {
          name: "Графики и таблицы",
          img: "Oil.svg",
          component: {
            name: "main-table",
            template:
              "<data-analysis-custom-charts></data-analysis-custom-charts>",
          },
          leftPanel: {
            name: "main-table",
            template:
              "<data-analysis-custom-charts-panel></data-analysis-custom-charts-panel>",
          },
        },
        {
          name: "Пользовательские графики ",
          img: "Oil.svg",
        },
        {
          name: "Состав жидкости",
          img: "Oil.svg",
          component: {
            name: "main-table",
            template:
              "<data-analysis-fluid-composition></data-analysis-fluid-composition>",
          },
          leftPanel: {
            name: "main-table",
            template:
              "<data-analysis-fluid-composition-panel></data-analysis-fluid-composition-panel>",
          },
        },
        {
          name: "Состав газа",
          img: "Oil.svg",
          component: {
            name: "main-table",
            template:
              "<data-analysis-gas-composition></data-analysis-gas-composition>",
          },
          leftPanel: {
            name: "main-table",
            template:
              "<data-analysis-gas-composition-panel></data-analysis-gas-composition-panel>",
          },
        },
        {
          name: "Газоконденсатные исследования",
          img: "Oil.svg",
        },
      ],
      isOpen: false,
      isOpenLeft: null,
    };
  },
  methods: {
    handleToggle() {
      this.isOpenLeft = null;
      this.isOpen = !this.isOpen;
    },
    openLeftDrop(i) {
      this.isOpenLeft = i;
    },
    clickLeftDrop(component) {
      this.isOpen = false;
      this.isOpenLeft = null;
      this.$emit("changePage", component);
    },
  },
};
</script>

<style scoped lang="scss">
.data-analysis-tab {
  display: flex;
  justify-content: space-between;
  background: #272953;
  padding: 8px;
  margin-bottom: 10px;
  position: relative;
  z-index: 20;

  &__item {
    width: 33%;
    background: #333975;
    font-size: 16px;
    padding: 5px;
    border-radius: 5px;
    text-align: center;
    position: relative;
    height: 30px;
    &.active {
      background: #2e50e9;
    }
  }
}
.data-analysis-dropdown {
  position: relative;
  &__icon {
    display: block;
    position: absolute;
    top: 0;
    right: 1.25rem;
    bottom: 0;
    margin: auto;
    width: 8px;
    height: 8px;
    border-right: 2px solid #fff;
    border-bottom: 2px solid #fff;
    transform: translateY(-2px) rotate(45deg);
    transition: transform 0.2s ease;
  }

  &.is-active {
    .data-analysis-dropdown__header {
    }
    .data-analysis-dropdown__icon {
      transform: translateY(2px) rotate(225deg);
    }
  }

  &__header {
    position: relative;
    /*padding: 8px 10px;*/
    background: transparent;
    cursor: pointer;
  }

  &__body {
    position: absolute;
    top: 38px;
    left: -7px;
    width: 104%;
    background: #333975;
    box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.25);
    height: auto;

    .list {
      list-style: none;
      margin-bottom: 0;

      li {
        padding: 15px 6px;
        cursor: pointer;
        border-bottom: 0.2646px solid #454d7d;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        &:hover {
          background-color: #2e50e9;
        }
        img {
          margin-right: 7px;
        }
        .drop-left {
          left: calc(100% + 6px);
          top: 0;
          width: 370px;
          background: #333975;
          position: absolute;

          .list {
            list-style: none;
            margin-bottom: 0;

            li {
              padding: 10px 15px;
              cursor: pointer;
              border-bottom: 0.2646px solid #454d7d;
              display: flex;
              align-items: center;
              justify-content: flex-start;
              position: relative;
            }
            img {
              margin-right: 7px;
            }
          }
        }
      }
    }
  }
}

.expand-enter-active,
.expand-leave-active {
  -webkit-transition: height 0.3s ease-in-out, margin 0.3s ease-in-out,
    padding 0.3s ease-in-out;
  transition: height 0.3s ease-in-out, margin 0.3s ease-in-out,
    padding 0.3s ease-in-out;
  overflow: hidden;
}

.expand-enter,
.expand-leave-to {
  height: 0;
  margin-top: 0 !important;
  margin-bottom: 0 !important;
  padding-top: 0 !important;
  padding-bottom: 0 !important;
}
</style>
