<template>
  <div class="table-container">
    <cat-loader/>
    <div>file<span>&nbsp;*</span>
    </div>
    <div class="container">
      <div class="row">
        <label class="section-text">Загрузить LAS файл</label>
      </div>
      <div class="row">

        <input class="col form-control filter-input mr-2 mb-2" v-model="input.well" placeholder="id скважины">
        <input class="col form-control filter-input mr-2 mb-2" v-model="input.field" placeholder="id месторождения">
        <input class="col form-control filter-input mr-2 mb-2" v-model="input.comment" placeholder="комментарий">
        <input class="col form-control filter-input mr-2 mb-2" v-model="input.filename" placeholder="имя файла">
      </div>
      <div class="row">
        <input class="col form-control filter-input mr-2 mb-2" type="file" id="file" ref="file" title="Файл"
               @change="handleFileUpload()">
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
          <option disabled value="">Укажите происхождение файла</option>
          <option v-for="provenance in provenances" :value="provenance.id">{{ provenance.origin }}</option>
        </select>
      </div>
      <div class="row">
        <button class="col btn get-report-button" id="experimentUploadButton a"
                :disabled="!input.provenanceId || !file || isLoading"
                @click="submitFile()">
          Загрузить
        </button>
      </div>
    </div>
    <div class="container info pt-5">
      <label class="label-text" v-if="experimentsId">ID эксперимента {{ experimentsId }}</label>
    </div>

    <div class="container pt-5">
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
    <div class="container info pt-5" v-if="selectedExperimentsInfo">
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

    <div class="container pt-5">
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
    <div class="container info pt-5" v-if="experimentStatistics">
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
    <div class="container info pt-5" v-if="statisticsInput.mnemonics.length > 0">
      <div class="row mb-2">
        <label class="col label-text">Мнемоника</label>
        <label class="col label-text">Max</label>
        <label class="col label-text">Min</label>
        <label class="col label-text">Average</label>
        <label class="col label-text">Steps</label>
        <label class="col label-text">Frames</label>
      </div>
      <div v-for="(statistics,mnemonics) in experimentStatistics">
        <div class="row mb-2" v-if="statisticsInput.mnemonics.includes(mnemonics) || statisticsInput.mnemonics.includes('all')">
          <label class="col label-text">{{ mnemonics }}</label>
          <label class="col label-text">{{ statistics.max }}</label>
          <label class="col label-text">{{ statistics.min }}</label>
          <label class="col label-text">{{ statistics.average }}</label>
          <label class="col label-text">{{ statistics.steps }}</label>
          <label class="col label-text">{{ statistics.frames }}</label>
        </div>
      </div>
    </div>


    <div class="container pt-5">
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
    <div class="container info pt-5" v-if="experimentInfo">
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

.filter-input-multiple {
  background-color: #333975 !important;
  border-color: #333975 !important;
  color: white !important;
  height: 100% !important;
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
</style>
