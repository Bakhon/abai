<template>
  <div class="structural-map-settings-modal">
    <div v-click-outside="closeModal">
      <div class="modal-heading">
        <div class="modal-heading-text-image-holder">
          <img src="/img/PlastFluids/mapsAndTablesMapSettingsModal.svg" />
          <p>{{ trans("plast_fluids.settings") }}</p>
        </div>
        <button @click="closeModal">
          <img
            src="/img/PlastFluids/mapsAndTablesModalClose.svg"
            alt="close modal"
          />
        </button>
      </div>
      <div class="modal-content-holder">
        <div class="modal-content">
          <div class="content">
            <input
              type="checkbox"
              name="show isohyps"
              id="show-isohyps"
              v-model="showIsohyps"
            />
            <label for="show-isohyps">{{
              trans("plast_fluids.show_isohyps")
            }}</label>
          </div>
          <div class="content">
            <label for="between-isohyps">{{
              trans("plast_fluids.between_isohyps")
            }}</label>
            <input
              type="text"
              readonly
              name="distance between isohyps"
              id="between-isohyps"
            />
          </div>
          <div class="content">
            <input
              type="checkbox"
              name="show tile layer"
              id="show-tile-layer"
              v-model="showTileLayer"
            />
            <label for="show-tile-layer">{{
              trans("plast_fluids.show_tile_layer")
            }}</label>
          </div>
        </div>
        <div class="modal-buttons">
          <button @click="applyChanges">
            {{ trans("plast_fluids.apply") }}
          </button>
          <button @click="closeModal">
            {{ trans("plast_fluids.cancel") }}
          </button>
        </div>
      </div>
    </div>
    <div class="cover"></div>
  </div>
</template>

<script>
import { mapState, mapMutations } from "vuex";
import { eventBus } from "../../eventBus";

export default {
  name: "StructuralMapSettingsModal",
  data() {
    return {
      showIsohyps: null,
      showTileLayer: null,
    };
  },
  computed: {
    ...mapState("plastFluidsLocal", [
      "depthMultiplier",
      "isIsohypsShown",
      "isTileLayerShown",
    ]),
  },
  methods: {
    ...mapMutations("plastFluidsLocal", [
      "SET_DEPTH_MULTIPLIER",
      "SET_IS_ISOHYPS_SHOWN",
      "SET_IS_TILE_LAYER_SHOWN",
    ]),
    applyChanges() {
      const initialIsohypsShown = this.isIsohypsShown;
      const initialTileLayerShown = this.isTileLayerShown;
      this.SET_IS_ISOHYPS_SHOWN(this.showIsohyps);
      this.SET_IS_TILE_LAYER_SHOWN(this.showTileLayer);
      eventBus.$emit("apply-map-changes", {
        isIsohypsShown:
          initialIsohypsShown === this.isIsohypsShown
            ? "remain"
            : this.isIsohypsShown,
        isTileLayerShown:
          initialTileLayerShown === this.isTileLayerShown
            ? "remain"
            : this.isTileLayerShown,
      });
      this.$emit("close-modal");
    },
    closeModal() {
      this.showIsohyps = this.isIsohypsShown;
      this.showTileLayer = this.isTileLayerShown;
      this.$emit("close-modal");
    },
  },
  mounted() {
    this.showIsohyps = this.isIsohypsShown;
    this.showTileLayer = this.isTileLayerShown;
  },
};
</script>

<style scoped>
label {
  font-size: 14px;
  color: #fff;
  margin: 0;
}

.cover {
  width: 100vw;
  height: 100vh;
  position: fixed;
  z-index: 999;
  top: 0;
  left: 0;
  background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5));
}

.structural-map-settings-modal > div:nth-of-type(1) {
  z-index: inherit;
  position: relative;
}

.structural-map-settings-modal {
  position: absolute;
  top: 32px;
  right: 0;
  z-index: 1000;
}

.modal-heading {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 6px 10px;
  background: #323370;
}

.modal-heading > button {
  background: none;
  border: none;
}

.modal-heading > button > img {
  width: 10px;
  height: 10px;
}

.modal-heading-text-image-holder {
  display: flex;
  align-items: center;
}

.modal-heading-text-image-holder > p {
  margin: 0 0 0 8px;
  font-size: 16px;
  color: #fff;
}

.modal-content-holder {
  background: #2f315a;
  padding: 6px;
}

.modal-content {
  background: #363b68;
  border: 1px solid #545580;
  padding: 8px;
  margin-bottom: 6px;
}

.content {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
}

.content:last-of-type {
  margin-bottom: 0;
}

.content > input[type="checkbox"] {
  margin-right: 10px;
}

.content > input[type="text"] {
  margin-left: 10px;
  background: #1f2142;
  border: 0.5px solid #454fa1;
  border-radius: 4px;
  padding: 3px 8px;
  font-size: 14px;
  color: rgba(255, 255, 255, 0.6);
  width: 110px;
}

.modal-buttons {
  display: flex;
}

.modal-buttons > button {
  border: 0.2px solid #3366ff;
  border-radius: 4px;
  color: #fff;
  font-size: 12px;
  font-weight: 600;
  width: 137px;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 8px 0;
}

.modal-buttons > button:nth-of-type(1) {
  background: #334296;
  margin-right: 4px;
}

.modal-buttons > button:nth-of-type(2) {
  background: #656a8a;
}
</style>
