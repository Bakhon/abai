<template>
  <select
      v-model="form[formKey]"
      class="form-control"
      @change="$emit('change')"
  >
    <option :value="null" disabled selected>
      {{ selectDefault }}
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
      type: String
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

    selectDefault() {
      return this.placeholder || this.trans('economic_reference.select_log')
    }
  }
}
</script>

<style scoped>
</style>