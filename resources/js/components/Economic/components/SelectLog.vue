<template>
  <select
      v-model="form[formKey]"
      class="form-control"
      @change="$emit('change')"
  >
    <option :value="null" disabled selected>
      {{ placeholder }}
    </option>

    <option
        v-for="log in logs"
        :key="log.id"
        :value="log.id">
      <span v-if="log.is_processed === 1">
          {{ trans('economic_reference.processed') }}:
      </span>

      <span v-else-if="log.is_processed === 0">
          {{ trans('economic_reference.in_processing') }}:
      </span>

      <span>{{ log.name }}</span>
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
    formKey: {
      required: false,
      type: String,
      default: () => 'log_id'
    },
    fetchParams: {
      required: false,
      type: Object
    },
    placeholder: {
      required: false,
      type: String,
      default: function () {
        return this.trans('economic_reference.select_log')
      }
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
    },
  }
}
</script>

<style scoped>
</style>