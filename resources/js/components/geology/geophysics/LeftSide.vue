<template>
  <PageSide>
    <template #top>
      <dropdown block class="w-100 mb-2" :selected-value.sync="dropdownValue.value" button-text="Выбор ДЗО" :options="[
              {label: 'option 1', value: 1},
              {label: 'option 2', value: 2},
              {label: 'option 3', value: 3}
            ]" />
      <Button align="left" color="accent" class="w-100 mb-2">Выбор месторождения</Button>
      <Button align="left" color="accent" class="w-100 mb-2">Выбор поверхности</Button>
      <Button align="left" color="accent" class="w-100 mb-2">Выбор карт</Button>
      <Button align="left" color="accent" class="w-100 mb-2">Выбор сейсмисческих данных</Button>
      <Button align="left" color="accent" class="w-100 mb-2">Выбор разлома</Button>
      <Button align="left" color="accent" class="w-100 mb-2">Выбор скважин</Button>
      <Button align="left" color="accent" class="w-100 mb-2">Выбор отбивки</Button>
      <Button align="left" color="accent" class="w-100">Модель</Button>
    </template>
    <ToolBlock class="mb-2" title="Настройка окна">
      <div class="rect">
        <dropdown block class="w-100 mb-2" :selected-value.sync="dropdownValue.value" button-text="Политра" :options="[
              {label: 'option 1', value: 1},
              {label: 'option 2', value: 2},
              {label: 'option 3', value: 3}
            ]" />
        <dropdown block class="w-100 mb-2" :selected-value.sync="dropdownValue.value" button-text="Шаг сейсмики" :options="[
              {label: 'option 1', value: 1},
              {label: 'option 2', value: 2},
              {label: 'option 3', value: 3}
            ]" />
        <dropdown block class="w-100" :selected-value.sync="dropdownValue.value" button-text="Расстояние скважин от" :options="[
              {label: 'option 1', value: 1},
              {label: 'option 2', value: 2},
              {label: 'option 3', value: 3}
            ]" />
      </div>
    </ToolBlock>
    <ToolBlock class="mb-2" title="Настройка кривых">
      <table class="aw-table w-100">
        <tbody >
        <tr>
          <td>Direction</td>
          <td>
            <dropdown block class="w-100" :selected-value.sync="dropdownValue.value" :options="[
              {label: 'option 1', value: 1},
              {label: 'option 2', value: 2},
              {label: 'option 3', value: 3}
            ]" />
          </td>
        </tr>
        <tr>
          <td>Color</td>
          <td>
            <dropdown block class="w-100" :selected-value.sync="dropdownValue.value" :options="[
              {label: 'option 1', value: 1},
              {label: 'option 2', value: 2},
              {label: 'option 3', value: 3}
            ]" />
          </td>
        </tr>
        <tr>
          <td>Line width</td>
          <td>
            <dropdown block class="w-100" :selected-value.sync="dropdownValue.value" :options="[
              {label: 'option 1', value: 1},
              {label: 'option 2', value: 2},
              {label: 'option 3', value: 3}
            ]" />
          </td>
        </tr>
        <tr>
          <td>Line type</td>
          <td>
            <dropdown block class="w-100" :selected-value.sync="dropdownValue.value" :options="[
              {label: 'option 1', value: 1},
              {label: 'option 2', value: 2},
              {label: 'option 3', value: 3}
            ]" />
          </td>
        </tr>
        </tbody>
      </table>
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
      this.listSelect = [];
      this.listSelect.push(item.value);
    }
  }
}
</script>
