<template>
  <div class="modal">
    <div class="content" v-click-outside="emitClose">
      <div class="content-header">
        <p>{{ trans("plast_fluids.template_create") }}</p>
        <button @click="emitClose">
          {{ trans("plast_fluids.close") }}
        </button>
      </div>
      <div></div>
      <div class="content-footer">
        <button>
          <img src="/img/PlastFluids/add.svg" alt="create template" />{{
            trans("plast_fluids.create_template")
          }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "BaseModal",
  methods: {
    emitClose() {
      this.$emit("close-modal");
    },
  },
};
</script>

<style scoped>
button {
  font-size: 14px;
  border: none;
}

.modal {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7));
}

.content {
  display: flex;
  flex-flow: column;
  justify-content: space-between;
  max-height: 650px;
  min-width: 430px;
  padding: 20px;
  color: #fff;
}

.content-header {
  display: flex;
  justify-content: space-between;
  width: 100%;
}

.content-header > p {
  margin: 0;
  font-size: 16px;
}

.content-header > button {
  border-radius: 8px;
  padding: 5px 15px;
}

.content-footer {
  width: 100%;
  display: flex;
  justify-content: flex-start;
}

.content-footer > button {
  padding: 8px 14px;
  border-radius: 4px;
}
</style>
