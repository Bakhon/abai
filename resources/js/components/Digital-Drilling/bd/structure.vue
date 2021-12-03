<template>
    <div class="digitalDrillingWindow defaultScroll">
       <div class="row-structure">
           <div class="structure ">
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
                  <structure-type :data="currentStructure.structure" :type="currentStructure.type" :unit="currentStructure.unit"/>
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
                currentStructure: {
                    structure: [],
                    unit: [],
                    type: 'type0'
                },
                structures: [],
                newStructures: [],
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
                structure1: [323.9, 397, 200, 244.5],
                structure2: [323.9, 397, 200, 244.5, 295.3, 700],
                structure3: [323.9, 397, 200, 244.5, 295.3, 700, 200, 323.9, 397, 200],
                structure4: [323, 397, 200, 244.5, 295.3, 700, 200.5, 323.9],
                structure5: [32.5, 397, 200, 244.5, 295.3, 700, 200.5, 323.9],
                structure6: [323.9, 397, 200, 244.5],
                structure7: [323.9, 397, 200, 244.5, 295.3, 700],
                structure8: [323.9, 397, 200, 244.5, 295.3, 700, 244.5, 323.9, 397, 200],
                structure9: [323.9, 397, 200, 244.5, 295.3, 700, 244.5, 323.9],
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
                            this.changeStructureType()
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
            },
            pushToArray(startIndex, lastIndex){
                let newP = this.structures.slice(startIndex, lastIndex)
                let descentDepth = 0
                for (let i = 0; i < newP.length; i++ ){
                    descentDepth += newP[i].Глубина_спуска
                }
                this.newStructures.push({
                    type: newP[0].Вид_колонны,
                    diameter: newP[0].Номинальный_диаметр,
                    diameterUnit: "мм.",
                    descentDepth: this.roundToTwo(descentDepth),
                    descentDepthUnit: 'м.'
                })
            },
            changeStructureType(){
                let typeOfPillar = this.structures[0].Вид_колонны
                let nominalDiameter = this.structures[0].Номинальный_диаметр
                let startIndex = 0
                for (let i=1; i<this.structures.length; i++){
                    if (this.structures[i].Номинальный_диаметр != nominalDiameter){
                            this.pushToArray(startIndex, i)
                            startIndex = i
                            typeOfPillar = this.structures[i].Вид_колонны
                            nominalDiameter = this.structures[i].Номинальный_диаметр
                    }
                    else if (this.structures[i].Вид_колонны != typeOfPillar) {
                        this.pushToArray(startIndex, i)
                        startIndex = i
                        typeOfPillar = this.structures[i].Вид_колонны
                        nominalDiameter = this.structures[i].Номинальный_диаметр
                    }
                }
                this.pushToArray(startIndex, this.structures.length)
                let directionPosition = -1
                for (let i=0; i<this.newStructures.length; i++){
                    if (this.newStructures[i].type == "Направление") {
                        directionPosition  = i
                    }
                }
                if (directionPosition!=-1 && directionPosition != 0){
                    for (let i=this.newStructures.length; i>0; i--){
                        if (i<=directionPosition){
                            this.array_move(i, i-1)
                        }
                    }
                }
                directionPosition=-1
                for (let i=0; i<this.newStructures.length; i++){
                    if (this.newStructures[i].type == "Хвостовик") {
                        directionPosition  = i
                    }
                }
                if (directionPosition!=-1 && directionPosition !=this.newStructures.length-1){
                    for (let i=0; i<this.newStructures.length -1; i++){
                        if (i>=directionPosition){
                            this.array_move(i, i+1)
                        }
                    }
                }
                let found = this.newStructures.some(el => el.type === "Хвостовик");

                let diameterCount = this.newStructures.length

                if (found){
                    diameterCount--
                }
                let currentType = 0
                for (let i=0; i<diameterCount; i++){
                    this.currentStructure.structure.push(this.newStructures[i].diameter)
                    this.currentStructure.structure.push(this.newStructures[i].descentDepth)
                    this.currentStructure.unit.push(this.newStructures[i].diameterUnit)
                    this.currentStructure.unit.push(this.newStructures[i].descentDepthUnit)
                }

                switch (diameterCount) {
                    case 2:
                        currentType = 1
                        break;
                    case 3:
                        currentType = 2
                        break;
                    case 4:
                        currentType = 4
                        break;
                    case 5:
                        currentType = 3
                        break;
                }

                if (found){
                    currentType += 5
                }
                this.currentStructure.type = "type" + currentType
            },
            array_move(old_index, new_index) {
                let arr = this.newStructures
                if (new_index >= arr.length) {
                    var k = new_index - arr.length + 1;
                    while (k--) {
                        arr.push(undefined);
                    }
                }
                arr.splice(new_index, 0, arr.splice(old_index, 1)[0]);
                return arr;
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
    .digitalDrillingWindow{
        overflow-x: scroll;
    }
    .row-structure{
        display: flex;
        background-color: #34365D;
        min-height: 100%;
        min-width: max-content;
    }
    .structure:first-child{
        max-width: calc(100% - 667px);
        overflow-x: scroll;
        overflow-y: hidden;
    }
    .structure:last-child{
        flex: 0 0 667px;
        height: 665px;
        margin: 15px;
    }
    .structure-graph{
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .table{
        max-width: 800px;
        height: 100% ;
    }
    .table td{
        padding: 10px 5px;
    }
</style>