<template>
  <div class="asside-db-tab-content__item asside-db-tab-content__item--form">
    <div class="asside-db-form">
      <template
          v-for="directory in formsStructure"
      >
        <div class="asside-db-form__title" v-html="directory.name"></div>
        <ul class="asside-db-form__list">
          <li
              v-for="form in directory.forms"
              :key="`form_${form.code}`"
              v-html="form.name"
          ></li>
        </ul>
      </template>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      formsStructure: [],
      formNameQuery: null
    }
  },
  computed: {
    filteredForms() {
      return this.formsStructure.filter(form => {
        if (!form.isVisible) return false
        if (this.formNameQuery && form.name.toLowerCase().indexOf(this.formNameQuery.trim().toLowerCase()) === -1) return false
        return true
      })
    }
  },
  mounted() {

    this.axios
        .get(this.localeUrl("api/bigdata/forms/tree"))
        .then(({data}) => {
          this.formsStructure = data.tree;
        })
  },
  methods: {
    loadForm(form) {
      this.$emit('selected', form)
    }
  }
}
</script>