<template>
  <select
      v-model="form.source_id"
      class="form-control"
      @change="$emit('change')"
  >
    <option
        v-for="source in sources"
        :key="source.id"
        :value="source.id">
      {{ source.name }}
    </option>
  </select>
</template>

<script>
export default {
  name: "SelectSource",
  props: {
    loading: {
      required: false,
      type: Boolean
    },
    form: {
      required: true,
      type: Object
    },
  },
  data: () => ({
    sources: []
  }),
  created() {
    this.getSources()
  },
  methods: {
    async getSources() {
      this.loading = true

      const {data} = await this.axios.get(this.localeUrl('/tech_struct_sources'))

      this.sources = data.sources

      this.loading = false
    },
  }
}
</script>

<style scoped>
</style>