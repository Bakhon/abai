<template>
  <div class="maps-development">
    <div class="maps-development__title">
      {{ objectTitle }}
    </div>
    <div class="maps-development__wrapper">
      <div
        class="maps-development__item cursor-pointer"
        v-for="map in maps" :key="map"
        @click="handleClickMap(map)"
      >
        <img
          class="maps-development__item-img"
          :src="`/img/digital-rating/${map}.svg`" alt=""
        />
      </div>
    </div>
    <b-modal
      size="xl"
      header-bg-variant="main1"
      body-bg-variant="main1"
      header-text-variant="light"
      footer-bg-variant="main1"
      centered
      id="mapModal"
      hide-footer
    >
      <template #modal-header="{close}">
        <div class="d-flex justify-content-end w-100">
          <button type="button" class="modal-bign-button" @click="close">
            {{ trans('pgno.zakrit') }}
          </button>
        </div>
      </template>
      <div class="maps-development__item maps-development__item-full">
        <img
          class="maps-development__item-img"
          :src="`/img/digital-rating/${mapFull}.svg`" alt=""
        />
      </div>
    </b-modal>
  </div>
</template>

<script>
export default {
  name: "Maps",
  data() {
    return {
      objectTitle: 'Объект 1',
      maps: ['map1', 'map2', 'map3', 'map4'],
      mapFull: ''
    }
  },
  methods: {
    handleClickMap(map) {
      this.$bvModal.show('mapModal');
      this.mapFull = map;
    },
    close() {
      this.$bvModal.hide('mapModal');
    }
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
  justify-content: space-between;
}
.maps-development__item {
  background-image: url('/img/digital-rating/bgLine.svg');
  background-repeat: no-repeat;
  width: calc(25% - 10px);
  height: 100%;
  background-color: #2B2E5E;
  border: 1px solid #545580;
  display: flex;
  justify-content: space-evenly;
  padding: 20px;
  position: relative;

  &-img {
    width: 100%;
  }

  &-icon {
    position: absolute;
    right: 10px;
    top: 10px;
  }

  &-full {
    width: 100%;
    height: calc(100% - 40px);
  }
}
</style>
