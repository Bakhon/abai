<template>
  <LayoutPage>
    <template #topSide>
      <topSide />
    </template>
    <template #leftSide>
      <leftSide />
    </template>
    <template #rightSide>
      <rightSide />
    </template>
    <template #baseSlot>
      <BaseGis/>
    </template>
  </LayoutPage>
</template>
<script>
import LinkButton from "../../geology/components/buttons/LinkButton";
import Button from "../../geology/components/buttons/Button";
import AwIcon from "../../geology/components/icons/AwIcon";
import ToolBlock from "../../geology/components/toolBlock/ToolBlock";
import ToolBlockList from "../../geology/components/toolBlock/ToolBlockList";

export default {
  name: "SuperTemplatePvtPlastOil",
  components: {
    LinkButton,
    Button,
    AwIcon,
    ToolBlock,
    ToolBlockList
  },
  data() {
    return {
      gridSwapperActiveID: "item1",
      dropdownValue: {
        value: null
      }
    }
  },
  methods: {
    gridSwapperActiveButton(id) {
      return this.gridSwapperActiveID === id ? 'primary' : 'accent';
    },
    gridSwapperItemsClasses(id) {
      return {
        "grid-swapper__item": true,
        "active": this.gridSwapperActiveID === id
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.geology-l-side{
  &__toggle{
    border: none;
    background: var(--a-accent);
    margin: -6px 10px 0 -7px;
    padding: 14px 6px;
    border-radius: 0 10px 10px 0;
  }
}

</style>