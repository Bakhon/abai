<template>
  <PageSide>
    <template #top>
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
    <ToolBlock class="mb-2" title="Выбор горизонта">
      <ToolBlockList
          @click="selectedHandle"
          :selected.sync="listSelect"
          description="Выбор с 1м/5м"
          has-checkbox
          :list="[
              {label: '1 m', value: '1m'},
              {label: 'Ящик/Коробка', value: 'box'},
          ]"
      />
    </ToolBlock>
    <ToolBlock class="mb-2" title="Выбор УФ/ Дневной">
      <ToolBlockList
          @click="selectedHandle"
          :selected.sync="listSelect"
          has-checkbox
          :list="[
              {label: 'УФ', value: 'УФ'},
              {label: 'Дневной', value: 'Дневной'},
          ]"
      />
    </ToolBlock>
    <ToolBlock class="mb-2" title="Список файлов">
      <ToolBlockList
          @click="selectedHandle"
          :selected.sync="listSelect"
          has-checkbox
          :list="[
              {label: 'ZN_0001_1000_1001_WL.jpeg', value: 'ZN_0001_1000_1001_WL.jpeg'},
              {label: 'ZN_0001_1000_1001_WL.jpeg', value: 'ZN_0001_1000_1001_WL.jpeg'},
          ]"
      />
    </ToolBlock>
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
