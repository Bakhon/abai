<template>
  <div class="file-upload">
    <p>{{ trans("plast_fluids.download_file") }}</p>
    <div class="file-input-block">
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
              {{ trans("plast_fluids.select_file") }}
            </p>
          </div>
          <p>
            {{ trans("plast_fluids.or") }}<br />
            {{ trans("plast_fluids.move_file") }}
          </p>
        </div>
        <div v-if="state === 'file chosen'">
          <p class="file-name">{{ file.name }}</p>
        </div>
        <SmallCatLoader
          v-if="state === 'uploading'"
          :loading="state === 'uploading'"
        />
        <div class="error" v-if="state === 'error'">
          {{ error }}
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
import SmallCatLoader from "./SmallCatLoader.vue";
import { uploadTemplate } from "../services/templateService";
import { mapActions, mapMutations } from "vuex";

export default {
  name: "MonitoringFileUpload",
  inject: ["name", "id"],
  components: {
    SmallCatLoader,
  },
  data() {
    return {
      formats: [".xls", ".xlsx", ".xlsm"],
      file: null,
      state: "initial",
      error: "",
    };
  },
  methods: {
    ...mapMutations("plastFluidsLocal", [
      "SET_FILE_LOG",
      "SET_REPORT_DUPLICATED_STATUS",
      "SET_DOWNLOAD_FILE_DATA",
    ]),
    ...mapActions("plastFluids", ["UPDATE_CURRENT_SUBSOIL_FIELD"]),
    ...mapActions("plastFluidsLocal", ["HANDLE_FILE_LOG"]),
    async handleFileUpload() {
      this.state = "uploading";
      const PostData = new FormData();
      PostData.append("user", this.name);
      PostData.append("user_id", this.id);
      PostData.append("file", this.file);
      try {
        const log = await uploadTemplate(PostData);
        const { template, status, description, user, sheets, ...rest } = log;
        sheets ? this.HANDLE_FILE_LOG(sheets) : "";
        this.SET_DOWNLOAD_FILE_DATA({
          template,
          status,
          user,
          description,
        });
        this.state = "file chosen";
        if (status === "ok") this.UPDATE_CURRENT_SUBSOIL_FIELD("resetField");
      } catch (error) {
        this.state = "error";
        this.error =
          error.response?.data["error text"] ??
          this.trans("plast_fluids.something_went_wrong");
        this.SET_FILE_LOG(null);
      }
    },
    handleFileChange(file) {
      const splitFileName = file.name.split(".");
      if (splitFileName[splitFileName.length - 1].includes("xls")) {
        this.file = file;
        this.state = "file chosen";
        return;
      }
      this.state = "error";
      this.error = this.trans("plast_fluids.incorrect_file_format");
    },
  },
};
</script>

<style lang="scss" scoped src="./MonitoringFileUploadStyles.scss"></style>
