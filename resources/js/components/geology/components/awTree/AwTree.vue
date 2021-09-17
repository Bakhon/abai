<template>
  <div :class="getAwTreeClasses">
    <ul v-if="typeof items === 'object'" :class="getAwTreeRootListClasses">
      <component :is="variant" :settings="settings" :item="items"/>
    </ul>
  </div>
</template>
<script>
import AwTreeItem from "./AwTreeItem";
import AwTreeItem2 from "./AwTreeItem2";

export default {
  name: "AwTree",
  components:{
    AwTreeItem,
    AwTreeItem2
  },
  props: {
    treeType: String,
    items: Object,
    settings: Object,
    selected: Array,
    isWithoutSpace: Boolean,
    variant: {
      type: String,
      default: "AwTreeItem"
    }
  },
  data(){
    return {
      dragElement: null,
      dragTo: null,
      dragFrom: null
    }
  },
  computed: {
    getDragElement(){
      return this.dragElement
    },
    getAwTreeRootListClasses(){
      return {
        "aw-tree__list": true,
        [this.variant]: true
      }
    },
    getAwTreeClasses(){
      return {
        "aw-tree": true,
        [this.variant]: true
      }
    }
  },
  methods: {
    selectItem(item){
      this.$emit('selectItem', item)
    },
    clickItem(value){
      let existsIndex = this.selected.indexOf(value);
      if(~existsIndex){
        this.selected.splice(existsIndex, 1)
      }else{
        this.selected.push(value)
      }
      this.$emit('update:selected', this.selected)
    },
  },
  provide(){
    return {
      selectItem: this.selectItem,
      selected: this.selected,
      settings: this.settings,
      clickItem: this.clickItem,
      isWithoutSpace: this.isWithoutSpace,
      variant: this.variant,
    }
  }
}
</script>
