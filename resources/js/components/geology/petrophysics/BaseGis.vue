<template>
  <div class="geology__content">
    <div class="rect mb-3">
      <div class="d-flex align-items-center">
        <Button @click="isShowListOfWellsModal = true" color="accent" icon="oilTower" class="flex-grow-1 mr-3"
                align="center">
          Список скважин
        </Button>
        <Button @click="isShowTableSettings = true" color="accent" icon="settPhone" class="flex-grow-1 mr-3"
                align="center">
          Настройка планшета
        </Button>
        <Button @click="isShowChooseStratModal = true" color="accent" icon="lupa" class="flex-grow-1 mr-3"
                align="center">
          Выбор отбивок
        </Button>
        <Button @click="isShowCrossPlot = true" color="accent" icon="locPC" class="flex-grow-1 mr-3" align="center">
          Кросс-плот
        </Button>
        <Button color="accent" icon="gisto" class="flex-grow-1" align="center">
          Гистограмма
        </Button>
      </div>
    </div>
    <div class="main_graph mb-2">
      <component v-bind="getGraphComponents[0]" :is="getGraphComponents[0].is" />
    </div>
    <div class="d-flex">
      <ToolBlock class="mr-3">
        <template #header>
          <div class="d-flex align-items-center justify-content-between">
            <h5 class="mr-2">Значения</h5>
            <Button @click="activeGraph = getGraphComponents[1].id" i-width="10" i-height="10" color="transparent"
                    icon="rectArrow" size="small" />
          </div>
        </template>
        <div class="secondary__graph">
          <component v-bind="getGraphComponents[1]" :is="getGraphComponents[1].is" />
        </div>
      </ToolBlock>
      <div class="info__grid">
        <div class="info__grid__item" id="item1">
          <div class="rect">
            <dropdown
                block
                class="w-100 mb-2"
                :selected-value.sync="dropdownValue.value"
                button-text="Выбор ДЗО"
                :options="[
								{ label: 'option 1', value: 1 },
								{ label: 'option 2', value: 2 },
								{ label: 'option 3', value: 3 },
							]"
            />
            <Button class="geology-l-side__toggle w-100 mb-2" color="accent">
              Выбор месторождения
            </Button>
            <Button class="geology-l-side__toggle w-100 mb-2" color="accent">
              Выбор горизонта
            </Button>
            <Button class="geology-l-side__toggle w-100 mb-2" color="accent">
              Выбор карты
            </Button>
            <Button class="geology-l-side__toggle w-100 mb-2" color="accent">
              Выбор скважин
            </Button>
            <Button class="geology-l-side__toggle w-100 mb-2" color="accent">
              Выбор отбивок
            </Button>
          </div>
        </div>
        <div class="info__grid__item" id="item2">
          <div class="info-block">
            <div class="info-block__header">
              <h5>Данные по скважине</h5>
            </div>
            <div class="info-block__body">
              <div class="info-block__body__content">
                <img src="/images/geology/demo.table.svg" alt="" />
              </div>
            </div>
          </div>
        </div>
        <div class="info__grid__item" id="item3">
          <ToolBlock>
            <template #header>
              <div class="d-flex align-items-center justify-content-between">
                <h5 class="mr-2">Окно сообщений</h5>
              </div>
            </template>
            Дата, время, комментарий
          </ToolBlock>
        </div>
      </div>
    </div>

    <AwModal is-confirm size="lg" title="Список скважин" :is-show.sync="isShowListOfWellsModal">
      <ListOfWells />
    </AwModal>

    <AwModal is-confirm position="top" size="lg" title="Выбор отбивок" :is-show.sync="isShowChooseStratModal">
      <AwTree class="p-2" :selected.sync="chooseStratModalTree" :items="chooseStratModalTreeItems" />
    </AwModal>

    <AwModal @cancel="cancelTableSettings" @save="saveTableSettings" is-confirm position="top" size="lg"
             title="Настройка планшета" :is-show.sync="isShowTableSettings">
      <TableSettings ref="tableSettings" />
    </AwModal>

    <AwModal is-confirm position="top" size="xl" title="Кросс-плот" :is-show.sync="isShowCrossPlot">
      <CrossPlot />
    </AwModal>
  </div>
</template>

<script>
import {globalloadingMutations} from "@store/helpers";
import {geologyState} from "../../../store/helpers";
import {
  FETCH_WELLS_CURVES,
  SET_GIS_DATA,
  SET_SELECTED_WELL_CURVES_FORCE
} from "../../../store/modules/geologyGis.const";

import Button from "../components/buttons/Button";
import dropdown from "../components/dropdowns/dropdown";
import ToolBlock from "../components/toolBlock/ToolBlock";
import AwModal from "../components/notifications/awModal/AwModal";
import AwTree from "../components/awTree/AwTree";
import AwIcon from "../components/icons/AwIcon";
import ListOfWells from "./modals/ListOfWells";
import TableSettings from "./modals/TableSettings";
import CrossPlot from "./modals/CrossPlot";
import graph2 from "./graphics/graph2";
import curve from "../demo_json/curve.json";
import AwGis from "./graphics/awGis/AwGis";

