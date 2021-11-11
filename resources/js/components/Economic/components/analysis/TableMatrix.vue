<template>
  <div class="mt-2 customScroll overflow-auto" style="max-height: 575px">
    <select-granularity
        :form="form"
        class="flex-grow-1 mb-2"
        @change="getData()"/>

    <vue-table-dynamic
        :params="tableParams"
        class="matrix-table bg-main1 pb-0"/>
  </div>
</template>

<script>
import {globalloadingMutations} from '@store/helpers';

import SelectGranularity from "../SelectGranularity";

export default {
  name: "TableMatrix",
  components: {
    SelectGranularity
  },
  data: () => ({
    form: {
      granularity: 'month'
    },
    wells: null
  }),
  created() {
    this.$emit('updateWide', false)

    this.getData()
  },
  methods: {
    ...globalloadingMutations(['SET_LOADING']),

    async getData() {
      this.SET_LOADING(true)

      try {
        const {data} = await this.axios.get(this.url, {params: this.form})

        this.wells = data
      } catch (e) {
        this.wells = null
      }

      this.SET_LOADING(false)
    },
  },
  computed: {
    url() {
      return this.localeUrl('/economic/analysis/get-wells-by-date')
    },

    tableParams() {
      return {
        data: [...[this.tableHeaders.map(header => header.name)], ...this.tableData],
        whiteSpace: 'normal',
        header: 'row',
        border: true,
        stripe: true,
        pagination: true,
        pageSize: 10,
        headerHeight: 80,
        rowHeight: 50,
        fixed: 1,
        highlightedColor: '#2E50E9'
      }
    },

    tableHeaders() {
      return [
        {
          name: 'uwi',
          key: 'uwi',
        },
        {
          name: 'Дата',
          key: 'date',
        },
        {
          name: 'Q н, факт',
          key: 'oil',
        },
        {
          name: 'Q ж, факт',
          key: 'liquid',
        },
        {
          name: 'Состояние',
          key: 'status_name',
        },
        {
          name: 'Причина потерь',
          key: 'loss_status_name',
        },
        {
          name: 'Рентабельность',
          key: 'profitability',
        },
        {
          name: 'Q н, предл',
          key: 'oil_propose',
        },
        {
          name: 'Q ж, предл',
          key: 'liquid_propose',
        },
      ]
    },

    tableData() {
      if (!this.wells) {
        return []
      }

      let rows = []

      this.wells.forEach(well => {
        rows.push(this.tableHeaders.map(header => well[header.key]))
      })

      return rows
    },
  }
}
</script>

<style scoped>
.matrix-table >>> .v-table-body {
  height: fit-content !important;
}

.matrix-table >>> .v-table-row {
  height: 40px !important;
}

.matrix-table >>> .table-cell {
  line-height: 13px;
}

.matrix-table >>> .v-table-fixed {
  color: #fff;
}

.matrix-table >>> .v-table-header-wrap .is-header .table-cell {
  background: #2E50E9 !important;
  color: #fff;
}

.matrix-table >>> .table-pagination .page-item,
.matrix-table >>> .table-pagination .size-item,
.matrix-table >>> .table-pagination .pagination-size,
.matrix-table >>> .v-table .table-cell,
.matrix-table >>> .v-table-row {
  background: #272953;
  color: #fff;
}
</style>