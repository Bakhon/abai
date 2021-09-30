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
          :currentGraphic.sync="currentGraphic"
        />
      </div>
    </div>
    <div class="correlations-holder">
      <div
        class="correlation"
        v-for="(correlation, index) in correlationList"
        :key="index"
      >
        <p>{{ correlation.name }}</p>
        <Dropdown
          :placeholder="trans('plast_fluids.choose')"
          :items="correlation.children"
          :selectedValue="getCurrentSelectedCorrelation(index)"
          @dropdown-select="updateCurrentCorrelation(index, ...arguments)"
          dropKey="name"
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

export default {
  name: "GraphsAndTablesLeftMenu",
  components: {
    LeftMenuGraphCustomization,
    Dropdown,
  },
  data() {
    return {
      currentGraphic: "ps_bs_ds_ms",
      currentSelectedCorrelation1: "",
      currentSelectedCorrelation2: "",
      currentSelectedCorrelation3: "",
      currentSelectedCorrelation4: "",
      categoryList: [
        {
          name: "connection_with_rs",
          key: "ps_bs_ds_ms",
          children: ["Ps", "Bos", "Dos", "μ‎os"],
        },
        {
          name: "sampling_time",
          key: "depth_pi_ps",
          children: ["Rs", "Ps", "μ‎o", "po"],
        },
        {
          name: "depth",
          key: "depth_g_vol_rpl_visc_rpl_dso",
          children: ["Ps", "Rs", "Bos", "Dos", "μos", "po", "μ‎o"],
        },
        {
          name: "density_st",
          key: "data_rs_ps_ds",
          children: ["μos", "mod"],
        },
      ],
      correlationList: [
        {
          name: "Корреляция Ps-Rs",
          children: [
            { name: "Al-Marhoun" },
            { name: "Al-Shammasi" },
            { name: "Dindoruk" },
            { name: "Ghetto" },
            { name: "Glaso" },
            { name: "Kartoatmodjo" },
            { name: "Lasater" },
            { name: "Moradi" },
            { name: "Standing" },
            { name: "Valko-McCain" },
            { name: "Vazquez-Beggs" },
            { name: "Velarde" },
          ],
        },
        {
          name: "Корреляция Bs-Rs",
          children: [
            { name: "Al-Marhoun_92" },
            { name: "Almehaideb" },
            { name: "Al-Shammasi" },
            { name: "Dindoruk" },
            { name: "Dokla-Osman" },
            { name: "Glaso" },
            { name: "Kartoatmodjo" },
            { name: "Petrosky" },
            { name: "Standing" },
            { name: "Vazquez-Beggs" },
            { name: "Velarde" },
          ],
        },
        {
          name: "Корреляция ms-Rs",
          children: [
            { name: "Beggs-Robinson" },
            { name: "Chew-Connally" },
            { name: "Labedi" },
            { name: "Kahn et al" },
            { name: "Kartoatmodjo" },
            { name: "Petrosky-Farshad" },
            { name: "Dindoruk" },
          ],
        },
        {
          name: "Модель EOS",
          children: [{ name: "Модель-1" }, { name: "Модель-2" }],
        },
      ],
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
  methods: {
    getCurrentSelectedCorrelation(index) {
      return this["currentSelectedCorrelation" + (index + 1)];
    },
    updateCurrentCorrelation(index, args) {
      this["currentSelectedCorrelation" + (index + 1)] = args.name;
    },
  },
};
</script>

<style scoped lang="scss" src="./LeftMenuStyles.scss"></style>
