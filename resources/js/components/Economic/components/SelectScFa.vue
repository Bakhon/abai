<template>
  <select
      v-model="form.sc_fa"
      class="form-control"
      @change="$emit('change')"
  >
    <option
        v-for="sc_fa in scFas"
        :key="sc_fa.id"
        :value="sc_fa.id">
      {{ sc_fa.name }}
    </option>
  </select>
</template>

<script>
export default {
  name: "SelectScFa",
  props: {
    form: {
      required: true,
      type: Object
    },
    fetchParams: {
      required: false,
      type: Object
    }
  },
  data: () => ({
    scFas: []
  }),
  created() {
    this.getScFas()
  },
  methods: {
    async getScFas() {
      this.$emit('loading')

      this.form.sc_fas = null

      this.scFas = [{
        id: null,
        name: this.trans('economic_reference.select_item')
      }]

      const {data} = await this.axios.get(this.localeUrl('/eco_refs_sc_fas'), {params: this.fetchParams})

      this.scFas = [...this.scFas, ...data.data]

      this.$emit('loaded')
    },
  }
}
</script>

<style scoped>
</style>