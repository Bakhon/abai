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
        v-for="kit in kits"
        :key="kit.id"
        :value="kit.id">
      {{ kit.name }}
    </option>
  </select>
</template>

<script>
import {globalloadingMutations} from '@store/helpers';

export default {
  name: "SelectGtmKit",
  props: {
    form: {
      required: true,
      type: Object
    },
    formKey: {
      required: false,
      type: String,
      default: () => 'gtm_kit_id'
    },
    fetchParams: {
      required: false,
      type: Object
    },
  },
  data: () => ({
    kits: []
  }),
  created() {
    this.getKits()
  },
  methods: {
    ...globalloadingMutations(['SET_LOADING']),

    async getKits() {
      this.SET_LOADING(true)

      const {data} = await this.axios.get(this.url, {params: this.fetchParams})

      this.kits = data

      this.SET_LOADING(false)
    },
  },
  computed: {
    url() {
      return this.localeUrl('/economic/gtm/kit/get-data')
    },
  }
}
</script>

<style scoped>
</style>