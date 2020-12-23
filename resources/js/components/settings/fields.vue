<template>
  <div class="row field-settings">
    <div class="col-12 alert alert-success mb-2" v-if="success">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <p class="mb-0">{{ success }}</p>
    </div>
    <template>
      <div class="col-3 field-settings__sections">
        <div
            class="field-settings__sections-item"
            :class="{'field-settings__sections-item_active': selectedSectionCode && selectedSectionCode === sectionCode}"
            v-for="(section, sectionCode) in fields"
            :key="`section_${sectionCode}`"
            @click="changeTab(sectionCode)"
        >
          <p><b>{{ sectionNames[sectionCode] }}</b></p>
        </div>
      </div>
      <div class="col-9 field-settings__fields" v-if="fields[selectedSectionCode]">
        <div class="col-xs-12 col-sm-12 col-md-12 row">
          <div class="col-xs-12 col-sm-4 col-md-4">
            <label>Поле</label>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4">
            <label>Минимальное значение</label>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4">
            <label>Максимальное значение</label>
          </div>
        </div>
        <div
            v-for="(field, index) in fields[selectedSectionCode]"
            :key="`field_${field.id}`"
            class="col-xs-12 col-sm-12 col-md-12 row field-settings__fields-row"
        >
          <div class="col-xs-12 col-sm-4 col-md-4 field-settings__fields-row-name">
            <label>{{ field.field_name }}</label>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4">
            <input type="number" class="form-control" v-model="field.min_value" step="0.0001">
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4">
            <input type="number" class="form-control" v-model="field.max_value" step="0.0001">
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12" v-if="errors[index]">
            <p class="text-danger">{{ errors[index] }}</p>
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
          <button type="submit" class="btn btn-success" @click="submit">Сохранить</button>
        </div>
      </div>
    </template>
  </div>
</template>
<script>
export default {
  props: [
    'fields'
  ],
  data() {
    return {
      sectionNames: {
        omgca: 'ОМГ ДДНГ',
        omgngdu: 'ОМГ НГДУ',
        omguhe: 'ОМГ УХЭ',
        watermeasurement: 'Промысловая жидкость и газ',
        oilgas: 'Нефть и газ',
        corrosioncrud: 'Скорость коррозии',
        pipes: 'Трубопроводы',
        inhibitors: 'Ингибиторы',
      },
      selectedSectionCode: null,
      success: null,
      errors: []
    }
  },
  mounted() {
  },
  methods: {
    submit() {

      this.errors = []

      let fieldValues = this.fields[this.selectedSectionCode].map((field, index) => {
        if (field.min_value*1 >= field.max_value*1) {
          console.log(field.min_value);
          console.log(field.max_value);
          this.errors[index] = 'Минимальное значение не может быть больше или равно максимальному'
        }

        return {
          id: field.id,
          min_value: field.min_value,
          max_value: field.max_value,
        }
      })

      if (this.errors.length === 0) {
        this.axios.post('/ru/settings/fields', {fields: fieldValues}).then(response => {
          if (response.status === 204) {
            this.success = 'Изменения сохранены'
            setTimeout(() => {
              this.success = null
            }, 3000)
          }
        })
      }
    },
    changeTab(code) {
      this.selectedSectionCode = code
      this.errors = []
    }
  }
}
</script>
<style lang="scss">
.field-settings {
  background: #20274e;
  color: #fff;

  margin: 0 0 20px;
  padding: 20px 10px;

  &__sections {
    max-height: calc(100vh - 270px);
    overflow-y: auto;

    &-item {
      border: 1px solid #ccc;
      border-radius: 10px;
      margin-bottom: 5px;
      padding: 5px 20px;

      &_active {
        background: #15509d;
        border-color: transparent;
      }

      p {
        margin: 0;
      }
    }
  }

  &__fields {
    &-row {
      margin-bottom: 10px;

      &-name {
        align-items: center;
        display: flex;

        label {
          line-height: 1.3;
          margin: 0;
        }
      }
    }
  }
}
</style>
