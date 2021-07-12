<template>
  <div class="aw-tab__content" v-show="isActive">
    <slot />
  </div>
</template>

<script>
export default {
  name: "AwTabContent",
  props: {
    tabId: String
  },
  computed:{
    cParentActiveID(){
      return this.$parent?.cActiveID;
    },
    isActive(){
      return this.cParentActiveID === this.tabId;
    }
  },
}
</script>
