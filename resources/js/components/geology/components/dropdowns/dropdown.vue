<template>
  <div :class="cDropDownClass">
    <Button :disabled="disabled" @click.native.stop="dropDownOpened = !dropDownOpened" ref="aDropdownTrigger" color="accent-100"
            :class="cDropDownClassTarget">
      <span>{{ cSelected.label || cSelected.value || buttonText }}</span>
      <AwIcon width="12" height="9" name="arrowDown" v-if="!loading"/>
      <AwIcon width="20" height="20" name="loading" v-else/>
    </Button>
    <div v-show="dropDownOpened" v-click-outside="closeDropDown" ref="aDropdownTarget" class="a-dropdown__target customScroll">
      <button :disabled="disabled" @click="selectOption(option)" :data-value="option.value" v-for="(option, i) in cOptions" :key="i">
        {{ option.label || option.value  }}
      </button>
      <slot />
    </div>
  </div>
</template>

<script>
// TODO Доделать варианты пунктов.
import Button from "../buttons/Button";
import AwIcon from "../icons/AwIcon.vue"

export default {
  name: "dropdown",
  props: {
    selectedValue: [String, Number],
    buttonText: String,
    block: Boolean,
    position: String,
    disabled: Boolean,
    loading: Boolean,
    options: {
      type: Array
    },
    size: String
  },
  data() {
    return {
      dropDownOpened: false,
      selectedLocal: null
    }
  },
  components: {
    Button,
    AwIcon
  },
  computed: {
    cDropDownClass(){
      return {
        'a-dropdown': true,
        "block": this.block,
        "loading": this.loading,
        [this.size]: this.size,
        [this.position]: this.position,
      }
    },
    cDropDownClassTarget(){
      return {
        'a-dropdown__trigger': true,
        "active": this.dropDownOpened,
      }
    },
    cOptions() {
      return this.options || [];
    },
    cSelected: {
      get() {
        return this.cOptions.find(({value}) => value === (this.selectedValue||this.selectedLocal))||{};
      },
      set(option) {
        this.selectedLocal = option.value;
        this.$emit('update:selected-value', option.value)
        this.$emit('update:selected-object', option)
        this.$emit('selected', option.value)
      }
    }
  },
  methods: {
    closeDropDown() {
      this.dropDownOpened = false
    },
    selectOption(option) {
      this.cSelected = option;
      this.closeDropDown();
    }
  }
}
</script>

<style scoped lang="scss">
.a-dropdown {
  display: inline-flex;
  position: relative;
  &.block{
    display: flex;
  }
  &__trigger {
    display: flex;
    align-items: center;
    width: 100%;
    background: var(--a-accent-darken);
    border: 0.5px solid #454FA1;
    &[disabled]{
      background: #2A2E55;
      color: #9394A9;
    }
    span {
      margin-right: 10px;
      font-size: 16px;
      user-select: none;
    }
    &::v-deep {
      .a-svg-icons {
        margin-left: auto;
        svg{
          transition: 300ms all;
        }
      }
    }
    &.active{
      background: var(--a-accent);
      border-color: var(--a-accent);
      &::v-deep {
        .a-svg-icons {
          svg{
            transform: rotate(-180deg);
          }
        }
      }
    }
  }

  &__target {
    position: absolute;
    top: calc(100% + 4px);
    left: 0;
    right: 0;
    padding: 7px 14px;
    border-radius: 4px;
    background: var(--a-accent);
    filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));
    border: 0.5px solid #454FA1;
    z-index: 2;
    max-height: 400px;
    overflow-y: auto;
    button{
      width: 100%;
      white-space: nowrap;
      background: none;
      border: none;
      border-bottom: 0.3px solid rgba(196, 222, 242, 0.4);
      color: #ffffff;
      font-size: 14px;
      padding: 7px 0 4px;
      text-align: left;
      &:first-child{
        padding-top: 0;
      }
      &:last-child{
        border-bottom: none;
      }
    }
  }

  &.tiny{
    button{
      padding: 2px 4px;
    }
    span{
      font-size: 12px;
    }
  }
}
</style>
