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

    <ToolBlock class="mb-2" title="Настройка">
      <table class="aw-table w-100">
        <thead>
        <tr>
          <th>Фильтр</th>
          <th>Все</th>
        </tr>
        </thead>
        <tbody>

        <tr>
          <td>
            <label class="d-flex mb-0 align-items-center justify-content-between w-100"><span
                class="mr-2">Выбор горизонта</span><input type="checkbox" value="2"></label>
          </td>
          <td>
            <label class="d-flex mb-0 align-items-center justify-content-center w-100">
              <span class="mr-2">1</span>
              <input type="checkbox" value="2">
            </label>
          </td>
        </tr>

        <tr>
          <td>
            <label class="d-flex mb-0 align-items-center justify-content-between w-100">
              <span class="mr-2">Выбор глубины</span>
              <input type="checkbox" value="2"></label>
          </td>
          <td>
            <label class="d-flex mb-0 align-items-center justify-content-center w-100">
              <span class="mr-2">1</span>
              <input type="checkbox" value="2">
            </label>
          </td>
        </tr>

        <tr>
          <td>
            <label class="d-flex mb-0 align-items-center justify-content-between w-100">
              <span class="mr-2">Свой фильтр</span>
              <input type="checkbox" value="2"></label>
          </td>
          <td>
            <label class="d-flex mb-0 align-items-center justify-content-center w-100">
              <span class="mr-2">1</span>
              <input type="checkbox" value="2">
            </label>
          </td>
        </tr>


        <tr>
          <td>
          </td>
          <td>
            <label class="d-flex mb-0 align-items-center justify-content-center w-100">
              <span class="mr-2">1</span>
              <input type="checkbox" value="2">
            </label>
          </td>
        </tr>


        <tr>
          <td>
          </td>
          <td>
            <label class="d-flex mb-0 align-items-center justify-content-center w-100">
              <span class="mr-2">1</span>
              <input type="checkbox" value="2">
            </label>
          </td>
        </tr>


        <tr>
          <td>
          </td>
          <td>
            <label class="d-flex mb-0 align-items-center justify-content-center w-100">
              <span class="mr-2">1</span>
              <input type="checkbox" value="2">
            </label>
          </td>
        </tr>


        <tr>
          <td>
          </td>
          <td>
            <label class="d-flex mb-0 align-items-center justify-content-center w-100">
              <span class="mr-2">1</span>
              <input type="checkbox" value="2">
            </label>
          </td>
        </tr>

        </tbody>
      </table>
    </ToolBlock>
    <Button align="left" color="primary" class="w-100 mb-2">Настройка сейсмических данных</Button>
    <Button align="left" color="accent" class="w-100">Статистика объека</Button>
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
  computed: {
    cListSelect() {
      return this.listSelect
    }
  },
  methods: {
    selectedHandle(item) {
      if (this.cListSelect.includes(item.value)) {
        const index = this.cListSelect.indexOf(item.value)
        return this.listSelect.splice(index, 1);
      }
      this.listSelect.push(item.value);
    }
  }
}
</script>
