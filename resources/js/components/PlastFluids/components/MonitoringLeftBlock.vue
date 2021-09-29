<template>
  <div class="menu_wrapper" :class="{ narrow: collapsed }">
    <div class="sidebar-top d-flex align-items-start w-100">
      <button @click="collapsed = !collapsed" class="collapse-left__sidebar">
        <Icon class="smooth" :class="{ swap: collapsed }" name="arrowLeft" />
      </button>
      <div v-show="!collapsed" class="dropdown__sidebar w-100">
        <Dropdown
          :items="subsoils"
          :placeholder="trans('plast_fluids.subsurface_user')"
          :selectedValue="currentSubsoil[0] ? currentSubsoil[0].owner_name : ''"
          dropKey="owner_name"
          @dropdown-select="updateCurrentSubsoil"
        />
        <Dropdown
          :items="subsoilFields"
          :placeholder="trans('plast_fluids.field')"
          :selectedValue="
            currentSubsoilField[0] ? currentSubsoilField[0].field_name : ''
          "
          dropKey="field_name"
          :parentShortName="
            currentSubsoil[0] ? currentSubsoil[0].owner_short_name : ''
          "
          @dropdown-select="updateCurrentSubsoilField"
        />
      </div>
    </div>
    <div class="sectors">
      <div v-show="!collapsed" class="sectors-svg">
        <img src="/img/PlastFluids/sectors.svg" />
        {{ trans("plast_fluids.sections") }}
      </div>
      <div v-show="!collapsed" class="tree-box box-border">
        <ul class="trees">
          <MonitoringTreeMenu
            v-for="template in templates"
            :key="template.name"
            :template="template"
          />
        </ul>
      </div>
    </div>
    <p v-show="collapsed" class="vertical-text">{{ trans("plast_fluids.choose_section") }}</p>
  </div>
</template>

<script>
import Dropdown from "./Dropdown.vue";
import Icon from "../../geology/components/icons/AwIcon";
import MonitoringTreeMenu from "./MonitoringTreeMenu.vue";
import { mapState, mapMutations, mapActions } from "vuex";

export default {
  name: "MonitoringLeftBlock",
  props: {
    templates: Array,
  },
  data() {
    return {
      collapsed: false,
    };
  },
  computed: {
    ...mapState("plastFluids", [
      "subsoils",
      "subsoilFields",
      "currentSubsoil",
      "currentSubsoilField",
      "subsoilHorizons",
    ]),
  },
  methods: {
    ...mapActions("plastFluids", [
      "UPDATE_CURRENT_SUBSOIL",
      "UPDATE_CURRENT_SUBSOIL_FIELD",
    ]),
    ...mapActions("plastFluidsLocal", ["handleTableData"]),
    updateCurrentSubsoil(value) {
      this.UPDATE_CURRENT_SUBSOIL(value);
    },
    updateCurrentSubsoilField(value) {
      this.UPDATE_CURRENT_SUBSOIL_FIELD(value);
      this.handleTableData({ field_id: value.field_id });
    },
  },
  components: {
    Dropdown,
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
  transition: 0.3s ease;
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
  margin-bottom: 15px;
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

.smooth {
  transition: 0.3s ease;
}

.swap {
  transform: rotate(180deg);
}

.narrow {
  width: 30px;
  justify-content: center;
  position: relative;
}

.vertical-text {
  position: absolute;
  transition: 0.3s ease-in-out;
  top: 50%;
  writing-mode: vertical-rl;
  transform: rotate(180deg);
  margin: 0;
  font-size: 16px;
  color: #fff;
}
</style>
