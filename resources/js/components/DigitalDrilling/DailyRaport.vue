<template>
    <div class="container-main">
        <div class="col-sm-12">
            <div class="daily_raport_block">
                <table class="tables table defaultTable">
                    <thead>
                        <tr>
                            <th rowspan="3" colspan="10" class="align-middle text-center border-right-0 title">
                                {{trans('digital_drilling.daily_raport.DAILY_DRILLING_REPORT')}}
                            </th>
                            <th class="text-right border-left-0 border-right-0 border-bottom-0">{{trans('digital_drilling.daily_raport.date')}}</th>
                            <th><input type="text"></th>
                        </tr>
                        <tr>
                            <th class="text-right border-0">{{trans('digital_drilling.daily_raport.report')}} №</th>
                            <th><input type="text"></th>
                        </tr>
                        <tr>
                            <th class="text-right border-0">{{trans('digital_drilling.daily_raport.page')}}</th>
                            <th><input type="text"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.unit_name')}}
                            </td>
                            <td colspan="2">
                                <select-input :options="unitNames"/>
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
                            <td colspan="2">
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.drilling_rig_type')}}
                            </td>
                            <td colspan="2">
                                <select name="" id="">
                                    <option value="" v-for="rig in drillingRigTypes">{{rig}}</option>
                                </select>
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.bit_load')}}
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.drilling_contractor')}}
                            </td>
                            <td colspan="2">
                                <select-input :options="drillingContractors"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.well')}}
                            </td>
                            <td colspan="2">
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.rotation_speed')}}
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.drilling_start_date')}}
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.field')}}
                            </td>
                            <td colspan="2">
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.rotation_torque')}}
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.total_drilling_days')}}
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.project_depth')}}
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.pump_capacity')}}
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.air_temperature')}}
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.previous_face')}}
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.riser_pressure')}}
                            </td>
                            <td colspan="2">
                                <input type="text">
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
                                <input type="text">
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.hook_weight')}}
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">

                            </td>
                            <td colspan="2">

                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.daily_meterage')}}
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.hook_weight_when_lifting')}}
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.supervisor')}}
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.drilling_reaming_time')}}
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.hook_weight_when_descending')}}
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.drilling_foreman')}}
                            </td>
                            <td colspan="2">
                                <input type="text">
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
                                <tr>
                                    <td colspan="2" class="w-10">
                                        <select name="" id="">
                                            <option value="">Test</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="w-10">
                                        <select name="" id="">
                                            <option value="">Test</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="w-10">
                                        <select name="" id="">
                                            <option value="">Test</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="w-10">
                                        <select name="" id="">
                                            <option value="">Test</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="w-10">
                                        <select name="" id="">
                                            <option value="">Test</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table defaultTable  border-top-0">
                            <thead>
                                <tr class="h-31">
                                    <th rowspan="2" colspan="2" class="w-50">
                                        {{trans('digital_drilling.daily_raport.rig_personnel')}}
                                    </th>
                                    <th rowspan="2" colspan="2">
                                        {{trans('digital_drilling.daily_raport.shift_of_watches')}}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="w-40"><input type="text"></td>
                                    <td class="w-10"><input type="text"></td>
                                    <td class="w-25">{{trans('digital_drilling.daily_raport.arrived')}}</td>
                                    <td class="w-25"><input type="text"></td>
                                </tr>
                                <tr>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td>{{trans('digital_drilling.daily_raport.deleted')}}</td>
                                    <td><input type="text"></td>
                                </tr>
                                <tr>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td>{{trans('digital_drilling.daily_raport.left')}}</td>
                                    <td><input type="text"></td>
                                </tr>
                                <tr v-for="i in 10">
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="text-right">Итого:</td>
                                    <td><input type="text"></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
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
                                <tr v-for="i in 19">
                                    <td class="w-15">
                                        <select-input :options="operation1"/>
                                    </td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td class="w-20">
                                        <select-input :options="operation2"/>
                                    </td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                </tr>
                                <tr class="h-31">
                                    <td colspan="3">
                                        {{trans('digital_drilling.daily_raport.total_production_time')}}
                                    </td>
                                    <td>
                                        0,00
                                    </td>
                                    <td colspan="3">
                                        {{trans('digital_drilling.daily_raport.total_non_productive_time')}}
                                    </td>
                                    <td>
                                        0,00
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
                        <tr>
                            <td ><input type="text"></td>
                            <td ><input type="text"></td>
                            <td ><input type="text"></td>
                            <td ><input type="text"></td>
                            <td >
                                <select name="" id="">
                                    <option value=""v-for="code in operationCodes">{{code}}</option>
                                </select>
                            </td>
                            <td ><input type="text"></td>
                            <td rowspan="16" colspan="4" class="w-20 border-top-0"><textarea name="" id="" cols="30" rows="32"></textarea></td>
                        </tr>
                        <tr v-for="i in 15">
                            <td ><input type="text"></td>
                            <td ><input type="text"></td>
                            <td ><input type="text"></td>
                            <td ><input type="text"></td>
                            <td >
                                <select name="" id="">
                                    <option value="" v-for="code in operationCodes">{{code}}</option>
                                </select>
                            </td>
                            <td ><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.TOTAL')}}</td>
                            <td >24:00</td>
                            <td ><input type="text"></td>
                            <td ><select name="" id="">
                                <option value=""v-for="code in operationCodes">{{code}}</option>
                            </select></td>
                            <td ><input type="text"></td>
                            <td class="w-5"></td>
                            <td class="w-5"></td>
                            <td class="w-5"></td>
                            <td class="w-5"></td>
                        </tr>
                    </tbody>
                </table>
                <table class="tables table defaultTable">
                    <thead>
                        <tr>
                            <th colspan="19" class="title">
                                {{trans('digital_drilling.daily_raport.TECHNOLOGICAL_INFORMATION')}}
                            </th>
                        </tr>
                        <tr>
                            <th colspan="5">
                                {{trans('digital_drilling.daily_raport.bit_information')}}
                            </th>
                            <th colspan="9">
                                {{trans('digital_drilling.daily_raport.BHA_well')}}
                            </th>
                            <th colspan="5">
                                {{trans('digital_drilling.daily_raport.well_control')}}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{trans('digital_drilling.daily_raport.chisel')}}</td>
                            <td  colspan="2">1</td>
                            <td  colspan="2">2</td>

                            <td colspan="9">{{trans('digital_drilling.daily_raport.descent_tool_characteristic')}}</td>
                            <td colspan="4" class="w-20">{{trans('digital_drilling.daily_raport.last_column_diameter')}}</td>
                            <td class="w-7">
                                <select-input :options="diameters"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{trans('digital_drilling.daily_raport.chisel_type')}}
                            </td>
                            <td colspan="2">
                                <select-input :options="bitTypes" />
                            </td>
                            <td colspan="2">
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.BHA_elements')}}
                            </td>
                            <td>
                                {{trans('digital_drilling.daily_raport.outside_mm')}}
                            </td>
                            <td>
                                {{trans('digital_drilling.daily_raport.inside_mm')}}
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.thread_type')}}
                            </td>
                            <td >
                                {{trans('digital_drilling.daily_raport.length')}}
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.growth_length')}}
                            </td>
                            <td colspan="4">
                                {{trans('digital_drilling.daily_raport.depth_descent_last')}}
                            </td>
                            <td>
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{trans('digital_drilling.daily_raport.IADC_code')}}
                            </td>
                            <td colspan="2">
                                <select-input :options="[]"/>
                            </td>
                            <td colspan="2">
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <select-input :options="threadTypes" />
                            </td>
                            <td >
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="4">
                                {{trans('digital_drilling.daily_raport.diameter_next_column')}}
                            </td>
                            <td>
                                <select-input :options="diameters"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{trans('digital_drilling.daily_raport.manufacturer')}}
                            </td>
                            <td colspan="2">
                               <select-input :options="manufacturers"/>
                            </td>
                            <td colspan="2">
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <select-input :options="threadTypes" />
                            </td>
                            <td >
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="4">
                                {{trans('digital_drilling.daily_raport.depth_descent_next_column')}}
                            </td>
                            <td>
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{trans('digital_drilling.daily_raport.diameter')}}
                            </td>
                            <td colspan="2">
                               <select-input :options="bitDiameters"/>
                            </td>
                            <td colspan="2">
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <select-input :options="threadTypes" />
                            </td>
                            <td >
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="4">
                                {{trans('digital_drilling.daily_raport.reservoir_integrity_test')}}
                            </td>
                            <td>
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{trans('digital_drilling.daily_raport.serial_number')}}
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <select-input :options="threadTypes" />
                            </td>
                            <td >
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="4">
                                {{trans('digital_drilling.daily_raport.equivalent_drill_density')}}
                            </td>
                            <td>
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{trans('digital_drilling.daily_raport.nozzles')}}
                            </td>
                            <td colspan="2" class="nozzles-td">
                                <div class="nozzles">
                                    <nozzles-table :table="Nozzles" />
                                    <nozzles-table :table="Nozzles" />
                                    <nozzles-table :table="Nozzles" />
                                    <nozzles-table :table="Nozzles" />
                                    <nozzles-table :table="Nozzles" />
                                    <nozzles-table :table="Nozzles" />
                                    <nozzles-table :table="Nozzles" />
                                </div>
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <select-input :options="threadTypes" />
                            </td>
                            <td >
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="4">
                                {{trans('digital_drilling.daily_raport.drilling_fluid_density')}}
                            </td>
                            <td>
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{trans('digital_drilling.daily_raport.TFA_area')}}
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <select-input :options="threadTypes" />
                            </td>
                            <td >
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="4">
                                {{trans('digital_drilling.daily_raport.date_of_last_test_PVO')}}
                            </td>
                            <td>
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{trans('digital_drilling.daily_raport.drilling_sm')}}
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <select-input :options="threadTypes" />
                            </td>
                            <td >
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="4">
                                {{trans('digital_drilling.daily_raport.drill_volume_solution')}}
                            </td>
                            <td>
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{trans('digital_drilling.daily_raport.to_m')}}
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <select-input :options="threadTypes" />
                            </td>
                            <td >
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="4">
                                {{trans('digital_drilling.daily_raport.drill_volume_solution_in_reception')}}
                            </td>
                            <td>
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{trans('digital_drilling.daily_raport.driving_distance')}}
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <select-input :options="threadTypes" />
                            </td>
                            <td >
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="4">
                                {{trans('digital_drilling.daily_raport.drill_volume_solution_in_stock')}}
                            </td>
                            <td>
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{trans('digital_drilling.daily_raport.driving_beginning_interval')}}
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <select-input :options="threadTypes" />
                            </td>
                            <td >
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="4">
                                {{trans('digital_drilling.daily_raport.density_drills_solution_stock')}}
                            </td>
                            <td>
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{trans('digital_drilling.daily_raport.drilling_time_h')}}
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <select-input :options="threadTypes" />
                            </td>

                            <td >
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="3">{{trans('digital_drilling.daily_raport.pump_2_ty6L3NB_1_300D')}} №1</td>
                            <td colspan="2">
                                <select name="" id="">
                                    <option value="" v-for="pump in pumps">{{pump}}</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{trans('digital_drilling.daily_raport.total_drilling_h')}}
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <select-input :options="threadTypes" />
                            </td>
                            <td >
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                {{trans('digital_drilling.daily_raport.bushings_mm')}}
                            </td>
                            <td>
                                <select-input :options="bushings"/>
                            </td>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.liter_stroke')}}</td>
                            <td>
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="2" class="align-middle">
                                {{trans('digital_drilling.daily_raport.bit_wear_according_IADC')}}
                            </td>
                            <td rowspan="2" colspan="2" class="align-middle bit-ware">
                                <div class="select__name">
                                    <div>I</div>
                                    <div>O</div>
                                    <div>D</div>
                                    <div>L</div>
                                    <div>B</div>
                                    <div>G</div>
                                    <div>D</div>
                                    <div>R</div>
                                </div>
                                <div class="selects">
                                    <select name="" id="">
                                        <option value="" v-for="opt in bitWare.I">{{opt}}</option>
                                    </select>
                                    <select name="" id="">
                                        <option value="" v-for="opt in bitWare.O">{{opt}}</option>
                                    </select>
                                    <select name="" id="">
                                        <option value="" v-for="opt in bitWare.D">{{opt}}</option>
                                    </select>
                                    <select name="" id="">
                                        <option value="" v-for="opt in bitWare.L">{{opt}}</option>
                                    </select>
                                    <select name="" id="">
                                        <option value="" v-for="opt in bitWare.B">{{opt}}</option>
                                    </select>
                                    <select name="" id="">
                                        <option value="" v-for="opt in bitWare.G">{{opt}}</option>
                                    </select>
                                    <select name="" id="">
                                        <option value="" v-for="opt in bitWare.D">{{opt}}</option>
                                    </select>
                                    <select name="" id="">
                                        <option value="" v-for="opt in bitWare.R">{{opt}}</option>
                                    </select>
                                </div>
                            </td>
                            <td rowspan="2" colspan="2" class="align-middle">
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <select-input :options="threadTypes" />
                            </td>
                            <td >
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                Коэф. напол-я
                            </td>
                            <td><input type="text"></td>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.density_g_cm')}}</td>
                            <td>
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2">
                                <select-input :options="threadTypes" />
                            </td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td rowspan="6"><input type="text">{{trans('digital_drilling.daily_raport.pumping_pressure')}}</td>
                            <td><input type="text">{{trans('digital_drilling.daily_raport.stroke_min')}}</td>
                            <td><input type="text">{{trans('digital_drilling.daily_raport.depth_m')}}</td>
                            <td><input type="text">{{trans('digital_drilling.daily_raport.pressure_atm')}}</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2">
                                <select-input :options="threadTypes" />
                            </td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>

                            <td colspan="7">{{trans('digital_drilling.daily_raport.BHA_length')}}</td>

                            <td colspan="2">0,00</td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2">0,00</td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="5" class="bg">{{trans('digital_drilling.daily_raport.solution_cleaning_system')}}</td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="3">{{trans('digital_drilling.daily_raport.centrifuge_operating_hours')}}</td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="7">{{trans('digital_drilling.daily_raport.total_length_drill_string')}} </td>
                            <td colspan="2">0,00</td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="3">{{trans('digital_drilling.daily_raport.operating_hours_vibrating_sieve')}} №1</td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="3">
                                {{trans('digital_drilling.daily_raport.pump_2_ty6L3NB_1_300D')}} №2
                            </td>
                            <td colspan="2">
                                <select name="" id="">
                                    <option value="" v-for="pump in pumps">{{pump}}</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">{{trans('digital_drilling.daily_raport.operating_hours_vibrating_sieve')}} №2</td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td>{{trans('digital_drilling.daily_raport.bushings_mm')}}</td>
                            <td>
                                <select-input :options="bushings"/>

                            </td>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.liter_stroke')}}</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="3">{{trans('digital_drilling.daily_raport.operating_hours_vibrating_sieve')}} №3</td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td>{{trans('digital_drilling.daily_raport.coef_floor')}}</td>
                            <td><input type="text"></td>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.density_g_cm')}}</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="3">{{trans('digital_drilling.daily_raport.sand_separator_work_hour')}}</td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td rowspan="4" class="align-middle">{{trans('digital_drilling.daily_raport.pumping_pressure')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.stroke_min')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.depth_m')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.pressure_atm')}}</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="3">{{trans('digital_drilling.daily_raport.sludge_separator_work_hour')}}</td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="3">{{trans('digital_drilling.daily_raport.dispenser_hour')}}</td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="2"></td>
                            <td colspan="3"></td>
                            <td></td>
                            <td></td>
                            <td v-for="i in 8"><input type="text"></td>
                        </tr>
                        <tr v-if="!pump[0].active">
                            <td v-for="i in 14"><input type="text"></td>
                            <td colspan="5">Добавить еще <span class="add" @click="addPump">+</span></td>
                        </tr>
                    </tbody>
                </table>
                <table class="pump" v-if="pump[0].active">
                    <tbody>
                        <!-- N3 -->
                        <tr>
                            <td colspan="3"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="3">{{trans('digital_drilling.daily_raport.pump_2_ty6L3NB_1_300D')}} №3 <span class="add"  @click="deletePump(0)">-</span></td>
                            <td colspan="2">
                                <select name="" id="">
                                    <option value="" v-for="pump in pumps">{{pump}}</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td>{{trans('digital_drilling.daily_raport.bushings_mm')}}</td>
                            <td>
                                <select-input :options="bushings"/>
                            </td>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.liter_stroke')}}</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="3"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td>{{trans('digital_drilling.daily_raport.coef_floor')}}</td>
                            <td><input type="text"></td>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.density_g_cm')}}</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="3"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td rowspan="4" class="align-middle">{{trans('digital_drilling.daily_raport.pumping_pressure')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.stroke_min')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.depth_m')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.pressure_atm')}}</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="3"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="3"><input type="text"></td>
                            <td colspan="2"></td>
                            <td colspan="2"></td>
                            <td></td>
                            <td></td>
                            <td colspan="2"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="3"><input type="text"></td>
                            <td colspan="2"></td>
                            <td colspan="3"></td>
                            <td></td>
                            <td></td>
                            <td v-for="i in 8"><input type="text"></td>
                        </tr>
                        <tr v-if="!pump[1].active">
                            <td colspan="3"><input type="text"></td>
                            <td colspan="2"></td>
                            <td colspan="3"></td>
                            <td></td>
                            <td></td>
                            <td v-for="i in 4"><input type="text"></td>
                            <td colspan="5">Добавить еще <span class="add" @click="addPump">+</span></td>
                        </tr>
                        <!-- end N3 -->
                    </tbody>
                </table>
                <table class="pump" v-if="pump[1].active">
                    <tbody>
                        <!-- N4 -->
                        <tr>
                            <td colspan="3"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="3">{{trans('digital_drilling.daily_raport.pump_2_ty6L3NB_1_300D')}} №4 <span class="add" @click="deletePump(1)">-</span></td>
                            <td colspan="2">
                                <select name="" id="">
                                    <option value="" v-for="pump in pumps">{{pump}}</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td>{{trans('digital_drilling.daily_raport.bushings_mm')}}</td>
                            <td>
                                <select-input :options="bushings"/>
                            </td>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.liter_stroke')}}</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="3"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td>{{trans('digital_drilling.daily_raport.coef_floor')}}</td>
                            <td><input type="text"></td>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.density_g_cm')}}</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="3"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td rowspan="4" class="align-middle">{{trans('digital_drilling.daily_raport.pumping_pressure')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.stroke_min')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.depth_m')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.pressure_atm')}}</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="3"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="3"><input type="text"></td>
                            <td colspan="2"></td>
                            <td colspan="2"></td>
                            <td></td>
                            <td></td>
                            <td colspan="2"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="3"><input type="text"></td>
                            <td colspan="2"></td>
                            <td colspan="3"></td>
                            <td></td>
                            <td></td>
                            <td v-for="i in 8"><input type="text"></td>
                        </tr>
                        <!-- end N4 -->
                    </tbody>
                </table>
                <table >
                    <tbody>
                        <tr>
                            <td colspan="3"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="7">{{trans('digital_drilling.daily_raport.total_length_drill_string_kelly')}}</td>
                            <td colspan="2">0.00</td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="7">
                                {{trans('digital_drilling.daily_raport.removal_solid_liquid_phase')}}
                            </td>
                            <td colspan="12" class="text-left">
                                {{trans('digital_drilling.daily_raport.HSE_status')}}
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('digital_drilling.daily_raport.name')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.ED')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.flights')}}</td>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.previous')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.per_day')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.total')}}</td>
                            <td colspan="12" class="border-bottom-0 text-left align-bottom">{{trans('digital_drilling.daily_raport.application_required')}}</td>
                        </tr>
                        <tr>
                            <td>{{trans('digital_drilling.daily_raport.TF')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.tn')}}</td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td rowspan="4" colspan="12" class="border-top-0">
                                <textarea name=""  cols="30" rows="10"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>{{trans('digital_drilling.daily_raport.ZHF_OBR')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.m_3')}}</td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>{{trans('digital_drilling.daily_raport.TBO')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.tn')}}</td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>{{trans('digital_drilling.daily_raport.waste_sewage')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.m_3')}}</td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
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
                                <textarea name=""  cols="30" rows="22"></textarea>
                            </td>
                        </tr>
                        <tr v-for="i in 11">
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td>
                                <select name="" id="">
                                    <option value="" v-for="code in operationCodes">{{code}}</option>
                                </select>
                            </td>
                            <td><input type="text"></td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table class="tables table defaultTable">
                    <thead>
                        <tr>
                            <th rowspan="2" colspan="18" class="align-middle">
                                {{trans('digital_drilling.daily_raport.TECHNICAL_PARAMETERS')}}
                            </th>
                            <th colspan="2">
                                {{trans('digital_drilling.daily_raport.date')}}:
                            </th>
                            <th colspan="2">
                                <input type="text">
                            </th>
                        </tr>
                        <tr>
                            <th colspan="2">
                                {{trans('digital_drilling.daily_raport.page')}}:
                            </th>
                            <th colspan="2">
                                <input type="text">
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
                                {{trans('digital_drilling.daily_raport.dense_inlet')}}
                            </td>
                            <td colspan="2">
                                {{trans('digital_drilling.daily_raport.dense_outlet')}}
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
                        <tr v-for="i in 6">
                            <td colspan="3" class="w-10">
                                <select-input :options="drillingMudTypes"/>
                            </td>
                            <td v-for="i in 19">
                                <input type="text">
                            </td>

                        </tr>
                        <tr>
                            <td colspan="19"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.daily_raport.content_solid_phase')}}</td>
                            <td rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.daily_raport.sand_content')}}</td>
                            <td rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.daily_raport.MVT')}}</td>
                            <td rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.daily_raport.water_content')}}</td>
                            <td rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.daily_raport.lubricant_content_solution')}}<</td>
                            <td colspan="4">CHC I,b/100ft2</td>
                            <td rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.daily_raport.crust')}}</td>
                            <td rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.daily_raport.total_hardness')}}</td>
                            <td colspan="4">{{trans('digital_drilling.concentration')}}</td>
                        </tr>
                        <tr>
                            <td colspan="2">10 {{trans('digital_drilling.daily_raport.sec')}}</td>
                            <td colspan="2">10 {{trans('digital_drilling.daily_raport.min')}}</td>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.ci_mg')}}</td>
                            <td colspan="2">KCI - %</td>
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
                        <tr>
                            <td v-for="i in 22"><input type="text"></td>
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
                            <td>{{trans('digital_drilling.daily_raport.density_material')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.mass_consumption')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.availability_rig')}}</td>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.receiving_per_day')}}</td>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.consumption_per_day')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.remaining_rig')}}</td>
                        </tr>
                        <tr v-for="i in 8">
                            <td>
                                <select-input :options="chemicalNames"/>
                            </td>
                            <td v-for="i in 5"><input type="text"></td>
                            <td v-for="j in 2" colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>
                                <select-input :options="chemicalNames"/>

                            </td>
                            <td v-for="i in 10"><input type="text"></td>
                        </tr>
                        <tr v-for="i in 6">
                            <td>
                                <select-input :options="chemicalNames"/>
                            </td>
                            <td v-for="i in 5"><input type="text"></td>
                            <td v-for="j in 2" colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                    </tbody>
                </table>
                <table class="tables table defaultTable">
                    <thead>
                        <tr>
                            <th colspan="16" class="title">{{trans('digital_drilling.daily_raport.consumption_tooling_materials')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="w-20">{{trans('digital_drilling.daily_raport.name_materials')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.before')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.coming')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.consumption')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.total_balance')}}</td>
                            <td colspan="5">{{trans('digital_drilling.daily_raport.name_materials')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.before')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.coming')}}</td>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.consumption')}}</td>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.total_balance')}}</td>
                        </tr>
                        <tr v-for="i in 7">
                            <td v-for="i in 5"><input type="text"></td>
                            <td colspan="5"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                        </tr>
                        <tr v-for="i in 2">
                            <td v-for="i in 16"><input type="text"></td>
                        </tr>
                        <tr>
                            <td v-for="i in 5"><input type="text"></td>
                            <td colspan="5"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
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
                            <td rowspan="2" class="align-middle">{{trans('digital_drilling.daily_raport.gradient_plas')}}</td>
                            <td rowspan="2" class="align-middle">{{trans('digital_drilling.daily_raport.gradient_GRP')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.old')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.sampling_interval')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.plan')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.fact_m')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.takeaway')}}</td>
                        </tr>
                        <tr>
                            <td>{{trans('digital_drilling.daily_raport.plan')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.fact_m')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.powerful')}}</td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr v-for="i in 10">
                            <td>
                                <select-input :options="stratigraphy"/>
                            </td>
                            <td v-for="i in 11"><input type="text"></td>
                        </tr>
                    </tbody>
                </table>
                <table class="tables table defaultTable">
                    <thead>
                        <tr>
                            <th colspan="10" class="title">{{trans('digital_drilling.daily_raport.INCLINOMETRY')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{trans('digital_drilling.daily_raport.depth_m')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.altitude')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.coal')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.azimuth')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.three_instruments')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.depth_m')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.altitude')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.coal')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.azimuth')}}</td>
                            <td>{{trans('digital_drilling.daily_raport.three_instruments')}}</td>
                        </tr>
                        <tr v-for="i in 20">
                            <td v-for="i in 10"><input type="text"></td>
                        </tr>
                    </tbody>
                </table>
                <table class="tables table defaultTable">
                    <thead>
                        <tr>
                            <th colspan="22" class="title">{{trans('digital_drilling.daily_raport.SAFETY')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.fire_alarm')}}</td>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.Uch_H2S_alarm')}}</td>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.TB_briefing')}}</td>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.GNVP_at_STR')}}</td>
                            <td colspan="3">{{trans('digital_drilling.daily_raport.anti_aircraft_defense')}}</td>
                            <td colspan="3">{{trans('digital_drilling.daily_raport.fukts_air_defense_check')}}</td>
                            <td colspan="3">{{trans('digital_drilling.daily_raport.alarm_GNVP')}}</td>
                            <td colspan="3">{{trans('digital_drilling.daily_raport.per_honey_help')}}</td>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.TB_meeting')}}</td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="3"><input type="text"></td>
                            <td colspan="3"><input type="text"></td>
                            <td colspan="3"><input type="text"></td>
                            <td colspan="3"><input type="text"></td>
                            <td colspan="2 "><input type="text"></td>
                        </tr>
                        <tr>
                            <td v-for="i in 22"></td>
                        </tr>
                        <tr>
                            <td v-for="i in 5"></td>
                            <td colspan="2" class="text-right border-right-0 align-bottom">{{trans('digital_drilling.daily_raport.drilling_supervisor')}}</td>
                            <td colspan="6" class="border-left-0"><input type="text" style="border-bottom: 2px solid #FFFFFF"></td>
                            <td colspan="9"></td>
                        </tr>
                        <tr>
                            <td v-for="i in 22"></td>
                        </tr>
                        <tr>
                            <td v-for="i in 5"></td>
                            <td colspan="2" class="text-right border-right-none align-bottom">{{trans('digital_drilling.daily_raport.drilling_foreman')}}</td>
                            <td colspan="6" class="border-left-0"><input type="text" style="border-bottom: 2px solid #FFFFFF"></td>
                            <td colspan="9"></td>
                        </tr>
                        <tr>
                            <td v-for="i in 22"></td>
                        </tr>
                        <tr>
                            <td v-for="i in 5"></td>
                            <td colspan="2" class="text-right border-right-none align-bottom">{{trans('digital_drilling.daily_raport.drilling_fluid_engineer')}}</td>
                            <td colspan="6" class="border-left-0"><input type="text" style="border-bottom: 2px solid #FFFFFF"></td>
                            <td colspan="9"></td>
                        </tr>
                        <tr>
                            <td v-for="i in 22"></td>
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
</template>

