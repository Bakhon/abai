<template>
  <b-col cols=12>

    <EditForm
        :formFields="formFields"
        :validationParams="validationParams"
        :formObject="omgngduWell"
        :selectsOptions="selectsOptions"
        @selectDate="getOmgNgduData"
        @changeWell="getOmgNgduData"
        @changeZu="changeZu"
        @submit="storeOmgNgdu"
        @dailyProductionInput="calculateFluidParams(true)"
    />
  </b-col>
</template>

<script>
import {complicationMonitoringState, complicationMonitoringActions, globalloadingMutations} from '@store/helpers';
import omgNgduWellformFields from '~/json/formFields/omg_ngdu_well.json';
import EditForm from '@ui-kit/EditForm';
import calculateFluidParams from '~/mixins/calculateFluidParams';

export default {
  name: "omgngdu-well-form",
  props: {
    omgngduWellProp: {
      type: Object,
      default: null
    },
    validationParams: {
      type: Object,
      required: true,
    },
  },
  components: {
    EditForm
  },
  mixins: [calculateFluidParams],
  data: function () {
    return {
      formFields: _.cloneDeep(omgNgduWellformFields),
      omgngduWell: this.omgngduWellProp
    }
  },
  computed: {
    ...complicationMonitoringState([
      'zus',
      'wells'
    ]),
    selectsOptions() {
      return {
        zus: this.zus,
        wells: this.wells,
      }
    },
    requestUrl() {
      return this.omgngduWell && this.omgngduWell.id ? this.localeUrl("/omgngdu-well/" + this.omgngduWell.id) : this.localeUrl("/omgngdu-well");
    },
    requestMethod() {
      return this.omgngduWell && this.omgngduWell.id ? "put" : "post";
    }
  },
  mounted() {
    this.$nextTick(async () => {
      this.SET_LOADING(true);
      await this.getAllZus()
      await this.getAllWells();
      this.SET_LOADING(false);

      if (this.omgngduWell) {
        this.setOmgNgduFormFields(this.omgngduWell);
        this.calculateFluidParams(true);
      }
    });

  },
  methods: {
    ...complicationMonitoringActions([
      'getAllZus',
      'getAllWells',
      'getZuRelations'
    ]),
    ...globalloadingMutations([
      'SET_LOADING'
    ]),
    setOmgNgduFormFields(omgngdu_well) {
      for (let param in this.formFields) {
        this.formFields[param].value = omgngdu_well[param];
      }
    },
    async changeZu() {
      this.SET_LOADING(true);
      await this.getZuRelations(this.formFields.zu_id.value);
      this.SET_LOADING(false);
    },
    storeOmgNgdu() {
      if (!this.formFields.date.value) {
        return false;
      }

      let omgngdu = {};
      for (let param in this.formFields) {
        omgngdu[param] = this.formFields[param].value;
      }

      this.SET_LOADING(true);
      this.axios
          [this.requestMethod](this.requestUrl, omgngdu)
          .then((response) => {
            if (response.data.status == 'success') {
              window.location.replace(this.localeUrl("/omgngdu-well"));
            }

          })
          .finally(() => {
            this.SET_LOADING(false);
          });
    },
    getOmgNgduData() {
      if (!this.formFields.date.value || !this.formFields.well_id.value) {
        return false;
      }

      let params = {
        date: this.formFields.date.value,
        well_id: this.formFields.well_id.value
      };

      this.SET_LOADING(true);
      this.axios.post(this.localeUrl("/omgngdu-well/get-omgngdu"), params).then((response) => {
        let omgngdu_well = response.data;

        if (!_.isEmpty(omgngdu_well)) {
          this.setOmgNgduFormFields(omgngdu_well);
          this.omgngduWell = omgngdu_well;
        } else {
          let date = this.formFields.date.value;
          let well_id = this.formFields.well_id.value;
          let zu_id = this.formFields.zu_id.value;
          this.formFields = _.cloneDeep(omgNgduWellformFields);
          this.formFields.date.value = date
          this.formFields.well_id.value = well_id;
          this.formFields.zu_id.value = zu_id;
          this.omgngduWell = null;
        }
      }).finally(() => {
        this.SET_LOADING(false);
      });
    },
  },
};
</script>

<style scoped>
.form-label-group {
  padding-bottom: 30px;
}
</style>