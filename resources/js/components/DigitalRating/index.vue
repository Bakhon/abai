<template>
  <div>
    <gtm-main-menu
      :parentType="this.parentType"
      :mainMenu="menu"
      @menuClick="menuClick"
    />
    <div class="rating-sections">
      <div class="rating-content">
        <div class="rating-content__title">
          <div>{{ trans('digital_rating.sectorMap') }}</div>
          <div class="d-flex align-items-center">
            <btn-dropdown :list="fileActions">
              <template #icon>
                <i class="far fa-file"/>
              </template>
              <template #title>
                {{ trans('digital_rating.file') }}
              </template>
            </btn-dropdown>
            <btn-dropdown :list="mapsActions">
              <template #icon>
                <i class="fas fa-map-marked-alt"/>
              </template>
              <template #title>
                {{ trans('digital_rating.maps') }}
              </template>
            </btn-dropdown>
            <i class="fas fa-cog gear-icon-svg"
               @click="openSettingModal"
               style="font-size: 20px;"
            />
          </div>
        </div>
        <div class="rating-content__wrapper">
          <div id="map"></div>
        </div>
      </div>
      <div class="rating-panel">
        <accordion
            :list="objects"
            title="digital_rating.object"
        />
        <accordion
            :list="maps"
            title="digital_rating.mapsGeologyDevelopment"
        />
        <accordion
            :list="cods"
            title="digital_rating.sectorCode"
        />
        <accordion
            :list="properties"
            title="digital_rating.property"
        />
      </div>
      <setting-modal
        @close="closeSettingModal"
      />
      <well-atlas-modal
        @close="closeAtlasModal"
      />
    </div>
  </div>
</template>

<script>
import L from 'leaflet';
import mapsData from './json/dataMap.json';
import wellsData from './json/dataWells.json';
import geojson from './json/geojson.json';
import 'leaflet/dist/leaflet.css';
import BtnDropdown from "./components/BtnDropdown";
import SettingModal from "./components/SettingModal";
import WellAtlasModal from "./components/WellAtlasModal";
import Accordion from "./components/Accordion";
import mainMenu from "../GTM/mock-data/main_menu.json";

