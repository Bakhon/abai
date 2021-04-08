<template>
  <div class="col-xs-12 col-sm-12 col-md-12 row">
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>{{ trans('monitoring.pipe_types.fields.name') }}</label>
      <div class="form-label-group">
        <input
            v-model="formFields.name"
            type="text"
            name="name"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>{{ trans('monitoring.pipe_types.fields.inner_diameter') }} {{trans('measurements.mm')}}</label>
      <div class="form-label-group">
        <input
            v-model="formFields.inner_diameter"
            type="number"
            step="0.0001"
            :min="validationParams.inner_diameter.min"
            :max="validationParams.inner_diameter.max"
            name="inner_diameter"
            class="form-control"
            placeholder=""
            @input="calcOutsideDiameter"
        >
      </div>
      <label>{{ trans('monitoring.pipe_types.fields.material') }}</label>
      <div class="form-label-group">
        <select class="form-control" name="material_id" v-model="formFields.material_id">
          <option v-for="row in materials" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>{{ trans('monitoring.pipe_types.fields.thickness') }} {{trans('measurements.mm')}}</label>
      <div class="form-label-group">
        <input
            v-model="formFields.thickness"
            type="number"
            step="0.0001"
            :min="validationParams.thickness.min"
            :max="validationParams.thickness.max"
            name="thickness"
            class="form-control"
            placeholder=""
            @input="calcInnerDiameter"
        >
      </div>
      <label>{{ trans('monitoring.pipe_types.fields.plot') }}</label>
      <div class="form-label-group">
        <select class="form-control" name="plot" v-model="formFields.plot">
          <option value="ab">ab</option>
          <option value="eg">eg</option>
        </select>
      </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>{{ trans('monitoring.pipe_types.fields.outside_diameter') }} {{trans('measurements.mm')}}</label>
      <div class="form-label-group">
        <input
            v-model="formFields.outside_diameter"
            type="number"
            step="0.0001"
            :min="validationParams.outside_diameter.min"
            :max="validationParams.outside_diameter.max"
            name="outside_diameter"
            class="form-control"
            placeholder=""
            @input="calcInnerDiameter"
        >
      </div>
      <label>{{ trans('monitoring.pipe_types.fields.roughness') }}</label>
      <div class="form-label-group">
        <input
            v-model="formFields.roughness"
            type="number"
            step="0.0001"
            :min="validationParams.roughness.min"
            :max="validationParams.roughness.max"
            name="roughness"
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
  name: null,
  outside_diameter: null,
  inner_diameter: null,
  thickness: null,
  roughness: null,
  material_id: null,
  plot: null,
};

export default {
  name: "pipe-type-form",
  props: {
    pipeType: {
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
        'name',
        'outside_diameter',
        'roughness',
        'material_id'
      ]
    }
  },
  methods: {
    submitForm () {
      this.axios
          [this.requestMethod](this.requestUrl, this.formFields)
          .then((response) => {
            if (response.data.status == 'success') {
              window.location.replace(this.localeUrl("/pipe_types"));
            }
          });
    },
    calcInnerDiameter (){
      if (this.formFields.outside_diameter && this.formFields.thickness) {
        this.formFields.inner_diameter = parseFloat(this.formFields.outside_diameter) - parseFloat(this.formFields.thickness);
      }
    },
    calcOutsideDiameter () {
      if (this.formFields.inner_diameter && this.formFields.thickness) {
        this.formFields.outside_diameter = parseFloat(this.formFields.inner_diameter) + parseFloat(this.formFields.thickness);
      }
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
      return this.isEditing ? this.localeUrl("/pipe_types/" + this.pipeType.id) : this.localeUrl("/pipe_types");
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
    this.formFields = this.pipeType ? this.pipeType : defaultFormFields;
  },
};
</script>
<style scoped>
.form-label-group {
  padding-bottom: 30px;
}
</style>
