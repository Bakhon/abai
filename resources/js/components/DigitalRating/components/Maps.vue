<template>
  <div class="maps-development" v-for="item in objects">
    <div class="maps-development__title">
      {{ item }}
    </div>
    <div class="maps-development__wrapper">
      <div class="maps-development__item" v-for="map in maps">
        <img class="maps-development__item-icon" src="/img/icons/link.svg" alt="">
        <img
          class="maps-development__item-img"
          :src="`/img/digital-rating/${map}.svg`" alt=""
        >
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Maps",
  data() {
    return {
      objects: ['Объект 1', 'Объект 2', 'Объект 3'],
      maps: ['map1', 'map2', 'map3', 'map4'],
    }
  }
}
</script>

<style scoped lang="scss">
.maps-development {
  display: flex;
  flex-direction: column;
  width: 100%;
  background-color: #272953;
  padding: 10px;
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
}
</style>
