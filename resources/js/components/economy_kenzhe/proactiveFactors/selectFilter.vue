<template>
  <select class="filter__input" id="filter" selectpicker>
    >
    <option v-for="(select, index) in selectFilter"
     :value="select.value">{{
      trans("economy_pf." + select.option)
    }}</option>
  </select>
</template>

<script>
export default {
  props: ["selectFilter"],
};
</script>
