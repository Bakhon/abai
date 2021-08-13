<template>
  <div class="container p-4 bg-light" style="max-width: 90vw">
    <vue-table-dynamic
        ref="table"
        :params="params"
        class="height-fit-content height-unset">
      <div slot="column-6" slot-scope="{ props }" class="mx-auto">
        <delete-button @click.native="deleteGtm(props.rowData[0].data)"/>
      </div>
    </vue-table-dynamic>
  </div>
</template>

<script>

import DeleteButton from "../components/DeleteButton";

export default {
  name: "economic-data-gtm-component",
  components: {
    DeleteButton
  },
  data: () => ({
    data: [],
    loading: false
  }),
  created() {
    this.getData()
  },
  methods: {
    async getData() {
      this.loading = true

      try {
        const {data} = await this.axios.get(this.localeUrl('/eco_refs_gtms'))

        this.data = [...[this.headers], ...data.data]
      } catch (e) {
        console.log(e)
      }

      this.loading = false
    },

    async deleteGtm(id) {
      try {
        await this.axios.delete(this.localeUrl(`/eco_refs_gtm/${id}`))

        let index = this.data.findIndex(x => x[0] === id)

        if (index !== -1) {
          this.data.splice(index, 1)
        }
      } catch (e) {
        console.log(e)
      }
    },
  },
  computed: {
    params() {
      return {
        data: this.data,
        enableSearch: true,
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
        'ID',
        this.trans('economic_reference.name'),
        this.trans('economic_reference.company'),
        this.trans('economic_reference.cost'),
        'pi',
        this.trans('economic_reference.comment'),
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
