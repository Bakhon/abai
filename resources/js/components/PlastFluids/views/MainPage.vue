<template>
  <div id="plast-fluids-main">
    <Header />
    <div class="main-content-holder">
      <div class="map-and-page-footer">
        <OilMap />
        <Footer />
      </div>
      <div class="area-choose-block-and-map-statistics">
        <div class="map-statistics">
          <div class="statistics-container">
            <p>
              {{ selectedField ? fieldData[selectedField].field : 0 }}
            </p>
            <p>{{ trans("plast_fluids.wells") }}</p>
          </div>
          <div class="statistics-container">
            <p>
              {{ selectedField ? fieldData[selectedField].deep : 0 }}
            </p>
            <p>
              {{ trans("plast_fluids.deep_samples") }}
            </p>
          </div>
          <div class="statistics-container">
            <p>
              {{ selectedField ? fieldData[selectedField].recombine : 0 }}
            </p>
            <p>{{ trans("plast_fluids.recombined") }}</p>
          </div>
          <div class="statistics-container">
            <p>
              {{ selectedField ? fieldData[selectedField].estuarine : 0 }}
            </p>
            <p>
              {{ trans("plast_fluids.well_head_samples") }}
            </p>
          </div>
        </div>
        <div class="subsoil-user" v-if="subsoilUsers.length">
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
          <template v-if="pickedSubsoil[0]">
            <div class="subsoil-secondary-tree-holder">
              <template v-if="filteredSubsoilChildren.length">
                <SubsoilTreeChildren
                  v-for="subsoilChild in filteredSubsoilChildren"
                  :key="subsoilChild.field_id"
                  :subsoil="subsoilChild"
                  :pickedSubsoil="pickedSubsoil[0]"
                />
              </template>
              <div v-else class="subsoil-not-found">
                <p>{{ trans("plast_fluids.subsoil_not_found") }}</p>
              </div>
            </div>
          </template>
        </div>
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
import { createDataTree, handleSearch } from "../helpers";
import { getMapOwners } from "../services/mapService";
import { mapState } from "vuex";
import SubsoilTreeChildren from "../components/SubsoilTreeChildren.vue";

export default {
  name: "PlastFluidsMain",
  components: {
    Header,
    OilMap,
    Footer,
    SubsoilTreeMain,
    SubsoilTreeChildren,
  },
  data() {
    return {
      subsoilUserSearch: "",
      subsoilChildrenSearch: "",
      subsoilUsers: [],
      selectedField: null,
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
    ...mapState("plastFluids", ["currentSubsoilChildren", "pickedSubsoil"]),
    filteredSubsoilUsers() {
      return handleSearch(this.subsoilUsers, this.subsoilUserSearch);
    },
    filteredSubsoilChildren() {
      return handleSearch(
        this.currentSubsoilChildren,
        this.subsoilChildrenSearch
      );
    },
  },
  methods: {
    async getOwners() {
      const data = await getMapOwners();
      this.subsoilUsers = createDataTree(data);
    },
  },
  mounted() {
    this.getOwners();
    leafMap((e) => {
      if (e.target.feature.properties.type === "field") {
        this.selectedField = e.target.feature.properties.id;
      } else {
        this.selectedField = null;
      }
    });
  },
};
</script>

<style lang="scss" scoped src="./MainPageStyles.scss"></style>
