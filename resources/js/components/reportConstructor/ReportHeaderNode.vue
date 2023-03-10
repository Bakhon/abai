<template>
<div class="cmp-tree-container">
  <div class="cmp-tree">
    <div class="cmp-node" @click="isOpen = !isOpen">
      <label>
        <input name="checkbox" type="checkbox" 
          v-if="renderComponent"
          @click.stop="handleChange" :checked="headerNode.isChecked"
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
          :list="headerNode.children"
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
            :updateThisComponent="updateThisComponent"
            :renderComponent="renderComponent"
        >
          <span>{{ translateAttribute(item.label) }}</span>
        </ReportHeaderNode>
      </draggable>
    </ul>
  </div>
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
    renderComponent: Number,
    updateThisComponent: Function,
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

      this.updateChildren(this.headerNode);
      this.updateParent(this.headerNode.isChecked);
      this.updateThisComponent();
    },
    updateChildren(headerNode) {
      if(!headerNode?.children) return;
      for(let child of headerNode.children) {
        child.isChecked = headerNode.isChecked;
        this.updateChildren(child);
      }
    },
    updateParent(val) {
      let content = this.$parent;
      while(!!content) {
        if(!content.headerNode) {
          content = content.$parent;
          continue;
        }
        if(!val && this.hasSelectedChildren(content.headerNode)) {
          break;
        }
        content.headerNode.isChecked = val;
        content = content.$parent;
      }
    },
    hasSelectedChildren(headerNode) {
      if(!headerNode?.children) return false;
      for(let child of headerNode.children) {
        if(child.isChecked || this.hasSelectedChildren(child)) return true;
      }
      return false;
    }
  },
};
</script>

<style scoped>
.cmp-node {
  display: flex;
  align-items: center;
  font-size: 16px;
}
.cmp-node input {
      height: 14px;
    width: 14px;
    background-color: white;
    border-radius: 3.5px;
    border: 10px solid #237DEB;
    margin-bottom: auto;
    margin-top: auto;
    outline: none;
}
.hierarchy .cmp-tree-container {
    padding-left: 0;
}
.cmp-tree-container {
    padding-left: 25px;
}
.cmp-node label {
      margin-bottom: 0;
      display: block;
      height: auto;
      margin-right: 30px;
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
  padding-left: 0;
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
