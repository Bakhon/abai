<template>
  <div class="table-container">
    <cat-loader/>
    <div class="container">
      <div class="row">
        <label class="label-text">Выберите тип отчета</label>
      </div>
      <div class="row">
        <select
            class="col form-control filter-input select mr-2 mb-2"
            id="reportTypeSelect"
            :disabled="isLoading"
            v-model="input.reportType"
            @change="increaseSelectionLevel"
        >
          <option disabled value="">Выберите тип отчета</option>
          <option value="По месяцам">По месяцам</option>
          <option value="По дням">По дням</option>
          <option value="Справочный">Справочный</option>
        </select>
      </div>

      <div class="row" v-if="selectionLevel > 0">
        <label class="label-text">Выберите представление</label>
      </div>
      <div class="row" v-if="selectionLevel > 0">
        <select
            class="col form-control filter-input select mr-2 mb-2"
            id="reportRepresentation"
            :disabled="isLoading"
            v-model="input.reportRepresentation"
            @change="increaseSelectionLevel"
        >
          <option disabled value="">Выберите представление</option>
          <option value="Данные по каждому объекту">Данные по каждому объекту</option>
          <option value="Аггрегированные данные по объектам">Аггрегированные данные по объектам</option>
        </select>
      </div>
      <div class="row" v-if="selectionLevel > 1">
        <label class="label-text">Выберите объект для отчета</label>
      </div>
      <div class="row" v-if="selectionLevel > 1">
        <select
            class="col form-control filter-input select mr-2 mb-2"
            id="reportTypeSelect"
            :disabled="isLoading"
            v-model="input.objectType"
            @change="onObjectTypeChange"
        >
          <option disabled value="">Выберите объект для отчета</option>
          <option v-for="(objectName, objectType) in objectNameByType" :value="objectType">{{ objectName }}</option>
        </select>
      </div>
      <template v-if="selectionLevel > 2">
        <template v-for="parentObjectType in getParentsInHierarchy(input.objectType)">
          <div class="row">
            <a href="#" @click="displayFilterFor(parentObjectType)" class="button">
              <label class="label-text">Фильтр значений по: {{ objectNameByType[parentObjectType] }}</label>
            </a>
          </div>

          <div class="row" v-if="activeFilterId === parentObjectType">
            <select
                class="col form-control filter-input-multiple select mr-2 mb-2"
                :disabled="isLoading"
                multiple
            >

              <option value="all">Все</option>
              <option v-for="objectValue in objectTypes[getInternalObjectType(input.objectType)]" :value="objectValue">{{ objectValue }}</option>
            </select>
          </div>
        </template>
        <div class="row">
          <label class="label-text">Выберите значение(-я) объекта: {{ objectNameByType[input.objectType] }}</label>
        </div>

        <div class="row">
          <select
              class="col form-control filter-input-multiple select mr-2 mb-2"
              :disabled="isLoading"
              v-model="input.objectValue"
              @change="onObjectTypeChange"
              multiple
          >

            <option value="all">Все</option>
            <option v-for="objectValue in objectTypes[getInternalObjectType(input.objectType)]" :value="objectValue"
            >{{ objectValue }}
            </option>
          </select>
        </div>

        <div class="row" v-if="selectionLevel > 3">
          <button class="col btn get-report-button" id="reportExampleButton" @click="fetchExampleData()">
            Отобразить пример данных отчета
          </button>
        </div>

        <template class="row" v-if="selectionLevel > 3 && exampleReport !== null">
          <div class="scrollable">
          <table>
            <tr>
              <th v-for="attributeName in exampleReport.schema">
                <input type="checkbox" checked>
                <label class="col label-text">  {{ attributeName }}</label>
              </th>
            </tr>
            <template v-for="row in exampleReport.data">
              <tr>
                <th v-for="attributeValue in row">
                  <label class="label-text">  {{ attributeValue }}</label>
                </th>
              </tr>
            </template>
          </table>
          </div>
        </template>
      </template>
    </div>
  </div>

</template>

<script>

