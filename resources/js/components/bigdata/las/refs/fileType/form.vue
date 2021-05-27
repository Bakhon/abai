<template>
  <div class="col-xs-12 col-sm-12 col-md-12 row">
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>{{ trans('monitoring.file_type.fields.name') }}</label>
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
  name: "file-type-form",
  props: {
    fileType: {
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
              window.location.replace(this.localeUrl("bigdata/file_type"));
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
      return this.isEditing ? this.localeUrl("bigdata/file_type/" + this.fileType.id) : this.localeUrl("bigdata/file_type");
    },
    requestMethod () {
      return this.isEditing ? "put" : "post";
    }
  },
  mounted() {
    this.formFields = this.fileType ? this.fileType : defaultFormFields;
  },
};
</script>
<style scoped>
.form-label-group {
  padding-bottom: 30px;
}
</style>
