<template>
  <div class="base-modal">
    <div>
      <p>{{ heading }}</p>
      <div class="input-holder">
        <label for="">{{ inputLabel }}</label>
        <input type="text" id="" v-model="inputText" />
      </div>
      <div class="action-buttons">
        <button class="save-button">Сохранить</button>
        <button class="cancel-button">Отмена</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "BaseModal",
  props: {
    heading: String,
    inputLabel: String,
    inputValue: String,
  },
  computed: {
    inputText: {
      get() {
        return this.inputValue;
      },
      set(value) {
        this.$emit("update:inputValue", value);
      },
    },
  },
};
</script>

<style scoped>
button {
  color: #fefefe;
  border: none;
  font-size: 18px;
  width: 160px;
  height: 44px;
}

.base-modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

.base-modal > div {
  min-width: 520px;
  padding: 20px;
  background-color: #272953;
}

.base-modal > div > p {
  margin: 0 0 10px 0;
  font-weight: 700;
  font-size: 20px;
}

.input-holder {
  padding: 14px 10px;
  background-color: #2B2E5E;
}

.action-buttons {
  display: flex;
  width: 100%;
  justify-content: center;
}

.action-buttons:first-child {
  margin-right: 5px;
  background-color: #3366ff;
}

.action-buttons:last-child {
  margin-left: 5px;
  background-color: #40467e;
}
</style>