<script>
    import SelectInput from  './components/SelectInput'
    import NozzlesTable from  './components/NozzlesTable'

    export default {
        name: "DailyRaport",
        components: {SelectInput, NozzlesTable},
        data(){
            return{
                pump:[
                    {
                        number: 3,
                        active: false
                    },
                    {
                        number: 4,
                        active: false
                    },
                ],
                bushings:[
                    '120', '130', '140', '150', '160', '170', '180'
                ],
                diameters:[114.3, 127,139.7, 146.1, 168.3, 177.8, 193.7, 219.1, 244,
                           273.1, 298.5, 323.9, 339.7, 351, 377, 406.4, 425.5, 508, 762 ],
                drillingMudTypes: ['На водной основе', 'На углеводородной основе', 'Аэрированный', 'Эмульсионный'],
                operationCodes:['Монтаж/Демонтаж/Переезд', 'Бурение', 'Проработка/Расширка ствола скважины',
                               'Отбор керна', 'Промывка и восстановление параметров раствора', 'СПО',
                               'Обслуживание и ремонт оборудования буровой установки', 'Ремонт буровой установки',
                               'Замена талевого каната', 'Замер инклинометрии', 'ГИС', 'Крепление (спуск и цементирование ОК)',
                               'ОЗЦ', 'Монтаж/демонтаж ПВО', 'Опрессовка ПВО', 'Испытание скважины',
                               'PLUG BACK', 'Продавка цемента', 'Ловильные работы', 'Наклонно-направленное бурение',
                               'Спуск и извлечение оборудования хвостовика', 'Опрессовка оборудования устья скважины',
                               'Прочие операции', 'Непроизводительное время (НПВ)', 'Статус операций',
                               'Техника безопасности', 'ГНВП', 'Гибкие НКТ', 'Перфорация', 'СПО НКТ',
                               'Освоение и заканчивание скважины', 'Сваббирование', 'Испытание скважины',
                               'Установка подводного оборудования'],
                chemicalNames:['Бикорбанат натрия', 'Биополимер ксантановый Гламин', 'Калий Хлор', 'Лубрикон ТУ',
                               'ATREN Antifoam (гаспен силикон)', 'Atren Bio (Биоцидол)', 'PAC LV - ХимПАК В',
                               'PAC HV - ХимПАК Н', 'Aquaflo LV', 'Асфасол', 'Известь Са(ОН)2 тн',
                               'Ингидол ДТ - 1 противосальниковая', 'Ингидол ГГЛ', 'Ингидол Б',
                               'FRACSEAL (Кислотнорастворимый)', 'Desco CF', 'Карбонат Кальция (SOLUFLAKE D хлопьевидный)',
                               'Биксол Фри', 'БИОЦИДОЛ - бактерицид', 'Карбонат Кальция М-5', 'Карбонат Кальция М-50',
                               'Гаммаксан/Ксантангам/Гламин (биополимер)', 'Полимер акриловый (PHPA) ',
                               'Бентонит порошкообразный для струтуро образования', 'Лимонная кислота',
                               'Ореховая скорлупа', 'Соль техническая', 'Шелуха рисовая', 'Ингибитор глин, Стабилайт II',
                               'Микрошарик, 500-1000 мкм', 'Микрошарик, 150-600 мкм' ],
                threadTypes: ['ОТТМ', 'ОТТГ', 'ТБО', 'VAM'],
                pumps: ['F-800D', 'F-1000D', 'F-1300D', 'F-1600D', 'SL3NB-1300D', 'SL3NB-1000D', 'НБ-1000D'],
                timeSpents: ['Организ. простой', 'Ремонт после 21 часа', 'Осложения по стволу', 'Авария',
                             'Неэффективность работы', 'Ожидание оборудования', 'Ожидание персонала',
                             'Ожидание техники', 'Некачествен. цементир.', 'Ожидание указ. Заказчика',
                             'Подогрев оборудования', 'Ожидание химреагентов', 'Отключение элек.энерг. ', 'Превыш. нормы времени'],
                stratigraphy: [],
                drillingContractors: ['ТОО СБП "КМГ-Бурение"', 'ТОО " Zhanros Drilling"', 'ТОО "Бургылау"',
                                      'ТОО "Oil Services Company" (OSC)', 'АО "КазБурГаз"', 'АО "KAZPETRODRILLING"',
                                      'ТОО ИБК "Сибу Кызылорда"', 'ТОО ИБК "Сибу Актау"', 'ТОО "KMG Drilling&Services"',
                                      'ТОО "KMG Nabors Drilling Company"', 'ТОО "Бурение и К"', 'ТОО "НефтьТехСервис"',
                                      'ТОО "Тулпар Мунай Сервис"', 'ТОО "Нефтяная инженерная компания "HUA SHENG DA"',
                                      'ТОО "МНСК Синопек"', 'ТОО "Восток нефть и сервисное обслуживание"',
                                      'ТОО "Мунай Сервис Лтд"', 'ТОО "Equipment Services LTD"', 'ТОО "БКЕ Казахстан Бурение"',
                                      'ТОО "Сан Дриллинг"', 'ТОО "ККБК "Великая стена"', 'ООО "БКЕ-Шельф (Буровая компания Евразия Шельф)',
                                      'Parker Drilling Company B.V.', 'PiS - 1', 'PiS - 2', 'ТОО Антон Ойл',
                                      'ТОО Великая стена', 'ТОО "Exalo Drilling"'],

                bitWare: {
                    I: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    O: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    D: ["BC", "BF", "BT", "BU", "CC", "CD", "CI", "CR", "CT", "ER", "FC", "HC", "JD", "LC", "LN",
                        "LT", "OC", "PB", "PN", "RG", "RO", "SD", "SS", "TR", "WO", "WT", "NO"],
                    L: ["C", "N", "T", "S", "G", "A" ],
                    B: [0, 1, 2, 3, 4, 5, 6, 7, 8, "E", "F", "N", "X"],
                    G: [1, "1/16", "1/8", "1/4"],
                    D:  ["BC", "BF", "BT", "BU", "CC", "CD", "CI", "CR", "CT", "ER", "FC", "HC", "JD", "LC", "LN",
                        "LT", "OC", "PB", "PN", "RG", "RO", "SD", "SS", "TR", "WO", "WT", "NO"],
                    R: ["BHA", "CM", "CP", "DMF", "DP", "DSF", "DST", "DTF", "FM", "HP", "HR",
                        "LIH”", "LOG;", "PP”", "PR”", "RIG", "TD”", "TQ", "TW", "WC"],
                },
                operation1: [
                    'digital_drilling.daily_raport.drilling',
                    'digital_drilling.daily_raport.build_up',
                    'digital_drilling.daily_raport.development_trunk',
                    'digital_drilling.daily_raport.well_flushing',
                    'digital_drilling.daily_raport.CPO',
                    'digital_drilling.daily_raport.PZR',
                    'digital_drilling.daily_raport.BCP',
                    'digital_drilling.daily_raport.GIS',
                    'digital_drilling.daily_raport.descent',
                    'digital_drilling.daily_raport.cementing',
                    'digital_drilling.daily_raport.OZS',
                    'digital_drilling.daily_raport.OU_PVO',
                    'digital_drilling.daily_raport.repair_21',
                    'digital_drilling.daily_raport.RBS',
                    'digital_drilling.daily_raport.formation_testing',
                    'digital_drilling.daily_raport.installation',
                    'digital_drilling.daily_raport.other',
                ],
                operation2: [
                    'digital_drilling.daily_raport.organiz_simple',
                    'digital_drilling.daily_raport.repair_after_21',
                    'digital_drilling.daily_raport.complications_trunk',
                    'digital_drilling.daily_raport.accident',
                    'digital_drilling.daily_raport.inefficiency_of_work',
                    'digital_drilling.daily_raport.waiting_equipment',
                    'digital_drilling.daily_raport.waiting_staff',
                    'digital_drilling.daily_raport.waiting_technology',
                    'digital_drilling.daily_raport.low_quality_cement',
                    'digital_drilling.daily_raport.waiting_decree_customer',
                    'digital_drilling.daily_raport.heating_equipment',
                    'digital_drilling.daily_raport.waiting_chemicals',
                    'digital_drilling.daily_raport.power_outage',
                    'digital_drilling.daily_raport.exceed_time_norms',
                ],
                drillingRigTypes:[
                    'Морская - Погружная',
                    'Морская - Полупогружная',
                    'Наземная - Телескопическая',
                    'Наземная - Мачтовая',
                    'Наземная - Мобильная',
                ],
                Nozzles: [
                    [7, 0.038, 0.075,  0.113,  0.150,  0.188,  0.225,  0.263,  0.301,  0.338,  0.376],
                    [8, 0.049, 0.098,  0.147,  0.196,  0.245,  0.295,  0.344,  0.393,  0.442,  0.491],
                    [9, 0.062,	0.124,	0.186,	0.249,	0.311,	0.373,	0.435,	0.497,	0.559,	0.621],
                    [10, 0.077,	0.153,	0.230,	0.307,	0.383,	0.460,	0.537,	0.614,	0.690,	0.767],
                    [11, 0.093,	0.186,	0.278,	0.371,	0.464,	0.557,	0.650,	0.742,	0.835,	0.928],
                    [12, 0.110,	0.221,	0.331,	0.442,	0.552,	0.663,	0.773,	0.884,	0.994,	1.104],
                    [13, 0.130,	0.259,	0.389,	0.518,	0.648,	0.778,	0.907,	1.037,	1.167,	1.296],
                    [14, 0.150,	0.301,	0.451,	0.601,	0.752,	0.902,	1.052,	1.203,	1.353,	1.503],
                    [15, 0.173,	0.345,	0.518,	0.690,	0.863,	1.035,	1.208,	1.381,	1.553,	1.726],
                    [16, 0.196,	0.393,	0.589,	0.785,	0.982,	1.178,	1.374,	1.571,	1.767,	1.963],
                    [18, 0.249,	0.497,	0.746,	0.994,	1.243,	1.491,	1.740,	1.988,	2.237,	2.485],
                    [20, 0.307,	0.614,	0.920,	1.227,	1.534,	1.841,	2.148,	2.454,	2.761,	3.068],
                    [22, 0.371,	0.742,	1.114,	1.485,	1.856,	2.227,	2.599,	2.970,	3.341,	3.712],
                    [24, 0.442,	0.884,	1.325,	1.767,	2.209,	2.651,	3.093,	3.534,	3.976,	4.418],
                    [26, 0.518,	1.037,	1.555,	2.074,	2.592,	3.111,	3.629,	4.148,	4.666,	5.185],
                    [28, 0.601,	1.203,	1.804,	2.405,	3.007,	3.608,	4.209,	4.811,	5.412,	6.013],
                    [30, 0.690,	1.381,	2.071,	2.761,	3.451,	4.142,	4.832,	5.522,	6.213,	6.903],
                    [32, 0.785,	1.571,	2.356,	3.142,	3.927,	4.712,	5.498,	6.283,	7.069,	7.854],

                ],
                bitTypes:[
                    'Трёхшарошечное долото',
                    'Долото с поликристаллическ. алмазами PDC',
                    'Долото с натуральными алмазами',
                ],
                manufacturers: [
                    'Smith',
                    'Smith Bits',
                    'Security DBS',
                ],
                bitDiameters: [
                    '95,25', '98,42', '104,77', '114,3', '118,74', '120,65', '123,82', '139,7', '142,87', '149,22',
                    '152,4', '155,58', '158,75', '165,1', '171,45', '184,15', '190,5', '200,02', '212,72', '215,9',
                    '222,25', '228,6', '241,3', '245,74', '250,82', '260,35', '266,7', '269,87', '279,4', '295,27',
                    '304,8', '307,98', '311,15', '317,5', '342,9', '349,25', '368,3', '374,65', '393,7', '406,4',
                    '412,75', '431,8', '444,5', '457,2', '469,9',  '508', '558,8', '584,2', '596,9', '609,6',
                    '660,4', '711,2', '736,6', '762', '863,6', '914,4',
                ],
                unitNames: ['ZJ-10', 'ZJ-15', 'ZJ-20', 'ZJ-30', 'ZJ-40', 'ZJ-40/2250DBT', 'ZJ-50', 'ZJ-70', 'МБУ ZJ-30',
                            'МБУ ZJ-30/27', 'МБУ-125', 'МБУ-140', 'МБУ-160', 'XJ-120', 'XJ-100', 'XJ-350', 'XJ-450',
                            'XJ-550', 'XJ-750', 'XCMG XZ360E', 'XCMG XR150d', 'IRI IDECO-270', 'АРБ-100', 'VR-500'],
            }
        },
        methods: {
            addPump(){
                if (!this.pump[0].active){
                    this.pump[0].active = true
                } else{
                    this.pump[1].active = true
                }
            },
            deletePump(index){
                this.pump[index].active = false
            }
        }
    }
</script>

<style scoped>
    .bit-ware{
        /*width: 140px;*/
    }
    .nozzles{
        width: 100%;
        display: flex;
        align-items: center;
        height: 40px!important;
    }
    .select__name{
        height: 25px;
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
        margin-left:4px
    }
    .bit-ware .selects{
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #454d7d;
        border-radius: 5px;
        margin-top: 2px;
    }
    .selects select{
        margin-left: 2px;
    }
    .select__name div:nth-child(1), .select__name div:nth-child(2),
    .select__name div:nth-child(4), .select__name div:nth-child(5),
    .selects select:nth-child(1), .selects select:nth-child(2),
    .selects select:nth-child(4), .selects select:nth-child(5){
        width: 35px;
    }
    .select__name div:nth-child(3), .select__name div:nth-child(6),
    .select__name div:nth-child(7), .select__name div:nth-child(8),
    .selects select:nth-child(3), .selects select:nth-child(6),
    .selects select:nth-child(7), .selects select:nth-child(8){
        width: 45px;
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
</style>