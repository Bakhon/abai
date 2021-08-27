<template>
  <div class="subsoil-tree">
    <div
      class="subsoil-tree-item"
      v-for="subsoil in treeData"
      :key="subsoil.field_id"
    >
      <div class="subsoil-input-label-holder">
        <input
          type="checkbox"
          :name="subsoil.field_name"
          :id="subsoil.field_name"
          :value="subsoil.field_id"
          v-model="computedPickedSubsoil"
          @click="handleSubsoilCheckbox(subsoil.childNodes)"
        />
        <label :for="subsoil.field_name">{{ subsoil.field_name }}</label>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapMutations } from "vuex";

export default {
  name: "SubsoilTreeMain",
  props: {
    treeData: Array,
  },
  computed: {
    ...mapState("plastFluids", ["pickedSubsoil", "currentSubsoilChildren"]),
    computedPickedSubsoil: {
      get() {
        return this.pickedSubsoil;
      },
      set(value) {
        this.SET_PICKED_SUBSOIL(value[value.length - 1]);
      },
    },
  },
  methods: {
    ...mapMutations("plastFluids", [
      "SET_CURRENT_SUBSOIL_CHILDREN",
      "SET_PICKED_SUBSOIL",
    ]),
    handleSubsoilCheckbox(subsoilChildren) {
      this.SET_CURRENT_SUBSOIL_CHILDREN(subsoilChildren);
    },
  },
};
</script>

<style scoped>
.subsoil-tree {
  border-radius: 4px;
  background: #1c1f4c;
  padding: 14px 9px;
  max-height: 130px;
  overflow-y: auto;
}

.subsoil-tree > p {
  margin: 0;
  color: #fff;
}

.subsoil-tree-item:not(:first-child) {
  margin-top: 20px;
}

.subsoil-input-label-holder > label,
.subsoil-input-label-holder > input {
  cursor: pointer;
}

.subsoil-input-label-holder > label {
  margin-left: 10px;
}

.field-checkbox {
  margin-bottom: 10px;
}

.input {
  margin-top: 15px;
}

.input-bg {
  background-color: #1f2142;
}
</style>
