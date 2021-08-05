<template>
  <div class="bd-table-field">
    <table class="table">
      <thead>
      <tr>
        <th></th>
        <th v-for="column in params.columns">
          {{ column.title }}
        </th>
      </tr>
      </thead>
      <tbody>
      <tr
          v-for="(item, index) in params.rows"
      >
        <td>
          <input
              v-model="item.checked"
              :value="item.id"
              type="checkbox"
              @change="updateValues"
          >
        </td>
        <td v-for="column in params.columns">
          {{ item[column.code] }}
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>

export default {
  name: "BigdataCheckboxTableField",
  props: {
    params: {
      type: Object,
      required: true
    },
  },
  data() {
    return {
      checkedValues: []
    }
  },
  watch: {
    checkedValues(val) {
      this.$emit('change', val)
    }
  },
  methods: {
    updateValues() {
      let values = this.params.rows.filter(row => row.checked === true).map(row => row.id)
      this.$emit('change', values)
    }
  }
};
</script>