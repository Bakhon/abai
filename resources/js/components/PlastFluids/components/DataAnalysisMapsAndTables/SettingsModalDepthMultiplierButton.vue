<template>
  <button
    :disabled="disable"
    :class="{ disabled: disable }"
    @click="$emit('update-multiplier', accumulator)"
  >
    {{ content }}
  </button>
</template>

<script>
export default {
  name: "SettingsModalDepthMultiplierButton",
  props: {
    content: String,
    disable: Boolean,
    accumulator: Number,
  },
};
</script>

<style scoped>
button {
  background: none;
  font-size: 10px;
  color: #fff;
  position: absolute;
  width: 16px;
  height: 14px;
  display: flex;
  justify-content: center;
  align-items: center;
  border: 0.8px solid gray;
}

.disabled {
  cursor: not-allowed;
}
</style>
