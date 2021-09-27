<template>
  <li
    @mouseover="hovered = true"
    @mouseleave="hovered = false"
    @click="type === 'download' ? handleTemplateDownload() : setTableData()"
  >
    <label>
      <i style="color: #999DC0; margin-right: 8px;" class="fa fa-file "></i
      >{{ treeChild["name_" + currentLang] }}
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
import { downloadTemplate } from "../services/templateService";
import { mapState, mapMutations, mapActions } from "vuex";

export default {
  name: "MonitoringTreeMenuChild",
  props: {
    treeChild: Object,
  },
  data() {
    return {
      hovered: false,
    };
  },
  inject: {
    type: {
      default: "",
    },
  },
  computed: {
    ...mapState("plastFluids", ["currentSubsoilField"]),
  },
  methods: {
    ...mapMutations("plastFluidsLocal", [
      "SET_CURRENT_TEMPLATE",
      "SET_TABLE_FIELDS",
      "SET_TABLE_ROWS",
    ]),
    ...mapActions("plastFluidsLocal", ["handleTableData"]),
    async handleTemplateDownload() {
      const data = new FormData();
      data.append("template_id", this.treeChild.id);
      const template = await downloadTemplate(data);
      let link = document.createElement("a");

      link.download = this.treeChild["name_" + this.currentLang];
      const blob = new Blob([template.data], {
        type: "application/vnd.ms-excel",
      });

      link.href = URL.createObjectURL(blob);
      link.click();
    },
    setTableData() {
      this.SET_CURRENT_TEMPLATE(this.treeChild);
      this.handleTableData({ field_id: this.currentSubsoilField[0].field_id });
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
