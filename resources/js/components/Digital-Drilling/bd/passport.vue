<template>
    <div class="digitalDrillingWindow">
        <div class="row">
            <div class="col-sm-4 pr-0 rightTable">
               <div class="table">
                   <table class="table defaultTable">
                       <tbody>
                       <tr>
                           <th colspan="2">{{trans(passportWell.plan.name)}}</th>
                       </tr>
                       <tr v-for="td in passportWell.plan.child">
                           <td>{{trans(td.name)}}</td>
                           <td></td>
                       </tr>
                       </tbody>
                   </table>
               </div>
               <div class="table">
                   <table class="table defaultTable">
                       <tbody>
                       <tr>
                           <th colspan="2">{{trans(passportWell.contract.name)}}</th>
                       </tr>
                       <tr v-for="td in passportWell.contract.child">
                           <td>{{trans(td.name)}}</td>
                           <td></td>
                       </tr>
                       </tbody>
                   </table>
               </div>
               <div class="table">
                   <table class="table defaultTable mb-0">
                       <tbody>
                       <tr>
                           <th colspan="2">{{trans('digital_drilling.passport.drilling_summary')}}</th>
                       </tr>
                       </tbody>
                   </table>
                   <div class="date-picker">
                       <span>{{trans('digital_drilling.passport.select_date')}}</span>
                       <date-picker />
                   </div>
               </div>
            </div>
            <div class="col-sm-8 leftTable">
                <div class="table">
                    <table class="table defaultTable">
                        <tbody>
                        <tr>
                            <th colspan="3">{{trans(passportWell.all_info.name)}}</th>
                        </tr>
                        <tr v-for="(td, index) in passportWell.all_info.child">
                            <td class="w-23 text-center">{{index+1}}</td>
                            <td class="pl-30 w-40">{{trans(td.name)}}</td>
                            <td class="w-default">{{td.value}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import  DatePicker from '../components/DatePicker'
    import {digitalDrillingState, globalloadingMutations} from '@store/helpers';

    export default {
        name: "passport",
        components:{
            DatePicker
        },
        data() {
            return{
                passportWell: {
                   plan:  {
                        name: "digital_drilling.passport.drilling_plan",
                        child: [
                            {
                                name: 'digital_drilling.passport.drilling_start_date'
                            },
                            {
                                name: 'digital_drilling.passport.drilling_end_date'
                            },
                        ]

                    },
                    contract:  {
                        name: "digital_drilling.passport.contract",
                        child: [
                            {
                                name: 'digital_drilling.passport.contractor'
                            },
                            {
                                name: 'digital_drilling.passport.contract_number'
                            },
                            {
                                name: 'digital_drilling.passport.contract_date'
                            },
                            {
                                name: 'digital_drilling.passport.contract_amount'
                            },
                        ]

                    },
                    summary:  {
                        name: "digital_drilling.passport.drilling_summary",
                        child: [
                            {
                                name: 'digital_drilling.passport.drilling_start'
                            },
                            {
                                name: 'digital_drilling.passport.drilling_end'
                            },
                            {
                                name: 'digital_drilling.passport.total_penetration'
                            },
                        ]

                    },
                    casing_information:  {
                        name: "digital_drilling.passport.production_casing_information",
                        child: [
                            {
                                name: 'digital_drilling.passport.column_diameter'
                            },
                            {
                                name: 'digital_drilling.passport.descent_depth'
                            }
                        ]

                    },
                    all_info:  {
                        name: "digital_drilling.passport.general_information",
                        child: [
                            {
                                name: 'digital_drilling.passport.well',
                                value: ''
                            },
                            {
                                name: 'digital_drilling.passport.well_type',
                                value: ''
                            },
                            {
                                name: 'digital_drilling.passport.field',
                                value: ''
                            },
                            {
                                name: 'digital_drilling.passport.block',
                                value: ''
                            },
                            {
                                name: 'digital_drilling.passport.horizon',
                                value: ''
                            },
                            {
                                name: 'digital_drilling.passport.technical_structure',
                                value: ''
                            },
                            {
                                name: 'digital_drilling.passport.organizational_structure',
                                value: ''
                            },
                            {
                                name: 'digital_drilling.passport.well_zone',
                                value: ''
                            },
                            {
                                name: 'digital_drilling.passport.wellhead_altitude',
                                value: ''
                            },
                            {
                                name: 'digital_drilling.passport.X_coordinates_mouth',
                                value: ''
                            },
                            {
                                name: 'digital_drilling.passport.Y_coordinates_mouth',
                                value: ''
                            },
                            {
                                name: 'digital_drilling.passport.downhole_coordinates_X',
                                value: ''
                            },
                            {
                                name: 'digital_drilling.passport.downhole_coordinates_Y',
                                value: ''
                            },
                            {
                                name: 'digital_drilling.passport.designation_according_project',
                                value: ''
                            },

                            {
                                name: 'digital_drilling.passport.category',
                                value: ''
                            },
                            {
                                name: 'digital_drilling.passport.commissioning_date',
                                value: ''
                            },
                            {
                                name: 'digital_drilling.daily_raport.drilling_contractor',
                                value: ''
                            },
                            {
                                name: 'digital_drilling.passport.design_depth',
                                value: ''
                            },
                            {
                                name: 'digital_drilling.passport.drainage_radius',
                                value: ''
                            },
                            {
                                name: 'digital_drilling.passport.state',
                                value: ''
                            },
                            {
                                name: 'digital_drilling.passport.method_operation',
                                value: ''
                            },
                            {
                                name: 'digital_drilling.passport.Rpl_date_measurement',
                                value: ''
                            },
                            {
                                name: 'digital_drilling.passport.Rzab_date_measurement',
                                value: ''
                            },
                            {
                                name: 'digital_drilling.passport.date_last_ORS',
                                value: ''
                            },
                            {
                                name: 'digital_drilling.passport.date_last_GIS',
                                value: ''
                            },
                            {
                                name: 'digital_drilling.passport.date_last_well_GDIS',
                                value: ''
                            },
                        ]

                    }
                },
                passport: {},
            }
        },
        computed: {
            ...digitalDrillingState([
                'currentWell'
            ]),
        },
        mounted() {
            this.getPassportByWell()
        },
        watch: {
            currentWell: function (val) {
                this.getPassportByWell()
            }
        },
        methods:{
            ...globalloadingMutations([
                'SET_LOADING'
            ]),
            async getPassportByWell(){
                this.SET_LOADING(true);
                try{
                    await this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/api/passport/'+
                        this.currentWell[this.currentWell.length-1].id).then((response) => {
                        let data = response.data;
                        if (data) {
                            this.passport = data.Общая_информация[0];
                            this.passportWell.all_info.child[0].value =  this.passport.Скважина
                            this.passportWell.all_info.child[1].value =  this.passport.Вид
                            this.passportWell.all_info.child[2].value =  this.passport.Месторождение
                            this.passportWell.all_info.child[3].value =  this.passport.Блок
                            this.passportWell.all_info.child[4].value =  this.passport.Горизонт.join(', ')
                            this.passportWell.all_info.child[5].value =  this.passport.Тех_структура
                            this.passportWell.all_info.child[6].value =  this.passport.Орг_струтура.join(', ')
                            this.passportWell.all_info.child[7].value =  this.passport.Зона
                            this.passportWell.all_info.child[8].value =  this.passport.Альтитуда
                            this.passportWell.all_info.child[9].value =  this.passport.Коор_Х_устья
                            this.passportWell.all_info.child[10].value =  this.passport.Коор_У_устья
                            this.passportWell.all_info.child[11].value =  this.passport.Коор_Х_заб
                            this.passportWell.all_info.child[12].value =  this.passport.Коор_У_заб
                            this.passportWell.all_info.child[13].value =  this.passport.Назначение_скважины
                            this.passportWell.all_info.child[14].value =  this.passport.Категория
                            this.passportWell.all_info.child[15].value =  this.passport.Экспл_дата
                            this.passportWell.all_info.child[16].value =  this.passport.Подрядчик
                            this.passportWell.all_info.child[17].value =  this.passport.Пр_глуб
                            this.passportWell.all_info.child[18].value =  this.passport.Радиус
                            this.passportWell.all_info.child[19].value =  this.passport.Состояние
                            this.passportWell.all_info.child[20].value =  this.passport.Экспл
                            this.passportWell.all_info.child[21].value =  this.passport.Факт_заб
                            this.passportWell.all_info.child[22].value =  this.passport.КРС
                            this.passportWell.all_info.child[23].value =  this.passport.ПРС
                            this.passportWell.all_info.child[24].value =  this.passport.ГИС
                            this.passportWell.all_info.child[25].value =  this.passport.ГДИС
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


    }
</script>

<style scoped>
    .defaultTable tr td{
        width: 50%;
    }
    .date-picker{
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 14px 9px;
        border: 1px solid #545580;

    }
    .rightTable{
        display: flex;
        flex-direction: column;
    }
    .table:last-child{
        flex: auto;
    }
</style>