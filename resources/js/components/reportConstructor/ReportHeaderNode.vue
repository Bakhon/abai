<template>
  <div class="cmp-tree">
    <div class="cmp-node" @click="isOpen = !isOpen">
      <label>
        <input name="checkbox" type="checkbox" @click.stop="handleChange" :value="headerNode.isChecked"
        /></label>
      {{ translateAttribute(headerNode.label) }}
      <div
          v-if="hasChildren"
          class="arrow-right"
          :class="{ 'arrow-active': isOpen }"
      ></div>
    </div>
    <ul class="hierarchy" v-if="isOpen">
      <draggable
          :headerNode="headerNode.children"
          ghost-class="ghost"
          @input="updateNode"
          :group="group"
          tag="ul"
          v-bind="dragOptions"
          @start="isDraggable = true"
          @end="isDraggable = false"
      >
        <ReportHeaderNode
            v-for="(item, index) in headerNode.children"
            :key="index"
            :headerNode="item"
            :translateAttribute="translateAttribute"
            @input="updateChildNode"
            :group="group"
            :rowKey="rowKey"
        >
          <span>{{ translateAttribute(item.label) }}</span>
        </ReportHeaderNode>
      </draggable>
    </ul>
  </div>
</template>

<script>
import Draggable from "vuedraggable";

export default {
  name: "ReportHeaderNode",
  components: {
    Draggable,
  },
  props: {
    headerNode: {
      type: Object,
      default: () => ({
        id: 0,
        name: "",
        children: [],
        isChecked: false
      }),
    },
    root: {
      type: Boolean,
      default: () => false,
    },
    group: {
      type: String,
      default: null,
    },
    rowKey: {
      type: String,
      default: "label",
    },
    translateAttribute: Function,
  },
  data() {
    return {
      isOpen: false,
      isDraggable: false,
      localValue: Object.assign({}, this.headerNode),
    };
  },
  computed: {
    hasChildren() {
      return this.headerNode.children != null && this.headerNode.children.length > 0;
    },
    isDark() {
      return "";
    },
    hasDefaultSlot() {
      return this.$scopedSlots.hasOwnProperty("body");
    },
    dragOptions() {
      return {
        animation: 200,
        group: "description",
        disabled: false,
        ghostClass: "ghost",
      };
    },
  },
  watch: {
    headerNode(headerNode) {
      this.localValue = Object.assign({}, headerNode);
    },
  },
  methods: {
    updateNode(headerNode) {
      if (headerNode.constructor == Array) {
        this.localValue.children = [...headerNode];
        this.$emit("input", this.localValue);
      }
    },
    updateChildNode(headerNode) {
      const index = this.localValue.children.findIndex(
          (c) => c[this.rowKey] === headerNode[this.rowKey]
      );
      this.$set(this.localValue.children, index, headerNode);
      this.$emit("input", this.localValue);
    },
    handleChange() {
      if (!('isChecked' in this.headerNode)) {
        this.headerNode.isChecked = true
      } else {
        this.headerNode.isChecked = !this.headerNode.isChecked
      }
    },
  },
};
</script>

<style scoped>
.cmp-node {
  display: flex;
  align-items: center;
}

.cmp-node:hover {
  background-color: #5d7980;
}

.cmp-drag-node {
  background-color: #768487;
  opacity: 0.7;
}

.disabled {
  pointer-events: none;
  opacity: 0.3;
  background: #bdc3c7;
}

.arrow-right {
  width: 0;
  height: 0;
  margin-left: 5px;
  border-top: 5px solid transparent;
  border-bottom: 5px solid transparent;
  border-left: 6px solid #666;
  transition: 0.3s ease-in-out;
}

.arrow-active {
  transform: rotate(90deg);
  -webkit-transform: rotate(90deg);
  -ms-transform: rotate(90deg);
}


ul.hierarchy {
  padding-left: 40px;
}

@keyframes spin {
  to {
    -webkit-transform: rotate(360deg);
  }
}

@-webkit-keyframes spin {
  to {
    -webkit-transform: rotate(360deg);
  }
}
</style>
