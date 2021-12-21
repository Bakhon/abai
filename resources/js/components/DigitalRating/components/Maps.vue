<template>
  <div class="maps-development">
    <div class="maps-development__wrapper">
      <div id="mapLeft"></div>
    </div>
    <div class="maps-development__wrapper">
      <div id="mapRight"></div>
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
      zoomLeft: -1,
      zoomRight: -1,
      mapList: [],
      currentProd: [],
      center: [83600, 52800],
      bounds: [[0, 12000], [0, 12000]],
      rectangleLeft: null,
      rectangleRight: null
    }
  },

  async mounted() {
    this.SET_LOADING(true);
    await this.fetchMapData();
    await this.initLeftMap();
    await this.initRightMap();
    await this.initSectorsLeftOnMap();
    await this.initSectorsRightOnMap();
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
    initLeftMap() {
      this.leftMap = L.map('mapLeft', {
        crs: L.CRS.Simple,
        zoomControl: false,
        minZoom: this.minZoom,
        maxZoom: this.maxZoom,
        attributionControl: false
      });

      L.control.zoom({
        position: 'bottomright'
      }).addTo(this.leftMap);

      this.leftMap.fitBounds(this.bounds);
      this.leftMap.setView( this.center, this.zoomLeft);
    },
    initRightMap() {
      this.rightMap = L.map('mapRight', {
        crs: L.CRS.Simple,
        zoomControl: false,
        minZoom: this.minZoom,
        maxZoom: this.maxZoom,
        attributionControl: false
      });

      L.control.zoom({
        position: 'bottomright'
      }).addTo(this.rightMap);

      this.rightMap.fitBounds(this.bounds);
      this.rightMap.setView( this.center, this.zoomRight);
    },

    async initSectorsLeftOnMap() {
      if(this.mapList?.length === 0) return;

      for (let i = 0; i < this.mapList.length; i++) {
        this.rectangleLeft = L.rectangle(this.getBounds(this.mapList[i]), {
          renderer: this.renderer,
          weight: 1,
          color: this.mapList[i]['color'],
          fillColor: this.mapList[i]['color'],
          fillOpacity: 1,
        }).addTo(this.leftMap).bindPopup(this.mapList[i]['value'].toString());
      }
    },

    async initSectorsRightOnMap() {
      if(this.mapList?.length === 0) return;

      for (let i = 0; i < this.mapList.length; i++) {
        this.rectangleRight = L.rectangle(this.getBounds(this.mapList[i]), {
          renderer: this.renderer,
          weight: 1,
          color: this.mapList[i]['color'],
          fillColor: this.mapList[i]['color'],
          fillOpacity: 1,
        }).addTo(this.rightMap).bindPopup(this.mapList[i]['value'].toString());
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
  height: calc(100vh - 400px);
  border: 1px solid #545580;
  width: 48%;
}

#mapLeft, #mapRight {
  width: 100%;
  height: 100%;
  background: transparent;
}
</style>
