<template>
  <div class="bd-table-field">
    <div class="bd-table-field__buttons">
      <a class="bd-table-field__buttons-button" href="#" @click.prevent="openCreateForm">Добавить</a>
      <a class="bd-table-field__buttons-button" href="#">Редактировать</a>
      <a class="bd-table-field__buttons-button" href="#">Удалить</a>
    </div>
    <table class="table">
      <thead>
      <tr>
        <th v-for="column in params.columns">
          {{ column.title }}
        </th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="item in items">
        <td v-for="column in params.columns">
          {{ item[column.code] }}
        </td>
      </tr>
      </tbody>
    </table>

    <div v-if="isFormOpened" class="bd-popup">
      <div class="bd-popup__inner">
        <a class="bd-popup__close" href="#" @click.prevent="isFormOpened = false">{{ trans('bd.close') }}</a>
        <div class="bd-main-block__form-block-content">
          <div
              v-for="column in params.columns"
          >
            <label>{{ column.title }}</label>
            <bigdata-form-field
                v-model="formValues[column.code]"
                :error="errors[column.code]"
                :item="column"
            >
            </bigdata-form-field>
          </div>
        </div>

        <div class="bd-popup__buttons">
          <button class="btn btn-success" type="button" @click="saveItem">
            {{ trans('app.save') }}
          </button>
          <button class="btn btn-info" type="reset" @click="isFormOpened = false">
            {{ trans('app.cancel') }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: "BigdataTableField",
  props: {
    params: {
      type: Object,
      required: true
    },
  },
  components: {
    BigdataFormField: () => import('../field')
  },
  data() {
    return {
      isFormOpened: false,
      editedItemIndex: null,
      items: [],
      errors: [],
      formValues: []
    }
  },
  methods: {
    openCreateForm() {
      this.editedItemIndex = null
      this.isFormOpened = true
      let formValues = []
      this.params.columns.forEach(column => {
        formValues[column.code] = null
      })
      this.formValues = formValues
    },
    openEditForm(item, index) {
      this.editedItemIndex = index
      this.isFormOpened = true
      let formValues = []
      this.params.columns.forEach(column => {
        formValues[column.code] = item[column.code]
      })
      this.formValues = formValues
    },
    saveItem() {

      if (this.editedItemIndex !== null) {
        this.$set(this.items, this.editedItemIndex, this.formValues)
        return
      }

      this.items.push(this.formValues)

      this.isFormOpened = false

    }
  }
};
</script>
<style lang="scss">

</style>