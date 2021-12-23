<template>
<<<<<<< HEAD
    <div v-if="!previous" :class="{fixed: fixedStyle}" >
        <div class="container-main">
            <div class="col-sm-12">
                <div class="daily_raport_block-header">
                    <div class="daily_raport_block-header-first">
                        <div class="daily_raport_block-header-input">
                            <label for="">{{trans('digital_drilling.daily_raport.date')}}</label>
                            <input type="date" class="date-report" v-model="reportDate" :max="getPreviousDay()"  @change="changeDate">
=======
    <div>
        <div v-if="!previous">
            <div class="container-main">
                <div class="col-sm-12">
                    <div class="daily_raport_block-header">
                        <div class="daily_raport_block-header-first">
                            <div class="daily_raport_block-header-input">
                                <label for="">{{trans('digital_drilling.daily_raport.date')}}</label>
                                <input type="date" class="date-report" v-model="reportDate" :max="getPreviousDay()"  @change="changeDate">
                            </div>
                            <div class="daily_raport_block-header-input">
                                <label for="">{{trans('digital_drilling.daily_raport.report')}}</label>
                                <input type="text" disabled v-model="report.report_daily.report_num" />
                            </div>
>>>>>>> master
                        </div>
                        <div class="daily_raport_block-header-center">
                            {{trans('digital_drilling.daily_raport.DAILY_DRILLING_REPORT')}}
                        </div>
                        <div class="daily_raport_block-header-save">
                            <button class="save" @click="saveModal=true">
                                {{trans('app.save')}}
                            </button>
                        </div>
<<<<<<< HEAD
                    </div>
                    <div class="daily_raport_block-header-center">
                        {{trans('digital_drilling.daily_raport.DAILY_DRILLING_REPORT')}}
                    </div>
                    <div class="daily_raport_block-header-save">
                        <button class="save" @click="saveModal=true">
                            {{trans('app.save')}}
                        </button>
                        <button class="save" @click="closeReport">
                            Назад
                        </button>
