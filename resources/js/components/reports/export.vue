<template>
  <div class="export-wrapper">
    <cat-loader v-show="loading"/>
    <div class="col-xs-12 col-sm-12 col-md-12 row">
      <div class="col-xs-12 col-sm-4 col-md-4 mb-4">
        <label>Выберите разделы</label>
        <div class="form-label-group form-check">
          <input
              type="checkbox"
              class="form-check-input"
              id="check_all"
              v-model="allSelected"
          />
          <label class="form-check-label" for="check_all">Все</label>
        </div>
        <div class="form-label-group form-check" v-for="section in sections">
          <input
              type="checkbox"
              class="form-check-input"
              name="sections[]"
              :id="`section_${section.code}`"
              v-model="selectedSections"
              :value="section.code"
          />
          <label class="form-check-label" :for="`section_${section.code}`">
            {{ section.name }}
          </label>
        </div>
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 row">
      <div class="col-xs-12 col-sm-4 col-md-4">
        <label>Дата начала</label>
        <div class="form-label-group">
          <datetime
              type="date"
              v-model="start_date"
              input-class="date form-control"
              value-zone="Asia/Almaty"
              zone="Asia/Almaty"
              :format="{ year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: '2-digit', timeZoneName: 'short' }"
              :phrases="{ok: trans('app.choose'), cancel: trans('app.cancel')}"
              :hour-step="1"
              :minute-step="5"
              :max-datetime="end_date"
              :week-start="1"
              use24-hour
              auto
          >
          </datetime>
        </div>
      </div>
      <div class="col-xs-12 col-sm-4 col-md-4">
        <label>Дата окончания</label>
        <div class="form-label-group">
          <datetime
              type="date"
              v-model="end_date"
              input-class="date form-control"
              value-zone="Asia/Almaty"
              zone="Asia/Almaty"
              :format="{ year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: '2-digit', timeZoneName: 'short' }"
              :phrases="{ok: trans('app.choose'), cancel: trans('app.cancel')}"
              :hour-step="1"
              :minute-step="5"
              :min-datetime="start_date"
              :max-datetime="today"
              :week-start="1"
              use24-hour
              auto
          >
          </datetime>
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
        <button class="btn btn-primary" :disabled="!selectedSections.length" @click="exportExcel">Экспорт</button>
      </div>
    </div>
  </div>
</template>
<script>
import moment from 'moment'
import CatLoader from '../ui-kit/CatLoader'

export default {
  name: 'report-export',
  components: {
    CatLoader
  },
  data() {
    return {
      start_date: moment().subtract(1, 'month').format('YYYY-MM-DD'),
      end_date: moment().format('YYYY-MM-DD'),
      today: moment().format('YYYY-MM-DD'),
      loading: false,
      sections: [
        {
          name: 'ОМГ ДДНГ',
          code: 'omgca'
        },
        {
          name: 'ОМГ УХЭ',
          code: 'omguhe'
        },
        {
          name: 'База данных по скорости коррозии',
          code: 'corrosion'
        },
        {
          name: 'ОМГ НГДУ',
          code: 'omgngdu'
        },
        {
          name: 'База данных по промысловой жидкости и газу',
          code: 'watermeasurement'
        },
        {
          name: 'База данных по нефти и газу',
          code: 'oilgas'
        }
      ],
      selectedSections: [
          'omgca',
          'omguhe',
          'corrosion',
          'omgngdu',
          'watermeasurement',
          'oilgas',
      ],
      allSelected: true
    }
  },
  watch: {
    allSelected(val) {
      if(val) {
        this.selectedSections = this.sections.map(section => section.code)
      }
      else {
        this.selectedSections = []
      }
    }
  },
  methods: {
    exportExcel() {
      this.loading = true
      this.axios.get('/ru/monitor/reports/generate', {
        params: {
          start_date: this.formatDate(this.start_date),
          end_date: this.formatDate(this.end_date),
          sections: this.selectedSections
        }
      }).then((response) => {
        let interval = setInterval(() => {
          this.axios.get('/ru/jobs/status', {params: {id: response.data.id}}).then((response) => {
            if (response.data.job.status === 'finished') {
              this.loading = false
              clearInterval(interval)
              document.location.href = response.data.job.output.filename
            } else if (response.data.job.status === 'failed') {
              this.loading = false
              clearInterval(interval)
              alert('Ошибка экспорта')
            }
          })
        }, 2000)

      });
    },
    formatDate(date) {
      return moment(date).format('YYYY-MM-DD')
    }
  }
};
</script>
<style lang="scss">
h1, label {
  color: #fff;
}

.export-loader {
  flex: 0 1 auto;
  flex-flow: row wrap;
  width: 100%;
  align-items: center;
  position: absolute;
  height: 100%;
  justify-content: center;
  display: flex;
  z-index: 5000;
  background: rgba(0, 0, 0, 0.4);
  left: 0;
  top: 0;
  right: 0;
  bottom: 0;
}
</style>
