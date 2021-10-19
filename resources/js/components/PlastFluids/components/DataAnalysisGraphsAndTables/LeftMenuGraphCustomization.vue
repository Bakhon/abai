<template>
  <div class="customization-category">
    <div class="category-header">
      <input
        :disabled="valueKey === 'temperature' ? true : false"
        type="radio"
        :id="'customization-category-' + categoryName"
        :value="valueKey"
        v-model="computedCurrentGraphic"
      />
      <label :for="'customization-category-' + categoryName">{{
        trans("plast_fluids." + categoryName)
      }}</label>
    </div>
    <div class="category-content">
      <div
        class="category-content-child"
        v-for="(child, index) in children"
        :key="index"
      >
        <input type="checkbox" :id="'customization-' + child" :value="child" />
        <label :for="'customization-' + child">{{ child }}</label>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "LeftMenuGraphCustomization",
  props: {
    valueKey: String,
    categoryName: String,
    children: Array,
    currentGraphic: String,
  },
  computed: {
    computedCurrentGraphic: {
      get() {
        return this.currentGraphic;
      },
      set(value) {
        this.$emit("update:currentGraphic", value);
      },
    },
  },
};
</script>

<style scoped>
label {
  font-size: 14px;
  color: #fff;
  margin: 0;
}

input {
  margin-right: 10px;
}

.customization-category {
  width: calc(50% - 2px);
  background: #363b68;
  border: 1px solid #545580;
}

.category-header {
  display: flex;
  align-items: center;
  padding: 8px 10px;
  border-bottom: 1px solid #545580;
  width: 100%;
}

.category-content {
  padding: 8px 10px;
  width: 100%;
}

.category-content-child {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
  width: 100%;
}

::-webkit-scrollbar {
  height: 4px;
  width: 4px;
}

::-webkit-scrollbar-track {
  background: #272953;
}

::-webkit-scrollbar-thumb {
  background: #656a8a;
}
</style>
