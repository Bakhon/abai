<template>
  <div class="upload_wrapper">
    <div class="file_upload">
      <div class="file_upload_title">
        {{ trans("plast_fluids.download_file") }}
        <Dropdown
          style="margin-top: 10px;"
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
          <div class="upload_border"></div>
          <button class="btn-common upload_file">
            {{ trans("plast_fluids.download_package") }}
          </button>
          <button class="btn-common exchange_file">
            {{ trans("plast_fluids.replace_package") }}
          </button>
        </div>
      </div>
    </div>
    <div class="upload_status">
      <div class="upload_status_title">
        {{ trans("plast_fluids.download_log") }}
      </div>
      <div class="log_status"></div>
      <button class="btn-common download_log">
        Скачать лог загрузки
      </button>
    </div>
  </div>
</template>

<script>
import Dropdown from "../../geology/components/dropdowns/dropdown";

export default {
  name: "MonitoringFileUploadBlock",
  components: {
    Dropdown,
  },
};
</script>

<style>
.file_upload {
  background-color: #363b68;
  width: 445px;
  height: 333px;
}

.upload_status {
  background-color: #363b68;
  margin-top: 15px;
  width: 445px;
  height: 491px;
}

.file_upload_title {
  font-size: 20px;
  font-style: normal;
  font-weight: 700;
  line-height: 24px;
  letter-spacing: 0em;
  text-align: left;
  color: aliceblue;
  margin-left: 17px;
  margin-top: 25px;
}

.upload_status_title {
  font-size: 20px;
  font-style: normal;
  font-weight: 700;
  line-height: 24px;
  letter-spacing: 0em;
  text-align: left;
  color: aliceblue;
  margin-left: 17px;
  margin-top: 25px;
}

.file_service {
  margin-top: 11px;
  width: 422px;
  height: 260px;
  background-color: #272953;
}

.upload_border {
  width: 100%;
  height: 100%;
  border: 1px dashed;
  border-radius: 10px;
}

.log_status {
  margin-top: 11px;
  margin-left: 12px;
  width: 421px;
  height: 367px;
  background-color: #272953;
}

.btn-common {
  height: 32px;
  background-color: #3366ff;
  font-size: 14px;
  font-style: normal;
  font-weight: 600;
  line-height: 24px;
  letter-spacing: 0em;
  text-align: center;
  color: aliceblue;
  border-radius: 4px;
}
.upload_file {
  width: 132px;
  margin-top: 218px;
  margin-left: 74px;
}

.exchange_file {
  width: 132px;
  margin-top: 218px;
  margin-right: 74px;
}

.download_log {
  width: 183px;
  margin-top: 12px;
  margin-left: 131px;
}
</style>
