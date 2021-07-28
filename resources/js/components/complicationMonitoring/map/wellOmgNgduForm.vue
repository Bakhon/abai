<template>
  <editForm
      :formFields="formFields"
      :validationParams="validationParams"
      :formObject="well"
      @selectDate="getOmgNgduData"
      @submit="storeOmgNgdu"
  />
</template>

<script>
import editForm from '@ui-kit/editForm';
import {globalloadingMutations} from '@store/helpers';
import omgNgduWellformFields from '~/json/formFields/omg_ngdu_well.json'

export default {
  name: "wellOmgNgduForm",
  props: {
    well: Object
  },
  components: {
    editForm
  },
  data: function () {
    return {
      formFields: _.cloneDeep(omgNgduWellformFields),
      validationParams: {},
      currentOmgngduWell: null
    }
  },
  beforeCreate: function () {
    this.axios.get(this.localeUrl("/omgngdu_well/validation-params")).then((response) => {
      let data = response.data;

      if (data) {
        this.validationParams = data.validationParams;
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
      this.axios.post(this.localeUrl("/omgngdu_well/get-omgngdu"), params).then((response) => {
        let omgngdu_well = response.data.omgngdu_well;

        if (omgngdu_well) {
          this.setOmgNgduParams(omgngdu_well);
          this.currentOmgngduWell = omgngdu_well;
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

      let route = "/omgngdu_well";
      let method = 'post';
      if (this.currentOmgngduWell && this.currentOmgngduWell.id) {
        route = route + '/' + this.currentOmgngduWell.id;
        method = 'put';
      }

      this.SET_LOADING(true);
      this.axios[method](this.localeUrl(route), omgngdu).then((response) => {
        let data = response.data;
        this.showToast(data.message, this.trans('app.success'), data.status);

        if (data.omgngdu_well) {
          this.currentOmgngduWell = data.omgngdu_well;
        }

        this.SET_LOADING(false);
      });

    }
  }
}
</script>

<style scoped>

</style>