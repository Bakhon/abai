<template>
  <div class="geology__content">
    <div class="rect mb-3">
      <div class="d-flex align-items-center">
        <Button @click.native="gridSwapperActiveID = 'item1'" icon="i3d" class="flex-grow-1 mr-3" align="center"
                :color="gridSwapperActiveButton('item1')">
          3D window 3(Any)
        </Button>
        <Button @click.native="gridSwapperActiveID = 'item2'" icon="i2d" class="flex-grow-1 mr-3" align="center"
                :color="gridSwapperActiveButton('item2')">
          2D window 5(Any)
        </Button>
        <Button @click.native="gridSwapperActiveID = 'item3'" icon="interpret" class="flex-grow-1 mr-3" align="center"
                :color="gridSwapperActiveButton('item3')">
          Interpretation window 3 (TVD) - Asar_3DLand_IL2002_3193_KPSDMstk_AGC_zph_dtm150_v1 (realized) 1 - Seismic Time
          5...
        </Button>
      </div>
    </div>

    <div class="grid-swapper mb-2">
      <div :class="gridSwapperItemsClasses('item1')">
        <ToolBlock class="tool-block-bg__content--accent-darken-400" title="Настройка кривых">
          <template #header>
            <div class="d-flex align-items-center justify-content-between">
              <div class="d-flex align-items-center">
                <Icon class="mr-2" fill="var(--a-default)" name="i3d" />
                <h5 class="mr-2">3D window 3(Any)</h5>
              </div>
              <Button @click.native="gridSwapperActiveID = 'item1'" i-width="10" i-height="10" color="transparent"
                      icon="rectArrow" size="small" />
            </div>
          </template>
          <img src="/images/geology/demo.geophysics1.svg" alt="" class="w-100 h-100">
        </ToolBlock>
      </div>
      <div :class="gridSwapperItemsClasses('item2')">
        <ToolBlock title="Настройка кривых">
          <template #header>
            <div class="d-flex align-items-center justify-content-between">
              <div class="d-flex align-items-center">
                <Icon class="mr-2" fill="var(--a-default)" name="i3d" />
                <h5 class="mr-2">2D window 5(Any)</h5>
              </div>
              <Button @click.native="gridSwapperActiveID = 'item2'" i-width="10" i-height="10" color="transparent"
                      icon="rectArrow" size="small" />
            </div>
          </template>
          <img src="/images/geology/demo.geophysics2.svg" alt="" class="w-100 h-100">
        </ToolBlock>
      </div>
      <div :class="gridSwapperItemsClasses('item3')">
        <ToolBlock>
          <template #header>
            <div class="d-flex align-items-center justify-content-between">
              <div class="d-flex align-items-center">
                <Icon class="mr-2" fill="var(--a-default)" name="i3d" />
                <h5 class="mr-2">Interpretation window 3 (TVD)</h5>
              </div>
              <Button @click.native="gridSwapperActiveID = 'item3'" i-width="10" i-height="10" color="transparent"
                      icon="rectArrow" size="small" />
            </div>
          </template>
          <img src="/images/geology/demo.geophysics3.svg" alt="" class="w-100 h-100">
        </ToolBlock>
      </div>
    </div>
    <div class="geophysics__options">
      <ToolBlock title="Volume attribute">
        <div class="rect h-100">
          <AwTab class="options-tabs" :buttons="[
            {id: 'tab1', label: 'RMS Amplitude'},
            {id: 'tab2', label: 'Variance'},
            {id: 'tab3', label: 'GSD'},
        ]">
            <AwTabContent tab-id="tab1">
              <table class="aw-table options_first_table no-padding w-100">
                <tbody>
                <tr>
                  <td>Algorithm</td>
                  <td>
                    <dropdown block class="w-100" :selected-value.sync="dropdownValue.value" button-text="C/C"
                              :options="[
                        {label: 'option 1', value: 1},
                        {label: 'option 2', value: 2},
                        {label: 'option 3', value: 3}
                      ]" />

                  </td>
                </tr>
                <tr>
                  <td>Frequency</td>
                  <td>
                    <dropdown block class="w-100" :selected-value.sync="dropdownValue.value" button-text="1-1000"
                              :options="[
                        {label: 'option 1', value: 1},
                        {label: 'option 2', value: 2},
                        {label: 'option 3', value: 3}
                      ]" />
                  </td>
                </tr>
                <tr>
                  <td>
                    Ncycles
                  </td>
                  <td>
                    <dropdown block class="w-100" :selected-value.sync="dropdownValue.value" button-text="1-1111"
                              :options="[
                        {label: 'option 1', value: 1},
                        {label: 'option 2', value: 2},
                        {label: 'option 3', value: 3}
                      ]" />
                  </td>
                </tr>
                <tr>
                  <td>
                    Phase
                  </td>
                  <td>
                    <dropdown block class="w-100" :selected-value.sync="dropdownValue.value" button-text="1-100"
                              :options="[
                        {label: 'option 1', value: 1},
                        {label: 'option 2', value: 2},
                        {label: 'option 3', value: 3}
                      ]" />
                  </td>
                </tr>
                <tr>
                  <td>
                    Max Filter len
                  </td>
                  <td>
                    <dropdown block class="w-100" :selected-value.sync="dropdownValue.value" button-text="0-15"
                              :options="[
                        {label: 'option 1', value: 1},
                        {label: 'option 2', value: 2},
                        {label: 'option 3', value: 3}
                      ]" />
                  </td>
                </tr>
                <tr>
                  <td>
                    Method
                  </td>
                  <td>
                    <dropdown block class="w-100" :selected-value.sync="dropdownValue.value" button-text="S/FT"
                              :options="[
                        {label: 'option 1', value: 1},
                        {label: 'option 2', value: 2},
                        {label: 'option 3', value: 3}
                      ]" />
                  </td>
                </tr>
                </tbody>
              </table>
              <Button color="primary" class="w-100 mt-2" size="big" align="center">
                Запуск
              </Button>
            </AwTabContent>
            <AwTabContent tab-id="tab2">
            </AwTabContent>
            <AwTabContent tab-id="tab3">
            </AwTabContent>
          </AwTab>
        </div>
      </ToolBlock>
      <div>
        <ToolBlock class="mb-2" title="Surface attribute">
          <table class="aw-table w-100 no-padding">
            <tbody>
            <tr>
              <td>
                <dropdown block class="w-100" :selected-value.sync="dropdownValue.value" button-text="S/FT"
                          :options="[
                        {label: 'option 1', value: 1},
                        {label: 'option 2', value: 2},
                        {label: 'option 3', value: 3}
                      ]" />
              </td>
              <td>
                <dropdown block class="w-100" :selected-value.sync="dropdownValue.value" button-text="S/FT"
                          :options="[
                        {label: 'option 1', value: 1},
                        {label: 'option 2', value: 2},
                        {label: 'option 3', value: 3}
                      ]" />
              </td>
            </tr>
            <tr>
              <td>
                <div class="d-flex align-items-center">
                <span class="flex-grow-1">
                  Reference Horizon
                </span>
                  <dropdown block class="flex-grow-1" :selected-value.sync="dropdownValue.value" button-text="S/FT"
                            :options="[
                        {label: 'option 1', value: 1},
                        {label: 'option 2', value: 2},
                        {label: 'option 3', value: 3}
                      ]" />
                </div>
              </td>
              <td>
                <div class="d-flex align-items-center">
                <span class="flex-grow-1">
                  Reference Horizon
                </span>
                  <dropdown block class="flex-grow-1" :selected-value.sync="dropdownValue.value" button-text="S/FT"
                            :options="[
                        {label: 'option 1', value: 1},
                        {label: 'option 2', value: 2},
                        {label: 'option 3', value: 3}
                      ]" />
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <div class="d-flex align-items-center">
                <span class="flex-grow-1">
                  Search window
                </span>
                  <dropdown block class="flex-grow-1" :selected-value.sync="dropdownValue.value" button-text="S/FT"
                            :options="[
                        {label: 'option 1', value: 1},
                        {label: 'option 2', value: 2},
                        {label: 'option 3', value: 3}
                      ]" />
                </div>
              </td>
              <td>
                <div class="d-flex align-items-center">
                <span class="flex-grow-1">
                  Search window
                </span>
                  <dropdown block class="flex-grow-1" :selected-value.sync="dropdownValue.value" button-text="S/FT"
                            :options="[
                        {label: 'option 1', value: 1},
                        {label: 'option 2', value: 2},
                        {label: 'option 3', value: 3}
                      ]" />
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <div class="d-flex align-items-center">
                <span class="flex-grow-1">
                  Horizon Offset
                </span>
                  <dropdown block class="flex-grow-1" :selected-value.sync="dropdownValue.value" button-text="S/FT"
                            :options="[
                        {label: 'option 1', value: 1},
                        {label: 'option 2', value: 2},
                        {label: 'option 3', value: 3}
                      ]" />
                </div>
              </td>
              <td>
                <div class="d-flex align-items-center">
                <span class="flex-grow-1">
                  Horizon Offset
                </span>
                  <dropdown block class="flex-grow-1" :selected-value.sync="dropdownValue.value" button-text="S/FT"
                            :options="[
                        {label: 'option 1', value: 1},
                        {label: 'option 2', value: 2},
                        {label: 'option 3', value: 3}
                      ]" />
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <Button color="primary" class="w-100 mt-2" size="big" align="center">
                  Запуск
                </Button>
              </td>
            </tr>
            </tbody>
          </table>
        </ToolBlock>
        <ToolBlock title="Repeated window">
          <AwTab class="options-tabs" :buttons="[
            {id: 'tab1', label: 'None'},
            {id: 'tab2', label: 'Fixed'},
            {id: 'tab3', label: 'Proportional'},
        ]">
            <AwTabContent tab-id="tab1" style="min-height: 58px">
            </AwTabContent>
            <AwTabContent tab-id="tab2" style="min-height: 58px">
            </AwTabContent>
            <AwTabContent tab-id="tab3" style="min-height: 58px">
            </AwTabContent>
          </AwTab>

        </ToolBlock>
      </div>
      <ToolBlockGroup>
        <ToolBlock title="Настройка кривых">
          <template #under-header>
            <div class="text-center">Auto-Picking</div>
          </template>
          <table class="aw-table no-padding w-100">
            <tbody>
            <tr>
              <td>
                <dropdown block class="w-100" :selected-value.sync="dropdownValue.value" button-text="C/C"
                          :options="[
                        {label: 'option 1', value: 1},
                        {label: 'option 2', value: 2},
                        {label: 'option 3', value: 3}
                      ]" />
              </td>
              <td>
                <dropdown block class="w-100" :selected-value.sync="dropdownValue.value" button-text="C/C"
                          :options="[
                        {label: 'option 1', value: 1},
                        {label: 'option 2', value: 2},
                        {label: 'option 3', value: 3}
                      ]" />
              </td>
              <td>
                <dropdown block class="w-100" :selected-value.sync="dropdownValue.value" button-text="C/C"
                          :options="[
                        {label: 'option 1', value: 1},
                        {label: 'option 2', value: 2},
                        {label: 'option 3', value: 3}
                      ]" />
              </td>
            </tr>
            <tr>
              <td>
                <dropdown block class="w-100" :selected-value.sync="dropdownValue.value" button-text="C/C"
                          :options="[
                        {label: 'option 1', value: 1},
                        {label: 'option 2', value: 2},
                        {label: 'option 3', value: 3}
                      ]" />
              </td>
              <td>
                <dropdown block class="w-100" :selected-value.sync="dropdownValue.value" button-text="C/C"
                          :options="[
                        {label: 'option 1', value: 1},
                        {label: 'option 2', value: 2},
                        {label: 'option 3', value: 3}
                      ]" />
              </td>
              <td>
                <dropdown block class="w-100" :selected-value.sync="dropdownValue.value" button-text="C/C"
                          :options="[
                        {label: 'option 1', value: 1},
                        {label: 'option 2', value: 2},
                        {label: 'option 3', value: 3}
                      ]" />
              </td>
            </tr>
            <tr>
              <td>
                <dropdown block class="w-100" :selected-value.sync="dropdownValue.value" button-text="C/C"
                          :options="[
                        {label: 'option 1', value: 1},
                        {label: 'option 2', value: 2},
                        {label: 'option 3', value: 3}
                      ]" />
              </td>
              <td>
                <dropdown block class="w-100" :selected-value.sync="dropdownValue.value" button-text="C/C"
                          :options="[
                        {label: 'option 1', value: 1},
                        {label: 'option 2', value: 2},
                        {label: 'option 3', value: 3}
                      ]" />
              </td>
              <td>
                <dropdown block class="w-100" :selected-value.sync="dropdownValue.value" button-text="C/C"
                          :options="[
                        {label: 'option 1', value: 1},
                        {label: 'option 2', value: 2},
                        {label: 'option 3', value: 3}
                      ]" />
              </td>
            </tr>
            </tbody>
          </table>

        </ToolBlock>
        <ToolBlockGroupDivider>Manual interpretation</ToolBlockGroupDivider>
        <ToolBlock>
          <table class="aw-table no-padding w-100">
            <tbody>
            <tr>
              <td>
                <dropdown block class="w-100" :selected-value.sync="dropdownValue.value" button-text="C/C"
                          :options="[
                        {label: 'option 1', value: 1},
                        {label: 'option 2', value: 2},
                        {label: 'option 3', value: 3}
                      ]" />
              </td>
              <td>
                <dropdown block class="w-100" :selected-value.sync="dropdownValue.value" button-text="C/C"
                          :options="[
                        {label: 'option 1', value: 1},
                        {label: 'option 2', value: 2},
                        {label: 'option 3', value: 3}
                      ]" />
              </td>
              <td>
                <dropdown block class="w-100" :selected-value.sync="dropdownValue.value" button-text="C/C"
                          :options="[
                        {label: 'option 1', value: 1},
                        {label: 'option 2', value: 2},
                        {label: 'option 3', value: 3}
                      ]" />
              </td>
            </tr>
            <tr>
              <td class="p-0"><button class="noStyleButton">Delete</button></td>
              <td class="p-0"><button class="noStyleButton">Select</button></td>
              <td class="p-0"><button class="noStyleButton">Edit</button></td>
            </tr>
            <tr>
              <td class="p-0"><button class="noStyleButton">Cut</button></td>
              <td class="p-0"><button class="noStyleButton">Cut MZ</button></td>
              <td class="p-0"><button class="noStyleButton">Flip MZ</button></td>
            </tr>
            </tbody>
          </table>
        </ToolBlock>
      </ToolBlockGroup>
    </div>
  </div>
