<template>
  <PageSide>
    <template #top>
      <dropdown block class="w-100 mb-2" @selected="selectedDropDown($event, 'dzos')" :loading="loadingStates.dzos"
                button-text="Выбор ДЗО" :options="getDZOSList" />

      <dropdown ref="dropDawnFields" block class="w-100 mb-2" @selected="selectedDropDown($event, 'field')"
                :loading="loadingStates.field"
                button-text="Выбор месторождения" :options="getFiledsList" />
    </template>
    <ToolBlock class="mb-2 toolBlock__auto-height" title="Скважины">
      <template #header>
        <div class="d-flex align-items-center justify-content-between">
          <h5 class="mr-2">Скважины</h5>
          <label class="d-flex align-items-center m-0">
            <input type="checkbox" class="mr-1">
            <small>Синхронизировать</small>
          </label>
        </div>
      </template>
      <template #tools-btn>
        <div class="d-flex flex-column">
          <Button size="narrow" icon="List" class="mb-2" />
          <Button size="narrow" icon="ListItemDown" class="mb-2" />
          <Button size="narrow" icon="ListItemUp" class="mb-2" />
          <Button size="narrow" icon="success" color="success" class="mt-4" />
        </div>
      </template>
      <ToolBlockList
          :loading="loadingStates.wells"
          @click="selectedHandle"
          :selected.sync="listSelect"
          :list="getWellsList"
      />
    </ToolBlock>
    <ToolBlockGroup>
      <ToolBlock class="toolBlock__auto-height">
        <template #header>
          <div class="d-flex align-items-center justify-content-between">
            <h5 class="mr-2">Интервал</h5>
            <Button i-width="10" i-height="10" color="transparent" icon="rectArrow" size="small" />
          </div>
        </template>
        <template #under-header>
          <div class="d-flex align-items-center justify-content-between">
            <span>Одиночные интервалы</span>
            <label class="d-flex align-items-center m-0">
              <input type="checkbox" class="mr-1">
              <small>Синхронизировать</small>
            </label>
          </div>
        </template>
        <template #tools-btn>
          <div class="d-flex flex-column">
            <Button size="narrow" icon="plusAndBrackets" class="mb-2" />
            <Button size="narrow" icon="plusAndBrackets2" class="mb-2" />
            <Button size="narrow" icon="remove" class="mb-2" color="danger" />
          </div>
        </template>
      </ToolBlock>
      <ToolBlockGroupDivider>
        <div class="d-flex align-items-center justify-content-between w-100">
          <div class="d-flex align-items-center">
            <AwIcon name="rulerToArrow" class="mr-2" />
            <span>Журнал горизонтов</span>
          </div>
          <Button size="narrow" icon="tripleDots" class="mb-2" />
        </div>
        <dropdown block class="w-100" :selected-value.sync="dropdownValue.value" button-text="TOPS.FORMATION" :options="[
              {label: 'option 1', value: 1},
              {label: 'option 2', value: 2},
              {label: 'option 3', value: 3}
            ]" />
        <template #right-side>
          <div class="d-flex h-100 align-items-center">
            <Button size="narrow" icon="reload" class="mb-2" color="success" />
          </div>
        </template>
      </ToolBlockGroupDivider>
      <ToolBlock class="toolBlock__auto-height">
        <template #tools-btn>
          <div class="d-flex flex-column">
            <Button size="narrow" icon="List" class="mb-2" />
            <Button size="narrow" icon="ListItemDown" class="mb-2" />
            <Button size="narrow" icon="ListItemUp" class="mb-2" />
            <Button size="narrow" icon="success" color="success" class="mt-4" />
          </div>
        </template>
        <template #tools-footer>
          <div class="d-flex align-items-center justify-content-between">
            <label class="d-flex align-items-center m-0">
              <input type="checkbox" class="mr-1">
              <small>Между интервалами</small>
            </label>
          </div>
        </template>
      </ToolBlock>
    </ToolBlockGroup>
  </PageSide>
</template>

<script>
import ToolBlock from "../components/toolBlock/ToolBlock";
import ToolBlockGroup from "../components/toolBlock/ToolBlockGroup";
import ToolBlockGroupDivider from "../components/toolBlock/ToolBlockGroupDivider";
import ToolBlockList from "../components/toolBlock/ToolBlockList";
import dropdown from "../components/dropdowns/dropdown";
import Button from "../components/buttons/Button";
import AwIcon from "../components/icons/AwIcon";

import PageSide from "../components/pageSide/PageSide";
import {FETCH_DZOS, FETCH_FIELDS, FETCH_WELLS, SET_WELLS} from "../../../store/modules/geologyGis.const";

export default {
  name: "Geology-LSide",
  data() {
    return {
      dropdownValue: {
        value: null
      },
      loadingStates: {
        dzos: false,
        field: false,
        wells: false,
      },
      listSelect: []
    }
  },
  components: {
    ToolBlockGroup,
    ToolBlock,
    Button,
    ToolBlockGroupDivider,
    dropdown,
    ToolBlockList,
    AwIcon,
    PageSide
  },
  computed: {
    cListSelect() {
      return this.listSelect
    },
    getDZOSList() {
      return this.$store.state.geologyGis.DZOS
    },
    getFiledsList() {
      return this.$store.state.geologyGis.FILEDS
    },
    getWellsList() {
      return this.$store.state.geologyGis.WELLS
    }
  },
  async mounted() {
    await this.$store.dispatch(FETCH_DZOS);
  },
  methods: {
    async selectedDropDown(e, t) {
      switch (t) {
        case "dzos": {
          this.loadingStates.field = true
          this.$refs.dropDawnFields.selectedLocal = null;
          this.$store.commit(SET_WELLS, []);
          await this.$store.dispatch(FETCH_FIELDS, e);
          this.loadingStates.field = false
          break;
        }
        case "field": {
          this.loadingStates.wells = true
          await this.$store.dispatch(FETCH_WELLS, e);
          this.loadingStates.wells = false
          break;
        }
      }
    },
    selectedHandle(item) {
      this.listSelect = [];
      this.listSelect.push(item.value);
    }
  }
}
</script>

