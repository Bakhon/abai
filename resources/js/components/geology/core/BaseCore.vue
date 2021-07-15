<template>
  <div class="core-center geology__content">
    <ToolBlock>
      <template #header>
        <div class="d-flex align-items-center justify-content-between">
          <h5 class="mr-2">Интервал</h5>
          <Button i-width="10" i-height="10" color="transparent" icon="rectArrow" size="small" />
        </div>
      </template>
      <img class="w-100" src="/images/geology/demo.core-graph2.svg" alt="">
      <template #tools-footer>
        <Legend title="Легенда" :items="[
            {color: 'var(--a-black)', name: 'Уголь'},
            {color: 'var(--a-yellow)', name: 'Песчаник'},
            {color: 'var(--a-gray)', name: 'Глина'},
        ]"/>
      </template>
    </ToolBlock>
    <ToolBlock>
      <template #header>
        <div class="d-flex align-items-center justify-content-between">
          <h5 class="mr-2">ГИС</h5>
          <Button i-width="10" i-height="10" color="transparent" icon="rectArrow" size="small" />
        </div>
      </template>
      <img class="w-100" src="/images/geology/demo.core-graph1.svg" alt="">
      <template #tools-footer>
        <Button size="big" align="center" color="primary" block class="w-100">ALARM</Button>
      </template>
    </ToolBlock>
  </div>
</template>

<script>
import LinkButton from "../components/buttons/LinkButton";
import Button from "../components/buttons/Button";
import ToolBlock from "../components/toolBlock/ToolBlock";
import Legend from "../components/legend/Legend";
export default {
  name: "core",
  components:{
    LinkButton,
    Button,
    ToolBlock,
    Legend
  }
}
</script>

<style scoped lang="scss">
.core-center{
  display: grid;
  grid-template-columns: minmax(300px, 607.3px) minmax(202px,476.2px);
  grid-gap: 10px;
  .legend{
    font-size: 13px;
    &::v-deep{
      .legend__item,.title{
        padding: 8px 25px;
      }
      .legend__items-wrapper{
        justify-content: space-between;
        width: 100%;
      }
      .legend__circle{
        width: 20px;
        height: 20px;
        border-radius: 0;
      }
    }
  }
}
</style>
