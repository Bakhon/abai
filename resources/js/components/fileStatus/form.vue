<template>
  <div class="col-xs-12 col-sm-12 col-md-12 row">
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>{{ trans('monitoring.file_status.fields.name') }}</label>
      <div class="form-label-group">
        <input
            v-model="formFields.name"
            type="text"
            name="name"
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
  name: null
};

export default {
  name: "file-status-form",
  props: {
    fileStatus: {
      type: Object,
      default: null
    },
    validationParams: {
      type: Object,
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
      materials: {},
      requiredFields: [
        'name'
      ]
    }
  },
  methods: {
    submitForm () {
      this.axios
          [this.requestMethod](this.requestUrl, this.formFields)
          .then((response) => {
            if (response.data.status == 'success') {
              window.location.replace(this.localeUrl("/file_status"));
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
      return this.isEditing ? this.localeUrl("/file_status/" + this.fileStatus.id) : this.localeUrl("/file_status");
    },
    requestMethod () {
      return this.isEditing ? "put" : "post";
    }
  },
  beforeCreate: function () {
    this.axios.get(this.localeUrl("/getmaterials")).then((response) => {
      let data = response.data;
      if (data) {
        this.materials = data.data;
      } else {
        console.log('No data');
      }
    });
  },
  mounted() {
    this.formFields = this.fileStatus ? this.fileStatus : defaultFormFields;
  },
};
</script>
<style scoped>
.form-label-group {
  padding-bottom: 30px;
}
</style>
