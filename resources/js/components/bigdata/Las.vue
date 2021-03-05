<template>
  <div class="table-container">
    <cat-loader v-show="isloading"/>
    <div>file<span>&nbsp;*</span>
    </div>
    <div class="container">
      <input type="file" id="file" ref="file" title="Файл" @change="handleFileUpload()">
      <input v-model="input.well" placeholder="id скважины">
      <input v-model="input.field" placeholder="id месторождения">
      <input v-model="input.comment" placeholder="комментарий">
      <input v-model="input.filename" placeholder="имя файлы">
      <button id="experimentUploadButton a" @click="submitFile()">Загрузить</button>
    </div>
    <div class="container info pt-5">
      <p v-if="experimentsId">ID измерения {{ experimentsId }}</p>
    </div>

    <div class="container pt-5">
      <input id="wellId" v-model="wellId" placeholder="id скважины как в лас файле">
      <button id="experimentInfoButton2" @click="selectExperiments()">Получить информацию обо всех экспериментах для
        этой скважины
      </button>
    </div>
    <div class="container info pt-5" v-if="selectedExperimentsInfo">
      <div v-for="experimentsInfo in selectedExperimentsInfo">
        <div>
          <p>Id {{ experimentsInfo.id }}</p>
          <button @click="getOriginalLas(experimentsInfo)">Скачать</button>
        </div>
      </div>
    </div>
    <div class="container pt-5">
      <input id="experiment" v-model="experimentId" placeholder="id эксперимента">
      <button id="experimentInfoButton" @click="fetchExperiments()">Получить информацию об эксперименте</button>
    </div>
    <div class="container info pt-5" v-if="experimentInfo">
      <p>Шаг {{ experimentInfo.step }}</p>
      <p>Начало глубины измерения {{ experimentInfo.depth_start }}</p>
      <p>Конец глубины измерения {{ experimentInfo.depth_end }}</p>
      <p>Id скважины {{ experimentInfo.well_id }}</p>
      <p>Id месторождения {{ experimentInfo.field_id }}</p>
      <p>Комментарий {{ experimentInfo.comment }}</p>
      <div v-for="experiment in experimentInfo.curves" v-if="experimentInfo">
        <p>Мнемоника {{ experiment.mnemonic }}</p>
        <p>Данные {{ experiment.curve }}</p>
      </div>
    </div>
  </div>
</template>

<script>

import {formatDate} from "../reports/FormatDate";
import download from "downloadjs";

export default {
  components: {},
  data() {
    return {
      file: '',
      isLoading: false,
      experimentId: null,
      experimentsId: null,
      wellId: null,
      input: {
        well: null,
        field: null,
        comment: null,
        filename: null,
      },
      baseUrl: 'http://172.20.103.157:8083/',
      experimentInfo: null,
      selectedExperimentsInfo: null
    }
  },
  methods: {
    handleFileUpload() {
      this.file = this.$refs.file.files[0];
    },
    submitFile() {
      let formData = new FormData();
      formData.append('file', this.file)

      this.isLoading = true;
      this.experimentsId = null;
      this.axios.post(this.baseUrl + 'upload/', formData, {
        responseType: 'json',
        params: {
          well: this.input.well,
          field: this.input.field,
          comment: this.input.comment,
          filename: this.input.filename,
        },
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }).then((response) => {
        if (response.data) {
          this.experimentsId = response.data.experiments_id
        }
      }).catch((error) => console.log(error)
      ).finally(() => this.isLoading = false);


    },
    fetchExperiments() {
      this.isLoading = true;
      this.experimentInfo = null;
      this.axios.get(
          this.baseUrl + 'experiment/' + this.experimentId
      ).then((response) => {
        if (response.data) {
          this.experimentInfo = response.data;
        }
      }).catch((error) => console.log(error)
      ).finally(() => this.isLoading = false);

    },
    getOriginalLas(experimentsInfo) {
      let content = JSON.stringify({
        experiments_id: experimentsInfo.id,
        filename: experimentsInfo.filename
      })
      this.axios.post(
          this.baseUrl + 'static/experiment_input_file/',
          content,
          {
            headers: {
              'Content-Type': 'application/json'
            }
          }
      ).then((response) => {
        if (response.data) {
          let content = response.headers['content-type']
          download(response.data, experimentsInfo.filename, content)
        }
      }).catch((error) => console.log(error)
      ).finally(() => this.isLoading = false);
    },
    selectExperiments() {
      this.isLoading = true;
      this.selectedExperimentsInfo = null;
      this.axios.get(
          this.baseUrl + 'experiments/well/' + this.wellId,
      ).then((response) => {
        if (response.data) {
          this.selectedExperimentsInfo = response.data;
        }
      }).catch((error) => console.log(error)
      ).finally(() => this.isLoading = false);
    }
  },
}
</script>

<style>
.info {
  color: white
}
</style>
