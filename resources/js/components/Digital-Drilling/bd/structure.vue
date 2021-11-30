<template>
    <div class="digitalDrillingWindow defaultScroll">
       <div class="row-structure">
           <div class="structure">
               <div class="table">
                   <table class="table defaultTable">
                       <tbody>
                       <tr v-for="(head, i) in structuresHead">
                           <td>{{ trans(head) }}</td>
                           <td v-for="structure in structures">
                                <span v-if="structureBody[i] == 'sum'">
                                    {{roundToTwo((structure.Номинальный_диаметр - structure.Внутренний_диаметр)/2)}}
                                </span>
                               <span v-else>
                                    {{structure[structureBody[i]]}}
                                </span>
                           </td>
                       </tr>
                       </tbody>
                   </table>
               </div>
           </div>
           <div class="structure">
               <div class="structure-graph">
                  <structure-type :data="structure9" type="type9"/>
               </div>
           </div>
       </div>
    </div>
</template>

<script>
    import {digitalDrillingState, globalloadingMutations} from '@store/helpers';
    import StructureType from '../components/StructureType'
    export default {
        name: "structure",
        components: {StructureType},
        data(){
            return{
                structures: [],
                structuresHead: ['digital_drilling.structure.column_view',
                'digital_drilling.default.nominal_diameter',
                'digital_drilling.structure.column_running_depth',
                'digital_drilling.structure.number_pipes',
                'digital_drilling.structure.wall_thickness',
                'digital_drilling.structure.pipe_inner_diameter',
                'digital_drilling.structure.steel_grade',
                'digital_drilling.structure.weight_per_unit_length',
                'digital_drilling.structure.cement_lifting_height',
                'digital_drilling.structure.side_barrel'],
                structureBody: [
                    'Вид_колонны',
                    'Номинальный_диаметр',
                    'Глубина_спуска',
                    'Количество_труб',
                    'sum',
                    'Внутренний_диаметр',
                    'Марка_стали',
                    'Погонный_вес',
                    'Высота_цемента',
                    'Боковой_ствол',
                ],
                structure1: [323.9, 397, 200, 244.5, 295.3, 700],
                structure2: [323.9, 397, 200, 244.5, 295.3, 700, 200, 244.5, 295.3],
                structure3: [323.9, 397, 200, 244.5, 295.3, 700, 200, 323.9, 397, 200, 244.5, 295.3, 700, 200,],
                structure4: [323000, 397, 200, 244.5, 295.3, 700, 200.5, 323.9, 397, 200, 244.5, 295555],
                structure5: [32.5, 397, 200, 244.5, 295.3, 700, 200.5, 323.9, 397, 200, 244.5, 295.5],
                structure6: [323.9, 397, 200, 244.5, 295.3, 700],
                structure7: [323.9, 397, 200, 244.5, 295.3, 700, 244.5, 295.3, 700],
                structure8: [323.9, 397, 200, 244.5, 295.3, 700, 244.5, 323.9, 397, 200, 244.5, 295.3, 700, 244.5],
                structure9: [323.9, 397, 200, 244.5, 295.3, 700, 244.5, 323.9, 397, 200, 244.5, 295.3],
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
                        this.currentWell.well_id).then((response) => {
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
            roundToTwo(num) {
                    return +(Math.round(num + "e+2")  + "e-2");
            }
        },
        watch: {
            currentWell: function (val) {
                this.getStructureByWell()
            }
        },
    }
</script>

<style scoped>
    .digitalDrillingWindow{
        overflow-x: scroll;
    }
    .row-structure{
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #34365D;
        min-height: 100%;
        min-width: 1500px;
    }
    .structure:first-child{
        flex: 0 0 calc(100% - 717px);
    }
    .structure:last-child{
        flex: 0 0 667px;
        height: 665px;
    }
    .structure-graph{
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>