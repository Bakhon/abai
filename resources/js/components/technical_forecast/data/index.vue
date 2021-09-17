<template>
  <div class="container p-4 bg-light" style="max-width: 90vw">
    <select-source
        :form="form"
        @loading="SET_LOADING(true)"
        @loaded="SET_LOADING(false)"
        @change="getData"/>

    <vue-table-dynamic v-if="form.source_id" :params="params" ref="table">
      <a slot="column-12" slot-scope="{ props }" :href="props.cellData">
        {{ trans('app.edit') }}
      </a>
    </vue-table-dynamic>
  </div>
</template>

<script>
import VueTableDynamic from 'vue-table-dynamic'

import {globalloadingMutations, globalloadingState} from '@store/helpers';

import SelectSource from "./../components/SelectSource";

export default {
  name: "tech-data-component",
  components: {
    VueTableDynamic,
    SelectSource
  },
  data: () => ({
    form: {
      source_id: null
    },
    data: []
  }),
  methods: {
    ...globalloadingMutations(['SET_LOADING']),

    async getData() {
      this.SET_LOADING(true);

      this.data = [this.headers]

      const {data} = await this.axios.get(this.url, {params: this.form})

      data.forEach(item => {
        this.data.push([
          item.source.name,
          item.gu.name,
          item.well_id,
          item.pes ? item.pes.name : '',
          item.date,
          item.oil,
          item.liquid,
          item.days_worked,
          item.prs,
          item.comment,
          `${item.created_at} ${item.author.name}`,
          item.editor ? `${item.updated_at} ${item.editor.name}` : '',
          this.localeUrl(`/economic/technical/forecast/${item.id}/edit`),
          item.log_id
        ])
      })

      this.SET_LOADING(false);
    },
  },
  computed: {
    ...globalloadingState(['loading']),

    url() {
      return this.localeUrl('/economic/technical/forecast/get-data')
    },

    params() {
      return {
        data: this.data,
        enableSearch: true,
        whiteSpace: 'normal',
        header: 'row',
        border: true,
        stripe: true,
        pagination: true,
        sort: this.headers.map((col, index) => (index)),
        pageSize: 12,
        pageSizes: [12, 24, 48],
        headerHeight: 80,
        rowHeight: 50,
        columnWidth: this.headers.map((col, index) => ({column: index, width: 150}))
      }
    },

    headers() {
      return [
        this.trans('forecast.source_data'),
        this.trans('forecast.gu'),
        this.trans('forecast.well'),
        this.trans('economic_reference.pes'),
        this.trans('forecast.month-year'),
        this.trans('forecast.oil-production'),
        this.trans('forecast.extraction-liquid'),
        this.trans('forecast.days-worked'),
        this.trans('forecast.prs'),
        this.trans('forecast.comment'),
        this.trans('forecast.added_date_author'),
        this.trans('forecast.changed_date_author'),
        this.trans('forecast.edit'),
        this.trans('forecast.id_of_add')
      ]
    }
  }
};
</script>
<style lang="scss" scoped>
</style>
