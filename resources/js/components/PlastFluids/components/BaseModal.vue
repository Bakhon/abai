<template>
  <div ref="modal" class="base-modal" @click="closeModal">
    <div>
      <p>{{ heading }}</p>
      <div class="input-holder" v-if="type === 'edit'">
        <label :for="heading + 'edit-input'">{{ inputLabel }}</label>
        <input
          type="text"
          :id="heading + 'edit-input'"
          v-model="inputText"
          :class="{ error: isEmpty }"
        />
      </div>
      <div class="action-buttons">
        <button
          v-if="type === 'delete'"
          @click="handleDelete"
          class="delete-button"
        >
          {{ trans("plast_fluids.delete") }}
        </button>
        <button v-else class="save-button" @click="handleSave">
          {{ trans(`plast_fluids.${type === "notify" ? "ok" : "save"}`) }}
        </button>
        <button
          v-if="type !== 'notify'"
          class="cancel-button"
          @click="$emit('close-modal')"
        >
          {{ trans("plast_fluids.cancel") }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "BaseModal",
  data() {
    return {
      isEmpty: false,
    };
  },
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
      e.stopPropagation();
      if (e.target.innerHTML === this.$refs.modal.innerHTML) {
        this.$emit("close-modal");
      }
    },
    handleSave(e) {
      if (this.inputText) {
        e.stopPropagation();
        this.$emit("modal-response");
        this.$emit("close-modal");
      } else {
        this.isEmpty = true;
      }
      if (this.type === "notify") {
        e.stopPropagation();
        this.$emit("modal-response");
        this.$emit("close-modal");
      }
    },
    handleDelete(e) {
      e.stopPropagation();
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
  display: flex;
  flex-flow: column;
  align-items: center;
  min-width: 520px;
  padding: 20px;
  background-color: #272953;
}

.base-modal > div > p {
  margin: 0 0 10px 0;
  font-weight: 700;
  font-size: 20px;
  text-align: center;
  color: #fff;
}

.input-holder {
  display: flex;
  align-items: center;
  padding: 14px 10px;
  background-color: #2b2e5e;
  width: 330px;
}

.input-holder > label {
  margin: 0 10px 0 0;
  font-size: 16px;
}

.input-holder > input {
  width: 100%;
  font-size: 14px;
  padding: 3px;
  border: 1px solid #fff;
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

.error {
  border: 1px solid red !important;
}
</style>