export default {
  components: {},
  data() {
    return {
      baseUrl: 'http://172.20.103.187:8084/',
      input: {
        reportType: null,
        reportRepresentation: null,
        objectType: null,
        objectValue: null,
      },
      objectTypes: null,
      selectionLevel: 0,
      isLoading: false,
      hierarchyByObjectType: {
        'company': 0,
        'dzo': 1,
        'cppn': 2,
        'field': 1,
        'ngdu': 3,
        'cdng': 4,
        'upsv': 4,
        'karmas': 5,
        'gu': 5,
        'agzy': 7,
        'bkns': 8,
        'fond': 9,
        'water_well': 10,
        'horizon_of_water_well': 11,
        'oil_well': 10,
        'horizon_of_oil_well': 13
      },
      objectNameByType: {
        'company': 'Компания',
        'dzo': 'ДЗО',
        'cppn': 'ЦППН',
        'field': 'Месторождение',
        'upsv': 'УПСВ',
        'ngdu': 'НГДУ',
        'cdng': 'ЦДНГ',
        'karmas': 'Кармас',
        'gu': 'ГУ',
        'agzy': 'АГЗУ',
        'bkns': 'БКНС',
        'fond': 'Фонд',
        'water_well': 'Вододобывающая скважина',
        'horizon_of_water_well': 'Горизонт вододобывающей скважины',
        'oil_well': 'Нефтедобывающая скважина',
        'horizon_of_oil_well': 'Горизонт нефтедобывающей скважины',
      },
      activeFilterId: null,
      exampleReport: null,
    }
  },
  mounted: function () {
    this.$nextTick(function () {
      this.$store.commit('globalloading/SET_LOADING', false);
    });
    this.loadObjectTypes();
  },
  methods: {
    loadObjectTypes() {
      this.$store.commit('globalloading/SET_LOADING', true);
      this.axios.get(this.baseUrl + 'get_unique_values_by_object_type/'
      ).then((response) => {
        if (response.data) {
          this.objectTypes = response.data;
        }
      }).catch((error) => console.log(error)
      ).finally(() => this.$store.commit('globalloading/SET_LOADING', false));
    },
    onObjectTypeChange() {
      this.increaseSelectionLevel()
    },
    getInternalObjectType(objectType) {
      if (objectType === 'dzo') {
        return 'geo'
      }
      let hierarchyId = this.hierarchyByObjectType[objectType]
      if (hierarchyId >= 2 && hierarchyId <= 8) {
        return 'org'
      }
      if (objectType === 'water_well' || objectType === 'oil_well') {
        return 'well'
      }
      return null
    },
    increaseSelectionLevel() {
      if (this.input.reportType !== null && this.selectionLevel === 0) {
        this.selectionLevel = 1
      }
      if (this.input.reportRepresentation !== null && this.selectionLevel === 1) {
        this.selectionLevel = 2
      }
      if (this.input.objectType !== null && this.selectionLevel === 2) {
        this.selectionLevel = 3
      }
      if (this.input.objectValue !== null && this.selectionLevel === 3) {
        this.selectionLevel = 4
      }
    },
    getObjectName() {
      return this.objectNameByType[this.input.objectType]

    },
    getParentsInHierarchy(selectedObjectType) {
      let selectedObjectId = this.hierarchyByObjectType[selectedObjectType]
      let parents = []
      _.forIn(this.hierarchyByObjectType, function (objectId, objectType) {
        if (objectId < selectedObjectId) {
          parents.push(objectType)
        }
      })
      return parents
    },
    displayFilterFor(parentId) {
      this.activeFilterId = parentId;
    },
    fetchExampleData() {
      let objectType = this.getInternalObjectType(this.input.objectType)
      this.$store.commit('globalloading/SET_LOADING', true);
      this.exampleReport = null;
      this.axios.get(this.baseUrl + 'get_all_object_data/'+ objectType
      ).then((response) => {
        if (response.data) {
          this.exampleReport = response.data;
        }
      }).catch((error) => console.log(error)
      ).finally(() => this.$store.commit('globalloading/SET_LOADING', false));

    },
    _fetchPartOfExampleData() {
      let objectType = this.getInternalObjectType(this.input.objectType)
      this.$store.commit('globalloading/SET_LOADING', true);
      this.exampleReport = null;
      let jsonData = JSON.stringify({
        'object_names': this.input.objectValue.join(',')
      });
      this.axios.post(this.baseUrl + 'get_some_object_data/'+ objectType, jsonData, {
        responseType: 'json',
        headers: {
          'Content-Type': 'application/json'
        }
      }).then((response) => {
        if (response.data) {
          this.exampleReport = response.data;
        }
      }).catch((error) => console.log(error)
      ).finally(() => this.$store.commit('globalloading/SET_LOADING', false));
    },
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
  overflow-x:scroll;
  white-space: nowrap;
}
.scrollable {
  overflow-x:auto;
}
</style>
