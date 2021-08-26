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
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
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
                                    <option value="">Test</option>
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
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
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
                                <tr v-for="expense in Expenses">
                                    <td class="w-15">{{trans(expense.operation1)}}</td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td class="w-20">{{trans(expense.operation2)}}</td>
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
                            <td>Код операции</td>
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
                                    <option value="">Test</option>
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
                            <td ><select name="" id="">
                                <option value="">Test</option>
                            </select></td>
                            <td ><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.TOTAL')}}</td>
                            <td >24:00</td>
                            <td ><input type="text"></td>
                            <td ><select name="" id="">
                                <option value="">Test</option>
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
                            <td class="w-7"><input type="text"></td>
                        </tr>
                        <tr>
                            <td>
                                {{trans('digital_drilling.daily_raport.chisel_type')}}
                            </td>
                            <td colspan="2">
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
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
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
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
                                <input type="text">
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
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{trans('digital_drilling.daily_raport.manufacturer')}}
                            </td>
                            <td colspan="2">
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
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
                                <input type="text">
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
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
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
                                <input type="text">
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
                                <input type="text">
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
                                <input type="text">
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
                                <input type="text">
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
                                <input type="text">
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
                                <input type="text">
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
                                <input type="text">
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
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
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
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td >
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="3">{{trans('digital_drilling.daily_raport.pump_2_ty6L3NB_1_300D')}} №1</td>
                            <td colspan="2"><input type="text"></td>
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
                                <input type="text">
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
                            <td><input type="text"></td>
                            <td colspan="2">{{trans('digital_drilling.daily_raport.liter_stroke')}}</td>
                            <td>
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="2" class="align-middle">
                                {{trans('digital_drilling.daily_raport.bit_wear_according_IADC')}}
                            </td>
                            <td rowspan="2" colspan="2" class="align-middle">
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
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
                                <input type="text">
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
                            <td colspan="2"><input type="text"></td>
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
                            <td colspan="2"><input type="text"></td>
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
                            <td colspan="2"><input type="text"></td>
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
                            <td><input type="text"></td>
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
                            <td colspan="2"><input type="text"></td>
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
                            <td><input type="text"></td>
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
                            <td colspan="2"><input type="text"></td>
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
                            <td><input type="text"></td>
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
                                    <option value="">Test</option>
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
                        <tr v-for="i in 3">
                            <td colspan="3" class="w-10">
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
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
                            <td v-for="j in 6"><input type="text"></td>
                            <td v-for="j in 2" colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td v-for="i in 11"><input type="text"></td>
                        </tr>
                        <tr v-for="i in 6">
                            <td v-for="j in 6"><input type="text"></td>
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
                            <td v-for="i in 12"><input type="text"></td>
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
    export default {
        name: "DailyRaport",
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
                Expenses: [
                    {operation1: 'digital_drilling.daily_raport.drilling', operation2: 'digital_drilling.daily_raport.organiz_simple'},
                    {operation1: 'digital_drilling.daily_raport.build_up', operation2: 'digital_drilling.daily_raport.repair_after_21'},
                    {operation1: 'digital_drilling.daily_raport.development_trunk', operation2: 'digital_drilling.daily_raport.complications_trunk'},
                    {operation1: 'digital_drilling.daily_raport.well_flushing', operation2: 'digital_drilling.daily_raport.accident'},
                    {operation1: 'digital_drilling.daily_raport.CPO', operation2: 'digital_drilling.daily_raport.inefficiency_of_work'},
                    {operation1: 'digital_drilling.daily_raport.PZR', operation2: 'digital_drilling.daily_raport.waiting_equipment'},
                    {operation1: 'digital_drilling.daily_raport.BCP', operation2: 'digital_drilling.daily_raport.waiting_staff'},
                    {operation1: 'digital_drilling.daily_raport.GIS', operation2: 'digital_drilling.daily_raport.waiting_technology'},
                    {operation1: 'digital_drilling.daily_raport.descent', operation2: 'digital_drilling.daily_raport.low_quality_cement'},
                    {operation1: 'digital_drilling.daily_raport.cementing', operation2: 'digital_drilling.daily_raport.waiting_decree_customer'},
                    {operation1: 'digital_drilling.daily_raport.OZS', operation2: 'digital_drilling.daily_raport.heating_equipment'},
                    {operation1: 'digital_drilling.daily_raport.OU_PVO', operation2: 'digital_drilling.daily_raport.waiting_chemicals'},
                    {operation1: 'digital_drilling.daily_raport.repair_21', operation2: 'digital_drilling.daily_raport.power_outage'},
                    {operation1: 'digital_drilling.daily_raport.RBS', operation2: 'digital_drilling.daily_raport.exceed_time_norms'},
                    {operation1: 'digital_drilling.daily_raport.formation_testing', operation2: ''},
                    {operation1: 'digital_drilling.daily_raport.installation', operation2: ''},
                    {operation1: 'digital_drilling.daily_raport.other', operation2: ''},
                    {operation1: '', operation2: ''},
                    {operation1: '', operation2: ''},
                ]
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