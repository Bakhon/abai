<template>
  <div class="bd-main-block">
    <div class="bd-main-block__header">
      <p class="bd-main-block__header-title">{{ params.title }}</p>
    </div>
    <form v-if="formParams" ref="form" class="bd-main-block__form" style="width: 100%">
      <div class="bd-main-block__form-tabs-header">
        <template v-for="(tab, index) in formParams.tabs">
          <div
              class="bd-main-block__form-tabs-header-tab"
              :class="{'active': index === activeTab}"
              @click="changeTab(index)"
          >
            <p v-if="tab.title">{{ tab.title }}</p>
          </div>
        </template>
      </div>
      <template v-for="(tab, index) in formParams.tabs">
        <div class="bd-main-block__form-tab" v-show="index === activeTab">
          <div
              class="bd-main-block__form-block scrollable"
              :class="{'bd-main-block__form-block_full': tab.blocks.length === 1}"
              v-for="block in tab.blocks"
          >
            <template v-for="subBlock in block">
              <p v-if="subBlock.title" class="bd-main-block__form-block-title">{{ subBlock.title }}</p>
              <div class="bd-main-block__form-block-content">
                <div v-if="subBlock.component">
                  <component v-bind:is="subBlock.component" :form-params="params" :well-id="wellId"></component>
                </div>
                <template v-else>
                  <div
                      v-for="item in subBlock.items"
                      v-if="isShowField(item)"
                  >
                    <label>{{ item.title }}</label>
                    <bigdata-form-field
                        :id="wellId"
                        :key="`field_${item.code}`"
                        v-model="formValues[item.code]"
                        :error="errors[item.code]"
                        :form="params"
                        :item="item"
                        :editable="item.hasOwnProperty('editable') ? item.editable : true"
                        v-on:change="validateField($event, item)"
                        v-on:input="callback($event, item)"
                    >
                    </bigdata-form-field>
                  </div>
                </template>
              </div>
            </template>
          </div>
        </div>
      </template>
      <div class="bd-main-block__form-buttons">
        <button type="button" class="btn btn-success" @click="submit">
          {{ trans('app.save') }}
        </button>
        <button class="btn btn-info" type="reset" @click="cancel">
          {{ trans('app.cancel') }}
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import Vue from "vue";
import BigdataFormField from './field'
import BigdataPlainFormResults from './PlainFormResults'
import {bdFormActions, globalloadingMutations} from '@store/helpers'
import axios from "axios";


