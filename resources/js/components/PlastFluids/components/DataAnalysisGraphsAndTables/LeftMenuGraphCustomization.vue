<template>
  <div class="customization-category">
    <div class="category-header">
      <input
        :disabled="
          valueKey === 'temperature' || valueKey === 'density' ? true : false
        "
        type="radio"
        :id="'customization-category-' + categoryName"
        :value="valueKey"
        v-model="computedCurrentGraphicType"
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
        <input
          :class="{
            disabled:
              currentGraphics.length === 4 &&
              !computedCurrentGraphics.includes(child.key),
          }"
          type="checkbox"
          :id="'customization-' + child.key"
          :value="child.key"
          :disabled="
            valueKey !== currentGraphicType ||
            (currentGraphics.length === 4 &&
              !computedCurrentGraphics.includes(child.key))
          "
          v-model="computedCurrentGraphics"
        />
        <label
          :for="'customization-' + child.key"
          :class="{
            disabled:
              currentGraphics.length === 4 &&
              !computedCurrentGraphics.includes(child.key),
          }"
          >{{ child.Label }}</label
        >
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
    currentGraphicType: String,
    currentGraphics: Array,
  },
  computed: {
    computedCurrentGraphicType: {
      get() {
        return this.currentGraphicType;
      },
      set(value) {
        this.$emit("update:currentGraphicType", value);
      },
    },
    computedCurrentGraphics: {
      get() {
        return this.valueKey === this.currentGraphicType
          ? this.currentGraphics
          : [];
      },
      set(value) {
        this.$emit("update:currentGraphics", value);
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

.disabled {
  cursor: not-allowed;
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
