<template>
  <div class="aw-tree">
    <ul v-if="typeof items === 'object'" class="aw-tree__list">
      <AwTreeItem :index="2" :settings="settings" icon-type="zone" :item="items"/>
    </ul>
  </div>
</template>
<script>
import AwTreeItem from "./AwTreeItem";
export default {
  name: "AwTree",
  components:{
    AwTreeItem
  },
  props: {
    treeType: String,
    items: Object,
    settings: Object,
    selected: Array
  },
  methods: {
    clickItem(value){
      let existsIndex = this.selected.indexOf(value);
      if(~existsIndex){
        this.selected.splice(existsIndex, 1)
      }else{
        this.selected.push(value)
      }
      this.$emit('update:selected', this.selected)
    }
  },
  provide(){
    return {
      selected: this.selected,
      settings: this.settings,
      clickItem: this.clickItem,
    }
  }
}
</script>
