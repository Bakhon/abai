<template>
<div>
  <ToolBlock title="Выбор модели (готовая)">
    <div class="d-flex align-items-center btns">
      <Button class="mr-3">ГК</Button>
      <Button class="mr-3">ПС</Button>
      <Button>КВ</Button>
    </div>
  </ToolBlock>
  <ToolBlock class="mb-2" title="Выбор модели (готовая)">
    <div class="btns">
      <div class="d-flex align-items-center">
        <Button class="mr-2">ГК</Button>
        <Button class="mr-2">ПС</Button>
        <Button class="mr-2">КВ</Button>
        <Button>ГККП</Button>
      </div>
      <Button class="mt-4 w-100" color="primary" align="center">Запуск</Button>
    </div>
  </ToolBlock>
  <ToolBlock class="mb-2">
    <AwTextarea />
    <template #tools-footer>
      <Button class="w-100" align="center">Создать новую кривую</Button>
    </template>
  </ToolBlock>
  <ToolBlock class="mb-2">
    <AwTextarea />
    <template #tools-footer>
      <Button class="w-100" align="center">Тип кривой</Button>
    </template>
  </ToolBlock>
  <ToolBlock class="mb-2">
    <AwTextarea />
    <template #tools-footer>
      <Button class="w-100" align="center">Создать новую модель (Data set)</Button>
    </template>
  </ToolBlock>
  <ToolBlock class="mb-2">
    <AwTextarea />
    <template #tools-footer>
      <Button class="w-100" align="center">Использовать существующую модель (Data set)</Button>
    </template>
  </ToolBlock>
</div>
</template>

<script>
import ToolBlock from "../../components/toolBlock/ToolBlock";
import ToolBlockList from "../../components/toolBlock/ToolBlockList";
import Button from "../../components/buttons/Button";
import AwTextarea from "../../components/form/AwTextarea";
export default {
  name: "FirstComponent",
  components:{
    ToolBlock,
    ToolBlockList,
    Button,
    AwTextarea
  },
  data(){
    return {
      listSelect:[]
    }
  },
  methods:{
    selectedHandle(){

    }
  }
}
</script>

<style scoped>
.btns {
  padding: 20px 13px;
}
</style>
