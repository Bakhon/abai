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
          <button class="col btn get-report-button" @click="saveReferenceBook(referenceBook)">
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

import referenceBooksJson from './reference_books.json';
export default {
  components: {},
  data() {
    return {
      baseUrl: 'http://172.20.103.187:8084/',
      referenceBooks: referenceBooksJson['referenceBooks'],
      input: referenceBooksJson['input'],
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
    saveReferenceBook(referenceBook) {

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
