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
      const {data} = await this.axios.get(this.localeUrl('/tech_struct_sources'))

      this.sources = data.sources
    },
  }
}
</script>

<style scoped>
</style>