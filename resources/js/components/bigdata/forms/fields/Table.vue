<template>
  <div class="bd-table-field">
    <div class="bd-table-field__buttons">
      <a class="bd-table-field__buttons-button bd-table-field__buttons-button_add" href="#"
         @click.prevent="openCreateForm">Добавить</a>
      <a :class="{'bd-table-field__buttons-button_disabled': selectedItemIndex === null}"
         class="bd-table-field__buttons-button bd-table-field__buttons-button_edit" href="#"
         @click.prevent="openEditForm(selectedItemIndex)">Редактировать</a>
      <a :class="{'bd-table-field__buttons-button_disabled': selectedItemIndex === null}"
         class="bd-table-field__buttons-button bd-table-field__buttons-button_remove" href="#"
         @click.prevent="deleteItem(selectedItemIndex)">Удалить</a>
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
      <tr v-for="(item, index) in items" :class="{'selected': selectedItemIndex === index}"
          @click="selectedItemIndex = index">
        <td v-for="column in params.columns">
          {{ item[column.code].text }}
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
                v-bind:value="formValues[column.code].value"
                v-on:update="updateField($event, column)"
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
      formValues: {},
      selectedItemIndex: null
    }
  },
  methods: {
    openCreateForm() {
      this.editedItemIndex = null
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
      this.selectedItemIndex = null

      if (this.editedItemIndex !== null) {
        this.$set(this.items, this.editedItemIndex, this.formValues)
      } else {
        this.items.push(this.formValues)
      }

      let items = this.items.map(item => {
        let result = {};
        Object.keys(item).forEach(key => {
          result[key] = item[key].value
        })
        return result
      })

      this.$emit('change', items)

    },
    deleteItem(index) {
      if (index === null) return
      this.items.splice(index, 1)
      this.selectedItemIndex = null
    },
    updateField(event, column) {
      this.formValues[column.code] = event
    }
  }
};
</script>
<style lang="scss">
.bd-table-field {
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