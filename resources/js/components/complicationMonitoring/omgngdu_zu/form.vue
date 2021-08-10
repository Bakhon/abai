<template>
  <div class="col-xs-12 col-sm-12 col-md-12 row">
    <cat-loader />
    <EditForm
        :formFields="formFields"
        :validationParams="validationParams"
        :formObject="omgngduZu"
        @selectDate="getOmgNgduData"
        @submit="storeOmgNgdu"
        @dailyProductionInput="calculateFluidParams"
    />

    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <button type="submit" :disabled="!formFields.date" class="btn btn-success" @click.prevent="submitForm">{{ trans('app.save') }}</button>
    </div>
  </div>
</template>

<script>

import {complicationMonitoringState, complicationMonitoringActions, globalloadingMutations} from '@store/helpers';
import omgNgduZuformFields from '~/json/formFields/omg_ngdu_zu.json';
import CatLoader from '@ui-kit/CatLoader';
import EditForm from '@ui-kit/EditForm';

const averageOilDensity = 853;

export default {
  name: "omgngdu-zu-form",
  props: {
    omgngduZu: {
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
  components: {
    CatLoader,
    EditForm
  },
  data: function () {
    return {
      formFields: _.cloneDeep(omgNgduZuformFields)
    }
  },
  computed: {
    ...complicationMonitoringState([
      'zus',
    ]),
    formatedDate() {
      if (this.formFields.date) {
        return moment.parseZone(this.formFields.date).format('Y-m-d')
      }
      return null
    },
    requestUrl () {
      return this.isEditing ? this.localeUrl("/omgngdu-well/" + this.omgngduWell.id) : this.localeUrl("/omgngdu-well");
    },
    requestMethod () {
      return this.isEditing ? "put" : "post";
    }
  },
  beforeCreate() {

  },
  mounted() {
    this.$nextTick(async () => {
      await this.getAllZus();

      if (this.omgngduZu) {
        this.setOmgNgduParams(this.omgngduZu)
      }
    });

  },
  methods: {
    ...complicationMonitoringActions([
      'getAllZus',
    ]),
    ...globalloadingMutations([
      'SET_LOADING'
    ]),
    getOmgNgduData() {
      if (!this.formFields.date.value) {
        return false;
      }

      let params = {
        date: this.formFields.date.value,
        gu_id: this.gu.id
      };

      this.SET_LOADING(true);
      this.axios.post(this.localeUrl("/omgngdu-zu/get-omgngdu"), params).then((response) => {
        let omgngdu_zu = response.data;

        if (!_.isEmpty(omgngdu_zu)) {
          this.setOmgNgduParams(omgngdu_zu);
          this.currentOmgNgduZu = omgngdu_zu;
        } else {
          let date = this.formFields.date.value;
          this.formFields = _.cloneDeep(omgNgduZuformFields);
          this.formFields.date.value = date;
          this.currentOmgNgduZu = null;
        }

        this.SET_LOADING(false);
      });
    },
    setOmgNgduParams(omgngdu_zu) {
      for (let param in this.formFields) {
        this.formFields[param].value = omgngdu_zu[param];
      }
    },
    submitForm () {
      this.SET_LOADING(true);
      this.axios
          [this.requestMethod](this.requestUrl, this.formFields)
          .then((response) => {
            if (response.data.status == 'success') {
              window.location.replace(this.localeUrl("/omgngdu-zu"));
            }
            this.SET_LOADING(false);
          });
    },
    storeOmgNgdu() {
      if (!this.formFields.date.value) {
        return false;
      }

      for (let param in this.formFields) {
        omgngdu[param] = this.formFields[param].value;
      }

      let route = "/omgngdu-zu";
      let method = 'post';
      if (this.currentOmgngdu && this.currentOmgngdu.id) {
        route = route + '/' + this.currentOmgngdu.id;
        method = 'put';
      }

      this.SET_LOADING(true);
      this.axios[method](this.localeUrl(route), omgngdu).then((response) => {
        let data = response.data;
        this.showToast(data.message, this.trans('app.success'), data.status);

        this.getOmgNgduData();

        this.SET_LOADING(false);
      });
    },
    calculateFluidParams () {
      if (this.formFields.daily_fluid_production.value && this.formFields.bsw.value) {
        this.formFields.daily_water_production.value = (this.formFields.daily_fluid_production.value * this.formFields.bsw.value) / 100;
        this.formFields.daily_oil_production.value = ((this.formFields.daily_fluid_production.value * (100 - this.formFields.bsw.value)) / 100) * averageOilDensity / 1000;
      }
    },
  },
};
</script>
<style scoped>
.form-label-group {
  padding-bottom: 30px;
}
</style>
