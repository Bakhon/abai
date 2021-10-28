<template>
    <div class="digitalDrillingWindow">
        <div class="table">
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th>{{ trans('digital_drilling.structure.column_view') }}</th>
                    <th>Номинальный диаметр</th>
                    <th>{{ trans('digital_drilling.structure.column_running_depth') }}</th>
                    <th>{{ trans('digital_drilling.structure.number_pipes') }}</th>
                    <th>{{ trans('digital_drilling.structure.column_running_interval_from') }}</th>
                    <th>{{ trans('digital_drilling.structure.column_running_interval_up') }}</th>
                    <th>{{ trans('digital_drilling.structure.poured_cement_volume') }}</th>
                    <th>{{ trans('digital_drilling.structure.packer_from') }}</th>
                    <th>{{ trans('digital_drilling.structure.packer_to') }}</th>
                    <th>{{ trans('digital_drilling.structure.cement_lifting_height') }}</th>
                    <th>{{ trans('digital_drilling.structure.side_barrel') }}</th>
                </tr>
                <tr v-for="structure in structures">
                    <td>{{structure.Вид_колонны}}</td>
                    <td>{{structure.Номинальный_диаметр}}</td>
                    <td>{{structure.Глубина_спуска}}</td>
                    <td>{{structure.Количество_труб}}</td>
                    <td>{{structure.Интервал_от}}</td>
                    <td>{{structure.Интервал_до}}</td>
                    <td>{{structure.Объем_цемента}}</td>
                    <td>{{structure.Пакер_от}}</td>
                    <td>{{structure.Пакер_до}}</td>
                    <td>{{structure.Высота_цемента}}</td>
                    <td>{{structure.Боковой_ствол}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    import {digitalDrillingState, globalloadingMutations} from '@store/helpers';

    export default {
        name: "structure",
        data(){
            return{
                structures: [],
            }
        },
        computed: {
            ...digitalDrillingState([
                'currentWell'
            ]),
        },
        mounted(){
            this.getStructureByWell()
        },
        methods:{
            ...globalloadingMutations([
                'SET_LOADING'
            ]),
            async getStructureByWell(){
                this.SET_LOADING(true);
                try{
                    await this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/api/structure/'+
                        this.currentWell.id).then((response) => {
                        let data = response.data;
                        if (data) {
                            this.structures =  data
                        } else {
                            console.log('No data');
                        }
                    });
                }
                catch (e) {
                    console.log(e)
                }
                this.SET_LOADING(false);
            },
        },
        watch: {
            currentWell: function (val) {
                this.getStructureByWell()
            }
        },
    }
</script>

<style scoped>

</style>