export default {
  name: "Sections",

  components: {
    BtnDropdown,
    SettingModal,
    WellAtlasModal,
    Accordion,
  },

  data() {
    return {
      objects: ['Объект 1', 'Объект 2'],
      maps: ['Карта ННТ', 'Накопленные отборы'],
      cods: ['1', '2', '3'],
      properties: ['Значок', 'Шрифт', 'Палитра'],
      fileActions: [
        { title: 'digital_rating.import', icon: 'upload', type: 'import'  },
        { title: 'digital_rating.export', icon: 'download', type: 'export' },
        { title: 'digital_rating.save', icon: 'save', type: 'save' }
      ],
      mapsActions: [
        { title: 'digital_rating.uploadCustomMaps', icon: 'share', type: 'upload' },
        { title: 'digital_rating.importPlannedWells', icon: 'upload', type: 'importWells' }
      ],
      parentType: '',
      menu: mainMenu,
      mapStyle: 'mapbox://styles/mapbox/satellite-v9?optimize=true',
    };
  },

  async mounted() {
    await this.initMap();
  },

  methods: {
    initMap2() {
      var mapboxAccessToken = 'pk.eyJ1IjoibWFja2V5c2kiLCJhIjoiY2sxZ2JwdzF1MDk4eDNubDhraHNxNTluaCJ9.5VnpUHKLM0rdx1pYjpNYPw';
      var map = L.map('map');

      L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=' + mapboxAccessToken, {
        id: 'mapbox/light-v9',
        tileSize: 512,
        zoomOffset: -1
      }).addTo(map);

      L.geoJson(geojson).addTo(map);
    },
    initMap() {
      const map = L.map('map', {
        crs: L.CRS.Simple,
        zoomControl: false,
        minZoom: 1,
        maxZoom: 3,
      });
      // L.tileLayer("http://{s}.tile.osm.org/{z}/{x}/{y}.png").addTo(map);

      L.control.zoom({
        position: 'bottomright'
      }).addTo(map);

      const bounds = [[0, 1500], [0,1500]];
      map.fitBounds(bounds);

      let yx = L.latLng;
      const xy = function (x, y) {
        if (L.Util.isArray(x)) {
          return yx(x[1], x[0]);
        }
        return yx(y, x);
      };

      map.setView( [850, 520], 1);

      mapsData.forEach((el) => {
        el.x = el.x / 100;
        el.y = el.y / 100;
      });

      const renderer = L.canvas({ padding: 0.5 })

      for(let i = 0; i < mapsData.length; i++) {
        const coordinateStart = xy(mapsData[i]['x'], mapsData[i]['y']);
        const coordinateEnd = xy(mapsData[i]['x'] + 1, mapsData[i]['y'] + 1);
        let rectangle = L.rectangle([[coordinateStart], [coordinateEnd]], {
          renderer: renderer,
          color: mapsData[i]['color'],
          weight: 6,
          fillColor: mapsData[i]['color'],
          fillOpacity: 1,
        }).addTo(map).bindPopup(mapsData[i]['sector'].toString());

        rectangle.on('mouseover', function (e) {
          this.openPopup();
        });
        rectangle.on('mouseout', function (e) {
          this.closePopup();
        });
        rectangle.on('click', (e) => {
          this.onMapClick();
        })
      }

      wellsData.forEach((el) => {
        el.x = el.x / 100;
        el.y = el.y / 100;
      });

      for(let i = 0; i < wellsData.length; i++) {
        const coordinate = xy(wellsData[i]['x'], wellsData[i]['y']);
        const marker = L.circleMarker(coordinate, {
          renderer: renderer,
          radius: 10,
          stroke: true,
          color: 'black',
          opacity: 1,
          weight: 1,
          fill: false,
          fillOpacity: 0
        }, 500).addTo(map).bindPopup(wellsData[i]['well']);
      }

      const myZoom = {
        start:  map.getZoom(),
        end: map.getZoom()
      };

      // map.on('zoomstart', function(e) {
      //   myZoom.start = map.getZoom();
      // });
      //
      // map.on('zoomend', function(e) {
      //   myZoom.end = map.getZoom();
      //   const diff = myZoom.start - myZoom.end;
      //   if (diff > 0) {
      //     L.circle.setRadius(L.circle.getRadius() / 2);
      //   } else if (diff < 0) {
      //     L.circle.setRadius(L.circle.getRadius() / 2);
      //   }
      // });

      // map.getBounds().pad(1);
    },
    onMapClick() {
      this.$modal.show('modalAtlas');
    },
    closeAtlasModal() {
      this.$modal.hide('modalAtlas');
    },
    openSettingModal() {
      this.$modal.show('modalSetting');
    },
    closeSettingModal() {
      this.$modal.hide('modalSetting');
    },
    menuClick(data) {
      const path = window.location.pathname.slice(3);
      if (data?.url && data.url !== path) {
        window.location.href = this.localeUrl(data.url);
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.rating-sections {
  color: #fff;
  display: flex;
  margin-top: 3rem;

  .rating-content {
    height: calc(100vh - 160px);

    &__wrapper {
      height: calc(100% - 40px);
      img {
        width: 80%;
      }
    }
  }
}

.rating-panel {
  width: 100%;
  max-width: 24.4%;
}

#map {
  width: 100%;
}

.leaflet-container {
  background: transparent;
}

.gear-icon-svg {
  cursor: pointer;
  margin-left: 10px;
  &:hover {
    content: "";
    opacity: 100;
    -webkit-animation: gear-icon-svg 3s infinite both;
    animation: gear-icon-svg 3s infinite both;
  }
}

@-webkit-keyframes gear-icon-svg {
  0% {
    -webkit-transform: scale(1) rotateZ(0);
    transform: scale(1) rotateZ(0);
  }
  50% {
    -webkit-transform: scale(1) rotateZ(180deg);
    transform: scale(1) rotateZ(180deg);
  }
  100% {
    -webkit-transform: scale(1) rotateZ(360deg);
    transform: scale(1) rotateZ(360deg);
  }
}
</style>
