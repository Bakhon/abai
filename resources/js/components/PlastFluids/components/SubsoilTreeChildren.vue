<template>
  <div class="subsoil-secondary-tree">
    <div
      class="subsoil-input-label-holder"
      v-show="pickedSubsoil == subsoil.owner_id"
    >
      <input
        v-if="hasChild"
        type="checkbox"
        name="subsoil-checkbox"
        :id="subsoil.field_id"
        :value="subsoil.field_id"
        v-model="checkedSubsoilChild"
        @click="clearCheckboxArray"
      />
      <input
        v-else
        type="radio"
        name="subsoil-checkbox"
        :id="subsoil.field_id"
        :value="subsoil.field_id"
        v-model="pickedSubsoilChild"
      />
      <label :for="subsoil.field_name">{{ subsoil.field_name }}</label>
    </div>

    <div v-show="pickedSubsoil" v-if="hasChild">
      <SubsoilTreeChildren
        v-for="child in subsoil.childNodes"
        :key="child.field_id"
        :subsoil="child"
        :pickedSubsoil="hasChild ? checkedSubsoilChild[0] : pickedSubsoilChild"
      ></SubsoilTreeChildren>
    </div>
  </div>
</template>

<script>
import { mapState, mapMutations } from "vuex";

export default {
  name: "SubsoilTreeChildren",
  props: ["subsoil", "pickedSubsoil"],
  data() {
    return {
      checkedSubsoilChild: [],
    };
  },
  computed: {
    ...mapState("plastFluids", ["pickedSubsoilChildRadio"]),
    hasChild() {
      return this.subsoil.childNodes && this.subsoil.childNodes.length;
    },
    pickedSubsoilChild: {
      get() {
        return this.pickedSubsoilChildRadio;
      },
      set(value) {
        this.SET_PICKED_SUBSOIL_CHILD_RADIO(value);
      },
    },
  },
  methods: {
    ...mapMutations("plastFluids", ["SET_PICKED_SUBSOIL_CHILD_RADIO"]),
    clearCheckboxArray() {
      this.checkedSubsoilChild = [];
    },
  },
  beforeDestroy() {
    this.SET_PICKED_SUBSOIL_CHILD_RADIO("");
  },
};
</script>

<style>
.subsoil-secondary-tree {
  margin: 15px;
}
</style>
