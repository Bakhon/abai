<template>
  <select
      v-if="hideLabel"
      v-model="form.org_id"
      class="form-control text-white bg-main4-important border-0"
      @change="$emit('change')"
  >
    <option
        v-for="org in organizations"
        :key="org.id"
        :value="org.id">
      {{ org.name }}
    </option>
  </select>

  <div v-else>
    <label for="org">
      {{ trans('economic_reference.org') }}
    </label>

    <select
        id="org"
        v-model="form.org_id"
        class="form-control text-white bg-main4-important border-0"
        @change="$emit('change')"
    >
      <option
          v-for="org in organizations"
          :key="org.id"
          :value="org.id">
        {{ org.name }}
      </option>
    </select>
  </div>
</template>

<script>
export default {
  name: "SelectOrganization",
  props: {
    form: {
      required: true,
      type: Object
    },
    hideLabel: {
      required: false,
      type: Boolean
    }
  },
  data: () => ({
    organizations: []
  }),
  created() {
    this.getOrganizations()
  },
  methods: {
    async getOrganizations() {
      const {data} = await this.axios.get(this.localeUrl('/organizations'))

      this.organizations = data.organizations

      if (!this.organizations.length || this.form.org_id) return

      this.form.org_id = this.organizations[0].id

      this.$emit('change')
    },
  }
}
</script>

<style scoped>
.bg-main4-important {
  background-color: #333975;
}
</style>