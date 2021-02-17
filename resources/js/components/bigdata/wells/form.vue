<template>
  <div class="bd-main-block">
    <notifications position="top"></notifications>
    <div class="bd-main-block__header">
      <p class="bd-main-block__header-title">{{ formTitle }}</p>
      <div class="block-three-fullscreen">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path
              d="M9 6H6C5.44772 6 5 6.44772 5 7V18C5 18.5523 5.44772 19 6 19H17C17.5523 19 18 18.5523 18 18V15M11.5 12.5L19 5M19 5V10.5M19 5H13.5"
              stroke="white" stroke-width="1.4" stroke-linecap="round"/>
        </svg>
      </div>
    </div>
    <form class="bd-main-block__form" style="width: 100%" ref="form">
      <div class="bd-main-block__form-tabs-header">
        <template v-for="(tab, index) in form.tabs">
          <div
              class="bd-main-block__form-tabs-header-tab"
              :class="{'active': index === activeTab}"
              @click="changeTab(index)"
          >
            <p>{{ tab.title }}</p>
          </div>
        </template>
      </div>
      <template v-for="(tab, index) in form.tabs">
        <div class="bd-main-block__form-tab" v-show="index === activeTab">
          <div
              class="bd-main-block__form-block"
              :class="{'bd-main-block__form-block_full': tab.blocks.length === 1}"
              v-for="block in tab.blocks"
          >
            <p class="bd-main-block__form-block-title" v-if="block.title">{{ block.title }}</p>
            <div class="bd-main-block__form-block-content">
              <div
                  v-for="item in block.items"
              >
                <label>{{ item.title }}</label>
                <bigdata-form-field
                    :item="item"
                    v-model="formValues[item.code]"
                    :error="errors[item.code]"
                    v-on:input="callback($event, item)"
                >
                </bigdata-form-field>
              </div>
            </div>
          </div>
        </div>
      </template>
      <div class="bd-main-block__form-buttons">
        <button type="button" class="btn btn-success" @click="submit">
          {{ trans('app.save') }}
        </button>
        <button type="reset" class="btn btn-info">
          {{ trans('app.cancel') }}
        </button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: "bigdata-form",
  props: ['formName', 'formTitle'],
  data: function () {
    return {
      errors: {},
      formValues: {},
      form: {},
      activeTab: 0
    }
  },
  mounted() {

    this.axios.get(this.localeUrl('/bigdata/form/' + this.formName)).then(({data}) => {
      this.form = data.params
      this.formValues = data.fields
    })

  },
  methods: {
    submit() {

      this.axios.post(this.localeUrl('/bigdata/form/' + this.formName), this.formValues)
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
      this.axios.get(this.localeUrl(`/bigdata/form/${this.formName}/well-prefix`), {
        params: {
          geo: this.formValues[triggerFieldCode]
        }
      }).then(({data}) => {
        this.formValues[changeFieldCode] = data.prefix
      })
    },
    filterGeoByDZO(triggerFieldCode, changeFieldCode) {

      this.axios.get(this.localeUrl(`/bigdata/dict/geos/${this.formValues[triggerFieldCode]}`)).then(({data}) => {
        for (const tab of this.form.tabs) {
          for (const block of tab.blocks) {
            for (const item of block.items) {
              if (item.code === changeFieldCode) {
                this.$store.commit("bd/SAVE_DICT", {
                  code: item.dict,
                  items: data
                });
                this.formValues[changeFieldCode] = null
              }
            }
          }
        }
      })
    }
  },
};
</script>
<style lang="scss">
.bd-main-block {
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