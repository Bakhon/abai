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
        <accordion title="digital_rating.object">
          <ul class="list">
            <li
              v-for="(item, index) in objects" :key="index"
              @click="selectPanelItem('horizon', item)"
              :class="{'active': item.id === horizonNumber}"
            >
              {{ item.title || item }}
            </li>
          </ul>
        </accordion>
        <accordion
          :list="maps"
          title="digital_rating.mapsGeologyDevelopment"
          @selectItem="(item) => selectPanelItem('map', item)"
        />
        <accordion title="digital_rating.legend">
          <ul class="list">
            <li
              v-for="(item, index) in legends" :key="index">
              <span>{{index+1}}</span>
              <div :style="`background: ${item.color}`" class="legend">
              </div>
              <span>{{ item.title }}</span>
            </li>
          </ul>
        </accordion>
        <accordion
          :list="properties"
          title="digital_rating.property"
        />
      </div>
      <setting-modal
        @close="closeSettingModal"
      />
      <well-atlas-modal
        ref="atlasModal"
        @close="closeAtlasModal"
      />
    </div>
  </div>
</template>

<script src="./Section.js"></script>

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

.leaflet-div-icon {
  background: #fff;
  border: 1px solid #666;
}
</style>
