<template>
  <div class="geology-l-side">
    <div class="geology-l-side__top d-flex align-items-start w-100">
      <button class="geology-l-side__toggle">
        <Icon name="arrowLeft"/>
      </button>
      <div class="w-100">
        <dropdown block class="w-100 mb-2" :selected-value.sync="dropdownValue.value" button-text="Выбор ДЗО" :options="[
              {label: 'option 1', value: 1},
              {label: 'option 2', value: 2},
              {label: 'option 3', value: 3}
            ]" />
        <dropdown block class="w-100 mb-2" :selected-value.sync="dropdownValue.value" button-text="Выбор месторождения" :options="[
              {label: 'option 1', value: 1},
              {label: 'option 2', value: 2},
              {label: 'option 3', value: 3}
            ]" />
      </div>
    </div>
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
          @click="selectedHandle"
          :selected.sync="listSelect"
          :list="[
              {label: '1', value: '1'},
              {label: '1-T', value: '1-T'},
              {label: '10', value: '10'},
              {label: '100', value: '100'},
              {label: '1000', value: '1000'},
              {label: '1001', value: '1001'},
              {label: '1002', value: '1002'},
              {label: '1003', value: '1003'},
              {label: '1007', value: '1007'},
              {label: '1008', value: '1008'},
              {label: '1009', value: '1009'},
              {label: '101', value: '101'},
              {label: '1011', value: '1011'},
          ]"
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
            <Icon name="rulerToArrow" class="mr-2"/>
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
            <Button size="narrow" icon="reload" class="mb-2" color="success"/>
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
            <dropdown size="tiny" :selected-value.sync="dropdownValue.value" button-text="Значения" :options="[
              {label: 'option 1', value: 1},
              {label: 'option 2', value: 2},
              {label: 'option 3', value: 3}
            ]" />
          </div>
        </template>
      </ToolBlock>
    </ToolBlockGroup>
  </div>
</template>

<script>
import ToolBlock from "../components/toolBlock/ToolBlock";
import ToolBlockGroup from "../components/toolBlock/ToolBlockGroup";
import ToolBlockGroupDivider from "../components/toolBlock/ToolBlockGroupDivider";
import ToolBlockList from "../components/toolBlock/ToolBlockList";
import dropdown from "../components/dropdowns/dropdown";
import Button from "../components/buttons/Button";
import Icon from "../components/icons/Icon";
export default {
  name: "Geology-LSide",
  data() {
    return {
      dropdownValue: {
        value: null
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
    Icon
  },
  computed:{
    cListSelect(){
      return this.listSelect
    }
  },
  methods:{
    selectedHandle(item){
      this.listSelect = [];
      this.listSelect.push(item.value);
    }
  }
}
</script>

<style scoped lang="scss">
.geology-l-side{
  &__toggle{
    border: none;
    background: var(--a-accent);
    margin: -6px 10px 0 -7px;
    padding: 14px 6px;
    border-radius: 0 10px 10px 0;
  }
}

</style>
