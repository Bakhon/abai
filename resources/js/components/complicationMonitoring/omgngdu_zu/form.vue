<template>
  <b-col cols=12>

    <EditForm
        :formFields="formFields"
        :validationParams="validationParams"
        :formObject="omgngduZu"
        :selectsOptions="selectsOptions"
        @selectDate="getOmgNgduData"
        @changeZu="getOmgNgduData"
        @submit="storeOmgNgdu"
        @dailyProductionInput="calculateFluidParams"
    />
  </b-col>
</template>

<script>
import {complicationMonitoringState, complicationMonitoringActions, globalloadingMutations} from '@store/helpers';
import omgNgduZuformFields from '~/json/formFields/omg_ngdu_zu.json';
import calculateFluidParams from '~/mixins/calculateFluidParams';
import EditForm from '@ui-kit/EditForm';

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
    }
  },
  components: {

    EditForm
  },
  mixins: [calculateFluidParams],
  data: function () {
    return {
      formFields: _.cloneDeep(omgNgduZuformFields)
    }
  },
  computed: {
    ...complicationMonitoringState([
      'zus',
    ]),
    selectsOptions() {
      return {zus: this.zus}
    },
    requestUrl() {
      return this.omgngduZu && this.omgngduZu.id ? this.localeUrl("/omgngdu-zu/" + this.omgngduZu.id) : this.localeUrl("/omgngdu-zu");
    },
    requestMethod() {
      return this.omgngduZu && this.omgngduZu.id ? "put" : "post";
    }
  },
  beforeCreate() {

  },
  mounted() {
    this.$nextTick(async () => {
      this.SET_LOADING(true);
      await this.getAllZus();
      this.SET_LOADING(false);

      if (this.omgngduZu) {
        this.setOmgNgduFormFields(this.omgngduZu)
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
      if (!this.formFields.date.value || !this.formFields.zu_id.value) {
        return false;
      }

      let params = {
        date: this.formFields.date.value,
        zu_id: this.formFields.zu_id.value
      };

      this.SET_LOADING(true);
      this.axios.post(this.localeUrl("/omgngdu-zu/get-omgngdu"), params).then((response) => {
        let omgngdu_zu = response.data;

        if (!_.isEmpty(omgngdu_zu)) {
          this.setOmgNgduFormFields(omgngdu_zu);
          this.omgngduZu = omgngdu_zu;
        } else {
          let date = this.formFields.date.value;
          let zu_id = this.formFields.zu_id.value;
          this.formFields = _.cloneDeep(omgNgduZuformFields);
          this.formFields.date.value = date
          this.formFields.zu_id.value = zu_id;
          this.omgngduZu = null;
        }
      }).finally(() => {
        this.SET_LOADING(false);
      });
    },
    setOmgNgduFormFields(omgngdu_zu) {
      for (let param in this.formFields) {
        this.formFields[param].value = omgngdu_zu[param];
      }
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
              window.location.replace(this.localeUrl("/omgngdu-zu"));
            }

          })
          .finally(() => {
            this.SET_LOADING(false);
          });
    }
  },
};
</script>

<style scoped>
.form-label-group {
  padding-bottom: 30px;
}
</style>
