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

    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>{{ trans("bd.geo_in_abai_system") }}</label>
      <div class="form-label-group">
        <select class="form-control" name="geo_id" v-model="formFields.geo_id"
        @change="loadWells()">
            <option v-for="row in geoList" v-bind:value="row.id">{{ row.name_ru }}</option>
        </select>
      </div>
    </div>

    <div v-if="modelName === 'well_mapping'" class="col-xs-12 col-sm-4 col-md-4">
      <label>{{ trans("bd.well_mapping.well_in_abai") }}</label>
      <div class="form-label-group">
        <select class="form-control" name="geo_id" v-model="formFields.well_id" :disabled="!formFields.geo_id">
            <option v-for="row in wellList" v-bind:value="row.id">{{ row.name }}</option>
        </select>
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
  name_ru: null,
  geo_id: null,
  well_id: null,
};

export default {
  name: "geo-mapping-form",
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
    geoList: {
        type: Array,
        required: true,
    }
  },
  data: function () {
    return {
      formFields: defaultFormFields,
      requiredFields: [
        'name_ru',
        'well_id',
        'geo_id',
      ],
      wellList: null,
      baseUrl: process.env.MIX_MICROSERVICE_USER_REPORTS,
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
    },
    loadWells() {
      if(!this.formFields.geo_id) return;
      return this.axios.get(this.baseUrl + "get_wells", {
        params: {
          structure_type: 'geo',
          item_id: this.formFields.geo_id
        },
        responseType: 'json',
        headers: {
          'Content-Type': 'application/json'
        }
      }).then((response) => {
        if (response.data) {
          this.wellList = this.filterData(response.data);
        } else {
          console.log("No data");
        }
      })
    },
    filterData(wellList) {
      let result = {};
      for(let obj of wellList) {
        if(!result[obj.name]) {
          result[obj.name] = obj;
        }
      }
      return result;
    },
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
    this.loadWells();
  },
};
</script>
<style scoped>
.form-label-group {
  padding-bottom: 30px;
}

select:disabled {
  background-color: gray;
}
</style>
