<template>
  <div>
    <div class="dropdown" @click="showDropdown">
      <div class="overselect">
        <div>
          {{ trans('pgno.select_options') }}
        </div>
      </div>
      <select class="c-form-input" >
        <option value=""></option>
      </select>
    </div>
    <div class="multiselect" v-if="show">
      <ul>
        <li class="border-b" v-for="(option, index) in options" :key="index">
          <input type="checkbox" :id="index" :value="option" v-model="selectedValues">
          <label :for="index">{{ option }}</label>
        </li>
      </ul>
    </div>
  </div>
</template>
<script>

export default {
  name: "dropdownMultiselect",
  props: ['options', 'selected'],
  data() {
    return {
      show: false,
      selectedValues: this.selected,
    }
  },
  methods: {
    showDropdown() {
      this.show = !this.show
      this.$emit('closeDropdown', this.selectedValues)
    },
  },
}
</script>
<style scoped lang="scss">
.c-form-input {
  width: 230px;
  height: 28px;
  background-color: #24264a;
  border: 0.5px solid #454FA1;
  box-sizing: border-box;
  border-radius: 4px;
  color: white;
}

.border-b {
  border-bottom: 1px solid rgba(196, 222, 242, 0.4) !important;
}

.dropdown {
  position: relative;
  cursor: pointer;
}

.multiselect {
  position: relative;
  width: 230px;
  height: 198px;

  ul {
    background: #40467E;
    border: 0.5px solid #454FA1;
    border-radius: 10px;
    left: 0;
    padding: 8px 8px;
    position: absolute;
    top: 0.25rem;
    list-style: none;
    max-height: 150px;
    overflow: auto;
    width: 230px;
    height: 198px;
    font-size: 12px;
    z-index: 1;
  }
}

.overselect {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  padding-left: 5px;
  border: 0.5px solid #454FA1;
}

.overselect:hover {
  background-color: #293688;
  //opacity: 0.33;
  border: 0.5px solid #454FA1;
  color: white;
}
</style>