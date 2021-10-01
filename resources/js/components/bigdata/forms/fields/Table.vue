<template>
  <div
      :class="{'bd-table-field_form': params.form}"
      class="bd-table-field"
  >
    <div class="bd-table-field__buttons">
      <a class="bd-table-field__buttons-button bd-table-field__buttons-button_add" href="#"
         @click.prevent="openCreateForm">{{ trans('app.create') }}</a>
      <a :class="{'bd-table-field__buttons-button_disabled': selectedRowIndex === null}"
         class="bd-table-field__buttons-button bd-table-field__buttons-button_edit" href="#"
         @click.prevent="openEditForm(selectedRowIndex)">{{ trans('app.edit') }}</a>
      <a :class="{'bd-table-field__buttons-button_disabled': selectedRowIndex === null}"
         class="bd-table-field__buttons-button bd-table-field__buttons-button_remove" href="#"
         @click.prevent="deleteItem(selectedRowIndex)">{{ trans('app.delete') }}</a>
    </div>
    <div class="table__wrap scrollable">
      <template v-if="params.form">
        <table class="table">
          <thead>
          <tr>
            <th v-for="field in params.columns">
              {{ field.title }}
            </th>
          </tr>
          </thead>
          <tbody>
          <tr
              v-for="(item, index) in items"
              :class="{'selected': selectedRowIndex === index}"
              @click="selectedRowIndex = index"
          >
            <td v-for="column in params.columns">
              {{ item.values[column.code] }}
            </td>
          </tr>
          </tbody>
        </table>
      </template>
      <template v-else>
        <table class="table">
          <thead>
          <tr>
            <th v-for="column in params.columns">
              {{ column.title }}
            </th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(item, index) in items" :class="{'selected': selectedRowIndex === index}"
              @click="selectedRowIndex = index">
            <td v-for="column in params.columns">
              <template v-if="column.type === 'date'">
                {{ item[column.code].text | moment().format('DD.MM.YYYY') }}
              </template>
              <template v-else-if="column.type === 'datetime'">
                {{ item[column.code].text | moment().format('DD.MM.YYYY HH:MM') }}
              </template>
              <template v-else>
                {{ item[column.code].text }}
              </template>
            </td>
          </tr>
          </tbody>
        </table>
      </template>
    </div>
    <div v-if="isFormOpened" class="bd-popup">
      <div class="bd-popup__inner">
        <a class="bd-popup__close" href="#" @click.prevent="isFormOpened = false">{{ trans('bd.close') }}</a>
        <template v-if="params.form">
          <BigDataPlainForm
              :params="formParams"
              :values="formValues"
              :well-id="id"
              @change="updateResults"
              @close="isFormOpened = false"
          >
          </BigDataPlainForm>
        </template>
        <template v-else>
          <div class="bd-main-block__form-block-content">
            <div
                v-for="column in params.columns"
            >
              <label>{{ column.title }}</label>
              <bigdata-form-field
                  :error="errors[column.code]"
                  :item="column"
                  v-bind:value="formValues[column.code].value"
                  v-on:change="validateField($event, column)"
                  v-on:update="updateField($event, column)"
              >
              </bigdata-form-field>
            </div>
          </div>

          <div class="bd-popup__buttons">
            <button
                class="btn btn-success"
                type="button"
                @click="saveItem"
            >
              {{ trans('app.save') }}
            </button>
            <button class="btn btn-info" type="reset" @click="isFormOpened = false">
              {{ trans('app.cancel') }}
            </button>
          </div>
        </template>
      </div>
    </div>
  </div>
</template>

<script>
import forms from '../../../../json/bd/forms.json'
import Vue from "vue";
import axios from "axios";

