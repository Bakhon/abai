<template>
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
</template>
<script>
import moment from 'moment'

export default {
    name: 'report-export',
    data() {
        return {
            start_date: moment().subtract(1, 'month').format('YYYY-MM-DD'),
            end_date: moment().format('YYYY-MM-DD'),
            today: moment().format('YYYY-MM-DD'),
        }
    },
    computed: {},
    methods: {
        exportExcel() {
            console.log('/ru/reports/monitoring?start_date=${this.start_date}&end_date=${this.end_date}')
            document.location.href = `/ru/reports/monitoring?start_date=${this.formatDate(this.start_date)}&end_date=${this.formatDate(this.end_date)}`
        },
        formatDate(date) {
            return moment(date).format('YYYY-MM-DD')
        }
    }
};
</script>
<style>
h1, label {
    color: #fff;
}
</style>
