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
              <template v-if="filteredSubsoilChildren.length">
                <SubsoilTreeChildren
                  v-for="subsoilChild in filteredSubsoilChildren"
                  :key="subsoilChild.field_id"
                  :subsoil="subsoilChild"
                  :checkedField="checkedField"
                  @clear-checked-field="clearCheckboxArray"
                  @set-checked-field="setCheckedField"
                  :pickedSubsoil="currentSubsoil[0]"
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
import { handleSearch } from "../helpers";
import { getMapOwners } from "../services/mapService";
import { mapState, mapMutations } from "vuex";
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

<style scoped>
#plast-fluids-main {
  display: flex;
  flex-flow: column;
  width: 100%;
  height: 100%;
}

.main-content-holder {
  display: flex;
  width: 100%;
  height: 100%;
}

.map-and-page-footer {
  display: flex;
  flex-flow: column;
  width: 80%;
}

.area-choose-block-and-map-statistics {
  display: flex;
  width: 20%;
  flex-direction: column;
  background: #272953;
  margin-left: 10px;
  padding: 10px;
  height: 100%;
}

.map-statistics {
  display: grid;
  height: 250px;
  row-gap: 10px;
  grid-template-rows: 1fr 1fr;
  grid-template-columns: 1fr 1fr;
}

.statistics-container {
  display: flex;
  flex-flow: column;
  align-items: center;
  justify-content: center;
  background: #1c1f4c;
}

.statistics-container > p {
  margin: 0;
}

.statistics-container > p:first-child {
  font-size: 48px;
  color: #fff;
  font-family: "Harmonia Sans Pro Cyr", sans-serif;
  font-weight: 700;
  line-height: 57.6px;
  margin-bottom: 14px;
}

.statistics-container > p:last-child {
  font-size: 14px;
  color: #fff;
  font-family: "Harmonia Sans Pro Cyr", sans-serif;
  font-weight: 700;
  line-height: 16.8px;
}

.subsoil-user > p {
  color: #fff;
  font-size: 20px;
  margin: 24px 0 14px 8px;
}

.subsoil-search-block {
  position: relative;
  width: 100%;
  height: 35px;
  margin-bottom: 14px;
}

.subsoil-search-block > input {
  width: 100%;
  height: 100%;
  border: 0.5px;
  border-color: #454fa1;
  border-radius: 5px;
  background: #1f2142;
  padding: 10px;
  color: #fff;
  font-size: 16px;
}

::-webkit-scrollbar {
  width: 10px;
}

::-webkit-scrollbar-track {
  background: #272953;
}

::-webkit-scrollbar-thumb {
  background: #656a8a;
}

.subsoil-search-block > button {
  position: absolute;
  right: 8px;
  display: flex;
  align-items: center;
  top: 4px;
  height: 27px;
  padding: 10px;
  border-radius: 4px;
  border: none;
  background: #3366ff;
  color: #fff;
  font-size: 10px;
}

.subsoil-secondary-tree-holder {
  max-height: 130px;
  overflow-y: auto;
  background: #1c1f4c;
}

.subsoil-not-found {
  padding: 15px;
  background: #1c1f4c;
  color: #fff;
}

.subsoil-not-found > p {
  margin: 0;
}

.buttons-wrapper {
  background: #272953;
  display: flex;
  flex-direction: column;
}

.buttons-wrapper button {
  height: 40px;
  background: #333975;
  margin-bottom: 10px;
  font-size: 14px;
  font-style: normal;
  color: #ffffff;
  text-align: center;
  font-family: "Harmonia Sans Pro Cyr", sans-serif;
  font-weight: 700;
  line-height: 16.8px;
  border: none;
}
</style>
