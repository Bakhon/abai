<template>
  <div>
    <div>
      <div class="block-edited-params" style="justify-content: space-between;">
        <div>
          Выделение кластеров
        </div>
        <div>
          <input type="text" class="edit-params-input">
        </div>
      </div>

      <div class="block-edited-params mt-1" style="justify-content: space-between;">
        <div>
          Замеры пластового давления
        </div>
        <div class="pl-4">
          <input type="text" class="edit-params-input">
        </div>
      </div>

      <div class="block-edited-params mt-1" style="justify-content: space-between;">
        <div>
          Взаимосвязь скважин
        </div>
        <div class="pl-4">
          <input type="text" class="edit-params-input">
        </div>
      </div>

      <div class="block-edited-params mt-1" style="justify-content: space-between;">
        <div>
          Влияние аквифера
        </div>
        <div class="pl-4">
          <input type="text" class="edit-params-input">
        </div>
      </div>

      <div class="block-edited-params mt-1" style="justify-content: space-between;">
        <div>
          Параметры флюида
        </div>
        <div class="pl-4">
          <input type="text" class="edit-params-input">
        </div>
      </div>

      <div class="block-edited-params mt-1" style="justify-content: space-between;">
        <div>
          Исторические данные
        </div>
        <div class="pl-4">
          <input type="text" class="edit-params-input">
        </div>
      </div>

      <div class="block-edited-params-button mt-2 ml-5">
        <div class="pt-1">
          Применить
        </div>
      </div>

    </div>
  </div>
</template>
<script>
export default {
  name: 'edit-parameters'
}
</script>
<style scoped>
.block-edited-params {
  padding: 15px;
  display: flex;
  background-color: #323370; border: 0.5px solid #545580;
}

.block-edited-params-button {
  background-color: #333975;
  border-radius: 6px;
  width: 170px;
  height: 28px;
  text-align: center;
  position: absolute;
  left: 30%;
  bottom: 7%;
}

.block-edited-params-button:hover {
  background-color: #2E50E9;
}

.edit-params-input {
  background: #272953;
  border: 1px solid #494AA5;
  outline: none;
  color: white;
  border-radius: 2px
}

.edit-params-input:focus {
  background: #5657c7;
}

.edit-params-input:disabled {
  color: #928f8f;
  background: #353e70;
}
</style>