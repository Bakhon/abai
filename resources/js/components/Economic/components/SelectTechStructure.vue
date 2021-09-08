<template>
  <select
      v-model="form[`${formKey}_id`]"
      class="form-control text-white bg-dark border-0"
      @change="$emit('change')"
  >
    <option :value="null" disabled selected>
      {{ trans('app.select') }} {{ formKey }}
    </option>

    <option
        v-for="item in items"
        :key="item.id"
        :value="item.id">
      {{ item.name }}
    </option>
  </select>
</template>

<script>
export default {
  name: "SelectTechStructure",
  props: {
    form: {
      required: true,
      type: Object
    },
    formKey: {
      required: true,
      type: String
    },
    fetchParams: {
      required: false,
      type: Object
    }
  },
  data: () => ({
    items: []
  }),
  computed: {
    url() {
      return this.localeUrl(`/tech-struct-${this.formKey}/get-data`)
    }
  },
  created() {
    this.getData()
  },
  methods: {
    async getData() {
      const {data} = await this.axios.get(this.url, {params: this.fetchParams})

      this.items = data
    },
  },
  watch: {
    fetchParams() {
      this.getData()
    }
  }
}
</script>

<style scoped>
.bg-dark {
  background-color: #333975;
}
</style>