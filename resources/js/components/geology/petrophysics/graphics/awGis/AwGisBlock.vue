<template>
  <div class="block" :style="{marginRight: `${blocksMargin}px`}">
    <div class="block__name">
      {{ blockName }}
    </div>
    <div class="block__content d-flex">
      <AwGisDepthColumn :scrollBlock.sync="offsetY" v-bind="$attrs" />
      <AwGisColumn
          v-for="(group, key) in getGroups"
          :key="key"
          v-bind="$attrs"
          :elements="group"
          :wellName="blockName"
          :offset-y="offsetY"
          :ref="`column_${key}`"
      />
    </div>
  </div>
</template>

<script>
import AwGisColumn from "./AwGisColumn";
import AwGisDepthColumn from "./AwGisDepthColumn";

export default {
  name: "AwGisBlock",
  props: {
    blockName: String,
    blockId: String | Number,
    blocksMargin: Number,
    groups: Array | Object,
    blocksScrollY: Number
  },
  components: {
    AwGisDepthColumn,
    AwGisColumn
  },
  data() {
    return {
      context: [],
      offsetY: 0,
      min: 1,
      max: 1,
      offsetX: 0,
    }
  },

  computed: {
    getElements() {
      return this.$store.state.geologyGis.selectedGisCurves;
    },
    getGroups() {
      return Object.values(this.groups).map((a) => {
        return a.filter((b) => {
          return b.data.wellID.includes(this.blockId)&&this.getElements.includes(b.data.name)
        })
      }).filter((a) => a?.length);
    },
  },
}
</script>

<style scoped lang="scss">
.block {
  position: relative;
  padding-top: 30px;
  border: 1px solid black;

  &__name {
    min-height: 30px;
    background: #e3e3e3;
    font-size: 0.8em;
    padding: 5px 10px;
    text-align: center;
    position: absolute;
    width: 100%;
    top: 0;
    left: 0;
    overflow: hidden;
    white-space: nowrap;
    color: #212529;
  }
}
</style>
