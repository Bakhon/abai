<template>
  <select
      v-model="form[formKey]"
      class="form-control"
      @change="$emit('change')"
  >
    <option :value="null" disabled selected>
      {{ trans('economic_reference.select_item') }}
    </option>

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
    isForecast: {
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

      this.scFas = []

      let params = {
        is_forecast: +this.isForecast
      }

      const {data} = await this.axios.get(this.localeUrl('/module_economy/eco_refs_sc_fas'), {params: params})

      this.scFas = data.data

      this.$emit('loaded')
    },
  }
}
</script>

<style scoped>
</style>