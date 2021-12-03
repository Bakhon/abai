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

export default {
  name: "Maps",

  mixins: [maps],

  data() {
    return {
      map: null,
      rectangle: null,
    }
  },

  async mounted() {
    this.SET_LOADING(true);
    await this.initMap('mapLeft');
    await this.initSectorOnMap();
    this.SET_LOADING(false);
  },

  computed: {
    ...digitalRatingState([
      'sectorNumber',
      'horizonNumber'
    ]),
  },

  methods: {
    async initSectorOnMap() {
      const maps = await this.fetchMapData();
      if(maps?.length === 0) return;

      for (let i = 0; i < maps.length; i++) {
        this.rectangle = L.rectangle(this.getBounds(maps[i]), {
          renderer: this.renderer,
          color: '#fff',
          fillColor: '#fff',
          weight: 1,
        }).addTo(this.map).bindPopup(maps[i]['sector'].toString());

        this.rectangle.on('mouseover', function (e) {
          this.openPopup();
        });
        this.rectangle.on('mouseout', function (e) {
          this.closePopup();
        });
      }
    },

    async fetchMapData() {
     const res = await axios.get(
         `${process.env.MIX_TEST_MICROSERVICE}/maps/near/${this.horizonNumber}/${this.sectorNumber}`
      );
     if (!res.error) {
       return res.data.map;
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
  flex-direction: column;
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
  background-image: url('/img/digital-rating/bgLine.svg');
  background-repeat: no-repeat;
  width: calc(45% - 10px);
  background-size: cover;
  background-color: #2B2E5E;
  border: 1px solid #545580;
}

#mapLeft {
  width: 50%;
  height: 50%;
  background: transparent;
}
</style>
