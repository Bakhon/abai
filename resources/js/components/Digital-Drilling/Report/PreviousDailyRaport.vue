<template>
    <div>
        <div class="container-main">
            <div class="col-sm-12">
                <div class="daily_raport_block-header">
                    <div class="daily_raport_block-header-first">
                        <div class="daily_raport_block-header-input">
                            <label for="">{{trans('digital_drilling.daily_raport.date')}}</label>
                            <input type="text" disabled v-model="report.report_daily.date" />
                        </div>
                        <div class="daily_raport_block-header-input">
                            <label for="">{{trans('digital_drilling.daily_raport.report')}}</label>
                            <input type="text" disabled v-model="report.report_daily.report_num" />
                        </div>
                    </div>
                    <div class="daily_raport_block-header-center">
                        {{trans('digital_drilling.daily_raport.DAILY_DRILLING_REPORT')}}
                    </div>
                    <div class="daily_raport_block-header-save">
                        <button class="save" @click="back">
                            Текущий отчет
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="daily_raport_block">
                    <table class="tables table defaultTable">
                        <tbody>
                        <tr>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.unit_name')}}
                            </td>
                            <td colspan="2">
                               {{report.general_data_daily.rig.name_ru}}
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.drilling_mode')}}
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.indicators')}}
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.operator_company')}}
                            </td>
                            <td colspan="2" class="text-left">
                               {{report.contractor_daily.operator.name_ru}}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.drilling_rig_type')}}
                            </td>
                            <td colspan="2">
                                {{report.general_data_daily.rig_type.name_ru}}
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.bit_load')}}
                            </td>
                            <td colspan="2">
                                <input type="text" v-model="report.drilling_parameters_daily.wob">
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.drilling_contractor')}}
                            </td>
                            <td colspan="2">
                                {{report.contractor_daily.contractor.name_ru}}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.well')}}
                            </td>
                            <td colspan="2" class="text-left">
                                {{report.general_data_daily.well.uwi}}
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.rotation_speed')}}
                            </td>
                            <td colspan="2">
                                <input type="text" v-model="report.drilling_parameters_daily.rotation_speed">
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.drilling_start_date')}}
                            </td>
                            <td colspan="2">
                                <input type="text" v-model="report.contractor_daily.dbeg">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.field')}}
                            </td>
                            <td colspan="2" class="text-left">
                                {{report.general_data_daily.geo.name_ru}}
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.rotation_torque')}}
                            </td>
                            <td colspan="2">
                                <input type="text" v-model="report.drilling_parameters_daily.torque">
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.total_drilling_days')}}
                            </td>
                            <td colspan="2">
                                <input type="text" v-model="report.contractor_daily.total_drilling_days">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.project_depth')}}
                            </td>
                            <td colspan="2">
                                <input type="text" v-model="report.general_data_daily.project_md_tvd">
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.pump_capacity')}}
                            </td>
                            <td colspan="2">
                                <input type="text" v-model="report.drilling_parameters_daily.pump_eff">
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.air_temperature')}}
                            </td>
                            <td colspan="2">
                                <input type="text" v-model="report.contractor_daily.air_temp">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.previous_face')}}
                            </td>
                            <td colspan="2">
                                <input type="text" v-model="report.general_data_daily.previous_bhd">
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.riser_pressure')}}
                            </td>
                            <td colspan="2">
                                <input type="text" v-model="report.drilling_parameters_daily.p_standpipe">
                            </td>
                            <td colspan="2">

                            </td>
                            <td colspan="2">

                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.slaughter_at')}}
                            </td>
                            <td colspan="2">
                                <input type="text" v-model="report.general_data_daily.bhd_24">
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.hook_weight')}}
                            </td>
                            <td colspan="2">
                                <input type="text" v-model="report.drilling_parameters_daily.woh">
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.drilling_supervisor')}}
                            </td>
                            <td colspan="2">
                                <input type="text" v-model="report.contractor_daily.supervisor">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.daily_meterage')}}
                            </td>
                            <td colspan="2" class="text-left">
                                <span v-if="report.general_data_daily.bhd_24">{{report.general_data_daily.bhd_24 - report.general_data_daily.previous_bhd}}</span>
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.hook_weight_when_lifting')}}
                            </td>
                            <td colspan="2">
                                <input type="text" v-model="report.drilling_parameters_daily.woh_pooh">
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.drilling_foreman')}}
                            </td>
                            <td colspan="2">
                                <input type="text" v-model="report.contractor_daily.drilling_engineer">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.drilling_reaming_time')}}
                            </td>
                            <td colspan="2">
                                <input type="text" v-model="report.general_data_daily.drilling_progress">
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.hook_weight_when_descending')}}
                            </td>
                            <td colspan="2">
                                <input type="text" v-model="report.drilling_parameters_daily.woh_rih">
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.drilling_fluid_engineer')}}
                            </td>
                            <td colspan="2">
                                <input type="text" v-model="report.contractor_daily.drilling_mud_engineer">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="row tables">
                        <div class="col-sm-5 pr-0 pl-0">
                            <table class="table defaultTable border-top-0" >
                                <thead>
                                <tr>
                                    <th rowspan="2" colspan="2" class="align-middle">
                                        {{trans('digital_drilling.daily_raport.well_design')}}
                                    </th>
                                    <th colspan="2">
                                        {{trans('digital_drilling.daily_raport.design')}}
                                    </th>
                                    <th colspan="2">
                                        {{trans('digital_drilling.daily_raport.actual')}}
                                    </th>
                                </tr>
                                <tr>
                                    <th>{{trans('digital_drilling.daily_raport.vertically')}}</th>
                                    <th>{{trans('digital_drilling.daily_raport.trunk')}}</th>

                                    <th>{{trans('digital_drilling.daily_raport.vertically')}}</th>
                                    <th>{{trans('digital_drilling.daily_raport.trunk')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="wellConstr in report.well_constr_daily">
                                    <td colspan="2" class="w-10">
                                        {{wellConstr.constr_type.name_ru}}
                                    </td>
                                    <td><input type="text" v-model="wellConstr.project_tvd"></td>
                                    <td><input type="text" v-model="wellConstr.project_md"></td>
                                    <td><input type="text" v-model="wellConstr.fact_tvd"></td>
                                    <td><input type="text" v-model="wellConstr.fact_md"></td>
                                </tr>
                                </tbody>
                            </table>
                           <div class="row">
                               <div class="col-sm-6 pr-0">
                                   <table class="table defaultTable">
                                       <thead>
                                       <tr class="h-31">
                                           <th rowspan="2" colspan="2" class="w-50">
                                               {{trans('digital_drilling.daily_raport.rig_personnel')}}
                                           </th>
                                       </tr>
                                       </thead>
                                       <tbody>
                                       <tr v-for="dailyS in report.staff_daily">
                                           <td><input type="text" v-model="dailyS.name_ru"></td>
                                           <td><input type="text" v-model="dailyS.hours"></td>
                                       </tr>
                                       <tr>
                                           <td><input type="text"></td>
                                           <td><input type="text"></td>
                                       </tr>
                                       <tr>
                                           <td>Итого:</td>
                                           <td>{{getSum(report.staff_daily)}}</td>
                                       </tr>
                                       </tbody>
                                   </table>
                               </div>
                               <div class="col-sm-6 pl-0">
                                   <table class="table defaultTable">
                                       <thead>
                                       <tr class="h-31">
                                           <th rowspan="2" colspan="2" class="w-50">
                                               {{trans('digital_drilling.daily_raport.shift_of_watches')}}
                                           </th>
                                       </tr>
                                       </thead>
                                       <tbody>
                                       <tr>
                                           <td>{{trans('digital_drilling.daily_raport.arrived')}}</td>
                                           <td><input type="text" v-model="report.shifts_daily.arrived"></td>
                                       </tr>
                                       <tr>
                                           <td>{{trans('digital_drilling.daily_raport.deleted')}}</td>
                                           <td><input type="text" v-model="report.shifts_daily.departed"></td>
                                       </tr>
                                       <tr>
                                           <td>{{trans('digital_drilling.daily_raport.left')}}</td>
                                           <td><input type="text" v-model="report.shifts_daily.remain"></td>
                                       </tr>
                                       <tr v-for="i in 12">
                                           <td class="h-31"></td>
                                           <td class="h-31"></td>
                                       </tr>
                                       </tbody>
                                   </table>
                               </div>
                           </div>
                        </div>
                        <div class="col-sm-7 pl-0 pr-0">
                            <table class="table defaultTable ">
                                <thead>
                                <tr>
                                    <th colspan="4">
                                        {{trans('digital_drilling.daily_raport.production_time')}}
                                    </th>
                                    <th colspan="4">
                                        {{trans('digital_drilling.daily_raport.waste_of_non_productive')}}
                                    </th>
                                </tr>
                                <tr>
                                    <th>{{trans('digital_drilling.daily_raport.operations')}}</th>
                                    <th>{{trans('digital_drilling.daily_raport.previous')}}</th>
                                    <th>{{trans('digital_drilling.daily_raport.per_day')}}</th>
                                    <th>{{trans('digital_drilling.daily_raport.total')}}</th>

                                    <th>{{trans('digital_drilling.daily_raport.operations')}}</th>
                                    <th>{{trans('digital_drilling.daily_raport.previous')}}</th>
                                    <th>{{trans('digital_drilling.daily_raport.per_day')}}</th>
                                    <th>{{trans('digital_drilling.daily_raport.total')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="i in 17">
                                    <td class="w-15">
                                        {{report.prod_time_daily[i-1].operations_type.name_ru}}
                                    </td>
                                    <td>{{report.prod_time_daily[i-1].previous}}</td>
                                    <td><input type="text" v-model="report.prod_time_daily[i-1].daily"></td>
                                    <td>{{sumValues(report.prod_time_daily[i-1].previous, report.prod_time_daily[i-1].daily)}}</td>
                                    <td class="w-20">
                                        {{report.unprod_time_daily[i-1].operations_type.name_ru}}
                                    </td>
                                    <td>{{report.unprod_time_daily[i-1].previous}}</td>
                                    <td><input type="text" v-model="report.unprod_time_daily[i-1].daily"></td>
                                    <td>{{sumValues(report.unprod_time_daily[i-1].previous, report.unprod_time_daily[i-1].daily)}}</td>
                                </tr>
                                <tr class="h-31">
                                    <td colspan="3">
                                        {{trans('digital_drilling.daily_raport.total_production_time')}}
                                    </td>
                                    <td>
                                        {{getAllProdTime('')}}
                                    </td>
                                    <td colspan="3">
                                        {{trans('digital_drilling.daily_raport.total_non_productive_time')}}
                                    </td>
                                    <td>
                                        {{getAllProdTime('un')}}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <table class="tables table defaultTable">
                        <thead>
                        <tr>
                            <th colspan="11" class="align-middle title">
                                {{trans('digital_drilling.daily_raport.DESCRIPTION_OF_WORKS_PER_DAY')}}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="3">
                                {{trans('digital_drilling.daily_raport.time')}}
                            </td>
                            <td rowspan="2">
                                {{trans('digital_drilling.daily_raport.bid')}}
                            </td>
                            <td rowspan="2" colspan="2">
                                {{trans('digital_drilling.daily_raport.operation')}}
                            </td>
                            <td rowspan="2" colspan="4">
                                {{trans('digital_drilling.daily_raport.comment')}}
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('digital_drilling.daily_raport.from')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.to')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.all')}}</td>
                        </tr>
                        <tr>
                            <td>0:00</td>
                            <td>24:00</td>
                            <td>0:00</td>
                            <td></td>
                            <td>{{trans('digital_drilling.daily_raport.operation_code')}}</td>
                            <td class="w-40">
                                {{trans('digital_drilling.daily_raport.NOTE')}}
                            </td>
                            <td colspan="4" class="border-bottom-0 text-left">{{trans('digital_drilling.daily_raport.delivered')}}</td>
                        </tr>
                        <tr class="text-left">
                            <td >{{report.job_status_daily[0].tbeg}}</td>
                            <td >{{report.job_status_daily[0].tend}}</td>
                            <td >{{report.job_status_daily[0].total_time}}</td>
                            <td ><input type="text" v-model="report.job_status_daily[0].rate"></td>
                            <td >
                                {{report.job_status_daily[0].operation_code.name_ru}}
                            </td>
                            <td ><input type="text" v-model="report.job_status_daily[0].operations"></td>
                            <td rowspan="16" colspan="4" class="w-20 border-top-0"><textarea name="" id="" cols="30" rows="32" v-model="report.comments.comment"></textarea></td>
                        </tr>
                        <tr v-for="i in 15" class="text-left">
                            <td >{{report.job_status_daily[i].tbeg}}</td>
                            <td >{{report.job_status_daily[i].tend}}</td>
                            <td >{{report.job_status_daily[i].total_time}}</td>
                            <td ><input type="text" v-model="report.job_status_daily[i].rate"></td>
                            <td >
                                {{report.job_status_daily[i].operation_code.name_ru}}
                            </td>
                            <td ><input type="text" v-model="report.job_status_daily[i].operations"></td>
                        </tr>
                        <tr>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.TOTAL')}}</td>
                            <td>{{summTotalTime}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="w-5"></td>
                            <td class="w-5"></td>
                            <td class="w-5"></td>
                            <td class="w-5"></td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="tech-info-header title">
                        {{trans('digital_drilling.daily_raport.TECHNOLOGICAL_INFORMATION')}}
                    </div>
                    <div class="row">
                        <div class="col-sm-6 pr-0">
                            <table class="tables table defaultTable">
                                <thead>
                                    <th colspan="5">
                                        {{trans('digital_drilling.daily_raport.bit_information')}}
                                    </th>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{trans('digital_drilling.daily_raport.chisel')}}</td>
                                    <td  colspan="2">1</td>
                                    <td  colspan="2">2</td>
                                </tr>
                                <tr>
                                    <td>
                                        {{trans('digital_drilling.daily_raport.chisel_type')}}
                                    </td>
                                    <td colspan="2">
                                        {{report.bit_info_daily[1].bit_type.name_ru}}
                                    </td>
                                    <td colspan="2">
                                       {{report.bit_info_daily[1].bit_type.name_ru}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{trans('digital_drilling.daily_raport.IADC_code')}}
                                    </td>
                                    <td colspan="2">
                                        <input type="text" v-model="report.bit_info_daily[0].iadc">
                                    </td>
                                    <td colspan="2">
                                        <input type="text" v-model="report.bit_info_daily[1].iadc">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{trans('digital_drilling.daily_raport.manufacturer')}}
                                    </td>
                                    <td colspan="2">
                                        {{report.bit_info_daily[0].manufacturer.name_ru}}
                                    </td>
                                    <td colspan="2">
                                       {{report.bit_info_daily[1].manufacturer.name_ru}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{trans('digital_drilling.daily_raport.diameter')}}
                                    </td>
                                    <td colspan="2">
                                        {{report.bit_info_daily[0].diameter_type.diameter}}
                                    </td>
                                    <td colspan="2">
                                        {{report.bit_info_daily[1].diameter_type.diameter}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{trans('digital_drilling.daily_raport.serial_number')}}
                                    </td>
                                    <td colspan="2">
                                        <input type="text" v-model="report.bit_info_daily[0].serial">
                                    </td>
                                    <td colspan="2">
                                        <input type="text" v-model="report.bit_info_daily[1].serial">
                                    </td>
                                </tr>
                                <tr >
                                    <td>
                                        {{trans('digital_drilling.daily_raport.nozzles')}}
                                    </td>
                                    <td colspan="2" class="nozzles-td text-left">
                                        <span v-for="i in 7" class="mr-1" v-if="report.bit_info_daily[0].nozzle['nozzle_'+i]">
                                            {{report.bit_info_daily[0].nozzle['nozzle_'+i]}};
                                        </span>
                                    </td>
                                    <td colspan="2" class="nozzles-td text-left">
                                        <span v-for="i in 7" class="mr-1" v-if="report.bit_info_daily[1].nozzle['nozzle_'+i]">
                                            {{report.bit_info_daily[1].nozzle['nozzle_'+i]}};
                                        </span>
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        {{trans('digital_drilling.daily_raport.TFA_area')}}
                                    </td>
                                    <td colspan="2">
                                        <input type="text" v-model="report.bit_info_daily[0].tfa">
                                    </td>
                                    <td colspan="2">
                                        <input type="text" v-model="report.bit_info_daily[1].tfa">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{trans('digital_drilling.daily_raport.drilling_sm')}}
                                    </td>
                                    <td colspan="2">
                                        <input type="text" v-model="report.bit_info_daily[0].drilling_from">
                                    </td>
                                    <td colspan="2">
                                        <input type="text" v-model="report.bit_info_daily[1].drilling_from">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{trans('digital_drilling.daily_raport.to_m')}}
                                    </td>
                                    <td colspan="2">
                                        <input type="text" v-model="report.bit_info_daily[0].drilling_to">
                                    </td>
                                    <td colspan="2">
                                        <input type="text" v-model="report.bit_info_daily[1].drilling_to">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{trans('digital_drilling.daily_raport.driving_distance')}}
                                    </td>
                                    <td colspan="2" class="text-left">
                                        {{report.bit_info_daily[0].drilling_to - report.bit_info_daily[0].drilling_from}}
                                    </td>
                                    <td colspan="2" class="text-left">
                                        {{report.bit_info_daily[1].drilling_to - report.bit_info_daily[1].drilling_from}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{trans('digital_drilling.daily_raport.driving_beginning_interval')}}
                                    </td>
                                    <td colspan="2">
                                        <input type="text" v-model="report.bit_info_daily[0].interval_beg">
                                    </td>
                                    <td colspan="2">
                                        <input type="text" v-model="report.bit_info_daily[1].interval_beg">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{trans('digital_drilling.daily_raport.drilling_time_h')}}
                                    </td>
                                    <td colspan="2">
                                        <input type="text" v-model="report.bit_info_daily[0].drilling_time">
                                    </td>
                                    <td colspan="2">
                                        <input type="text" v-model="report.bit_info_daily[1].drilling_time">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{trans('digital_drilling.daily_raport.total_drilling_h')}}
                                    </td>
                                    <td colspan="2" class="text-left">
                                        {{report.bit_info_daily[0].overall_drilling_time}}
                                    </td>
                                    <td colspan="2" class="text-left">
                                        {{report.bit_info_daily[1].overall_drilling_time }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">
                                        {{trans('digital_drilling.daily_raport.bit_wear_according_IADC')}}
                                    </td>
                                    <td colspan="2" class="align-middle bit-ware">
                                        <div class="select__name">
                                            <div v-for="letter in bitWareLetters">{{letter}}</div>
                                        </div>
                                        <div class="selects">
                                            <div v-for="letter in bitWareLetters" >
                                                {{report.bit_info_daily[0].bit_cond_iadc[bit_cond_iadc_letter[letter]]}}
                                            </div>
                                        </div>
                                    </td>
                                    <td colspan="2" class="align-middle bit-ware">
                                        <div class="select__name">
                                            <div v-for="letter in bitWareLetters">{{letter}}</div>
                                        </div>
                                        <div class="selects">
                                            <div v-for="letter in bitWareLetters" >
                                                {{report.bit_info_daily[1].bit_cond_iadc[bit_cond_iadc_letter[letter]]}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text"></td>
                                    <td colspan="2"><input type="text"></td>
                                    <td colspan="2"><input type="text"></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="bg">{{trans('digital_drilling.daily_raport.solution_cleaning_system')}}</td>
                                </tr>
                                <tr>
                                    <td colspan="3">{{trans('digital_drilling.daily_raport.centrifuge_operating_hours')}}</td>
                                    <td colspan="2"><input type="text" v-model="report.mcs_daily.centrifuge"></td>
                                </tr>
                                <tr>
                                    <td colspan="3">{{trans('digital_drilling.daily_raport.operating_hours_vibrating_sieve')}} №1</td>
                                    <td colspan="2"><input type="text" v-model="report.mcs_daily.vibrating_sieve1"></td>
                                </tr>
                                <tr>
                                    <td colspan="3">{{trans('digital_drilling.daily_raport.operating_hours_vibrating_sieve')}} №2</td>
                                    <td colspan="2"><input type="text" v-model="report.mcs_daily.vibrating_sieve2"></td>
                                </tr>
                                <tr>
                                    <td colspan="3">{{trans('digital_drilling.daily_raport.operating_hours_vibrating_sieve')}} №3</td>
                                    <td colspan="2"><input type="text" v-model="report.mcs_daily.vibrating_sieve3"></td>
                                </tr>
                                <tr>
                                    <td colspan="3">{{trans('digital_drilling.daily_raport.sand_separator_work_hour')}}</td>
                                    <td colspan="2"><input type="text" v-model="report.mcs_daily.sand_operator"></td>
                                </tr>
                                <tr>
                                    <td colspan="3">{{trans('digital_drilling.daily_raport.sludge_separator_work_hour')}}</td>
                                    <td colspan="2"><input type="text" v-model="report.mcs_daily.silt_separator"></td>
                                </tr>
                                <tr>
                                    <td colspan="3">{{trans('digital_drilling.daily_raport.dispenser_hour')}}</td>
                                    <td colspan="2"><input type="text" v-model="report.mcs_daily.degasser"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-6 pl-0">
                            <table class="tables table defaultTable">
                                <thead>
                                <th colspan="6">
                                    {{trans('digital_drilling.daily_raport.bit_information')}}
                                </th>
                                </thead>
                                <tbody>
                                <tr class="h-31">
                                    <td colspan="6">{{trans('digital_drilling.daily_raport.descent_tool_characteristic')}}</td>
                                </tr>
                                <tr class="h-31">
                                    <td>
                                        {{trans('digital_drilling.daily_raport.BHA_elements')}}
                                    </td>
                                    <td>
                                        {{trans('digital_drilling.daily_raport.outside_mm')}}
                                    </td>
                                    <td>
                                        {{trans('digital_drilling.daily_raport.inside_mm')}}
                                    </td>
                                    <td>
                                        {{trans('digital_drilling.daily_raport.thread_type')}}
                                    </td>
                                    <td >
                                        {{trans('digital_drilling.daily_raport.length')}}
                                    </td>
                                    <td>
                                        {{trans('digital_drilling.daily_raport.growth_length')}}
                                    </td>
                                </tr>
                                <tr v-for="(bha, i) in report.bha_daily" class="h-31">
                                    <td>
                                       {{bha.bha_elements_type.name_ru}}
                                    </td>
                                    <td>
                                        <input type="text" v-model="bha.outside_d">
                                    </td>
                                    <td>
                                        <input type="text" v-model="bha.inside_d">
                                    </td>
                                    <td>
                                       {{bha.screw_size.name_ru}}
                                    </td>
                                    <td >
                                        <input type="text" v-model="bha.length">
                                    </td>
                                    <td colspan="2">
                                        <input type="text" v-model="bha.increasing_length">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">{{trans('digital_drilling.daily_raport.BHA_length')}}</td>
                                    <td colspan="2">{{sumBHA()}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <table class="tables table defaultTable">
                        <thead>
                        <tr>
                            <th colspan="19">
                                {{trans('digital_drilling.daily_raport.removal_solid_liquid_phase')}}
                            </th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{trans('digital_drilling.daily_raport.name')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.ED')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.flights')}}</td>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.previous')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.per_day')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.total')}}</td>
                            <td colspan="12" class="text-left">
                                {{trans('digital_drilling.daily_raport.HSE_status')}}
                            </td>

                        </tr>
                        <tr>
                            <td><input type="text" v-model="report.slt_daily[0].name_type"></td>
                            <td><input type="text" v-model="report.slt_daily[0].unit"></td>
                            <td><input type="text" v-model="report.slt_daily[0].trip"></td>
                            <td colspan="2"><input type="text" v-model="report.slt_daily[0].previous"></td>
                            <td><input type="text" v-model="report.slt_daily[0].daily"></td>
                            <td><input type="text" v-model="report.slt_daily[0].overall"></td>
                            <td colspan="12" class="border-bottom-0 text-left align-bottom">{{trans('digital_drilling.daily_raport.application_required')}}</td>

                        </tr>
                        <tr>
                            <td><input type="text" v-model="report.slt_daily[1].name_type"></td>
                            <td><input type="text" v-model="report.slt_daily[1].unit"></td>
                            <td><input type="text" v-model="report.slt_daily[1].trip"></td>
                            <td colspan="2"><input type="text" v-model="report.slt_daily[1].previous"></td>
                            <td><input type="text" v-model="report.slt_daily[1].daily"></td>
                            <td><input type="text" v-model="report.slt_daily[1].overall"></td>
                            <td rowspan="3" colspan="12" class="border-top-0">
                                <textarea name=""  cols="30" rows="10" v-model="report.oztok_daily.request"></textarea>
                            </td>
                        </tr>
                        <tr v-for="i in 2">
                            <td><input type="text" v-model="report.slt_daily[i+1].name_type"></td>
                            <td><input type="text" v-model="report.slt_daily[i+1].unit"></td>
                            <td><input type="text" v-model="report.slt_daily[i+1].trip"></td>
                            <td colspan="2"><input type="text" v-model="report.slt_daily[i+1].previous"></td>
                            <td><input type="text" v-model="report.slt_daily[i+1].daily"></td>
                            <td><input type="text" v-model="report.slt_daily[i+1].overall"></td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="tables table defaultTable">
                        <thead>
                        <tr>
                            <th colspan="5">
                                {{trans('digital_drilling.daily_raport.well_control')}}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="4" class="w-50">{{trans('digital_drilling.daily_raport.last_column_diameter')}}</td>
                            <td class="w-50">
                                {{report.well_parameters_daily.last_casing_dia.diameter}}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                {{trans('digital_drilling.daily_raport.depth_descent_last')}}
                            </td>
                            <td>
                                <input type="text" v-model="report.well_parameters_daily.last_casing_dep">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                {{trans('digital_drilling.daily_raport.diameter_next_column')}}
                            </td>
                            <td>
                                {{report.well_parameters_daily.next_casing_dia.diameter}}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                {{trans('digital_drilling.daily_raport.depth_descent_next_column')}}
                            </td>
                            <td>
                                <input type="text" v-model="report.well_parameters_daily.next_casing_dep">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                {{trans('digital_drilling.daily_raport.reservoir_integrity_test')}}
                            </td>
                            <td>
                                <input type="text" v-model="report.well_parameters_daily.form_integr_test">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                {{trans('digital_drilling.daily_raport.equivalent_drill_density')}}
                            </td>
                            <td>
                                <input type="text" v-model="report.well_parameters_daily.equiv_mud_den">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                {{trans('digital_drilling.daily_raport.drilling_fluid_density')}} <sup>3</sup>
                            </td>
                            <td>
                                <input type="text" v-model="report.well_parameters_daily.test_mud_den">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                {{trans('digital_drilling.daily_raport.drill_volume_solution')}} <sup>3</sup>
                            </td>
                            <td>
                                <input type="text" v-model="report.well_parameters_daily.hole_mud_vol">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                {{trans('digital_drilling.daily_raport.drill_volume_solution_in_reception')}} <sup>3</sup>
                            </td>
                            <td>
                                <input type="text" v-model="report.well_parameters_daily.surf_mud_vol">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                {{trans('digital_drilling.daily_raport.drill_volume_solution_in_stock')}} <sup>3</sup>
                            </td>
                            <td>
                                <input type="text" v-model="report.well_parameters_daily.extra_mud_vol">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">{{trans('digital_drilling.daily_raport.pump_2_ty6L3NB_1_300D')}} №1</td>
                            <td colspan="2">
                               {{report.pump_daily[0].pump_type.name_ru}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{trans('digital_drilling.daily_raport.bushings_mm')}}
                            </td>
                            <td>
                                {{report.pump_daily[0].pump_barrel_type.name_ru}}
                            </td>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.liter_stroke')}}</td>
                            <td>
                                <input type="text" v-model="report.pump_daily[0].liters_type">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{trans('digital_drilling.daily_raport.coef_floor')}}
                            </td>
                            <td><input type="text"  v-model="report.pump_daily[0].coeff_type"></td>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.density_g_cm')}} <sup>3</sup></td>
                            <td>
                                <input type="text" v-model="report.pump_daily[0].liquid_dens">
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="5"><input type="text">{{trans('digital_drilling.daily_raport.pumping_pressure')}}</td>
                            <td><input type="text">{{trans('digital_drilling.daily_raport.stroke_min')}}</td>
                            <td><input type="text">{{trans('digital_drilling.daily_raport.depth_m')}}</td>
                            <td><input type="text">{{trans('digital_drilling.daily_raport.pressure_atm')}}</td>
                            <td></td>
                        </tr>
                        <tr v-for="pressure in report.pump_daily[0].pumping_pressure">
                            <td><input type="text" v-model="pressure.progress"></td>
                            <td><input type="text"  v-model="pressure.depth"></td>
                            <td><input type="text"  v-model="pressure.pressure"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="3">{{trans('digital_drilling.daily_raport.pump_2_ty6L3NB_1_300D')}} №2</td>
                            <td colspan="2">
                               {{report.pump_daily[1].pump_type.name_ru}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{trans('digital_drilling.daily_raport.bushings_mm')}}
                            </td>
                            <td>
                               {{report.pump_daily[1].pump_barrel_type.name_ru}}
                            </td>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.liter_stroke')}}</td>
                            <td>
                                <input type="text" v-model="report.pump_daily[1].liters_type">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{trans('digital_drilling.daily_raport.coef_floor')}}
                            </td>
                            <td><input type="text"  v-model="report.pump_daily[1].coeff_type"></td>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.density_g_cm')}} <sup>3</sup></td>
                            <td>
                                <input type="text" v-model="report.pump_daily[1].liquid_dens">
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="5"><input type="text">{{trans('digital_drilling.daily_raport.pumping_pressure')}}</td>
                            <td><input type="text">{{trans('digital_drilling.daily_raport.stroke_min')}}</td>
                            <td><input type="text">{{trans('digital_drilling.daily_raport.depth_m')}}</td>
                            <td><input type="text">{{trans('digital_drilling.daily_raport.pressure_atm')}}</td>
                            <td></td>
                        </tr>
                        <tr v-for="pressure in report.pump_daily[1].pumping_pressure">
                            <td><input type="text" v-model="pressure.progress"></td>
                            <td><input type="text"  v-model="pressure.depth"></td>
                            <td><input type="text"  v-model="pressure.pressure"></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="pump">
                        <tbody>
                        <tr>
                            <td colspan="3">{{trans('digital_drilling.daily_raport.pump_2_ty6L3NB_1_300D')}} №3</td>
                            <td colspan="2">
                               {{report.pump_daily[2].pump_type.name_ru}}
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('digital_drilling.daily_raport.bushings_mm')}}</td>
                            <td>
                                {{report.pump_daily[2].pump_barrel_type.name_ru}}
                            </td>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.liter_stroke')}}</td>
                            <td><input type="text" v-model="report.pump_daily[2].liters_type"></td>
                        </tr>
                        <tr>
                            <td>
                                {{trans('digital_drilling.daily_raport.coef_floor')}}
                            </td>
                            <td><input type="text"  v-model="report.pump_daily[2].coeff_type"></td>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.density_g_cm')}} <sup>3</sup></td>
                            <td>
                                <input type="text" v-model="report.pump_daily[2].liquid_dens">
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="5"><input type="text">{{trans('digital_drilling.daily_raport.pumping_pressure')}}</td>
                            <td><input type="text">{{trans('digital_drilling.daily_raport.stroke_min')}}</td>
                            <td><input type="text">{{trans('digital_drilling.daily_raport.depth_m')}}</td>
                            <td><input type="text">{{trans('digital_drilling.daily_raport.pressure_atm')}}</td>
                            <td></td>
                        </tr>
                        <tr v-for="pressure in report.pump_daily[2].pumping_pressure">
                            <td><input type="text" v-model="pressure.progress"></td>
                            <td><input type="text"  v-model="pressure.depth"></td>
                            <td><input type="text"  v-model="pressure.pressure"></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="pump">
                        <tbody>
                        <tr>
                            <td colspan="3">{{trans('digital_drilling.daily_raport.pump_2_ty6L3NB_1_300D')}} №4</td>
                            <td colspan="2">
                               {{report.pump_daily[3].pump_type.name_ru}}
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('digital_drilling.daily_raport.bushings_mm')}}</td>
                            <td>
                                {{report.pump_daily[3].pump_barrel_type.name_ru}}
                            </td>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.liter_stroke')}}</td>
                            <td><input type="text" v-model="report.pump_daily[3].liters_type"></td>
                        </tr>
                        <tr>
                            <td>
                                {{trans('digital_drilling.daily_raport.coef_floor')}}
                            </td>
                            <td><input type="text"  v-model="report.pump_daily[3].coeff_type"></td>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.density_g_cm')}} <sup>3</sup></td>
                            <td>
                                <input type="text" v-model="report.pump_daily[3].liquid_dens">
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="5"><input type="text">{{trans('digital_drilling.daily_raport.pumping_pressure')}}</td>
                            <td><input type="text">{{trans('digital_drilling.daily_raport.stroke_min')}}</td>
                            <td><input type="text">{{trans('digital_drilling.daily_raport.depth_m')}}</td>
                            <td><input type="text">{{trans('digital_drilling.daily_raport.pressure_atm')}}</td>
                            <td></td>
                        </tr>
                        <tr v-for="pressure in report.pump_daily[3].pumping_pressure">
                            <td><input type="text" v-model="pressure.progress"></td>
                            <td><input type="text"  v-model="pressure.depth"></td>
                            <td><input type="text"  v-model="pressure.pressure"></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="tables table defaultTable">
                        <thead>
                        <tr>
                            <th colspan="7" lass="title">{{trans('digital_drilling.daily_raport.INFORMATION_AT_06')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="3">{{trans('digital_drilling.daily_raport.time')}}</td>
                            <td rowspan="2" class="align-middle">{{trans('digital_drilling.daily_raport.bid')}}</td>
                            <td rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.daily_raport.operation')}}</td>
                            <td rowspan="2" class="align-middle">{{trans('digital_drilling.daily_raport.planned_work_next_day')}}</td>
                        </tr>
                        <tr>
                            <td>{{trans('digital_drilling.daily_raport.from')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.to')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.all')}}</td>
                        </tr>
                        <tr>
                            <td>0:00</td>
                            <td>6:00</td>
                            <td>6:00</td>
                            <td><input type="text"></td>
                            <td>{{trans('digital_drilling.daily_raport.operation_code')}}</td>
                            <td>
                                {{trans('digital_drilling.daily_raport.Note_complete_analysis')}}
                            </td>
                            <td rowspan="12">
                                <textarea name=""  cols="30" rows="22" v-model="report.planned_work.planned_work"></textarea>
                            </td>
                        </tr>
                        <tr v-for="(job_status, i) in report.job_status_6_hours" class="text-left">
                            <td>{{job_status.tbeg}}</td>
                            <td>{{job_status.tend}}</td>
                            <td>{{job_status.total_time}}</td>
                            <td><input type="text" v-model="job_status.rate"></td>
                            <td>
                               {{job_status.operation_code.name_ru}}
                            </td>
                            <td><input type="text" v-model="job_status.operations"></td>
                        </tr>
                        </tbody>
                    </table>
                    <br>
                    <table class="tables table defaultTable">
                        <thead>
                        <tr>
                            <th rowspan="2" colspan="22" class="align-middle">
                                {{trans('digital_drilling.daily_raport.TECHNICAL_PARAMETERS')}}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="22">
                                {{trans('digital_drilling.daily_raport.drilling_mud_parameters')}}
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="2" colspan="4" class="align-middle">
                                {{trans('digital_drilling.daily_raport.drilling_mud_type')}}
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.dense_inlet')}} <sup>2</sup>
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.dense_outlet')}} <sup>2</sup>
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.viscosity_sec')}}
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.plastic_viscosity')}}
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.DNS_IB')}}
                            </td>
                            <td colspan="2">
                                pH
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.water_loss')}}
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.coef_crust_friction')}}
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.T_in_out')}}
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('digital_drilling.project')}}</td>
                            <td>{{trans('digital_drilling.fact')}}</td>
                            <td>{{trans('digital_drilling.project')}}</td>
                            <td>{{trans('digital_drilling.fact')}}</td>
                            <td>{{trans('digital_drilling.project')}}</td>
                            <td>{{trans('digital_drilling.fact')}}</td>
                            <td>{{trans('digital_drilling.project')}}</td>
                            <td>{{trans('digital_drilling.fact')}}</td>
                            <td>{{trans('digital_drilling.project')}}</td>
                            <td>{{trans('digital_drilling.fact')}}</td>
                            <td>{{trans('digital_drilling.project')}}</td>
                            <td>{{trans('digital_drilling.fact')}}</td>
                            <td>{{trans('digital_drilling.project')}}</td>
                            <td>{{trans('digital_drilling.fact')}}</td>
                            <td>{{trans('digital_drilling.project')}}</td>
                            <td>{{trans('digital_drilling.fact')}}</td>
                            <td>{{trans('digital_drilling.project')}}</td>
                            <td>{{trans('digital_drilling.fact')}}</td>
                        </tr>
                        <tr v-for="(mud, i) in report.drilling_mud_daily">
                            <td colspan="4" class="w-10" >
                                {{mud.mud_type.name_ru}}
                            </td>
                           <td><input type="text" v-model="mud.project_inlet_density"></td>
                           <td><input type="text" v-model="mud.fact_inlet_density"></td>
                           <td><input type="text" v-model="mud.project_outlet_density"></td>
                           <td><input type="text" v-model="mud.fact_outlet_density"></td>
                           <td><input type="text" v-model="mud.project_viscosity"></td>
                           <td><input type="text" v-model="mud.fact_viscosity"></td>
                           <td><input type="text" v-model="mud.project_plastic_viscosity"></td>
                           <td><input type="text" v-model="mud.fact_plastic_viscosity"></td>
                           <td><input type="text" v-model="mud.project_dynamic_shear_stress"></td>
                           <td><input type="text" v-model="mud.fact_dynamic_shear_stress"></td>
                           <td><input type="text" v-model="mud.project_ph"></td>
                           <td><input type="text" v-model="mud.fact_ph"></td>
                           <td><input type="text" v-model="mud.project_fluid_loss"></td>
                           <td><input type="text" v-model="mud.fact_fluid_loss"></td>
                           <td><input type="text" v-model="mud.project_friction_coefficient"></td>
                           <td><input type="text" v-model="mud.fact_friction_coefficient"></td>
                           <td><input type="text" v-model="mud.project_t_in_out"></td>
                           <td><input type="text" v-model="mud.fact_t_in_out"></td>
                        </tr>
                        <tr>
                            <td rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.daily_raport.content_solid_phase')}}</td>
                            <td rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.daily_raport.sand_content')}}</td>
                            <td rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.daily_raport.MVT')}}</td>
                            <td rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.daily_raport.water_content')}}</td>
                            <td rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.daily_raport.lubricant_content_solution')}}</td>
                            <td colspan="4">CHC lb/100ft2</td>
                            <td rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.daily_raport.crust')}}</td>
                            <td rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.daily_raport.total_hardness')}}</td>
                            <td colspan="4">{{trans('digital_drilling.daily_raport.concentration')}}</td>
                        </tr>
                        <tr>
                            <td colspan="2">10 {{trans('digital_drilling.daily_raport.sec')}}</td>
                            <td colspan="2">10 {{trans('digital_drilling.daily_raport.min')}}</td>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.ci_mg')}}</td>
                            <td colspan="2">Kcl - %</td>
                        </tr>
                        <tr>
                            <td>{{trans('digital_drilling.project')}}</td>
                            <td>{{trans('digital_drilling.fact')}}</td>
                            <td>{{trans('digital_drilling.project')}}</td>
                            <td>{{trans('digital_drilling.fact')}}</td>
                            <td>{{trans('digital_drilling.project')}}</td>
                            <td>{{trans('digital_drilling.fact')}}</td>
                            <td>{{trans('digital_drilling.project')}}</td>
                            <td>{{trans('digital_drilling.fact')}}</td>
                            <td>{{trans('digital_drilling.project')}}</td>
                            <td>{{trans('digital_drilling.fact')}}</td>
                            <td>{{trans('digital_drilling.project')}}</td>
                            <td>{{trans('digital_drilling.fact')}}</td>
                            <td>{{trans('digital_drilling.project')}}</td>
                            <td>{{trans('digital_drilling.fact')}}</td>
                            <td>{{trans('digital_drilling.project')}}</td>
                            <td>{{trans('digital_drilling.fact')}}</td>
                            <td>{{trans('digital_drilling.project')}}</td>
                            <td>{{trans('digital_drilling.fact')}}</td>
                            <td>{{trans('digital_drilling.project')}}</td>
                            <td>{{trans('digital_drilling.fact')}}</td>
                            <td>{{trans('digital_drilling.project')}}</td>
                            <td>{{trans('digital_drilling.fact')}}</td>
                        </tr>
                        <tr v-for="mud in report.drilling_mud_daily">
                            <td><input type="text" v-model="mud.project_total_solids"></td>
                            <td><input type="text" v-model="mud.fact_total_solids"></td>
                            <td><input type="text" v-model="mud.project_total_sand"></td>
                            <td><input type="text" v-model="mud.fact_total_sand"></td>
                            <td><input type="text" v-model="mud.project_mbt"></td>
                            <td><input type="text" v-model="mud.fact_mbt"></td>
                            <td><input type="text" v-model="mud.project_water_content"></td>
                            <td><input type="text" v-model="mud.fact_water_content"></td>
                            <td><input type="text" v-model="mud.project_lube_content"></td>
                            <td><input type="text" v-model="mud.fact_lube_content"></td>
                            <td><input type="text" v-model="mud.project_static_shear_stress_10sec"></td>
                            <td><input type="text" v-model="mud.fact_static_shear_stress_10sec"></td>
                            <td><input type="text" v-model="mud.project_static_shear_stress_10min"></td>
                            <td><input type="text" v-model="mud.fact_static_shear_stress_10min"></td>
                            <td><input type="text" v-model="mud.project_filter_cake"></td>
                            <td><input type="text" v-model="mud.fact_filter_cake"></td>
                            <td><input type="text" v-model="mud.project_total_hardness"></td>
                            <td><input type="text" v-model="mud.fact_total_hardness"></td>
                            <td><input type="text" v-model="mud.project_concentration_cl"></td>
                            <td><input type="text" v-model="mud.fact_concentration_cl"></td>
                            <td><input type="text" v-model="mud.project_concentration_kcl"></td>
                            <td><input type="text" v-model="mud.fact_concentration_kcl"></td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="tables table defaultTable">
                        <thead>
                        <tr>
                            <th colspan="11" class="title">{{trans('digital_drilling.daily_raport.component_composition_drilling_mud')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{trans('digital_drilling.daily_raport.name_chemicals')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.assigning_material')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.unit_measurement')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.density_material')}} <sup>3</sup></td>
                            <td>{{trans('digital_drilling.daily_raport.mass_consumption')}} <sup>3</sup></td>
                            <td>{{trans('digital_drilling.daily_raport.availability_rig')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.receiving_per_day')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.consumption_per_day')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.remaining_rig')}}</td>
                        </tr>
                        <tr v-for="(compositionDaily, i) in report.drilling_mud_composition_daily">
                            <td>
                               {{compositionDaily.mud_composition.name_ru}}
                            </td>
                            <td><input type="text" v-model="compositionDaily.functions"></td>
                            <td><input type="text" v-model="compositionDaily.metrics"></td>
                            <td><input type="text" v-model="compositionDaily.density"></td>
                            <td><input type="text" v-model="compositionDaily.total_consumption"></td>
                            <td>{{compositionDaily.availability}}</td>
                            <td><input type="number" v-model="compositionDaily.received_day"></td>
                            <td><input type="number" v-model="compositionDaily.consumption_day"></td>
                            <td>{{subtractValues(sumValues(compositionDaily.availability, compositionDaily.received_day), compositionDaily.consumption_day)}}</td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="tables table defaultTable">
                        <thead>
                        <tr>
                            <th colspan="5" class="title">{{trans('digital_drilling.daily_raport.consumption_tooling_materials')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="w-20">{{trans('digital_drilling.daily_raport.name_materials')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.before')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.coming')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.consumption')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.total_balance')}}</td>
                        </tr>

                        <tr v-for="(consDaily, i) in report.material_cons_daily">
                            <td><input type="text" v-model="consDaily.name"></td>
                            <td>{{consDaily.last}}</td>
                            <td><input type="number" v-model="consDaily.receipts"></td>
                            <td><input type="number" v-model="consDaily.consumption"></td>
                            <td>{{subtractValues(sumValues(consDaily.last, consDaily.receipts), consDaily.consumption)}}</td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="tables table defaultTable">
                        <thead>
                        <tr>
                            <th colspan="7" class="title">{{trans('digital_drilling.daily_raport.GEOLOGICAL_INFORMATION')}}</th>
                            <th colspan="5" class="title">{{trans('digital_drilling.daily_raport.CORE_COLLECTION')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td rowspan="2" class="align-middle">{{trans('digital_drilling.daily_raport.stratigraphy')}}</td>
                            <td colspan="3">{{trans('digital_drilling.daily_raport.roof')}}</td>
                            <td rowspan="2" class="align-middle">{{trans('digital_drilling.daily_raport.lithology')}}</td>
                            <td rowspan="2" class="align-middle">
                                {{trans('digital_drilling.daily_raport.gradient_plas')}}
                                <sup>2</sup>
                                {{trans('digital_drilling.daily_raport.na_m')}}
                            </td>
                            <td rowspan="2" class="align-middle">
                                {{trans('digital_drilling.daily_raport.gradient_GRP')}}
                                <sup>2</sup>
                                {{trans('digital_drilling.daily_raport.na_m')}}
                            </td>
                            <td rowspan="2">{{trans('digital_drilling.daily_raport.old')}}</td>
                            <td rowspan="2">{{trans('digital_drilling.daily_raport.sampling_interval')}}</td>
                            <td rowspan="2">{{trans('digital_drilling.daily_raport.plan')}}</td>
                            <td rowspan="2">{{trans('digital_drilling.daily_raport.fact_m')}}</td>
                            <td rowspan="2">{{trans('digital_drilling.daily_raport.takeaway')}}</td>
                        </tr>
                        <tr>
                            <td>{{trans('digital_drilling.daily_raport.plan')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.fact_m')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.powerful')}}</td>
                        </tr>
                        <tr v-for="(geological, i) in report.geo_data_daily">
                            <td>
                               {{geological.stratigraphy.name_ru}}
                            </td>
                            <td><input type="text" v-model="geological.plan_top_of_formation"></td>
                            <td><input type="text" v-model="geological.fact_top_of_formation"></td>
                            <td><input type="text" v-model="geological.thickness_top_of_formation"></td>
                            <td>
                               {{geological.lithology.name_ru}}
                            </td>
                            <td><input type="text" v-model="geological.formation_pressure_gradient"></td>
                            <td><input type="text" v-model="geological.frac_gradient"></td>
                            <td><input type="text" v-model="report.coring_daily[i].age"></td>
                            <td><input type="text" v-model="report.coring_daily[i].interval"></td>
                            <td><input type="text" v-model="report.coring_daily[i].plan"></td>
                            <td><input type="text" v-model="report.coring_daily[i].fact"></td>
                            <td><input type="text" v-model="report.coring_daily[i].percentage"></td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="tables table defaultTable">
                        <thead>
                        <tr>
                            <th colspan="4" class="title">{{trans('digital_drilling.daily_raport.INCLINOMETRY')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{trans('digital_drilling.daily_raport.depth_m')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.angle')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.azimuth')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.type_instrument')}}</td>
                        </tr>
                        <tr v-for="(incl, i) in report.incl_daily">
                            <td><input type="text" v-model="incl.depth"></td>
                            <td><input type="text" v-model="incl.angle"></td>
                            <td><input type="text" v-model="incl.bearing"></td>
                            <td>
                                {{incl.equip_type.name_ru}}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="tables table defaultTable">
                        <thead>
                        <tr>
                            <th colspan="9" class="title">{{trans('digital_drilling.daily_raport.SAFETY')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{trans('digital_drilling.daily_raport.fire_alarm')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.Uch_H2S_alarm')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.TB_briefing')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.GNVP_at_STR')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.anti_aircraft_defense')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.fukts_air_defense_check')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.alarm_GNVP')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.per_honey_help')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.TB_meeting')}}</td>
                        </tr>
                        <tr>
                            <td>{{report.safety_daily.fire_alarm}}</td>
                            <td>{{report.safety_daily.h2s_test}}</td>
                            <td>{{report.safety_daily.instructions}}</td>
                            <td>{{report.safety_daily.ogws_trip}}</td>
                            <td>{{report.safety_daily.bop_p_test}}</td>
                            <td>{{report.safety_daily.bop_func_test}}</td>
                            <td>{{report.safety_daily.ogws_alarm}}</td>
                            <td>{{report.safety_daily.first_aid}}</td>
                            <td>{{report.safety_daily.safety_meeting}}</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="decryption-block">
                        <div class="decryption-title">
                            *** {{trans('digital_drilling.daily_raport.explanation_abbreviation')}} :
                        </div>
                        <div class="decryption-content">
                            <div class="decryption-content-left">
                                <p>{{trans('digital_drilling.daily_raport.ea_bo')}}</p>
                                <p>{{trans('digital_drilling.daily_raport.ea_pvo')}}</p>
                                <p>{{trans('digital_drilling.daily_raport.ea_ou')}}</p>
                                <p>{{trans('digital_drilling.daily_raport.ea_umk')}}</p>
                                <p>{{trans('digital_drilling.daily_raport.ea_akb')}}</p>
                                <p>{{trans('digital_drilling.daily_raport.ea_bus')}}</p>
                                <p>{{trans('digital_drilling.daily_raport.ea_bn')}}</p>
                                <p>{{trans('digital_drilling.daily_raport.ea_ubt')}}</p>
                                <p>{{trans('digital_drilling.daily_raport.ea_cbt')}}</p>
                                <p>{{trans('digital_drilling.daily_raport.ea_tbt')}}</p>
                                <p>{{trans('digital_drilling.daily_raport.ea_gbya')}}</p>
                            </div>
                            <div class="decryption-content-right">
                                <p>{{trans('digital_drilling.daily_raport.ea_kubt')}}</p>
                                <p>{{trans('digital_drilling.daily_raport.ea_ksh')}}</p>
                                <p>{{trans('digital_drilling.daily_raport.ea_bd')}}</p>
                                <p>{{trans('digital_drilling.daily_raport.ea_bcp')}}</p>
                                <p>{{trans('digital_drilling.daily_raport.ea_bd_bg')}}</p>
                                <p>{{trans('digital_drilling.daily_raport.ea_pug')}}</p>
                                <p>{{trans('digital_drilling.daily_raport.ea_ppg')}}</p>
                                <p>{{trans('digital_drilling.daily_raport.ea_bpr')}}</p>
                                <p>{{trans('digital_drilling.daily_raport.ea_obr')}}</p>
                                <p>{{trans('digital_drilling.daily_raport.ea_vpub')}}</p>
                                <p>{{trans('digital_drilling.daily_raport.ea_sn')}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SelectInput from '../components/SelectInput'
    import SelectAdd from '../components/SelectAdd'
    import NozzlesTable from '../components/NozzlesTable'
    import componentComposition from '../core/componentComposition'
    import geologicalInformation from '../core/geologicalInformation'
    import threadTypesJson from '../core/threadType'
    import inclino from '../core/inclino'
    import mudDaily from '../core/drillingmudDaily'
    import moment from "moment";

    export default {
        name: "DailyRaport",
        props: ['report'],
        data(){
            return{
                bitWareLetters: ["I", "O", "D", "L", "B", "G", "D1", "R"],
                bit_cond_iadc_letter: {
                    I: 'inner_rows',
                    O: 'outer_rows',
                    D: 'dull_characteristics',
                    L: 'location',
                    B: 'bearing_seals',
                    G: 'gauge',
                    D1: 'other_dull_characteristics',
                    R: 'reason_for_pulling_bit',

                },
                summTotalTime: '00:00',
            }
        },
        mounted(){
            this.changeTotalTime(24)
            this.changeTotalTime(6)
            var inputs = document.getElementsByTagName("INPUT");
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].disabled = true;
            }
        },
        methods:{
            back(){
                this.$emit('closePreviousReport')
            },
            sumValues(a, b){
                if (!a){
                    a = 0
                }
                if (!b){
                    b = 0
                }
                if (!a && !b){
                    return ''
                }
                return parseInt(a) + parseInt(b)
            },
            subtractValues(a, b){
                if (!a){
                    a = 0
                }
                if (!b){
                    b = 0
                }
                if (!a && !b){
                    return ''
                }
                return parseInt(a) - parseInt(b)
            },
            getAllProdTime(type){
                let arr = []
                if(type=='un'){
                    arr = this.report.unprod_time_daily
                }else{
                    arr = this.report.prod_time_daily
                }
                let sum = 0
                for (let i=0; i<arr.length; i++){
                    if (arr[i].previous && arr[i].daily) {
                        sum += parseInt(arr[i].previous) + parseInt(arr[i].daily)
                    }
                }
                return sum
            },
            changeTotalTime(type){
                let arr = []
                if (type == 24){
                    arr = this.report.job_status_daily
                }else{
                    arr = this.report.job_status_6_hours
                }
                for (let i=0; i<arr.length; i++){
                    this.getTotalTime(i, type)
                }
            },
            getTotalTime(i, type){

                let arr = []
                if (type == 24){
                    arr = this.report.job_status_daily
                }else{
                    arr = this.report.job_status_6_hours
                }
                if (arr[i].tbeg && arr[i].tend) {
                    let startTime = arr[i].tbeg;
                    let endTime = arr[i].tend;

                    let todayDate = moment(new Date()).format("MM-DD-YYYY");

                    let startDate = new Date(`${todayDate} ${startTime}`);
                    let endDate = new Date(`${todayDate } ${endTime}`);
                    let timeDiff = Math.abs(startDate.getTime() - endDate.getTime());

                    let hh = Math.floor(timeDiff / 1000 / 60 / 60);
                    hh = ('0' + hh).slice(-2)

                    timeDiff -= hh * 1000 * 60 * 60;
                    let mm = Math.floor(timeDiff / 1000 / 60);
                    mm = ('0' + mm).slice(-2)

                    arr[i].total_time = hh + ":" + mm
                    if (startDate > endDate) {
                        if (mm == '00'){
                            arr[i].total_time = (24-hh)  + ":" + mm
                        } else{
                            arr[i].total_time = (23-hh)  + ":" + (60-mm)
                        }
                    }
                    if(type == 24){
                        this.getAllTotalTime()
                    }

                }
            },
            getAllTotalTime(){
                let sum = '00:00:00'
                for (let i=0; i<this.report.job_status_daily.length; i++){
                    if (this.report.job_status_daily[i].total_time){
                        let time = this.report.job_status_daily[i].total_time + ':00'
                        sum = this.formatTime(this.timestrToSec(sum) + this.timestrToSec(time));
                    }
                }
                this.summTotalTime = sum.slice(0, -3);
            },
            timestrToSec(timestr) {
                let parts = timestr.split(":");
                return (parts[0] * 3600) +
                    (parts[1] * 60) +
                    (+parts[2]);
            },

            pad(num) {
                if(num < 10) {
                    return "0" + num;
                } else {
                    return "" + num;
                }
            },
            formatTime(seconds) {
                return [this.pad(Math.floor(seconds/3600)),
                    this.pad(Math.floor(seconds/60)%60),
                    this.pad(seconds%60),
                ].join(":");
            },
            getSum(arr){
                let sum = 0
                for (let i=0; i<arr.length; i++){
                    if (arr[i].hours) {
                        sum += parseInt(arr[i].hours)
                    }
                }
                return sum
            },
            sumBHA(){
                let arr = this.report.bha_daily
                for (let i=arr.length-1; i>=0; i--){
                    if (arr[i].increasing_length) {
                        return parseInt(arr[i].increasing_length)
                    }
                }
            },
        }

    }
</script>

<style scoped>
    .tables{
        overflow: unset!important;
    }
    .nozzles-td-row{
        display: flex;
        align-items: center;
    }
    .nozzles{
        width: 80px;
        display: flex;
        align-items: center;
        height: 40px!important;
        margin-left: 8px;
    }
    .select__name{
        height: 28px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #454d7d;
        padding: 2px 2px 0;
        border-radius: 5px;
        color: #000000;
    }
    .select__name div{
        text-align: left;
        padding: 5px;
    }
    .bit-ware .selects{
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #454d7d;
        border-radius: 5px;
        margin-top: 2px;
    }
    .selects div{
       padding: 5px;
    }

.pump td{
    width: 7.35%!important
}
.pump td:last-child input{
    width: 106px!important;
}
.pump td:first-child input{
    width: 610px!important;
}
.add{
    cursor: pointer;
    padding: 5px;
    margin-left: 20px;
    font-size: 25px;
    background-color: #0b2a52
}
.add:hover{
    opacity: 0.5;
}
    .save{
        border: 0;
        background: #2E50E9;
        border-radius: 6px;
        font-weight: 600;
        font-size: 12px;
        line-height: 14px;
        text-align: center;

        color: #FFFFFF;
        width: 170px;
        padding: 8px;

    }
    .characteristic__modal, .catalog-add{
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        z-index: 20000;
        background: rgba(0, 0, 0, 0.5);
    }
    .catalog-add-inner{
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .catalog-add-form{
        min-width: 300px;
        width: max-content;
        min-height: 200px;
        height: auto;
        background: #272953;
        border: 2px solid #656A8A;
        border-radius: 8px;
        padding: 20px 14px;
    }
    .catalog-add-header{
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 30px;
        font-weight: bold;
        font-size: 18px;
        line-height: 22px;
        color: #FFFFFF;
    }
    .catalog-add-title{
    }
    .catalog-add-close{
        flex: 0 0 90px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #656A8A;
        border-radius: 6px;
        font-size: 16px;
        line-height: 19px;
        cursor: pointer;
    }
    .catalog-add-content input{
        display: block;
        width: 100%;
        margin-bottom: 30px;
        background: #1F2142;
        border: 1px solid #454FA1;
        border-radius: 4px;
        padding: 7px;
    }
    .catalog-add-content input.error{
        border-color: red;
    }
    .catalog-add-content input:focus{
        outline: none;
    }
    .catalog-add-content button{
        background: rgba(46, 80, 233, 0.5);
        border: 0;
        margin: 0 auto;
        display: block;
        padding: 8px 40px;
        border-radius: 6px;
    }
    .characteristic_content{
        max-width: 600px;
        margin: 60px auto;
        height: 80vh;
        background: #272953;
        box-shadow: 0px 7px 7px rgba(0, 0, 0, 0.25);
        border-radius: 10px;
        padding: 15px;
    }
    .characteristic__modal.graph .characteristic_content,
    .characteristic__modal.scheme .characteristic_content{
        max-width: 90%;
        width: 90%;
        height: auto;
    }
    .characteristic_content .characteristic_body{
        margin-top: 15px;
        height: calc(100% - 100px);
        overflow-y: scroll;
        overflow-x: hidden;
    }
    .characteristic_header{
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .characteristic_header span{
        font-family: Harmonia Sans Pro Cyr;
        font-style: normal;
        font-weight: bold;
        font-size: 16px;
        line-height: 19px;

        color: #FFFFFF;
    }
    .characteristic_header-close{
        background: #656A8A;
        border-radius: 10px;
        padding:0 15px;
        font-weight: bold;
        font-size: 16px;
        height: 26px;
        cursor: pointer;
    }

    .ml-10{
        padding: 0 10px 0 18px!important;
    }
    .rigs__content{
        background-color: #272953;
        width: 100%;
        height: 675px;
        padding: 0 4px 0;
        position: relative;
        overflow-x: hidden;
        overflow-y: scroll;

    }
    .characteristic_body-save{
        display: flex;
        justify-content: center;
        margin: 15px;
    }
    .characteristic_body-save button{
        background: #333975;
        border-radius: 6px;
        border: 0;
        font-weight: 600;
        font-size: 12px;
        line-height: 14px;
        text-align: center;

        color: #FFFFFF;
        padding: 8px 35px;
        margin: 0 auto;
    }
    .characteristic_body-save button:hover,
    .characteristic_body-save button:focus{
        background: #2E50E9;
    }
    .modalTable td{
        padding: 15px!important;
    }
    .characteristic__modal td input{
        background: inherit;
        border: 0;
        width: 100%;
        height: 100%;
    }
    .characteristic__modal td input:focus{
        outline: none;
    }
    .characteristic__modal td{
        padding: 5px!important;
    }
    .characteristic{
        background: #205AA3;
        border: 0.5px solid #454FA1;
        box-shadow: 0px 4px 3px rgba(0, 0, 0, 0.25);
        border-radius: 10px;
        padding: 5px;
        display: flex;
        align-items: center;
        margin: 0 auto;
    }

    .characteristic img{
        margin-left: 5px;
    }
    .error{
        border: 1px solid red!important;
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    td.h-31, .h-31 td{
        height: 31px!important;
    }
    .delete-row{
        cursor: pointer;
        width: 10px;
    }
</style>