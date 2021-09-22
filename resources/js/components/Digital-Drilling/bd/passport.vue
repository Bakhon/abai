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
                   <table class="table defaultTable">
                       <tbody>
                       <tr>
                           <th colspan="2">{{trans('digital_drilling.passport.drilling_summary')}}</th>
                       </tr>
                       <tr>
                           <td>{{trans('digital_drilling.passport.select_date')}}</td>
                           <td></td>
                       </tr>
                       </tbody>
                   </table>
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
                            <td class="w-default"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "passport",
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
                                name: 'digital_drilling.passport.well'
                            },
                            {
                                name: 'digital_drilling.passport.well_type'
                            },
                            {
                                name: 'digital_drilling.passport.field'
                            },
                            {
                                name: 'digital_drilling.passport.block'
                            },
                            {
                                name: 'digital_drilling.passport.horizon'
                            },
                            {
                                name: 'digital_drilling.passport.technical_structure'
                            },
                            {
                                name: 'digital_drilling.passport.organizational_structure'
                            },
                            {
                                name: 'digital_drilling.passport.well_zone'
                            },
                            {
                                name: 'digital_drilling.passport.wellhead_altitude'
                            },
                            {
                                name: 'digital_drilling.passport.X_coordinates_mouth'
                            },
                            {
                                name: 'digital_drilling.passport.Y_coordinates_mouth'
                            },
                            {
                                name: 'digital_drilling.passport.downhole_coordinates_X'
                            },
                            {
                                name: 'digital_drilling.passport.downhole_coordinates_Y'
                            },
                            {
                                name: 'digital_drilling.passport.designation_according_project'
                            },

                            {
                                name: 'digital_drilling.passport.category'
                            },
                            {
                                name: 'digital_drilling.passport.commissioning_date'
                            },
                            {
                                name: 'digital_drilling.daily_raport.drilling_contractor'
                            },
                            {
                                name: 'digital_drilling.passport.design_depth'
                            },
                            {
                                name: 'digital_drilling.passport.drainage_radius'
                            },
                            {
                                name: 'digital_drilling.passport.state'
                            },
                            {
                                name: 'digital_drilling.passport.method_operation'
                            },
                            {
                                name: 'digital_drilling.passport.Rpl_date_measurement'
                            },
                            {
                                name: 'digital_drilling.passport.Rzab_date_measurement'
                            },
                            {
                                name: 'digital_drilling.passport.fact_boggle_beat_date'
                            },
                            {
                                name: 'digital_drilling.passport.date_last_workover'
                            },
                            {
                                name: 'digital_drilling.passport.date_last_ORS'
                            },
                            {
                                name: 'digital_drilling.passport.date_last_GIS'
                            },
                            {
                                name: 'digital_drilling.passport.date_last_well_GDIS'
                            },
                        ]

                    }
                }
            }
        },
        mounted() {

        },
        methods:{

        },
        computed: {}

    }
</script>

<style scoped>
    .defaultTable tr td{
        width: 50%;
    }
    .rightTable{
        display: flex;
        flex-direction: column;
    }
    .table:last-child{
        flex: auto;
    }
</style>