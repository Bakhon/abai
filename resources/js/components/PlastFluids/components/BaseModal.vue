<template>
  <div ref="modal" class="base-modal" @click="closeModal">
    <div>
      <p>{{ heading }}</p>
      <div class="input-holder" v-if="type === 'edit'">
        <label for="">{{ inputLabel }}</label>
        <input type="text" id="" v-model="inputText" />
      </div>
      <div class="action-buttons">
        <button
          :class="type === 'delete' ? 'delete-button' : 'save-button'"
          @click="save"
        >
          {{ trans(`plast_fluids.${type === "delete" ? "delete" : "save"}`) }}
        </button>
        <button class="cancel-button" @click="$emit('close-modal')">
          Отмена
        </button>
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
    type: String,
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
  methods: {
    closeModal(e) {
      if (e.target.innerHTML === this.$refs.modal.innerHTML) {
        this.$emit("close-modal");
      }
    },
    save() {
      this.$emit("modal-response");
      this.$emit("close-modal");
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
  z-index: 1000;
  display: flex;
  justify-content: center;
  align-items: center;
  background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7));
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
  text-align: center;
}

.input-holder {
  padding: 14px 10px;
  background-color: #2b2e5e;
}

.action-buttons {
  display: flex;
  width: 100%;
  justify-content: center;
}

.delete-button {
  margin-right: 5px;
  background-color: red;
}

.save-button {
  margin-right: 5px;
  background-color: #3366ff;
}

.cancel-button {
  margin-left: 5px;
  background-color: #40467e;
}
</style>
