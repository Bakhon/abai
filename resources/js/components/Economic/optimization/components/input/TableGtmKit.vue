<template>
  <vue-table-dynamic
      ref="table"
      :params="params"
      class="height-fit-content height-unset">
    <div slot="column-5" slot-scope="{ props }" class="mx-auto">
      <delete-button @click.native="deleteKit(props.rowData[0].data)"/>
    </div>
  </vue-table-dynamic>
</template>

<script>
import {globalloadingMutations} from '@store/helpers';

import DeleteButton from "../../../components/DeleteButton";

export default {
  name: "TableGtmKit",
  components: {
    DeleteButton
  },
  data: () => ({
    data: [],
  }),
  created() {
    this.getData()
  },
  methods: {
    ...globalloadingMutations(['SET_LOADING']),

    async getData() {
      this.SET_LOADING(true)

      this.data = [this.headers.map(header => header.label)]

      const {data} = await this.axios.get(`${this.url}/get-data`)

      data.forEach(item => {
        let row = []

        this.headers.forEach(header => {
          if (header.isUser) {
            return row.push(item[header.key] ? `${item.created_at} ${item[header.key].name}` : '')
          }

          if (header.isRelationName) {
            return row.push(item[header.key] ? item[header.key].name : '')
          }

          row.push(item[header.key])
        })

        this.data.push(row)
      })

      this.SET_LOADING(false)
    },

    async deleteKit(id) {
      this.SET_LOADING(true)

      try {
        await this.axios.delete(`${this.url}/${id}`)

        let index = this.data.findIndex(x => x[0] === id)

        if (index !== -1) {
          this.data.splice(index, 1)
        }
      } catch (e) {
        console.log(e)
      }

      this.SET_LOADING(false)
    },
  },
  computed: {
    url() {
      return this.localeUrl('/economic/gtm/kit')
    },

    params() {
      return {
        data: this.data,
        whiteSpace: 'normal',
        header: 'row',
        border: true,
        stripe: true,
        pagination: true,
        pageSize: 12,
        pageSizes: [12, 24, 48],
        headerHeight: 80,
        rowHeight: 50,
      }
    },

    headers() {
      return [
        {
          label: 'id',
          key: 'id',
        },
        {
          label: this.trans('economic_reference.name'),
          key: 'name',
        },
        {
          label: this.trans('economic_reference.economic_data'),
          key: 'gtm_log',
          isRelationName: true
        },
        {
          label: this.trans('economic_reference.technical_data'),
          key: 'gtm_value_log',
          isRelationName: true
        },
        {
          label: this.trans('economic_reference.added_date_author'),
          key: 'user',
          isUser: true
        },
        {
          label: '',
          key: 'deleted_btn',
        },
      ]
    },
  }
};
</script>
<style scoped>
.height-fit-content >>> .v-table-body {
  height: fit-content !important;
}

.height-unset >>> .v-table-row {
  height: unset !important;
  padding: 5px 0;
}
</style>
