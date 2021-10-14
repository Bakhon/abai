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
            <SearchFormRefresh
                @input="(val) => this.searchSector = val"
                placeholder="Поиск"
                @start-search="onSearchSector()"
                class="mr-10px"
            />
            <btn-dropdown :list="fileActions" class="mr-10px">
              <template #icon>
                <i class="far fa-file mr-10px"/>
              </template>
              <template #title>
                {{ trans('digital_rating.file') }}
              </template>
            </btn-dropdown>
            <btn-dropdown :list="mapsActions" class="mr-10px">
              <template #icon>
                <i class="fas fa-map-marked-alt mr-10px"/>
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
          <button class="ruler" @click="isRulerActive = !isRulerActive">
            <i class="fas fa-ruler" :class="{'active': isRulerActive}"/>
          </button>
        </div>
      </div>
      <div class="rating-panel">
        <accordion title="digital_rating.horizon">
          <ul class="list">
            <li
                v-for="(item, index) in horizons" :key="index"
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
              <span>{{ index + 1 }}</span>
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

<script src="./SectionMaps.js"></script>

<style lang="scss" scoped>
.rating-sections {
  color: #fff;
  display: flex;
  margin-top: 3rem;

  .rating-content {
    height: calc(100vh - 160px);

    &__wrapper {
      height: calc(100% - 40px);
      position: relative;
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

.ruler {
  position: absolute;
  right: 10px;
  top: 10px;
  z-index: 998;
  background-color: #fff;
  width: 28px;
  height: 24px;
  border-radius: 5px;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  border: none;

  .fa-ruler {
    color: #000;
    &.active {
      color: #198cff;
    }
  }
}
</style>
