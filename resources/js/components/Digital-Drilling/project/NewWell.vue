<template>
    <div class="newWell">
        <div class="well_content">
            <div class="well_body">
                <div class="well_body-header">
                    <div class="well_body-header-title">
                        Новая скважина
                    </div>
                    <div class="well_body-header-close" @click="closeNewWell">
                        Закрыть
                    </div>
                </div>
                <div class="well_body-content">
                    <div class="well_body-content-title">
                        <span>Скважина 1</span>
                    </div>
                    <div class="well_body-inner">
                        <div class="well_body-form">
                            <div class="well_body-form-input">
                                <label for="DZO">Наименование ДЗО:</label>
                                <select name="" id="DZO">
                                    <option value="" disabled selected="selected">Выбор ДЗО</option>
                                </select>
                            </div>
                            <div class="well_body-form-input">
                                <label for="field">Месторождение:</label>
                                <select  id="field">
                                    <option value="" disabled selected="selected">Выбор Месторождения</option>
                                </select>
                            </div>
                            <div class="well_body-form-input">
                                <label for="well">Скважина:</label>
                                <input type="text" placeholder="| Введите скважину" id="well">
                            </div>
                            <div class="well_body-form-checkbox">
                                <div class="Ground">
                                    <label for="ground">Наземная</label>
                                    <input type="checkbox" id="ground">
                                </div>
                                <div class="Marine">
                                    <label for="marine">Морская</label>
                                    <input type="checkbox" id="marine">
                                </div>
                            </div>
                            <div class="well_body-form-input">
                                <label for="height">Высота над уровнем моря:</label>
                                <input type="text" placeholder="| Высота" id="height">
                                <span class="input-size">м.</span>
                            </div>
                            <div class="well_body-form-input">
                                <label for="sheight">Высота стола ротора:</label>
                                <input type="text" placeholder="| Высота" id="sheight">
                                <span class="input-size">м.</span>
                            </div>
                            <div class="well_body-form-coordinates">
                                <div class="coordinates-title">
                                    Координаты устья:
                                </div>
                                <div class="coordinates-form">
                                    <div class="coordinates-form-input">
                                        <label for="mouthX">x</label>
                                        <input type="text" id="mouthX" placeholder="| x">
                                    </div>
                                    <div class="coordinates-form-input">
                                        <label for="mouthY">y</label>
                                        <input type="text" id="mouthY" placeholder="| y">
                                    </div>
                                </div>
                            </div>
                            <div class="well_body-form-coordinates">
                                <div class="coordinates-title">
                                    Координаты забоя:
                                </div>
                                <div class="coordinates-form">
                                    <div class="coordinates-form-input">
                                        <label for="downholeX">x</label>
                                        <input type="text" id="downholeX" placeholder="| x">
                                    </div>
                                    <div class="coordinates-form-input">
                                        <label for="downholeY">y</label>
                                        <input type="text" id="downholeY" placeholder="| y">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NewWell",
        methods:{
            closeNewWell(){
                this.$emit('closeNewWell')
            },
        },
    }
</script>

<style scoped>

</style>