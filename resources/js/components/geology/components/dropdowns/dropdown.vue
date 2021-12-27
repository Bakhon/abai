<template>
  <div :class="cDropDownClass">
    <AwInput v-model="searchText" v-if="search&dropDownOpened" :disabled="disabled" ref="aDropdownSearchInput" color="accent-100"
            :class="cDropDownClassTarget" />

    <Button v-else :disabled="disabled" @click.native.stop="dropDownOpened = !dropDownOpened" ref="aDropdownTrigger" color="accent-100"
            :class="cDropDownClassTarget">
      <span v-if="multiple">{{ cSelected || buttonText }}</span>
      <span v-else>{{ cSelected.label || cSelected.value || buttonText }}</span>
      <AwIcon width="12" height="9" name="arrowDown" v-if="!loading"/>
      <AwIcon width="20" height="20" name="loading" v-else/>
    </Button>

    <div v-if="multiple" v-show="dropDownOpened" v-click-outside="closeDropDown" ref="aDropdownTarget" class="a-dropdown__target customScroll">
      <label v-for="(option, i) in cOptions" :key="i">
        <input :checked="~isMultipleSelected(option)" type="checkbox" @change="selectOption(option, $event)"/>
        <span>{{ option.label || option.value  }}</span>
      </label>
      <slot />
    </div>

    <div v-else v-show="dropDownOpened" v-click-outside="closeDropDown" ref="aDropdownTarget" class="a-dropdown__target customScroll">
      <button v-bind="$attrs" :disabled="disabled" @click="selectOption(option, $event)" :data-value="option.value" v-for="(option, i) in cOptions" :key="i">
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
import AwInput from "../form/AwInput";

export default {
  name: "dropdown",
  props: {
    selectedValue: [String, Number, Array, Object],
    buttonText: String,
    block: Boolean,
    position: String,
    disabled: Boolean,
    loading: Boolean,
    multiple: Boolean,
    search: Boolean,
    options: {
      type: Array
    },
    size: String
  },
  data() {
    return {
      dropDownOpened: false,
      selectedLocal: null,
      searchText: ""
    }
  },
  components: {
    AwInput,
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
      return (this.options || []).filter(({label, value})=>(label||value).toLowerCase().match(new RegExp(this.searchText.toLowerCase(), 'mug')));
    },
    cSelected: {
      get() {
        if(this.multiple){
          return (this.selectedValue??this.selectedLocal).reduce((acc, opt)=>{
            acc += (opt.label||opt.value||opt)+', ';
            return acc
          }, "").trim().replace(/,\s*$/, "");
        }
        return this.cOptions.find(({value}) => value === (this.selectedValue??this.selectedLocal))||{};
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
    closeDropDown(e) {
      let input = this.$refs.aDropdownSearchInput&&this.$refs.aDropdownSearchInput.$el.querySelector('input');
      if(e&&![input].includes(e.target))
        this.dropDownOpened = false
    },

    isMultipleSelected(option){
      if(typeof this.selectedValue === "object"){
        return this.selectedValue.findIndex((opt)=>(opt.value||opt.label||opt) === (option.value||option.label||option));
      }
      return false;
    },

    selectOption(option, e) {
      if(this.multiple && typeof this.selectedValue === "object"){
        let a = JSON.parse(JSON.stringify(this.selectedValue));
        let index = a.findIndex((opt)=>(opt.value||opt.label||opt) === (option.value||option.label||option));
        if(~index) a.splice(index, 1);
        else a.push(option);
        this.$emit('change', a, e, option)
        this.$emit('update:selected-value', a, e, option)
        this.selectedLocal = a;
      }else{
        if(this.cSelected.value !== option.value) this.$emit('change', option.value, e, option)
        this.cSelected = option;
        this.closeDropDown(e);
      }
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
      overflow: hidden;
      white-space: nowrap;
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
    label{
      margin-bottom: 0;
    }
    button, label{
      width: 100%;
      white-space: nowrap;
      background: none;
      border: none;
      border-bottom: 0.3px solid rgba(196, 222, 242, 0.4);
      color: #ffffff;
      font-size: 14px;
      padding: 7px 0 4px;
      text-align: left;
      cursor: pointer;
      user-select: none;
      &:first-child{
        padding-top: 0;
      }
      &:last-child{
        border-bottom: none;
      }
      input[type=checkbox]{
        padding-top: 20px;
        vertical-align: middle;
        height: 15px;
        margin-right: 5px;
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
