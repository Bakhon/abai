<template>
  <div class="map-context-menu"
       id="contextMenu"
       v-show="showContextMenu"
       :style="menuStyle"
       v-click-outside="onClickOutside"
  >
    <div class="map-context-menu__items">
      <li
          v-for="(option, index) in options"
          class="map-context-menu__item"
          @click.stop="optionClicked(option)">
        <span v-html="option.name"></span>
      </li>
    </div>
  </div>
</template>

<script>
import Vue from 'vue'
import vClickOutside from 'v-click-outside'

Vue.use(vClickOutside)

export default {
  name: "mapContextMenu",
  props: {
    value: {
      required: true,
      validator: prop => typeof prop === 'object' || prop === null
    }
  },
  data() {
    return {
      showContextMenu: false,
      point: {
        x: 0,
        y: 0
      },
      lngLat: {
        lat: 0,
        lng: 0
      }
    }
  },
  computed: {
    menuStyle() {
      let display = this.showContextMenu ? 'block !important' : 'none';
      return {
        left: this.point.x + 'px',
        top: this.point.y + 'px',
        display: display
      }
    },
    clickedObject: {
      get() {
        return this.value;
      },
      set(val) {
        this.$emit('input', val)
      }
    },
    defaultOptions() {
      return [
        {
          name: this.trans('app.create') + ' ' + this.trans('monitoring.gu.gu'),
          lngLat: this.lngLat,
          type: 'create',
          editMode: 'gu'
        },
        {
          name: this.trans('app.create') + ' ' + this.trans('monitoring.zu.zu'),
          lngLat: this.lngLat,
          type: 'create',
          editMode: 'zu'
        },
        {
          name: this.trans('app.create') + ' ' + this.trans('monitoring.well_vinit'),
          lngLat: this.lngLat,
          type: 'create',
          editMode: 'well'
        },
      ]
    },
    optionsForSelectedObject() {
      let options =  [
        {
          name: this.trans('app.edit') + ' ' + this.clickedObject.name,
          mapObject: this.clickedObject,
          type: 'edit',
          editMode: this.clickedObject.type
        },
        {
          name: this.trans('app.delete') + ' ' + this.clickedObject.name,
          mapObject: this.clickedObject,
          editMode: this.clickedObject.type,
          type: 'delete',
        }
      ];

      if (this.clickedObject.type == 'zu' || this.clickedObject.type == 'well') {
        options.push({
          name: this.trans('monitoring.pipe.add'),
          mapObject: this.clickedObject,
          type: 'create',
          editMode: 'pipe'
        });
      }

      return options;
    },
    options() {
      return this.clickedObject ? this.optionsForSelectedObject : this.defaultOptions;
    }
  },
  methods: {
    showMenu(coords) {
      this.point = coords.point;
      this.lngLat = coords.lngLat;
      this.showContextMenu = true;
    },
    hideContextMenu() {
      this.clickedObject = null;
      this.showContextMenu = false;
    },
    onClickOutside() {
      this.hideContextMenu()
    },
    optionClicked(option) {
      this.hideContextMenu();
      this.$emit('option-clicked', option)
    },
    onEscKeyRelease(event) {
      if (event.keyCode === 27) {
        this.hideContextMenu();
      }
    }
  }
}
</script>

<style lang="scss">
$light-grey: #ecf0f1;
$grey: darken($light-grey, 15%);
$blue: #20274f;
$white: #fff;
$black: #333;

.map-context-menu {
  top: 0;
  left: 0;
  margin: 0;
  list-style: none;
  position: absolute;
  z-index: 1000000;
  background-color: $blue;
  color: $white;
  border: 1px solid rgba(0, 0, 0, 0.15);
  border-radius: 0.25rem;
  float: left;
  min-width: 10rem;
  padding: 0.5rem 0;
  font-size: 0.9rem;

  &__items {
    margin-left: 15px;
  }

  &__item {
    width: 15vw;
    margin-left: 10px;
    cursor: pointer;
    align-items: center;
    text-decoration: none;

    &:hover {
      text-decoration: underline;
    }
  }

  li {
    &:first-of-type {
      margin-top: 4px;
    }

    &:last-of-type {
      margin-bottom: 4px;
    }
  }
}
</style>