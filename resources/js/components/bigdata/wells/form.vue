<template>
  <div class="bd-main-block">
    <div class="bd-main-block__header">
      <p class="bd-main-block__header-title">Текущие замеры по ГДИС</p>
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
  name: "bigdata-well-form",
  props: ['action'],
  data: function () {
    return {
      errors: {},
      formValues: {
        name: '',
        date_create: '',
        category: '',
        org: '',
        geo: '',
        altitude: '',
        rotor_table: '',
        coord_type: '',
        coord_mouth_x: '',
        coord_mouth_y: '',
        type: '',
        coord_bottom_x: '',
        coord_bottom_y: '',
        date_start_drilling: '',
        date_end_drilling: '',
        company: '',
        agreement_num: '',
        agreement_date: '',
        planned_depth: '',
        avg_gasoil_ratio: '',
        planned_liquid_rate: '',
        planned_watering: '',
      },
      form: {
        tabs: [
          {
            title: 'Основное',
            blocks: [
              {
                title: 'Скважина',
                items: [
                  {
                    code: 'name',
                    type: 'text',
                    title: 'Номер скважины',
                    required: true,
                  },
                  {
                    code: 'date_create',
                    type: 'date',
                    title: 'Дата создания проекта',
                    required: true
                  },
                  {
                    code: 'category',
                    type: 'dict',
                    title: 'Категория скважины',
                    required: true,
                    dict: 'well_categories'
                  },
                  {
                    code: 'org',
                    type: 'dict_tree',
                    title: 'Оргструктура',
                    required: true,
                    dict: 'orgs'
                  },
                  {
                    code: 'geo',
                    type: 'dict_tree',
                    title: 'Геоструктура',
                    required: true,
                    dict: 'geos'
                  }
                ]
              },
              {
                title: 'Свойства скважины',
                items: [
                  {
                    code: 'altitude',
                    type: 'numeric',
                    title: 'Альтитуда',
                    required: false,
                  },
                  {
                    code: 'rotor_table',
                    type: 'numeric',
                    title: 'Превышение стола ротора',
                    required: false
                  },
                  {
                    code: 'coord_type',
                    type: 'radio',
                    title: 'Координатная система',
                    required: true,
                    values: ['WGS-84', 'Пулково-42']
                  },
                  {
                    code: 'coord_mouth_x',
                    type: 'numeric',
                    title: 'Координаты устья X',
                    required: false
                  },
                  {
                    code: 'coord_mouth_y',
                    type: 'numeric',
                    title: 'Координаты устья Y',
                    required: false
                  },
                  {
                    code: 'type',
                    type: 'dict',
                    title: 'Вид скважины',
                    required: true,
                    dict: 'well_types'
                  },
                  {
                    code: 'coord_bottom_x',
                    type: 'numeric',
                    title: 'Координаты забоя X',
                    required: false
                  },
                  {
                    code: 'coord_bottom_y',
                    type: 'numeric',
                    title: 'Координаты забоя Y',
                    required: false
                  },
                ]
              }
            ]
          },
          {
            title: 'Проект бурения',
            blocks: [
              {
                title: 'Скважина',
                items: [
                  {
                    code: 'date_start_drilling',
                    type: 'date',
                    title: 'Дата начала бурения',
                    required: false
                  },
                  {
                    code: 'date_end_drilling',
                    type: 'date',
                    title: 'Дата окончания бурения',
                    required: false
                  },
                  {
                    code: 'company',
                    type: 'dict',
                    title: 'Подрядчик',
                    required: false,
                    dict: 'companies'
                  },
                  {
                    code: 'agreement_num',
                    type: 'numeric',
                    title: 'Номер договора',
                    required: true
                  },
                  {
                    code: 'agreement_date',
                    type: 'date',
                    title: 'Дата договора',
                    required: true
                  },
                  {
                    code: 'planned_depth',
                    type: 'numeric',
                    title: 'Проектная глубина, м',
                    required: false
                  },
                  {
                    code: 'avg_gasoil_ratio',
                    type: 'numeric',
                    title: 'Средний газовый фактор',
                    required: false
                  },
                  {
                    code: 'planned_liquid_rate',
                    type: 'numeric',
                    title: 'Ожидаемый дебит жидкости',
                    required: false
                  },
                  {
                    code: 'planned_watering',
                    type: 'numeric',
                    title: 'Ожидаемая обводненность',
                    required: false
                  },
                ]
              }
            ]
          }
        ],
      },
      activeTab: 0
    }
  },
  mounted() {
  },
  methods: {
    submit() {
      if (this.$refs.form.checkValidity()) {

        this.axios.post(this.action, this.formValues)
            .then(data => {
              this.errors = []
              this.formValues.map(item => '')
              this.$refs.form.reset()
              alert('Ваша форма успешно отправлена')
            })
            .catch(error => {
              this.errors = error.response.data.errors

              for(const [tabIndex, tab] of Object.entries(this.form.tabs)) {
                for(const block of tab.blocks) {
                  for(const item of block.items) {
                    if(typeof this.errors[item.code] !== 'undefined') {
                      this.activeTab = parseInt(tabIndex)
                      return false
                    }
                  }
                }
              }

            })

      } else {
        this.$refs.form.reportValidity()
      }
    },
    changeTab(index) {
      this.activeTab = index
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
          background: #31335f;
          border-top-left-radius: 3px;
          border-top-right-radius: 3px;
          color: #8389AF;
          font-size: 14px;
          font-weight: 600;
          height: 28px;
          line-height: 28px;
          margin-right: 15px;
          padding: 0 45px;

          &:hover {
            color: #fff;
          }

          &.active {
            background: #363b68;
            color: #fff;
          }
        }
      }
    }

    &-tab {
      background: #363b68;
      display: flex;
      justify-content: space-between;
      padding: 10px;
    }

    &-block {
      background: #272953;
      border-left: 1px solid #454D7D;
      height: 600px;
      width: 50%;
      &_full{
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