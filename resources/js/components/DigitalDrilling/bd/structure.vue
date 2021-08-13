<template>
    <div class="digitalDrillingWindow">
        <window-head @getWellID="getWellID"/>
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Конструкция скважины</p>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table defaultTable">
                            <tbody>
                                <tr>
                                    <th>Вид обсадной трубы</th>
                                    <th>Вид колонны</th>
                                    <th>Интервал спуска колонны от</th>
                                    <th>Интервал спуска колонны до</th>
                                    <th>Боковой ствол</th>
                                    <th>Количество труб</th>
                                    <th>Объем залитого цемента</th>
                                    <th>Высота подъема цемента</th>
                                    <th>Пакер от</th>
                                    <th>Пакер до</th>
                                    <th>Глубина спуска колонны</th>
                                    <th>Пакер</th>
                                </tr>
                                <tr v-for="str in structure">
                                    <td>{{str.Вид_трубы}}</td>
                                    <td>{{str.Вид_колонны}}</td>
                                    <td>{{str.Интервал_от}}</td>
                                    <td>{{str.Интервал_до}}</td>
                                    <td>{{str.Боковой_ствол}}</td>
                                    <td>{{str.Количество_труб}}</td>
                                    <td>{{str.Объем_цемента}}</td>
                                    <td>{{str.Высота_цемента}}</td>
                                    <td>{{str.Пакер_от}}</td>
                                    <td>{{str.Пакер_до}}</td>
                                    <td>{{str.Глубина_спуска}}</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <img src="/img/digital-drilling/structure.png" alt="" class="structure-img">
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "structure",
        data() {
            return{
                structure: null
            }
        },
        mounted() {
            if (this.well){
                this.getWellID(this.well.id)
            }
        },
        methods:{
            getWellID(id){
                this.axios.get('http://172.20.103.203:8000/digital_drilling/api/structure/'+id + '/').then((response) => {
                    let data = response.data;
                    if (data) {
                        this.structure = data;
                        console.log(this.structure)
                    } else {
                        console.log('No data');
                    }
                });

            },
        },
        computed:{
            well(){
                return this.$store.getters['digitalDrilling/isCurrentWell']
            }
        },
    }
</script>

<style scoped>

</style>