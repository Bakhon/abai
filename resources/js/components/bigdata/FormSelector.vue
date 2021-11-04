<template>
  <div class="asside-db-tab-content__item asside-db-tab-content__item--form">
    <div class="asside-db-form">
      <template
          v-for="directory in filteredFormStructure"
      >
        <div class="asside-db-form__title" v-html="directory.name"></div>
        <ul class="asside-db-form__list">
          <li
              v-for="form in directory.forms"
              :key="`form_${form.code}`"
              v-html="form.name"
              @click="loadForm(form)"
          ></li>
        </ul>
      </template>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    currentWellId: {
      type: Number,
      required: false
    },
    query: {
      type: String,
      required: false,
      default: ''
    }
  },
  data() {
    return {
      formsStructure: []
    }
  },
  computed: {
    filteredFormStructure() {

      let result = []
      this.formsStructure.forEach(section => {
        if (!section.isVisible) return false

        let forms = []
        section.forms.forEach(form => {
          if (!form.isVisible) return false
          if (this.query && form.name.toLowerCase().indexOf(this.query.trim().toLowerCase()) === -1) return false
          forms.push(form)
        })

        if (forms.length === 0) {
          return null
        }

        result.push({...section, ...{forms: forms}})
      })
      return result
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