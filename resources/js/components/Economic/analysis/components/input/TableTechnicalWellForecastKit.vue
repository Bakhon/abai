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
  name: "TableTechnicalWellForecastKit",
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

      this.data = [this.headers]

      try {
        const {data} = await this.axios.get(`${this.url}/get-data`)

        data.forEach(kit => {
          this.data.push([
            kit.id,
            kit.name,
            kit.economic_log ? kit.economic_log.name : '',
            kit.technical_log ? kit.technical_log.name : '',
            kit.user ? `${kit.created_at} ${kit.user.name}` : '',
            ''
          ])
        })

      } catch (e) {
        console.log(e)
      }

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
      return this.localeUrl('/economic/technical/well_forecast/kit')
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
        'id',
        this.trans('economic_reference.name'),
        this.trans('economic_reference.economic_data'),
        this.trans('economic_reference.technical_data'),
        this.trans('economic_reference.added_date_author'),
        '',
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
