<template>
  <div class="container-col_color mt-2">
    <select class="filter__input w-100 px-2">
      >
      <option class="filter__option"      
        v-for="(select, index) in selectFilter"
        :value="select.value"
        >{{ trans("economy_pf." + select.option) }}</option
      >
    </select>
  </div>
</template>
<style scoped lang="scss">
.filter__input {
  width: 100%;
  $form-select-color: #293688;
  $form-select-line-height: 75px;
}
</style>

<script>
export default {
  props: ["selectFilter"],
};
</script>
