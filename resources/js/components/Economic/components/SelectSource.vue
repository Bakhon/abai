<template>
  <select
      v-model="form.source_id"
      class="form-control"
      @change="$emit('change')"
  >
    <option :value="null" disabled selected>
      {{ trans('economic_reference.select_item') }}
    </option>

    <option
        v-for="source in sources"
        :key="source.id"
        :value="source.id">
      {{ source.name }}
    </option>
  </select>
</template>

<script>
import {globalloadingMutations} from '@store/helpers';

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
    ...globalloadingMutations(['SET_LOADING']),

    async getSources() {
      this.SET_LOADING(true)

      const {data} = await this.axios.get(this.url)

      this.sources = data

      this.SET_LOADING(false);
    },
  },
  computed: {
    url() {
      return this.localeUrl('/economic/technical/structure/source/get-data')
    },
  },
}
</script>

<style scoped>
</style>