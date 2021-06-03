<template>
  <div class="col-xs-12 col-sm-12 col-md-12 row">
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>{{ trans(`bd.forms.${this.modelName}.fields.name`) }}</label>
      <div class="form-label-group">
        <input
            v-model="formFields.name_ru"
            type="text"
            name="name_ru"
            class="form-control"
            placeholder=""
        >
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <button type="submit" :disabled="!isValidFields" @click.prevent="submitForm" class="btn btn-success">{{ trans('app.save') }}</button>
    </div>
  </div>
</template>

<script>
import {Settings} from 'luxon'

Settings.defaultLocale = 'ru'

const defaultFormFields = {
  name_ru: null
};

export default {
  name: "las-dictionaries-form",
  props: {
    link: {
      type: String,
      required: true,
    },
    modelName: {
      type: String,
      required: true,
    },
    dictData: {
      type: Object,
      default: null
    },
    validationParams: {
      type: Array,
      required: true,
    },
    isEditing: {
      type: Boolean,
      default: false
    },
  },
  data: function () {
    return {
      formFields: defaultFormFields,
      requiredFields: [
        'name_ru',
      ]
    }
  },
  methods: {
    submitForm () {
      this.axios
          [this.requestMethod](this.requestUrl, this.formFields)
          .then((response) => {
            if (response.data.status == 'success') {
              window.location.replace(this.localeUrl(`bigdata/${this.link}`));
            }
          });
    }
  },
  computed: {
    isValidFields() {
      this.requiredFields.forEach(field => {
        if (!this.formFields[field]) {
          return false
        }
      })
      return true
    },
    requestUrl () {
      return this.isEditing ? this.localeUrl(`bigdata/${this.link}/` + this.dictData.id) : this.localeUrl(`bigdata/${this.link}`);
    },
    requestMethod () {
      return this.isEditing ? "put" : "post";
    }
  },
  mounted() {
    this.formFields = this.dictData ? this.dictData : defaultFormFields;
  },
};
</script>
<style scoped>
.form-label-group {
  padding-bottom: 30px;
}
</style>
