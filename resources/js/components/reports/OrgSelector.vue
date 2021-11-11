<template>
  <div class="form-group1 filter-group select">
    <select
        id="companySelect"
        :disabled="$store.state.globalloading.loading"
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
import {globalloadingMutations} from '@store/helpers';

;

export default {
  props: ['value'],
  data() {
    return {
      orgs: [],
      predefinedShortNamesByDzoId: {
        '3': 'АО ОМГ',
        '126': 'КОА',
        '4': 'АО ЭМГ',
        '179': 'ТОО «СП «Казгермунай»',
        '71': 'КБМ',
        '112': 'ММГ',
        '173': 'ТОО «Казахтуркмунай»'
      }
    }
  },
  mounted() {
    this.axios.get(this.localeUrl('/api/bigdata/dzo')).then(({data}) => {
      this.orgs = data.orgs
      for (let i = 0; i < data.orgs.length; i++) {
        let id = data.orgs[i].id
        if (id in this.predefinedShortNamesByDzoId) {
          data.orgs[i].name_short_ru = this.predefinedShortNamesByDzoId[id]
        }
      }
      this.$emit('input', this.orgs[0].name_short_ru)
    })
  }
};
</script>