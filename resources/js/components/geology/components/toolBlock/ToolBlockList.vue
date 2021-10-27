<template>
  <div :class="toolBlockClass">
    <div class="loading d-flex align-items-center justify-content-center" v-if="loading">
      <AwIcon width="40" height="40" name="loading" />
    </div>
    <div v-if="description" class="description mb-2">
      <p>{{ description }}</p>
    </div>
    <button v-for="(item, i) in cList" :key="i" @click="selectHandle(item, i)" :class="optionsClasses(item.value)">
      <input
          class="mr-2"
          v-if="hasCheckbox"
          type="checkbox"
          :value="item.value"
          :checked="cSelected.includes(item.value)"
      />
      {{ item.label || item.value }}
    </button>
  </div>
</template>

<script>
import AwIcon from "../icons/AwIcon";

export default {
  name: "toolBlockList",
  props: {
    description: String,
    hasCheckbox: Boolean,
    loading: Boolean,
    list: Array,
    selected: Array
  },
  components: {
    AwIcon
  },
  computed: {
    cList() {
      return this.list || [];
    },
    cSelected() {
      return this.selected || []
    },
    toolBlockClass() {
      return {
        "toolBlock__list": true,
        "multiple": this.hasCheckbox
      }
    }
  },
  methods: {
    selectHandle(item, index) {
      this.$emit('update:selected', this.cSelected);
      this.$emit('click', item, index);
    },
    optionsClasses(value) {
      return {
        'd-flex align-items-center mb-2': this.hasCheckbox,
        "active": this.cSelected.includes(value)
      }
    }

  }
}
</script>

<style scoped lang="scss">
.toolBlock {

  &__list {
    padding: 5px 0;
    background: var(--a-accent-300);

    .loading {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.38);
    }

    .description {
      background: var(--a-accent-100);
      padding: 7px 12px;
      margin-top: -5px;

      p {
        font-size: 16px;
        color: #ffffff;
        margin: 0;
      }
    }

    button {
      width: 100%;
      text-align: left;
      display: block;
      background: none;
      border: none;
      color: #ffffff;
      font-size: 14px;
      font-weight: 400;
      padding: 2px 12px;
      transition: 300ms all;
      line-height: 1;

      &:last-child {
        margin-bottom: 0 !important;
      }
      &.active {
        background: var(--a-accent-100)
      }
      &:hover{
        background: var(--a-accent-darken-200)
      }
    }

    &.multiple {
      button {
        &:hover, &.active {
          background: none
        }
      }
    }
  }
}
</style>
