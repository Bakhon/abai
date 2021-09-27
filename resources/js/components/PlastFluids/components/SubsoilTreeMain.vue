<template>
  <div class="subsoil-tree">
    <div
      class="subsoil-tree-item"
      v-for="subsoil in treeData"
      :key="subsoil.owner_id"
    >
      <div class="subsoil-input-label-holder">
        <input
          type="checkbox"
          :name="subsoil.owner_name"
          :id="subsoil.owner_name"
          :value="subsoil"
          v-model="pickedSubsoil"
          @click="clearArray"
        />
        <label :for="subsoil.owner_name">{{ subsoil.owner_name }}</label>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions } from "vuex";

export default {
  name: "SubsoilTreeMain",
  props: {
    treeData: Array,
  },
  computed: {
    ...mapState("plastFluids", ["currentSubsoil"]),
    pickedSubsoil: {
      get() {
        return this.currentSubsoil;
      },
      set(value) {
        this.UPDATE_CURRENT_SUBSOIL(value[value.length - 1]);
      },
    },
  },
  methods: {
    ...mapActions("plastFluids", ["UPDATE_CURRENT_SUBSOIL"]),
    clearArray() {
      this.pickedSubsoil = [];
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
</style>
