<template>
  <select
      v-model="form.field_id"
      class="form-control text-white bg-main4-important border-0"
      @change="$emit('change')"
  >
    <option
        v-for="field in fields"
        :key="field.id"
        :value="field.id">
      {{ field.name }}
    </option>
  </select>
</template>

<script>
export default {
  name: "SelectField",
  props: {
    form: {
      required: true,
      type: Object
    },
    org_id: {
      required: true,
      type: Number
    }
  },
  data: () => ({
    fields: []
  }),
  created() {
    this.getFields()
  },
  methods: {
    async getFields() {
      this.form.field_id = null

      this.fields = [{
        id: null,
        name: this.trans('economic_reference.select_field')
      }]

      const params = {org_id: this.form.org_id}

      const {data} = await this.axios.get(this.localeUrl('/fields'), {params: params})

      this.fields = [...this.fields, ...data.fields]
    },
  },
  watch: {
    org_id() {
      this.getFields()
    }
  }

}
</script>

<style scoped>
.bg-main4-important {
  background-color: #333975;
}
</style>