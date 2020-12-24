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
          <path
            fill-rule="evenodd"
            clip-rule="evenodd"
            d="M9.48121 0C12.1145 0 14.3541 0.921826 16.1968 2.76547C18.0405 4.60814 18.9623 6.84756 18.9623 9.48078C18.9623 11.3244 18.4688 13.0032 17.4818 14.5182L24 21.0361L21.036 24L14.5178 17.4811C12.9376 18.4681 11.2588 18.9625 9.48121 18.9625C6.8469 18.9625 4.60936 18.0407 2.76563 16.1971C0.920925 14.3534 0 12.115 0 9.48078C0 6.84756 0.920925 4.60814 2.76563 2.76547C4.60936 0.921826 6.8469 0 9.48121 0ZM9.48121 4.24691C8.03229 4.24691 6.79752 4.75717 5.77696 5.77769C4.7564 6.79821 4.24614 8.0329 4.24614 9.48078C4.24614 10.9296 4.7564 12.1633 5.77696 13.1839C6.79752 14.2054 8.03229 14.7156 9.48121 14.7156C10.9291 14.7156 12.1638 14.2054 13.1844 13.1839C14.206 12.1633 14.7152 10.9296 14.7152 9.48078C14.7152 8.0329 14.206 6.79821 13.1844 5.77769C12.1638 4.75717 10.9291 4.24691 9.48121 4.24691Z"
            fill="#9EA4C9"
          />
        </svg>
      </div>
      <input
        type="text"
        @input="onInput($event)"
        class="form-control fix-rounded-right"
        :placeholder="placeholder || 'Поиск скважины'"
        v-model="searchStringModel"
      />
    </div>

    <button type="submit" class="input-submit-button">Поиск</button>
  </form>
</template>

<script>
export default {
  props: {
    placeholder: {
      type: String,
      required: false,
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
  width: calc(100% - 120px);
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