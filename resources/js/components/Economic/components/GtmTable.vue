<template>
  <div>
    <select
        v-model="form.author_id"
        class="form-control"
        @change="getData()"
    >
      <option :value="null" disabled selected>
        {{ trans('economic_reference.select_user') }}
      </option>

      <option
          v-for="author in authors"
          :key="author.id"
          :value="author.id">
        {{ author.name }}
      </option>
    </select>

    <vue-table-dynamic
        ref="table"
        :params="params"
        class="height-fit-content height-unset">
      <div slot="column-6" slot-scope="{ props }" class="mx-auto">
        <delete-button @click.native="deleteItem(props.rowData[0].data)"/>
      </div>
    </vue-table-dynamic>
  </div>
</template>

<script>
import {globalloadingMutations} from '@store/helpers';

import DeleteButton from "./DeleteButton";

export default {
  name: "GtmTable",
  components: {
    DeleteButton
  },
  data: () => ({
    data: [],
    authors: [],
    form: {
      author_id: null
    }
  }),
  created() {
    this.getAuthors()
  },
  methods: {
    ...globalloadingMutations(['SET_LOADING']),

    async getData() {
      this.SET_LOADING(true);

      try {
        const {data} = await this.axios.get(this.localeUrl('/economic/gtm/get-data'), {params: this.form})

        this.data = [...[this.headers], ...data.data]
      } catch (e) {
        console.log(e)
      }

      this.SET_LOADING(false);
    },

    async getAuthors() {
      this.SET_LOADING(true);

      try {
        const {data} = await this.axios.get(this.localeUrl('/economic/gtm/get-authors'))

        this.authors = data
      } catch (e) {
        console.log(e)
      }

      this.SET_LOADING(false);
    },

    async deleteItem(id) {
      this.SET_LOADING(true);

      try {
        await this.axios.delete(this.localeUrl(`/economic/gtm/${id}`))

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
        this.trans('economic_reference.name'),
        this.trans('economic_reference.company'),
        this.trans('economic_reference.cost'),
        'pi',
        this.trans('economic_reference.comment'),
        '',
      ]
    },
  }
}
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