<template>
  <form
    @submit.prevent="search()"
    class="input-group search-form-input-group no-margin"
  >
    <div class="input-group-F">
      <div class="input-form-icon">
        <svg
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <mask
            id="mask0"
            mask-type="alpha"
            maskUnits="userSpaceOnUse"
            x="3"
            y="3"
            width="18"
            height="18"
          >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M15.1867 14.4716H15.9767L20.2167 18.7316C20.6267 19.1416 20.6267 19.8116 20.2167 20.2216C19.8067 20.6316 19.1367 20.6316 18.7267 20.2216L14.4767 15.9716V15.1816L14.2067 14.9016C12.8067 16.1016 10.8967 16.7216 8.8667 16.3816C6.0867 15.9116 3.8667 13.5916 3.5267 10.7916C3.0067 6.56157 6.5667 3.00157 10.7967 3.52157C13.5967 3.86157 15.9167 6.08157 16.3867 8.86157C16.7267 10.8916 16.1067 12.8016 14.9067 14.2016L15.1867 14.4716ZM5.4767 9.97157C5.4767 12.4616 7.4867 14.4716 9.9767 14.4716C12.4667 14.4716 14.4767 12.4616 14.4767 9.97157C14.4767 7.48157 12.4667 5.47157 9.9767 5.47157C7.4867 5.47157 5.4767 7.48157 5.4767 9.97157Z"
              fill="black"
            />
          </mask>
          <g mask="url(#mask0)">
            <rect width="24" height="24" fill="white" />
          </g>
        </svg>
      </div>
      <input
        type="text"
        @input="onInput($event)"
        class="form-control fix-rounded-right"
        :placeholder="placeholder || `${this.trans('tr.search_well')}`"
        v-model="searchStringModel"
      />
    </div>
    <clear-icon v-if="clear" @clear-click="clearClick()" background="#393d75" v-bind:placeholder="trans('tr.reset_search')"/>
    <button type="submit" class="input-submit-button">{{trans('tr.search')}}</button>
  </form>
</template>

<script>
import ClearIcon from "@ui-kit/ClearIcon.vue";

export default {
  components: {
    ClearIcon,
  },
  props: {
    placeholder: {
      type: String,
      required: false,
    },
    clear: {
      type: Boolean,
      required: false,
      default: false,
    },
  },
  data() {
    return {
      searchStringModel: "",
    };
  },
  methods: {
    search() {
      this.$emit("start-search");
    },
    clearClick() {
      this.searchStringModel= "";
      this.$emit("input", "");
      this.search();
    },
    onInput({ target: { value } }) {
      this.$emit("input", value);
    },
  },
};
</script>

<style scoped>
.input-form-icon {
  position: absolute;
  top: 9px;
  left: 16px;
}

.input-group-F {
  min-width: 200px;
  position: relative;
}

.input-submit-button {
  color: white !important;
  background: #3366ff !important;
  border: none !important;
  border-top-right-radius: 5px !important;
  border-bottom-right-radius: 5px !important;
  border-top-left-radius: 0 !important;
  border-bottom-left-radius: 0 !important;
  width: 120px;
  text-align: center;
}

.input-group-F input {
  color: white;
}

.input-group-F input:focus {
  color: white !important;
}

.search-form-input-group {
  display: flex;
  flex-wrap: nowrap;
}

.form-control {
  border-top-right-radius: 0 !important;
  border-bottom-right-radius: 0 !important;
}

.form-control,
.fix-rounded-right {
  border-top-left-radius: 5px !important;
  border-bottom-left-radius: 5px !important;
  height: 40px !important;
  background: #393d75 !important;
  border: none !important;
  font-size: 18px !important;
  padding-left: 55px;
}
</style>