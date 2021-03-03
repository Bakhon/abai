<template>
  <div>
    <b-form-group
        :label="trans('monitoring.gu.gu')"
        label-for="gu"
        v-if="pipe.gu_id"
    >
      <b-form-select
          id="gu"
          v-model="pipe.gu_id"
          :options="guOptions"
      ></b-form-select>
    </b-form-group>

    <b-form-group
        :label="trans('monitoring.zu.zu')"
        label-for="zu">
      <b-form-select
          id="gu"
          v-model="pipe.zu_id"
          :options="zuOptions"
      ></b-form-select>
    </b-form-group>

    <h5 class="coords-collapse" v-b-toggle.coordsVisible>{{ trans('monitoring.pipe.coords') }}
      <i class="fas fa-chevron-down"></i>
    </h5>

    <b-collapse  id="coordsVisible">
      <b-row v-for="(coord, index) in pipe.coordinates" :key="index">
        <b-col cols="12" sm="6">
          <b-form-group :label="trans('monitoring.latitude')" :label-for="'coord-x'+index">
            <b-form-input
                :id="'coord-x'+index"
                v-model="pipe.coordinates[index][1]"
                required
            ></b-form-input>
          </b-form-group>
        </b-col>
        <b-col cols="12" sm="6">
          <b-form-group :label="trans('monitoring.longitude')" :label-for="'coord-y'+index">
            <b-form-input
                :id="'coord-y'+index"
                v-model="pipe.coordinates[index][0]"
                required
            ></b-form-input>
          </b-form-group>
        </b-col>
        <hr class="mb-2" />
      </b-row>
    </b-collapse>
  </div>
</template>

<script>
export default {
  name: "mapPipeForm",
  props: {
    pipe: {
      type: Object,
      required: true,
    },
    gus: {
      type: Array,
      required: true,
    },
    zus: {
      type: Array,
      required: true,
    }
  },
  computed: {
    guOptions: function () {
      let options = [];
      this.gus.forEach((item) => {
        options.push(
            { value: item.id, text: item.name }
        );
      });

      return options;
    },
    zuOptions: function () {
      let options = [];
      this.zus.forEach((item) => {
        options.push(
            { value: item.id, text: item.name }
        );
      });

      return options;
    },
  },
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
    transition: transform .15s cubic-bezier(1,-.115,.975,.855);
  }

  &.not-collapsed i {
    -webkit-transform: rotate(180deg);
    -moz-transform: rotate(180deg);
    -o-transform: rotate(180deg);
    -ms-transform: rotate(180deg);
    transform: rotate(180deg);
  }
}
</style>