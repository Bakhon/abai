<template>
  <div class="table-settings">
    <div class="d-flex align-items-stretch">
      <div class="table-settings__left-panel d-flex flex-column">
        <Button size="narrow" icon="downwardsArrow" class="mb-2" />
        <Button size="narrow" icon="upwardsArrow" class="mb-2" />
        <Button size="narrow" icon="copy" class="mb-2" />
      </div>
      <div class="table-settings__content w-100">
        <div class="d-flex align-items-stretch h-100 w-100">
          <div class="customScroll tree-wrapper mr-2">
            <AwTree :selected.sync="tableSettingsSelected" variant="AwTreeItem2" :items="getCurves" />
          </div>
          <AwTab active="tab3" class="options-tabs w-100" :buttons="[
            {id: 'tab1', label: 'Info'},
            {id: 'tab2', label: 'Definition'},
            {id: 'tab3', label: 'Limits'},
            {id: 'tab4', label: 'Style'},
        ]">
            <AwTabContent tab-id="tab1">
              <pre>{{ getCurveOptions }}</pre>
            </AwTabContent>
            <AwTabContent tab-id="tab2"></AwTabContent>
            <AwTabContent tab-id="tab3">
              <div class="limits-tab">
                <div class="d-flex align-items-center p-2 w-100">
                  <label class="d-flex align-items-center mr-2 mb-0 w-space-nowrap">
                    <input :disabled="!getSelectedCurveName" :checked="getCurveOptions.min.use" type="checkbox" class="mr-2" name="min"
                           @change="setToggleUsageProperty">
                    <span>Min value</span>
                  </label>
                  <AwInput :disabled="!getSelectedCurveName" :value="getCurveOptions.min.value" type="number" class="w-100" prop-name="min"
                           @change="setValueProperty" />
                </div>
                <div class="d-flex align-items-center p-2 w-100">
                  <label class="d-flex align-items-center mr-2 mb-0 w-space-nowrap">
                    <input :disabled="!getSelectedCurveName" :checked="getCurveOptions.max.use" type="checkbox" class="mr-2" name="max"
                           @change="setToggleUsageProperty">
                    <span>Max value</span>
                  </label>
                  <AwInput :disabled="!getSelectedCurveName" :value="getCurveOptions.max.value" type="number" class="w-100" prop-name="max"
                           @change="setValueProperty" />
                </div>
                <div class="d-flex align-items-center p-2 w-100">
                  <label class="d-flex align-items-center mr-2 mb-0 w-space-nowrap">
                    <span>Direction</span>
                  </label>
                  <dropdown
                      :disabled="!getSelectedCurveName"
                      @change="setValueProperty"
                      prop-name="direction"
                      class="w-100"
                      button-text="??????????????"
                      :selectedValue="getCurveOptions.direction.value"
                      :options="[
                        {label: 'Normal', value: 'normal'},
                        {label: 'Reverse', value: 'reverse'}
                      ]"
                  />
                </div>

              </div>

            </AwTabContent>
            <AwTabContent tab-id="tab4">
              <div class="style-tab p-2">

                <div class="d-flex align-items-center p-2 w-100">
                  <label class="d-flex align-items-center mr-2 mb-0 w-space-nowrap">
                    <input :disabled="!getSelectedCurveName" :checked="getCurveOptions.curveColor.use" type="checkbox" class="mr-2" name="curveColor"
                           @change="setToggleUsageProperty">
                    <span>Curve color</span>
                  </label>
                  <AwInput :disabled="!getSelectedCurveName" :value="getCurveOptions.curveColor.value" type="color" class="mr-2" prop-name="curveColor"
                         @change="setValueProperty" />
                </div>
                <div class="d-flex align-items-center p-2 w-100">
                  <label class="d-flex align-items-center mr-2 mb-0 w-space-nowrap">
                    <span>Line dash</span>
                  </label>
                  <dropdown
                      :disabled="!getSelectedCurveName"
                      class="w-100"
                      button-text="??????????????"
                      @change="setValueProperty"
                      prop-name="dash"
                      :selectedValue="getCurveOptions.dash.value"
                      :options="getDashLineOptions"
                  />
                </div>

              </div>
            </AwTabContent>
          </AwTab>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Button from "../../components/buttons/Button";
import AwIcon from "../../components/icons/AwIcon"
import AwTree from "../../components/awTree/AwTree";
import AwTab from "../../components/awTab/AwTab";
import AwTabContent from "../../components/awTab/AwTabContent";
import AwInput from "../../components/form/AwInput";
import dropdown from "../../components/dropdowns/dropdown";
import {
  CANVAS_DASH_LINES_TYPES, CURVE_ELEMENT_OPTIONS,
  GET_TREE_CURVES,
  SET_CURVE_OPTIONS,
  SET_SELECTED_WELL_CURVES
} from "../../../../store/modules/geologyGis.const";

export default {
  name: "TableSettings",
  components: {
    AwInput,
    Button,
    AwIcon,
    AwTree,
    AwTab,
    AwTabContent,
    dropdown
  },

  data() {
    return {
      tableSettingsSelected: [],
      tableSettingsOptions: {options: {}},
      gisData: [],
    }
  },
  watch: {
    "$store.state.geologyGis.curveName"() {
      this.updateOptions();
    },
    tableSettingsSelected(val) {
      this.$store.commit(SET_SELECTED_WELL_CURVES, val);
    },
  },
  computed: {
    getSelectedCurveName(){
      return this.$store.state.geologyGis.curveName
    },
    getDashLineOptions() {
      return Object.entries(CANVAS_DASH_LINES_TYPES).map(([label, value]) => ({label, value: value.join(',')}))
    },
    getCurveOptions() {
      let {options: {customParams = {...CURVE_ELEMENT_OPTIONS.customParams}}} = this.tableSettingsOptions;
      return customParams;
    },
    getCurves() {
      return {
        id: 1,
        name: 'Vertical track',
        iconType: 'oilTower',
        iconFill: 'red',
        isOpen: true,
        children: this.$store.getters[GET_TREE_CURVES] || []
      }
    }
  },
  mounted() {
    this.updateOptions();
  },
  methods: {
    setToggleUsageProperty(e) {
      let {checked, name} = e.target;
      this.$store.commit(SET_CURVE_OPTIONS, [name, {use: checked}])
      this.updateOptions()
    },
    setValueProperty(value, e) {
      let name = e.target.getAttribute('prop-name');
      this.$store.commit(SET_CURVE_OPTIONS, [name, {value}])
      this.updateOptions()
    },
    updateOptions() {
      if(this.getSelectedCurveName) this.tableSettingsOptions = this.$store.state.geologyGis.awGis.getElement(this.getSelectedCurveName);
    }
  }
}
</script>

<style scoped lang="scss">
.table-settings {
  background: var(--a-accent-darken-300);

  &__left-panel {
    background: var(--a-accent-400);
    padding: 10px;
  }

  &::v-deep {
    .options-tabs {
      background: var(--a-accent-darken-100);

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

  .tree-wrapper {
    overflow: auto;
    max-height: 380px;
    min-width: 280px;
    background: var(--a-accent-darken-100);

    &::v-deep {
      .AwTreeItem2.aw-tree {
        padding: 16px;
        background-color: transparent;
      }
    }
  }

  .limits-tab {
    padding: 20px;
  }
}
</style>
