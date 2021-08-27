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
          @selectItem="selectPanelItem"
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
</style>
