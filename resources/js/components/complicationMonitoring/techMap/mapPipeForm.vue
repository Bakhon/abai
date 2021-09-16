<template>
  <div>
    <b-form-group :label="trans('monitoring.pipe.name')" label-for="pipe_name">
      <b-form-input
          id="pipe_name"
          v-model="pipe.name"
          required
      ></b-form-input>

      <b-form-invalid-feedback id="input-live-feedback" :state="!($v.pipe.name.$dirty && !$v.pipe.name.required)">
        {{ trans('validation.required', {attribute: trans('monitoring.pipe.name')}) }}
      </b-form-invalid-feedback>
    </b-form-group>

    <b-form-group
        :label="trans('monitoring.gu.gu')"
        label-for="gu"
        v-if="pipe.gu_id"
    >
      <b-form-select
          id="gu"
          v-model="pipe.gu_id"
          :options="guOptions"
          @change="updateEndPoints"
      ></b-form-select>

      <b-form-invalid-feedback id="input-live-feedback" :state="!($v.pipe.gu_id.$dirty && !$v.pipe.gu_id.required)">
        {{ trans('validation.required', {attribute: trans('monitoring.gu.gu')}) }}
      </b-form-invalid-feedback>
    </b-form-group>

    <b-form-group
        :label="trans('monitoring.zu.zu')"
        label-for="zu">
      <b-form-select
          id="gu"
          v-model="pipe.zu_id"
          :options="zuOptions"
          @change="updateEndPoints"
      ></b-form-select>

      <b-form-invalid-feedback id="input-live-feedback" :state="!($v.pipe.zu_id.$dirty && !$v.pipe.zu_id.required)">
        {{ trans('validation.required', {attribute: trans('monitoring.zu.zu')}) }}
      </b-form-invalid-feedback>
    </b-form-group>

    <b-form-group
        :label="trans('monitoring.well.well')"
        label-for="gu"
        v-if="pipe.well_id"
    >
      <b-form-select
          id="gu"
          v-model="pipe.well_id"
          :options="wellOptions"
          @change="updateEndPoints"
      ></b-form-select>
    </b-form-group>

    <h5 class="coords-collapse" v-b-toggle.coordsVisible>{{ trans('monitoring.pipe.coords') }}
      <i class="fas fa-chevron-down"></i>
    </h5>

    <b-collapse id="coordsVisible">
      <b-row v-for="(coord, index) in pipe.coords" :key="index">
        <h6 class="w-100 px-3 mb-2">Точка {{ index }}</h6>
        <b-col cols="12" sm="4">
          <b-form-group :label="trans('monitoring.latitude')" :label-for="'coord-x'+index">
            <b-form-input
                :id="'coord-x'+index"
                v-model="pipe.coords[index].lat"
                required
            ></b-form-input>
          </b-form-group>
        </b-col>

        <b-col cols="12" sm="4">
          <b-form-group :label="trans('monitoring.longitude')" :label-for="'coord-y'+index">
            <b-form-input
                :id="'coord-y'+index"
                v-model="pipe.coords[index].lon"
                required
            ></b-form-input>
          </b-form-group>
        </b-col>

        <b-col cols="12" sm="4">
          <b-form-group :label="trans('monitoring.elevation')" :label-for="'coord-z'+index">
            <b-form-input
                :id="'coord-z'+index"
                v-model="pipe.coords[index].elevation"
                required
            ></b-form-input>
          </b-form-group>
        </b-col>

        <b-col cols="12" sm="6">
          <b-form-group :label="trans('monitoring.h_distance')" :label-for="'coord-z'+index">
            <b-form-input
                :id="'coord-h-distance'+index"
                v-model="pipe.coords[index].h_distance"
                required
            ></b-form-input>
          </b-form-group>
        </b-col>

        <b-col cols="12" sm="6">
          <b-form-group :label="trans('monitoring.m_distance')" :label-for="'coord-z'+index">
            <b-form-input
                :id="'coord-m-distance'+index"
                v-model="pipe.coords[index].m_distance"
                required
            ></b-form-input>
          </b-form-group>
        </b-col>
        <hr class="mb-2 mt-0 w-100 white-border-top"/>
      </b-row>
    </b-collapse>

    <hr class="mb-2 mt-0 white-border-top w-100"/>

    <b-form-group
        :label="trans('monitoring.pipe.type')"
        label-for="pipeType">
      <b-form-select
          id="pipeType"
          v-model="pipe.type_id"
          :options="pipeTypesOptions"
      ></b-form-select>

      <b-form-invalid-feedback id="input-live-feedback" :state="!($v.pipe.type_id.$dirty && !$v.pipe.type_id.required)">
        {{ trans('validation.required', {attribute: trans('monitoring.pipe.type')}) }}
      </b-form-invalid-feedback>
    </b-form-group>

    <h5>{{ trans('monitoring.pipe.params') }}</h5>
    <div class="params_block">
      <p>{{ trans('monitoring.pipe.fields.outside_diameter') }}:
        {{ pipeTypeParams.outside_diameter + trans('measurements.mm') }}</p>
      <p>{{ trans('monitoring.pipe.fields.thickness') }}: {{ pipeTypeParams.thickness + trans('measurements.mm') }}</p>
      <p>{{ trans('monitoring.pipe.fields.inner_diameter') }}:
        {{ pipeTypeParams.inner_diameter + trans('measurements.mm') }}</p>
      

    </div>

  </div>
