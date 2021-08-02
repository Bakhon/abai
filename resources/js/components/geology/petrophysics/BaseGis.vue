<template>
  <div class="geology__content">
    <div class="rect mb-3">
      <div class="d-flex align-items-center">
        <Button @click="isShowListOfWellsModal = true" color="accent" icon="oilTower" class="flex-grow-1 mr-3"
                align="center">
          Список скважин
        </Button>
        <Button @click="isShowTableSettings = true" color="accent" icon="settPhone" class="flex-grow-1 mr-3" align="center">
          Настройка планшета
        </Button>
        <Button @click="isShowChooseStratModal = true" color="accent" icon="lupa" class="flex-grow-1 mr-3"
                align="center">
          Выбор отбивок
        </Button>
        <Button color="accent" icon="locPC" class="flex-grow-1 mr-3" align="center">
          Кросс-плот
        </Button>
        <Button color="accent" icon="gisto" class="flex-grow-1" align="center">
          Гистограмма
        </Button>
      </div>
    </div>
    <img class="mb-2" src="/images/geology/demo.graph.svg" alt="">
    <div class="d-flex">
      <ToolBlock class="mr-3">
        <template #header>
          <div class="d-flex align-items-center justify-content-between">
            <h5 class="mr-2">Значения</h5>
            <Button i-width="10" i-height="10" color="transparent" icon="rectArrow" size="small" />
          </div>
        </template>
        <img src="/images/geology/demo.map.svg" alt="">
      </ToolBlock>
      <div class="info__grid">
        <div class="info__grid__item" id="item1">
          <div class="rect">
            <dropdown block class="w-100 mb-2" :selected-value.sync="dropdownValue.value" button-text="Выбор ДЗО"
                      :options="[
              {label: 'option 1', value: 1},
              {label: 'option 2', value: 2},
              {label: 'option 3', value: 3}
            ]" />
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
              <Button i-width="10" i-height="10" color="transparent" icon="rectArrow" size="small" />
            </div>
            <div class="info-block__body">
              <div class="info-block__body__content">
                <img src="/images/geology/demo.table.svg" alt="">
              </div>
            </div>
          </div>
        </div>
        <div class="info__grid__item" id="item3">
          <ToolBlock>
            <template #header>
              <div class="d-flex align-items-center justify-content-between">
                <h5 class="mr-2">Окно сообщений</h5>
                <Button i-width="10" i-height="10" color="transparent" icon="rectArrow" size="small" />
              </div>
            </template>
            Дата, время, комментарий
          </ToolBlock>
        </div>
      </div>
    </div>

    <AwModal size="lg" title="Список скважин" :is-show.sync="isShowListOfWellsModal">
      <ListOfWells />
    </AwModal>

    <AwModal position="top" size="lg" title="Выбор отбивок" :is-show.sync="isShowChooseStratModal">
      <AwTree class="p-2"
              :selected.sync="chooseStratModalTree"
              :items="chooseStratModalTreeItems" />

      <template #footer>
        <div class="d-flex align-items-center justify-content-center">
          <Button class="mr-3">Ок</Button>
          <Button color="primary" @click="isShowChooseStratModal = false">Отмена</Button>
        </div>
      </template>
    </AwModal>

    <AwModal position="top" size="lg" title="Настройка планшета" :is-show.sync="isShowTableSettings">
      <TableSettings />
      <template #footer>
        <div class="d-flex align-items-center justify-content-center">
          <Button class="mr-3">Ок</Button>
          <Button color="primary" @click="isShowTableSettings = false">Отмена</Button>
        </div>
      </template>
    </AwModal>
  </div>
</template>

<script>
import Button from "../components/buttons/Button";
import dropdown from "../components/dropdowns/dropdown";
import ToolBlock from "../components/toolBlock/ToolBlock";
import AwModal from "../components/notifications/awModal/AwModal";
import AwTree from "../components/awTree/AwTree";
import AwIcon from "../components/icons/AwIcon"
import ListOfWells from "./modals/ListOfWells";
import TableSettings from "./modals/TableSettings";
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
    AwTree
  },
  data() {
    return {
      dropdownValue: {
        value: null
      },
      isShowTableSettings: false,
      isShowListOfWellsModal: false,
      isShowChooseStratModal: false,
      chooseStratModalTree: [],
      chooseStratModalTreeItems: {
        name: 'J-I-III.txt',
        value: 1,
        iconType: 'welltops',
        isOpen: true,
        children: [
          {
            name: 'Attributes',
            value: '1-1',
            iconType: 'ybs',
            children: [
              {
                name: 'name',
                iconType: 'u1'
              }
            ]
          },
          {
            name: 'Stratigraphy',
            iconType: 'zoneStatic',
            value: 2,
            children: [
              {
                name: 'U1_top',
                iconType: 'u1',
                value: "111",
              },
              {
                name: 'Zone U1_top',
                iconType: 'zone',
              },
              {
                name: 'U1_bot',
                iconType: 'u1',
                value: "1111",
              },
              {
                name: 'Zone U1_top',
                iconType: 'zone',
              },
            ]
          },
        ]
      },
    }
  },
}
</script>

<style lang="scss" scoped>

.info__grid {
  display: grid;
  width: 100%;
  grid-template-rows: 1fr 96px;
  grid-gap: 10px;
  grid-template-areas:
            "item1 item2"
            "item3 item3";

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

  &__body {
    &__content {
    }
  }
}
</style>
