<template>
  <select
      v-model="form[formKey]"
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
    formKey: {
      required: false,
      type: String,
      default: () => 'sc_fa_id'
    },
    forecast: {
      required: false,
      type: Boolean
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

      let params = {
        is_forecast: +this.forecast
      }

      const {data} = await this.axios.get(this.localeUrl('/eco_refs_sc_fas'), {params: params})

      this.scFas = [...this.scFas, ...data.data]

      this.$emit('loaded')
    },
  }
}
</script>

<style scoped>
</style>