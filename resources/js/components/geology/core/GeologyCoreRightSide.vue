<template>
  <div class="geology-l-side">
    <div class="geology-l-side__top d-flex align-items-start w-100">
      <div class="w-100">
        <dropdown block class="w-100 mb-2" :selected-value.sync="dropdownValue.value" button-text="Выбор методов" :options="[
              {label: 'option 1', value: 1},
              {label: 'option 2', value: 2},
              {label: 'option 3', value: 3}
            ]" />
        <dropdown block class="w-100 mb-2" :selected-value.sync="dropdownValue.value" button-text="Выбор алгоритмов" :options="[
              {label: 'option 1', value: 1},
              {label: 'option 2', value: 2},
              {label: 'option 3', value: 3}
            ]" />
        <dropdown block class="w-100 mb-2" :selected-value.sync="dropdownValue.value" button-text="Данные по сважине" :options="[
              {label: 'option 1', value: 1},
              {label: 'option 2', value: 2},
              {label: 'option 3', value: 3}
            ]" />
      </div>
      <button class="geology-l-side__toggle">
        <Icon name="arrowLeft"/>
      </button>
    </div>
    <ToolBlock class="mb-2">
      <template #header>
        <div class="d-flex align-items-center justify-content-between">
          <h5 class="mr-2">Кросс-плот</h5>
          <Button i-width="10" i-height="10" color="transparent" icon="rectArrow" size="small" />
        </div>
      </template>
      <img class="w-100" src="/images/geology/demo.cross-plot.svg" alt="">
    </ToolBlock>
    <ToolBlock class="mb-3">
      <ToolBlockList
          @click="selectedHandle"
          :selected.sync="listSelect"
          :list="[
              {label: 'ГК_123', value: '1'},
          ]"
      />
      <template #tools-footer>
        <Button class="w-100" align="center">Выбор НС</Button>
      </template>
    </ToolBlock>
    <Button color="primary" class="w-100 mb-3" align="center">Запуск</Button>
    <div class="d-flex align-items-stretch w-100">
      <ToolBlock title="Все" class="flex-grow-1 mr-2 w-100">
        <ToolBlockList
            @click="selectedHandle"
            :selected.sync="listSelect"
            :list="[
              {label: '1', value: '1'},
              {label: '2', value: '12'},
              {label: '3', value: '13'},
          ]"
        />
      </ToolBlock>
      <div class="rect flex-grow-1 p-3">
        <Button class="mb-2 w-100" align="center">Импорт</Button>
        <Button class="mb-2 w-100" align="center">Импорт расчета литотипов с ГИС</Button>
        <Button class="w-100" align="center">Кнопка на карту керна</Button>
      </div>
    </div>
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
import Legend from "../components/legend/Legend";
export default {
  name: "GeologyCoreLeftSide",
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
    Icon,
    Legend
  },
  computed:{
    cListSelect(){
      return this.listSelect
    }
  },
  methods:{
    selectedHandle(item){
      if(this.cListSelect.includes(item.value)){
        const index = this.cListSelect.indexOf(item.value)
        return this.listSelect.splice(index, 1);
      }
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
.geology-l-side{
  .toolBlock__list{
    background: none;
  }
  .btns{
    padding: 20px 13px;
  }
  &__toggle{
    border: none;
    background: var(--a-accent);
    margin: -6px -7px 0  10px;
    padding: 14px 6px;
    border-radius: 10px 0 0 10px;
    .a-svg-icons{
      transform: rotate(180deg);
    }
  }
}
</style>
