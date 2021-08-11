<template>
  <EditForm
      :formFields="formFields"
      :validationParams="validationParams"
      :formObject="gu"
      @selectDate="getOmgNgduData"
      @submit="storeOmgNgdu"
      @dailyProductionInput="calculateFluidParams"
  />
</template>

<script>
import EditForm from '@ui-kit/EditForm';
import {globalloadingMutations} from '@store/helpers';
import omgNgduGuformFields from '~/json/formFields/omg_ngdu_gu.json';

const averageOilDensity = 853;

export default {
  name: "guOmgNgduForm",
  props: {
    gu: Object
  },
  components: {
    EditForm
  },
  data: function () {
    return {
      formFields: _.cloneDeep(omgNgduGuformFields),
      validationParams: {},
      currentOmgngdu: null
    }
  },
   beforeCreate: function () {
    this.axios.get(this.localeUrl("/settings/validation-params/omgngdu")).then((response) => {
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
        gu_id: this.gu.id
      };

      this.SET_LOADING(true);
      this.axios.post(this.localeUrl("/omgngdu/get-omgngdu"), params).then((response) => {
        let omgngdu = response.data;

        if (!_.isEmpty(omgngdu)) {
          this.setOmgNgduParams(omgngdu);
          this.currentOmgngdu = omgngdu;
        } else {
          let date = this.formFields.date.value;
          this.formFields = _.cloneDeep(omgNgduGuformFields);
          this.formFields.date.value = date;
          this.currentOmgngdu = null;
        }

        this.SET_LOADING(false);
      });
    },
    setOmgNgduParams(omgngdu) {
      for (let param in this.formFields) {
        this.formFields[param].value = omgngdu[param];
      }
    },
    storeOmgNgdu() {
      if (!this.formFields.date.value) {
        return false;
      }

      let omgngdu = {
        gu_id: this.gu.id,
      };

      for (let param in this.formFields) {
        omgngdu[param] = this.formFields[param].value;
      }

      let route = "/omgngdu";
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
  }
}
</script>