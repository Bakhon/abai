<template>
  <div class="bd-main-block">
    <notifications position="top"></notifications>
    <div class="bd-main-block__header">
      <p class="bd-main-block__header-title">{{ params.title }}</p>
    </div>
    <form ref="form" class="bd-main-block__form" style="width: 100%">
      <div class="bd-main-block__form-tabs-header">
        <template v-for="(tab, index) in form.tabs">
          <div
              :class="{'active': index === activeTab}"
              class="bd-main-block__form-tabs-header-tab"
              @click="changeTab(index)"
          >
            <p>{{ tab.title }}</p>
          </div>
        </template>
      </div>
      <template v-for="(tab, index) in form.tabs">
        <div v-show="index === activeTab" class="bd-main-block__form-tab">
          <div
              v-for="block in tab.blocks"
              :class="{'bd-main-block__form-block_full': tab.blocks.length === 1}"
              class="bd-main-block__form-block"
          >
            <p v-if="block.title" class="bd-main-block__form-block-title">{{ block.title }}</p>
            <div class="bd-main-block__form-block-content">
              <div
                  v-for="item in block.items"
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
          </div>
        </div>
      </template>
      <div class="bd-main-block__form-buttons">
        <button class="btn btn-success" type="button" @click="submit">
          {{ trans('app.save') }}
        </button>
        <button class="btn btn-info" type="reset">
          {{ trans('app.cancel') }}
        </button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: "bigdata-form",
  props: {
    params: {
      type: Object,
      required: true
    },
  },
  data() {
    return {
      errors: {},
      formValues: {},
      form: {},
      activeTab: 0
    }
  },
  mounted() {

    this.axios.get(this.localeUrl('/bigdata/form/' + this.params.code)).then(({data}) => {
      this.form = data.params
      this.formValues = data.fields
    })

  },
  methods: {
    submit() {

      this.axios.post(this.localeUrl('/bigdata/form/' + this.params.code), this.formValues)
          .then(data => {
            this.errors = []
            this.formValues.map(value => '')
            this.$refs.form.reset()
            Vue.prototype.$notifySuccess('Ваша форма успешно отправлена')
          })
          .catch(error => {
            this.errors = error.response.data.errors

            Vue.prototype.$notifyWarning('Некоторые поля заполнены некорректно')

            for (const [tabIndex, tab] of Object.entries(this.form.tabs)) {
              for (const block of tab.blocks) {
                for (const item of block.items) {
                  if (typeof this.errors[item.code] !== 'undefined') {
                    this.activeTab = parseInt(tabIndex)
                    return false
                  }
                }
              }
            }
          })

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
    //callbacks
    setWellPrefix(triggerFieldCode, changeFieldCode) {
      this.axios.get(this.localeUrl(`/bigdata/form/${this.params.code}/well-prefix`), {
        params: {
          geo: this.formValues[triggerFieldCode]
        }
      }).then(({data}) => {
        for (const tab of this.form.tabs) {
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
      for (const tab of this.form.tabs) {
        for (const block of tab.blocks) {
          for (const item of block.items) {
            if (item.code === changeFieldCode) {
              dictName = item.dict
            }
          }
        }
      }

      this.$store.dispatch('bd/getGeoDictByDZO', {
        dzo: this.formValues[triggerFieldCode],
        code: dictName
      })

    },
    validateField(e, formItem) {

      this.axios.post(
          this.localeUrl('/bigdata/form/' + this.params.code + '/validate/' + formItem.code),
          this.formValues
      )
          .then(data => {
            Vue.set(this.errors, formItem.code, null)
          })
          .catch(error => {
            Vue.set(this.errors, formItem.code, error.response.data.errors)
          })

    }
  },
};
</script>
<style lang="scss">
.bd-main-block {
  max-width: 1340px;
  margin: 0 auto;

  &__header {
    align-items: center;
    display: flex;
    justify-content: space-between;
    margin: 16px 0 20px;

    &-title {
      color: #fff;
      font-weight: bold;
      font-size: 20px;
      line-height: 24px;
      margin: 0;
    }
  }

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
        height: calc(100% - 50px);
        overflow-y: auto;
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