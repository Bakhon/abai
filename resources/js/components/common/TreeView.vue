<template>
  <li class="text-white list-style-none mt-2 pl-3">
    <div class="d-flex flex-wrap align-items-center" v-if="node.name">
      <div class="my-table-border col-md-1" v-if="isShowCheckboxes">
        <div class="centered">
          <div class="custom-checkbox">
            <form> 
              <label class="container">
                <span class="bottom-border"></span>
                <input type="checkbox" :id="node.id"
                      v-if="!!renderComponent"
                      :checked="isMarked()"
                      class="dropdown-item" @change="onClick()">
                <span class="checkmark"></span>
              </label>
            </form>
          </div>
        </div>
      </div>
      <div class="cursor-pointer" @click="showChildren()" v-if="!isWell(node)">
        <img class="arrow-img" :class="isShowChildren ? 'opened-arrow' : 'closed-arrow'" width="16" height="16"
             :src="'/img/icons/arrow.svg'"
        >
      </div>
      <div v-if="node.name"
           class="text-right text-white ml-2 cursor-pointer"
           :class="{'cursor-pointer': isWell(node), 'h5 m-0': currentWellId === node.id}"
           @click.stop="handleClick(node)">
        {{ node.name }}
      </div>
    </div>
    <ul class="treeUl" v-if="isShowChildren">
      <node
            v-for="(child, index) in node.children"
            :node="child"
            :key="`${index}-${child.id}-${node.id}`"
            :handle-click="handleClick"
            :get-wells="getWells"
            :get-initial-items="getInitialItems"
            :isNodeOnBottomLevelOfHierarchy="isNodeOnBottomLevelOfHierarchy"
            :isShowCheckboxes="isShowCheckboxes"
            :onCheckboxClick="onCheckboxClick"
            :isWell="isWell"
            :currentWellId="currentWellId"
            :level="level+1"
            :nodeClickOnArrow="nodeClickOnArrow"
            :markedNodes="markedNodes"
            :structureType="structureType"
            :renderComponent="renderComponent"
            :updateThisComponent="updateThisComponent"
      ></node>
    </ul>
    <div class="centered mx-auto mt-3" v-if="isShowChildren && isLoading">
      <div class="blob-1"></div>
      <div class="blob-2"></div>
    </div>
  </li>
</template>
<script>
export default {
  name: "node",
  props: {
    node: Object,
    level: Number,
    markedNodes: Object,
    structureType: String,
    renderComponent: Number,
    updateThisComponent: Function,
    isSelectUntilWells: Boolean,
    handleClick: Function,
    getWells: Function,
    getInitialItems: Function,
    isNodeOnBottomLevelOfHierarchy: Function,
    isShowCheckboxes: Boolean,
    isWell: Function,
    onCheckboxClick: {
      type: Function,
      required: false
    },
    currentWellId: {
      type: Number,
      required: false
    },
    markedNodes: {
      type: Object,
      required: false
    },
    structureType: {
      type: String,
      required: false
    },
    renderComponent: {
      type: Number,
      required: false
    },
    updateThisComponent: {
      type: Function,
      required: false
    },
    isSelectUntilWells: Boolean,
    nodeClickOnArrow: false
  },
  created() {
    if(!this.isShowCheckboxes) return;
    if(typeof this.markedNodes[this.level] === 'undefined') {
      this.markedNodes[this.level] = {};
    }
    if(typeof this.markedNodes[this.level][this.node.id] === 'undefined') {
      this.markedNodes[this.level][this.node.id] = false;
    }
  },
  model: {
    prop: "node",
    event: "nodeChange"
  },
  methods: {
    showChildren: async function () {
      this.isShowChildren = !this.isShowChildren;
      if (!this.isShowChildren) {
        return
      }
      if (this.nodeClickOnArrow && !this.node.children) {
          await this.handleClick(this.node);
      }
      if(!this.isHaveChildren(this.node)) {
        this.isLoading = true;
        await this.getWells(this);
      }
      if(this.isShowCheckboxes) {
        this.onExpandTree(this.node, this.level);
      }

      this.$forceUpdate()
    },
    onClick: async function () {
      let val = this.markedNodes[this.level][this.node.id];
      this.markedNodes[this.level][this.node.id] = !val;
      this.loadChildren(this.node);
      this.onExpandTree(this.node, this.level);
      this.onCheckboxClick(this.node, this.level);
      if(this.isSelectUntilWells || val) {
        await this.updateChildren(this.node, this.level);
      }else {
        await this.updateNextLevelNodes();
      }
      this.updateThisComponent();
    },
    onExpandTree: function(node, level) {
      if(!this.isHaveChildren(node) || this.markedNodes[level+1]) return;

      this.markedNodes[level+1] = {};
      let content = this.markedNodes[level + 1];
      for(let child of node.children) {
        content[child.id] = {};
        this.onExpandTree(child, level);
      }
    },
    loadChildren: async function(node) {
      if(this.isWell(node)) return;
      if(typeof node.children === 'undefined') {
        await this.handleClick(node);
      }
      if(!this.isHaveChildren(node)) {
        await this.getWells(node);
        this.updateThisComponent();
      }
      
      for(let idx in node.children) {
        this.loadChildren(node.children[idx]);
      }
    },
    updateChildren: async function(node, level) {
      if(!this.isHaveChildren(node)) return;
      let content = this.markedNodes[level+1];
      let val = this.markedNodes[level][node.id];
      for(let child of node.children) {
        content[child.id] = val;
        this.updateChildren(child, level);
      }
    },
    updateNextLevelNodes: async function() {
      if(!this.isHaveChildren(this.node)) return;
      let content = this.markedNodes[level+1];
      let val = this.markedNodes[level][node.id];
      for(let child of this.node.children) {
        content[child.id] = val;
      }
    },
    isMarked: function() {
      return typeof this.markedNodes[this.level] !== 'undefined' &&
             this.markedNodes[this.level][this.node.id];
    },
    isHaveChildren(node) {
      return typeof node !== 'undefined' && 
             typeof node.children !== 'undefined' && 
             !this.isNodeOnBottomLevelOfHierarchy(node);
    }
  },
  data: function () {
    return {
      isShowChildren: false,
      isLoading: false,
    };
  },
}
</script>

<style scoped lang="scss">

.custom-checkbox {
  .container {
    padding: 0px;
    display: flex;
    position: relative;
    cursor: pointer;
    margin: 0px;
  }

  .container input {
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
  }

  .checkmark {
    height: 14px;
    width: 14px;
    background-color: white;
    border-radius: 3.5px;
    border: 1px solid #237DEB;
    margin-bottom: auto;
    margin-top: auto;
  }

  .container input:checked ~ .checkmark {
    background: #237DEB;

  }

  .checkmark:after {
    content: "";
    position: relative;
    display: none;
  }

  .container input:checked ~ .checkmark:after {
    display: block;
  }

  .container .checkmark:after {
    width: 4px;
    height: 8px;
    border: solid white;
    border-width: 0 1.5px 1.5px 0;
    transform: rotate(
            45deg
    );
    position: inherit;
    margin: auto;
  }
}

.arrow-img {
  transition: 0.2s;
}

.opened-arrow {
  transform: rotate(0deg);
}

.closed-arrow {
  transform: rotate(-90deg);
}

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