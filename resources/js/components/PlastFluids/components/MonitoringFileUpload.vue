<template>
  <div class="file-upload">
    <p>{{ trans("plast_fluids.download_file") }}</p>
    <div class="file-input-block">
      <Dropdown
        style="padding: 10px; margin: 0;"
        block
        class="w-100 mb-2"
        button-text="Выбрать формат загрузки"
        :options="[
          { label: 'option 1', value: 1 },
          { label: 'option 2', value: 2 },
          { label: 'option 3', value: 3 },
        ]"
      />
      <div class="file_service">
        <input
          type="file"
          name="excel files"
          @change="handleFileChange($event.target.files[0])"
          :accept="formats"
        />
        <div v-if="state === 'initial'">
          <div class="file-service-text">
            <img src="/img/PlastFluids/file.svg" alt="upload file" />
            <p>
              Выберите файл
            </p>
          </div>
          <p>
            или<br />
            перетащите сюда файл
          </p>
        </div>
        <div v-if="state === 'file chosen'">
          <p class="file-name">{{ file.name }}</p>
        </div>
        <div v-if="state === 'uploading'">
          Загружаем файл...
        </div>
      </div>
      <div class="buttons-holder">
        <button @click="handleFileUpload">
          {{ trans("plast_fluids.download_package") }}
        </button>
        <input
          id="change-file-button"
          type="file"
          style="display: none;"
          @change="handleFileChange($event.target.files[0])"
        />
        <label for="change-file-button">{{
          trans("plast_fluids.replace_package")
        }}</label>
      </div>
    </div>
  </div>
</template>

<script>
import { uploadTemplate } from "../services/templateService";
import Dropdown from "../../geology/components/dropdowns/dropdown";
import { mapMutations } from "vuex";

export default {
  name: "MonitoringFileUpload",
  components: {
    Dropdown,
  },
  inject: ["name"],
  data() {
    return {
      formats: ["xls", "xlsx"],
      file: null,
      state: "initial",
    };
  },
  methods: {
    ...mapMutations("plastFluidsLocal", [
      "SET_FILE_LOG",
      "SET_REPORT_DUPLICATED_STATUS",
    ]),
    async handleFileUpload() {
      const PostData = new FormData();
      PostData.append("user", this.name);
      PostData.append("file", this.file);
      const log = await uploadTemplate(PostData);
      const {
        Template,
        "report is duplicated": duplicated,
        status,
        ...rest
      } = log;
      this.SET_FILE_LOG(rest);
      this.SET_REPORT_DUPLICATED_STATUS(duplicated === "True" ? true : false);
    },
    handleFileChange(file) {
      this.file = file;
      this.state = "file chosen";
    },
  },
};
</script>

<style scoped>
.file-upload {
  background-color: #272953;
  width: 100%;
  height: 373px;
  padding: 0 11px;
  margin-bottom: 10px;
}

.file-upload > p {
  margin: 20px 0 16px 4px;
  font-size: 20px;
  font-weight: 700;
  line-height: 24px;
  color: #fff;
}

.file-input-block {
  margin-bottom: 13px;
  border-radius: 4px;
  background: rgba(49, 53, 96, 0.6);
  border: 1px solid #454d7d;
  display: flex;
  flex-flow: column;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  max-height: 300px;
  padding: 0 10px;
}

.file_service {
  position: relative;
  display: flex;
  justify-content: center;
  border-radius: 4px;
  border: 1px dashed #e2e6ea;
  width: 100%;
  height: 190px;
  margin-bottom: 14px;
}

.file_service > input {
  z-index: 10;
  opacity: 0;
  width: 100%;
  height: 100%;
  position: absolute;
  cursor: pointer;
}

.file_service > div {
  display: flex;
  flex-flow: column;
  justify-content: center;
  align-items: center;
  font-size: 14px;
  color: #fff;
}

.file_service > div > p {
  opacity: 0.5;
  margin: 0;
  text-align: center;
}

.file-service-text {
  display: flex;
  margin-bottom: 5px;
}

.file-service-text > p {
  margin: 0;
  margin-left: 8px;
}

.file-name {
  color: #fff;
  font-size: 14px;
}

.buttons-holder {
  display: flex;
  align-items: center;
  justify-content: space-around;
  margin-bottom: 14px;
}

.buttons-holder > button,
label {
  background: #3366ff;
  font-size: 14px;
  color: #fff;
  line-height: 24px;
  text-align: center;
  padding: 10px 14px 8px 14px;
  border-radius: 4px;
  border: none;
}

.buttons-holder > button {
  margin-right: 5px;
}

.buttons-holder > label {
  margin-left: 5px;
  margin-bottom: 0;
  cursor: pointer;
}

.exchange_file {
  width: 132px;
  margin-top: 218px;
  margin-right: 74px;
}
</style>
