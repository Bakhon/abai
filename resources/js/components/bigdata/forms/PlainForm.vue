<template>
  <div class="bd-main-block">
    <cat-loader v-if="isLoading"></cat-loader>
    <notifications position="top"></notifications>
    <div class="bd-main-block__header">
      <p class="bd-main-block__header-title">{{ params.title }}</p>
    </div>
    <form class="bd-main-block__form" style="width: 100%" ref="form">
      <div class="bd-main-block__form-tabs-header">
        <template v-for="(tab, index) in formParams.tabs">
          <div
              class="bd-main-block__form-tabs-header-tab"
              :class="{'active': index === activeTab}"
              @click="changeTab(index)"
          >
            <p>{{ tab.title }}</p>
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
                <div
                    v-for="item in subBlock.items"
                >
                  <label>{{ item.title }}</label>
                  <bigdata-form-field
                      v-model="formValues[item.code]"
                      :error="errors[item.code]"
                      :item="item"
                      v-on:change="validateField($event, item)"
                      v-on:input="callback($event, item)"
                  >
                  </bigdata-form-field>
                </div>
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
import BigdataFormField from './field'
import {bdFormActions, bdFormState} from '@store/helpers'

export default {
  name: "BigDataPlainForm",
  components: {
    BigdataFormField,
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
    values: {
      type: Object,
      required: false
    }
  },
  data() {
    return {
      errors: {},
      activeTab: 0,
      formValues: {},
      well: null,
      isLoading: false
    }
  },
  computed: {
    ...bdFormState([
      'formParams'
    ]),
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
    ...bdFormActions([
      'getGeoDictByDZO',
      'updateForm',
      'submitForm',
      'getWellPrefix',
      'getValidationErrors'
    ]),
    init() {
      this.activeTab = 0
      this.updateForm(this.params.code)
          .catch(error => {
            Vue.prototype.$notifyError(error.response.data.text + "\r\n\r\n" + error.response.data.errors)
          })

      this.axios.get(this.localeUrl(`/api/bigdata/wells/${this.wellId}`)).then(({data}) => {
        this.well = data.well
      })

      if (this.values) {
        this.formValues = this.values
      }
    },
    submit() {

      this
          .submitForm({
            code: this.params.code,
            wellId: this.wellId,
            values: this.formValues
          })
          .then(data => {
            this.errors = []
            Object.keys(this.formValues).forEach(key => {
              this.formValues[key] = ''
            })
            this.$refs.form.reset()
            Vue.prototype.$notifySuccess('Ваша форма успешно отправлена')
            this.$emit('change')
            this.$emit('close')
          })
          .catch(error => {

            if (error.response.status === 500) {
              Vue.prototype.$notifyError(error.response.data.message)
              return false
            }

            if (error.response.status === 422) {

              this.errors = error.response.data.errors

              Vue.prototype.$notifyWarning('Некоторые поля заполнены некорректно')

              for (const [tabIndex, tab] of Object.entries(this.formParams.tabs)) {
                for (const block of tab.blocks) {
                  for (const item of block.items) {
                    if (typeof this.errors[item.code] !== 'undefined') {
                      this.activeTab = parseInt(tabIndex)
                      return false
                    }
                  }
                }
              }

            }
          })
    },
    cancel() {
      this.$emit('close')
    },
    changeTab(index) {
      this.activeTab = index
    },
    callback(e, formItem) {
      if (typeof formItem.callbacks === 'undefined') return

      for (let callback in formItem.callbacks) {
        if (typeof this[callback] === 'undefined') continue
        this[callback](formItem.code, formItem.callbacks[callback])
      }
    },
    fillCalculatedFields(triggerFieldCode) {
      this.isLoading = true
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
      }).finally(() => {
        this.isLoading = false
      })

    },
    setWellPrefix(triggerFieldCode, changeFieldCode) {
      this.getWellPrefix({code: this.params.code, geo: this.formValues[triggerFieldCode]})
          .then(({data}) => {
            for (const tab of this.formParams.tabs) {
              for (const block of tab.blocks) {
                for (const item of block.items) {
                  if (item.code === changeFieldCode) {
                    item.prefix = data.prefix
                  }
                }
              }
            }
          })
    },
    filterGeoByDZO(triggerFieldCode, changeFieldCode) {

      let dictName
      this.formValues[changeFieldCode] = null
      for (const tab of this.formParams.tabs) {
        for (const block of tab.blocks) {
          for (const item of block.items) {
            if (item.code === changeFieldCode) {
              dictName = item.dict
            }
          }
        }
      }

      this.getGeoDictByDZO({
        dzo: this.formValues[triggerFieldCode],
        code: dictName
      })

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
          height: 28px;
          margin-right: 15px;
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
      height: 600px;
      overflow-y: auto;
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