export default {
  name: "BigDataPlainForm",
  components: {
    BigdataFormField,
    BigdataPlainFormResults
  },
  props: {
    params: {
      type: Object,
      required: true
    },
    wellId: {
      type: Number,
      required: true
    },
    type: {
      type: String,
      required: true
    },
    values: {
      type: Object,
      required: false
    }
  },
  data() {
    return {
      formParams: null,
      errors: {},
      activeTab: 0,
      formValues: {},
      well: null
    }
  },
  computed: {
    formFields() {
      if (!this.formParams || !this.formParams.tabs) return []

      let fields = []
      for (const tab of this.formParams.tabs) {
        for (const blocks of tab.blocks) {
          blocks.forEach(block => {
            if (!block.items) return
            for (const item of block.items) {
              fields.push(item)
            }
          })
        }
      }
      return fields
    },
    formFilesToSubmit() {
      let files = {}
      for (let key in this.formValues) {
        let field = this.formFields.find(field => field.code === key)
        if (!field || field.type !== 'file') continue
        files[key] = this.formValues[key]
      }
      return files
    },
    formValuesToSubmit() {
      let values = {}
      for (let key in this.formValues) {
        let field = this.formFields.find(field => field.code === key)
        if (field && field.type === 'file') continue
        if (field && field.submit_value === false) continue
        if (field && field.type === 'calc' && field.submit_value !== true) continue
        values[key] = this.formValues[key]
      }
      return values
    }
  },
  watch: {
    params() {
      this.init()
    }
  },
  mounted() {
    this.init()
  },
  methods: {
    ...globalloadingMutations([
      'SET_LOADING'
    ]),
    ...bdFormActions([
      'getGeoDictByDZO',
      'updateForm',
      'submitForm',
      'getWellPrefix',
      'getValidationErrors'
    ]),
    init() {
      this.activeTab = 0

      if (this.values) {
        this.formValues = Object.assign({}, this.values)
        for (let i in this.formValues) {
          let value = this.formValues[i]
          if (value && typeof value === 'object' && value.value) {
            this.formValues[i] = value.value
          }
        }
      }

      this.updateForm(this.params.code)
          .then(data => {
            this.formParams = data

            this.formFields.filter(field => !!field.callbacks).forEach(field => {
              if (this.formValues[field.code]) {
                this.callback(null, field)
              }
            })
          })
          .catch(error => {
            this.$notifyError(error.response.data.text + "\r\n\r\n" + error.response.data.errors)
          })

      this.axios.get(this.localeUrl(`/api/bigdata/wells/${this.wellId}`)).then(({data}) => {
        this.well = data.well
      })

      let calculatedFields = this.formFields.filter(field => field.type === 'calc')
      if (calculatedFields.length > 0) {
        this.fillCalculatedFields()
      }

    },
    async submit() {

      this.SET_LOADING(true)

      let files = {}
      if (Object.keys(this.formFilesToSubmit).length > 0) {
        for (let key in this.formFilesToSubmit) {
          let formData = new FormData()
          let existedFiles = []
          this.formFilesToSubmit[key].forEach((file, index) => {
            if (file.exists) {
              existedFiles.push(file.id)
              return
            }
            formData.append(`uploads[]`, file.file)
          })

          if (formData.get('uploads[]') === null) {
            files[key] = existedFiles
            continue
          }

          let fileField = this.formFields.find(field => field.code === key)
          let origin = this.formValues[fileField.origin]
          formData.append('origin', origin)

          await axios.post(this.localeUrl('/attachments'), formData).then(({data}) => {
            files[key] = [...data.files, ...existedFiles]
          }).catch(() => {
            this.SET_LOADING(false)
          })
        }
      }

      this
          .submitForm({
            code: this.params.code,
            wellId: this.wellId,
            type: this.type,
            values: {...this.formValuesToSubmit, ...files}
          })
          .then(response => {

            this.SET_LOADING(false)

            this.errors = []
            this.$refs.form.reset()
            this.$notifySuccess('???????? ?????????? ?????????????? ????????????????????')
            this.$emit('change', {
              id: response.data.id,
              values: this.formValues
            })
            this.$emit('close')
            this.formValues = {}
          })
          .catch(error => {

            this.SET_LOADING(false)

            if (error.response.status === 500) {
              this.$notifyError(error.response.data.message)
              return false
            }

            if (error.response.status === 422) {

              this.errors = error.response.data.errors

              this.$notifyWarning('?????????????????? ???????? ?????????????????? ??????????????????????')

              for (const [tabIndex, tab] of Object.entries(this.formParams.tabs)) {
                for (const blocks of tab.blocks) {
                  blocks.forEach(block => {
                    for (const item of block.items) {
                      if (typeof this.errors[item.code] !== 'undefined') {
                        this.activeTab = parseInt(tabIndex)
                        return false
                      }
                    }
                  })
                }
              }
            }
          })
    },
    submitForm(params) {
      return axios.post(this.localeUrl(`/api/bigdata/forms/${params.code}`), {
        ...params.values,
        well: params.wellId,
        files: params.files
      })
    },
    cancel() {
      this.$emit('close')
    },
    changeTab(index) {
      this.activeTab = index
    },
    callback: _.debounce(function (e, formItem) {
      this.$nextTick(() => {
        if (typeof formItem.callbacks === 'undefined') return

        for (let callback in formItem.callbacks) {
          if (typeof this[callback] === 'undefined') continue
          this[callback](formItem.code, formItem.callbacks[callback])
        }
      })
    }, 350),
    fillCalculatedFields() {
      this.SET_LOADING(true)
      axios.post(
          this.localeUrl(`/api/bigdata/forms/${this.params.code}/calc-fields`),
          {
            values: this.formValues,
            well_id: this.wellId
          }
      ).then(({data}) => {
        for (let key in data) {
          this.formValues[key] = data[key]
        }
        this.$forceUpdate()
      }).finally(() => {
        this.SET_LOADING(false)
      })
    },
    updateFields() {
      this.SET_LOADING(true)
      axios.post(
          this.localeUrl(`/api/bigdata/forms/${this.params.code}/update-fields`),
          {
            values: this.formValues,
            well_id: this.wellId
          }
      ).then(({data}) => {
        for (let fieldCode in data) {
          let field = this.formFields.find(field => field.code === fieldCode)
          for (let key in data[fieldCode]) {
            field[key] = data[fieldCode][key]
          }
        }
      }).finally(() => {
        this.SET_LOADING(false)
      })
    },
    updateFieldList() {
      this.SET_LOADING(true)
      axios.post(
          this.localeUrl(`/api/bigdata/forms/${this.params.code}/update-field-list`),
          {
            values: this.formValues,
            well_id: this.wellId
          }
      ).then(({data}) => {
        this.formParams.tabs = data
      }).finally(() => {
        this.SET_LOADING(false)
      })
    },
    setWellPrefix(triggerFieldCode, changeFieldCode) {
      if (!this.formValues[triggerFieldCode]) return
      this.getWellPrefix({code: this.params.code, geo: this.formValues[triggerFieldCode]})
          .then(({data}) => {
            for (const tab of this.formParams.tabs) {
              for (const blocks of tab.blocks) {
                blocks.forEach(block => {
                  for (const item of block.items) {
                    if (item.code === changeFieldCode) {
                      item.prefix = data.prefix
                    }
                  }
                })
              }
            }
          })
    },
    filterGeoByDZO(triggerFieldCode, changeFieldCode) {

      let dictName
      this.formValues[changeFieldCode] = null

      this.formFields.forEach(field => {
        if (field.code === changeFieldCode) {
          dictName = field.dict
        }
      })

      if (this.formValues[triggerFieldCode]) {
        this.getGeoDictByDZO({
          dzo: this.formValues[triggerFieldCode],
          code: dictName
        })
      }

    },
    isShowField(field) {
      if (!field.depends_on) return true

      let isShowField = true
      field.depends_on.forEach(dependency => {
        if (dependency.value === false && !this.formValues[dependency.field]) {
          return;
        }

        if (this.formValues[dependency.field] !== dependency.value) {
          isShowField = false
        }
      })

      return isShowField

    },
    validateField: _.debounce(function (e, formItem) {
          this.$nextTick(() => {
            this.getValidationErrors({formCode: this.params.code, fieldCode: formItem.code, values: this.formValues})
                .then(data => {
                  Vue.set(this.errors, formItem.code, null)
                })
                .catch(error => {
                  Vue.set(this.errors, formItem.code, error.response.data.errors)
                })
          })
        },
        350
    )
  },
};
</script>
<style lang="scss" scoped>
.bd-main-block {

  &__form {
    &-tabs {
      &-header {
        display: flex;
        justify-content: flex-start;

        &-tab {
          align-items: center;
          background: #31335f;
          border-top-left-radius: 3px;
          border-top-right-radius: 3px;
          color: #8389AF;
          display: flex;
          font-size: 14px;
          font-weight: 600;
          margin-right: 15px;
          min-height: 28px;
          padding: 0 45px;
          @media (max-width: 768px) {
            padding: 0 15px;
          }

          &:hover {
            color: #fff;
          }

          &.active {
            background: #363b68;
            color: #fff;
          }

          p {
            margin-bottom: 0;
          }
        }
      }
    }

    &-tab {
      background: #363b68;
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      padding: 10px;
    }

    &-block {
      background: #272953;
      border-left: 1px solid #454D7D;
      overflow-y: visible;
      width: 50%;
      @media (max-width: 767px) {
        border-left: none;
        height: auto;
        width: 100%;
      }

      &_full {
        width: 100%;
      }

      &:first-child {
        border-left: none;
      }

      &-title {
        background: #333975;
        color: #FFFFFF;
        font-weight: bold;
        font-size: 14px;
        height: 48px;
        line-height: 48px;
        margin-bottom: 0;
        padding: 0 0 0 43px;
      }

      &-content {
        padding: 20px 55px 10px 43px;
        @media (max-width: 767px) {
          height: auto;
        }

        &::-webkit-scrollbar {
          width: 4px;
        }

        &::-webkit-scrollbar-track {
          background: #20274F;
        }

        &::-webkit-scrollbar-thumb {
          background: #656A8A;
        }

        &::-webkit-scrollbar-thumb:hover {
          background: #656A8A;
        }

        &::-webkit-scrollbar-corner {
          background: #20274F;
        }

        label {
          font-size: 14px;
          font-weight: 600;
          line-height: 1;
          margin: 14px 0 10px;
        }

        & > div:first-child {
          label {
            margin-top: 0;
          }
        }

      }
    }

    &-buttons {
      background: #363b68;
      display: flex;
      justify-content: flex-end;
      padding: 0 20px 10px;

      button {
        background: #3366FF;
        border: none;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        margin-left: 8px;
        width: 116px;

        &.btn-info {
          background: #40467E;
        }
      }
    }
  }
}
</style>