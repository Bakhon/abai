<template>
  <div class="form-group">
    <label
        for="companySelect"
        class="text-wrap"
        style="color:white;">
      Выберите компанию
    </label>

    <select
        id="companySelect"
        class="form-control text-white"
        style="background-color: #20274e; border-color: #20274e;"
        @change="$emit('change', $event.target.value)"
    >
      <option
          v-for="org in organizations"
          :key="`org_${org.id}`"
          :value="org.id">
        {{ org.name }}
      </option>
    </select>
  </div>
</template>

<script>
export default {
  name: "EconomicSelectOrganization",
  props: {
    organizations: {
      required: true,
      type: Array
    }
  }
}
</script>

<style scoped>

</style>