<template>
  <div
    class="clear-button"
    @click="clearClick"
    :title="placeholder"
    v-bind:style="{ backgroundColor: background }"
  >
    <svg
      version="1.1"
      width="35"
      height="35"
      viewBox="0 0 24 24"
      xmlns="http://www.w3.org/2000/svg"
    >
      <line x1="7" y1="17" x2="17" y2="7" stroke="white" stroke-width="1" />
      <line x1="7" y1="7" x2="17" y2="17" stroke="white" stroke-width="1" />
    </svg>
  </div>
</template>

<script>
export default {
  props: {
    background: {
      type: String,
      default: "#393d75",
    },
    placeholder: {
      type: String,
      default: "Сброс",
    },
  },
  methods: {
    clearClick() {
      this.$emit("clear-click");
    },
  },
};
</script>

<style scoped>
.clear-button {
  display: flex;
  align-items: center;
  align-self: flex-end;
  width: 35px;
  cursor: pointer;
  justify-content: center;
}
</style>
