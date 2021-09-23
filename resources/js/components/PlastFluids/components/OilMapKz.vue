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
};
</script>

<style lang="scss" scoped>
label {
  margin: 0;
}

#map,
.main-page-map {
  height: 100%;
  width: 100%;
  background: #2b2e5e;
  display: flex;
  flex-flow: column;
  justify-content: space-between;
  align-items: center;
}

.main-page-map > img {
  width: 85%;
  height: 90%;
  cursor: pointer;
}

.province {
  background-image: url("/img/PlastFluids/province.svg");
  background-repeat: no-repeat;
  background-position: center;
  position: relative;
  width: 85%;
  height: 90%;
  cursor: pointer;
}

.province > img {
  width: 103%;
  height: 100%;
  position: absolute;
  right: 0%;
  top: 0%;
}

.province > p {
  margin: 0;
  text-shadow: 0px 0px 8px rgba(0, 0, 0, 0.1);
  font-size: 18px;
  color: #ffffff;
  position: absolute;
  z-index: 2;
}

.map-header {
  padding: 6px 12px;
  width: 100%;
  display: flex;
  justify-content: space-between;
  background-color: #333975;
}

.map-header > p {
  font-size: 16px;
  color: #fff;
  font-weight: 700;
  margin: 6px 0 6px 6px;
}

.map-header-toolbar {
  display: flex;
  align-items: center;
}

.map-header-toolbar > img:nth-of-type(1) {
  margin-right: 14px;
}

.map-header-toolbar > img:nth-of-type(2) {
  margin-right: 2px;
  width: 16px;
  height: 16px;
}

.toolbar-search {
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-radius: 4px;
  padding: 4px;
  background-color: #272953;
  min-width: 280px;
  margin-right: 14px;
}

.input-holder {
  display: flex;
}

.input-holder > label > img {
  width: 20px;
  height: 20px;
}

.input-holder > input:focus {
  outline: none;
}

.input-holder > input {
  background: none;
  border: none;
  color: #fff;
}

.break {
  margin: 0 8px 0 4px;
  width: 0.3px;
  height: 16px;
  background-color: #42487d;
}

.toolbar-search-button {
  padding: 4px 7px;
  font-weight: 600;
  font-size: 14px;
  letter-spacing: 1px;
  color: #fff;
  background-color: #3366ff;
  border-radius: 2px;
  border: none;
  align-self: flex-end;
}

.satelite-holder {
  margin-top: 10px;
  padding: 0 10px;
  display: flex;
  width: 100%;
  height: 36px;
  align-items: center;
  justify-content: flex-start;
}

.satelite-holder > button:nth-of-type(1) {
  border: none;
  background: #656a8a;
  font-weight: 700;
  color: #fff;
  font-size: 17px;
  border-radius: 12px;
  padding: 5px 20px;
  margin-right: 18px;
}

.satelite-holder > button:nth-of-type(2) {
  border: none;
  background: none;
  display: flex;
  align-items: center;
}

.satelite-holder > button:nth-of-type(2) > span {
  font-weight: 700;
  color: #fff;
  font-size: 16px;
  opacity: 0.5;
  margin-left: 8px;
}

#map::v-deep .leaflet-tooltip.my-label {
  background: transparent;
  border: none;
  box-shadow: none;
  font-size: 14px;
  color: #a1a3bc;
}
</style>
