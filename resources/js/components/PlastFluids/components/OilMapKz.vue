<template>
  <!-- <div id="map"></div> -->
  <div class="main-page-map">
    <div class="map-header">
      <p>Карта размещений нефтегазоносных провинций и областей</p>
      <div class="map-header-toolbar">
        <div class="toolbar-search">
          <div class="input-holder">
            <label for="main-page-map-search"
              ><img
                src="/img/PlastFluids/main-page-search.svg"
                alt="search for provinces"
            /></label>
            <div class="break"></div>
            <input type="text" id="main-page-map-search" placeholder="Поиск" />
          </div>
          <button class="toolbar-search-button">
            Поиск
          </button>
        </div>
        <img src="/img/PlastFluids/box-icon.svg" alt="" />
        <img src="/img/PlastFluids/openModal.svg" alt="open map fullscreen" />
      </div>
    </div>
    <div class="satelite-holder">
      <button v-if="currentScreen > 0" @click="currentScreen--">
        Назад
      </button>
      <button>
        <img src="/img/PlastFluids/satelite.svg" alt="" />
        <span>Спутник</span>
      </button>
    </div>
    <div class="province" v-if="currentScreen === 1">
      <p style="top: 8%; left: 50%;">Северобортовая НГО</p>
      <p style="top: 40%; left: 30%;">Центрально-Каспийская НГО</p>
      <p style="top: 40%; right: 10%;">
        Восточно-Эмбинская НГО
      </p>
      <p style="top: 55%; right: 25%;">Северо-Эмбинская НГО</p>
      <p style="top: 70%; left: 33%;">Астрахань-Макатская НГО</p>
      <p style="top: 80%; right: 20%;">Южно-Эмбинская НГО</p>
      <p style="top: 88%; left: 55%;">Приморско-Эмбинская НГО</p>
      <img
        @click="currentScreen = 2"
        src="/img/PlastFluids/MaskGroup.svg"
        alt=""
      />
    </div>
    <img
      src="/img/PlastFluids/presentation3d.jpg"
      v-else-if="currentScreen === 2"
      @click="setSubsoilField"
      style="flex: 2 1 auto; margin: 14px 10px 10px 10px; width: unset; height: unset;"
      alt=""
    />
    <img
      @click="currentScreen = 1"
      v-else
      src="/img/PlastFluids/map.svg"
      alt=""
    />
  </div>
</template>

<script>
import { mapActions, mapState } from "vuex";

export default {
  name: "OilMapKz",
  data() {
    return {
      map: null,
      province: undefined,
      currentProvince: undefined,
      currentScreen: 0,
    };
  },
  computed: {
    ...mapState("plastFluids", ["subsoils", "subsoilFields"]),
  },
  methods: {
    ...mapActions("plastFluids", [
      "UPDATE_CURRENT_SUBSOIL",
      "UPDATE_CURRENT_SUBSOIL_FIELD",
      "GET_SUBSOIL_FIELD_COUNTERS",
    ]),
    setSubsoilField() {
      const foundSubsoil = this.subsoils.find(
        (subsoil) => subsoil.owner_short_name === "КОА"
      );
      this.UPDATE_CURRENT_SUBSOIL(foundSubsoil).then((res) => {
        const foundField = this.subsoilFields.find(
          (field) => field.field_name === "Кожасай"
        );
        this.UPDATE_CURRENT_SUBSOIL_FIELD(foundField).then(() =>
          this.GET_SUBSOIL_FIELD_COUNTERS()
        );
      });
    },
  },
};
</script>

<style lang="scss" scoped src="./OilMapKzStyles.scss"></style>
