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
import { downloadExcelFile } from "../helpers";

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
    userID: {
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
      downloadExcelFile(
        this.treeChild["name_" + this.currentLang],
        template.data
      );
    },
    setTableData() {
      if (this.currentSubsoilField[0])
        this.handleTableData({
          report_id: this.treeChild.id,
          user_id: this.userID,
          template: this.treeChild,
          type: "upload",
        });
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
