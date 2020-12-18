<template>
    <div class="col-xs-12 col-sm-12 col-md-12 row">
        <div class="col-xs-12 col-sm-4 col-md-4">
            <label>Название</label>
            <div class="form-label-group">
                <input v-model="formFields.name" type="text" name="name" class="form-control" placeholder="">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <a href="#" @click.prevent="showPriceChange = !showPriceChange">Изменить цену</a>
            </div>
            <template v-if="showPriceChange">
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <label>Цена</label>
                    <div class="form-label-group">
                        <input v-model="formFields.price" type="number" step="0.0001" name="price" class="form-control">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <label>Дата применения цены</label>
                    <div class="form-label-group">
                        <datetime
                            type="date"
                            v-model="formFields.date_from"
                            input-class="form-control date"
                            value-zone="Asia/Almaty"
                            zone="Asia/Almaty"
                            :format="{ year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: '2-digit', timeZoneName: 'short' }"
                            :phrases="{ok: 'Выбрать', cancel: 'Выход'}"
                            :hour-step="1"
                            :minute-step="5"
                            :week-start="1"
                            :min-datetime="minDate"
                            :max-datetime="formatDate()"
                            use24-hour
                            auto
                        >
                        </datetime>
                        <input type="hidden" name="date_from" v-bind:value="formatDate(formFields.date_from)">
                    </div>
                </div>
            </template>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" :disabled="!formFields.name" class="btn btn-success">Сохранить</button>
            </div>
        </div>
    </div>
</template>

<script>
import {Settings} from 'luxon'
import {Datetime} from 'vue-datetime'
import moment from 'moment'

Settings.defaultLocale = 'ru'

export default {
    name: "inhibitor-edit",
    components: {
        Datetime
    },
    props: [
        'inhibitor'
    ],
    data: function () {
        return {
            minDate: null,
            showPriceChange: false,
            formFields: {
                name: null,
                price: null,
                date_from: null
            },
            requiredFields: [
                'name'
            ]
        }
    },
    computed: {
        valid() {
            let valid = true
            this.requiredFields.forEach(field => {
                if (!this.formFields[field]) {
                    valid = false
                }
            })
            return valid
        }
    },
    mounted() {
        if (this.inhibitor) {
            this.formFields = {
                name: this.inhibitor.name,
                price: this.inhibitor.price,
                date_from: this.formatDate()
            }
            this.minDate = this.inhibitor.minDate
        }
    },
    methods: {
        formatDate(date = null) {
            if (date) {
                return moment(date).format('YYYY-MM-DD')
            }
            return moment().format('YYYY-MM-DD')
        }
    }
};
</script>
<style scoped>
.form-label-group {
    padding-bottom: 30px;
}
</style>
