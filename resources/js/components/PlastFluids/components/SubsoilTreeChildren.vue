<template>
  <div class="subsoil-secondary-tree">
    <div v-for="field in treeData" :key="field.field_id">
      <input
        type="checkbox"
        :name="field.field_name"
        :id="field.field_name"
        :value="field"
        v-model="checkedField"
        @click="checkedField = []"
      />
      <label :for="field.field_name">{{ field.field_name }}</label>
      <div
        v-show="checkedField[0].field_name == field.field_name"
        v-if="hasChild"
      >
        <template v-for="horizon in field.horizons">
          <div
            v-if="horizon.horizon_name"
            :key="horizon.horizon_id"
            class="subsoil-horizons"
          >
            <input
              type="checkbox"
              :id="horizon.horizon_name"
              :value="horizon"
              v-model="checkedSubsoilHorizon"
            />
            <label :for="horizon.horizon_name">{{
              horizon.horizon_name
            }}</label>
          </div>
        </template>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from "vuex";

export default {
  name: "SubsoilTreeChildren",
  props: {
    treeData: Array,
  },
  computed: {
    ...mapState("plastFluids", [
      "currentSubsoilField",
      "currentSubsoilHorizon",
    ]),
    checkedField: {
      get() {
        return this.currentSubsoilField;
      },
      set(value) {
        this.UPDATE_CURRENT_SUBSOIL_FIELD(value[value.length - 1]);
      },
    },
    hasChild() {
      return (
        this.checkedField[0]?.horizons && this.checkedField[0]?.horizons.length
      );
    },
    checkedSubsoilHorizon: {
      get() {
        return this.currentSubsoilHorizon;
      },
      set(value) {
        this.SET_CURRENT_SUBSOIL_HORIZON(value);
      },
    },
  },
  methods: {
    ...mapMutations("plastFluids", [
      "SET_CURRENT_SUBSOIL_HORIZON",
      "SET_SUBSOIL_FIELDS",
    ]),
    ...mapActions("plastFluids", ["UPDATE_CURRENT_SUBSOIL_FIELD"]),
  },
  beforeDestroy() {
    this.UPDATE_CURRENT_SUBSOIL_FIELD({});
    this.SET_SUBSOIL_FIELDS([]);
  },
};
</script>

<style scoped>
.subsoil-secondary-tree > div {
  margin: 15px;
}

.subsoil-horizons {
  margin: 10px 10px 10px 15px;
}
</style>
