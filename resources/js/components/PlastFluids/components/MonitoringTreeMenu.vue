<template>
  <ul class="trees">
    <li v-for="template in templates" :key="template.name" class="has-child">
      <input id="tree-controll1" type="checkbox" checked /><span
        class="tree-control"
      ></span>
      <label>
        <i style="color: #3366FF" class="fa fa-folder light-blue"></i
        >{{ template.name }}
      </label>
      <ul>
        <li v-for="child in template.childNodes" :key="child.id">
          <label>
            <i style="color: #999DC0" class="fa fa-file "></i
            >{{ child["name_" + currentLang] }}
          </label>
        </li>
      </ul>
    </li>
  </ul>
</template>

<script>
export default {
  name: "MonitoringTreeMenu",
  props: {
    templates: Array,
  },
};
</script>

<style></style>
