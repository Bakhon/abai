<template>
  <div class="modal">
    <div
      class="content"
      :style="{ width: mainContentWidth }"
      v-click-outside="emitClose"
    >
      <div class="content-header">
        <p>{{ trans("plast_fluids.template_create") }}</p>
        <button @click="emitClose">
          {{ trans("plast_fluids.close") }}
        </button>
      </div>
      <div class="content-main">
        <div class="content-main-header">
          <p>{{ trans("plast_fluids.ready_templates") }}: {{ templateName }}</p>
        </div>
        <div class="content-main-body">
          <div
            :style="{ width: fieldWidth }"
            v-for="(field, index) in fields"
            :key="index"
          >
            <input
              type="checkbox"
              :value="field"
              v-model="checkedFields"
              :id="index + 'pf-upload-' + field"
            /><label :for="index + 'pf-upload-' + field">{{ field }}</label>
          </div>
        </div>
      </div>
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
  name: "MonitoringDownloadTableModal",
  props: {
    templateName: String,
    fields: Array,
  },
  computed: {
    multiplier() {
      const fValue = this.fields.length / 14;
      return Number(Math.ceil(fValue));
    },
    mainContentWidth() {
      const width = this.fields.length <= 14 ? 440 : 200 * this.multiplier + 40;
      return width + "px";
    },
    fieldWidth() {
      const width = this.fields.length <= 14 ? 400 : 200;
      return width + "px";
    },
  },
  data() {
    return {
      checkedFields: [],
    };
  },
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
  color: #fff;
}

.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
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
  padding: 20px;
  color: #fff;
  background-color: #272953;
  border-radius: 4px;
}

.content-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
}

.content-header > p {
  margin: 0;
  font-size: 16px;
  font-weight: 700;
}

.content-header > button {
  border-radius: 8px;
  padding: 5px 15px;
  background-color: #656a8a;
  font-weight: 700;
}

.content-main {
  margin: 16px 0 20px 0;
  width: 100%;
}

.content-main-header {
  display: flex;
  align-items: center;
  width: 100%;
  height: 40px;
  background-color: rgba(46, 80, 233, 0.35);
  border: 1px solid #545580;
}

.content-main-header > p {
  font-size: 16px;
  margin: 0;
  margin: 12px 10px;
}

.content-main-body {
  width: 100%;
  max-height: 448px;
  display: flex;
  flex-flow: column;
  flex-wrap: wrap;
}

.content-main-body > div {
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  padding: 8px 10px 5px 10px;
  border: 1px solid #545580;
}

.content-main-body > div > label {
  font-size: 16px;
  margin: 0 0 0 8px;
  width: 100%;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.content-main-body > div:nth-child(even) {
  background-color: #2b2e5e;
}

.content-main-body > div:nth-child(odd) {
  background-color: #343868;
}

.content-footer {
  width: 100%;
  display: flex;
  justify-content: center;
}

.content-footer > button {
  display: flex;
  align-items: center;
  padding: 8px 14px;
  border-radius: 4px;
  font-weight: 700;
  background-color: #656A8A;
}

.content-footer > button > img {
  margin-right: 13px;
}
</style>
