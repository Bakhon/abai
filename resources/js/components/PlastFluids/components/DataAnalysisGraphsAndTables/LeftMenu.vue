<template>
  <div class="graphs-and-tables-left-menu">
    <div class="graphs-customization">
      <div class="customization-title">
        <img
          src="/img/PlastFluids/graphsCustomization.svg"
          alt="graphs customization"
        />
        <p>{{ trans("plast_fluids.graphs_settings") }}</p>
      </div>
      <div class="customization-content">
        <LeftMenuGraphCustomization
          v-for="category in categoryList"
          :key="category.key"
          :categoryName="category.name"
          :valueKey="category.key"
          :children="category.children"
          :currentGraphicType.sync="currentGraphicType"
          :currentGraphics.sync="computedCurrentGraphics"
        />
        <div class="customization-category">
          <LeftMenuGraphCustomization
            categoryName="temperature"
            valueKey="temperature"
            :children="[
              { key: 'Ms', Label: 'μos' },
              { key: 'Mod', Label: 'mod' },
              { key: 'Ds', Label: 'Ds' },
            ]"
            :currentGraphicType.sync="currentGraphicType"
            :currentGraphics.sync="computedCurrentGraphics"
          />
          <LeftMenuGraphCustomization
            categoryName="density_st"
            valueKey="density"
            :children="[
              { key: 'Mod', Label: 'mod' },
              { key: 'Mo', Label: 'Mo' },
            ]"
            :currentGraphicType.sync="currentGraphicType"
            :currentGraphics.sync="computedCurrentGraphics"
          />
        </div>
      </div>
    </div>
    <div class="correlations-holder">
      <div
        class="correlation"
        v-for="(correlations, key) in correlationList"
        :key="key"
      >
        <p>{{ trans(`plast_fluids.correlation_${key}`) }}</p>
        <Dropdown
          :selectedValue="getCurrentSelectedCorrelation(key).name"
          @dropdown-select="updateCurrentCorrelation(key, ...arguments)"
          :placeholder="trans('plast_fluids.choose')"
          :items="correlations"
          :dropKey="['name']"
        />
      </div>
    </div>
    <div class="table-customization">
      <div class="customization-title">
        <img
          src="/img/PlastFluids/tableCustomization.svg"
          alt="table customization"
        />
        <p>{{ trans("plast_fluids.table_settings") }}</p>
      </div>
      <div class="customization-content">
        <div class="table-customization-inputs-holder">
          <div
            v-for="option in tableCustomizationOptions"
            :key="option.labelKey"
          >
            <input type="checkbox" :id="option.labelKey" /><label
              :for="option.labelKey"
              >{{ trans("plast_fluids." + option.name) }}</label
            >
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import LeftMenuGraphCustomization from "./LeftMenuGraphCustomization.vue";
import Dropdown from "../Dropdown.vue";
import { getCorrelations } from "../../services/graphService";
import { mapState, mapMutations, mapActions } from "vuex";

export default {
  name: "GraphsAndTablesLeftMenu",
  components: {
    LeftMenuGraphCustomization,
    Dropdown,
  },
  data() {
    return {
      currentSelectedCorrelation4: "",
      categoryList: [
        {
          name: "connection_with_rs",
          key: "ps_bs_ds_ms",
          children: [
            { key: "Ps", Label: "Ps" },
            { key: "Bs", Label: "Bos" },
            { key: "Ds", Label: "Dos" },
            { key: "Ms", Label: "μos" },
          ],
        },
        {
          name: "sampling_time",
          key: "data_rs_ps_ds",
          children: [
            { key: "Rs", Label: "Rs" },
            { key: "Ps", Label: "Ps" },
            { key: "Mo", Label: "μo" },
            { key: "Ds", Label: "po" },
          ],
        },
        {
          name: "depth",
          key: "all_depth",
          children: [
            { key: "pi_ps", Label: "Ps" },
            { key: "Rs", Label: "Rs" },
            { key: "volume_coefficient", Label: "Bo" },
            { key: "Do", Label: "Do" },
            { key: "viscosity_reservoir_oil", Label: "mo" },
            { key: "density_separated_oil", Label: "po" },
            { key: "Mod", Label: "mod" },
          ],
        },
      ],
      correlationList: {},
      tableCustomizationOptions: [
        {
          name: "properties",
          labelKey: "analyze-graphs-table-page-tableproperty",
        },
        {
          name: "sample_selection",
          labelKey: "analyze-graphs-table-page-table-sample-selection",
        },
        {
          name: "custom",
          labelKey: "analyze-graphs-table-page-table-custom",
        },
      ],
    };
  },
  computed: {
    ...mapState("plastFluids", [
      "currentSubsoilField",
      "currentSubsoilHorizon",
    ]),
    ...mapState("plastFluidsLocal", [
      "graphType",
      "currentGraphics",
      "currentSelectedCorrelation_ps",
      "currentSelectedCorrelation_bs",
      "currentSelectedCorrelation_ms",
    ]),
    currentGraphicType: {
      get() {
        return this.graphType;
      },
      set(value) {
        this.SET_GRAPH_TYPE(value);
        if (this.currentSubsoilField[0])
          this.handleAnalysisTableData({
            field_id: this.currentSubsoilField[0].field_id,
            postUrl: "analytics/pvt-data-analysis",
          });
        this.SET_CURRENT_GRAPHICS(this.setInitialGraphics(value));
      },
    },
    computedCurrentGraphics: {
      get() {
        return this.currentGraphics;
      },
      set(value) {
        this.SET_CURRENT_GRAPHICS(value);
      },
    },
  },
  methods: {
    ...mapActions("plastFluidsLocal", ["handleAnalysisTableData"]),
    ...mapMutations("plastFluidsLocal", [
      "SET_GRAPH_TYPE",
      "SET_CURRENT_GRAPHICS",
      "SET_CURRENT_CORRELATION_PS",
      "SET_CURRENT_CORRELATION_BS",
      "SET_CURRENT_CORRELATION_MS",
    ]),
    setInitialGraphics(graphType) {
      return graphType === "ps_bs_ds_ms"
        ? ["Ps", "Bs", "Ds", "Ms"]
        : graphType === "all_depth"
        ? [
            "pi_ps",
            "volume_coefficient",
            "viscosity_reservoir_oil",
            "density_separated_oil",
          ]
        : ["Ds", "Ps", "Rs"];
    },
    getCurrentSelectedCorrelation(key) {
      return this["currentSelectedCorrelation_" + key];
    },
    async updateCurrentCorrelation(key, args) {
      this["SET_CURRENT_CORRELATION_" + key.toUpperCase()](args);
    },
    async getCorrelationList() {
      const correlations = await getCorrelations();
      for (let key in correlations) {
        let correlationChildren = correlations[key].map(
          (correlationFunction) => {
            const entry = Object.entries(correlationFunction)[0];
            return { func_id: entry[0], name: entry[1] };
          }
        );
        correlations[key] = correlationChildren;
      }
      this.correlationList = correlations;
    },
  },
  mounted() {
    this.getCorrelationList();
  },
};
</script>

<style scoped lang="scss" src="./LeftMenuStyles.scss"></style>