=======
>>>>>>> master
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
                                    <select-add :options="drillingRig" name="Unit_Name"  :header="report.general_data_daily.rig"
                                                @addItem="addItemRig"
                                                @selectOption="selectOption"
                                                :class="{error: validationError && report.general_data_daily.rig.name_ru == ''}"
                                    />
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
                                    <select name="" id="" v-model="report.general_data_daily.rig_type" :class="{error: validationError && report.general_data_daily.rig_type.name_ru == ''}">
                                        <option :value="rig" v-for="rig in drillingRigTypes">{{rig.name_ru}}</option>
                                    </select>
                                </td>
                                <td colspan="2">
                                    {{trans('digital_drilling.daily_raport.bit_load')}}
                                </td>
                                <td colspan="2" class="validation">
                                    <input type="number" v-model="report.drilling_parameters_daily.wob"
                                           :class="{error: validationError && report.drilling_parameters_daily.wob == '',
                                        errorValidate:!checkMinMaxLengthVar(report.drilling_parameters_daily.wob , 0, 500)}"
                                           @input="checkMinMaxLength(report.drilling_parameters_daily.wob , 0, 500, 'wob')"
                                    >
                                    <div class="info" data-title="Минимум-0, Максимум-500">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td colspan="2">
                                    {{trans('digital_drilling.daily_raport.drilling_contractor')}}
                                </td>
                                <td colspan="2">
                                    <select-add :options="drillingContractors" name="drillingContractors" :header="report.contractor_daily.contractor"
                                                @selectOption="selectOption"
                                                @addItem="openCatalog('Буровой подрядчик', 'company', 'companyName')"
                                                :class="{error: validationError && report.contractor_daily.contractor.name_ru == ''}"
                                    />
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
                                <td colspan="2" class="validation">
                                    <input type="text" v-model="report.drilling_parameters_daily.rotation_speed"
                                           :class="{error: validationError && report.drilling_parameters_daily.rotation_speed == '',
                                        errorValidate:!checkMinMaxLengthVar(report.drilling_parameters_daily.rotation_speed , 0, 1000)}"
                                           @input="checkMinMaxLength(report.drilling_parameters_daily.rotation_speed , 0, 1000, 'rotation_speed')"
                                    >
                                    <div class="info" data-title="Минимум-0, Максимум-1000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td colspan="2">
                                    {{trans('digital_drilling.daily_raport.drilling_start_date')}}
                                </td>
                                <td colspan="2" class="text-left">
                                <span v-if="report.contractor_daily.dbeg != ''">
                                    {{report.contractor_daily.dbeg}}
                                </span>
                                    <input type="text" v-model="report.contractor_daily.dbeg" v-else :class="{error: validationError && report.contractor_daily.dbeg == ''}">
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
                                <td colspan="2" class="validation">
                                    <input type="number" v-model="report.drilling_parameters_daily.torque"
                                           :class="{error: validationError && report.drilling_parameters_daily.torque == '',
                                        errorValidate:!checkMinMaxLengthVar(report.drilling_parameters_daily.torque , 0, 500)}"
                                           @input="checkMinMaxLength(report.drilling_parameters_daily.torque , 0, 500, 'torque')"
                                    >
                                    <div class="info" data-title="Минимум-0, Максимум-500">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td colspan="2">
                                    {{trans('digital_drilling.daily_raport.total_drilling_days')}}
                                </td>
                                <td colspan="2">
                                    <input type="text" v-model="report.contractor_daily.total_drilling_days" :class="{error: validationError && report.contractor_daily.total_drilling_days == ''}" >
                                </td>
                            </tr>
                            <tr>
                                <td >
                                    {{trans('digital_drilling.daily_raport.project_depth')}}
                                </td>
                                <td class="validation">
                                    <input type="number"
                                           v-model="report.general_data_daily.project_md"
                                           :class="{
                                       error: validationError && report.general_data_daily.project_md == '',
                                       errorValidate:!checkMinMaxLengthVar(report.general_data_daily.project_md, 0, 10000)}"
                                           @input="checkMinMaxLength(report.general_data_daily.project_md, 0, 10000, 'project_md')"
                                    >
                                    <div class="info" data-title="Минимум-0, Максимум-10000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <!--:class="{error: validationError && checkMinMaxLength($event, 0, 10000)}"-->
                                <td >
                                    {{trans('digital_drilling.daily_raport.project_depth_vert')}}
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="report.general_data_daily.project_tvd"
                                           :class="{
                                       error: validationError && report.general_data_daily.project_tvd == '',
                                       errorValidate: !checkMinMaxLengthVar(report.general_data_daily.project_tvd, 0, 10000)}"
                                           @input="checkMinMaxLength(report.general_data_daily.project_tvd, 0, 10000, 'project_tvd')"
                                    >
                                    <div class="info" data-title="Минимум-0, Максимум-10000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td colspan="2">
                                    {{trans('digital_drilling.daily_raport.pump_capacity')}}
                                </td>
                                <td colspan="2" class="validation">
                                    <input type="number" v-model="report.drilling_parameters_daily.pump_eff"
                                           :class="{error: validationError && report.drilling_parameters_daily.pump_eff == '',
                                        errorValidate:!checkMinMaxLengthVar(report.drilling_parameters_daily.pump_eff , 0, 500)}"
                                           @input="checkMinMaxLength(report.drilling_parameters_daily.pump_eff , 0, 500, 'pump_eff')"
                                    >
                                    <div class="info" data-title="Минимум-0, Максимум-500">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td colspan="2">
                                    {{trans('digital_drilling.daily_raport.air_temperature')}}
                                </td>
                                <td colspan="2" class="validation">
                                    <input type="number" v-model="report.contractor_daily.air_temp"
                                           :class="{error: validationError && report.contractor_daily.air_temp == '',
                                        errorValidate:!checkMinMaxLengthVar(report.contractor_daily.air_temp , -50, 50)}"
                                           @input="checkMinMaxLength(report.contractor_daily.air_temp , -50, 50, 'air_temp')"
                                    >
                                    <div class="info" data-title="Минимум:-50, Максимум: 50">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    {{trans('digital_drilling.daily_raport.previous_face')}}
                                </td>
                                <td colspan="2" class="text-left">
                                    <span>{{report.general_data_daily.previous_bhd}}</span>
                                </td>
                                <td colspan="2">
                                    {{trans('digital_drilling.daily_raport.riser_pressure')}}
                                </td>
                                <td colspan="2" class="validation">
                                    <input type="number" v-model="report.drilling_parameters_daily.p_standpipe"
                                           :class="{
                                       error: validationError && report.drilling_parameters_daily.p_standpipe == '',
                                       errorValidate: !checkMinMaxLengthVar(report.drilling_parameters_daily.p_standpipe, 0, 1000)}"
                                           @input="checkMinMaxLength(report.drilling_parameters_daily.p_standpipe, 0, 1000, 'p_standpipe')"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 1000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
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
                                <td colspan="2" class="validation">
                                    <input type="number" v-model="report.general_data_daily.bhd_24"
                                           :class="{error: validationError && report.general_data_daily.bhd_24 == 0,
                                        errorValidate:!checkMinMaxLengthVar(report.general_data_daily.bhd_24, report.general_data_daily.previous_bhd, 10000)}"
                                           @input="checkMinMaxLength(report.general_data_daily.bhd_24, report.general_data_daily.previous_bhd, 10000, 'bhd_24')"
                                    >
                                    <div class="info" :data-title="'Минимум:' +report.general_data_daily.previous_bhd +', Максимум: 10000'">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td colspan="2">
                                    {{trans('digital_drilling.daily_raport.hook_weight')}}
                                </td>
                                <td colspan="2" class="validation">
                                    <input type="number" v-model="report.drilling_parameters_daily.woh"
                                           :class="{error: validationError && report.drilling_parameters_daily.woh == '',
                                        errorValidate:!checkMinMaxLengthVar(report.drilling_parameters_daily.woh , 0, 500)}"
                                           @input="checkMinMaxLength(report.drilling_parameters_daily.woh , 0, 500, 'woh')"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 500">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td colspan="2">
                                    {{trans('digital_drilling.daily_raport.drilling_supervisor')}}
                                </td>
                                <td colspan="2">
                                    <input type="text" v-model="report.contractor_daily.supervisor" :class="{error: validationError && report.contractor_daily.supervisor == ''}">
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
                                <td colspan="2" class="validation">
                                    <input type="number" v-model="report.drilling_parameters_daily.woh_pooh"
                                           :class="{error: validationError && report.drilling_parameters_daily.woh_pooh == '',
                                        errorValidate:!checkMinMaxLengthVar(report.drilling_parameters_daily.woh_pooh , 0, 500)}"
                                           @input="checkMinMaxLength(report.drilling_parameters_daily.woh_pooh , 0, 500, 'woh_pooh')"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 500">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td colspan="2">
                                    {{trans('digital_drilling.daily_raport.drilling_foreman')}}
                                </td>
                                <td colspan="2">
                                    <input type="text" v-model="report.contractor_daily.drilling_engineer" :class="{error: validationError && report.contractor_daily.drilling_engineer == ''}">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    {{trans('digital_drilling.daily_raport.drilling_reaming_time')}}
                                </td>
                                <td colspan="2">
                                    <input type="time" v-model="report.general_data_daily.reaming_drilling" :class="{error: validationError && report.general_data_daily.reaming_drilling == ''}">
                                </td>
                                <td colspan="2">
                                    {{trans('digital_drilling.daily_raport.hook_weight_when_descending')}}
                                </td>
                                <td colspan="2" class="validation">
                                    <input type="number" v-model="report.drilling_parameters_daily.woh_rih"
                                           :class="{error: validationError && report.drilling_parameters_daily.woh_rih == '',
                                        errorValidate:!checkMinMaxLengthVar(report.drilling_parameters_daily.woh_rih , 0, 500)}"
                                           @input="checkMinMaxLength(report.drilling_parameters_daily.woh_rih , 0, 500, 'woh_rih')"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 500">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td colspan="2">
                                    {{trans('digital_drilling.daily_raport.drilling_fluid_engineer')}}
                                </td>
                                <td colspan="2">
                                    <input type="text" v-model="report.contractor_daily.drilling_mud_engineer" :class="{error: validationError && report.contractor_daily.drilling_mud_engineer == ''}">
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
                                    <tr v-for="(wellConstr, i) in report.well_constr_daily">
                                        <td colspan="2" class="w-10">
                                            <select name="" id="" v-model="wellConstr.constr_type">
                                                <option :value="constructor" v-for="constructor in constructors">{{constructor.name_ru}}</option>
                                            </select>
                                        </td>
                                        <td class="validation">
                                            <input type="number" v-model="wellConstr.project_tvd"
                                                   :class="{errorValidate:!checkMinMaxLengthVar(wellConstr.project_tvd , 0, 15000)}"
                                                   @input="checkMinMaxLength(wellConstr.project_tvd , 0, 15000, 'project_tvd'+i)"
                                            >
                                            <div class="info" data-title="Минимум:0, Максимум: 15000">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="error">
                                                        <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                        <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                        <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                                    </g>
                                                </svg>
                                            </div>
                                        </td>
                                        <td class="validation">
                                            <input type="number" v-model="wellConstr.project_md"
                                                   :class="{errorValidate:!checkMinMaxLengthVar(wellConstr.project_md , 0, 15000)}"
                                                   @input="checkMinMaxLength(wellConstr.project_md , 0, 15000, 'project_md'+i)"
                                            >
                                            <div class="info" data-title="Минимум:0, Максимум: 15000">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="error">
                                                        <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                        <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                        <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                                    </g>
                                                </svg>
                                            </div>
                                        </td>
                                        <td class="validation">
                                            <input type="number" v-model="wellConstr.fact_tvd"
                                                   :class="{errorValidate:!checkMinMaxLengthVar(wellConstr.fact_tvd , 0, 15000)}"
                                                   @input="checkMinMaxLength(wellConstr.fact_tvd , 0, 15000, 'fact_tvd'+i)"
                                            >
                                            <div class="info" data-title="Минимум:0, Максимум: 15000">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="error">
                                                        <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                        <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                        <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                                    </g>
                                                </svg>
                                            </div>
                                        </td>
                                        <td class="validation">
                                            <input type="number" v-model="wellConstr.fact_md"
                                                   :class="{errorValidate:!checkMinMaxLengthVar(wellConstr.fact_md , 0, 15000)}"
                                                   @input="checkMinMaxLength(wellConstr.fact_md , 0, 15000, 'fact_md'+i)"
                                            >
                                            <div class="info" data-title="Минимум:0, Максимум: 15000">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="error">
                                                        <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                        <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                        <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                                    </g>
                                                </svg>
                                            </div>
                                        </td>
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
                                                <td class="validation">
                                                    <input type="number" v-model="report.shifts_daily.arrived"
                                                           :class="{errorValidate:!checkMinMaxLengthVar(report.shifts_daily.arrived , 0, 20)}"
                                                           @input="checkMinMaxLength(report.shifts_daily.arrived , 0, 20, 'shifts_daily-arrived')"
                                                    >
                                                    <div class="info" data-title="Минимум:0, Максимум: 20">
                                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <g id="error">
                                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                                            </g>
                                                        </svg>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{trans('digital_drilling.daily_raport.deleted')}}</td>
                                                <td class="validation">
                                                    <input type="number" v-model="report.shifts_daily.departed"
                                                           :class="{errorValidate:!checkMinMaxLengthVar(report.shifts_daily.departed , 0, 20)}"
                                                           @input="checkMinMaxLength(report.shifts_daily.departed , 0, 20, 'shifts_daily-departed')"
                                                    >
                                                    <div class="info" data-title="Минимум:0, Максимум: 20">
                                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <g id="error">
                                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                                            </g>
                                                        </svg>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{trans('digital_drilling.daily_raport.left')}}</td>
                                                <td class="validation">
                                                    <input type="number" v-model="report.shifts_daily.remain"
                                                           :class="{errorValidate:!checkMinMaxLengthVar(report.shifts_daily.remain , 0, 20)}"
                                                           @input="checkMinMaxLength(report.shifts_daily.remain , 0, 20, 'shifts_daily-remain')"
                                                    >
                                                    <div class="info" data-title="Минимум:0, Максимум: 20">
                                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <g id="error">
                                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                                            </g>
                                                        </svg>
                                                    </div>
                                                </td>
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
                                            {{report.prod_time_daily[i-1].operations_type}}
                                        </td>
                                        <td>{{report.prod_time_daily[i-1].previous}}</td>
                                        <td class="validation">
                                            <input type="number"  v-model="report.prod_time_daily[i-1].daily"
                                                   :class="{errorValidate:!checkMinMaxLengthVar(report.prod_time_daily[i-1].daily , 0, 24)}"
                                                   @input="checkMinMaxLength(report.prod_time_daily[i-1].daily , 0, 24, 'prod_time_daily'+i)"
                                            >
                                            <div class="info" data-title="Минимум:0, Максимум: 24">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="error">
                                                        <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                        <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                        <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                                    </g>
                                                </svg>
                                            </div>
                                        </td>
                                        <td>{{sumValues(report.prod_time_daily[i-1].previous, report.prod_time_daily[i-1].daily)}}</td>
                                        <td class="w-20">
                                            {{report.unprod_time_daily[i-1].operations_type}}
                                        </td>
                                        <td>{{report.unprod_time_daily[i-1].previous}}</td>
                                        <td class="validation">
                                            <input type="number" v-model="report.unprod_time_daily[i-1].daily"
                                                   :class="{errorValidate:!checkMinMaxLengthVar(report.unprod_time_daily[i-1].daily , 0, 24)}"
                                                   @input="checkMinMaxLength(report.unprod_time_daily[i-1].daily , 0, 24, 'unprod_time_daily'+i)"
                                            >
                                            <div class="info" data-title="Минимум:0, Максимум: 24">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="error">
                                                        <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                        <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                        <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                                    </g>
                                                </svg>
                                            </div>
                                        </td>
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
                            <tr>
                                <td ><input type="time" v-model="report.job_status_daily[0].tbeg" @change="getTotalTime(0, 24)"></td>
                                <td ><input type="time" v-model="report.job_status_daily[0].tend" @change="getTotalTime(0, 24)"></td>
                                <td >{{report.job_status_daily[0].total_time}}</td>
                                <td ><input type="text" v-model="report.job_status_daily[0].rate"></td>
                                <td >
                                    <select name="" id=""  v-model="report.job_status_daily[0].operation_code">
                                        <option :value="code" v-for="code in operationCodes">{{code.name_ru}}</option>
                                    </select>
                                </td>
                                <td ><input type="text" v-model="report.job_status_daily[0].operations"></td>
                                <td rowspan="16" colspan="4" class="w-20 border-top-0"><textarea name="" id="" cols="30" rows="32" v-model="report.comments.comment"></textarea></td>
                            </tr>
                            <tr v-for="i in 15">
                                <td ><input type="time" v-model="report.job_status_daily[i].tbeg" @change="getTotalTime(i, 24)"></td>
                                <td ><input type="time" v-model="report.job_status_daily[i].tend" @change="getTotalTime(i, 24)"></td>
                                <td >{{report.job_status_daily[i].total_time}}</td>
                                <td ><input type="text" v-model="report.job_status_daily[i].rate"></td>
                                <td >
                                    <select name="" id=""  v-model="report.job_status_daily[i].operation_code">
                                        <option :value="code" v-for="code in operationCodes">{{code.name_ru}}</option>
                                    </select>
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
                            <div class="col-xl-7 col-lg-12 pr-0 nozzle-row">
                                <table class="tables table defaultTable">
                                    <thead>
                                    <th colspan="5">
                                        {{trans('digital_drilling.daily_raport.bit_information')}}
                                    </th>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{trans('digital_drilling.daily_raport.chisel')}}</td>
                                        <td  colspan="2">
                                            <input type="text" v-model="report.bit_info_daily[0].bit_num" disabled>
                                        </td>
                                        <td  colspan="2">
                                            <input type="text" v-model="report.bit_info_daily[1].bit_num" disabled>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{trans('digital_drilling.daily_raport.chisel_type')}}
                                        </td>
                                        <td colspan="2">
                                            <select name="" id="" v-model="report.bit_info_daily[0].bit_type">
                                                <option :value="type" v-for="type in bitTypes">{{type.name_ru}}</option>
                                            </select>
                                        </td>
                                        <td colspan="2">
                                            <select name="" id="" v-model="report.bit_info_daily[1].bit_type">
                                                <option :value="type" v-for="type in bitTypes">{{type.name_ru}}</option>
                                            </select>
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
                                            <select-add :options="manufacturers" name="manufacturer1" :header="report.bit_info_daily[0].manufacturer"
                                                        @selectOption="selectOption"
                                                        @addItem="openCatalog('Производитель', 'manufacturer', 'manufacturer1')"
                                            />
                                        </td>
                                        <td colspan="2">
                                            <select-add :options="manufacturers" name="manufacturer2" :header="report.bit_info_daily[1].manufacturer"
                                                        @selectOption="selectOption"
                                                        @addItem="openCatalog('Производитель', 'manufacturer', 'manufacturer2')"
                                            />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{trans('digital_drilling.daily_raport.diameter')}}
                                        </td>
                                        <td colspan="2">
                                            <select name="" id="" v-model="report.bit_info_daily[0].diameter_type">
                                                <option :value="diameter" v-for="diameter in bitDiameters">
                                                    {{diameter.diameter}}
                                                </option>
                                            </select>
                                        </td>
                                        <td colspan="2">
                                            <select name="" id="" v-model="report.bit_info_daily[1].diameter_type">
                                                <option :value="diameter" v-for="diameter in bitDiameters">
                                                    {{diameter.diameter}}
                                                </option>
                                            </select>
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
                                    <tr>
                                        <td>
                                            {{trans('digital_drilling.daily_raport.nozzles')}}
                                        </td>
                                        <td colspan="2" class="nozzles-td">
                                            <div class="nozzles-td-row">
                                                <div class="nozzles">
                                                    <select name="" id="" v-model="report.bit_info_daily[0].nozzle.nozzle_1" @change="nozzleSelect(1)">
                                                        <option value=""></option>
                                                        <option :value="nozzle" v-for="nozzle in Nozzles">{{nozzle}}</option>
                                                    </select>
                                                </div>
                                                <div class="nozzles">
                                                    <select name="" id="" v-model="report.bit_info_daily[0].nozzle.nozzle_2" @change="nozzleSelect(1)">
                                                        <option value=""></option>
                                                        <option :value="nozzle" v-for="nozzle in Nozzles">{{nozzle}}</option>
                                                    </select>
                                                </div>
                                                <div class="nozzles">
                                                    <select name="" id="" v-model="report.bit_info_daily[0].nozzle.nozzle_3" @change="nozzleSelect(1)">
                                                        <option value=""></option>
                                                        <option :value="nozzle" v-for="nozzle in Nozzles">{{nozzle}}</option>
                                                    </select>
                                                </div>
                                                <div class="nozzles">
                                                    <select name="" id="" v-model="report.bit_info_daily[0].nozzle.nozzle_4" @change="nozzleSelect(1)">
                                                        <option value=""></option>
                                                        <option :value="nozzle" v-for="nozzle in Nozzles">{{nozzle}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="nozzles-td-row">
                                                <div class="nozzles">
                                                    <select name="" id="" v-model="report.bit_info_daily[0].nozzle.nozzle_5" @change="nozzleSelect(1)">
                                                        <option value=""></option>
                                                        <option :value="nozzle" v-for="nozzle in Nozzles">{{nozzle}}</option>
                                                    </select>
                                                </div>
                                                <div class="nozzles">
                                                    <select name="" id="" v-model="report.bit_info_daily[0].nozzle.nozzle_6" @change="nozzleSelect(1)">
                                                        <option value=""></option>
                                                        <option :value="nozzle" v-for="nozzle in Nozzles">{{nozzle}}</option>
                                                    </select>
                                                </div>
                                                <div class="nozzles">
                                                    <select name="" id="" v-model="report.bit_info_daily[0].nozzle.nozzle_7" @change="nozzleSelect(1)">
                                                        <option value=""></option>
                                                        <option :value="nozzle" v-for="nozzle in Nozzles">{{nozzle}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="2" class="nozzles-td">
                                            <div class="nozzles-td-row">
                                                <div class="nozzles">
                                                    <select name="" id="" v-model="report.bit_info_daily[1].nozzle.nozzle_1" @change="nozzleSelect(2)">
                                                        <option value=""></option>
                                                        <option :value="nozzle" v-for="nozzle in Nozzles">{{nozzle}}</option>
                                                    </select>
                                                </div>
                                                <div class="nozzles">
                                                    <select name="" id="" v-model="report.bit_info_daily[1].nozzle.nozzle_2" @change="nozzleSelect(2)">
                                                        <option value=""></option>
                                                        <option :value="nozzle" v-for="nozzle in Nozzles">{{nozzle}}</option>
                                                    </select>
                                                </div>
                                                <div class="nozzles">
                                                    <select name="" id="" v-model="report.bit_info_daily[1].nozzle.nozzle_3" @change="nozzleSelect(2)">
                                                        <option value=""></option>
                                                        <option :value="nozzle" v-for="nozzle in Nozzles">{{nozzle}}</option>
                                                    </select>
                                                </div>
                                                <div class="nozzles">
                                                    <select name="" id="" v-model="report.bit_info_daily[1].nozzle.nozzle_4" @change="nozzleSelect(2)">
                                                        <option value=""></option>
                                                        <option :value="nozzle" v-for="nozzle in Nozzles">{{nozzle}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="nozzles-td-row">
                                                <div class="nozzles">
                                                    <select name="" id="" v-model="report.bit_info_daily[1].nozzle.nozzle_5" @change="nozzleSelect(2)">
                                                        <option value=""></option>
                                                        <option :value="nozzle" v-for="nozzle in Nozzles">{{nozzle}}</option>
                                                    </select>
                                                </div>
                                                <div class="nozzles">
                                                    <select name="" id="" v-model="report.bit_info_daily[1].nozzle.nozzle_6" @change="nozzleSelect(2)">
                                                        <option value=""></option>
                                                        <option :value="nozzle" v-for="nozzle in Nozzles">{{nozzle}}</option>
                                                    </select>
                                                </div>
                                                <div class="nozzles">
                                                    <select name="" id="" v-model="report.bit_info_daily[1].nozzle.nozzle_7" @change="nozzleSelect(2)">
                                                        <option value=""></option>
                                                        <option :value="nozzle" v-for="nozzle in Nozzles">{{nozzle}}</option>
                                                    </select>
                                                </div>
                                            </div>
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
                                        <td colspan="2" class="validation">
                                            <input type="number" v-model="report.bit_info_daily[0].drilling_from"
                                                   :class="{errorValidate:!checkMinMaxLengthVar(report.bit_info_daily[0].drilling_from , 0, 15000)}"
                                                   @input="checkMinMaxLength(report.bit_info_daily[0].drilling_from , 0, 15000, 'drilling_from0')"
                                            >
                                            <div class="info" data-title="Минимум:0, Максимум: 15000">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="error">
                                                        <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                        <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                        <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                                    </g>
                                                </svg>
                                            </div>
                                        </td>
                                        <td colspan="2" class="validation">
                                            <input type="number" v-model="report.bit_info_daily[1].drilling_from"
                                                   :class="{errorValidate:!checkMinMaxLengthVar(report.bit_info_daily[1].drilling_from , 0, 15000)}"
                                                   @input="checkMinMaxLength(report.bit_info_daily[1].drilling_from , 0, 15000, 'drilling_from1')"
                                            >
                                            <div class="info" data-title="Минимум:0, Максимум: 15000">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="error">
                                                        <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                        <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                        <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                                    </g>
                                                </svg>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{trans('digital_drilling.daily_raport.to_m')}}
                                        </td>
                                        <td colspan="2" class="validation">
                                            <input type="number" v-model="report.bit_info_daily[0].drilling_to"
                                                   :class="{errorValidate:!checkMinMaxLengthVar(report.bit_info_daily[0].drilling_to , 0, 15000)}"
                                                   @input="checkMinMaxLength(report.bit_info_daily[0].drilling_to , 0, 15000, 'drilling_to0')"
                                            >
                                            <div class="info" data-title="Минимум:0, Максимум: 15000">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="error">
                                                        <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                        <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                        <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                                    </g>
                                                </svg>
                                            </div>
                                        </td>
                                        <td colspan="2" class="validation">
                                            <input type="number" v-model="report.bit_info_daily[1].drilling_to"
                                                   :class="{errorValidate:!checkMinMaxLengthVar(report.bit_info_daily[1].drilling_to , 0, 15000)}"
                                                   @input="checkMinMaxLength(report.bit_info_daily[1].drilling_to , 0, 15000, 'drilling_to1')"
                                            >
                                            <div class="info" data-title="Минимум:0, Максимум: 15000">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="error">
                                                        <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                        <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                        <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                                    </g>
                                                </svg>
                                            </div>
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
                                        <td colspan="2" class="validation">
                                            <input type="number" v-model="report.bit_info_daily[0].interval_beg"
                                                   :class="{errorValidate:!checkMinMaxLengthVar(report.bit_info_daily[0].interval_beg , 0, 5000)}"
                                                   @input="checkMinMaxLength(report.bit_info_daily[0].interval_beg , 0, 5000, 'interval_beg0')"
                                            >
                                            <div class="info" data-title="Минимум:0, Максимум: 5000">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="error">
                                                        <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                        <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                        <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                                    </g>
                                                </svg>
                                            </div>
                                        </td>
                                        <td colspan="2" class="validation">
                                            <input type="number" v-model="report.bit_info_daily[1].interval_beg"
                                                   :class="{errorValidate:!checkMinMaxLengthVar(report.bit_info_daily[1].interval_beg , 0, 5000)}"
                                                   @input="checkMinMaxLength(report.bit_info_daily[1].interval_beg , 0, 5000, 'interval_beg1')"
                                            >
                                            <div class="info" data-title="Минимум:0, Максимум: 5000">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="error">
                                                        <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                        <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                        <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                                    </g>
                                                </svg>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{trans('digital_drilling.daily_raport.drilling_time_h')}}
                                        </td>
                                        <td colspan="2" class="validation">
                                            <input type="number" v-model="report.bit_info_daily[0].drilling_time"
                                                   @change="changeOveralTime(0)"
                                                   :class="{errorValidate:!checkMinMaxLengthVar(report.bit_info_daily[0].drilling_time , 0, 24)}"
                                                   @input="checkMinMaxLength(report.bit_info_daily[0].drilling_time , 0, 24, 'drilling_time0')"
                                            >
                                            <div class="info" data-title="Минимум:0, Максимум: 24">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="error">
                                                        <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                        <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                        <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                                    </g>
                                                </svg>
                                            </div>
                                        </td>
                                        <td colspan="2" class="validation">
                                            <input type="number" v-model="report.bit_info_daily[1].drilling_time"
                                                   @change="changeOveralTime(1)"
                                                   :class="{errorValidate:!checkMinMaxLengthVar(report.bit_info_daily[1].drilling_time , 0, 24)}"
                                                   @input="checkMinMaxLength(report.bit_info_daily[1].drilling_time , 0, 24, 'drilling_time1')"
                                            >
                                            <div class="info" data-title="Минимум:0, Максимум: 24">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="error">
                                                        <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                        <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                        <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                                    </g>
                                                </svg>
                                            </div>
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
                                                <select name="" id="" v-for="letter in bitWareLetters" v-model="report.bit_info_daily[0].bit_cond_iadc[bit_cond_iadc_letter[letter]]">
                                                    <option :value="opt" v-for="opt in bitWare[letter]">{{opt}}</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td colspan="2" class="align-middle bit-ware">
                                            <div class="select__name">
                                                <div v-for="letter in bitWareLetters">{{letter}}</div>
                                            </div>
                                            <div class="selects">
                                                <select name="" id="" v-for="letter in bitWareLetters" v-model="report.bit_info_daily[1].bit_cond_iadc[bit_cond_iadc_letter[letter]]">
                                                    <option :value="opt" v-for="opt in bitWare[letter]">{{opt}}</option>
                                                </select>
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
                                        <td colspan="2"><input type="time" v-model="report.mcs_daily.centrifuge"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">{{trans('digital_drilling.daily_raport.operating_hours_vibrating_sieve')}} №1</td>
                                        <td colspan="2"><input type="time" v-model="report.mcs_daily.vibrating_sieve1"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">{{trans('digital_drilling.daily_raport.operating_hours_vibrating_sieve')}} №2</td>
                                        <td colspan="2"><input type="time" v-model="report.mcs_daily.vibrating_sieve2"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">{{trans('digital_drilling.daily_raport.operating_hours_vibrating_sieve')}} №3</td>
                                        <td colspan="2"><input type="time" v-model="report.mcs_daily.vibrating_sieve3"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">{{trans('digital_drilling.daily_raport.sand_separator_work_hour')}}</td>
                                        <td colspan="2"><input type="time" v-model="report.mcs_daily.sand_operator"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">{{trans('digital_drilling.daily_raport.sludge_separator_work_hour')}}</td>
                                        <td colspan="2"><input type="time" v-model="report.mcs_daily.silt_separator"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">{{trans('digital_drilling.daily_raport.dispenser_hour')}}</td>
                                        <td colspan="2"><input type="time" v-model="report.mcs_daily.degasser"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-xl-5 col-lg-12 pl-0 nozzle-row">
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
                                            <select name="" id="" v-model="bha.bha_elements_type">
                                                <option :value="element" v-for="element in BHAelements">{{element.name_ru}}</option>
                                            </select>
                                        </td>
                                        <td class="validation">
                                            <input type="number" v-model="bha.outside_d"
                                                   :class="{errorValidate:!checkMinMaxLengthVar(bha.outside_d , 0, 2000)}"
                                                   @input="checkMinMaxLength(bha.outside_d , 0, 2000, 'outside_d'+i)"
                                            >
                                            <div class="info" data-title="Минимум:0, Максимум: 2000">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="error">
                                                        <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                        <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                        <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                                    </g>
                                                </svg>
                                            </div>
                                        </td>
                                        <td class="validation">
                                            <input type="number" v-model="bha.inside_d"
                                                   :class="{errorValidate:!checkMinMaxLengthVar(bha.inside_d , 0, 2000)}"
                                                   @input="checkMinMaxLength(bha.inside_d , 0, 2000, 'inside_d'+i)"
                                            >
                                            <div class="info" data-title="Минимум:0, Максимум: 2000">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="error">
                                                        <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                        <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                        <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                                    </g>
                                                </svg>
                                            </div>
                                        </td>
                                        <td>
                                            <select-add :options="threadTypes" :name="'threadTypes'+i" :header="bha.screw_size"
                                                        @selectOption="selectOption"
                                                        @addItem="openCatalog('Тип резьбы', 'screw_size', 'threadTypes'+i)"
                                            />
                                        </td>
                                        <td class="validation">
                                            <input type="number"
                                                   v-model="bha.length"
                                                   :class="{errorValidate:!checkMinMaxLengthVar(bha.length , 0, 2000)}"
                                                   @input="checkMinMaxLength(bha.length , 0, 2000, 'length'+i)"
                                            >
                                            <div class="info" data-title="Минимум:0, Максимум: 2000">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="error">
                                                        <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                        <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                        <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                                    </g>
                                                </svg>
                                            </div>
                                        </td>
                                        <td colspan="2" class="validation">
                                            <input type="number" v-model="bha.increasing_length"
                                                   :class="{errorValidate:!checkMinMaxLengthVar(bha.increasing_length , 0, 15000)}"
                                                   @input="checkMinMaxLength(bha.increasing_length , 0, 15000, 'increasing_length'+i)"
                                            >
                                            <div class="info" data-title="Минимум:0, Максимум: 15000">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="error">
                                                        <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                        <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                        <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                                    </g>
                                                </svg>
                                            </div>
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
                                <td>{{report.slt_daily[0].name_type}}</td>
                                <td>{{report.slt_daily[0].unit}}</td>
                                <td class="validation">
                                    <input type="number" v-model="report.slt_daily[0].trip"
                                           :class="{errorValidate:!checkMinMaxLengthVar(report.slt_daily[0].trip , 0, 50)}"
                                           @input="checkMinMaxLength(report.slt_daily[0].trip , 0, 50, 'trip0')"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 50">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td colspan="2">{{report.slt_daily[0].previous}}</td>
                                <td class="validation">
                                    <input type="number" v-model="report.slt_daily[0].daily"
                                           @change="summSLT(0)"
                                           :class="{errorValidate:!checkMinMaxLengthVar(report.slt_daily[0].daily , 0, 1000)}"
                                           @input="checkMinMaxLength(report.slt_daily[0].daily , 0, 1000, 'slt-daily0')"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 1000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td>
                                <span v-if="report.slt_daily[0].overall">
                                    {{report.slt_daily[0].overall}}
                                </span>
                                    <span v-else>
                                    {{report.slt_daily[0].previous}}
                                </span>
                                </td>
                                <td colspan="12" class="border-bottom-0 text-left align-bottom">{{trans('digital_drilling.daily_raport.application_required')}}</td>

                            </tr>
                            <tr>
                                <td>{{report.slt_daily[1].name_type}}</td>
                                <td>{{report.slt_daily[1].unit}}</td>
                                <td class="validation">
                                    <input type="number" v-model="report.slt_daily[1].trip"
                                           :class="{errorValidate:!checkMinMaxLengthVar(report.slt_daily[1].trip , 0, 50)}"
                                           @input="checkMinMaxLength(report.slt_daily[1].trip , 0, 50, 'trip1')"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 50">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td colspan="2">{{report.slt_daily[1].previous}}</td>
                                <td class="validation">
                                    <input type="number" v-model="report.slt_daily[1].daily"
                                           @change="summSLT(1)"
                                           :class="{errorValidate:!checkMinMaxLengthVar(report.slt_daily[1].daily , 0, 1000)}"
                                           @input="checkMinMaxLength(report.slt_daily[1].daily , 0, 1000, 'slt-daily1')"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 1000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td>
                                <span v-if="report.slt_daily[1].overall">
                                    {{report.slt_daily[1].overall}}
                                </span>
                                    <span v-else>
                                    {{report.slt_daily[1].previous}}
                                </span>
                                </td>
                                <td rowspan="3" colspan="12" class="border-top-0">
                                    <textarea name=""  cols="30" rows="10" v-model="report.oztok_daily.request"></textarea>
                                </td>
                            </tr>
                            <tr v-for="i in 2">
                                <td>{{report.slt_daily[i+1].name_type}}</td>
                                <td>{{report.slt_daily[i+1].unit}}</td>
                                <td class="validation">
                                    <input type="text" v-model="report.slt_daily[i+1].trip"
                                           :class="{errorValidate:!checkMinMaxLengthVar(report.slt_daily[i+1].trip , 0, 50)}"
                                           @input="checkMinMaxLength(report.slt_daily[i+1].trip , 0, 50, 'trip'+i+1)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 50">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td colspan="2">{{report.slt_daily[i+1].previous}}</td>
                                <td class="validation">
                                    <input type="number" v-model="report.slt_daily[i+1].daily"
                                           @change="summSLT(i+1)"
                                           :class="{errorValidate:!checkMinMaxLengthVar(report.slt_daily[i+1].daily , 0, 1000)}"
                                           @input="checkMinMaxLength(report.slt_daily[i+1].daily , 0, 1000, 'slt-daily'+i+1)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 1000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td>
                                <span v-if="report.slt_daily[i+1].overall">
                                    {{report.slt_daily[i+1].overall}}
                                </span>
                                    <span v-else>
                                    {{report.slt_daily[i+1].previous}}
                                </span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table class="tables table defaultTable">
                            <thead>
                            <tr>
                                <th colspan="6">
                                    {{trans('digital_drilling.daily_raport.well_control')}}
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="5" class="w-50">{{trans('digital_drilling.daily_raport.last_column_diameter')}}</td>
                                <td class="w-50">
                                    <select name="" id="" v-model="report.well_parameters_daily.last_casing_dia">
                                        <option :value="diameter" v-for="diameter in diameters">
                                            {{diameter.diameter}}
                                        </option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    {{trans('digital_drilling.daily_raport.depth_descent_last')}}
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="report.well_parameters_daily.last_casing_dep"
                                           :class="{errorValidate:!checkMinMaxLengthVar(report.well_parameters_daily.last_casing_dep , 0, 10000)}"
                                           @input="checkMinMaxLength(report.well_parameters_daily.last_casing_dep , 0, 10000, 'last_casing_dep')"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 10000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    {{trans('digital_drilling.daily_raport.diameter_next_column')}}
                                </td>
                                <td>
                                    <select name="" id="" v-model="report.well_parameters_daily.next_casing_dia">
                                        <option :value="diameter" v-for="diameter in diameters">
                                            {{diameter.diameter}}
                                        </option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    {{trans('digital_drilling.daily_raport.depth_descent_next_column')}}
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="report.well_parameters_daily.next_casing_dep"
                                           :class="{errorValidate:!checkMinMaxLengthVar(report.well_parameters_daily.next_casing_dep , 0, 10000)}"
                                           @input="checkMinMaxLength(report.well_parameters_daily.next_casing_dep , 0, 10000, 'next_casing_dep')"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 10000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    {{trans('digital_drilling.daily_raport.reservoir_integrity_test')}}
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="report.well_parameters_daily.form_integr_test"
                                           :class="{errorValidate:!checkMinMaxLengthVar(report.well_parameters_daily.form_integr_test , 0, 1000)}"
                                           @input="checkMinMaxLength(report.well_parameters_daily.form_integr_test , 0, 1000, 'form_integr_test')"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 1000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    {{trans('digital_drilling.daily_raport.equivalent_drill_density')}}
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="report.well_parameters_daily.equiv_mud_den"
                                           :class="{errorValidate:!checkMinMaxLengthVar(report.well_parameters_daily.equiv_mud_den , 0, 5000)}"
                                           @input="checkMinMaxLength(report.well_parameters_daily.equiv_mud_den , 0, 5000, 'equiv_mud_den')"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 5000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    {{trans('digital_drilling.daily_raport.drilling_fluid_density')}} <sup>3</sup>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="report.well_parameters_daily.test_mud_den"
                                           :class="{errorValidate:!checkMinMaxLengthVar(report.well_parameters_daily.test_mud_den , 0, 5000)}"
                                           @input="checkMinMaxLength(report.well_parameters_daily.test_mud_den , 0, 5000, 'test_mud_den')"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 5000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    {{trans('digital_drilling.daily_raport.drill_volume_solution')}} <sup>3</sup>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="report.well_parameters_daily.hole_mud_vol"
                                           :class="{errorValidate:!checkMinMaxLengthVar(report.well_parameters_daily.hole_mud_vol , 0, 1000)}"
                                           @input="checkMinMaxLength(report.well_parameters_daily.hole_mud_vol , 0, 1000, 'hole_mud_vol')"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 1000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    {{trans('digital_drilling.daily_raport.drill_volume_solution_in_reception')}} <sup>3</sup>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="report.well_parameters_daily.surf_mud_vol"
                                           :class="{errorValidate:!checkMinMaxLengthVar(report.well_parameters_daily.surf_mud_vol , 0, 1000)}"
                                           @input="checkMinMaxLength(report.well_parameters_daily.surf_mud_vol , 0, 1000, 'surf_mud_vol')"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 1000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    {{trans('digital_drilling.daily_raport.drill_volume_solution_in_stock')}} <sup>3</sup>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="report.well_parameters_daily.extra_mud_vol"
                                           :class="{errorValidate:!checkMinMaxLengthVar(report.well_parameters_daily.extra_mud_vol , 0, 1000)}"
                                           @input="checkMinMaxLength(report.well_parameters_daily.extra_mud_vol , 0, 1000, 'extra_mud_vol')"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 1000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">{{trans('digital_drilling.daily_raport.pump_2_ty6L3NB_1_300D')}} №1</td>
                                <td colspan="2" class="validation">
                                    <select-add :options="pumps" name="pump0" :header="report.pump_daily[0].pump_type"
                                                @selectOption="selectOption"
                                                @addItem="openCatalog('Насос №1', 'pump_type', 'pump0')"
                                    />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {{trans('digital_drilling.daily_raport.bushings_mm')}}
                                </td>
                                <td class="validation">
                                    <select-add :options="bushings" name="bushings0" :header="report.pump_daily[0].pump_barrel_type"
                                                @selectOption="selectOption"
                                                @addItem="openCatalog('Втулки, мм', 'pump_barrel', 'bushings0')"
                                    />
                                </td>
                                <td colspan="2">{{trans('digital_drilling.daily_raport.liter_stroke')}}</td>
                                <td class="validation">
                                    <input type="number" v-model="report.pump_daily[0].liters_type"
                                           :class="{errorValidate:!checkMinMaxLengthVar(report.pump_daily[0].liters_type , 0, 1000)}"
                                           @input="checkMinMaxLength(report.pump_daily[0].liters_type , 0, 1000, 'liters_type0')"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 1000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {{trans('digital_drilling.daily_raport.coef_floor')}}
                                </td>
                                <td class="validation">
                                    <input type="number"  v-model="report.pump_daily[0].coeff_type"
                                           :class="{errorValidate:!checkMinMaxLengthVar(report.pump_daily[0].coeff_type , 0, 100)}"
                                           @input="checkMinMaxLength(report.pump_daily[0].coeff_type , 0, 100, 'coeff_type0')"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 100">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td colspan="2">{{trans('digital_drilling.daily_raport.density_g_cm')}} <sup>3</sup></td>
                                <td class="validation">
                                    <input type="number" v-model="report.pump_daily[0].liquid_dens"
                                           :class="{errorValidate:!checkMinMaxLengthVar(report.pump_daily[0].liquid_dens , 0, 3)}"
                                           @input="checkMinMaxLength(report.pump_daily[0].liquid_dens , 0, 3, 'liquid_dens0')"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 3">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
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
                                <td colspan="4">{{trans('digital_drilling.daily_raport.pump_2_ty6L3NB_1_300D')}} №2</td>
                                <td colspan="2">
                                    <select-add :options="pumps" name="pump1" :header="report.pump_daily[1].pump_type"
                                                @selectOption="selectOption"
                                                @addItem="openCatalog('Насос №2', 'pump_type', 'pump1')"
                                    />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {{trans('digital_drilling.daily_raport.bushings_mm')}}
                                </td>
                                <td>
                                    <select-add :options="bushings" name="bushings1" :header="report.pump_daily[1].pump_barrel_type"
                                                @selectOption="selectOption"
                                                @addItem="openCatalog('Втулки, мм', 'pump_barrel', 'bushings1')"
                                    />
                                </td>
                                <td colspan="2">{{trans('digital_drilling.daily_raport.liter_stroke')}}</td>
                                <td class="validation">
                                    <input type="number" v-model="report.pump_daily[1].liters_type"
                                           :class="{errorValidate:!checkMinMaxLengthVar(report.pump_daily[1].liters_type , 0, 1000)}"
                                           @input="checkMinMaxLength(report.pump_daily[1].liters_type , 0, 1000, 'liters_type1')"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 1000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {{trans('digital_drilling.daily_raport.coef_floor')}}
                                </td>
                                <td class="validation">
                                    <input type="number"  v-model="report.pump_daily[1].coeff_type"
                                           :class="{errorValidate:!checkMinMaxLengthVar(report.pump_daily[1].coeff_type , 0, 100)}"
                                           @input="checkMinMaxLength(report.pump_daily[1].coeff_type , 0, 100, 'coeff_type1')"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 100">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td colspan="2">{{trans('digital_drilling.daily_raport.density_g_cm')}} <sup>3</sup></td>
                                <td class="validation">
                                    <input type="number" v-model="report.pump_daily[1].liquid_dens"
                                           :class="{errorValidate:!checkMinMaxLengthVar(report.pump_daily[1].liquid_dens , 0, 3)}"
                                           @input="checkMinMaxLength(report.pump_daily[1].liquid_dens , 0, 3, 'liquid_dens1')"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 3">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
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
                            <tr v-if="!pump[0].active">
                                <td colspan="5">Добавить еще <span class="add" @click="addPump">+</span></td>
                            </tr>
                            </tbody>
                        </table>
                        <table class="pump" v-if="pump[0].active">
                            <tbody>
                            <tr>
                                <td colspan="4">{{trans('digital_drilling.daily_raport.pump_2_ty6L3NB_1_300D')}} №3 <span class="add"  @click="deletePump(2)">-</span></td>
                                <td colspan="2">
                                    <select-add :options="pumps" name="pump2" :header="report.pump_daily[2].pump_type"
                                                @selectOption="selectOption"
                                                @addItem="openCatalog('Насос №3', 'pump_type', 'pump2')"
                                    />
                                </td>
                            </tr>
                            <tr>
                                <td>{{trans('digital_drilling.daily_raport.bushings_mm')}}</td>
                                <td>
                                    <select-add :options="bushings" name="bushings2" :header="report.pump_daily[2].pump_barrel_type"
                                                @selectOption="selectOption"
                                                @addItem="openCatalog('Втулки, мм', 'pump_barrel', 'bushings2')"
                                    />
                                </td>
                                <td colspan="2">{{trans('digital_drilling.daily_raport.liter_stroke')}}</td>
                                <td class="validation">
                                    <input type="number" v-model="report.pump_daily[2].liters_type"
                                           :class="{errorValidate:!checkMinMaxLengthVar(report.pump_daily[2].liters_type , 0, 1000)}"
                                           @input="checkMinMaxLength(report.pump_daily[2].liters_type , 0, 1000, 'liters_type2')"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 1000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {{trans('digital_drilling.daily_raport.coef_floor')}}
                                </td>
                                <td class="validation">
                                    <input type="number"  v-model="report.pump_daily[2].coeff_type"
                                           :class="{errorValidate:!checkMinMaxLengthVar(report.pump_daily[2].coeff_type , 0, 100)}"
                                           @input="checkMinMaxLength(report.pump_daily[2].coeff_type , 0, 100, 'coeff_type2')"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 100">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td colspan="2">{{trans('digital_drilling.daily_raport.density_g_cm')}} <sup>3</sup></td>
                                <td class="validation">
                                    <input type="number" v-model="report.pump_daily[2].liquid_dens"
                                           :class="{errorValidate:!checkMinMaxLengthVar(report.pump_daily[2].liquid_dens , 0, 3)}"
                                           @input="checkMinMaxLength(report.pump_daily[2].liquid_dens , 0, 3, 'liquid_dens2')"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 3">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
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
                            <tr v-if="!pump[1].active">
                                <td colspan="5">Добавить еще <span class="add" @click="addPump">+</span></td>
                            </tr>
                            </tbody>
                        </table>
                        <table class="pump" v-if="pump[1].active">
                            <tbody>
                            <tr>
                                <td colspan="4">{{trans('digital_drilling.daily_raport.pump_2_ty6L3NB_1_300D')}} №4 <span class="add" @click="deletePump(3)">-</span></td>
                                <td colspan="2">
                                    <select-add :options="pumps" name="pump3" :header="report.pump_daily[3].pump_type"
                                                @selectOption="selectOption"
                                                @addItem="openCatalog('Насос №4', 'pump_type', 'pump3')"
                                    />
                                </td>
                            </tr>
                            <tr>
                                <td>{{trans('digital_drilling.daily_raport.bushings_mm')}}</td>
                                <td>
                                    <select-add :options="bushings" name="bushings3" :header="report.pump_daily[3].pump_barrel_type"
                                                @selectOption="selectOption"
                                                @addItem="openCatalog('Втулки, мм', 'pump_barrel', 'bushings3')"
                                    />
                                </td>
                                <td colspan="2">{{trans('digital_drilling.daily_raport.liter_stroke')}}</td>
                                <td class="validation">
                                    <input type="number" v-model="report.pump_daily[3].liters_type"
                                           :class="{errorValidate:!checkMinMaxLengthVar(report.pump_daily[3].liters_type , 0, 1000)}"
                                           @input="checkMinMaxLength(report.pump_daily[3].liters_type , 0, 1000, 'liters_type3')"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 1000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {{trans('digital_drilling.daily_raport.coef_floor')}}
                                </td>
                                <td class="validation">
                                    <input type="number"  v-model="report.pump_daily[3].coeff_type"
                                           :class="{errorValidate:!checkMinMaxLengthVar(report.pump_daily[3].coeff_type , 0, 100)}"
                                           @input="checkMinMaxLength(report.pump_daily[3].coeff_type , 0, 100, 'coeff_type3')"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 100">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td colspan="2">{{trans('digital_drilling.daily_raport.density_g_cm')}} <sup>3</sup></td>
                                <td class="validation">
                                    <input type="number" v-model="report.pump_daily[3].liquid_dens"
                                           :class="{errorValidate:!checkMinMaxLengthVar(report.pump_daily[3].liquid_dens , 0, 3)}"
                                           @input="checkMinMaxLength(report.pump_daily[3].liquid_dens , 0, 3, 'liquid_dens3')"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 3">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td rowspan="5"><input type="text">{{trans('digital_drilling.daily_raport.pumping_pressure')}}</td>
                                <td><input type="text">{{trans('digital_drilling.daily_raport.stroke_min')}}</td>
                                <td><input type="text">{{trans('digital_drilling.daily_raport.depth_m')}}</td>
                                <td><input type="text">{{trans('digital_drilling.daily_raport.pressure_atm')}}</td>
                                <td></td>
                            </tr>
                            <tr v-for="(pressure, i) in report.pump_daily[3].pumping_pressure">
                                <td class="validation">
                                    <input type="number" v-model="pressure.progress"
                                           :class="{errorValidate:!checkMinMaxLengthVar(pressure.progress , 0, 1000)}"
                                           @input="checkMinMaxLength(pressure.progress , 0, 1000, 'pressure_progress'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 1000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number"  v-model="pressure.depth"
                                           :class="{errorValidate:!checkMinMaxLengthVar(pressure.depth , 0, 8000)}"
                                           @input="checkMinMaxLength(pressure.depth , 0, 8000, 'pressure_depth'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 8000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number"  v-model="pressure.pressure"
                                           :class="{errorValidate:!checkMinMaxLengthVar(pressure.pressure , 0, 500)}"
                                           @input="checkMinMaxLength(pressure.pressure , 0, 500, 'pressure_pressure'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 500">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
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
                            <tr v-for="(job_status, i) in report.job_status_6_hours">
                                <td><input type="time" v-model="job_status.tbeg" @input="getTotalTime(i, 6)"></td>
                                <td><input type="time" v-model="job_status.tend" @input="getTotalTime(i, 6)"></td>
                                <td>{{job_status.total_time}}</td>
                                <td><input type="text" v-model="job_status.rate"></td>
                                <td>
                                    <select name="" id="" v-model="job_status.operation_code">
                                        <option :value="code" v-for="code in operationCodes">{{code.name_ru}}</option>
                                    </select>
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
                                <td colspan="23">
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
                                <td></td>
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
                                <td></td>
                            </tr>
                            <tr v-for="(mud, i) in report.drilling_mud_daily">
                                <td colspan="4" class="w-10" >
                                    <select name="" id="" v-model="mud.mud_type">
                                        <option :value="type" v-for="type in drillingMudTypes">{{type.name_ru}}</option>
                                    </select>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.project_inlet_density"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.project_inlet_density , 0, 3)}"
                                           @input="checkMinMaxLength(mud.project_inlet_density , 0, 3, 'mud-project_inlet_density'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 3">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.fact_inlet_density"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.fact_inlet_density , 0, 3)}"
                                           @input="checkMinMaxLength(mud.fact_inlet_density , 0, 3, 'mud-fact_inlet_density'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 3">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.project_outlet_density"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.project_outlet_density , 0, 3)}"
                                           @input="checkMinMaxLength(mud.project_outlet_density , 0, 3, 'mud-project_outlet_density'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 3">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.fact_outlet_density"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.fact_outlet_density , 0, 3)}"
                                           @input="checkMinMaxLength(mud.fact_outlet_density , 0, 3, 'mud-fact_outlet_density'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 3">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.project_viscosity"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.project_viscosity , 26, 200)}"
                                           @input="checkMinMaxLength(mud.project_viscosity , 26, 200, 'mud-project_viscosity'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 200">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.fact_viscosity"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.fact_viscosity , 26, 200)}"
                                           @input="checkMinMaxLength(mud.fact_viscosity , 26, 200, 'mud-fact_viscosity'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 200">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.project_plastic_viscosity"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.project_plastic_viscosity , 0, 200)}"
                                           @input="checkMinMaxLength(mud.project_plastic_viscosity , 0, 200, 'mud-project_plastic_viscosity'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 200">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.fact_plastic_viscosity"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.fact_plastic_viscosity , 0, 200)}"
                                           @input="checkMinMaxLength(mud.fact_plastic_viscosity , 0, 200, 'mud-fact_plastic_viscosity'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 200">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.project_dynamic_shear_stress"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.project_dynamic_shear_stress , 0, 200)}"
                                           @input="checkMinMaxLength(mud.project_dynamic_shear_stress , 0, 200, 'mud-project_dynamic_shear_stress'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 200">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.fact_dynamic_shear_stress"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.fact_dynamic_shear_stress , 0, 200)}"
                                           @input="checkMinMaxLength(mud.fact_dynamic_shear_stress , 0, 200, 'mud-fact_dynamic_shear_stress'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 200">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.project_ph"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.project_ph , 4, 13)}"
                                           @input="checkMinMaxLength(mud.project_ph , 4, 13, 'mud-project_ph'+i)"
                                    >
                                    <div class="info" data-title="Минимум:4, Максимум: 13">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.fact_ph"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.fact_ph , 4, 13)}"
                                           @input="checkMinMaxLength(mud.fact_ph , 4, 13, 'mud-fact_ph'+i)"
                                    >
                                    <div class="info" data-title="Минимум:4, Максимум: 13">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.project_fluid_loss"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.project_fluid_loss , 0, 350)}"
                                           @input="checkMinMaxLength(mud.project_fluid_loss , 0, 350, 'mud-project_fluid_loss'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 350">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.fact_fluid_loss"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.fact_fluid_loss , 0, 350)}"
                                           @input="checkMinMaxLength(mud.fact_fluid_loss , 0, 350, 'mud-fact_fluid_loss'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 350">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.project_friction_coefficient"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.project_friction_coefficient , 0, 1)}"
                                           @input="checkMinMaxLength(mud.project_friction_coefficient , 0, 1, 'mud-project_friction_coefficient'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 1">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.fact_friction_coefficient"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.fact_friction_coefficient , 0, 1)}"
                                           @input="checkMinMaxLength(mud.fact_friction_coefficient , 0, 1, 'mud-fact_friction_coefficient'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 1">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.project_t_in_out"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.project_t_in_out , 0, 300)}"
                                           @input="checkMinMaxLength(mud.project_t_in_out , 0, 300, 'mud-project_t_in_out'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 300">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.fact_t_in_out"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.fact_t_in_out , 0, 300)}"
                                           @input="checkMinMaxLength(mud.fact_t_in_out , 0, 300, 'mud-fact_t_in_out'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 300">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td @click="deleteMudDaily(i)"><img src="/img/digital-drilling/delete-row.svg" class="delete-row" alt=""></td>
                            </tr>
                            <tr>
                                <td colspan="23"><p @click="addMudDaily" class="pushElement">Добавить</p></td>
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
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2">10 {{trans('digital_drilling.daily_raport.sec')}}</td>
                                <td colspan="2">10 {{trans('digital_drilling.daily_raport.min')}}</td>
                                <td colspan="2">{{trans('digital_drilling.daily_raport.ci_mg')}}</td>
                                <td colspan="2">Kcl - %</td>
                                <td></td>
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
                                <td></td>
                            </tr>
                            <tr v-for="(mud, i) in report.drilling_mud_daily">
                                <td class="validation">
                                    <input type="number" v-model="mud.project_total_solids"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.project_total_solids , 0, 50)}"
                                           @input="checkMinMaxLength(mud.project_total_solids , 0, 50, 'mud-project_total_solids'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 50">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.fact_total_solids"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.fact_total_solids , 0, 50)}"
                                           @input="checkMinMaxLength(mud.fact_total_solids , 0, 50, 'mud-fact_total_solids'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 50">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.project_total_sand"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.project_total_sand , 0, 10)}"
                                           @input="checkMinMaxLength(mud.project_total_sand , 0, 10, 'mud-project_total_sand'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 10">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.fact_total_sand"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.fact_total_sand , 0, 10)}"
                                           @input="checkMinMaxLength(mud.fact_total_sand , 0, 10, 'mud-fact_total_sand'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 10">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.project_mbt"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.project_mbt , 0, 200)}"
                                           @input="checkMinMaxLength(mud.project_mbt , 0, 200, 'mud-project_mbt'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 200">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.fact_mbt"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.fact_mbt , 0, 200)}"
                                           @input="checkMinMaxLength(mud.fact_mbt , 0, 200, 'mud-fact_mbt'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 200">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.project_water_content"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.project_water_content , 0, 100)}"
                                           @input="checkMinMaxLength(mud.project_water_content , 0, 100, 'mud-project_water_content'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 100">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.fact_water_content"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.fact_water_content , 0, 100)}"
                                           @input="checkMinMaxLength(mud.fact_water_content , 0, 100, 'mud-fact_water_content'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 100">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.project_lube_content"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.project_lube_content , 0, 20)}"
                                           @input="checkMinMaxLength(mud.project_lube_content , 0, 20, 'mud-project_lube_content'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 20">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.fact_lube_content"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.fact_lube_content , 0, 20)}"
                                           @input="checkMinMaxLength(mud.fact_lube_content , 0, 20, 'mud-fact_lube_content'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 20">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.project_static_shear_stress_10sec"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.project_static_shear_stress_10sec , 0, 120)}"
                                           @input="checkMinMaxLength(mud.project_static_shear_stress_10sec , 0, 120, 'mud-project_static_shear_stress_10sec'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 120">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.fact_static_shear_stress_10sec"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.fact_static_shear_stress_10sec , 0, 120)}"
                                           @input="checkMinMaxLength(mud.fact_static_shear_stress_10sec , 0, 120, 'mud-fact_static_shear_stress_10sec'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 120">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.project_static_shear_stress_10min"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.project_static_shear_stress_10min , 0, 120)}"
                                           @input="checkMinMaxLength(mud.project_static_shear_stress_10min , 0, 120, 'mud-project_static_shear_stress_10min'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 120">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.fact_static_shear_stress_10min"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.fact_static_shear_stress_10min , 0, 120)}"
                                           @input="checkMinMaxLength(mud.fact_static_shear_stress_10min , 0, 120, 'mud-fact_static_shear_stress_10min'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 120">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.project_filter_cake"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.project_filter_cake , 0, 30)}"
                                           @input="checkMinMaxLength(mud.project_filter_cake , 0, 30, 'mud-project_filter_cake'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 30">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.fact_filter_cake"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.fact_filter_cake , 0, 30)}"
                                           @input="checkMinMaxLength(mud.fact_filter_cake , 0, 30, 'mud-fact_filter_cake'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 30">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.project_total_hardness"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.project_total_hardness , 0, 20000)}"
                                           @input="checkMinMaxLength(mud.project_total_hardness , 0, 20000, 'mud-project_total_hardness'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 20000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.fact_total_hardness"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.fact_total_hardness , 0, 20000)}"
                                           @input="checkMinMaxLength(mud.fact_total_hardness , 0, 20000, 'mud-fact_total_hardness'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 20000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.project_concentration_cl"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.project_concentration_cl , 0, 50000)}"
                                           @input="checkMinMaxLength(mud.project_concentration_cl , 0, 50000, 'mud-project_concentration_cl'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 50000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.fact_concentration_cl"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.fact_concentration_cl , 0, 50000)}"
                                           @input="checkMinMaxLength(mud.fact_concentration_cl , 0, 50000, 'mud-fact_concentration_cl'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 50000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.project_concentration_kcl"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.project_concentration_kcl , 0, 24)}"
                                           @input="checkMinMaxLength(mud.project_concentration_kcl , 0, 24, 'mud-project_concentration_kcl'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 24">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="mud.fact_concentration_kcl"
                                           :class="{errorValidate:!checkMinMaxLengthVar(mud.fact_concentration_kcl , 0, 24)}"
                                           @input="checkMinMaxLength(mud.fact_concentration_kcl , 0, 24, 'mud-fact_concentration_kcl'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 24">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                        <table class="tables table defaultTable">
                            <thead>
                            <tr>
                                <th colspan="12" class="title">{{trans('digital_drilling.daily_raport.component_composition_drilling_mud')}}</th>
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
                                <td></td>
                            </tr>
                            <tr v-for="(compositionDaily, i) in report.drilling_mud_composition_daily">
                                <td>
                                    <select-add :options="nameChemicals" :name="'chemical_name'+i" :header="compositionDaily.mud_composition"
                                                @selectOption="selectOption"
                                                @addItem="openCatalog('Наименование химреагентов', 'mud_composition', 'chemical_name'+i)"/>
                                </td>
                                <td><input type="text" v-model="compositionDaily.functions"></td>
                                <td><input type="text" v-model="compositionDaily.metrics"></td>
                                <td class="validation">
                                    <input type="number" v-model="compositionDaily.density"
                                           :class="{errorValidate:!checkMinMaxLengthVar(compositionDaily.density , 0, 10000)}"
                                           @input="checkMinMaxLength(compositionDaily.density , 0, 10000, 'compositionDaily_density'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 10000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="compositionDaily.total_consumption"
                                           :class="{errorValidate:!checkMinMaxLengthVar(compositionDaily.total_consumption , 0, 3000)}"
                                           @input="checkMinMaxLength(compositionDaily.total_consumption , 0, 3000, 'compositionDaily_total_consumption'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 3000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td>{{compositionDaily.availability}}</td>
                                <td class="validation">
                                    <input type="number" v-model="compositionDaily.received_day"
                                           :class="{errorValidate:!checkMinMaxLengthVar(compositionDaily.received_day , 0, null)}"
                                           @input="checkMinMaxLength(compositionDaily.received_day , 0, null, 'compositionDaily_received_day'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="compositionDaily.consumption_day"
                                           :class="{errorValidate:!checkMinMaxLengthVar(compositionDaily.consumption_day , 0, null)}"
                                           @input="checkMinMaxLength(compositionDaily.consumption_day , 0, null, 'compositionDaily_consumption_day'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td>{{subtractValues(sumValues(compositionDaily.availability, compositionDaily.received_day), compositionDaily.consumption_day)}}</td>
                                <td @click="deleteComposition(i)"><img src="/img/digital-drilling/delete-row.svg" class="delete-row" alt=""></td>
                            </tr>
                            <tr>
                                <td @click="addComposition" colspan="12">
                                    <p class="pushElement">Добавить</p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table class="tables table defaultTable">
                            <thead>
                            <tr>
                                <th colspan="6" class="title">{{trans('digital_drilling.daily_raport.consumption_tooling_materials')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="w-20">{{trans('digital_drilling.daily_raport.name_materials')}}</td>
                                <td>{{trans('digital_drilling.daily_raport.before')}}</td>
                                <td>{{trans('digital_drilling.daily_raport.coming')}}</td>
                                <td>{{trans('digital_drilling.daily_raport.consumption')}}</td>
                                <td>{{trans('digital_drilling.daily_raport.total_balance')}}</td>
                                <td></td>
                            </tr>

                            <tr v-for="(consDaily, i) in report.material_cons_daily">
                                <td><input type="text" v-model="consDaily.name"></td>
                                <td>{{consDaily.last}}</td>
                                <td class="validation">
                                    <input type="number" v-model="consDaily.receipts"
                                           :class="{errorValidate:!checkMinMaxLengthVar(consDaily.receipts , 0, null)}"
                                           @input="checkMinMaxLength(consDaily.receipts , 0, null, 'consDaily_receipts'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="consDaily.consumption"
                                           :class="{errorValidate:!checkMinMaxLengthVar(consDaily.consumption , 0, null)}"
                                           @input="checkMinMaxLength(consDaily.consumption , 0, null, 'consDaily_consumption'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td>{{subtractValues(sumValues(consDaily.last, consDaily.receipts), consDaily.consumption)}}</td>
                                <td @click="deleteConsDaily(i)"><img src="/img/digital-drilling/delete-row.svg" class="delete-row" alt=""></td>
                            </tr>
                            <tr>
                                <td colspan="6" @click="addConsDaily"><p class="pushElement">Добавить</p></td>
                            </tr>
                            </tbody>
                        </table>
                        <table class="tables table defaultTable">
                            <thead>
                            <tr>
                                <th colspan="7" class="title">{{trans('digital_drilling.daily_raport.GEOLOGICAL_INFORMATION')}}</th>
                                <th colspan="7" class="title">{{trans('digital_drilling.daily_raport.CORE_COLLECTION')}}</th>
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
                                <td colspan="2">{{trans('digital_drilling.daily_raport.sampling_interval')}}</td>
                                <td rowspan="2">{{trans('digital_drilling.daily_raport.plan')}}</td>
                                <td rowspan="2">{{trans('digital_drilling.daily_raport.fact_m')}}</td>
                                <td rowspan="2">{{trans('digital_drilling.daily_raport.takeaway')}}</td>
                                <td rowspan="2"></td>
                            </tr>
                            <tr>
                                <td>{{trans('digital_drilling.daily_raport.plan')}}</td>
                                <td>{{trans('digital_drilling.daily_raport.fact_m')}}</td>
                                <td>{{trans('digital_drilling.daily_raport.powerful')}}</td>
                                <td>От</td>
                                <td>До</td>
                            </tr>
                            <tr v-for="(geological, i) in report.geo_data_daily">
                                <td>
                                    <select-add :options="stratigraphy" :name="'stratigraphy'+i" :header="geological.stratigraphy"
                                                @selectOption="selectOption"
                                                @addItem="openCatalog('Стратиграфия', 'stratigraphy', 'stratigraphy'+i)"/>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="geological.plan_top_of_formation"
                                           :class="{errorValidate:!checkMinMaxLengthVar(geological.plan_top_of_formation , 0, 6000)}"
                                           @input="checkMinMaxLength(geological.plan_top_of_formation , 0, 6000, 'plan_top_of_formation'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 6000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="geological.fact_top_of_formation"
                                           :class="{errorValidate:!checkMinMaxLengthVar(geological.fact_top_of_formation , 0, 6000)}"
                                           @input="checkMinMaxLength(geological.fact_top_of_formation , 0, 6000, 'fact_top_of_formation'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 6000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="geological.thickness_top_of_formation"
                                           :class="{errorValidate:!checkMinMaxLengthVar(geological.thickness_top_of_formation , 0, 8000)}"
                                           @input="checkMinMaxLength(geological.thickness_top_of_formation , 0, 8000, 'thickness_top_of_formation'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 8000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td>
                                    <select-add :options="lithology" :name="'lithology'+i" :header="geological.lithology"
                                                @selectOption="selectOption"
                                                @addItem="openCatalog('Литология', 'lithology', 'lithology'+i)"/>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="geological.formation_pressure_gradient"
                                           :class="{errorValidate:!checkMinMaxLengthVar(geological.formation_pressure_gradient , 0, 3000)}"
                                           @input="checkMinMaxLength(geological.formation_pressure_gradient , 0, 3000, 'formation_pressure_gradient'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 3000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="geological.frac_gradient"
                                           :class="{errorValidate:!checkMinMaxLengthVar(geological.frac_gradient , 0, 3000)}"
                                           @input="checkMinMaxLength(geological.frac_gradient , 0, 3000, 'frac_gradient'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 3000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td><input type="text" v-model="report.coring_daily[i].age"></td>
                                <td class="validation">
                                    <input type="number" v-model="report.coring_daily[i].interval_from"
                                           :class="{errorValidate:!checkMinMaxLengthVar(geological.interval_from , 0, 8000)}"
                                           @input="checkMinMaxLength(geological.interval_from , 0, 8000, 'interval_from'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 8000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="report.coring_daily[i].interval_to"
                                           :class="{errorValidate:!checkMinMaxLengthVar(geological.interval_to , 0, 8000)}"
                                           @input="checkMinMaxLength(geological.interval_to , 0, 8000, 'interval_to'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 8000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="report.coring_daily[i].plan"
                                           :class="{errorValidate:!checkMinMaxLengthVar(report.coring_daily[i].plan , 0, 1000)}"
                                           @input="checkMinMaxLength(report.coring_daily[i].plan , 0, 1000, 'coring_daily_plan'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 1000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="report.coring_daily[i].fact"
                                           :class="{errorValidate:!checkMinMaxLengthVar(report.coring_daily[i].fact , 0, 1000)}"
                                           @input="checkMinMaxLength(report.coring_daily[i].fact , 0, 1000, 'coring_daily_fact'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 1000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="report.coring_daily[i].percentage"
                                           :class="{errorValidate:!checkMinMaxLengthVar(report.coring_daily[i].percentage , 0, 100)}"
                                           @input="checkMinMaxLength(report.coring_daily[i].percentage , 0, 100, 'coring_daily_percentage'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 100">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td @click="deleteStratigraphy(i)"><img src="/img/digital-drilling/delete-row.svg" class="delete-row" alt=""></td>
                            </tr>
                            <tr>
                                <td colspan="13" @click="addStratigraphy">
                                    <p class="pushElement">Добавить</p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table class="tables table defaultTable">
                            <thead>
                            <tr>
                                <th colspan="6" class="title">{{trans('digital_drilling.daily_raport.INCLINOMETRY')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{trans('digital_drilling.daily_raport.depth_m')}}</td>
                                <td>{{trans('digital_drilling.daily_raport.angle')}}</td>
                                <td>{{trans('digital_drilling.daily_raport.azimuth')}}</td>
                                <td>{{trans('digital_drilling.daily_raport.type_instrument')}}</td>
                                <td></td>
                            </tr>
                            <tr v-for="(incl, i) in report.incl_daily">
                                <td class="validation">
                                    <input type="number" v-model="incl.depth"
                                           :class="{errorValidate:!checkMinMaxLengthVar(incl.depth , 0, 8000)}"
                                           @input="checkMinMaxLength(incl.depth , 0, 8000, 'incl_depth'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 8000">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="incl.angle"
                                           :class="{errorValidate:!checkMinMaxLengthVar(incl.angle , 0, 120)}"
                                           @input="checkMinMaxLength(incl.angle , 0, 120, 'incl_angle'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 120">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td class="validation">
                                    <input type="number" v-model="incl.bearing"
                                           :class="{errorValidate:!checkMinMaxLengthVar(incl.bearing , 0, 360)}"
                                           @input="checkMinMaxLength(incl.bearing , 0, 360, 'incl_bearing'+i)"
                                    >
                                    <div class="info" data-title="Минимум:0, Максимум: 360">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="error">
                                                <path id="Path 5" d="M9 6V9.75" stroke="#F94A5B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path id="Oval" fill-rule="evenodd" clip-rule="evenodd" d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z" fill="#F94A5B"/>
                                                <path id="Oval_2" fill-rule="evenodd" clip-rule="evenodd" d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85787 13.1421 1.5 9 1.5C4.85787 1.5 1.5 4.85787 1.5 9C1.5 13.1421 4.85787 16.5 9 16.5Z" stroke="#F94A5B" stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td>
                                    <select-add :options="deviceType" :name="'inclino1'+i" :header="incl.equip_type"
                                                @selectOption="selectOption"
                                                @addItem="openCatalog('Тип прибора', 'device_type', 'inclino1'+i)"/>
                                </td>
                                <td @click="deleteInclino(i)"><img src="/img/digital-drilling/delete-row.svg" class="delete-row" alt=""></td>
                            </tr>
                            <tr>
                                <td colspan="6" @click="addInclino">
                                    <p class="pushElement">Добавить</p>
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
                                <td><input type="text" v-model="report.safety_daily.fire_alarm"></td>
                                <td><input type="text" v-model="report.safety_daily.h2s_test"></td>
                                <td><input type="text" v-model="report.safety_daily.instructions"></td>
                                <td><input type="text" v-model="report.safety_daily.ogws_trip"></td>
                                <td><input type="text" v-model="report.safety_daily.bop_p_test"></td>
                                <td><input type="text" v-model="report.safety_daily.bop_func_test"></td>
                                <td><input type="text" v-model="report.safety_daily.ogws_alarm"></td>
                                <td><input type="text" v-model="report.safety_daily.first_aid"></td>
                                <td><input type="text" v-model="report.safety_daily.safety_meeting"></td>
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
                <div class="characteristic__modal" v-if="addRigModal">
                    <div class="characteristic_content">
                        <div class="characteristic_header">
                            <span>Технические характеристики ZJ-40</span>
                            <div class="characteristic_header-close" @click="addItemRig">
                                Закрыть
                            </div>
                        </div>
                        <div class="characteristic_body defaultScroll">
                            <table class="table defaultTable modalTable" v-if="rigCharacteristic.length>0">
                                <tbody>
                                <tr>
                                    <th>Название</th>
                                    <th>Значение</th>
                                </tr>
                                <tr>
                                    <td>{{rigCharacteristic[0][0].parameter}}</td>
                                    <td>
                                        <select-add :options="drillingContractors" name="drillingContractors" :header="companyName"
                                                    @selectOption="selectOption"
                                                    @addItem="openCatalog('Буровой подрядчик', 'company', 'companyName')"
                                                    :class="{error: companyName=='' && addRigModalError}"
                                        /></td>
                                </tr>
                                <tr>
                                    <td>{{rigCharacteristic[0][1].parameter}}</td>
                                    <td><input type="text" v-model="headDrilling" :class="{error: headDrilling=='' && addRigModalError}"></td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="table defaultTable modalTable" v-if="rigCharacteristic.length>0">
                                <tbody>
                                <tr>
                                    <th>Параметры</th>
                                    <th>Ед. изм.</th>
                                    <th>Значение</th>
                                </tr>
                                <tr v-for="(rig, i) in rigCharacteristic[1]">
                                    <td>{{rig.parameter}}</td>
                                    <td>{{rig.unit}}</td>
                                    <td>
                                        <input type="text" v-model="rig.value" :class="{error: addRigModalError && rig.value=='' && i==0}">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="characteristic_body-save">
                            <button @click="uploadRig">{{trans('app.save')}}</button>
                        </div>
                    </div>
                </div>
                <div class="catalog-add" v-if="catalogModal">
                    <div class="catalog-add-inner">
                        <div class="catalog-add-form">
                            <div class="catalog-add-header">
                                <div class="catalog-add-title">
                                    {{currentCatalogAdd.name}}
                                </div>
                                <div class="catalog-add-close" @click="catalogModal=false">
                                    Закрыть
                                </div>
                            </div>
                            <div class="catalog-add-content">
                                <input type="text" :class="{error: catalogError && catalog==''}"  v-model="catalog">
                                <button @click="saveCatalog">{{trans('app.save')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="catalog-add" v-if="catalogModalCompany">
                    <div class="catalog-add-inner">
                        <div class="catalog-add-form">
                            <div class="catalog-add-header">
                                <div class="catalog-add-title">
                                    {{currentCatalogAdd.name}}
                                </div>
                                <div class="catalog-add-close" @click="catalogModalCompany=false">
                                    Закрыть
                                </div>
                            </div>
                            <div class="catalog-add-content">
                                <input type="text" :class="{error: catalogError && catalogCompany.name_ru==''}"  v-model="catalogCompany.name_ru" placeholder="Напишите назание">
                                <input type="number" :class="{error: (catalogError && catalogCompany.bin=='') || (catalogError && catalogCompany.bin.toString().length !=12)}"  v-model="catalogCompany.bin" placeholder="Напишите БИН, число, 12 цифр">
                                <button @click="saveCatalogCompany">{{trans('app.save')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="catalog-add" v-if="saveModal">
                <div class="catalog-add-inner">
                    <div class="catalog-add-form m-height">
                        <div class="catalog-add-header justify-content-center">
                            <div class="catalog-add-title text-center">
                                Вы точно хотите сохранить?
                            </div>
                        </div>
                        <div class="catalog-add-content flex align-items-center justify-content-between">
                            <button class="catalog-add-close" @click="saveModal=false">
                                Отмена
                            </button>
                            <button @click="saveReport">{{trans('app.save')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <PreviousDailyRaport v-else :report="previousReport"
                               :user="user"
                               :show="show"
                               @closePreviousReport="previous=false"
                               @changePreviousReport="changePreviousReport"
                               @editReport = "editReport"
        />
    </div>
<<<<<<< HEAD
    <previous-daily-raport v-else :report="previousReport"
                           :user="user"
                           :show="show"
                           :fixedStyle="fixedStyle"
                           @closePreviousReport="previous=false"
                           @changePreviousReport="changePreviousReport"
                           @editReport = "editReport"
                           @closeReport="closeReport"
    />
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
    import PreviousDailyRaport from './PreviousDailyRaport'

    export default {
        name: "DailyRaport",
        components: {SelectInput, NozzlesTable, SelectAdd, PreviousDailyRaport},
        props: ['report', 'user', 'isEdit', 'show', 'fixedStyle'],
        data(){
            return{
                reportDate: moment(this.report.report_daily.date, 'DD-MM-YYYY').format('YYYY-MM-DD'),
                saveModal: false,
                previous: false,
                previousReport: false,
                summTotalTime: '00:00',
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
                newMudDaily: mudDaily,
                componentComposition: componentComposition,
                geologicalInformation: geologicalInformation,
                inclino: inclino,
                threadTypesJson: threadTypesJson,
                catalog: '',
                catalogCompany: {
                    name_ru: '',
                    bin: ''
                },
                currentCatalogAdd: {
                    name: '',
                    url: '',
                    type: '',
                },
                headDrilling: '',
                companyName: {
                    id: '',
                    name_ru: '',
                },
                Unit_Name: {
                    id: '',
                    name_ru: ''
                },
                manufacturer1: {
                    id: '',
                    name_ru: ''
                },
                manufacturer2: {
                    id: '',
                    name_ru: ''
                },
                catalogError: false,
                catalogModal: false,
                catalogModalCompany: false,
                rigCharacteristic: [],
                addRigModal: false,
                addRigModalError: false,
                constructors: [],
                bushings:[],
                diameters:[],
                drillingMudTypes: [],
                BHAelements: [],
                operationCodes:[],
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
                threadTypes: [],
                pumps: [],
                timeSpents: ['Организ. простой', 'Ремонт после 21 часа', 'Осложения по стволу', 'Авария',
                             'Неэффективность работы', 'Ожидание оборудования', 'Ожидание персонала',
                             'Ожидание техники', 'Некачествен. цементир.', 'Ожидание указ. Заказчика',
                             'Подогрев оборудования', 'Ожидание химреагентов', 'Отключение элек.энерг. ', 'Превыш. нормы времени'],
                stratigraphy: [],
                lithology: [],
                drillingContractors: [],
                deviceType: [],
                bitWare: {
                    I: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    O: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    D: ["BC", "BF", "BT", "BU", "CC", "CD", "CI", "CR", "CT", "ER", "FC", "HC", "JD", "LC", "LN",
                        "LT", "OC", "PB", "PN", "RG", "RO", "SD", "SS", "TR", "WO", "WT", "NO"],
                    L: ["C", "N", "T", "S", "G", "A" ],
                    B: [0, 1, 2, 3, 4, 5, 6, 7, 8, "E", "F", "N", "X"],
                    G: [1, "1/16", "1/8", "1/4"],
                    D1:  ["BC", "BF", "BT", "BU", "CC", "CD", "CI", "CR", "CT", "ER", "FC", "HC", "JD", "LC", "LN",
                        "LT", "OC", "PB", "PN", "RG", "RO", "SD", "SS", "TR", "WO", "WT", "NO"],
                    R: ["BHA", "CM", "CP", "DMF", "DP", "DSF", "DST", "DTF", "FM", "HP", "HR",
                        "LIH”", "LOG;", "PP”", "PR”", "RIG", "TD”", "TQ", "TW", "WC"],
                },
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
                bitWareLetters: ["I", "O", "D", "L", "B", "G", "D1", "R"],
                operation1: [],
                operation2: [],
                drillingRigTypes:[],
                drillingRig:[],
                nameChemicals: [],
                NozzlesTable: {
                    7: [ 0.038, 0.075,  0.113,  0.150,  0.188,  0.225,  0.263,  0.301,  0.338,  0.376],
                    8: [ 0.049, 0.098,  0.147,  0.196,  0.245,  0.295,  0.344,  0.393,  0.442,  0.491],
                    9: [0.062,	0.124,	0.186,	0.249,	0.311,	0.373,	0.435,	0.497,	0.559,	0.621],
                    10:[ 0.077,	0.153,	0.230,	0.307,	0.383,	0.460,	0.537,	0.614,	0.690,	0.767],
                    11:[ 0.093,	0.186,	0.278,	0.371,	0.464,	0.557,	0.650,	0.742,	0.835,	0.928],
                    12:[ 0.110,	0.221,	0.331,	0.442,	0.552,	0.663,	0.773,	0.884,	0.994,	1.104],
                    13:[ 0.130,	0.259,	0.389,	0.518,	0.648,	0.778,	0.907,	1.037,	1.167,	1.296],
                    14:[ 0.150,	0.301,	0.451,	0.601,	0.752,	0.902,	1.052,	1.203,	1.353,	1.503],
                    15:[ 0.173,	0.345,	0.518,	0.690,	0.863,	1.035,	1.208,	1.381,	1.553,	1.726],
                    16:[ 0.196,	0.393,	0.589,	0.785,	0.982,	1.178,	1.374,	1.571,	1.767,	1.963],
                    18:[ 0.249,	0.497,	0.746,	0.994,	1.243,	1.491,	1.740,	1.988,	2.237,	2.485],
                    20:[ 0.307,	0.614,	0.920,	1.227,	1.534,	1.841,	2.148,	2.454,	2.761,	3.068],
                    22:[ 0.371,	0.742,	1.114,	1.485,	1.856,	2.227,	2.599,	2.970,	3.341,	3.712],
                    24:[ 0.442,	0.884,	1.325,	1.767,	2.209,	2.651,	3.093,	3.534,	3.976,	4.418],
                    26:[ 0.518,	1.037,	1.555,	2.074,	2.592,	3.111,	3.629,	4.148,	4.666,	5.185],
                    28:[ 0.601,	1.203,	1.804,	2.405,	3.007,	3.608,	4.209,	4.811,	5.412,	6.013],
                    30:[ 0.690,	1.381,	2.071,	2.761,	3.451,	4.142,	4.832,	5.522,	6.213,	6.903],
                    32:[ 0.785,	1.571,	2.356,	3.142,	3.927,	4.712,	5.498,	6.283,	7.069,	7.854],

                },
                Nozzles: [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 20, 22, 24, 26, 28, 30, 32],
                bitTypes:[],
                manufacturers: [],
                bitDiameters: [],
                unitNames: ['ZJ-10', 'ZJ-15', 'ZJ-20', 'ZJ-30', 'ZJ-40', 'ZJ-40/2250DBT', 'ZJ-50', 'ZJ-70', 'МБУ ZJ-30',
                            'МБУ ZJ-30/27', 'МБУ-125', 'МБУ-140', 'МБУ-160', 'XJ-120', 'XJ-100', 'XJ-350', 'XJ-450',
                            'XJ-550', 'XJ-750', 'XCMG XZ360E', 'XCMG XR150d', 'IRI IDECO-270', 'АРБ-100', 'VR-500'],
            }
        },
        watch:{
            report(){
                this.reportDate = moment(this.report.report_daily.date, 'DD-MM-YYYY').format('YYYY-MM-DD')
                this.getResourses()
            },
        },
        mounted(){
            if (this.show){
                this.openForShow()
            } else{
                this.getResourses()
            }

        },
        methods: {
            getResourses(){
                this.getRigType()
                this.getRig()
                this.getBitDiameters()
                this.getDrillingMudTypes()
                this.getThreadTypes()
                this.getDiameters()
                this.getConstructors()
                this.getDrillingContractors()
                this.getOperationCodes()
                this.getBitTypes()
                this.getManufacturers()
                this.getPumps()
                this.getBushings()
                this.getNameChemicals()
                this.getStratigraphy()
                this.getLithology()
                this.getOperation1()
                this.getoperation2()
                this.getDeviceType()
                this.getBHAelements()
                this.changeTotalTime(24)
                this.changeTotalTime(6)
            },
            closeReport(){
                this.$emit('closeReport')
            },
            getPreviousDay(){
                let date = new Date();
                date.setDate(date.getDate() - 1);
                return moment(date).format('YYYY-MM-DD') ;
            },
            editReport(id){
                this.previous = false
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/report/'+id).then((response) => {
                    if (response) {
                        this.$emit('changeReport', response.data)
                    } else {
                        console.log("No data");
                    }
                })
                    .catch((error) => {
                        console.log(error)
                        this.showToast('', 'No result', 'danger');
                    })
            },
            openForShow(){
                this.previousReport = this.report
                this.previous = true
            },
            changeDate(){
                let date =  moment(this.reportDate, 'YYYY-MM-DD').format('DD-MM-YYYY')
                this.axios.post(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/report/well/date',{
                    well: this.report.general_data_daily.well.id,
                    date: date
                }).then((response) => {
                    if (response) {
                        this.previousReport = response.data
                        this.previous = true
                    } else {
                        console.log("No data");
                    }
                })
                    .catch((error) => {
                        console.log(error)
                        this.showToast('', 'No result', 'danger');
                    })
                this.reportDate = moment(this.report.report_daily.date, 'DD-MM-YYYY').format('YYYY-MM-DD')

            },
            changePreviousReport(report){
                this.previousReport = report
            },
            getPreviousReport(){
                if (this.report.previous_report.id) {
                    this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/report/'+this.report.previous_report.id).then((response) => {
                        if (response) {
                            this.previousReport = response.data
                        } else {
                            console.log("No data");
                        }
                    })
                        .catch((error) => console.log(error))
                }

            },
            nozzleSelect(index){
                let nozzles = ['nozzle_1', 'nozzle_2', 'nozzle_3', 'nozzle_4', 'nozzle_5', 'nozzle_6', 'nozzle_7']
                let nozzleValues = []
                let sum = 0
                if (index == 1){
                    for (let i=0; i<nozzles.length; i++) {
                        nozzleValues.push(this.report.bit_info_daily[0].nozzle[nozzles[i]])
                    }
                    let counts = {};
                    nozzleValues.forEach(function(x) { counts[x] = (counts[x] || 0)+1; });
                    for (const [key, value] of Object.entries(counts)) {
                        if (key){
                            sum += this.NozzlesTable[key][value-1]
                        }
                    }
                    this.report.bit_info_daily[0].tfa = sum.toFixed(3)
                }else  if (index == 2){
                    for (let i=0; i<nozzles.length; i++) {
                        nozzleValues.push(this.report.bit_info_daily[1].nozzle[nozzles[i]])
                    }
                    let counts = {};
                    nozzleValues.forEach(function(x) { counts[x] = (counts[x] || 0)+1; });
                    for (const [key, value] of Object.entries(counts)) {
                        if (key){
                            sum += this.NozzlesTable[key][value-1]
                        }
                    }
                    this.report.bit_info_daily[1].tfa = sum.toFixed(3)
                }
            },
            addMudDaily(){
                this.report.drilling_mud_daily.push(this.newMudDaily)
            },
            deleteMudDaily(index){
                this.report.drilling_mud_daily.splice(index, 1);
            },
            addComposition(){
                this.report.drilling_mud_composition_daily.push(this.componentComposition)
            },
            deleteComposition(index){
                this.report.drilling_mud_composition_daily.splice(index, 1);
            },
            addInclino(){
                this.report.incl_daily.push({
                    "depth": "",
                    "alt": "",
                    "angle": "",
                    "bearing": "",
                    "equip_type": {
                        "id": "",
                        "name_ru": ""
                    }
                })
            },
            deleteInclino(index){
                this.report.incl_daily.splice(index, 1);
            },
            addStratigraphy(){
                this.report.geo_data_daily.push({
                    "stratigraphy": {
                        "id": "",
                        "name_ru": ""
                    },
                    "plan_top_of_formation": "",
                    "fact_top_of_formation": "",
                    "thickness_top_of_formation": "",
                    "lithology": {
                        "id": "",
                        "name_ru": ""
                    },
                    "formation_pressure_gradient": "",
                    "frac_gradient": ""
                })
                this.report.coring_daily.push({
                    "age": "",
                    "interval": "",
                    "plan": "",
                    "fact": "",
                    "percentage": ""
                })
            },
            deleteStratigraphy(index){
                this.report.geo_data_daily.splice(index, 1);
                this.report.coring_daily.splice(index, 1);
            },
            addConsDaily(){
                this.report.material_cons_daily.push({
                    "name": "",
                    "last": "",
                    "receipts": "",
                    "consumption": "",
                    "total_balance": ""
                })
            },
            deleteConsDaily(index){
                this.report.material_cons_daily.splice(index, 1);
            },
            saveReport(){
                if (this.isEdit){
                    this.axios.put(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/report/'+this.report.report_daily.id,
                        this.report).then((response) => {
                        if (response) {
                            this.$bvToast.toast("Отчет создан!!", {
                                title: "Отчет",
                                variant: "success",
                                solid: true,
                                toaster: "b-toaster-top-center",
                                autoHideDelay: 8000,
                            });
                            window.location.href = this.localeUrl('/digital-drilling');
                        } else {
                            console.log("No data");
                        }
                    }).catch((error) =>{
                        console.log(error)
                    })
                } else{
                    this.axios.post(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/report',
                        this.report).then((response) => {
                        if (response) {
                            window.location.href = this.localeUrl('/digital-drilling');
                        } else {
                            console.log("No data");
                        }
                    }).catch((error) =>{
                        console.log(error)
                    })
                }
            },
            saveCatalog(){
                if (this.catalog != '') {
                    this.axios.post(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/'+this.currentCatalogAdd.url+'/',
                        {name_ru: this.catalog}).then((response) => {
                        if (response.data) {
                            this.catalogModal = false
                            switch (this.currentCatalogAdd.url) {
                                case "manufacturer":
                                    switch (this.currentCatalogAdd.type){
                                        case "manufacturer1":
                                            this.manufacturer1 = response.data
                                            this.report.bit_info_daily[0].manufacturer = response.data
                                            break
                                        case "manufacturer2":
                                            this.manufacturer2 = response.data
                                            this.report.bit_info_daily[1].manufacturer = response.data
                                            break
                                    }
                                    this.getManufacturers()
                                    break
                                case "pump_barrel":
                                    for (let i=0; i<this.report.pump_daily.length; i++) {
                                        if (this.currentCatalogAdd.type == 'bushings'+i){
                                            this.report.pump_daily[i].pump_barrel_type = response.data
                                            break
                                        }
                                    }
                                    this.getBushings()
                                    break
                                case "pump_type":
                                    for (let i=0; i<this.report.pump_daily.length; i++) {
                                        if (this.currentCatalogAdd.type == 'pump'+i){
                                            this.report.pump_daily[i].pump_type = response.data
                                            break
                                        }
                                    }
                                    this.getPumps()
                                    break
                                case "mud_composition":
                                    for (let i=0; i<this.report.drilling_mud_composition_daily.length; i++) {
                                        if (this.currentCatalogAdd.type == 'chemical_name'+i){
                                            this.report.drilling_mud_composition_daily[i].mud_composition= response.data
                                            break
                                        }
                                    }
                                    this.getNameChemicals()
                                    break
                                case "stratigraphy":
                                    for (let i=0; i<this.report.geo_data_daily.length; i++) {
                                        if (this.currentCatalogAdd.type == 'stratigraphy'+i){
                                            this.report.geo_data_daily[i].stratigraphy = response.data
                                            break
                                        }
                                    }
                                    this.getStratigraphy()
                                    break
                                case "lithology":
                                    for (let i=0; i<this.report.geo_data_daily.length; i++) {
                                        if (this.currentCatalogAdd.type == 'lithology'+i){
                                            this.report.geo_data_daily[i].lithology = response.data
                                            break
                                        }
                                    }
                                    this.getLithology()
                                    break
                                case "device_type":
                                    for (let i=0; i<this.report.incl_daily.length; i++) {
                                        if (this.currentCatalogAdd.type == 'inclino1'+i){
                                            this.report.incl_daily[i].equip_type = response.data
                                            break
                                        }
                                    }
                                    this.getDeviceType()
                                    break
                                case "screw_size":
                                    for (let i=0; i<this.report.bha_daily.length; i++) {
                                        if (this.currentCatalogAdd.type == 'threadTypes'+i){
                                            this.report.bha_daily[i].screw_size = response.data
                                            break
                                        }
                                    }
                                    this.getThreadTypes()
                                    break
                            }
                            this.catalogError = false
                            this.catalog = ""
                        } else {
                            console.log("No data");
                        }
                    })
                        .catch((error) => console.log(error))
                }else{
                    this.catalogError = true
                }
            },
            saveCatalogCompany(){
                if (this.catalogCompany.name_ru == '' || this.catalogCompany.bin == '' || this.catalogCompany.bin.toString().length !=12) {
                    this.catalogError = true
                }else{
                    this.catalogError = false
                    this.axios.post(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/'+this.currentCatalogAdd.url+'/',
                        this.catalogCompany).then((response) => {
                        if (response.data) {
                            this.companyName = response.data
                            this.report.contractor_daily.contractor = response.data
                            this.catalogModalCompany = false
                            this.getDrillingContractors()
                        } else {
                            console.log("No data");
                        }
                    })
                        .catch((error) => console.log(error))
                }
            },
            openCatalog(name, url, catalog){
                if (name == "Буровой подрядчик") {
                    this.catalogModalCompany = true
                }else{
                    this.catalogModal = true
                }
                this.currentCatalogAdd.name = name
                this.currentCatalogAdd.url = url
                this.currentCatalogAdd.type = catalog
            },
            selectOption(item, name){
                switch (name) {
                    case "drillingContractors":
                        this.companyName = item
                        this.report.contractor_daily.contractor = item
                        break
                    case "Unit_Name":
                        this.report.general_data_daily.rig = item
                        break
                    case "manufacturer1":
                        this.manufacturer1 = item
                        this.report.bit_info_daily[0].manufacturer = item
                        break
                    case "manufacturer2":
                        this.manufacturer2 = item
                        this.report.bit_info_daily[1].manufacturer = item
                        break
                }
                for (let i=0; i<this.report.drilling_mud_composition_daily.length; i++) {
                    if (name == 'chemical_name'+i){
                        this.report.drilling_mud_composition_daily[i].mud_composition = item
                        break
                    }
                }
                for (let i=0; i<this.report.pump_daily.length; i++) {
                    if (name == 'pump'+i){
                        this.report.pump_daily[i].pump_type = item
                        break
                    }else if (name == 'bushings'+i){
                        this.report.pump_daily[i].pump_barrel_type = item
                        break
                    }
                }
                for (let i=0; i<this.report.bha_daily.length; i++) {
                    if (name == 'threadTypes'+i){
                        this.report.bha_daily[i].screw_size = item
                        break
                    }
                }
                for (let i=0; i<this.report.geo_data_daily.length; i++) {
                    if (name == 'stratigraphy'+i){
                        this.report.geo_data_daily[i].stratigraphy = item
                        break
                    }else if(name =="lithology"+i){
                        this.report.geo_data_daily[i].lithology = item
                        break
                    }
                }
                for (let i=0; i<this.report.incl_daily.length; i++) {
                    if (name == 'inclino1'+i){
                        this.report.incl_daily[i].equip_type = item
                        break
                    }
                }
            },
            uploadRig(){
                this.rigCharacteristic[0][0].value = this.companyName.id
                this.rigCharacteristic[0][1].value = this.headDrilling
                if (this.rigCharacteristic[0][0].value == "" || this.rigCharacteristic[0][1].value == ""){
                    this.addRigModalError = true
                }else{
                    this.addRigModalError = false
                }
                if(this.rigCharacteristic[1][0].value==''){
                    this.addRigModalError = true
                }else{
                    this.addRigModalError = false
                }
                if (!this.addRigModalError) {
                    this.axios.post(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/reports/rig',{array: this.rigCharacteristic}).then((response) => {
                        if (response.data) {
                            this.Unit_Name = response.data[0]
                            this.addRigModal = false
                            this.getRig()
                        } else {
                            console.log("No data");
                        }
                    })
                        .catch((error) => console.log(error))

                }

            },
            addItemRig(){
                if (this.addRigModal){
                    this.addRigModal = false
                    document.body.overflow = 'auto'
                } else{
                    document.body.overflow = 'hidden'
                    this.addRigModal = true
                    this.getRigCharacteristic()
                }
            },
            getRigCharacteristic(){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/reports/rig').then((response) => {
                    let data = response.data;
                    this.rigCharacteristic = data
                });

            },
            getDeviceType(){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/device_type/').then((response) => {
                    let data = response.data;
                    this.deviceType = data
                });

            },
            getBHAelements(){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/bha_element/').then((response) => {
                    let data = response.data;
                    this.BHAelements = data
                });

            },
            getOperation1(){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/prod_operation/').then((response) => {
                    let data = response.data;
                    this.operation1 = data
                });

            },
            getoperation2(){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/unprod_operation/').then((response) => {
                    let data = response.data;
                    this.operation2 = data
                });

            },
            getStratigraphy(){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/stratigraphy/').then((response) => {
                    let data = response.data;
                    this.stratigraphy = data
                });

            },
            getLithology(){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/lithology/').then((response) => {
                    let data = response.data;
                    this.lithology = data
                });

            },
            getNameChemicals(){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/mud_composition/').then((response) => {
                    let data = response.data;
                    this.nameChemicals = data
                });

            },
            getBushings(){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/pump_barrel/').then((response) => {
                    let data = response.data;
                    this.bushings = data
                });

            },
            getPumps(){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/pump_type/').then((response) => {
                    let data = response.data;
                    this.pumps = data
                });

            },
            getManufacturers(){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/manufacturer/').then((response) => {
                    let data = response.data;
                    this.manufacturers = data
                });

            },
            getDiameters(){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/casing_diameter/').then((response) => {
                    let data = response.data;
                    this.diameters = data
                });

            },
            getRig(){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/rig/').then((response) => {
                    let data = response.data;
                    this.drillingRig = data
                });

            },
            getRigType(){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/rig_type/').then((response) => {
                    let data = response.data;
                    this.drillingRigTypes = data
                });

            },
            getBitTypes(){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/chisel/').then((response) => {
                    let data = response.data;
                    this.bitTypes = data
                });

            },
            getBitDiameters(){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/bit_diameter/').then((response) => {
                    let data = response.data;
                    this.bitDiameters = data
                });

            },
            getDrillingMudTypes(){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/mud_type/').then((response) => {
                    let data = response.data;
                    this.drillingMudTypes = data
                });

            },
            getThreadTypes(){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/screw_size/').then((response) => {
                    let data = response.data;
                    this.threadTypes = data
                });

            },
            getOperationCodes(){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/operations_code/').then((response) => {
                    let data = response.data;
                    this.operationCodes = data
                });

            },
            getConstructors(){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/equip_type/').then((response) => {
                    let data = response.data;
                    this.constructors = data
                });

            },
            getDrillingContractors(){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/company/').then((response) => {
                    let data = response.data;
                    this.drillingContractors = data
                });

            },
            addPump(){
                if (!this.pump[0].active){
                    this.pump[0].active = true
                } else{
                    this.pump[1].active = true
                }
            },
            deletePump(index){
                this.pump[index-2].active = false
                this.report.pump_daily[index] = {
                    "id": "",
                    "pump_type": {
                        "id": "",
                        "name_ru": ""
                    },
                    "pump_barrel_type": {
                        "id": "",
                        "name_ru": ""
                    },
                    "coeff_type": "",
                    "liters_type": "",
                    "liquid_dens": "",
                    "pressure": "",
                    "pumping_pressure": [
                        {
                            "progress": "",
                            "depth": "",
                            "pressure": ""
                        },
                        {
                            "progress": "",
                            "depth": "",
                            "pressure": ""
                        },
                        {
                            "progress": "",
                            "depth": "",
                            "pressure": ""
                        },
                        {
                            "progress": "",
                            "depth": "",
                            "pressure": ""
                        }
                    ]
                }
            },
            changeOveralTime(index){
                if (this.report.bit_info_daily[index].drilling_time) {
                    this.report.bit_info_daily[index].overall_drilling_time = parseInt(this.report.bit_info_daily[index].prev_overall_drilling_time)
                        + parseInt(this.report.bit_info_daily[index].drilling_time)
                }else{
                    this.report.bit_info_daily[index].overall_drilling_time = this.report.bit_info_daily[index].prev_overall_drilling_time
                }
            },
            sumBHA(){
                let arr = this.report.bha_daily
                for (let i=arr.length-1; i>=0; i--){
                    if (arr[i].increasing_length) {
                        return parseInt(arr[i].increasing_length)
                    }
                }
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
            summSLT(index){
                this.report.slt_daily[index].overall = this.sumValues(this.report.slt_daily[index].previous, this.report.slt_daily[index].daily)
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
                return parseFloat(a) + parseFloat(b)
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
                return parseFloat(a) - parseFloat(b)
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
                        sum += parseFloat(arr[i].previous) + parseFloat(arr[i].daily)
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
            }

        }
    }
</script>
=======
</template>

<script src="./daily-report.js"></script>
>>>>>>> master

<style scoped>
    @import "./css/daily-report.css";
</style>