<template>
  <li class="text-white list-style-none mt-2 pl-3">
    <div class="d-flex flex-wrap align-items-center" v-if="node.name">
      <div class="my-table-border col-md-1" v-if="isShowCheckboxes">
        <div class="centered">
          <div class="custom-checkbox">
            <form>
              <label class="container">
                <span class="bottom-border"></span>
                <input type="checkbox" :id="node.id" name="tech_structure" value="tech_structure"
                       class="dropdown-item">
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
           class="text-right text-white ml-2"
           @click.stop="handleClick(node)">
        {{ node.name }}
      </div>
    </div>
    <ul class="treeUl" v-if="isShowChildren">
      <node
            v-for="(child, index) in node.children"
            :node="child"
            :key="index+child.id"
            :handle-click="handleClick"
            :get-wells="getWells"
            :get-initial-items="getInitialItems"
            :isNodeOnBottomLevelOfHierarchy="isNodeOnBottomLevelOfHierarchy"
            :isShowCheckboxes="isShowCheckboxes"
            :isWell="isWell"
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
    handleClick: Function,
    getWells: Function,
    getInitialItems: Function,
    isNodeOnBottomLevelOfHierarchy: Function,
    isShowCheckboxes: Boolean,
    isWell: Function,
  },
  model: {
    prop: "node",
    event: "nodeChange"
  },
  methods: {
    showChildren: function () {
      this.isShowChildren = !this.isShowChildren;
      if (!this.isShowChildren) {
        return
      }
      if (this.isNodeOnBottomLevelOfHierarchy(this.node)) {
        this.isLoading = true;
        this.getWells(this);
      }
      this.$forceUpdate()
    },
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