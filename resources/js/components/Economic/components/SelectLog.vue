<template>
  <select
      v-model="form.log_id"
      class="form-control"
      @change="$emit('change')"
  >
    <option :value="null" disabled selected>
      {{ trans('economic_reference.select_log') }}
    </option>

    <option
        v-for="log in logs"
        :key="log.id"
        :value="log.id">
      {{ log.name }}
    </option>
  </select>
</template>

<script>
import {globalloadingMutations} from '@store/helpers';

export default {
  name: "SelectLog",
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
    logs: []
  }),
  created() {
    this.getLogs()
  },
  methods: {
    ...globalloadingMutations(['SET_LOADING']),

    async getLogs() {
      this.SET_LOADING(true);

      const {data} = await this.axios.get(this.url, {params: this.fetchParams})

      this.logs = data

      this.SET_LOADING(false);
    },
  },
  computed: {
    url() {
      return this.localeUrl('/economic/log/get-data')
    }
  }
}
</script>

<style scoped>
</style>