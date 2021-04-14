<template>
  <div class="table-container">
    <cat-loader/>
    <div>file<span>&nbsp;*</span>
    </div>
    <div class="container container-main">
      <transition name="fade">

        <div v-if="isFilesUploadedOnPreApproval">
          <div class="row">
            <label class="section-text">Укажите данные для LAS файла: {{ files[currentFileInfo].name }} | файл
              {{ currentFileInfo + 1 }} из {{ files.length }}</label>
          </div>
          <div class="row">

            <input class="col form-control filter-input mr-2 mb-2" v-model="input.well" placeholder="id скважины">
            <input class="col form-control filter-input mr-2 mb-2" v-model="input.field" placeholder="id месторождения">
            <input class="col form-control filter-input mr-2 mb-2" v-model="input.comment" placeholder="комментарий">
          </div>
          <div class="row">
            <label class="subsection-text">Выберите параметры для формирования имени файла</label>
          </div>
          <div class="row">
            <label class="label-text">Имя файла: UZN_0001_ST2_OH_WL_DEN_NEU_RES_030321_FIN_100_1500_MAIN.las
              {{ input.filename.name }}</label>
          </div>
          <div class="row">
            <div class="col-6">
              <select
                  class="form-control filter-input select mr-2 mb-2"
                  id="originSelect2"
                  :disabled="isLoading"
                  v-model="input.filename.field"
              >
                <option disabled value="">Месторождение</option>
                <option v-for="field in filenameParameters.generic.fields" :value="field">{{ field }}</option>
              </select>
            </div>
            <div class="col-6">
              <select
                  class="col form-control filter-input select mr-2 mb-2"
                  id="originSelect"
                  :disabled="isLoading"
                  v-model="input.filename.well"
              >
                <option disabled value="">Скважина</option>
                <option v-for="well in filenameParameters.generic.wells" :value="well">{{ well }}</option>
              </select>
            </div>
          </div>
          <div class="row">

            <div class="col">
              <select
                  class="col form-control filter-input select mr-2 mb-2"
                  id="originSelect"
                  :disabled="isLoading"
                  v-model="input.filename.stemType"
              >
                <option disabled value="">Наименование ствола</option>
                <option v-for="stemType in filenameParameters.generic.stemTypes" :value="stemType">{{ stemType }}</option>
              </select>
            </div>
            <div class="col">
              <select
                  class="col form-control filter-input select mr-2 mb-2"
                  id="originSelect"
                  :disabled="isLoading"
                  v-model="input.filename.stemSection"
              >
                <option disabled value="">Секция ствола</option>
                <option v-for="stemSection in filenameParameters.generic.stemSections" :value="stemSection">{{ stemSection }}</option>
              </select>
            </div>

          </div>
          <div class="row">
            <div class="col-6">
              <select
                  class="col form-control filter-input select mr-2 mb-2"
                  id="originSelect"
                  :disabled="isLoading"
                  v-model="input.filename.recordingMethod"
              >
                <option disabled value="">Наименование технологии записи</option>
                <option v-for="recordingMethod in filenameParameters.generic.recordingMethods" :value="recordingMethod">{{ recordingMethod }}</option>
              </select>
            </div>
            <div class="col-3">
              <label class="label-text">Выберите мнемоники:</label>
            </div>
            <div class="col-3">
              <select
                  class="col form-control filter-input-multiple select mr-2 mb-2"
                  id="originSelect"
                  :disabled="isLoading"
                  v-model="input.filename.mnemonics"
                  multiple
              >
                <option v-for="mnemonic in filenameParameters.specific[currentFileInfo].mnemonics" :value="mnemonic">{{ mnemonic }}</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <label class="label-text">Выберите дату проведения работ:</label>
            </div>
            <div class="col-3">
              <datetime
                  id="end_date"
                  type="date"
                  v-model="input.endDate"
                  value-zone="Asia/Almaty"
                  zone="Asia/Almaty"
                  input-class="form-control filter-input"
                  format="dd LLLL yyyy"
                  :phrases="{ok: '', cancel: ''}"
                  :disabled="isLoading"
                  input-id="end_date2"
                  auto
                  :flow="['year', 'month', 'date']"
              >
              </datetime>
            </div>
            <div class="col-6">
              <select
                  class="col form-control filter-input select mr-2 mb-2"
                  id="originSelect"
                  :disabled="isLoading"
                  v-model="input.filename.fileStatus"
              >
                <option disabled value="">Статус обработки</option>
                <option v-for="fileStatus in filenameParameters.generic.fileStatuses" :value="fileStatus">{{ fileStatus }}</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <label class="label-text">Глубина записи:</label>
            </div>
            <div class="col-3">
              <input class="col form-control filter-input mr-2 mb-2" v-model="input.filename.recordingDepth">
            </div>
            <div class="col-6">
              <select
                  class="col form-control filter-input select mr-2 mb-2"
                  id="originSelect"
                  :disabled="isLoading"
                  v-model="input.filename.recordState"
              >
                <option disabled value="">Статус записи</option>
                <option v-for="recordState in filenameParameters.generic.recordStates" :value="recordState">{{ recordState }}</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <select
                  class="col form-control filter-input select mr-2 mb-2"
                  id="originSelect"
                  :disabled="isLoading"
                  v-model="input.filename.extension"
              >
                <option disabled value="">Расширение файла</option>
                <option v-for="extension in filenameParameters.generic.extensions" :value="extension">{{ extension }}</option>
              </select>
            </div>
            <div class="col"></div>
          </div>
        </div>

        <div v-else>
          <div class="row">
            <label class="section-text">Загрузить LAS файлы </label>
          </div>
          <div class="row">
            <input class="col form-control filter-input mr-2 mb-2" type="file" id="file" ref="file" title="Файл"
                   @change="handleFileUpload()" multiple>
          </div>
          <div class="row">
            <button class="col btn get-report-button" id="experimentUploadButton a"
                    :disabled="!files || isLoading"
                    @click="submitFile()">
              Загрузить
            </button>
          </div>
        </div>
        <div class="row">
          <label class="label-text">Укажите происхождение файла</label>
        </div>
        <div class="row">
          <select
              class="col form-control filter-input select mr-2 mb-2"
              id="originSelect"
              :disabled="isLoading"
              v-model="input.provenanceId"
          >
            <option selected disabled value="">Укажите происхождение файла</option>
            <option v-for="provenance in provenances" :value="provenance.id">{{ provenance.origin }}</option>
          </select>
        </div>
        <div class="row">
          <button class="col btn get-report-button" id="submitExperimentInfo"
                  :disabled="input.provenanceId === null || !files || isLoading"
                  @click="submitExperimentInfo()">
            Подвердить данные по эксперименту
          </button>
        </div>
      </transition>
    </div>
