<template>
  <div>
    <select-author
        :form="form"
        :url="localeUrl('/economic/gtm_value/get-authors')"/>

    <select-log
        v-if="form.author_id"
        :form="form"
        :fetch-params="{author_id: form.author_id, type_id: EconomicDataLogTypeModel.GTM_VALUE}"
        class="mt-3"
        @change="getData()"/>

    <vue-table-dynamic
        ref="table"
        :params="params"
        class="height-fit-content height-unset">
      <div slot="column-7" slot-scope="{ props }" class="mx-auto">
        <delete-button @click.native="deleteItem(props.rowData[0].data)"/>
      </div>
    </vue-table-dynamic>
  </div>
</template>

<script>
import {globalloadingMutations} from '@store/helpers';

import SelectAuthor from "./SelectAuthor";
import SelectLog from "./SelectLog";
import DeleteButton from "./DeleteButton";

import {EconomicDataLogTypeModel} from "../models/EconomicDataLogTypeModel";

export default {
  name: "GtmValueTable",
  components: {
    SelectAuthor,
    SelectLog,
    DeleteButton
  },
  data: () => ({
    EconomicDataLogTypeModel,
    data: [],
    form: {
      author_id: null,
      log_id: null
    }
  }),
  methods: {
    ...globalloadingMutations(['SET_LOADING']),

    async getData() {
      this.SET_LOADING(true);

      try {
        const {data} = await this.axios.get(this.localeUrl('/economic/gtm_value/get-data'))

        this.data = [...[this.headers], ...data.data]
      } catch (e) {
        console.log(e)
      }

      this.SET_LOADING(false);
    },

    async deleteItem(id) {
      this.SET_LOADING(true);

      try {
        await this.axios.delete(this.localeUrl(`/economic/gtm_value/${id}`))

        let index = this.data.findIndex(x => x[0] === id)

        if (index !== -1) {
          this.data.splice(index, 1)
        }
      } catch (e) {
        console.log(e)
      }

      this.SET_LOADING(false);
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
        this.trans('app.date'),
        this.trans('economic_reference.gtm_view'),
        this.trans('economic_reference.priority'),
        this.trans('economic_reference.gtm_growth'),
        this.trans('economic_reference.gtm_amount'),
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