</template>

<script>
import Button from "../components/buttons/Button";
import dropdown from "../components/dropdowns/dropdown";
import ToolBlock from "../components/toolBlock/ToolBlock";
import ToolBlockGroup from "../components/toolBlock/ToolBlockGroup";
import ToolBlockGroupDivider from "../components/toolBlock/ToolBlockGroupDivider";
import Icon from "../components/icons/Icon"
import AwTab from "../components/awTab/AwTab";
import AwTabContent from "../components/awTab/AwTabContent";

export default {
  name: "Geology-Page",
  components: {
    Button,
    dropdown,
    ToolBlock,
    Icon,
    AwTab,
    AwTabContent,
    ToolBlockGroup,
    ToolBlockGroupDivider
  },
  data() {
    return {
      gridSwapperActiveID: "item1",
      dropdownValue: {
        value: null
      }
    }
  },
  methods: {
    gridSwapperActiveButton(id) {
      return this.gridSwapperActiveID === id ? 'primary' : 'accent';
    },
    gridSwapperItemsClasses(id) {
      return {
        "grid-swapper__item": true,
        "active": this.gridSwapperActiveID === id
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.grid-swapper {
  display: grid;
  grid-gap: 10px;
  grid-template-columns: minmax(400px, 1fr) 300px;

  &__item {
    order: 2;
    max-height: 246px;
    // TODO Удалить когда сделают норм графики
    overflow: hidden;
    // TODO Удалить когда сделают норм графики
    img {
      min-height: 208px;
    }

    &.active {
      max-height: 522px;
      order: 1;
      grid-row-start: 1;
      grid-row-end: 3;
    }
  }
}

.geophysics__options {
  display: grid;
  grid-gap: 10px;
  grid-template-columns: 388px 1fr 300px;

  &::v-deep {
    .options-tabs {
      .aw-tab__buttons {
        display: flex;
        align-items: flex-end;

        button {
          flex-grow: 1;
          margin-right: 3px;

          &:last-child {
            margin-right: 0;
          }
        }
      }
    }
  }
}

.aw-table {
  &.options_first_table {
    line-height: 1;
  }
}

.noStyleButton {
  border: none;
  background: #363B68;
  transition: 300ms all;
  color: #ffffff;
  padding: 16px 12px;
  width: 100%;
  display: block;
  text-align: left;
  &:hover{
    background: darken(#363B68, 7%);
  }
}
</style>
