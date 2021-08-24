<template>
  <div class="menu_wrapper">
    <div class="sidebar-top d-flex align-items-start w-100">
      <button class="collapse-left__sidebar">
        <Icon name="arrowLeft" />
      </button>
      <div class="dropdown__sidebar w-100">
        <Dropdown
          block
          class="w-100 mb-2"
          button-text="Недропользователь"
          :options="options"
        />
        <Dropdown
          block
          class="w-100 mb-2"
          button-text="Месторождения"
          :options="options"
        />
        <Dropdown
          block
          class="w-100 mb-2"
          button-text="Горизонт"
          :options="options"
        />
      </div>
    </div>
    <div class="sectors">
      <div class="sectors-svg">
        <svg
          width="17"
          height="18"
          viewBox="0 0 17 18"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M5.33671 12.6923V12.5423H5.18671H3.52294V9.15H8.05965V12.5423H6.39588H6.24588V12.6923V17V17.15H6.39588H10.628H10.778V17V12.6923V12.5423H10.628H8.96424V9.15H13.5009V12.5423H11.8372H11.6872V12.6923V17V17.15H11.8372H16.0693H16.2193V17V12.6923V12.5423H16.0693H14.4055V8.38462V8.23462H14.2555H8.96424V5.45769H10.628H10.778V5.30769V1V0.85H10.628H6.39588H6.24588V1V5.30769V5.45769H6.39588H8.05965V8.23462H2.76835H2.61835V8.38462V12.5423H0.95459H0.80459V12.6923V17V17.15H0.95459H5.18671H5.33671V17V12.6923ZM15.3147 13.4577V16.2346H12.5918V13.4577H15.3147ZM7.15047 4.54231V1.76538H9.87341V4.54231H7.15047ZM9.87341 13.4577V16.2346H7.15047V13.4577H9.87341ZM4.43212 16.2346H1.70918V13.4577H4.43212V16.2346Z"
            fill="#3366FF"
            stroke="#3366FF"
            stroke-width="0.3"
          />
        </svg>

        {{ trans("plast_fluids.sections") }}
      </div>
      <div class="tree-box box-border">
        <ul class="trees">
          <MonitoringTreeMenu
            v-for="template in templates"
            :key="template.name"
            :template="template"
          />
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import Dropdown from "../../geology/components/dropdowns/dropdown";
import Button from "../../geology/components/buttons/Button";
import Icon from "../../geology/components/icons/AwIcon";
import MonitoringTreeMenu from "./MonitoringTreeMenu.vue";
import { getDownloadTemplates } from "../services/templateService";
import { convertTemplateData } from "../helpers";

export default {
  name: "MonitoringLeftBlock",
  data() {
    return {
      templates: [],
      options: [
        { label: "option 1", value: 1 },
        { label: "option 2", value: 2 },
        { label: "option 3", value: 3 },
      ],
    };
  },
  methods: {
    async getTemplates() {
      const data = await getDownloadTemplates();
      this.templates = convertTemplateData(data, this.currentLang);
    },
  },
  mounted() {
    this.getTemplates();
  },
  components: {
    Dropdown,
    Button,
    Icon,
    MonitoringTreeMenu,
  },
};
</script>

<style scoped>
.menu_wrapper {
  width: 360px;
  flex-shrink: 0;
  height: 100%;
  background-color: #272953;
  display: flex;
  flex-flow: column;
}

.collapse-left__sidebar {
  border: none;
  background: var(--a-accent);
  padding: 14px 6px;
  border-radius: 0 10px 10px 0;
}

.dropdown__sidebar {
  margin: 10px;
}

.sectors {
  flex-grow: 2;
  overflow-y: auto;
  margin-bottom: 170px;
}

::-webkit-scrollbar {
  width: 5px;
}

::-webkit-scrollbar-track {
  background: #272953;
}

::-webkit-scrollbar-thumb {
  background: #656a8a;
}

.sectors-svg {
  height: 50px;
}

.sectors > div {
  font-size: 16px;
  font-style: normal;
  font-weight: 400;
  line-height: 19px;
  letter-spacing: 0em;
  text-align: left;
  color: white;
  padding-top: 15px;
  padding-left: 15px;
}
.sectors-svg > svg {
  margin-right: 5px;
}

label {
  font-weight: normal;
}

.trees {
  margin-left: 10px;
}
</style>
