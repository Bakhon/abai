<template>
  <div>
    <Switcher :active.sync="switcherActive" :items="[
        {label: 'DTW'},
        {label: 'PCA'},
    ]" class="switcher mb-2" />

    <dropdown block class="w-100 mb-2" button-text="Опорная скважина" :options="[
        {label: 'Option 0'},
        {label: 'Option 1'},
        {label: 'Option 2'},
        {label: 'Option 3'},
    ]" />

    <dropdown block class="w-100 mb-2" button-text="Выбор отбивок" :options="[
        {label: 'Option 0'},
        {label: 'Option 1'},
        {label: 'Option 2'},
        {label: 'Option 3'},
    ]" />

    <dropdown multiple :selected-value.sync="multipleSelect" block class="w-100 mb-2" button-text="Корреляционные скважины" :options="[
        {label: 'Option 0'},
        {label: 'Option 1'},
        {label: 'Option 2'},
        {label: 'Option 3'},
    ]" />

    <ToolBlock title="Выбор кривых">
      <div class="p-2">
        <div class="buttons-grid">
          <Button color="accent" align="center">GR</Button>
          <Button color="accent" align="center">NPHI</Button>
          <Button color="accent" align="center">SP</Button>
          <Button color="accent" align="center">RHOB</Button>
        </div>
      </div>
    </ToolBlock>

    <ToolBlock class="mb-2">
      <div class="p-2 grid__inputs">
        <AwInput type="number" class="curve-inputs mb-2" label-direction="row" label="Интервал поиска" />
        <AwInput type="number" class="curve-inputs" label-direction="row" label="Окно поиска" />
      </div>
    </ToolBlock>

    <Button class="mb-2 w-100" color="primary" align="center">Старт</Button>

    <dropdown multiple block class="w-100 mb-2" button-text="Результаты" :options="[
        {label: 'Option 0'},
        {label: 'Option 1'},
        {label: 'Option 2'},
        {label: 'Option 3'},
    ]" />

    <div class="buttons-grid">
      <Button color="accent-100" align="center">Сохранить</Button>
      <Button color="gray" align="center">Отмена</Button>
    </div>

  </div>
</template>

<script>
import Button from "../../components/buttons/Button";
import Switcher from "../../components/switcher/Switcher";
import ToolBlock from "../../components/toolBlock/ToolBlock";
import dropdown from "../../components/dropdowns/dropdown";
import AwInput from "../../components/form/AwInput";

export default {
  name: "SecondComponent",
  components: {
    Button,
    Switcher,
    ToolBlock,
    dropdown,
    AwInput
  },
  data() {
    return {
      switcherActive: "DTW",
      multipleSelect: []
    }
  },
}
</script>
<style scoped lang="scss">
.buttons-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-gap: 10px;
}

.grid__inputs {
  .curve-inputs {
    display: grid;
    grid-template-columns: auto 130px;
  }
}
</style>
