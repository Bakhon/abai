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
            <div class="between-isohyps-input-holder">
              <SettingsModalDepthMultiplierButton
                content="--"
                :disable="betweenIsohyps - 100 < 10 || !currentModel.id"
                :accumulator="-100"
                @update-multiplier="updateMultiplier"
              />
              <SettingsModalDepthMultiplierButton
                content="-"
                :disable="betweenIsohyps - 10 < 10 || !currentModel.id"
                :accumulator="-10"
                @update-multiplier="updateMultiplier"
              />
              <input
                type="text"
                readonly
                :value="betweenIsohyps"
                name="distance between isohyps"
                id="between-isohyps"
              />
              <span>м.</span>
              <SettingsModalDepthMultiplierButton
                content="+"
                :disable="
                  betweenIsohyps + 10 > maxDepthMultiplier || !currentModel.id
                "
                :accumulator="10"
                @update-multiplier="updateMultiplier"
              />
              <SettingsModalDepthMultiplierButton
                content="++"
                :disable="
                  betweenIsohyps + 100 > maxDepthMultiplier || !currentModel.id
                "
                :accumulator="100"
                @update-multiplier="updateMultiplier"
              />
            </div>
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
import SettingsModalDepthMultiplierButton from "./SettingsModalDepthMultiplierButton.vue";

export default {
  name: "StructuralMapSettingsModal",
  components: {
    SettingsModalDepthMultiplierButton,
  },
  data() {
    return {
      showIsohyps: null,
      showTileLayer: null,
      betweenIsohyps: 0,
    };
  },
  computed: {
    ...mapState("plastFluidsLocal", [
      "depthMultiplier",
      "maxDepthMultiplier",
      "isIsohypsShown",
      "isTileLayerShown",
      "currentModel",
    ]),
  },
  methods: {
    ...mapMutations("plastFluidsLocal", [
      "SET_DEPTH_MULTIPLIER",
      "SET_IS_ISOHYPS_SHOWN",
      "SET_IS_TILE_LAYER_SHOWN",
    ]),
    updateMultiplier(acc) {
      this.betweenIsohyps += acc;
    },
    applyChanges() {
      const initialTileLayerShown = this.isTileLayerShown;
      const initialDepthMultiplier = this.depthMultiplier;
      this.SET_IS_ISOHYPS_SHOWN(this.showIsohyps);
      this.SET_IS_TILE_LAYER_SHOWN(this.showTileLayer);
      this.SET_DEPTH_MULTIPLIER(this.betweenIsohyps / 10);
      eventBus.$emit("apply-map-changes", {
        isTileLayerShown:
          initialTileLayerShown === this.isTileLayerShown
            ? "remain"
            : this.isTileLayerShown,
        depthMultiplier:
          initialDepthMultiplier === this.depthMultiplier
            ? "remain"
            : this.depthMultiplier,
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
    this.betweenIsohyps = this.depthMultiplier * 10;
  },
};
</script>

<style lang="scss" src="./StructuralMapSettingsModalStyles.scss" scoped></style>
