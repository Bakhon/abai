<template>
  <div class="table-container">
    <cat-loader v-show="isloading"/>
    <div>file<span>&nbsp;*</span>
    </div>
    <div class="container">
      <input type="file" id="file" ref="file" title="Файл" @change="handleFileUpload()">
      <button id="experimentUploadButton a" @click="submitFile()">Загрузить</button>
    </div>
    <div class="container info pt-5">
      <p v-if="experimentsId">ID измерения {{ experimentsId }}</p>
    </div>
    <div class="container pt-5">
      <input id="experiment" v-model="experimentId" placeholder="id эксперимента">
      <button id="experimentInfoButton" @click="fetchExperiments()">Получить информацию об эксперименте</button>
    </div>
    <div class="container info pt-5" v-if="experimentInfo">
      <p>Шаг {{ experimentInfo.step }}</p>
      <p>Начало глубины измерения {{ experimentInfo.depth_start }}</p>
      <p>Конец глубины измерения {{ experimentInfo.depth_end }}</p>
      <div v-for="experiment in experimentInfo.curves" v-if="experimentInfo">
        <p>Мнемоника {{ experiment.mnemonic }}</p>
        <p>Данные {{ experiment.curve }}</p>
      </div>
    </div>
  </div>
</template>

<script>

import {formatDate} from "../reports/FormatDate";

export default {
  components: {},
  data() {
    return {
      file: '',
      isLoading: false,
      experimentId: null,
      experimentsId: null,
      baseUrl: 'http://172.20.103.157:8083/',
      experimentInfo: null
    }
  },
  methods: {
    handleFileUpload() {
      this.file = this.$refs.file.files[0];
    },
    submitFile() {
      let formData = new FormData();
      formData.append('file', this.file);

      this.isLoading = true;
      this.experimentsId = null;

      this.axios.post(this.baseUrl + 'upload/', formData, {
        responseType: 'json',
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

    }
  }
}
</script>

<style>
.info {
  color: white
}
</style>
