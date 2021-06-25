<template>
  <div class="toolBlock__list">
      <button
          v-for="(item, i) in cList"
          :key="i"
          @click="selectHandle(item)"
          :class="optionsClasses(item.value)"
      >
        {{item.label || item.value}}
      </button>
  </div>
</template>

<script>
export default {
  name: "toolBlockList",
  props:{
    list:{
      type: Array,
    },
    selected: {
      type: Array,
    }
  },
  computed:{
    cList(){
      return this.list || [];
    },
    cSelected(){
      return this.selected || []
    },
  },
  methods:{
    selectHandle(item){
      // TODO Узнать будет ли мультивыбор
      this.$emit('update:selected', this.cSelected);
      this.$emit('click', item);
    },
    optionsClasses(value){
      return {
        "active": this.cSelected.includes(value)
      }
    }

  }
}
</script>

<style scoped lang="scss">
.toolBlock{
  &__list{
    padding: 5px 0;
    background: var(--a-accent-300);
    button{
      width: 100%;
      text-align: left;
      display: block;
      background: none;
      border: none;
      color: #ffffff;
      font-size: 14px;
      font-weight: 400;
      padding: 2px 12px;
      transition: 300ms all;
      &:hover, &.active {
        background: var(--a-accent-100)
      }
    }
  }
}
</style>
