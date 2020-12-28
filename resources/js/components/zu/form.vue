<template>
  <div class="col-xs-12 col-sm-12 col-md-12 row mb-5">
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>{{ trans('monitoring.gu') }}</label>
      <div class="form-label-group">
        <select class="form-control" name="gu_id" v-model="formFields.gu_id">
          <option v-for="row in gus" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
      <label>{{ trans('app.lon') }}</label>
      <div class="form-label-group">
        <input
            v-model="formFields.lon"
            type="number"
            step="0.00001"
            name="lon"
            class="form-control"
            placeholder=""
        >
      </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>{{ trans('app.param_name') }}</label>
      <div class="form-label-group">
        <input
            v-model="formFields.name"
            type="text"
            name="name"
            class="form-control"
            placeholder=""
        >
      </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>{{ trans('app.lat') }}</label>
      <div class="form-label-group">
        <input
            v-model="formFields.lat"
            type="number"
            step="0.00001"
            name="lat"
            class="form-control"
            placeholder=""
        >
      </div>
    </div>
    <div class="w-100 mb-3" style="height: 400px">
      <link
          href="https://api.tiles.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.css"
          rel="stylesheet"
      />
      <MglMap
          :accessToken="accessToken"
          :mapStyle="mapStyle"
          :zoom="11"
          :center="mapCenter"
          @load="onMapLoaded"
      >
        <MglMarker v-if="formFields.lat && formFields.lon" :coordinates="[formFields.lon, formFields.lat]"
                   color="blue"/>
      </MglMap>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <button type="submit" :disabled="!formFields.name" class="btn btn-success">{{ trans('app.save') }}</button>
    </div>
  </div>
</template>

<script>
import {MglMap, MglMarker} from "vue-mapbox"

export default {
  name: "zu-form",
  props: [
    'zu',
    'validationParams'
  ],
  components: {
    MglMap,
    MglMarker,
  },
  data: function () {
    return {
      formFields: {
        cdng_id: null,
        name: null,
        lat: null,
        lon: null
      },
      gus: {},
      accessToken: 'pk.eyJ1IjoibWFja2V5c2kiLCJhIjoiY2sxZ2JwdzF1MDk4eDNubDhraHNxNTluaCJ9.5VnpUHKLM0rdx1pYjpNYPw', // your access token. Needed if you using Mapbox maps
      mapStyle: 'mapbox://styles/mapbox/satellite-v9?optimize=true',
      mapCenter: [52.6899, 43.4898]
    }
  },
  beforeCreate: function () {

    this.axios.get(this.localeUrl("/getallgus")).then((response) => {
      let data = response.data;
      if (data) {
        this.gus = data.data;
      } else {
        console.log('No data');
      }
    });

  },
  mounted() {
    if (this.zu) {
      this.formFields = {
        gu_id: this.zu.gu_id,
        name: this.zu.name,
        lat: parseFloat(this.zu.lat),
        lon: parseFloat(this.zu.lon),
      }
      if(this.zu.lat && this.zu.lon) {
        this.mapCenter = [parseFloat(this.zu.lon), parseFloat(this.zu.lat)]
      }
    }
  },
  methods: {
    onMapLoaded(e) {
      e.map.on('dblclick', (event) => {
        event.preventDefault()
        let points = event.lngLat.toArray()
        this.formFields.lon = Math.round(points[0] * 100000) / 100000
        this.formFields.lat = Math.round(points[1] * 100000) / 100000
        return false
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
