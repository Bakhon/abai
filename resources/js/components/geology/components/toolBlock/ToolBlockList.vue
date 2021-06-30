<template>
  <div :class="toolBlockClass">
      <div v-if="description" class="description mb-2">
        <p>{{description}}</p>
      </div>
      <button v-for="(item, i) in cList" :key="i" @click="selectHandle(item)" :class="optionsClasses(item.value)">
        <input class="mr-2" v-if="hasCheckbox" type="checkbox" :value="item.value" :checked="cSelected.includes(item.value)">
        {{item.label || item.value}}
      </button>
  </div>
</template>

<script>
export default {
  name: "toolBlockList",
  props:{
    description: String,
    hasCheckbox: Boolean,
    list: Array,
    selected: Array
  },
  computed:{
    cList(){
      return this.list || [];
    },
    cSelected(){
      return this.selected || []
    },
    toolBlockClass(){
      return {
        "toolBlock__list": true,
        "multiple": this.hasCheckbox
      }
    }
  },
  methods:{
    selectHandle(item){
      this.$emit('update:selected', this.cSelected);
      this.$emit('click', item);
    },
    optionsClasses(value){
      return {
        'd-flex align-items-center mb-2': this.hasCheckbox,
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
    .description{
      background: var(--a-accent-100);
      padding: 7px 12px;
      margin-top: -5px;
      p{
        font-size: 16px;
        color: #ffffff;
        margin: 0;
      }
    }
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
      line-height: 1;
      &:last-child{
        margin-bottom: 0!important;
      }
      &:hover, &.active {
        background: var(--a-accent-100)
      }
    }

    &.multiple {
      button{
        &:hover, &.active {
          background: none
        }
      }
    }
  }
}
</style>
