<template>
    <div class="digitalDrillingWindow">
        <div class="table">
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th>{{ trans('digital_drilling.structure.column_view') }}</th>
                    <th>{{ trans('digital_drilling.default.nominal_diameter') }}</th>
                    <th>{{ trans('digital_drilling.structure.column_running_depth') }}</th>
                    <th>{{ trans('digital_drilling.structure.number_pipes') }}</th>
                    <th>{{ trans('digital_drilling.structure.pipe_inner_diameter') }}</th>
                    <th>{{ trans('digital_drilling.structure.steel_grade') }}</th>
                    <th>{{ trans('digital_drilling.structure.weight_per_unit_length') }}</th>
                    <th>{{ trans('digital_drilling.structure.cement_lifting_height') }}</th>
                    <th>{{ trans('digital_drilling.structure.side_barrel') }}</th>
                </tr>
                <tr v-for="structure in structures">
                    <td>{{structure.Вид_колонны}}</td>
                    <td>{{structure.Номинальный_диаметр}}</td>
                    <td>{{structure.Глубина_спуска}}</td>
                    <td>{{structure.Количество_труб}}</td>
                    <td>{{structure.Внутренний_диаметр}}</td>
                    <td>{{structure.Марка_стали}}</td>
                    <td>{{structure.Погонный_вес}}</td>
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