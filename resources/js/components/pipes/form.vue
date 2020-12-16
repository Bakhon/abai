<template>
    <div class="col-xs-12 col-sm-12 col-md-12 row">
        <div class="col-xs-12 col-sm-4 col-md-4">
            <label>ГУ</label>
            <div class="form-label-group">
                <select class="form-control" name="gu_id" v-model="formFields.gu_id">
                    <option v-for="row in gus" v-bind:value="row.id">{{ row.name }}</option>
                </select>
            </div>
            <label>Внутренний диаметр</label>
            <div class="form-label-group">
                <input v-model="formFields.inner_diameter" type="number" step="0.0001"
                       name="inner_diameter" class="form-control" placeholder="">
            </div>
            <label>Материал</label>
            <div class="form-label-group">
                <select class="form-control" name="material_id" v-model="formFields.material_id">
                    <option v-for="row in materials" v-bind:value="row.id">{{ row.name }}</option>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4">
            <label>Длина</label>
            <div class="form-label-group">
                <input v-model="formFields.length" type="number" step="0.0001"
                       name="length" class="form-control" placeholder="">
            </div>
            <label>Толщина стенок</label>
            <div class="form-label-group">
                <input v-model="formFields.thickness" type="number" step="0.0001"
                       name="thickness" class="form-control" placeholder="">
            </div>
            <label>Участок</label>
            <div class="form-label-group">
                <input v-model="formFields.plot" type="number" step="0.0001"
                       name="plot" class="form-control" placeholder="">
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4">
            <label>Внешний диаметр</label>
            <div class="form-label-group">
                <input v-model="formFields.outside_diameter" type="number" step="0.0001"
                       name="outside_diameter" class="form-control" placeholder="">
            </div>
            <label>Жесткость</label>
            <div class="form-label-group">
                <input v-model="formFields.roughness" type="number" step="0.0001"
                       name="roughness" class="form-control" placeholder="">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" :disabled="!valid" class="btn btn-success">Сохранить</button>
        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import {Settings} from 'luxon'

Settings.defaultLocale = 'ru'

export default {
    name: "pipe-form",
    props: [
        'pipe'
    ],
    data: function () {
        return {
            formFields: {
                gu_id: null,
                length: null,
                outside_diameter: null,
                inner_diameter: null,
                thickness: null,
                roughness: null,
                material_id: null,
                plot: null,
            },
            gus: {},
            materials: {},
            requiredFields: [
                'gu_id',
                'length',
                'outside_diameter',
                'roughness',
            ]
        }
    },
    computed: {
        valid() {
            let valid = true
            this.requiredFields.forEach(field => {
                if(!this.formFields[field]) {
                    valid = false
                }
            })
            return valid
        }
    },
    beforeCreate: function () {
        this.axios.get("/ru/getallgus").then((response) => {
            let data = response.data;
            if (data) {
                this.gus = data.data;
            } else {
                console.log('No data');
            }
        });
        this.axios.get("/ru/getmaterials").then((response) => {
            let data = response.data;
            if (data) {
                this.materials = data.data;
            } else {
                console.log('No data');
            }
        });
    },
    mounted() {
        if (this.pipe) {
            this.formFields = {
                gu_id: this.pipe.gu_id,
                length: this.pipe.length,
                outside_diameter: this.pipe.outside_diameter,
                inner_diameter: this.pipe.inner_diameter,
                thickness: this.pipe.thickness,
                roughness: this.pipe.roughness,
                material_id: this.pipe.material_id,
                plot: this.pipe.plot,
            }
        }
    },
};
</script>
<style scoped>
.form-label-group {
    padding-bottom: 30px;
}
</style>
