<template>
    <div class="digitalDrillingWindow">
        <window-head @getWellID="getWellID"/>
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">{{ trans('digital_drilling.structure.well_design') }}</p>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table defaultTable">
                            <tbody>
                                <tr>
                                    <th>{{ trans('digital_drilling.structure.casing_type') }}</th>
                                    <th>{{ trans('digital_drilling.structure.column_view') }}</th>
                                    <th>{{ trans('digital_drilling.structure.column_running_interval_from') }}</th>
                                    <th>{{ trans('digital_drilling.structure.column_running_interval_up') }}</th>
                                    <th>{{ trans('digital_drilling.structure.side_barrel') }}</th>
                                    <th>{{ trans('digital_drilling.structure.number_pipes') }}</th>
                                    <th>{{ trans('digital_drilling.structure.poured_cement_volume') }}</th>
                                    <th>{{ trans('digital_drilling.structure.cement_lifting_height') }}</th>
                                    <th>{{ trans('digital_drilling.structure.packer_from') }}</th>
                                    <th>{{ trans('digital_drilling.structure.packer_to') }}</th>
                                    <th>{{ trans('digital_drilling.structure.column_running_depth') }}</th>
                                    <th>{{ trans('digital_drilling.structure.packer') }}</th>
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
    import {digitalDrillingState} from '@store/helpers';
    export default {
        name: "structure",
        data() {
            return{
                structure: null
            }
        },
        mounted() {
            if (this.isCurrentWell()){
                this.getWellID(this.currentWell.id)
            }
        },
        methods:{
            getWellID(id){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/api/structure/'+id + '/').then((response) => {
                    let data = response.data;
                    this.structure = data;
                    if (data) {
                    } else {
                        console.log('No data');
                    }
                });

            },
            isCurrentWell () {
                return Object.keys(this.currentWell).length != 0;
            },
        },
        computed:{
            ...digitalDrillingState([
                'currentWell'
            ]),
        },
    }
</script>

<style scoped>

</style>