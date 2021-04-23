<template>
  <div class="bd-main-block__table">
    <table v-if="rows" class="table">
      <thead>
      <tr>
        <th>ID</th>
        <th v-for="column in columns">{{ column.title }}</th>
        <th></th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(row, index) in rows">
        <td>{{ row.id }}</td>
        <td v-for="column in columns">
          {{ row[column.code] }}
        </td>
        <td>
          <a href="#" @click.prevent="editRow(row)">Редактировать</a>
          <a href="#" @click.prevent="deleteRow(row, index)">Удалить</a>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: "BigdataPlainFormResults",
  props: {
    params: {
      type: Object,
      required: true
    },
    wellId: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      rows: null,
      columns: null
    }
  },
  watch: {
    params() {
      this.init()
    }
  },
  mounted() {
    this.init()
  },
  methods: {
    init() {
      this.axios.get(
          this.localeUrl(`/api/bigdata/forms/${this.params.code}/results`),
          {params: {well_id: this.wellId}}
      ).then(({data}) => {
        this.rows = data.rows
        this.columns = data.columns
      })
    },
    editRow(row) {
      this.$emit('edit', row)
    },
    deleteRow(row, rowIndex) {
      this.axios.delete(this.localeUrl(`/api/bigdata/forms/${this.params.code}/${row.id}`)).then(({data}) => {
        this.rows.splice(rowIndex, 1)
      })
    }
  }
}
</script>
<style lang="scss" scoped>
.bd-main-block {
  &__table {
    .table {
      color: #fff;
    }
  }
}
</style>