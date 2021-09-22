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

<style scoped>
label {
  margin: 0;
}

.graphs-and-tables-left-menu {
  width: 100%;
  height: 100%;
  overflow-y: auto;
  color: #fff;
}

.graphs-customization {
  width: 100%;
}

.customization-title {
  display: flex;
  align-items: center;
  background: #323370;
  padding: 6px 10px;
}

.customization-title > p {
  margin: 0;
  font-size: 16px;
}

.customization-title > img {
  width: 18px;
  height: 18px;
  margin-right: 8px;
}

.customization-content {
  padding: 6px;
  display: flex;
  flex-wrap: wrap;
  width: 100%;
}

.customization-content > div {
  margin-bottom: 4px;
}

.customization-content > div:nth-last-child(1),
.customization-content > div:nth-last-child(2) {
  margin-bottom: 0;
}

.customization-content > div:nth-of-type(odd) {
  margin-right: 2px;
}

.customization-content > div:nth-of-type(even) {
  margin-left: 2px;
}

.correlations-holder {
  background: rgba(255, 255, 255, 0.04);
  padding: 6px;
  margin-bottom: 10px;
}

.correlation {
  padding: 8px 6px;
  margin-bottom: 6px;
  background: #363b68;
}

.correlation:last-child {
  margin-bottom: 0;
}

.correlation > p {
  margin: 0 0 6px 4px;
  font-size: 14px;
  color: #fff;
}

.table-customization-inputs-holder {
  width: 100%;
  background: #363b68;
  border: 1px solid #545580;
  padding: 8px 6px;
}

.table-customization-inputs-holder > div {
  width: 100%;
  display: flex;
  align-items: center;
}

.table-customization-inputs-holder > div > input {
  margin-right: 8px;
}

.table-customization-inputs-holder > div > label {
  font-size: 14px;
  color: #fff;
}

::-webkit-scrollbar {
  height: 4px;
  width: 4px;
}

::-webkit-scrollbar-track {
  background: #272953;
}

::-webkit-scrollbar-thumb {
  background: #656a8a;
}
</style>