export default {
  name: "BigdataTableField",
  props: {
    values: {
      type: Array,
      required: false
    },
    params: {
      type: Object,
      required: true
    },
    form: {
      type: Object,
      required: true
    },
    id: {
      type: Number,
      required: true
    }
  },
  components: {
    BigDataPlainForm: () => import('../PlainForm'),
    BigdataFormField: () => import('../field')
  },
  data() {
    return {
      forms: forms,
      isFormOpened: false,
      formParams: null,
      editedItemIndex: null,
      items: [],
      errors: {},
      formValues: {},
      selectedRowIndex: null
    }
  },
  mounted() {
    this.initValues()
  },
  methods: {
    initValues() {
      if (!this.values) return

      if (this.params.form) {
        this.items = this.values
        return
      }

      this.items = this.values.map(value => {
        let obj = {}
        for (let i in value) {
          obj[i] = {
            value: value[i]
          }
        }
        return obj
      })

    },
    openCreateForm() {
      this.editedItemIndex = null

      if (this.params.form) {
        this.formParams = this.forms.find(form => form.code === this.params.form)
        this.formValues = {}
        this.isFormOpened = true
        return
      }

      this.isFormOpened = true
      let formValues = {}
      this.params.columns.forEach(column => {
        formValues[column.code] = {value: null, text: ''}
      })
      this.formValues = formValues

    },
    openEditForm(index) {
      if (index === null) return
      let item = this.items[index]

      if (this.params.form) {
        this.formParams = this.forms.find(form => form.code === this.params.form)
        this.formValues = item
        this.isFormOpened = true
        return
      }

      this.editedItemIndex = index
      this.isFormOpened = true
      let formValues = []
      this.params.columns.forEach(column => {
        formValues[column.code] = item[column.code]
      })
      this.formValues = formValues

    },
    saveItem() {

      this.isFormOpened = false
      this.selectedRowIndex = null

      if (this.editedItemIndex !== null) {
        this.$set(this.items, this.editedItemIndex, this.formValues)
      } else {
        this.items.push(this.formValues)
      }

      this.updateParentField()
    },
    deleteItem(index) {
      if (index === null) return
      this.items.splice(index, 1)
      this.selectedRowIndex = null

      this.updateParentField()
    },
    updateParentField() {

      let items = this.items.map(item => {
        let result = {};
        Object.keys(item).forEach(key => {
          result[key] = item[key].value
        })
        return result
      })

      this.$emit('change', items)

    },
    updateField(event, column) {
      this.formValues[column.code] = event
    },
    updateResults(event) {
      this.items.push(event)

      this.$emit('change', this.items.map(row => row.id))

    },
    validateField: _.debounce(function (e, formItem) {
          this.$nextTick(() => {

            let data = {}
            for (let i in this.formValues) {
              data[i] = this.formValues[i].value
            }

            axios.post(
                this.localeUrl(`/api/bigdata/forms/${this.form.code}/validate/${this.params.code}/${formItem.code}`),
                data
            ).then(data => {
              Vue.set(this.errors, formItem.code, null)
            }).catch(error => {
              Vue.set(this.errors, formItem.code, error.response.data.errors)
            })

          })
        },
        350
    )
  }
};
</script>
<style lang="scss">
.bd-table-field {

  &_form {
    min-height: 500px;
  }

  &__buttons {
    align-items: center;
    display: flex;
    margin-bottom: 20px;

    &-button {
      align-items: center;
      background-size: 16px;
      background-position: 0 50%;
      background-repeat: no-repeat;
      color: #fff;
      display: flex;
      font-size: 14px;
      height: 16px;
      font-weight: bold;
      margin-right: 45px;
      padding-left: 28px;
      text-decoration: none;

      &_add {
        background-image: url('/img/bd/add.svg');
      }

      &_edit {
        background-image: url('/img/bd/edit.svg');
      }

      &_remove {
        background-image: url('/img/bd/remove.svg');
      }

      &_disabled {
        opacity: 0.5;
      }

      &:hover {
        color: #fff;
        text-decoration: none;
      }
    }
  }


  .table {
    color: #fff;
    font-size: 14px;

    &__wrap {
      overflow-y: auto;
    }

    th {
      background: #2b2e5e;
      border: none;
      border-top: 1px solid #3c4270;
      border-bottom: 1px solid #3c4270;
      padding: 5px;
      text-align: center;
      vertical-align: middle;

      &:nth-child(2n + 1) {
        background: #2b40a9;
      }
    }

    tbody {
      tr {
        &.selected {
          filter: saturate(2);
        }

        td {
          background: #2b2e5e;
          border: none;

          &:nth-child(2n + 1) {
            background: #343868;
          }

          a {
            color: #82BAFF;
          }
        }

        &:nth-child(2n + 1) {
          td {
            background: #343868;

            &:nth-child(2n + 1) {
              background: #383d6d;
            }
          }
        }
      }
    }
  }
}
</style>