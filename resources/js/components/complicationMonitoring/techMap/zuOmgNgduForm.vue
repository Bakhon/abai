<template>
  <EditForm
      :formFields="formFields"
      :validationParams="validationParams"
      :formObject="zu"
      @selectDate="getOmgNgduData"
      @submit="storeOmgNgdu"
      @dailyProductionInput="calculateFluidParams"
  />
</template>

<script>
import EditForm from '@ui-kit/EditForm';
import {globalloadingMutations} from '@store/helpers';
import omgNgduZuformFields from '~/json/formFields/map_omg_ngdu_zu.json';
import calculateFluidParams from '~/mixins/calculateFluidParams';

export default {
  name: "zuOmgNgduForm",
  props: {
    zu: Object
  },
  components: {
    EditForm
  },
  mixins: [calculateFluidParams],
  data: function () {
    return {
      formFields: _.cloneDeep(omgNgduZuformFields),
      validationParams: {},
      currentOmgngduZu: null
    }
  },
  beforeCreate: function () {
    this.axios.get(this.localeUrl("/settings/validation-params/omgngdu_zu")).then((response) => {
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
        zu_id: this.zu.id
      };

      this.SET_LOADING(true);
      this.axios.post(this.localeUrl("/omgngdu-zu/get-omgngdu"), params).then((response) => {
        let omgngdu_zu = response.data;

        if (!_.isEmpty(omgngdu_zu)) {
          this.setOmgNgduParams(omgngdu_zu);
          this.currentOmgngduZu = omgngdu_zu;
        } else {
          let date = this.formFields.date.value;
          this.formFields = _.cloneDeep(omgNgduZuformFields);
          this.formFields.date.value = date;
          this.currentOmgngduZu = null;
        }

        this.SET_LOADING(false);
      });
    },
    setOmgNgduParams(omgngdu_zu) {
      for (let param in this.formFields) {
        this.formFields[param].value = omgngdu_zu[param];
      }
    },
    storeOmgNgdu() {
      if (!this.formFields.date.value) {
        return false;
      }

      let omgngdu = {
        zu_id: this.zu.id,
      };

      for (let param in this.formFields) {
        omgngdu[param] = this.formFields[param].value;
      }

      let route = "/omgngdu-zu";
      let method = 'post';
      if (this.currentOmgngduZu && this.currentOmgngduZu.id) {
        route = route + '/' + this.currentOmgngduZu.id;
        method = 'put';
      }

      this.SET_LOADING(true);
      this.axios[method](this.localeUrl(route), omgngdu).then((response) => {
        let data = response.data;
        this.showToast(data.message, this.trans('app.success'), data.status);

        this.getOmgNgduData();

        this.SET_LOADING(false);
      });
    }
  }
}
</script>