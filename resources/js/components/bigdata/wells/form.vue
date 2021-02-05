<template>
  <form style="width: 100%" ref="form">
    <template v-for="tab in form.tabs">
      <div class="form-tab col-xs-12 col-sm-12 col-md-12">
        <p class="title">{{ tab.title }}</p>
        <div class="form-block" v-for="block in tab.blocks">
          <p class="title" v-if="block.title">{{ block.title }}</p>
          <div
              class="col-xs-12 col-sm-4 col-md-4"
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
    </template>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <button type="button" class="btn btn-success" @click="submit">
        {{ trans('app.save') }}
      </button>
    </div>
  </form>
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
                    type: 'dict',
                    title: 'Оргструктура',
                    required: true,
                    dict: 'orgs'
                  },
                  {
                    code: 'geo',
                    type: 'dict',
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
      }
    }
  },
  mounted() {
  },
  methods: {
    submit() {

      if (this.$refs.form.checkValidity()) {

        this.axios.post(this.action, this.formValues)
            .then(data => {
              console.log(data)
            })
            .catch(error => {
              this.errors = error.response.data.errors
            })

      }
      else {
        this.$refs.form.reportValidity()
      }

    }
  },
};
</script>