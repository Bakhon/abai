<template>
  <div>
    <div class="export-loader" v-if="loading">
      <fade-loader :loading="loading"></fade-loader>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 row export-wrapper">
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
              :phrases="{ok: 'Выбрать', cancel: 'Выход'}"
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
              :phrases="{ok: 'Выбрать', cancel: 'Выход'}"
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
        <button class="btn btn-primary" @click="exportExcel">Экспорт</button>
      </div>
    </div>
  </div>
</template>
<script>
import moment from 'moment'
import FadeLoader from 'vue-spinner/src/FadeLoader.vue'

export default {
  name: 'report-export',
  components: {
    FadeLoader
  },
  data() {
    return {
      start_date: moment().subtract(1, 'month').format('YYYY-MM-DD'),
      end_date: moment().format('YYYY-MM-DD'),
      today: moment().format('YYYY-MM-DD'),
      loading: false
    }
  },
  computed: {},
  methods: {
    exportExcel() {
      this.loading = true
      this.axios.get('/ru/reports/monitoring', {
        params: {
          start_date: this.formatDate(this.start_date),
          end_date: this.formatDate(this.end_date)
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
