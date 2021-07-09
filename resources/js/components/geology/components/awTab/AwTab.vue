<template>
  <div class="aw-tab">
    <div class="aw-tab__buttons">
      <button :class="{active: cActiveID === btn.id}" @click="cActiveID = btn.id" v-for="btn in cButtons" :key="btn.id">{{ btn.label || btn.id }}</button>
    </div>
    <slot />
  </div>
</template>

<script>
export default {
  name: "AwTab",
  props: {
    buttons: Array,
    active: String
  },
  data(){
    return {
      activeID: this.active
    }
  },
  computed: {
    cActiveID:{
      get(){
        return this.activeID || this.cButtons?.length&&this.cButtons[0]?.id
      },
      set(val){
        this.activeID = val
      }
    },
    cButtons() {
      return this.buttons || [];
    },
  },
}
</script>

<style scoped lang="scss">
.aw-tab {
  &__buttons{
    button{
      background: var(--a-accent-400);
      border: 1px solid var(--a-accent-300);
      color: #ffffff;
      font-size: 14px;
      padding: 7px 10px;
      text-align: center;
      line-height: 1;
      transition: 300ms all;
      &:hover{
        background: darken(#454D7D, 7%);
      }
      &.active{
        background: #212982;
      }
    }
  }
}
</style>
