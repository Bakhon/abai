<template>
  <div class="geology__content">
    <div class="rect mb-2">
      <div class="d-flex align-items-center">
        <Button color="accent" icon="i3d" class="flex-grow-1 mr-3" align="center">
          3D window 3(Any)
        </Button>
        <Button color="accent" icon="i2d" class="flex-grow-1 mr-3" align="center">
          2D window 5(Any)
        </Button>
        <Button color="accent" icon="interpret" class="flex-grow-1 mr-3" align="center">
          Interpretation window 3 (TVD) - Asar_3DLand_IL2002_3193_KPSDMstk_AGC_zph_dtm150_v1 (realized) 1 - Seismic Time
          5...
        </Button>
      </div>
    </div>
    <div class="rect mb-3">
      <div class="d-flex align-items-center">
        <Button color="accent" icon="cog" class="flex-grow-1 mr-3" align="center">
          Основные настройки
        </Button>
        <Button color="accent" icon="eq" class="flex-grow-1 mr-3" align="center">
          Параметры отображения
        </Button>
        <Button color="accent" icon="cubeArrow" class="flex-grow-1 mr-3" align="center">
          Двигать сейсмический профиль
        </Button>
        <Button color="accent" icon="ruler" class="flex-grow-1 mr-3" align="center">
          Линейка
        </Button>
      </div>
    </div>
    <ToolBlock>
      <template #header>
        <div class="d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center">
            <AwIcon class="mr-2" fill="var(--a-default)" name="i3d"/>
            <h5 class="mr-2">3D window 3(Any)</h5>
          </div>
          <Button i-width="10" i-height="10" color="transparent" icon="rectArrow" size="small" />
        </div>
      </template>
      <img class="w-100" src="/images/geology/demo.visualization.svg" alt="">
    </ToolBlock>
    <div class="visualization-bottom mt-2">
      <ToolBlock title="2D window 5(Any)">
        <template #header>
          <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
              <AwIcon class="mr-2" fill="var(--a-default)" name="i2d"/>
              <h5 class="mr-2">3D window 3(Any)</h5>
            </div>
            <Button i-width="10" i-height="10" color="transparent" icon="rectArrow" size="small" />
          </div>
        </template>
        <img class="w-100" src="/images/geology/demo.visualization2.svg" alt="">
      </ToolBlock>
      <ToolBlock>
        <template #header>
          <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
              <AwIcon class="mr-2" fill="var(--a-default)" name="interpret"/>
              <h5 class="mr-2">Interpretation window 3 (TVD)</h5>
            </div>
            <Button i-width="10" i-height="10" color="transparent" icon="rectArrow" size="small" />
          </div>
        </template>
        <div class="p-2">
          <img class="w-100" src="/images/geology/demo.visualization3.svg" alt="">
        </div>
      </ToolBlock>
      <ToolBlock title="Настройка окна">
        <div class="rect h-100">
          <dropdown block class="w-100 mb-2" :selected-value.sync="dropdownValue.value" button-text="Выбор ДЗО" :options="[
              {label: 'option 1', value: 1},
              {label: 'option 2', value: 2},
              {label: 'option 3', value: 3}
            ]" />
          <dropdown block class="w-100 mb-2" :selected-value.sync="dropdownValue.value" button-text="Выбор ДЗО" :options="[
              {label: 'option 1', value: 1},
              {label: 'option 2', value: 2},
              {label: 'option 3', value: 3}
            ]" />
          <div class="text-white">Расстояние скважин от профиля</div>
          <AwTextarea style="height: 141px" readonly/>
        </div>
      </ToolBlock>
    </div>
  </div>
</template>

<script>
import Button from "../components/buttons/Button";
import ToolBlock from "../components/toolBlock/ToolBlock";
import AwIcon from "../components/icons/AwIcon";
import dropdown from "../components/dropdowns/dropdown";
import AwForm from "../components/form/AwForm";
import AwInput from "../components/form/AwInput";
import AwTextarea from "../components/form/AwTextarea";

export default {
  name: "core",
  components: {
    AwTextarea,
    AwIcon,
    Button,
    ToolBlock,
    dropdown,
    AwForm,
    AwInput
  },
  data(){
    return {
      dropdownValue: {
        value: null
      }
    }
  }
}
</script>

<style scoped lang="scss">
.visualization-bottom {
  display: grid;
  grid-template-columns: repeat(2, minmax(300px, 1fr)) minmax(200px, 300px);
  grid-gap: 10px;
}
</style>
