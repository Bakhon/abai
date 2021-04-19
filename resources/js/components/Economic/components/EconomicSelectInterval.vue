<template>
  <input
      v-model="form.interval"
      placeholder="Выберите период времени"
      class="form-control text-white bg-main4-important border-0"
      @change="$emit('change')">
</template>

<script>
export default {
  name: "EconomicSelectInterval",
  props: {
    form: {
      required: true,
      type: Object
    },
  }
}
</script>

<style scoped>
.bg-main4-important {
  background-color: #333975 !important;
}

.form-control::placeholder {
  color: #fff !important;
}
</style>