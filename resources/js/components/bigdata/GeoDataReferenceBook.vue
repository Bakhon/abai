<template>
  <div class="container container-main">
    <cat-loader/>
    <template v-for="referenceBook in referenceBooks">
      <div class="row">
        <label class="section-text">Добавить данные в справочник: {{ referenceBook.description }}</label>
      </div>
      <form @submit.prevent="sendMessage">
        <div class="row">
          <input class="col form-control filter-input mr-2 mb-2" v-model="input[referenceBook.input]['value']"
                 placeholder="значение" required>
        </div>
        <div class="row">
          <input class="col form-control filter-input mr-2 mb-2" v-model="input[referenceBook.input]['ru']"
                 placeholder="RU:">
        </div>
        <div class="row">
          <input class="col form-control filter-input mr-2 mb-2" v-model="input[referenceBook.input]['kz']"
                 placeholder="KZ:">
        </div>
        <div class="row">
          <input class="col form-control filter-input mr-2 mb-2" v-model="input[referenceBook.input]['en']"
                 placeholder="EN:">
        </div>
        <div class="row">
          <button class="col btn get-report-button" @click="update(referenceBook)">
            Добавить
          </button>
        </div>
      </form>
      <div class="row" v-if="isUpdated[referenceBook.input]">
        <label class="label-text mt-2">Значение добавлено</label>
      </div>
      <div class="row mb-5"></div>
    </template>
  </div>

</template>

<script>

export default {
  components: {},
  data() {
    return {
      // baseUrl: 'http://172.20.103.187:8084/',
      baseUrl: 'http://127.0.0.1:8091/',
      referenceBooks: [
        {
          description: 'Расширение',
          referenceBook: 'extension',
          input: 'extension',
        },
        {
          description: 'Наименование ствола',
          referenceBook: 'stem_type',
          input: 'stemType',
        },
        {
          description: 'Секция ствола',
          referenceBook: 'stem_section',
          input: 'stemSection',
        },
        {
          description: 'Наименование технологии записи',
          referenceBook: 'recording_method',
          input: 'recordingMethod',
        },
        {
          description: 'Статус обработки',
          referenceBook: 'file_status',
          input: 'fileStatus',
        },
        {
          description: 'Запись',
          referenceBook: 'recording_state',
          input: 'recordingState',
        }
      ],
      input: {
        extension: {
          value: '',
          ru: '',
          kz: '',
          en: ''
        },
        stemType: {
          value: '',
          ru: '',
          kz: '',
          en: ''
        },
        stemSection: {
          value: '',
          ru: '',
          kz: '',
          en: ''
        },
        recordingMethod: {
          value: '',
          ru: '',
          kz: '',
          en: ''
        },
        fileStatus: {
          value: '',
          ru: '',
          kz: '',
          en: ''
        },
        recordingState: {
          value: '',
          ru: '',
          kz: '',
          en: ''
        },
      },
      isUpdated: {
        extension: false,
        stemType: false,
        stemSection: false,
        recordingMethod: false,
        fileStatus: false,
        recordingState: false,
      },
    }
  },
  mounted: function () {
    this.$nextTick(function () {
      this.$store.commit('globalloading/SET_LOADING', false)
    });
  },
  methods: {
    update(referenceBook) {

      this.$store.commit('globalloading/SET_LOADING', true)
      let referenceName = referenceBook.input
      this.isUpdated[referenceName] = false
      let jsonData = JSON.stringify({
        reference_book: referenceBook.referenceBook,
        value: this.input[referenceName]['value'],
        ru: this.input[referenceName]['ru'],
        kz: this.input[referenceName]['kz'],
        en: this.input[referenceName]['en']
      });
      this.axios.post(this.baseUrl + 'update-reference-book/', jsonData, {
        responseType: 'json',
        headers: {
          'Content-Type': 'application/json'
        }
      }).then((response) => {
        if (response.data) {
          this.isUpdated[referenceName] = true;
        }
      }).catch((error) => console.log(error)
      ).finally(() => this.$store.commit('globalloading/SET_LOADING', false));
    }
  }
}


</script>

<style scoped>

.label-text {
  font-size: 20px;
}

</style>
