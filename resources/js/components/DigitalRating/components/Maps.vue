<template>
  <div class="maps-development">
    <div class="maps-development__wrapper">
      <div id="mapLeft"></div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { digitalRatingState, globalloadingMutations} from '@store/helpers';
import maps from '../mixins/maps.js';
import L from "leaflet";

export default {
  name: "Maps",

  mixins: [maps],

  data() {
    return {
      leftMap: null,
      rightMap: null,
      rectangle: null,
      zoom: -1,
      mapList: [],
      currentProd: [],
      center: [83600, 52800],
      bounds: [[0, 15000], [0, 15000]],
    }
  },

  async mounted() {
    this.SET_LOADING(true);
    await this.fetchMapData();
    await this.initMap('mapLeft', 'leftMap');
    await this.initSectorsOnMap('leftMap');
    this.initCurrentProdOnMap();
    this.SET_LOADING(false);
  },

  computed: {
    ...digitalRatingState([
      'sectorNumber',
      'horizonNumber'
    ]),
  },

  methods: {
    initMap(id, property) {
      this[property] = L.map(id, {
        crs: L.CRS.Simple,
        zoomControl: false,
        minZoom: this.minZoom,
        maxZoom: this.maxZoom,
        attributionControl: false
      });

      L.control.zoom({
        position: 'bottomright'
      }).addTo(this[property]);

      this[property].fitBounds(this.bounds);
      this[property].setView( this.center, this.zoom);

      this[property].on('zoom', this.onMapZoom);
    },

    async initSectorsOnMap(property) {
      if(this.mapList?.length === 0) return;

      for (let i = 0; i < this.mapList.length; i++) {
        this.rectangle = L.rectangle(this.getBounds(this.mapList[i]), {
          renderer: this.renderer,
          weight: 1,
          color: this.mapList[i]['color'],
          fillColor: this.mapList[i]['color'],
          fillOpacity: 1,
        }).addTo(this[property]).bindPopup(this.mapList[i]['value'].toString());

        this.rectangle.on('mouseover', function (e) {
          this.openPopup();
        });
        this.rectangle.on('mouseout', function (e) {
          this.closePopup();
        });
      }
    },

    initCurrentProdOnMap() {
      for (let i = 0; i < this.currentProd.length; i++) {
        let cumProdChart = L.minichart([this.currentProd[i].y, this.currentProd[i].x], {
          data: [this.currentProd[i].oil_rate, this.currentProd[i].water_rate],
          type: 'pie',
          colors: ['#fcba03', '#039dfc'],
          width: this.currentProd[i].r,
          height: this.currentProd[i].r,
          labels: [this.currentProd[i].well]
        });
        this.leftMap.addLayer(cumProdChart);
      }
    },

    async fetchMapData() {
     const res = await axios.get(
         `${process.env.MIX_DIGITAL_RATING_MAPS}/maps/near/${this.horizonNumber}/${this.sectorNumber}`
      );
     if (!res.error) {
       this.mapList = res.data?.map;
       this.currentProd = res.data?.current_prod;
       // this.center = this.bounds = [];
       // this.center = [res.data?.center[0]?.x_c, res.data?.center[0]?.y_c];
       // this.bounds = [[res.data?.borders[0]?.x_min, res.data?.borders[0]?.x_max], [res.data?.borders[0]?.y_min, res.data?.borders[0]?.y_max]];
     }
    },

    ...globalloadingMutations([
      'SET_LOADING'
    ]),
  }
}
</script>

<style scoped lang="scss">
.maps-development {
  display: flex;
  justify-content: space-around;
  width: 100%;
  margin-bottom: 10px;
}
.maps-development__title {
  color: #fff;
  margin-bottom: 10px;
  font-size: 16px;
  text-align: center;
}
.maps-development__wrapper {
  display: flex;
  align-items: center;
  justify-content: center;
  //background-image: url('/img/digital-rating/bgLine.svg');
  //background-repeat: no-repeat;
  //background-size: cover;
  //background-color: #2B2E5E;
  //border: 1px solid #545580;
  width: 100%;
  height: calc(100vh - 400px);

}

#mapLeft, #mapRight {
  width: 100%;
  height: 100%;
  background: transparent;
}
</style>
