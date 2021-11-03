<template>
  <li
      :class="{'active': isShowChildren}"
      class="asside-db-list__item asside-db-list__item-parent"
  >
    <span v-if="!isWell(node)" class="cursor-pointer" @click="showChildren()"></span>
    <span :class="isWell(node) ? 'asside-db-link-file' : 'asside-db-link-parent'" v-html="node.name"></span>
    <ul v-if="isShowChildren">
      <node
          v-for="(child, index) in node.children"
          :key="`${index}-${child.id}-${node.id}`"
          :currentWellId="currentWellId"
          :get-initial-items="getInitialItems"
          :get-wells="getWells"
          :handle-click="handleClick"
          :isCheckedCheckbox="isCheckedCheckbox"
          :isNodeOnBottomLevelOfHierarchy="isNodeOnBottomLevelOfHierarchy"
          :isShowCheckboxes="isShowCheckboxes"
          :isWell="isWell"
          :level="level+1"
          :node="child"
          :nodeClickOnArrow="nodeClickOnArrow"
          :onClick="onClick"
          :parent="node"
          :renderComponent="renderComponent"
          :updateThisComponent="updateThisComponent"
      ></node>
      <li v-if="isShowChildren && isLoading" class="centered mx-auto mt-3">
        <div class="blob-1"></div>
        <div class="blob-2"></div>
      </li>
    </ul>
  </li>
</template>
<script>
import treeview from "../common/mixins/treeview";

export default {
  name: "node",
  mixins: [treeview]
}
</script>
<style lang="scss" scoped>
.centered {
  width: 40px;
  height: 11px;
  transform: translate(-50%, -50%);
  filter: contrast(20);
}

.blob-1, .blob-2 {
  width: 10px;
  height: 10px;
  position: absolute;
  border-radius: 50%;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.blob-1 {
  left: 20%;
  background: #fff;
  animation: osc-l 2.5s ease infinite;
}

.blob-2 {
  width: 11px;
  height: 11px;
  left: 80%;
  animation: osc-r 2.5s ease infinite;
  background: rgb(51, 102, 255);
}

@keyframes osc-l {
  0% {
    left: 20%;
  }
  50% {
    left: 50%;
  }
  100% {
    left: 20%;
  }
}

@keyframes osc-r {
  0% {
    left: 80%;
  }
  50% {
    left: 50%;
  }
  100% {
    left: 80%;
  }
}
</style>