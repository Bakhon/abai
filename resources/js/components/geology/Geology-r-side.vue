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
    <ToolBlock title="Выбор модели (готовая)">
      <div class="d-flex align-items-center btns">
        <Button class="mr-3">ГК</Button>
        <Button class="mr-3">ПС</Button>
        <Button>КВ</Button>
      </div>
    </ToolBlock>
    <ToolBlock class="mb-2" title="Выбор модели (готовая)">
      <div class="btns">
        <div class="d-flex align-items-center">
          <Button class="mr-2">ГК</Button>
          <Button class="mr-2">ПС</Button>
          <Button class="mr-2">КВ</Button>
          <Button>ГККП</Button>
        </div>
        <Button class="mt-5 w-100" color="primary" align="center">Запуск</Button>
      </div>
    </ToolBlock>

    <ToolBlock class="mb-2">
      <ToolBlockList
          @click="selectedHandle"
          :selected.sync="listSelect"
          :list="[
              {label: '1', value: '1'},
          ]"
      />
      <template #tools-footer>
        <Button class="w-100" align="center">Создать новую кривую</Button>
      </template>
    </ToolBlock>

    <ToolBlock class="mb-2">
      <ToolBlockList
          @click="selectedHandle"
          :selected.sync="listSelect"
          :list="[
              {label: '1', value: '1'},
          ]"
      />

      <template #tools-footer>
        <Button class="w-100" align="center">Тип кривой</Button>
      </template>
    </ToolBlock>

    <ToolBlock class="mb-2">
      <ToolBlockList
          @click="selectedHandle"
          :selected.sync="listSelect"
          :list="[
              {label: '1', value: '1'},
          ]"
      />

      <template #tools-footer>
        <Button class="w-100" align="center">Создать новую модель (Data set)</Button>
      </template>
    </ToolBlock>

    <ToolBlock class="mb-2">
      <ToolBlockList
          @click="selectedHandle"
          :selected.sync="listSelect"
          :list="[
              {label: '1', value: '1'},
          ]"
      />

      <template #tools-footer>
        <Button class="w-100" align="center">Использовать существующую модель (Data set)</Button>
      </template>
    </ToolBlock>

  </div>
</template>

<script>
import ToolBlock from "./components/toolBlock/ToolBlock";
import ToolBlockGroup from "./components/toolBlock/ToolBlockGroup";
import ToolBlockGroupDivider from "./components/toolBlock/ToolBlockGroupDivider";
import ToolBlockList from "./components/toolBlock/ToolBlockList";
import dropdown from "./components/dropdowns/dropdown";
import Button from "./components/buttons/Button";
import Icon from "./components/icons/Icon"
export default {
  name: "Geology-RSide",
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
      /*
      if(this.cListSelect.includes(item.value)){
        const index = this.cListSelect.indexOf(item.value)
        return this.listSelect.splice(index, 1);
      }
      */
      this.listSelect = [];
      this.listSelect.push(item.value);
    }
  }
}
</script>

<style scoped lang="scss">
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
.test{
  &::v-deep{
    .tool-block__body{
      height: calc((100vh / 3) - 120px);
      min-height: 200px;
    }
  }
}
</style>
