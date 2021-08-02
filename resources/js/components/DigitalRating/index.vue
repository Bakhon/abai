<template>
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
</template>

<script>
import L from 'leaflet';
import mapsData from './dataMap.json';
import 'leaflet/dist/leaflet.css';
import BtnDropdown from "./components/BtnDropdown";
import SettingModal from "./components/SettingModal";
import WellAtlasModal from "./components/WellAtlasModal";
import Accordion from "./components/Accordion";

export default {
  name: "Sections",

  components: {
    BtnDropdown,
    SettingModal,
    WellAtlasModal,
    Accordion
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
      ]
    };
  },

  async mounted() {
    await this.initMap();
  },

  methods: {
    initMap() {
      const map = L.map('map', {
        crs: L.CRS.Simple,
        minZoom: 1,
        maxZoom: 3,
      });
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

      L.latLng([ mapsData[0]['x'], mapsData[0]['y'] ]);

      for(let i = 0; i < mapsData.length; i++) {
        const coordinateStart = xy(mapsData[i]['x'], mapsData[i]['y']);
        const coordinateEnd = xy(mapsData[i]['x'] + 1, mapsData[i]['y'] + 1);
        let marker = L.rectangle([[coordinateStart], [coordinateEnd]], {
          color: mapsData[i]['color'],
          weight: 6,
          fillColor: mapsData[i]['color'],
          fillOpacity: 1,
        }).addTo(map).bindPopup(mapsData[i]['sector'].toString());
        marker.on('mouseover', function (e) {
          this.openPopup();
        });
        marker.on('mouseout', function (e) {
          this.closePopup();
        });
        marker.on('click', (e) => {
          this.onMapClick();
        })
      }
      map.getBounds().pad(1);
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
  }
}
</script>

<style lang="scss" scoped>
.rating-sections {
  color: #fff;
  display: flex;

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
