<template>
  <div class="table-container scrollable">
    <div class="container container-main">
      <transition name="fade">
        <div>
          <div v-if="isFilesUploadedOnPreApproval && !isLastFileProcessed">

            <div class="row">
              <label class="subsection-text">
                <span>Укажите данные для LAS файла:</span>
                <span :title="files[currentFileInfoNum].name" class="filename">{{
                    files[currentFileInfoNum].name
                  }}</span>
              </label>
              <span>| файл {{ currentFileInfoNum + 1 }} из {{ files.length }}</span>
            </div>
            <div class="row">
              <button id="refreshExperimentInfo" :disabled="isLoading"
                      class="col btn btn-primary get-report-button"
                      @click="refreshGenericUploadParams()">
                &#x21bb; Обновить
              </button>
            </div>
            <div class="row">
              <div class="col">
                <label class="subsection-text">скважина</label>
                <input v-model="input.well" class="form-control filter-input mr-2 mb-2">
              </div>
              <div class="col">
                <label class="subsection-text">месторождение</label>
                <input v-model="input.field" class="form-control filter-input mr-2 mb-2">
              </div>
              <div class="col">
                <label class="subsection-text">комментарий</label>
                <input v-model="input.comment" class="form-control filter-input mr-2 mb-2">
              </div>
            </div>
            <div class="row">
              <label class="label-text">Укажите происхождение файла</label>
            </div>
            <div class="row">
              <select
                  id="originSelect"
                  v-model="input.provenanceId"
                  :disabled="isLoading"
                  class="col form-control filter-input select mr-2 mb-2"
              >
                <option disabled selected value="">Укажите происхождение файла</option>
                <option v-for="item in getDict('file_origin')" :value="item.id">{{ item.name }}</option>
              </select>
            </div>
            <div class="row">
              <label class="subsection-text">Параметры для формирования имени файла</label>
            </div>
            <div class="row">
              <label class="label-text">Имя файла: {{ filenameByParameters }}</label>
            </div>
            <div class="row">

              <div class="col">
                <select
                    id="originSelect"
                    v-model="input.filename.stemType"
                    :disabled="isLoading"
                    class="col form-control filter-input select mr-2 mb-2"
                    required
                >
                  <option disabled value="">Тип ствола</option>
                  <option v-for="item in getDict('stem_type')" :value="item.id">{{ item.name }}</option>
                </select>
              </div>
              <div class="col-6">
                <select
                    id="originSelect"
                    v-model="input.filename.recordingMethod"
                    :disabled="isLoading"
                    class="col form-control filter-input select mr-2 mb-2"
                    required
                >
                  <option disabled value="">Технология записи</option>
                  <option v-for="item in getDict('recording_method')" :value="item.id">{{ item.name }}</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                <label class="label-text">Мнемоники:</label>
              </div>
              <div class="col-3">
                <select
                    id="originSelect"
                    v-model="input.filename.mnemonics"
                    :disabled="isLoading"
                    class="col filter-input-multiple select mr-2 mb-2"
                    multiple
                    required
                >
                  <option v-for="mnemonic in filenameParameters.specific[currentFileInfoNum].mnemonics"
                          :value="mnemonic"
                  >{{ mnemonic }}
                  </option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                <label class="label-text">Дата проведения работ:</label>
              </div>
              <div class="col-3">
                <datetime
                    id="end_date"
                    v-model="input.filename.date"
                    :disabled="isLoading"
                    :flow="['year', 'month', 'date']"
                    :phrases="{ok: '', cancel: ''}"
                    auto
                    format="dd LLLL yyyy"
                    input-class="form-control filter-input"
                    input-id="end_date2"
                    type="date"
                    value-zone="Asia/Almaty"
                    zone="Asia/Almaty"
                >
                </datetime>
              </div>
              <div class="col-6">
                <select
                    id="originSelect"
                    v-model="input.filename.fileStatus"
                    :disabled="isLoading"
                    class="col form-control filter-input select mr-2 mb-2"
                    required
                >
                  <option disabled value="">Статус обработки</option>
                  <option v-for="item in getDict('file_status')" :value="item.id">{{ item.name }}</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                <label class="label-text">Глубина записи
                  ({{ filenameParameters.specific[currentFileInfoNum].recordingStep }}):</label>
              </div>
              <div class="col-3">
                <input v-model="input.filename.recordingDepth" class="col form-control filter-input mr-2 mb-2" required>
              </div>
              <div class="col-6">
                <select
                    id="originSelect"
                    v-model="input.filename.recordingState"
                    :disabled="isLoading"
                    class="col form-control filter-input select mr-2 mb-2"
                    required
                >
                  <option disabled value="">Статус записи</option>
                  <option v-for="item in getDict('recording_state')" :value="item.id">{{ item.name }}</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <select
                    id="originSelect"
                    v-model="input.filename.extension"
                    :disabled="isLoading"
                    class="col form-control filter-input select mr-2 mb-2"
                    required
                >
                  <option disabled value="">Расширение файла</option>
                  <option v-for="item in getDict('file_format')" :value="item.id">{{ item.name }}</option>
                </select>
              </div>
              <div class="col"></div>
            </div>
            <div class="row">
              <button id="submitExperimentInfo"
                      :disabled="!isInputFilledFieldsForFileUpload || !files || isLoading || input.provenanceId === ''"
                      class="col btn btn-primary get-report-button"
                      @click="submitFileParams()">
                Подтвердить данные по эксперименту
              </button>
            </div>

          </div>
          <div v-else>
            <div class="row">
              <label class="section-text">Загрузить LAS файлы </label>
            </div>
            <div class="row">
              <input id="file" ref="file" class="col form-control filter-input mr-2 mb-2" multiple title="Файл"
                     type="file" @change="handleFileUpload()">
            </div>

            <div class="row">
              <button id="experimentUploadButton a" :disabled="files.length === 0"
                      class="col btn btn-primary get-report-button"
                      @click.prevent="submitFiles()">
                Загрузить
              </button>
            </div>
          </div>
        </div>
      </transition>
    </div>
  </div>
</template>

<script src="./GisFormLas.js"></script>

<style lang="scss" scoped>
.table-container {
  overflow-y: auto;
}

.section-text {
  font-size: 30px;
}

.label-text {
  font-size: 20px;
}

.subsection-text {
  align-items: center;
  display: flex;
  font-size: 25px;

  span {
    display: inline-block;
    line-height: 1;
    margin-right: 5px;

    &.filename {
      max-width: 200px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }
  }
}

.filter-input-multiple {
  background-color: #333975;
  border-color: #333975;
  color: white;
  height: 70px;
  padding-left: 20px;
  padding-right: 20px;
  font-size: 14px;
  font-weight: bold;
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
  transition: opacity 1s
}

.fade-enter, .fade-leave-to, .fade-leave-active {
  opacity: 0
}

.reference-link {
  color: #fff;
  font-size: 20px;
  line-height: 25px;
}
</style>
