<template>
  <div class="subsoil-secondary-tree">
    <div v-show="pickedSubsoil">
      <input
        type="checkbox"
        :name="subsoil.field_name"
        :id="subsoil.field_name"
        :value="subsoil"
        v-model="computedCheckedField"
        @click="$emit('clear-checked-field')"
      />
      <label :for="subsoil.field_name">{{ subsoil.field_name }}</label>
    </div>

    <div
      v-show="checkedField[0].field_name == subsoil.field_name"
      v-if="hasChild"
      class="subsoil-secondary-tree"
    >
      <div
        v-for="horizon in checkedField[0].horizons"
        :key="horizon.horizon_id"
      >
        <input
          type="radio"
          :name="horizon.horizon_name"
          :id="horizon.horizon_name"
          :value="horizon"
          v-model="pickedSubsoilHorizon"
        />
        <label :for="horizon.horizon_name">{{ horizon.horizon_name }}</label>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapMutations } from "vuex";
import _ from "lodash";

export default {
  name: "SubsoilTreeChildren",
  props: {
    checkedField: Array,
    subsoil: Object,
    pickedSubsoil: Object,
  },
  computed: {
    ...mapState("plastFluids", [
      "currentSubsoilField",
      "currentSubsoilHorizon",
    ]),
    hasChild() {
      return (
        this.checkedField[0]?.horizons && this.checkedField[0]?.horizons.length
      );
    },
    computedCheckedField: {
      get() {
        return this.checkedField;
      },
      set(value) {
        this.$emit("set-checked-field", value[value.length - 1]);
        this.SET_CURRENT_SUBSOIL_HORIZON("");
      },
    },
    pickedSubsoilHorizon: {
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
      "SET_CURRENT_SUBSOIL_FIELD",
    ]),
  },
  beforeDestroy() {
    this.SET_CURRENT_SUBSOIL_FIELD("");
  },
  mounted() {
    this.computedCheckedField = _.cloneDeep(this.currentSubsoilField) ?? "";
  },
};
</script>

<style scoped>
.subsoil-secondary-tree {
  margin: 15px;
}
</style>
