<template>
  <div class="form-group1 filter-group select">
    <select
        id="companySelect"
        :disabled="isLoading"
        class="form-control filter-input select"
        v-bind:value="value"
        v-on:change="$emit('input', $event.target.value)"
    >
      <option disabled value="">{{ trans('bd.select_company') }}</option>
      <option v-for="org in orgs" :value="org.name_short_ru">{{ org.name_ru }}</option>
    </select>
  </div>
</template>
<script>
export default {
  props: ['value'],
  data() {
    return {
      orgs: []
    }
  },
  mounted() {
    this.axios.get(this.localeUrl('/api/bigdata/dzo')).then(({data}) => {
      this.orgs = data.orgs
      this.$emit('input', this.orgs[0].name_short_ru)
    })
  }
};
</script>