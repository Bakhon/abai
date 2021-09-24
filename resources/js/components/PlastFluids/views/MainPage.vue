<template>
  <div id="plast-fluids-main">
    <Header />
    <div class="main-content-holder">
      <div class="map-and-page-footer">
        <OilMap />
      </div>
      <div class="area-choose-block-and-map-statistics">
        <div class="map-statistics">
          <div class="statistics-container">
            <p>
              {{ subsoilFieldCounters.wells ? subsoilFieldCounters.wells : 0 }}
            </p>
            <p>{{ trans("plast_fluids.wells") }}</p>
          </div>
          <div class="statistics-container">
            <p>
              {{ subsoilFieldCounters.deep ? subsoilFieldCounters.deep : 0 }}
            </p>
            <p>
              {{ trans("plast_fluids.deep_samples") }}
            </p>
          </div>
          <div class="statistics-container">
            <p>
              {{
                subsoilFieldCounters.recombined
                  ? subsoilFieldCounters.recombined
                  : 0
              }}
            </p>
            <p>{{ trans("plast_fluids.recombined") }}</p>
          </div>
          <div class="statistics-container">
            <p>
              {{
                subsoilFieldCounters.wellhead
                  ? subsoilFieldCounters.wellhead
                  : 0
              }}
            </p>
            <p>
              {{ trans("plast_fluids.well_head_samples") }}
            </p>
          </div>
        </div>
        <div class="subsoil-user" v-if="subsoils.length">
          <p>{{ trans("plast_fluids.subsurface_user") }}</p>
          <div class="subsoil-search-block">
            <input type="text" v-model.trim="subsoilUserSearch" />
            <button>ОК</button>
          </div>
          <SubsoilTreeMain
            v-if="filteredSubsoilUsers.length"
            :treeData="filteredSubsoilUsers"
          />
          <div v-else class="subsoil-not-found">
            <p>{{ trans("plast_fluids.subsoil_not_found") }}</p>
          </div>
          <p>{{ trans("plast_fluids.field") }}</p>
          <div class="subsoil-search-block">
            <input type="text" v-model.trim="subsoilChildrenSearch" />
            <button>ОК</button>
          </div>
          <template v-if="currentSubsoil[0]">
            <div class="subsoil-secondary-tree-holder">
              <SubsoilTreeChildren
                v-if="filteredSubsoilChildren.length"
                :treeData="filteredSubsoilChildren"
              />
              <div v-else class="subsoil-not-found">
                <p>{{ trans("plast_fluids.subsoil_not_found") }}</p>
              </div>
            </div>
          </template>
        </div>
        <SearchForFluids />
      </div>
    </div>
  </div>
</template>

<script>
import leafMap from "../components/leafMap";
import OilMap from "../components/OilMapKz.vue";
import Header from "../components/Header.vue";
import Footer from "../components/Footer.vue";
import SubsoilTreeMain from "../components/SubsoilTreeMain.vue";
import SearchForFluids from "../components/SearchForFluids.vue";
import { handleSearch } from "../helpers";
import { getMapOwners } from "../services/mapService";
import { mapState, mapMutations } from "vuex";
import SubsoilTreeChildren from "../components/SubsoilTreeChildren.vue";

export default {
  name: "PlastFluidsMain",
  components: {
    Header,
    OilMap,
    SubsoilTreeMain,
    SubsoilTreeChildren,
    SearchForFluids,
  },
  data() {
    return {
      subsoilUserSearch: "",
      subsoilChildrenSearch: "",
      selectedField: null,
      checkedField: [],
      fieldData: {
        kozhasai: {
          field: 60,
          deep: 86,
          recombine: 24,
          estuarine: 86,
        },
      },
    };
  },
  computed: {
    ...mapState("plastFluids", [
      "currentSubsoil",
      "subsoils",
      "subsoilFields",
      "subsoilFieldCounters",
    ]),
    filteredSubsoilUsers() {
      return handleSearch(this.subsoils, this.subsoilUserSearch);
    },
    filteredSubsoilChildren() {
      return handleSearch(
        this.subsoilFields,
        this.subsoilChildrenSearch,
        "field"
      );
    },
  },
  methods: {
    ...mapMutations("plastFluids", [
      "SET_SUBSOILS",
      "SET_CURRENT_SUBSOIL_FIELD",
    ]),
    async getOwners() {
      const data = await getMapOwners();
      this.SET_SUBSOILS(data);
    },
    setCheckedField(value) {
      this.checkedField = [value];
      this.SET_CURRENT_SUBSOIL_FIELD(value);
    },
    clearCheckboxArray() {
      this.checkedField = [];
    },
  },
  mounted() {
    this.getOwners();
  },
};
</script>

<style lang="scss" scoped src="./MainPageStyles.scss"></style>
