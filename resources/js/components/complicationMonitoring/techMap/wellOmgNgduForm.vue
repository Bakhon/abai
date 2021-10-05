<template>
  <EditForm
      :formFields="formFields"
      :validationParams="validationParams"
      :formObject="well"
      @selectDate="getOmgNgduData"
      @submit="storeOmgNgdu"
      @dailyProductionInput="calculateFluidParams"
  />
</template>

<script>
import EditForm from '@ui-kit/EditForm';
import {globalloadingMutations} from '@store/helpers';
import omgNgduWellformFields from '~/json/formFields/map_omg_ngdu_well.json'

const averageOilDensity = 853;

export default {
  name: "wellOmgNgduForm",
  props: {
    well: Object
  },
  components: {
    EditForm
  },
  data: function () {
    return {
      formFields: _.cloneDeep(omgNgduWellformFields),
      validationParams: {},
      currentOmgngduWell: null
    }
  },
  beforeCreate: function () {
    this.axios.get(this.localeUrl("/settings/validation-params/omgngdu_well")).then((response) => {
      let validationParams = response.data;

      if (!_.isEmpty(validationParams)) {
        this.validationParams = validationParams;
      }
    });
  },
  methods: {
    ...globalloadingMutations([
      'SET_LOADING'
    ]),
    getOmgNgduData() {
      if (!this.formFields.date.value) {
        return false;
      }

      let params = {
        date: this.formFields.date.value,
        well_id: this.well.id
      };

      this.SET_LOADING(true);
      this.axios.post(this.localeUrl("/omgngdu-well/get-omgngdu"), params).then((response) => {
        let omgngdu_well = response.data;

        if (!_.isEmpty(omgngdu_well)) {
          this.setOmgNgduParams(omgngdu_well);
          this.currentOmgngduWell = omgngdu_well;
          this.calculateFluidParams();
        } else {
          let date = this.formFields.date.value;
          this.formFields = _.cloneDeep(omgNgduWellformFields);
          this.formFields.date.value = date;
          this.currentOmgngduWell = null;
        }

        this.SET_LOADING(false);
      });
    },
    setOmgNgduParams(omgngdu_well) {
      for (let param in this.formFields) {
        this.formFields[param].value = omgngdu_well[param];
      }
    },
    storeOmgNgdu() {
      if (!this.formFields.date.value) {
        return false;
      }

      let omgngdu = {
        zu_id: this.well.zu_id,
        well_id: this.well.id,
      };

      for (let param in this.formFields) {
        omgngdu[param] = this.formFields[param].value;
      }

      let route = "/omgngdu-well";
      let method = 'post';
      if (this.currentOmgngduWell && this.currentOmgngduWell.id) {
        route = route + '/' + this.currentOmgngduWell.id;
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
    calculateFluidParams() {
      let gas_factor = this.formFields.gas_factor.value;
      let daily_fluid_production = this.formFields.daily_fluid_production.value;
      let bsw = this.formFields.bsw.value;

      if (daily_fluid_production && bsw) {
        this.formFields.daily_water_production.value = ((daily_fluid_production * bsw) / 100).toFixed(2);
        this.formFields.daily_oil_production.value = (((daily_fluid_production * (100 - bsw)) / 100) * averageOilDensity / 1000).toFixed(2);
      }

      if (daily_fluid_production &&
          gas_factor &&
          bsw
      ) {
        this.formFields.daily_gas_production.value = (gas_factor * daily_fluid_production * (1 - bsw / 100)).toFixed(2);
      }
    },
  }
}
</script>