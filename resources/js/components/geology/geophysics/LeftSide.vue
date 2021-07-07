<template>
  <div class="geology-l-side">
    <div class="geology-l-side__top d-flex align-items-start w-100">
      <button class="geology-l-side__toggle">
        <Icon name="arrowLeft" />
      </button>
      <div class="w-100 mb-2">
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
      </div>
    </div>
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