export default {
  name: "Geology-Page",
  components: {
    Button,
    dropdown,
    ToolBlock,
    AwModal,
    AwIcon,
    ListOfWells,
    TableSettings,
    CrossPlot,
    AwTree,
  },
  data() {
    return {
      activeGraph: "GisGraph",
      graphComponents: [
        {
          id: "canvasWrapper",
          is: AwGis,
          graphData: curve,
        },
        {
          id: 2,
          is: graph2,
        },
      ],
      dropdownValue: {
        value: null,
      },
      selectedGisCurvesOld: [],
      isShowTableSettings: false,
      isShowCrossPlot: false,
      isShowListOfWellsModal: false,
      isShowChooseStratModal: false,
      chooseStratModalTree: [],
      chooseStratModalTreeItems: {
        name: "J-I-III.txt",
        value: 1,
        iconType: "welltops",
        isOpen: true,
        children: [
          {
            name: "Attributes",
            value: "1-1",
            iconType: "ybs",
            children: [
              {
                name: "name",
                iconType: "u1",
              },
            ],
          },
          {
            name: "Stratigraphy",
            iconType: "zoneStatic",
            value: 2,
            children: [
              {
                name: "U1_top",
                iconType: "u1",
                value: "111",
              },
              {
                name: "Zone U1_top",
                iconType: "zone",
              },
              {
                name: "U1_bot",
                iconType: "u1",
                value: "1111",
              },
              {
                name: "Zone U1_top",
                iconType: "zone",
              },
            ],
          },
        ],
      },
    };
  },
  computed: {
    getGraphComponents() {
      return this.graphComponents.sort((e) => (e.id === this.activeGraph ? -1 : 1));
    },
    ...geologyState(["isOpenedRightSide", "isOpenedLeftSide"]),
  },
  watch: {
    isShowTableSettings(val) {
      if (val) {
        this.selectedGisCurvesOld = [...this.$store.state.geologyGis.selectedGisCurves];
        this.$store.state.geologyGis.awGis.save();
      }
    },
  },
  async mounted() {
    this.SET_LOADING(false);
  },
  methods: {
    async saveTableSettings() {
      this.SET_LOADING(true);
      const awGisData = this.$store.state.geologyGis.awGis.getElementsWithData();
      const {
        CURVES_OF_SELECTED_WELLS: loadedCurves,
        selectedGisCurves: awGisSelectedCurves,
        gisWells: awGisSelectedWells
      } = this.$store.state.geologyGis;

      let selectedCurves = awGisSelectedCurves.reduce((acc, element) => {
        let findElement = awGisData.find(({data}) => (element === data.name && awGisSelectedWells.find((w) => data.wellID.includes(w.name))));
        let curves = Object.values(findElement.data.curve_id);
        let hasCurve = curves.find((item) => Object.keys(loadedCurves).includes(item.toString()));
        if (!hasCurve) acc.push(...curves)
        return acc;
      }, []);
      await this.$store.dispatch(FETCH_WELLS_CURVES, selectedCurves);
      this.SET_LOADING(false);
    },

    cancelTableSettings() {
      this.$store.state.geologyGis.awGis.reset();
      this.$store.commit(SET_SELECTED_WELL_CURVES_FORCE, [...this.selectedGisCurvesOld]);
      this.$store.commit(SET_GIS_DATA);
    },
    ...globalloadingMutations(["SET_LOADING"]),
  },
};
</script>

<style lang="scss" scoped>
.info__grid {
  display: grid;
  width: 100%;
  grid-template-rows: 1fr 96px;
  grid-gap: 10px;
  grid-template-areas: "item1 item2" "item3 item3";

  #item1 {
    grid-area: item1;

    &::v-deep {
      .a-dropdown__trigger {
        background: var(--a-accent);
        border-color: var(--a-accent);
      }
    }
  }

  #item2 {
    grid-area: item2;
    width: 348px;
  }

  #item3 {
    grid-area: item3;
    color: #fff;

    &::v-deep {
      .tool-block__body__content {
        padding: 10px 18px;
        height: 60px;
      }
    }
  }
}

.info-block {
  color: #ffffff;

  &__header {
    font-size: 16px;
    display: flex;
    align-items: center;
    background: var(--a-accent-darken-100);
    padding: 10px 14px;
    justify-content: space-between;

    h5 {
      margin: 0;
    }
  }
}

//!TODO Поменять стили после создания графиков
.main_graph {
  max-height: 560px;
  width: 100%;
  overflow: hidden;

  img {
    display: block;
    height: 100%;
    width: 100%;
    object-fit: cover;
  }
}

//!TODO Поменять стили после создания графиков
.secondary__graph {
  width: 560px;
  overflow: hidden;

  img {
    display: block;
    width: 100%;
    height: 100%;
  }
}
</style>
