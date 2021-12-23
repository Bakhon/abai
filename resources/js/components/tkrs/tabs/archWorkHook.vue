<template>
  <li class="has-child">
    <input
      id="tree-controll1"
      type="checkbox"
      
    /><span
      class="tree-control"
      
    ></span>
    <label>
      <i
        style="color: #3366FF; margin-right: 8px;"
        class="fa fa-folder light-blue"
      ></i
      >{{ type === 'year' ? template.year : template.well_name}}
    </label>
    <ul v-if="type === 'year'">
      <archWorkHook
        
      v-for="well in template.wells"
            :key="well.well_name" type="well" :template="well"/>
    </ul>
    <ul v-else>
      <archWorkHookTreeMenuChild
        
      v-for="date in template.date"
            :key="date.date_name" :date="date" :treeChild="template.well_name"/>
    </ul>
  </li>
</template>

<script>
import archWorkHookTreeMenuChild from "./archWorkHookTreeMenuChild.vue";
import archWorkHook from "./archWorkHook.vue";

export default {
  name: "archWorkHook",
  props: {
    template: Object,
    isOpenedTrees: Array,
    type: String
  },
  components: {
    archWorkHookTreeMenuChild,
    archWorkHook
  },
  computed: {
    computedIsOpenedTrees: {
      get() {
        return this.isOpenedTrees;
      },
      set(value) {
        this.$emit("update:isOpenedTrees", value);
      },
    },
  },
};
</script>

<style scoped>
li {
  border-left: dotted 1px #bcbec0;
  padding: 1px 0 1px 25px;
  position: relative;
  list-style: none;
}

li > label {
  position: relative;
  left: -11px;
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

li:last-child:after {
  position: absolute;
  width: 2px;
  height: 13px;
  background: #fff;
  left: -1px;
  bottom: 0px;
}

li input {
  margin-right: 5px;
  margin-left: 5px;
}

li.has-child > ul {
  display: none;
}

li.has-child > input {
  opacity: 0;
  position: absolute;
  left: -14px;
  z-index: 9999;
  width: 22px;
  height: 22px;
}

li.has-child > input + .tree-control {
  position: absolute;
  left: -5px;
  top: 8px;
  width: 8px;
  height: 8px;
  line-height: 8px;
  z-index: 2;
  display: inline-block;
  color: #fff;
  border-radius: 3px;
}

li.has-child > input + .tree-control:after {
  font-family: "FontAwesome";
  content: url(/img/PlastFluids/hideMenuArrow.svg);
  font-size: 8px;
  color: #183955;
  position: absolute;
  left: 1px;
}

.rotate {
  transform: rotate(270deg);
  left: -2px !important;
}

li.has-child > input:checked + .tree-control:after {
  font-family: "FontAwesome";
  content: url(/img/PlastFluids/hideMenuArrow.svg);
  font-size: 8px;
  color: #183955;
  position: absolute;
  left: 1px;
}

li.has-child > input:checked ~ ul {
  display: block;
}

ul li.has-child:last-child {
  border-left: none;
}

ul li.has-child:nth-last-child(2):after {
  content: "";
  width: 1px;
  height: 5px;
  border-left: dotted 1px #bcbec0;
  position: absolute;
  bottom: -5px;
  left: -1px;
}

.rotate {
  transform: rotate(270deg);
}

</style>
