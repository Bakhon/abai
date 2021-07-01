<template>
  <div class="rating-sections">
    <div class="rating-content">
      <div class="rating-content__title">
        <div>{{ trans('digital_rating.map') }}</div>
        <div class="d-flex">
          <div
            class="btn-dropdown"
            :class="{'is-active': show}"
          >
            <div class="btn-dropdown__header" @click="handleShow">
              <i class="far fa-file"></i>
              <div class="btn-dropdown__title">{{ trans('digital_rating.file') }}</div>
              <div class="btn-dropdown__icon"/>
            </div>
            <div v-if="show" class="btn-dropdown__area">
              <ul class="btn-dropdown__area-list">
                <li>
                  <i class="fas fa-upload"></i>
                  <span>{{ trans('digital_rating.import') }}</span>
                </li>
                <li>
                  <i class="fas fa-download"></i>
                  <span>{{ trans('digital_rating.export') }}</span>
                </li>
                <li>
                  <i class="far fa-save"></i>
                  <span>{{ trans('digital_rating.save') }}</span>
                </li>
              </ul>
            </div>
          </div>
          <img class="ml-10px" src="/img/icons/link.svg" alt="">
        </div>
      </div>
      <div class="rating-content__wrapper">
        <img src="/img/digital-rating/map.svg" alt="">
      </div>
    </div>
    <div class="rating-panel">
      <div
        class="rating-dropdown"
        :class="{ 'is-active': dropdownTitle === 'object' }"
      >
        <div class="rating-dropdown__header" @click="handleToggle('object')">
          <div class="rating-dropdown__title">{{ trans('digital_rating.object') }}</div>
          <div class="rating-dropdown__icon"></div>
        </div>
        <transition-expand duration="100">
          <div v-show="dropdownTitle === 'object'" class="rating-dropdown__body">
            <ul class="list">
              <li v-for="(object, index) in objects" :key="index">
                {{ object }}
              </li>
            </ul>
          </div>
        </transition-expand>
      </div>
      <div
        class="rating-dropdown"
        :class="{ 'is-active': dropdownTitle === 'map' }"
      >
        <div class="rating-dropdown__header" @click="handleToggle('map')">
          <div class="rating-dropdown__title">{{ trans('digital_rating.mapsGeologyDevelopment') }}</div>
          <div class="rating-dropdown__icon"></div>
        </div>
        <transition-expand duration="100">
          <div v-show="dropdownTitle === 'map'" class="rating-dropdown__body">
            <ul class="list">
              <li v-for="(map, index) in maps" :key="index">
                {{ map }}
              </li>
            </ul>
          </div>
        </transition-expand>
      </div>
      <div
        class="rating-dropdown"
        :class="{ 'is-active': dropdownTitle === 'code' }"
      >
        <div class="rating-dropdown__header" @click="handleToggle('code')">
          <div class="rating-dropdown__title">{{ trans('digital_rating.sectorCode') }}</div>
          <div class="rating-dropdown__icon"></div>
        </div>
        <transition-expand duration="100">
          <div v-show="dropdownTitle === 'code'" class="rating-dropdown__body">
            <ul class="list">
              <li v-for="(code, index) in cods" :key="index">
                {{ code }}
              </li>
            </ul>
          </div>
        </transition-expand>
      </div>
      <div
        class="rating-dropdown"
        :class="{ 'is-active': dropdownTitle === 'property' }"
      >
        <div class="rating-dropdown__header" @click="handleToggle('property')">
          <div class="rating-dropdown__title">{{ trans('digital_rating.property') }}</div>
          <div class="rating-dropdown__icon"></div>
        </div>
        <transition-expand duration="100">
          <div v-show="dropdownTitle === 'property'" class="rating-dropdown__body">
            <ul class="list">
              <li v-for="(property, index) in properties" :key="index">
                {{ property }}
              </li>
            </ul>
          </div>
        </transition-expand>
      </div>
    </div>
  </div>
</template>

<script>
import { TransitionExpand } from 'vue-transition-expand';

export default {
  name: "Sections",

  components: {
    TransitionExpand
  },

  data() {
    return {
      show: false,
      dropdownTitle: '',
      objects: ['Объект 1', 'Объект 2'],
      maps: ['Карта ННТ', 'Накопленные отборы'],
      cods: ['1', '2', '3'],
      properties: ['Значок', 'Шрифт', 'Палитра'],
    };
  },

  mounted() {
    document.addEventListener('click', this.close);
  },

  beforeDestroy() {
    document.removeEventListener('click', this.close);
  },

  methods: {
    handleToggle(title) {
      this.dropdownTitle = title;
    },
    handleShow() {
      this.show = !this.show;
    },
    close(e) {
      if (!this.$el.contains(e.target)) {
        this.show = false;
      }
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

.btn-dropdown {
  position: relative;

  &__icon {
    display: block;
    position: absolute;
    top: 0;
    right: 12px;
    bottom: 0;
    margin: auto;
    width: 8px;
    height: 8px;
    border-right: 2px solid #fff;
    border-bottom: 2px solid #fff;
    transform: translateY(-2px) rotate(45deg);
    transition: transform 0.2s ease;
  }

  &.is-active {
    .btn-dropdown__icon {
      transform: translateY(2px) rotate(225deg);
    }
  }
}

.btn-dropdown__header {
  background: #5D5F7F;
  display: flex;
  align-items: center;
  padding: 6px 12px;
  width: 200px;
  border-radius: 4px;
  cursor: pointer;
}

.btn-dropdown__title {
  margin-left: 10px;
}

.btn-dropdown__area {
  background: #5D5F7F;
  border-radius: 4px;
  position: absolute;
  z-index: 10;
  width: 200px;
  margin-top: 6px;

  &-list {
    list-style: none;
    margin: 0;

    li {
      display: flex;
      align-items: center;
      padding: 8px;

      span {
        margin-left: 8px;
      }

      &:hover {
        background: #4b4c66;
        cursor: pointer;
        border-radius: 4px;
      }
    }
  }
}
</style>
