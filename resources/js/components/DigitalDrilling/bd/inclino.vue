<template>
    <div class="digitalDrillingWindow">
        <window-head />
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Инклинометрия</p>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table defaultTable">
                            <tbody>
                                <tr>
                                    <th>Скважина</th>
                                    <th>Прибор</th>
                                    <th>Источник</th>
                                    <th>Истинная глубина по вертикали</th>
                                    <th>Дата</th>
                                    <th>Географический идентификатор</th>
                                </tr>
                                <tr v-for="i in 10">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <img src="/img/digital-drilling/inclino.png" alt="" class="inclino-img">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "inclino"
    }
</script>

<style scoped>

</style>