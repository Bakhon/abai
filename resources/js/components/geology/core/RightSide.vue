<template>
  <PageSide direction="right">
    <template #top>
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
    </template>
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
import Legend from "../components/legend/Legend";
import PageSide from "../components/pageSide/PageSide";
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
    AwIcon,
    Legend,
    PageSide
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