<!--    <div class="container  container-main info pt-5">-->
<!--      <label class="label-text" v-if="experimentsId">ID эксперимента {{ experimentsId }}</label>-->
<!--    </div>-->

    <div class="container  container-main pt-5">
      <div class="row">
        <label class="section-text">Поиск экспериментов по номеру скважины</label>
      </div>
      <div class="row">
        <input class="col form-control filter-input mb-2" id="wellId" v-model="wellId"
               placeholder="id скважины как в лас файле">
      </div>
      <div class="row">
        <button class="col btn get-report-button" id="experimentInfoButton2" @click="selectExperiments()">
          Поиск
        </button>
      </div>
    </div>
    <div class="container  container-main info pt-5" v-if="selectedExperimentsInfo">
      <div class="row mb-2">
        <label class="col label-text pt-4">Id</label>
        <label class="col label-text pt-4">Происхождение</label>
        <div class="col"></div>
      </div>
      <div v-for="experimentsInfo in selectedExperimentsInfo">
        <div class="row mb-2">
          <label class="col label-text pt-4">{{ experimentsInfo.id }}</label>
          <label class="col label-text pt-4">{{ experimentsInfo.provenance_origin }}</label>
          <button class="col btn get-report-button" @click="getOriginalLas(experimentsInfo)">Скачать</button>
        </div>
      </div>
    </div>

    <div class="container  container-main pt-5">
      <div class="row">
        <label class="section-text">Получение статистики по эксперименту</label>
      </div>
      <div class="row">
        <input class="col form-control filter-input mb-2" id="wellId" v-model="statisticsInput.experimentId"
               placeholder="id эксперимента">
      </div>
      <div class="row">
        <button class="col btn get-report-button" id="statisticksButton" @click="fetchStatistics()">
          Получить
        </button>
      </div>
    </div>
    <div class="container  container-main info pt-5" v-if="experimentStatistics">
      <div class="row">
        <label class="col label-text">Выберите мнемоники</label>
      </div>
      <div class="row">
        <select
            class="col form-control filter-input-multiple select mr-2 mb-2"
            id="mnemonicsSelect"
            :disabled="isLoading"
            v-model="statisticsInput.mnemonics"
            multiple
        >
          <option value="all">Все</option>
          <option v-for="(statistics,mnemonics) in experimentStatistics" :value="mnemonics">{{ mnemonics }}</option>
        </select>
      </div>
    </div>
    <div class="container  container-main info pt-5" v-if="statisticsInput.mnemonics.length > 0">
      <div class="row mb-2">
        <label class="col label-text">Мнемоника</label>
        <label class="col label-text">Max</label>
        <label class="col label-text">Min</label>
        <label class="col label-text">Average</label>
        <label class="col label-text">Steps</label>
        <label class="col label-text">Frames</label>
      </div>
      <div v-for="(statistics,mnemonics) in experimentStatistics">
        <div class="row mb-2"
             v-if="statisticsInput.mnemonics.includes(mnemonics) || statisticsInput.mnemonics.includes('all')">
          <label class="col label-text">{{ mnemonics }}</label>
          <label class="col label-text">{{ statistics.max }}</label>
          <label class="col label-text">{{ statistics.min }}</label>
          <label class="col label-text">{{ statistics.average }}</label>
          <label class="col label-text">{{ statistics.steps }}</label>
          <label class="col label-text">{{ statistics.frames }}</label>
        </div>
      </div>
    </div>


    <div class="container  container-main pt-5">
      <div class="row">
        <label class="section-text">Получение полной информации об эксперименте</label>
      </div>
      <div class="row">
        <input class="col form-control filter-input mb-2" id="experiment" v-model="experimentId"
               placeholder="id эксперимента">
      </div>
      <div class="row">
        <button class="col btn get-report-button" id="experimentInfoButton" @click="fetchExperiments()">
          Поиск
        </button>
      </div>
    </div>
    <div class="container  container-main info pt-5" v-if="experimentInfo">
      <div class="row">
        <label class="section-text">Шаг {{ experimentInfo.step }}</label>
      </div>
      <div class="row">
        <label class="section-text">Начало глубины измерения {{ experimentInfo.depth_start }}</label>
      </div>
      <div class="row">
        <label class="section-text">Конец глубины измерения {{ experimentInfo.depth_end }}</label>
      </div>
      <div class="row">
        <label class="section-text">Id скважины {{ experimentInfo.well_id }}</label>
      </div>
      <div class="row">
        <label class="section-text">Id месторождения {{ experimentInfo.field_id }}</label>
      </div>
      <div class="row">
        <label class="section-text">Комментарий {{ experimentInfo.comment }}</label>
      </div>

      <div class="row" v-for="experiment in experimentInfo.curves" v-if="experimentInfo">
        <label class="section-text">Мнемоника {{ experiment.mnemonic }}</label>
        <label class="section-text">Данные {{ experiment.curve }}</label>
      </div>
    </div>
  </div>
</template>

<script src="./Las.js"></script>

<style>
.info {
  color: white
}

.section-text {
  font-size: 30px;
}

.label-text {
  font-size: 20px;
}

.subsection-text {
  font-size: 25px;
}


.filter-input-multiple {
  background-color: #333975 !important;
  border-color: #333975 !important;
  color: white !important;
  height: 70px !important;
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

.fade-enter-active, .fade-leave-active {
  transition: opacity .5s
}

.fade-enter, .fade-leave-to, .fade-leave-active {
  opacity: 0
}

</style>
