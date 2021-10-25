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
                            <td class="w-default">{{getItem(td.item)}}</td>
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
                        child: []

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
                        this.currentWell.id).then((response) => {
                        let data = response.data;
                        console.log(data)
                        if (data) {
                            this.passportWell.all_info.child =  data.Общая_информация
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
            getItem(item){
                if (Array.isArray(item)){
                    return item.join(', ')
                } else{
                    return item
                }
            },
        },


    }
</script>

<style scoped>
    .defaultTable tr td{
        width: 50%;
        padding: 10px!important;
        line-height: 18px;
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