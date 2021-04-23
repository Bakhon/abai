<template>
  <div class="d-flex align-items-center white-placeholder">
    <datetime
        v-model="form.interval_start"
        placeholder="Начало"
        input-class="bg-main4 text-white form-control border-0"
        class="mr-2 flex-grow-1"
        auto
    />

    <datetime
        v-model="form.interval_end"
        placeholder="Конец"
        input-class="bg-main4 text-white form-control border-0"
        class="mr-2 flex-grow-1"
        auto
    />

    <i class="fas fa-search cursor-pointer mr-2"
       @click="$emit('change')"></i>

    <i class="fas fa-times cursor-pointer"
       @click="reset"></i>
  </div>
</template>

<script>
export default {
  name: "EconomicSelectInterval",
  props: {
    form: {
      required: true,
      type: Object
    },
  },
  methods: {
    reset() {
      this.form.interval_start = null
      this.form.interval_end = null
    }
  }
}
</script>

<style scoped>
.white-placeholder >>> *::placeholder {
  color: #fff;
}

.cursor-pointer {
  cursor: pointer;
}
</style>