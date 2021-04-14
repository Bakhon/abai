<template>
  <div class="container container-main">
    <cat-loader/>
    <template v-for="(description, referenceBook) in referenceBooks">
      <div class="row">
        <label class="section-text">Добавить данные в справочник: {{ description }}</label>
      </div>
      <div class="row">
        <input class="col form-control filter-input mr-2 mb-2" v-model="input[referenceBook]['value']" placeholder="значение">
      </div>
      <div class="row">
        <input class="col form-control filter-input mr-2 mb-2" v-model="input[referenceBook]['ru']" placeholder="RU:">
      </div>
      <div class="row">
        <input class="col form-control filter-input mr-2 mb-2" v-model="input[referenceBook]['en']" placeholder="EN:">
      </div>
      <div class="row">
        <button class="col btn get-report-button" @click="update(referenceBook)">
          Добавить
        </button>
      </div>
      <div class="row" v-if="isUpdated[referenceBook]">
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
      baseUrl: 'http://172.20.103.187:8084/',
      referenceBooks: {
        extensions: 'Расширение',
        stemTypes: 'Наименование ствола',
        stemSections: 'Секция ствола',
        recordingMethods: 'Наименование технологии записи',
        fileStatuses: 'Статус обработки',
        recordingStates: 'Запись',
      },
      input: {
        extensions: {
          value: '',
          ru: '',
          en: ''
        },
        stemTypes: {
          value: '',
          ru: '',
          en: ''
        },
        stemSections: {
          value: '',
          ru: '',
          en: ''
        },
        recordingMethods: {
          value: '',
          ru: '',
          en: ''
        },
        fileStatuses: {
          value: '',
          ru: '',
          en: ''
        },
        recordingStates: {
          value: '',
          ru: '',
          en: ''
        },
      },
      isUpdated: {
        extensions: false,
        stemTypes: false,
        stemSections: false,
        recordingMethods: false,
        fileStatuses: false,
        recordingStates: false,
      },


    }
  },
  mounted: function () {
  },
  methods: {
    update(referenceBook) {
      this.isUpdated[referenceBook] = true;
    }
  }
}


</script>

<style scoped>
.info {
  color: white
}

.section-text {
  font-size: 30px;
}

.label-text {
  font-size: 20px;
}

.filter-input-multiple {
  background-color: #333975 !important;
  border-color: #333975 !important;
  color: white !important;
  height: 100px !important;
  padding-left: 20px !important;
  padding-right: 20px !important;
  font-size: 14px !important;
  font-weight: bold !important;
  position: relative;
}

.filter-input-multiple.select {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  position: relative;
  cursor: pointer;
}

.container-scrollable {
  overflow-x: scroll;
  white-space: nowrap;
}

.scrollable {
  overflow-x: auto;
}
</style>
