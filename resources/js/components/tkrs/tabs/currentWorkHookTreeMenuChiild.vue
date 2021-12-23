<template>
  <li
  @click="handleTableAndGraph"
  >
    <label>
      <i style="color: #999DC0; margin-right: 8px;" class="fa fa-file "></i
      >{{ date.field_name }}
    </label>
    <img
      v-if="type === 'download'"
      v-show="hovered"
      class="download-icon"
      src="/img/PlastFluids/data_upload.svg"
      alt="download template"
    />
  </li>
</template>

<script>
import { mapActions } from "vuex";

export default {
  name: "currentWorkHookTreeMenuChiild",
  props: {
    treeChild: String,
    date: Object,
  },
  data() {
    return {
      hovered: false,
    };
  },
  
  computed: {
  },
  methods: {
    ...mapActions("tkrs", ["getTableWork", "getSelectedtWellFile"]),
    handleTableAndGraph() {
      this.getTableWork({ well_name: this.treeChild, well_date: this.date.field_name });
      this.getSelectedtWellFile({ well_name_chart: this.treeChild, well_date_chart: this.date.field_name });
    },
    postSelectedtWellFileChild(well_name, well_date) {
      this.$emit('post_method', {well_name, well_date})
    },
  },
};
</script>

<style scoped>
.download-icon {
  position: absolute;
  right: 20px;
  top: 4px;
  width: 14px;
  height: 15px;
}

li:last-child:after {
  position: absolute;
  width: 2px;
  height: 13px;
  background: #fff;
  left: -1px;
  bottom: 0px;
}

li:before {
  content: "";
  width: 13px;
  height: 1px;
  border-bottom: dotted 1px #bcbec0;
  position: absolute;
  top: 10px;
  left: 0;
}

li,
label {
  cursor: pointer;
}

li > label {
  margin-right: 34px;
  position: relative;
  left: -11px;
}

li {
  border-left: dotted 1px #bcbec0;
  padding: 1px 0 1px 25px;
  position: relative;
  list-style: none;
}
</style>