</template>

<script>
import {guMapState} from '@store/helpers';
import {required} from "vuelidate/lib/validators";

const blankPipeParams = {
  inner_diameter: '',
  outside_diameter: '',
  plot: '',
  roughness: '',
  thickness: ''
};

export default {
  name: "mapPipeForm",
  props: {
    pipe: {
      type: Object,
      required: true,
    },
  },
  computed: {
    ...guMapState([
      'pipeTypes',
      'guPoints',
      'zuPoints',
      'wellPoints',
    ]),
    pipeTypesOptions: function () {
      let options = [];
      this.pipeTypes.forEach((item) => {
        options.push(
            {value: item.id, text: item.name}
        );
      });

      return options;
    },
    wellOptions: function () {
      let options = [];
      this.wellPoints.forEach((item) => {
        if (_.isUndefined(this.pipe.zu_id) ||
            item.zu_id == this.pipe.zu_id
        ) {
          options.push(
              {value: item.id, text: item.name}
          );
        }
      });

      return options;
    },
    pipeTypeParams() {
      if (this.pipe.type_id) {
        let index = this.pipeTypes.findIndex(type => type.id == this.pipe.type_id);
        if (typeof index !== 'undefined') {
          return this.pipeTypes[index]
        }
      }

      return blankPipeParams;
    },
    guOptions: function () {
      let options = [];
      this.guPoints.forEach((item) => {
        options.push(
            {value: item.id, text: item.name}
        );
      });

      return options;
    },
    zuOptions: function () {
      let options = [];
      this.zuPoints.forEach((item) => {
        if (_.isUndefined(this.pipe.gu_id) ||
            item.gu_id == this.pipe.gu_id
        ) {
          options.push(
              {value: item.id, text: item.name}
          );
        }
      });

      return options;
    },
  },
  validations: {
    pipe: {
      gu_id: {
        required
      },
      name: {
        required
      },
      zu_id: {
        required
      },
      type_id: {
        required
      }
    }
  },
  methods: {
    validate() {
      this.$v.$touch();

      return this.$v.$invalid;
    },
    updateEndPoints () {
      let well, zu, gu;

      switch (this.pipe.between_points) {
        case 'well-zu':
          well = this.wellPoints.find((well) => {
            return well.id == this.pipe.well_id;
          });

          zu = this.zuPoints.find((zu) => {
            return zu.id == this.pipe.zu_id;
          });

          this.pipe.start_point = well.name
          this.pipe.end_point = zu.name;
          break;

        case 'zu-gu':
          gu = this.guPoints.find((gu) => {
            return gu.id == this.pipe.gu_id;
          });

          zu = this.zuPoints.find((zu) => {
            return zu.id == this.pipe.zu_id;
          });

          this.pipe.end_point = gu.name
          this.pipe.start_point = zu.name;
          break;
      }
    }
  }
}
</script>

<style scoped lang="scss">
.coords-collapse {
  outline: none;
  box-shadow: none !important;

  i {
    float: right;
    top: 3px;
    position: relative;
    transition: transform .15s cubic-bezier(1, -.115, .975, .855);
  }

  &.not-collapsed i {
    -webkit-transform: rotate(180deg);
    -moz-transform: rotate(180deg);
    -o-transform: rotate(180deg);
    -ms-transform: rotate(180deg);
    transform: rotate(180deg);
  }
}

.params_block {
  color: white;
}

.white-border-top {
  border-top: 1px solid rgba(255, 255, 255, 1);
}
</style>