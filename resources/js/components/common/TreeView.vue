<template>
  <li class="text-white list-style-none mt-2 pl-3">
    <div class="d-flex flex-wrap align-items-center" v-if="node.name">
      <div v-if="node.type !== 'well'" class="cursor-pointer" @click="toggleUl(node.id)">
        <img class="arrow-img" :class="showChildren ? 'opened-arrow' : 'closed-arrow'" width="16" height="16" :src="'/img/icons/arrow.svg'">
      </div>
      <div v-if="node.name"
           class="text-right text-white ml-2"
           :class="{'cursor-pointer': node.type === 'well'}"
           @click.stop="handleClick(node)">
        {{ node.name }}
      </div>
    </div>
    <ul class="treeUl" v-if="showChildren">
      <node
          v-for="child in node.children"
          :node="child"
          :key="child.name"
          :handle-click="handleClick"
          :get-wells="getWells"
      ></node>
    </ul>
    <div class="centered mx-auto mt-3" v-if="showChildren && isLoading">
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
  },
  methods: {
    toggleUl: function () {
      this.showChildren = !this.showChildren;
      if (this.showChildren && this.node.type !== 'org') {
        this.isLoading = true;
        this.getWells(this);
      }
    },
  },
  data: function () {
    return {
      showChildren: false,
      isLoading: false,
    };
  },
}
</script>

<style>
.arrow-img {
  transition: 0.2s;
}

.opened-arrow {
  transform: rotate(0deg);
}

.closed-arrow {
  transform: rotate(-90deg);
}

.centered{
  width:40px;
  height:11px;
  transform:translate(-50%,-50%);
  filter: contrast(20);
}
.blob-1,.blob-2{
  width:10px;
  height:10px;
  position:absolute;
  border-radius:50%;
  top:50%;left:50%;
  transform:translate(-50%,-50%);
}
.blob-1{
  left:20%;
  background:#fff;
  animation:osc-l 2.5s ease infinite;
}
.blob-2{
  width:11px;
  height:11px;
  left:80%;
  animation:osc-r 2.5s ease infinite;
  background:rgb(51, 102, 255);
}
@keyframes osc-l{
  0%{left:20%;}
  50%{left:50%;}
  100%{left:20%;}
}
@keyframes osc-r{
  0%{left:80%;}
  50%{left:50%;}
  100%{left:80%;}
}
</style>