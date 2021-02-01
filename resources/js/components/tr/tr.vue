<template>
  <div class="w-100">
    <div class="col-md-12 row trcolmd12">
      <div
        class="col-md-12 row justify-content-between"
        style="
          box-sizing: border box;
          flex-grow: 1;
          padding-right: 0;
          margin-right: 0;
          margin-left: 0;
          padding-left: 0;
        "
      >
        <a
          href="fa"
          class="col but-nav__link but trheadhight"
          style="min-width: 330px; line-height: 31px"
          ><i style="margin-right: 10px"
            ><svg
              width="24"
              height="14"
              viewBox="0 0 24 14"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M13.8015 10.4124C13.4953 10.4123 13.2018 10.2864 12.9853 10.062L9.52204 6.47442L2.25734 14L0.625 12.309L8.36763 4.28837C8.58407 4.06415 8.87765 3.93811 9.1838 3.93799H9.86032C10.1665 3.93811 10.46 4.06415 10.6765 4.28837L14.1397 7.87597L19.0956 2.74212L16.4485 0H23.375V7.17519L20.7279 4.43307L15.2941 10.062C15.0777 10.2864 14.7841 10.4123 14.478 10.4124H13.8015Z"
                fill="white"
              />
            </svg> </i
          >{{trans('tr.tr')}}</a
        >
        <!-- <form class="form-group but-nav__link">
                    <label for="inputDate">Введите дату:</label>
                    <input type="date" value = "01.06.2020" class="form-control" v-model="dt">
            </form> -->
        <div class="col dropdown" style="padding: 0 13px">
          <button
            class="col-md-12 but-nav__link but faheadhight"
            type="button"
            id="dropdownMenuButton"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            <i style="margin-right: 10px">
              <svg
                width="18"
                height="20"
                viewBox="0 0 18 20"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M15.6583 19.4286H2.33239C1.281 19.4286 0.42868 18.5843 0.42868 17.5429V4.34285C0.42868 3.3014 1.281 2.45714 2.33239 2.45714H4.23609V0.571426H6.1398V2.45714H11.8509V0.571426H13.7546V2.45714H15.6583C16.7098 2.45714 17.562 3.3014 17.562 4.34285V17.5429C17.562 18.5843 16.7098 19.4286 15.6583 19.4286ZM2.33239 8.11428V17.5429H15.6583V8.11428H2.33239ZM2.33239 4.34285V6.22857H15.6583V4.34285H2.33239ZM8.04351 16.0475L4.51499 12.5523L5.86091 11.2191L8.04351 13.3811L12.1298 9.3334L13.4757 10.6666L8.04351 16.0465V16.0475Z"
                  fill="white"
                />
              </svg>
            </i>
            {{trans('tr.dt')}}
          </button>

          <div
            class="dropdown-menu fadropmenu"
            style="
              background: #40467e;
              height: 117px;
              flex-direction: column;
              width: calc(100% - 26px);
              margin-top: 4px;
            "
            aria-labelledby="dropdownMenuButton"
            data-toggle="dropdown"
            @click.prevent.stop="() => {}"
          >
            <div>
              <select
                v-model="month"
                style="
                  background-color: #40467e;
                  border-color: #40467e;
                  color: white;
                  width: 100%;
                  padding: 8px;
                "
                class="form-controll"
                id="companySelect"
                @change="onChangeMonth($event)"
              >
                <option value="1">{{trans('tr.jan')}}</option>
                <option value="2">{{trans('tr.feb')}}</option>
                <option value="3">{{trans('tr.mar')}}</option>
                <option value="4">{{trans('tr.apr')}}</option>
                <option value="5">{{trans('tr.may')}}</option>
                <option value="6">{{trans('tr.jun')}}</option>
                <option value="7">{{trans('tr.jul')}}</option>
                <option value="8">{{trans('tr.aug')}}</option>
                <option value="9">{{trans('tr.sep')}}</option>
                <option value="10">{{trans('tr.oct')}}</option>
                <option value="11">{{trans('tr.nov')}}</option>
                <option value="12">{{trans('tr.dec')}}</option>
              </select>
            </div>
            <div>
              <select
                v-model="selectYear"
                style="
                  background-color: #40467E ;
                  border-color: #40467E;
                  color: white;
                  width: 100%;
                  padding: 8px;
                  border: none
                  height: 35px !important;
                  color: white !important;
                "
                class="form-controll"
                id="companySelect"
                @change="onChangeYear($event)"
              >
                <option value="2021">2021</option>
                <option value="2020">2020</option>
                <option value="2019">2019</option>

              </select>
            </div>
            <a href="#" @click.prevent="chooseDt" class="btn btn-sm button_form"
              >{{trans('tr.sf')}}</a
            >
          </div>
        </div>
        
        <div class="big-data-input-container">
          <search-form-refresh
            @input="handlerSearch"
            @start-search="searchWell()"
            :clear="searched"
          />
        </div>
      </div>
    </div>

    <div>
      <!-- <input type="text" placeholder="Enter Name" v-model="searchText"> -->
    </div>
    <div class="col-md-12 maintable tablecont">
      <div class="maintable-level2" style="position: relative">
        <div class="techbt1 tr-table-header">
          <div class="tech" style="margin-left: 14px; color: white">
            <h5>{{trans('tr.htr')}} {{ dt }}</h5>
          </div>

          <tr-multiselect
            :filter="filter"
            :selectedAllTag="true"
            :fieldFilterOptions="fieldFilterOptions"
            @change-filter="handlerFilter"
            filterName="месторождения"
          />
          
          <a v-show="false" v-if="edit"></a>


          <modal name="add_well" :width="1600" :height="220"  :adaptive="true" style="z-index:9900000; ">
            <div class="main_modals" style="background: #272953; width=900; height=400; border: 3px solid #656A8A;">
              <notifications position="top"></notifications>
              <div>
                    <div class="header_mod" style="color:white; display:flex; margin-left: 14px; padding-top: 8px; ">
                        <h5>Добавление скважин</h5>
                        <!-- <a class="modal-close" title="Close" @click.prevent="reRender" style="cursor: pointer;"> -->
                          <!-- <svg 
                            width="24" 
                            height="24" 
                            viewBox="0 0 24 24" 
                            fill="none" 
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.6567 17.6575L6.34294 6.34383" 
                              stroke="white" stroke-width="1.4" stroke-linecap="round"/>
                            <path d="M17.6556 6.34383L6.34188 17.6575" 
                              stroke="white" stroke-width="1.4" stroke-linecap="round"/>
                          </svg>
                        </a> -->
                    </div>
                    
                    <div class="body" style="background: #272953; display:flex; justify-content: center; padding-top: 6px; padding-bottom: 7px;">
                            <div style="margin-left: 7px;">
                              <select
                                class="form-control select_mod"
                                style="background: #334296 !important"
                                v-model="Filter_status"
                                value="Статус"
                              >
                                <option v-for="(f, k) in statusFilters" :key="k" :value="f">
                                  {{ f === undefined ? "Выберите статус" : f }}
                                </option>
                              </select>
                            </div>
                            <div style="margin-left: 7px; cursor: pointer;">
                              <select
                                class="select_mod form-control"
                                style="background: #334296 !important"
                                v-model="Filter_field"
                                value="Месторождение"
                              >
                                <option v-for="(f, k) in fieldFilters" :key="k" :value="f">
                                  {{ f === undefined ? "Выберите месторождение" : f }}
                                </option>
                              </select>
                            </div>
                            <div style="margin-left: 7px; cursor: pointer;">
                              <select
                                class="select_mod form-control"
                                style="background: #334296 !important"
                                v-model="Filter_well"
                                value="Скважина"
                              >
                                <option v-for="(f, k) in wellFilters" :key="k" :value="f">
                                  {{ f === undefined ? "Выберите скважину" : f }}
                                </option>
                              </select>
                            </div>

                            <div style="margin-left: 7px; cursor: pointer;">
                              <select
                                class="form-control select_mod"
                                style="background: #334296 !important"
                                v-model="Filter_well_type"
                                value="Тип скв"
                              >
                                <option v-for="(f, k) in typeWellFilters" :key="k" :value="f">
                                  {{ f === undefined ? "Выберите тип скв" : f }}
                                </option>
                              </select>
                            </div>

                            <div style="margin-left: 7px; cursor: pointer;">
                              <select
                                class="form-control select_mod"
                                style="background: #334296 !important"
                                v-model="Filter_well_status"
                                value="Состояние"
                              >
                                <option v-for="(f, k) in wellStatusFilters" :key="k" :value="f">
                                  {{ f === undefined ? "Выберите состояние" : f }}
                                </option>
                              </select>
                            </div>
                            
                              <a
                                
                                style="margin-left: 50px;; cursor: pointer; color:white; margin-top: 5px;"
                                v-if="!show_add"
                                @click="addWellData"
                                @click.prevent="showWells"
                                ><svg 
                                width="16" 
                                height="16" 
                                viewBox="0 0 16 16" 
                                fill="none" 
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.5 8L1.5 8" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M8 1.5V14.5" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                              Добавить</a>

                              <a
                                
                                style="margin-left: 50px;; cursor: pointer; color:white; margin-top: 5px;"
                                v-if="show_add"
                                ><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M17.6567 17.6575L6.34294 6.34383" 
                                    stroke="white" stroke-width="1.4" stroke-linecap="round"/>
                                  <path d="M17.6556 6.34383L6.34188 17.6575" 
                                    stroke="white" stroke-width="1.4" stroke-linecap="round"/>
                                  </svg>
                              Отмена</a> 

                            <a
                              style="margin-left: 10px; cursor: pointer; color:white; margin-top: 5px;"
                              @click="saveadd()"
                              @click.prevent="reRender"
                              ><svg width="24" 
                              height="24" 
                              viewBox="0 0 24 24" 
                              fill="none" 
                              xmlns="http://www.w3.org/2000/svg">
                              <path d="M4 12.5L8.85858 17.3586C8.93668 17.4367 9.06332 17.4367 9.14142 17.3586L20 6.5" stroke="white" 
                              stroke-width="1.5" stroke-linecap="round"/>
                              </svg>Сохранить</a>

                             <a
                              style="margin-left: 10px; cursor: pointer; color:white; margin-top: 5px;"
                              @click="deleteWell"
                              @click.prevent="reRender"
                              ><svg width="24"
                               height="24" 
                               viewBox="0 0 24 24" 
                               fill="none" 
                               xmlns="http://www.w3.org/2000/svg">
                              <path d="M17.6567 17.6575L6.34294 6.34383" stroke="white" stroke-width="1.4" stroke-linecap="round"/>
                              <path d="M17.6556 6.34383L6.34188 17.6575" stroke="white" stroke-width="1.4" stroke-linecap="round"/>
                              </svg>Удалить</a>
                            
                </div>
              </div>
              <div class="table" style="padding-top: 21px;  background: #454D7D; overflow: hidden !important;">

                    <table class="table table-bordered table-dark table-responsive trtable" style="font-size: 12px; background: #454D7D; color: #fff; height: 100px;" v-if="show_add" :key="render">
                    <thead>
                      <tr >
                        <td scope="col">Место-ние</td>
                        <td scope="col">Состояние скв</td>
                        <td scope="col">№ скв</td>
                        <td scope="col">Горизонт</td>
                        <td scope="col">Обьект</td>
                        <td scope="col">Способ эксп-ии</td>
                        <td scope="col">Тип скв</td>
                        <td scope="col">Блок</td>
                        <td scope="col">Наружный диаметр э/к</td>
                        <td scope="col">Внутр. диаметр э/к</td>
                        <td scope="col">Н вд</td>
                        <td scope="col">СЭ</td>
                        <td scope="col">Тип насоса</td>
                        <td scope="col">Тип СК</td>
                        <td scope="col">Р буф</td>
                        <td scope="col">Р л</td>
                        <td scope="col">Р пласт.</td>
                        <td scope="col">Н д</td>
                        <td scope="col">P затр</td>
                        <td scope="col">Плот-ть нефти</td>
                        <td scope="col">Плот-ть воды</td>
                        <td scope="col">Н перф</td>
                        <td scope="col">Р заб замерное</td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(row, row_index) in lonelywell" 
                        :key="row_index"
                        ref="editTable">
                        <td><input data-key="field" :value="row.field" class="input_edit"></td>
                        <td><input data-key="well_status_last_day" :value="row.well_status_last_day" class="input_edit"></td>
                        <td><input data-key="rus_wellname" :value="row.rus_wellname" class="input_edit"></td>
                        <td><input data-key="horizon" :value="row.horizon" class="input_edit"></td>
                        <td><input data-key="object" :value="row.object" class="input_edit"></td>
                        <td><input data-key="exp_meth" :value="row.exp_meth" class="input_edit"></td>
                        <td><input data-key="type_text" :value="row.type_text" class="input_edit"></td>
                        <td><input data-key="block" :value="row.block" class="input_edit"></td>
                        <td><input data-key="cas_OD" :value="row.cas_OD" class="input_edit"></td>
                        <td><input data-key="cas_ID" :value="row.cas_ID" class="input_edit"></td>
                        <td><input data-key="h_up_perf_md" :value="row.h_up_perf_md" class="input_edit"></td>
                        <td><input data-key="pump_type" :value="row.pump_type" class="input_edit"></td>
                        <td><input data-key="type_sr" :value="row.type_sr" class="input_edit"></td>
                        <td><input data-key="whp" :value="row.whp" class="input_edit"></td>
                        <td><input data-key="line_p" :value="row.line_p" class="input_edit"></td>
                        <td><input data-key="p_res" :value="row.p_res" class="input_edit"></td>
                        <td><input data-key="h_dyn" :value="row.h_dyn" class="input_edit"></td>
                        <td><input data-key="p_annular" :value="row.p_annular" class="input_edit"></td>
                        <td><input data-key="dens_oil" :value="row.dens_oil" class="input_edit"></td>
                        <td><input data-key="h_perf" :value="row.h_perf" class="input_edit"></td>
                        <td><input data-key="bhp_meter" :value="row.bhp_meter" class="input_edit"></td>

                      </tr>
                    </tbody>
                  </table>
              </div>
            </div>
          </modal>

          <button
            type="button" 
            data-toggle="modal" 
            data-target="#exampleModalCenter" 
            @click="addpush()"
            @click.prevent="wellAdd"
            style="background: #272953; border: none; margin-left: 10px;"
            title="Добавить скважины">
            
            <svg 
                width="24" 
                height="24" 
                viewBox="0 0 24 24"
                fill="none" 
                xmlns="http://www.w3.org/2000/svg">
              <path 
                d="M18.5 12L5.5 12" 
                stroke="white" 
                stroke-width="1.5" 
                stroke-linecap="round"/>
              <path 
                d="M12 5.5V18.5" 
                stroke="white" 
                stroke-width="1.5" 
                stroke-linecap="round"/>
            </svg>
          </button>
            

          <a
            v-if="edit"
            v-bind:title="trans('tr.trtlp6')"
            style="margin-left: 10px; cursor: pointer;"
            @click="savetable()"
            ><svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M15.4735 5C15.7387 5 15.9931 5.10536 16.1806 5.29289L18.9985 8.11077L18.9985 17.9985C18.9985 18.5508 18.5508 18.9985 17.9985 18.9985L6 18.9985C5.44772 18.9985 5 18.5508 5 17.9985L5 6C5 5.44772 5.44771 5 6 5L15.4735 5Z"
                stroke="white"
                stroke-width="1.2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
              <rect
                x="8.109"
                y="12.778"
                width="7.77693"
                height="6.22155"
                stroke="white"
                stroke-width="1.2"
                stroke-linejoin="round"
              />
              <rect
                x="8.88917"
                y="5"
                width="6.22155"
                height="3.88847"
                stroke="white"
                stroke-width="1.2"
                stroke-linejoin="round"
              />
            </svg>
          </a>

          <a
            v-if="edit"
            class="trgraph"
            v-bind:title="trans('tr.trtlp5')"
            style="cursor: pointer;"
            data-toggle="tooltip"
            data-placement="top"
            @click="cancelEdit"
            ><svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M17.6574 17.6575L6.34367 6.34383"
                stroke="white"
                stroke-width="1.4"
                stroke-linecap="round"
              />
              <path
                d="M17.6563 6.34383L6.34262 17.6575"
                stroke="white"
                stroke-width="1.4"
                stroke-linecap="round"
              />
            </svg>
          </a>

          <a
            v-if="!edit"
            class="trgraph"
            v-bind:title="trans('tr.trtlp1')"
            data-toggle="tooltip"
            data-placement="top"
            href="tr_charts"
           
            ><svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M15 5H5C4.44771 5 4 5.44772 4 6V18C4 18.5523 4.44772 19 5 19H17C17.5523 19 18 18.5523 18 18V11.6923M18 5V7M18 7H20M18 7V9M18 7H16M7.5 16V12.7692M11 16V8.46154M14.5 16V11.6923"
                stroke="white"
                stroke-width="1.4"
                stroke-linecap="round"
              />
            </svg>
          </a>

          <a
            v-if="!edit"
            v-bind:title="trans('tr.trtlp2')"
            style="cursor: pointer;"
            data-toggle="tooltip"
            data-placement="top"
            @click="editable()"
            ><svg
              width="18"
              height="18"
              viewBox="0 0 18 18"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M3 11.5L1.55336 16.3221C1.53048 16.3984 1.6016 16.4695 1.67788 16.4466L6.5 15M3 11.5C3 11.5 11.0603 3.43942 12.7227 1.7772C12.8789 1.62104 13.1257 1.62572 13.2819 1.78189C13.8372 2.33714 15.1144 3.61434 16.2171 4.71709C16.3733 4.87334 16.3788 5.12115 16.2226 5.27738C14.5597 6.94002 6.5 15 6.5 15M3 11.5L3.64727 10.8527L7.14727 14.3527L6.5 15"
                stroke="white"
                stroke-width="1.4"
              />
            </svg>
          </a>

          <button
            v-if="!edit"
            class="trgraph"
            id="bt1"
            @click="swap"
            style="
              background: #272953;
              color: white;
              border: none;
            "
            :title="isfulltable ? trans('tr.trtlp3') : trans('tr.trtlp4')"
            data-toggle="tooltip"
            data-placement="top"
          >
            <svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
              v-if="isfulltable"
            >
              <path
                d="M9.23235 6H6.18359C5.63131 6 5.18359 6.44772 5.18359 7V18C5.18359 18.5523 5.63131 19 6.18359 19H17.342C17.8943 19 18.342 18.5523 18.342 18V15"
                stroke="white"
                stroke-width="1.4"
                stroke-linecap="round"
              />
              <path
                d="M18 6L12 12M12 12V7.6M12 12H16.4"
                stroke="white"
                stroke-width="1.4"
                stroke-linecap="round"
              />
            </svg>

            <svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
              v-if="!isfulltable"
            >
              <path
                d="M9 6H6C5.44772 6 5 6.44772 5 7V18C5 18.5523 5.44772 19 6 19H17C17.5523 19 18 18.5523 18 18V15M11.5 12.5L19 5M19 5V10.5M19 5H13.5"
                stroke="white"
                stroke-width="1.4"
                stroke-linecap="round"
              />
            </svg>
          </button>
        </div>

        <div class="table-outer">
          <div class="table-inner">
            <TrTable :wells="wells" @onSort="sortBy" v-if="show_first" />
            <!-- <TrFullTable :wells="wells" :edit="edit" @onSort="sortBy" v-show="show_second"/> -->
            <table
              v-if="show_second"
              class="table table-bordered table-dark table-responsive trtable"
              style="margin-bottom: 0; background: #0d1e63"

            >
              <thead>
                <tr class="headerColumn sticky" style="background: #333975">
                  <td rowspan="4" class="th">№</td>
                  <td rowspan="4" class="th">{{trans('tr.trs1')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.tr1')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.tr2')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.tr3')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.tr4')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.tr5')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs2')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.tr6')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs3')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.tr7')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs4')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.tr30')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.tr9')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs5')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.tr10')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.tr11')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs6')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs7')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs8')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs9')}}</td>
                  <td rowspan="4" class="th">
                    {{trans('tr.tr12')}}
                  </td>
                  <td rowspan="4" class="th">{{trans('tr.tr13')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs10')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs11')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs12')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.tr15')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.tr16')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs13')}}</td>
                  <td class="colspan th" colspan="5">
                    {{trans('tr.trs14')}}
                  </td>
                  <td class="colspan th" colspan="5">{{trans('tr.tr17')}}</td>
                  <td rowspan="4" class="th">
                    <span>{{trans('tr.tr25')}}</span>
                  </td>
                  <td rowspan="4" class="th">{{trans('tr.trs15')}}</td>
                  <!-- <td rowspan="4" class="th">ГФ</td> -->
                  <td rowspan="4" class="th">{{trans('tr.trs16')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs17')}}</td>
                  <td class="colspan th" colspan="4">{{trans('tr.tr28')}}</td>
                  <td rowspan="4" class="th">
                    <span>{{trans('tr.trs18')}}</span>
                  </td>
                  <td rowspan="4" class="th">
                    <span>{{trans('tr.trs19')}}</span>
                  </td>
                  <td rowspan="4" class="th">{{trans('tr.trs20')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs21')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs22')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs23')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs24')}}</td>
                  <td rowspan="4" class="th">k</td>
                  <td rowspan="4" class="th">КН</td>
                  <td rowspan="4" class="th">{{trans('tr.trs25')}}</td>
                  <td class="colspan th" colspan="14">
                    {{trans('tr.tr18')}}
                  </td>
                  <td class="colspan th" colspan="11">
                    {{trans('tr.trs26')}}
                  </td>
                  <td class="colspan th" colspan="4">{{trans('tr.trs27')}}</td>
                  <td rowspan="4" class="th">
                    <span>{{trans('tr.trs28')}}</span>
                  </td>
                  <td rowspan="4" class="th">{{trans('tr.trs29')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs30')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs31')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs32')}}</td>
                  <td rowspan="4" class="th">
                    <span>{{trans('tr.trs33')}}</span>
                  </td>
                  <td rowspan="4" class="th">{{trans('tr.trs34')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs35')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs36')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs37')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs38')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs39')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs40')}}</td>
                  <td rowspan="4" class="th">
                    <span>{{trans('tr.trs41')}}</span>
                  </td>
                  <td rowspan="4" class="th">{{trans('tr.trs42')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs43')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs44')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs45')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs46')}}</td>
                  <td rowspan="4" class="th">{{trans('tr.trs47')}}</td>
                  <td rowspan="4" class="th">
                    <span>{{trans('tr.trs48')}}</span>
                  </td>
                  <td class="colspan th" colspan="2">{{trans('tr.trs49')}}</td>
                  <td class="colspan th" colspan="3">
                    {{trans('tr.trs50')}}
                  </td>
                  <td rowspan="4" class="th"><span>{{trans('tr.trs51')}}</span></td>
                  <td rowspan="4" class="th">
                    <span>{{trans('tr.trs52')}}</span>
                  </td>
                  <td rowspan="4" class="th"><span>{{trans('tr.trs54')}}</span></td>
                  <td rowspan="4" class="th">
                    <span>{{trans('tr.trs55')}}</span>
                  </td>
                  <td rowspan="4" class="th">
                    <span>{{trans('tr.trs56')}}</span>
                  </td>
                  <td class="colspan th" colspan="14">{{trans('tr.tr19')}}</td>
                </tr>
                <tr class="headerColumn notsticky" style="background: #333975">
                  <td rowspan="3" class="th"><span>{{trans('tr.tr20')}}</span></td>
                  <td rowspan="3" class="th"><span>{{trans('tr.tr22')}}</span></td>
                  <td rowspan="3" class="th"><span>{{trans('tr.tr23')}}</span></td>
                  <td rowspan="3" class="th"><span>{{trans('tr.trs57')}}</span></td>
                  <td rowspan="3" class="th"><span>{{trans('tr.trs58')}}</span></td>
                  <td rowspan="3" class="th"><span>{{trans('tr.tr20')}}</span></td>
                  <td rowspan="3" class="th"><span>{{trans('tr.tr21')}}</span></td>
                  <td rowspan="3" class="th"><span>{{trans('tr.tr22')}}</span></td>
                  <td rowspan="3" class="th"><span>{{trans('tr.tr23')}}</span></td>
                  <td rowspan="3" class="th"><span>{{trans('tr.tr24')}}</span></td>
                  <td rowspan="3" class="th"><span>{{trans('tr.trs59')}}</span></td>
                  <td rowspan="3" class="th"><span>{{trans('tr.trs60')}}</span></td>
                  <td rowspan="3" class="th"><span>{{trans('tr.trs61')}}</span></td>
                  <td rowspan="3" class="th"><span>Фирма</span></td>
                  <td rowspan="3" class="th"><span>{{trans('tr.trs62')}}</span></td>
                  <td class="colspan th" colspan="4">{{trans('tr.tr27')}}</td>
                  <td rowspan="3" class="th"><span>{{trans('tr.trs63')}}</span></td>
                  <td rowspan="3" class="th"><span>Skin</span></td>
                  <td rowspan="3" class="th">
                    <span>{{trans('tr.trs64')}}</span>
                  </td>
                  <td class="colspan th" colspan="4">{{trans('tr.tr28')}}</td>
                  <td rowspan="3" class="th"><span>{{trans('tr.trs65')}}</span></td>
                  <td rowspan="3" class="th"><span>{{trans('tr.tr29')}}</span></td>
                  <td rowspan="3" class="th"><span>{{trans('tr.trs62')}}Р заб</span></td>
                  <td class="colspan th" colspan="4">{{trans('tr.tr27')}}</td>
                  <td class="colspan th" colspan="4">{{trans('tr.tr28')}}</td>
                  <td rowspan="3" class="th"><span>{{trans('tr.trs65')}}</span></td>
                  <td rowspan="3" class="th"><span>{{trans('tr.tr29')}}</span></td>
                  <td class="colspan th" colspan="2">{{trans('tr.trs66')}}</td>
                  <td class="colspan th" colspan="2">{{trans('tr.trs67')}}</td>
                  <td rowspan="3" class="th"><span>{{trans('tr.trs68')}}</span></td>
                  <td rowspan="3" class="th"><span>{{trans('tr.trs69')}}</span></td>
                  <td class="colspan th" colspan="3">{{trans('tr.trs70')}}</td>
                  <td rowspan="3" class="th"><span>{{trans('tr.tr30')}}</span></td>
                  <td rowspan="3" class="th"><span>{{trans('tr.tr21')}}</span></td>
                  <td rowspan="3" class="th"><span>{{trans('tr.tr22')}}</span></td>
                  <td rowspan="3" class="th"><span>{{trans('tr.tr31')}}</span></td>
                  <td rowspan="3" class="th"><span>{{trans('tr.tr23')}}</span></td>
                  <td rowspan="3" class="th"><span>{{trans('tr.tr24')}}</span></td>
                  <td rowspan="3" class="th"><span>{{trans('tr.trs71')}}</span></td>
                  <td rowspan="3" class="th">
                    <span>{{trans('tr.trs72')}}</span>
                  </td>
                  <td rowspan="3" class="th">
                    <span>{{trans('tr.trs73')}}</span>
                  </td>
                  <td rowspan="3" class="th">
                    <span>{{trans('tr.trs74')}}</span>
                  </td>
                  <td rowspan="3" class="th">
                    <span>{{trans('tr.trs75')}}</span>
                  </td>
                  <td class="colspan th" colspan="2">
                    <span>{{trans('tr.trs76')}}</span>
                  </td>
                  <td rowspan="3" class="th">
                    <span>{{trans('tr.trs77')}}</span>
                  </td>
                </tr>
                <tr class="headerColumn notsticky" style="background: #333975">
                  <td rowspan="2" class="th"><span>{{trans('tr.tr22')}}</span></td>
                  <td rowspan="2" class="th">
                    <span>{{trans('tr.trs78')}}</span>
                  </td>
                  <td rowspan="2" class="th"><span>{{trans('tr.tr21')}}</span></td>
                  <td rowspan="2" class="th"><span>{{trans('tr.tr32')}}</span></td>
                  <td rowspan="2" class="th"><span>{{trans('tr.tr22')}}</span></td>
                  <td rowspan="2" class="th">
                    <span>{{trans('tr.trs78')}}</span>
                  </td>
                  <td rowspan="2" class="th"><span>{{trans('tr.tr21')}}</span></td>
                  <td rowspan="2" class="th"><span>{{trans('tr.tr32')}}</span></td>
                  <td rowspan="2" class="th"><span>{{trans('tr.tr22')}}</span></td>
                  <td rowspan="2" class="th">
                    <span>{{trans('tr.trs78')}}</span>
                  </td>
                  <td rowspan="2" class="th"><span>{{trans('tr.tr21')}}</span></td>
                  <td rowspan="2" class="th"><span>{{trans('tr.tr32')}}</span></td>
                  <td rowspan="2" class="th"><span>{{trans('tr.tr22')}}</span></td>
                  <td rowspan="2" class="th">
                    <span>{{trans('tr.trs78')}}</span>
                  </td>
                  <td rowspan="2" class="th"><span>{{trans('tr.tr21')}}</span></td>
                  <td rowspan="2" class="th"><span>{{trans('tr.tr32')}}</span></td>
                  <td rowspan="2" class="th"><span>{{trans('tr.trs79')}}</span></td>
                  <td rowspan="2" class="th"><span>{{trans('tr.trs80')}}</span></td>
                  <td rowspan="2" class="th">
                    <span>{{trans('tr.trs81')}}</span>
                  </td>
                  <td rowspan="2" class="th">
                    <span>{{trans('tr.trs82')}}</span>
                  </td>
                  <td rowspan="2" class="th"><span>{{trans('tr.trs83')}}</span></td>
                  <td rowspan="2" class="th"><span>{{trans('tr.tr22')}}</span></td>
                  <td rowspan="2" class="th"><span>{{trans('tr.tr23')}}</span></td>
                  <td rowspan="2" class="th"><span>{{trans('tr.tr21')}}</span></td>
                  <td rowspan="2" class="th"><span>{{trans('tr.tr22')}}</span></td>
                </tr>
                <tr></tr>
                <tr
                  class="subHeaderColumn"
                  style="background: #333975; cursor: pointer"
                >
                  <td @click="sortBy('gu')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('field')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('well')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('well_type')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('horizon')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('object')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('block')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('r_con')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м
                  </td>
                  <td @click="sortBy('cas_OD')" class="th">
                    <i class="fa fa-fw fa-sort"></i>мм
                  </td>
                  <td @click="sortBy('cas_ID')" class="th">
                    <i class="fa fa-fw fa-sort"></i>мм
                  </td>
                  <td @click="sortBy('tub_OD')" class="th">
                    <i class="fa fa-fw fa-sort"></i>мм
                  </td>
                  <td @click="sortBy('tub_ID')" class="th">
                    <i class="fa fa-fw fa-sort"></i>мм
                  </td>
                  <td @click="sortBy('choke_d')" class="th">
                    <i class="fa fa-fw fa-sort"></i>мм
                  </td>
                  <td @click="sortBy('h_up_perf_md')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м
                  </td>
                  <td @click="sortBy('h_up_perf_ext')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('exp_meth')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('pump_type')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('type_sr')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('spm')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('stroke_len')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м
                  </td>
                  <td @click="sortBy('q_theor')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr2')}}
                  </td>
                  <td @click="sortBy('freq')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr1')}}
                  </td>
                  <td @click="sortBy('h_pump_set')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м
                  </td>
                  <td @click="sortBy('whp')" class="th">
                    <i class="fa fa-fw fa-sort"></i>атм
                  </td>
                  <td @click="sortBy('line_p')" class="th">
                    <i class="fa fa-fw fa-sort"></i>атм
                  </td>
                  <td @click="sortBy('p_res')" class="th">
                    <i class="fa fa-fw fa-sort"></i>атм
                  </td>
                  <td @click="sortBy('h_dyn')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м
                  </td>
                  <td @click="sortBy('p_annular')" class="th">
                    <i class="fa fa-fw fa-sort"></i>атм
                  </td>
                  <td @click="sortBy('p_intake')" class="th">
                    <i class="fa fa-fw fa-sort"></i>атм
                  </td>
                  <td @click="sortBy('bhp_prev_m')" class="th">
                    <i class="fa fa-fw fa-sort"></i>атм
                  </td>
                  <td @click="sortBy('q_l_prev_m')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr2')}}
                  </td>
                  <td @click="sortBy('wct_prev_m')" class="th">
                    <i class="fa fa-fw fa-sort"></i>%
                  </td>
                  <td @click="sortBy('h_dyn_prev_m')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м
                  </td>
                  <td @click="sortBy('pi_prev_m')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr4')}}
                  </td>
                  <td @click="sortBy('bhp')" class="th">
                    <i class="fa fa-fw fa-sort"></i>атм
                  </td>
                  <td @click="sortBy('q_o')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr3')}}
                  </td>
                  <td @click="sortBy('q_l')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr2')}}
                  </td>
                  <td @click="sortBy('wct')" class="th">
                    <i class="fa fa-fw fa-sort"></i>%
                  </td>
                  <td @click="sortBy('gor')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м3/т
                  </td>
                  <td @click="sortBy('well_status_last_day')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('P_bubble_point')" class="th">
                    <i class="fa fa-fw fa-sort"></i>атм
                  </td>
                  <td @click="sortBy('t_res')" class="th">
                    <i class="fa fa-fw fa-sort"></i>ºC
                  </td>
                  <td @click="sortBy('wht')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('grp_skin')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('grp_jd')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('grp_date')" class="th">
                    <i class="fa fa-fw fa-sort"></i>д/м/г
                  </td>
                  <td @click="sortBy('grp_contractor')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('visc_oil_rc')" class="th">
                    <i class="fa fa-fw fa-sort"></i>сПз
                  </td>
                  <td @click="sortBy('visc_wat_rc')" class="th">
                    <i class="fa fa-fw fa-sort"></i>сПз
                  </td>
                  <td @click="sortBy('visc_liq_rc')" class="th">
                    <i class="fa fa-fw fa-sort"></i>сПз
                  </td>
                  <td @click="sortBy('bo')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м3/м3
                  </td>
                  <td @click="sortBy('dens_oil')" class="th">
                    <i class="fa fa-fw fa-sort"></i>г/см3
                  </td>
                  <td @click="sortBy('dens_liq')" class="th">
                    <i class="fa fa-fw fa-sort"></i>г/см3
                  </td>
                  <td @click="sortBy('h_perf')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м
                  </td>
                  <td @click="sortBy('k')" class="th">
                    <i class="fa fa-fw fa-sort"></i>мД
                  </td>
                  <td @click="sortBy('kh')" class="th">
                    <i class="fa fa-fw fa-sort"></i>мДм
                  </td>
                  <td @click="sortBy('pi')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr4')}}
                  </td>
                  <td @click="sortBy('tp_idn_bhp')" class="th">
                    <i class="fa fa-fw fa-sort"></i>атм
                  </td>
                  <td @click="sortBy('tp_idn_liq')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr2')}}
                  </td>
                  <td @click="sortBy('tp_idn_liq_cas_d_corr')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr2')}}
                  </td>
                  <td @click="sortBy('tp_idn_oil')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr3')}}
                  </td>
                  <td @click="sortBy('tp_idn_oil_inc')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr3')}}
                  </td>
                  <td @click="sortBy('tp_idn_jd')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('tp_idn_skin')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('tp_idn_pi_after')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr4')}}
                  </td>
                  <td @click="sortBy('tp_idn_grp_q_liq')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr2')}}
                  </td>
                  <td @click="sortBy('tp_idn_grp_q_liq_cas_d_corr')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr2')}}
                  </td>
                  <td @click="sortBy('tp_idn_grp_q_oil')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr3')}}
                  </td>
                  <td @click="sortBy('tp_idn_grp_q_oil_inc')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr3')}}
                  </td>
                  <td @click="sortBy('tp_idn_q_oil_inc_perc')" class="th">
                    <i class="fa fa-fw fa-sort"></i>%
                  </td>
                  <td @click="sortBy('gt_total_inc')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr3')}}
                  </td>

                  <td @click="sortBy('gp_idn_bhp')" class="th">
                    <i class="fa fa-fw fa-sort"></i>атм
                  </td>
                  <td @click="sortBy('gp_idn_q_liq')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr2')}}
                  </td>
                  <td @click="sortBy('gp_idn_q_liq_cas_d_corr')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr2')}}
                  </td>
                  <td @click="sortBy('gp_idn_q_oil')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr3')}}
                  </td>
                  <td @click="sortBy('gp_idn_q_oil_inc')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr3')}}
                  </td>
                  <td @click="sortBy('gp_grp_q_liq')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr2')}}
                  </td>
                  <td @click="sortBy('gp_grp_q_liq_cas_d_corr')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('gp_grp_q_oil')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('gp_grp_q_oil_inc')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('gp_total_inc_perc')" class="th">
                    <i class="fa fa-fw fa-sort"></i>%
                  </td>
                  <td @click="sortBy('gp_total_inc')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr3')}}
                  </td>
                  <td @click="sortBy('error_count')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('error_first')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('error_warning')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('error_first_warning')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('idn_pump_depth_max')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('stop_date')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr6')}}
                  </td>
                  <td @click="sortBy('layers_count')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('zone')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('tseh')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('semi_free_flow')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('non_profit')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('unsteady_state')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('start_up_date')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr6')}}
                  </td>
                  <td @click="sortBy('well_project_purpose')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('bhp_meter')" class="th">
                    <i class="fa fa-fw fa-sort"></i>атм
                  </td>
                  <td @click="sortBy('oil_net_pay')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м
                  </td>
                  <td @click="sortBy('oil_cumulative')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr7')}}
                  </td>
                  <td @click="sortBy('max_q_liq_hist')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr2')}}
                  </td>
                  <td @click="sortBy('dist_to_inj_well')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м
                  </td>
                  <td @click="sortBy('dist_to_woc')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м
                  </td>
                  <td @click="sortBy('curr_bh')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('pump_fillage')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr2')}}
                  </td>
                  <td @click="sortBy('gzu_type')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('p_res_init')" class="th">
                    <i class="fa fa-fw fa-sort"></i>атм
                  </td>
                  <td @click="sortBy('q_liq_charac')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr2')}}
                  </td>
                  <td @click="sortBy('APV_t_rab')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr8')}}
                  </td>
                  <td @click="sortBy('APV_t_nak')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr8')}}
                  </td>
                  <td @click="sortBy('plan_izo_work')" class="th">
                    <i class="fa fa-fw fa-sort"></i>атм
                  </td>
                  <td @click="sortBy('plan_act_q_l')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr2')}}
                  </td>
                  <td @click="sortBy('plan_act_wct')" class="th">
                    <i class="fa fa-fw fa-sort"></i>%
                  </td>
                  <td @click="sortBy('plan_activities')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('plan_casing_info')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('plan_comment')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('last_gtm_date')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('last_gtm_type')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>

                  <td @click="sortBy('planned_choke')" class="th">
                    <i class="fa fa-fw fa-sort"></i>мм
                  </td>
                  <td @click="sortBy('planned_oil')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr3')}}
                  </td>
                  <td @click="sortBy('planned_liq')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr2')}}
                  </td>
                  <td @click="sortBy('planned_gas')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr5')}}
                  </td>
                  <td @click="sortBy('planned_wct')" class="th">
                    <i class="fa fa-fw fa-sort"></i>%
                  </td>
                  <td @click="sortBy('planned_gor')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м3/т
                  </td>
                  <td @click="sortBy('planned_month_days')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr9')}}
                  </td>
                  <td @click="sortBy('planned_monthly_oil')" class="th">
                    <i class="fa fa-fw fa-sort"></i>тонн
                  </td>
                  <td @click="sortBy('planned_monthly_gas')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr10')}}
                  </td>
                  <td @click="sortBy('planned_monthly_liq')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м3
                  </td>
                  <td @click="sortBy('planned_monthly_water')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м3
                  </td>
                  <td @click="sortBy('planned_diff_oil')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr3')}}
                  </td>
                  <td @click="sortBy('planned_diff_liq')" class="th">
                    <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr2')}}
                  </td>
                  <td @click="sortBy('planned_events')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(row, row_index) in wells" :key="row_index">
                  <td v-if="!edit">{{ row_index + 1 }}</td>
                  <td v-if="edit">{{ row_index + 1 }}</td>

                  <td v-if="!edit">{{ row.field }}</td>
                  <td v-if="edit">{{ row.field }}</td>

                  <td v-if="!edit">{{ row.rus_wellname }}</td>
                  <td v-if="edit">{{ row.rus_wellname }}</td>
                  <!-- <td>{{row.well_type}}</td> -->

                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].well_type[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].well_type[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].well_type[1][0]
                      )}`"
                    >
                    </span>
                    <span>{{ row.well_type[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].well_type[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].well_type[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].well_type[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].well_type[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input
                    @change="editrow(row, row_index)"
                    v-model="row.well_type[0]"
                    :disabled="!edit"
                  /> -->
                    <span>{{ row.well_type[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].well_type[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{row.horizon}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].horizon[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].horizon[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].horizon[1][0]
                      )}`"
                    >
                    </span>
                    <span>{{ row.horizon[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].horizon[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].horizon[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].horizon[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].horizon[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input
                    @change="editrow(row, row_index)"
                    v-model="row.horizon[0]"
                    :disabled="!edit"
                  /> -->
                    <span>{{ row.horizon[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].horizon[1][1] }}
                    </span>
                  </td>

                  <td v-if="!edit">{{ row.object }}</td>
                  <td v-if="edit">{{ row.object }}</td>

                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].block[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].block[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].block[1][0]
                      )}`"
                    >
                    </span>
                    <span>{{ row.block[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].block[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].block[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].block[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].block[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.block[0]" :disabled="!edit"> -->
                    <span>{{ row.block[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].block[1][1] }}
                    </span>
                  </td>

                  <!-- <td v-if="!edit">{{ Math.round(row.r_con * 10) / 10 }}</td>
              <td v-if="edit" contenteditable="true">
                <input
                  @change="editrow(row, row_index)"
                  v-model="row.r_con"
                  :disabled="!edit"
                />
              </td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].r_con[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].r_con[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].r_con[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.r_con[0] != null">{{
                      Math.round(row.r_con[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].r_con[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].r_con[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].r_con[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].r_con[1][0]
                      )}`"
                    >
                    </span>
                    <input
                      @change="editrow(row, row_index)"
                      class="input_edit"
                      v-model="row.r_con[0]"
                      :disabled="!edit"
                    />
                    <!-- <span>{{Math.round(row.r_con[0]*10)/10}}</span> -->
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].r_con[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.cas_OD*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].cas_OD[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].cas_OD[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].cas_OD[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.cas_OD[0] != null">{{
                      Math.round(row.cas_OD[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].cas_OD[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].cas_OD[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].cas_OD[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].cas_OD[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.cas_OD[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.cas_OD[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].cas_OD[1][1] }}
                    </span>
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.cas_ID != null">{{
                      Math.round(row.cas_ID * 10) / 10
                    }}</span>
                  </td>
                  <td v-if="edit">{{ Math.round(row.cas_ID * 10) / 10 }}</td>

                  <!-- <td>{{Math.round(row.tub_OD*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].tub_OD[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tub_OD[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].tub_OD[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.tub_OD[0] != null">{{
                      Math.round(row.tub_OD[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].tub_OD[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].tub_OD[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tub_OD[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].tub_OD[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.tub_OD[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.tub_OD[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].tub_OD[1][1] }}
                    </span>
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.tub_ID != null">{{
                      Math.round(row.tub_ID * 10) / 10
                    }}</span>
                  </td>
                  <td v-if="edit">{{ Math.round(row.tub_ID * 10) / 10 }}</td>

                  <!-- <td>{{Math.round(row.choke_d*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].choke_d[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].choke_d[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].choke_d[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.choke_d[0] != null">{{
                      Math.round(row.choke_d[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].choke_d[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].choke_d[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].choke_d[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].choke_d[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.choke_d[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.choke_d[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].choke_d[1][1] }}
                    </span>
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.h_up_perf_md[0] != null">
                      {{ Math.round(row.h_up_perf_md[0] * 10) / 10 }}
                    </span>ок
                  </td>
                  <td v-if="edit">
                    {{ Math.round(row.h_up_perf_md[0] * 10) / 10 }}
                  </td>

                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].h_up_perf_ext[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].h_up_perf_ext[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].h_up_perf_ext[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.h_up_perf_ext[0] != null">{{
                      Math.round(row.h_up_perf_ext[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].h_up_perf_ext[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].h_up_perf_ext[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].h_up_perf_ext[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].h_up_perf_ext[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.h_up_perf_ext[0]" :disabled="!edit"> -->
                    <span>{{
                      Math.round(row.h_up_perf_ext[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].h_up_perf_ext[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{row.exp_meth}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].exp_meth[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].exp_meth[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].exp_meth[1][0]
                      )}`"
                    >
                    </span>
                    <span>{{ row.exp_meth[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].exp_meth[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].exp_meth[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].exp_meth[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].exp_meth[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.exp_meth[0]" :disabled="!edit"> -->
                    <span>{{ row.exp_meth[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].exp_meth[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{row.pump_type}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].pump_type[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].pump_type[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].pump_type[1][0]
                      )}`"
                    >
                    </span>
                    <span>{{ row.pump_type[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].pump_type[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].pump_type[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].pump_type[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].pump_type[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.pump_type[0]" :disabled="!edit"> -->
                    <span>{{ row.pump_type[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].pump_type[1][1] }}
                    </span>
                  </td>

                  <td v-if="!edit">{{ row.type_sr }}</td>
                  <td v-if="edit">{{ row.type_sr }}</td>

                  <!-- <td>{{Math.round(row.spm*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].spm[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].spm[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].spm[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.spm[0] != null">{{
                      Math.round(row.spm[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].spm[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].spm[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].spm[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].spm[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.spm[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.spm[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].spm[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.stroke_len*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].stroke_len[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].stroke_len[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].stroke_len[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.stroke_len[0] != null">{{
                      Math.round(row.stroke_len[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].stroke_len[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].stroke_len[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].stroke_len[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].stroke_len[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.stroke_len[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.stroke_len[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].stroke_len[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.q_theor*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].q_theor[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].q_theor[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].q_theor[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="Math.round(row.q_theor[0] * 10) / 10 != '0'">{{
                      Math.round(row.q_theor[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].q_theor[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].q_theor[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].q_theor[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].q_theor[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="Math.round(row.q_theor[0] * 10) / 10 != '0'">{{
                      Math.round(row.q_theor[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].q_theor[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.freq*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].freq[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].freq[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].freq[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.freq[0] != null">{{
                      Math.round(row.freq[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].freq[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    contenteditable="true"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].freq[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].freq[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].freq[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.freq[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.freq[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].freq[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.h_pump_set*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].h_pump_set[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].h_pump_set[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].h_pump_set[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.h_pump_set[0] != null">{{
                      Math.round(row.h_pump_set[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].h_pump_set[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].h_pump_set[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].h_pump_set[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].h_pump_set[1][0]
                      )}`"
                    >
                    </span>
                    <input
                      class="input_edit"
                      @change="editrow(row, row_index)"
                      v-model="row.h_pump_set[0]"
                      :disabled="!edit"
                    />
                    <!-- <span>{{Math.round(row.h_pump_set[0]*10)/10}}</span> -->
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].h_pump_set[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.whp*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].whp[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].whp[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].whp[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.whp[0] != null">{{
                      Math.round(row.whp[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].whp[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].whp[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].whp[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].whp[1][0]
                      )}`"
                    >
                    </span>
                    <input
                      class="input_edit"
                      @change="editrow(row, row_index)"
                      v-model="row.whp[0]"
                      :disabled="!edit"
                    />
                    <!-- <span>{{Math.round(row.whp[0]*10)/10}}</span> -->
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].whp[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.line_p*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].line_p[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].line_p[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].line_p[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.line_p[0] != null">{{
                      Math.round(row.line_p[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].line_p[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].line_p[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].line_p[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].line_p[1][0]
                      )}`"
                    >
                    </span>
                    <input
                      class="input_edit"
                      @change="editrow(row, row_index)"
                      v-model="row.line_p[0]"
                      :disabled="!edit"
                    />
                    <!-- <span>{{Math.round(row.line_p[0]*10)/10}}</span> -->
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].line_p[1][1] }}
                    </span>
                  </td>

                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].p_res[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].p_res[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].p_res[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.p_res[0] != null">{{
                      Math.round(row.p_res[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].p_res[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].p_res[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].p_res[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].p_res[1][0]
                      )}`"
                    >
                    </span>
                    <input
                      class="input_edit"
                      @change="editrow(row, row_index)"
                      v-model="row.p_res[0]"
                      :disabled="!edit"
                    />
                    <!-- <span>{{Math.round(row.p_res[0]*10)/10}}</span> -->
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].p_res[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.h_dyn*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].h_dyn[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].h_dyn[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].h_dyn[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.h_dyn[0] != null">{{
                      Math.round(row.h_dyn[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].h_dyn[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].h_dyn[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].h_dyn[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].h_dyn[1][0]
                      )}`"
                    >
                    </span>
                    <input
                      class="input_edit"
                      @change="editrow(row, row_index)"
                      v-model="row.h_dyn[0]"
                      :disabled="!edit"
                    />
                    <!-- <span>{{Math.round(row.h_dyn[0]*10)/10}}</span> -->
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].h_dyn[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.p_annular*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].p_annular[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].p_annular[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].p_annular[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.p_annular[0] != null">{{
                      Math.round(row.p_annular[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].p_annular[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].p_annular[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].p_annular[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].p_annular[1][0]
                      )}`"
                    >
                    </span>
                    <input
                      class="input_edit"
                      @change="editrow(row, row_index)"
                      v-model="row.p_annular[0]"
                      :disabled="!edit"
                    />
                    <!-- <span>{{Math.round(row.p_annular[0]*10)/10}}</span> -->
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].p_annular[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.p_intake*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].p_intake[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].p_intake[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].p_intake[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.p_intake[0] != null">{{
                      Math.round(row.p_intake[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].p_intake[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].p_intake[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].p_intake[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].p_intake[1][0]
                      )}`"
                    >
                    </span>
                    <input
                      class="input_edit"
                      @change="editrow(row, row_index)"
                      v-model="row.p_intake[0]"
                      :disabled="!edit"
                    />
                    <!-- <span>{{Math.round(row.p_intake[0]*10)/10}}</span> -->
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].p_intake[1][1] }}
                    </span>
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.bhp_prev_m != null">{{
                      Math.round(row.bhp_prev_m * 10) / 10
                    }}</span>
                  </td>
                  <td v-if="edit">
                    {{ Math.round(row.bhp_prev_m * 10) / 10 }}
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.q_l_prev_m != null">{{
                      Math.round(row.q_l_prev_m * 10) / 10
                    }}</span>
                  </td>
                  <td v-if="edit">
                    {{ Math.round(row.q_l_prev_m * 10) / 10 }}
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.wct_prev_m != null">{{
                      Math.round(row.wct_prev_m * 10) / 10
                    }}</span>
                  </td>
                  <td v-if="edit">
                    {{ Math.round(row.wct_prev_m * 10) / 10 }}
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.h_dyn_prev_m != null">{{
                      Math.round(row.h_dyn_prev_m * 10) / 10
                    }}</span>
                  </td>
                  <td v-if="edit">
                    {{ Math.round(row.h_dyn_prev_m * 10) / 10 }}
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.pi_prev_m != null">{{
                      Math.round(row.pi_prev_m * 10) / 10
                    }}</span>
                  </td>
                  <td v-if="edit">{{ Math.round(row.pi_prev_m * 10) / 10 }}</td>

                  <!-- <td>{{Math.round(row.bhp*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].bhp[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].bhp[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].bhp[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.bhp[0] != null">{{
                      Math.round(row.bhp[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].bhp[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].bhp[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].bhp[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].bhp[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.bhp[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.bhp[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].bhp[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.q_o*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].q_o[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].q_o[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].q_o[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.q_o[0] != null">{{
                      Math.round(row.q_o[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].q_o[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].q_o[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].q_o[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].q_o[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.q_o[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.q_o[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].q_o[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.q_l*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].q_l[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].q_l[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].q_l[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.q_l[0] != null">{{
                      Math.round(row.q_l[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].q_l[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].q_l[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].q_l[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].q_l[1][0]
                      )}`"
                    >
                    </span>
                    <input
                      class="input_edit"
                      @change="editrow(row, row_index)"
                      v-model="row.q_l[0]"
                      :disabled="!edit"
                    />
                    <!-- <span>{{Math.round(row.q_l[0]*10)/10}}</span> -->
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].q_l[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.wct*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].wct[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].wct[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].wct[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.wct[0] != null">{{
                      Math.round(row.wct[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].wct[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].wct[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].wct[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].wct[1][0]
                      )}`"
                    >
                    </span>
                    <input
                      class="input_edit"
                      @change="editrow(row, row_index)"
                      v-model="row.wct[0]"
                      :disabled="!edit"
                    />
                    <!-- <span>{{Math.round(row.wct[0]*10)/10}}</span> -->
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].wct[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.gor*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].gor[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].gor[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].gor[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.gor[0] != null">{{
                      Math.round(row.gor[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].gor[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].gor[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].gor[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].gor[1][0]
                      )}`"
                    >
                    </span>
                    <input
                      class="input_edit"
                      @change="editrow(row, row_index)"
                      v-model="row.gor[0]"
                      :disabled="!edit"
                    />
                    <!-- <span>{{Math.round(row.gor[0]*10)/10}}</span> -->
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].gor[1][1] }}
                    </span>
                  </td>


                  <!-- <td>{{row.well_status_last_day}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].well_status_last_day[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].well_status_last_day[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].well_status_last_day[1][0]
                      )}`"
                    >
                    </span>
                    <span>{{ row.well_status_last_day[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].well_status_last_day[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].well_status_last_day[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].well_status_last_day[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].well_status_last_day[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.well_status_last_day[0]" :disabled="!edit"> -->
                    <span>{{ row.well_status_last_day[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].well_status_last_day[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.P_bubble_point*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].P_bubble_point[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].P_bubble_point[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].P_bubble_point[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.P_bubble_point[0] != null">{{
                      Math.round(row.P_bubble_point[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].P_bubble_point[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].P_bubble_point[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].P_bubble_point[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].P_bubble_point[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.P_bubble_point[0]" :disabled="!edit"> -->
                    <span>{{
                      Math.round(row.P_bubble_point[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].P_bubble_point[1][1] }}
                    </span>
                  </td>
                 
                  <!-- <td>{{Math.round(row.t_res*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].t_res[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].t_res[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].t_res[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.t_res[0] != null">{{
                      Math.round(row.t_res[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].t_res[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].t_res[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].t_res[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].t_res[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.t_res[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.t_res[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].t_res[1][1] }}
                    </span>
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.wht != null">{{
                      Math.round(row.wht * 10) / 10
                    }}</span>
                  </td>
                  <td v-if="edit">{{ Math.round(row.wht * 10) / 10 }}</td>

                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].grp_skin[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].grp_skin[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].grp_skin[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.grp_skin[0] != null">{{
                      Math.round(row.grp_skin[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].grp_skin[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].grp_skin[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].grp_skin[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].grp_skin[1][0]
                      )}`"
                    >
                    </span>
                    <input
                      class="input_edit"
                      @change="editrow(row, row_index)"
                      v-model="row.grp_skin[0]"
                      :disabled="!edit"
                    />
                    <!-- <span>{{ Math.round(row.grp_skin[0] * 10) / 10 }}</span> -->
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].grp_skin[1][1] }}
                    </span>
                  </td>
                  <td v-if="!edit">
                    <span v-if="row.grp_jd != null">{{
                      Math.round(row.grp_jd * 100) / 100
                    }}</span>
                  </td>
                  <td v-if="edit">{{ Math.round(row.grp_jd * 10) / 10 }}</td>

                  <!-- <td>{{row.grp_date}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].grp_date[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].grp_date[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].grp_date[1][0]
                      )}`"
                    >
                    </span>
                    <span>{{ row.grp_date[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].grp_date[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].grp_date[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].grp_date[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].grp_date[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.grp_date[0]" :disabled="!edit"> -->
                    <span>{{ row.grp_date[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].grp_date[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{row.grp_contractor}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].grp_contractor[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].grp_contractor[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].grp_contractor[1][0]
                      )}`"
                    >
                    </span>
                    <span>{{ row.grp_contractor[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].grp_contractor[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].grp_contractor[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].grp_contractor[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].grp_contractor[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.grp_contractor[0]" :disabled="!edit"> -->
                    <span>{{ row.grp_contractor[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].grp_contractor[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.visc_oil_rc*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].visc_oil_rc[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].visc_oil_rc[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].visc_oil_rc[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.visc_oil_rc[0] != null">{{
                      Math.round(row.visc_oil_rc[0] * 100) / 100
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].visc_oil_rc[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].visc_oil_rc[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].visc_oil_rc[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].visc_oil_rc[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.visc_oil_rc[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.visc_oil_rc[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].visc_oil_rc[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.visc_wat_rc*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].visc_wat_rc[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].visc_wat_rc[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].visc_wat_rc[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.visc_wat_rc[0] != null">{{
                      Math.round(row.visc_wat_rc[0] * 100) / 100
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].visc_wat_rc[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].visc_wat_rc[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].visc_wat_rc[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].visc_wat_rc[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.visc_wat_rc[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.visc_wat_rc[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].visc_wat_rc[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.visc_liq_rc*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].visc_liq_rc[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].visc_liq_rc[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].visc_liq_rc[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.visc_liq_rc[0] != null">{{
                      Math.round(row.visc_liq_rc[0] * 100) / 100
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].visc_liq_rc[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].visc_liq_rc[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].visc_liq_rc[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].visc_liq_rc[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.visc_liq_rc[0]" :disabled="!edit"> -->
                    <span>{{
                      Math.round(row.visc_liq_rc[0] * 100) / 100
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].visc_liq_rc[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.bo*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].bo[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].bo[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].bo[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.bo[0] != null">{{
                      Math.round(row.bo[0] * 100) / 100
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].bo[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].bo[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].bo[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].bo[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.bo[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.bo[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].bo[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.dens_oil*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].dens_oil[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].dens_oil[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].dens_oil[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.dens_oil[0] != null">{{
                      Math.round(row.dens_oil[0] * 100) / 100
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].dens_oil[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].dens_oil[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].dens_oil[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].dens_oil[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.dens_oil[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.dens_oil[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].dens_oil[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.dens_liq*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].dens_liq[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].dens_liq[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].dens_liq[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.dens_liq[0] != null">{{
                      Math.round(row.dens_liq[0] * 100) / 100
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].dens_liq[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].dens_liq[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].dens_liq[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].dens_liq[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.dens_liq[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.dens_liq[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].dens_liq[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.h_perf*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].h_perf[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].h_perf[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].h_perf[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.h_perf[0] != null">{{
                      Math.round(row.h_perf[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].h_perf[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].h_perf[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].h_perf[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].h_perf[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.h_perf[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.h_perf[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].h_perf[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.k*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].k[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].k[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].k[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.k[0] != null">{{
                      Math.round(row.k[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].k[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].k[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].k[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].k[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.k[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.k[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].k[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.kh*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].kh[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].kh[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].kh[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.kh[0] != null">{{
                      Math.round(row.kh[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].kh[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].kh[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].kh[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].kh[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.kh[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.kh[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].kh[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.pi*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].pi[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].pi[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].pi[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.pi[0] != null">{{
                      Math.round(row.pi[0] * 100) / 100
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].pi[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].pi[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].pi[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].pi[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.pi[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.pi[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].pi[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.tp_idn_bhp*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].tp_idn_bhp[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tp_idn_bhp[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].tp_idn_bhp[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.tp_idn_bhp[0] != null">{{
                      Math.round(row.tp_idn_bhp[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].tp_idn_bhp[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].tp_idn_bhp[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tp_idn_bhp[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].tp_idn_bhp[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_bhp[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.tp_idn_bhp[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].tp_idn_bhp[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.tp_idn_liq*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].tp_idn_liq[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tp_idn_liq[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].tp_idn_liq[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.tp_idn_liq[0] != null">{{
                      Math.round(row.tp_idn_liq[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].tp_idn_liq[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].tp_idn_liq[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tp_idn_liq[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].tp_idn_liq[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_liq[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.tp_idn_liq[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].tp_idn_liq[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.tp_idn_liq_cas_d_corr*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].tp_idn_liq_cas_d_corr[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tp_idn_liq_cas_d_corr[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].tp_idn_liq_cas_d_corr[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.tp_idn_liq_cas_d_corr[0] != null">{{
                      Math.round(row.tp_idn_liq_cas_d_corr[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].tp_idn_liq_cas_d_corr[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].tp_idn_liq_cas_d_corr[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tp_idn_liq_cas_d_corr[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].tp_idn_liq_cas_d_corr[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_liq_cas_d_corr[0]" :disabled="!edit"> -->
                    <span>{{
                      Math.round(row.tp_idn_liq_cas_d_corr[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].tp_idn_liq_cas_d_corr[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.tp_idn_oil*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].tp_idn_oil[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tp_idn_oil[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].tp_idn_oil[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.tp_idn_oil[0] != null">{{
                      Math.round(row.tp_idn_oil[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].tp_idn_oil[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].tp_idn_oil[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tp_idn_oil[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].tp_idn_oil[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_oil[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.tp_idn_oil[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].tp_idn_oil[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.tp_idn_oil_inc*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].tp_idn_oil_inc[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tp_idn_oil_inc[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].tp_idn_oil_inc[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.tp_idn_oil_inc[0] != null">{{
                      Math.round(row.tp_idn_oil_inc[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].tp_idn_oil_inc[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].tp_idn_oil_inc[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tp_idn_oil_inc[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].tp_idn_oil_inc[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_oil_inc[0]" :disabled="!edit"> -->
                    <span>{{
                      Math.round(row.tp_idn_oil_inc[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].tp_idn_oil_inc[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.tp_idn_jd*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].tp_idn_jd[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tp_idn_jd[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].tp_idn_jd[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.tp_idn_jd[0] != null">{{
                      Math.round(row.tp_idn_jd[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].tp_idn_jd[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].tp_idn_jd[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tp_idn_jd[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].tp_idn_jd[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_jd[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.tp_idn_jd[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].tp_idn_jd[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.tp_idn_skin*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].tp_idn_skin[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tp_idn_skin[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].tp_idn_skin[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.tp_idn_skin[0] != null">{{
                      Math.round(row.tp_idn_skin[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].tp_idn_skin[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].tp_idn_skin[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tp_idn_skin[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].tp_idn_skin[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_skin[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.tp_idn_skin[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].tp_idn_skin[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.tp_idn_pi_after*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].tp_idn_pi_after[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tp_idn_pi_after[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].tp_idn_pi_after[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.tp_idn_pi_after[0] != null">{{
                      Math.round(row.tp_idn_pi_after[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].tp_idn_pi_after[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].tp_idn_pi_after[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tp_idn_pi_after[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].tp_idn_pi_after[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_pi_after[0]" :disabled="!edit"> -->
                    <span>{{
                      Math.round(row.tp_idn_pi_after[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].tp_idn_pi_after[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.tp_idn_grp_q_liq*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].tp_idn_grp_q_liq[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tp_idn_grp_q_liq[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].tp_idn_grp_q_liq[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.tp_idn_grp_q_liq[0] != null">{{
                      Math.round(row.tp_idn_grp_q_liq[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].tp_idn_grp_q_liq[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].tp_idn_grp_q_liq[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tp_idn_grp_q_liq[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].tp_idn_grp_q_liq[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_grp_q_liq[0]" :disabled="!edit"> -->
                    <span>{{
                      Math.round(row.tp_idn_grp_q_liq[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].tp_idn_grp_q_liq[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.tp_idn_grp_q_liq_cas_d_corr*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][0] !==
                          '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][0] !==
                            '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.tp_idn_grp_q_liq_cas_d_corr[0] != null">{{
                      Math.round(row.tp_idn_grp_q_liq_cas_d_corr[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][0] !==
                          '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][0] !==
                            '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_grp_q_liq_cas_d_corr[0]" :disabled="!edit"> -->
                    <span>{{
                      Math.round(row.tp_idn_grp_q_liq_cas_d_corr[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.tp_idn_grp_q_oil*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].tp_idn_grp_q_oil[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tp_idn_grp_q_oil[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].tp_idn_grp_q_oil[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.tp_idn_grp_q_oil[0] != null">{{
                      Math.round(row.tp_idn_grp_q_oil[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].tp_idn_grp_q_oil[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].tp_idn_grp_q_oil[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tp_idn_grp_q_oil[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].tp_idn_grp_q_oil[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_grp_q_oil[0]" :disabled="!edit"> -->
                    <span>{{
                      Math.round(row.tp_idn_grp_q_oil[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].tp_idn_grp_q_oil[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.tp_idn_grp_q_oil_inc*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].tp_idn_grp_q_oil_inc[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tp_idn_grp_q_oil_inc[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].tp_idn_grp_q_oil_inc[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.tp_idn_grp_q_oil_inc[0] != null">{{
                      Math.round(row.tp_idn_grp_q_oil_inc[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].tp_idn_grp_q_oil_inc[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].tp_idn_grp_q_oil_inc[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tp_idn_grp_q_oil_inc[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].tp_idn_grp_q_oil_inc[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_grp_q_oil_inc[0]" :disabled="!edit"> -->
                    <span>{{
                      Math.round(row.tp_idn_grp_q_oil_inc[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].tp_idn_grp_q_oil_inc[1][1] }}
                    </span>
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.tp_idn_q_oil_inc_perc != null">
                      {{ Math.round(row.tp_idn_q_oil_inc_perc * 10) / 10 }}
                    </span>
                  </td>
                  <td v-if="edit">
                    {{ Math.round(row.tp_idn_q_oil_inc_perc * 10) / 10 }}
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.gt_total_inc != null">{{
                      Math.round(row.gt_total_inc * 10) / 10
                    }}</span>
                  </td>
                  <td v-if="edit">
                    {{ Math.round(row.gt_total_inc * 10) / 10 }}
                  </td>

                  <!-- <td>{{Math.round(row.gp_idn_bhp*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].gp_idn_bhp[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].gp_idn_bhp[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].gp_idn_bhp[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.gp_idn_bhp[0] != null">{{
                      Math.round(row.gp_idn_bhp[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].gp_idn_bhp[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].gp_idn_bhp[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].gp_idn_bhp[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].gp_idn_bhp[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.gp_idn_bhp[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.gp_idn_bhp[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].gp_idn_bhp[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.gp_idn_q_liq*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].gp_idn_q_liq[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].gp_idn_q_liq[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].gp_idn_q_liq[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.gp_idn_q_liq[0] != null">{{
                      Math.round(row.gp_idn_q_liq[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].gp_idn_q_liq[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].gp_idn_q_liq[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].gp_idn_q_liq[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].gp_idn_q_liq[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.gp_idn_q_liq[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.gp_idn_q_liq[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].gp_idn_q_liq[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.gp_idn_q_liq_cas_d_corr*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].gp_idn_q_liq_cas_d_corr[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].gp_idn_q_liq_cas_d_corr[1][0] !==
                            '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].gp_idn_q_liq_cas_d_corr[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.gp_idn_q_liq_cas_d_corr[0] != null">{{
                      Math.round(row.gp_idn_q_liq_cas_d_corr[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].gp_idn_q_liq_cas_d_corr[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].gp_idn_q_liq_cas_d_corr[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].gp_idn_q_liq_cas_d_corr[1][0] !==
                            '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].gp_idn_q_liq_cas_d_corr[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.gp_idn_q_liq_cas_d_corr[0]" :disabled="!edit"> -->
                    <span>{{
                      Math.round(row.gp_idn_q_liq_cas_d_corr[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].gp_idn_q_liq_cas_d_corr[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.gp_idn_q_oil*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].gp_idn_q_oil[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].gp_idn_q_oil[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].gp_idn_q_oil[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.gp_idn_q_oil[0] != null">{{
                      Math.round(row.gp_idn_q_oil[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].gp_idn_q_oil[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].gp_idn_q_oil[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].gp_idn_q_oil[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].gp_idn_q_oil[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.gp_idn_q_oil[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.gp_idn_q_oil[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].gp_idn_q_oil[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.gp_idn_q_oil_inc*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].gp_idn_q_oil_inc[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].gp_idn_q_oil_inc[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].gp_idn_q_oil_inc[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.gp_idn_q_oil_inc[0] != null">{{
                      Math.round(row.gp_idn_q_oil_inc[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].gp_idn_q_oil_inc[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].gp_idn_q_oil_inc[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].gp_idn_q_oil_inc[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].gp_idn_q_oil_inc[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.gp_idn_q_oil_inc[0]" :disabled="!edit"> -->
                    <span>{{
                      Math.round(row.gp_idn_q_oil_inc[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].gp_idn_q_oil_inc[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.gp_grp_q_liq*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].gp_grp_q_liq[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].gp_grp_q_liq[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].gp_grp_q_liq[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.gp_grp_q_liq[0] != null">{{
                      Math.round(row.gp_grp_q_liq[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].gp_grp_q_liq[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].gp_grp_q_liq[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].gp_grp_q_liq[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].gp_grp_q_liq[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.gp_grp_q_liq[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.gp_grp_q_liq[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].gp_grp_q_liq[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.gp_grp_q_liq_cas_d_corr*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].gp_grp_q_liq_cas_d_corr[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].gp_grp_q_liq_cas_d_corr[1][0] !==
                            '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].gp_grp_q_liq_cas_d_corr[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.gp_grp_q_liq_cas_d_corr[0] != null">{{
                      Math.round(row.gp_grp_q_liq_cas_d_corr[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].gp_grp_q_liq_cas_d_corr[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].gp_grp_q_liq_cas_d_corr[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].gp_grp_q_liq_cas_d_corr[1][0] !==
                            '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].gp_grp_q_liq_cas_d_corr[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.gp_grp_q_liq_cas_d_corr[0]" :disabled="!edit"> -->
                    <span>{{
                      Math.round(row.gp_grp_q_liq_cas_d_corr[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].gp_grp_q_liq_cas_d_corr[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.gp_grp_q_oil*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].gp_grp_q_oil[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].gp_grp_q_oil[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].gp_grp_q_oil[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.gp_grp_q_oil[0] != null">{{
                      Math.round(row.gp_grp_q_oil[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].gp_grp_q_oil[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].gp_grp_q_oil[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].gp_grp_q_oil[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].gp_grp_q_oil[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.gp_grp_q_oil[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.gp_grp_q_oil[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].gp_grp_q_oil[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.gp_grp_q_oil_inc*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].gp_grp_q_oil_inc[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].gp_grp_q_oil_inc[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].gp_grp_q_oil_inc[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.gp_grp_q_oil_inc[0] != null">{{
                      Math.round(row.gp_grp_q_oil_inc[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].gp_grp_q_oil_inc[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].gp_grp_q_oil_inc[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].gp_grp_q_oil_inc[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].gp_grp_q_oil_inc[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.gp_grp_q_oil_inc[0]" :disabled="!edit"> -->
                    <span>{{
                      Math.round(row.gp_grp_q_oil_inc[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].gp_grp_q_oil_inc[1][1] }}
                    </span>
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.gp_total_inc_perc != null">{{
                      Math.round(row.gp_total_inc_perc * 10) / 10
                    }}</span>
                  </td>
                  <td v-if="edit">
                    {{ Math.round(row.gp_total_inc_perc * 10) / 10 }}
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.gp_total_inc != null">{{
                      Math.round(row.gp_total_inc * 10) / 10
                    }}</span>
                  </td>
                  <td v-if="edit">
                    {{ Math.round(row.gp_total_inc * 10) / 10 }}
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.error_count != null">{{
                      row.error_count
                    }}</span>
                  </td>
                  <td v-if="edit">{{ row.error_count }}</td>

                  <td v-if="!edit">{{ row.error_first }}</td>
                  <td v-if="edit">{{ row.error_first }}</td>

                  <td v-if="!edit">
                    <span v-if="row.error_warning != null">{{
                      row.error_warning
                    }}</span>
                  </td>
                  <td v-if="edit">{{ row.error_warning }}</td>

                  <td v-if="!edit">{{ row.error_first_warning }}</td>
                  <td v-if="edit">{{ row.error_first_warning }}</td>

                  <!-- <td>{{Math.round(row.idn_pump_depth_max*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].idn_pump_depth_max[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].idn_pump_depth_max[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].idn_pump_depth_max[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.idn_pump_depth_max[0] != null">{{
                      Math.round(row.idn_pump_depth_max[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].idn_pump_depth_max[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].idn_pump_depth_max[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].idn_pump_depth_max[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].idn_pump_depth_max[1][0]
                      )}`"
                    >
                    </span>
                    <input
                      class="input_edit"
                      @change="editrow(row, row_index)"
                      v-model="row.idn_pump_depth_max[0]"
                      :disabled="!edit"
                    />
                    <!-- <span>{{Math.round(row.idn_pump_depth_max[0]*10)/10}}</span> -->
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].idn_pump_depth_max[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{row.stop_date}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].stop_date[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].stop_date[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].stop_date[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.stop_date[0] != null">{{
                      row.stop_date[0]
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].stop_date[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].stop_date[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].stop_date[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].stop_date[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.stop_date[0]" :disabled="!edit"> -->
                    <span>{{ row.stop_date[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].stop_date[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{row.layers_count}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].layers_count[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].layers_count[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].layers_count[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.layers_count[0] != null">{{
                      row.layers_count[0]
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].layers_count[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].layers_count[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].layers_count[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].layers_count[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.layers_count[0]" :disabled="!edit"> -->
                    <span>{{ row.layers_count[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].layers_count[1][1] }}
                    </span>
                  </td>

                  <!-- <td v-if="!edit">{{row.zone}}</td>
                          <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.zone" :disabled="!edit"></td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].zone[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].zone[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].zone[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.zone[0] != null">{{ row.zone[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].zone[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].zone[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].zone[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].zone[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.zone[0]" :disabled="!edit"> -->
                    <span>{{ row.zone[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].zone[1][1] }}
                    </span>
                  </td>

                  <!-- <td v-if="!edit">{{row.tseh}}</td>
                          <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.tseh" :disabled="!edit"></td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].tseh[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tseh[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].tseh[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.tseh[0] != null">{{ row.tseh[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].tseh[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].tseh[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tseh[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].tseh[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.tseh[0]" :disabled="!edit"> -->
                    <span>{{ row.tseh[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].tseh[1][1] }}
                    </span>
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.semi_free_flow[0] != null">{{
                      row.semi_free_flow[0]
                    }}</span>
                  </td>
                  <td v-if="edit">{{ row.semi_free_flow[0] }}</td>

                  <!-- <td>{{row.non_profit[0]}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].non_profit[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].non_profit[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].non_profit[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.non_profit[0] != null">{{
                      row.non_profit[0]
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].non_profit[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].non_profit[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].non_profit[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].non_profit[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.non_profit[0]" :disabled="!edit"> -->
                    <span>{{ row.non_profit[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].non_profit[1][1] }}
                    </span>
                  </td>

                  <!-- <td v-if="!edit">{{row.unsteady_state}}</td>
                          <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.unsteady_state" :disabled="!edit"></td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].unsteady_state[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].unsteady_state[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].unsteady_state[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.unsteady_state[0] != null">{{
                      row.unsteady_state[0]
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].unsteady_state[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].unsteady_state[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].unsteady_state[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].unsteady_state[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.unsteady_state[0]" :disabled="!edit"> -->
                    <span>{{ row.unsteady_state[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].unsteady_state[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{row.start_up_date}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].start_up_date[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].start_up_date[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].start_up_date[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.start_up_date[0] != null">{{
                      row.start_up_date[0]
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].start_up_date[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].start_up_date[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].start_up_date[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].start_up_date[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.start_up_date[0]" :disabled="!edit"> -->
                    <span>{{ row.start_up_date[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].start_up_date[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{row.well_project_purpose}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].well_project_purpose[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].well_project_purpose[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].well_project_purpose[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.well_project_purpose[0] != null">{{
                      row.well_project_purpose[0]
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].well_project_purpose[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].well_project_purpose[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].well_project_purpose[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].well_project_purpose[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.well_project_purpose[0]" :disabled="!edit"> -->
                    <span>{{ row.well_project_purpose[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].well_project_purpose[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.bhp_meter*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].bhp_meter[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].bhp_meter[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].bhp_meter[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.bhp_meter[0] != null">{{
                      Math.round(row.bhp_meter[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].bhp_meter[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].bhp_meter[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].bhp_meter[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].bhp_meter[1][0]
                      )}`"
                    >
                    </span>
                    <input
                      class="input_edit"
                      @change="editrow(row, row_index)"
                      v-model="row.bhp_meter[0]"
                      :disabled="!edit"
                    />
                    <!-- <span>{{Math.round(row.bhp_meter[0]*10)/10}}</span> -->
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].bhp_meter[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.oil_net_pay*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].oil_net_pay[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].oil_net_pay[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].oil_net_pay[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.oil_net_pay[0] != null">{{
                      Math.round(row.oil_net_pay[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].oil_net_pay[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].oil_net_pay[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].oil_net_pay[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].oil_net_pay[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.oil_net_pay[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.oil_net_pay[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].oil_net_pay[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.oil_cumulative*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].oil_cumulative[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].oil_cumulative[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].oil_cumulative[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.oil_cumulative[0] != null">{{
                      Math.round(row.oil_cumulative[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].oil_cumulative[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].oil_cumulative[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].oil_cumulative[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].oil_cumulative[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.oil_cumulative[0]" :disabled="!edit"> -->
                    <span>{{
                      Math.round(row.oil_cumulative[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].oil_cumulative[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.max_q_liq_hist*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].max_q_liq_hist[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].max_q_liq_hist[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].max_q_liq_hist[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.max_q_liq_hist[0] != null">{{
                      Math.round(row.max_q_liq_hist[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].max_q_liq_hist[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].max_q_liq_hist[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].max_q_liq_hist[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].max_q_liq_hist[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.max_q_liq_hist[0]" :disabled="!edit"> -->
                    <span>{{
                      Math.round(row.max_q_liq_hist[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].max_q_liq_hist[1][1] }}
                    </span>
                  </td>

                  <td v-if="!edit">
                    {{ Math.round(row.dist_to_inj_well * 10) / 10 }}
                  </td>
                  <td v-if="edit">
                    {{ Math.round(row.dist_to_inj_well * 10) / 10 }}
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.dist_to_woc != null">{{
                      Math.round(row.dist_to_woc * 10) / 10
                    }}</span>
                  </td>
                  <td v-if="edit">
                    {{ Math.round(row.dist_to_woc * 10) / 10 }}
                  </td>

                  <!-- <td>{{Math.round(row.curr_bh*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].curr_bh[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].curr_bh[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].curr_bh[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.curr_bh[0] != null">{{
                      Math.round(row.curr_bh[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].curr_bh[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].curr_bh[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].curr_bh[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].curr_bh[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.curr_bh[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.curr_bh[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].curr_bh[1][1] }}
                    </span>
                  </td>

                  <!-- <td>{{Math.round(row.pump_fillage*10)/10}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].pump_fillage[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].pump_fillage[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].pump_fillage[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.pump_fillage[0] != null">{{
                      Math.round(row.pump_fillage[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].pump_fillage[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].pump_fillage[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].pump_fillage[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].pump_fillage[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.pump_fillage[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.pump_fillage[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].pump_fillage[1][1] }}
                    </span>
                  </td>

                  <td v-if="!edit">{{ row.gzu_type }}</td>
                  <td v-if="edit">{{ row.gzu_type }}</td>

                  <td v-if="!edit">
                    <span v-if="row.p_res_init != null">{{
                      Math.round(row.p_res_init * 10) / 10
                    }}</span>
                  </td>
                  <td v-if="edit">
                    {{ Math.round(row.p_res_init * 10) / 10 }}
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.q_liq_charac != null">{{
                      Math.round(row.q_liq_charac * 10) / 10
                    }}</span>
                  </td>
                  <td v-if="edit">
                    {{ Math.round(row.q_liq_charac * 10) / 10 }}
                  </td>

                  <!-- <td v-if="!edit">{{row.APV_t_rab}}</td>
                          <td v-if="edit">{{row.APV_t_rab}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].APV_t_rab[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].APV_t_rab[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].APV_t_rab[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.APV_t_rab[0] != null">{{
                      row.APV_t_rab[0]
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].APV_t_rab[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].APV_t_rab[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].APV_t_rab[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].APV_t_rab[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.APV_t_rab[0]" :disabled="!edit"> -->
                    <span>{{ row.APV_t_rab[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].APV_t_rab[1][1] }}
                    </span>
                  </td>

                  <!-- <td v-if="!edit">{{row.APV_t_nak}}</td>
                          <td v-if="edit">{{row.APV_t_nak}}</td> -->
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].APV_t_nak[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].APV_t_nak[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].APV_t_nak[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.APV_t_nak != null">{{
                      row.APV_t_nak[0]
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].APV_t_nak[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].APV_t_nak[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].APV_t_nak[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].APV_t_nak[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.APV_t_nak[0]" :disabled="!edit"> -->
                    <span>{{ row.APV_t_nak[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].APV_t_nak[1][1] }}
                    </span>
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.plan_izo_work != null">{{
                      row.plan_izo_work
                    }}</span>
                  </td>
                  <td v-if="edit">{{ row.plan_izo_work }}</td>

                  <td v-if="!edit">
                    <span v-if="row.plan_act_q_l != null">{{
                      Math.round(row.plan_act_q_l * 10) / 10
                    }}</span>
                  </td>
                  <td v-if="edit">
                    {{ Math.round(row.plan_act_q_l * 10) / 10 }}
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.plan_act_wct != null">{{
                      Math.round(row.plan_act_wct * 10) / 10
                    }}</span>
                  </td>
                  <td v-if="edit">
                    {{ Math.round(row.plan_act_wct * 10) / 10 }}
                  </td>

                  <td v-if="!edit">{{ row.plan_activities }}</td>
                  <td v-if="edit">{{ row.plan_activities }}</td>

                  <td v-if="!edit">{{ row.plan_casing_info }}</td>
                  <td v-if="edit">{{ row.plan_casing_info }}</td>

                  <td v-if="!edit">{{ row.plan_comment }}</td>
                  <td v-if="edit">{{ row.plan_comment }}</td>

                  <td v-if="!edit">{{ row.last_gtm_date }}</td>
                  <td v-if="edit">{{ row.last_gtm_date }}</td>

                  <td v-if="!edit">{{ row.last_gtm_type }}</td>
                  <td v-if="edit">{{ row.last_gtm_type }}</td>

                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].planned_choke[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].planned_choke[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].planned_choke[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.planned_choke[0] != null">{{
                      row.planned_choke[0]
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].planned_choke[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].planned_choke[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].planned_choke[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].planned_choke[1][0]
                      )}`"
                    >
                    </span>
                    <input
                      class="input_edit"
                      @change="editrow(row, row_index)"
                      v-model="row.planned_choke[0]"
                      :disabled="!edit"
                    />
                    <!-- <span>{{Math.round(row.APV_t_rab[0]*10)/10}}</span> -->
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].planned_choke[1][1] }}
                    </span>
                  </td>

                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].planned_oil[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].planned_oil[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].planned_oil[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.planned_oil[0] != null">{{
                      Math.round(row.planned_oil[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].planned_oil[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].planned_oil[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].planned_oil[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].planned_oil[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.planned_oil[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.planned_oil[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].planned_oil[1][1] }}
                    </span>
                  </td>

                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].planned_liq[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].planned_liq[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].planned_liq[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.planned_liq[0] != null">{{
                      Math.round(row.planned_liq[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].planned_liq[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].planned_liq[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].planned_liq[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].planned_liq[1][0]
                      )}`"
                    >
                    </span>
                    <input
                      class="input_edit"
                      @change="editrow(row, row_index)"
                      v-model="row.planned_liq[0]"
                      :disabled="!edit"
                    />
                    <!-- <span>{{Math.round(row.APV_t_rab[0]*10)/10}}</span> -->
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].planned_liq[1][1] }}
                    </span>
                  </td>

                  <td v-if="!edit">{{ Math.round(row.planned_gas*10)/10 }}</td>
                  <td v-if="edit">{{ Math.round(row.planned_gas*10)/10 }}</td>

                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].planned_wct[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].planned_wct[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].planned_wct[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.planned_wct[0] != null">{{
                      Math.round(row.planned_wct[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].planned_wct[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].planned_wct[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].planned_wct[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].planned_wct[1][0]
                      )}`"
                    >
                    </span>
                    <input
                      class="input_edit"
                      @change="editrow(row, row_index)"
                      v-model="row.planned_wct[0]"
                      :disabled="!edit"
                    />
                    <!-- <span>{{Math.round(row.APV_t_rab[0]*10)/10}}</span> -->
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].planned_wct[1][1] }}
                    </span>
                  </td>

                  <td v-if="!edit">{{Math.round(row.planned_gor*10)/10}}</td>
                  <td v-if="edit"><input :value="row.planned_gor" @change="editrow(row)" :disabled="!edit" class="input_edit"></td>

                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].planned_month_days[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].planned_month_days[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].planned_month_days[1][0]
                      )}`"
                    >
                    </span>
                    <span>{{ row.planned_month_days[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].planned_month_days[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].planned_month_days[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].planned_month_days[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].planned_month_days[1][0]
                      )}`"
                    >
                    </span>
                    <input
                      class="input_edit"
                      @change="editrow(row, row_index)"
                      v-model="row.planned_month_days[0]"
                      :disabled="!edit"
                    />
                    <!-- <span>{{Math.round(row.APV_t_rab[0]*10)/10}}</span> -->
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].planned_month_days[1][1] }}
                    </span>
                  </td>

                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].planned_monthly_oil[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].planned_monthly_oil[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].planned_monthly_oil[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.planned_monthly_oil[0] != null">{{
                      Math.round(row.planned_monthly_oil[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].planned_monthly_oil[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].planned_monthly_oil[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].planned_monthly_oil[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].planned_monthly_oil[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.planned_monthly_oil[0]" :disabled="!edit"> -->
                    <span>{{
                      Math.round(row.planned_monthly_oil[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].planned_monthly_oil[1][1] }}
                    </span>
                  </td>

                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].planned_monthly_gas[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].planned_monthly_gas[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].planned_monthly_gas[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.planned_monthly_gas[0] != null">{{
                      Math.round(row.planned_monthly_gas[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].planned_monthly_gas[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].planned_monthly_gas[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].planned_monthly_gas[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].planned_monthly_gas[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.planned_monthly_gas[0]" :disabled="!edit"> -->
                    <span>{{
                      Math.round(row.planned_monthly_gas[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].planned_monthly_gas[1][1] }}
                    </span>
                  </td>

                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].planned_monthly_liq[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].planned_monthly_liq[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].planned_monthly_liq[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.planned_monthly_liq[0] != null">{{
                      Math.round(row.planned_monthly_liq[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].planned_monthly_liq[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].planned_monthly_liq[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].planned_monthly_liq[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].planned_monthly_liq[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.planned_monthly_liq[0]" :disabled="!edit"> -->
                    <span>{{
                      Math.round(row.planned_monthly_liq[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].planned_monthly_liq[1][1] }}
                    </span>
                  </td>

                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].planned_monthly_water[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].planned_monthly_water[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].planned_monthly_water[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.planned_monthly_water[0] != null">{{
                      Math.round(row.planned_monthly_water[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].planned_monthly_water[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].planned_monthly_water[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].planned_monthly_water[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].planned_monthly_water[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.planned_monthly_water[0]" :disabled="!edit"> -->
                    <span>{{
                      Math.round(row.planned_monthly_water[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].planned_monthly_water[1][1] }}
                    </span>
                  </td>

                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].planned_diff_oil[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].planned_diff_oil[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].planned_diff_oil[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.planned_diff_oil[0] != null">{{
                      Math.round(row.planned_diff_oil[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].planned_diff_oil[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].planned_diff_oil[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].planned_diff_oil[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].planned_diff_oil[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.planned_diff_oil[0]" :disabled="!edit"> -->
                    <span>{{
                      Math.round(row.planned_diff_oil[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].planned_diff_oil[1][1] }}
                    </span>
                  </td>

                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].planned_diff_liq[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].planned_diff_liq[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].planned_diff_liq[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.planned_diff_liq[0] != null">{{
                      Math.round(row.planned_diff_liq[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].planned_diff_liq[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].planned_diff_liq[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].planned_diff_liq[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].planned_diff_liq[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.planned_diff_liq[0]" :disabled="!edit"> -->
                    <span>{{
                      Math.round(row.planned_diff_liq[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].planned_diff_liq[1][1] }}
                    </span>
                  </td>

                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].planned_events[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].planned_events[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].planned_events[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.planned_events[0] != null">{{
                      row.planned_events[0]
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].planned_events[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].planned_events[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].planned_events[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].planned_events[1][0]
                      )}`"
                    >
                    </span>
                    <input
                      class="input_edit"
                      @change="editrow(row, row_index)"
                      v-model="row.planned_events[0]"
                      :disabled="!edit"
                    />
                    <!-- <span>{{Math.round(row.APV_t_rab[0]*10)/10}}</span> -->
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].planned_events[1][1] }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import NotifyPlugin from "vue-easy-notify";
import "vue-easy-notify/dist/vue-easy-notify.css";
import TrTable from "./table";
import TrFullTable from "./tablefull";
import SearchFormRefresh from "../ui-kit/SearchFormRefresh.vue";
// import FadeLoader from "vue-spinner/src/FadeLoader.vue";
import { fields } from "./constants.js";
import TrMultiselect from "./TrMultiselect.vue";

Vue.use(NotifyPlugin);
export default {
  name: "TrPage",
  components: {
    TrTable,
    TrFullTable,
    SearchFormRefresh,
    TrMultiselect,
    // FadeLoader,
  },
  computed: {
    // Добавление выбранных данных в таблицу
    addWellData() {
      if (this.allWells && this.allWells.length > 0) {
        let is_saved = this.Filter_status;
        let field = this.Filter_field;
        let rus_wellname = this.Filter_well;
        let type_text = this.Filter_well_type;
        let well_status_last_day = this.Filter_well_status;
        try {
          let filteredResult = this.allWells.filter(
            (row) =>
              (!is_saved || row.is_saved === is_saved) &&
              (!field || row.field === field) &&
              (!rus_wellname || row.rus_wellname === rus_wellname) &&
              (!type_text || row.type_text === type_text) &&
              (!well_status_last_day || row.well_status_last_day === well_status_last_day)
          );
          this.filteredWellData = filteredResult;
          console.log("filteredResult bat = ", filteredResult);
        } catch (err) {
          console.error(err);
          return false;
        }
        if(this.filteredWellData.length === 1){
          this.lonelywell = this.filteredWellData;
        }
        else return false;
      } else return false;
      this.render++;
    },
    // фильтр месторожд.
    fieldFilters() {
      if (this.allWells && this.allWells.length > 0) {
        let filters = [];
        this.allWells.forEach((el) => {
          if (
            filters.indexOf(el.field) === -1 &&
            (!this.Filter_well || el.rus_wellname === this.Filter_well) &&
            (!this.Filter_well_status || el.well_status_last_day === this.Filter_well_status) &&
            (!this.Filter_status || el.is_saved === this.Filter_status) &&
            (!this.Filter_well_type || el.type_text === this.Filter_well_type)
          ) {
            filters = [...filters, el.field];
          }
        });
        return [undefined, ...filters];
      } else return [];
    },
    // фильтр по скважинам
    wellFilters() {
      if (this.allWells && this.allWells.length > 0) {
        let filters = [];
        this.allWells.forEach((el) => {
          if (
            filters.indexOf(el.rus_wellname) === -1 &&
            (!this.Filter_field || el.field === this.Filter_field) &&
            (!this.Filter_well_status || el.well_status_last_day === this.Filter_well_status) &&
            (!this.Filter_status || el.is_saved === this.Filter_status) &&
            (!this.Filter_well_type || el.type_text === this.Filter_well_type)
          ) {
            filters = [...filters, el.rus_wellname];
          }
        });
        return [undefined, ...filters];
      } else return [];
    },
    // фильтр по сост.скв
    wellStatusFilters() {
      if (this.allWells && this.allWells.length > 0) {
        let filters = [];
        this.allWells.forEach((el) => {
          if (
            filters.indexOf(el.well_status_last_day) === -1 &&
            (!this.Filter_field || el.field === this.Filter_field) &&
            (!this.Filter_well || el.rus_wellname === this.Filter_well) &&
            (!this.Filter_status || el.is_saved === this.Filter_status) &&
            (!this.Filter_well_type || el.type_text === this.Filter_well_type)
          ) {
            filters = [...filters, el.well_status_last_day];
          }
        });
        return [undefined, ...filters];
      } else return [];
    },
    // фильтр по статусам (сохраненные или не сохраненные)
    statusFilters() {
      if (this.allWells && this.allWells.length > 0) {
        let filters = [];
        this.allWells.forEach((el) => {
          if (
            filters.indexOf(el.is_saved) === -1 &&
            (!this.Filter_field || el.field === this.Filter_field) &&
            (!this.Filter_well || el.rus_wellname === this.Filter_well)  &&
            (!this.Filter_well_status || el.well_status_last_day === this.Filter_well_status) &&
            (!this.Filter_well_type || el.type_text === this.Filter_well_type)
          ) {
            filters = [...filters, el.is_saved];
          }
        });
        return [undefined, ...filters];
      } else return [];
    },
    typeWellFilters() {
      if (this.allWells && this.allWells.length > 0) {
        let filters = [];
        this.allWells.forEach((el) => {
          if (
            filters.indexOf(el.type_text) === -1 &&
            (!this.Filter_field || el.field === this.Filter_field) &&
            (!this.Filter_well || el.rus_wellname === this.Filter_well)  &&
            (!this.Filter_well_status || el.well_status_last_day === this.Filter_well_status) &&
            (!this.Filter_status || el.is_saved === this.Filter_status)
          ) {
            filters = [...filters, el.type_text];
          }
        });
        return [undefined, ...filters];
      } else return [];
    },          
  },
  beforeCreate: function () {},
  created() {
    this.$store.commit("globalloading/SET_LOADING", true);
    this.$store.commit("tr/SET_SORTPARAM", this.sortParam);
    this.$store.commit("tr/SET_SEARCH", this.searchString);
    this.$store.commit("tr/SET_FILTER", this.filter);
    var today = new Date();
    var mm = today.getMonth() + 1;
    var yyyy = today.getFullYear();
    var day = today.getDate();
    if(day > 25 && mm < 12) {
      var mm1 = today.getMonth() + 2;
      var yyyy1 = today.getFullYear();
    }
    else if(day > 25 && mm === 12){
      var mm1 = 1;
      var yyyy1 = today.getFullYear() + 1;
    }
    else{
      var mm1 = today.getMonth() + 1;
      var yyyy1 = today.getFullYear();
    }
    this.$store.commit("tr/SET_MONTH", mm);
    this.$store.commit("tr/SET_YEAR", yyyy);
    this.axios
      .get("http://172.20.103.187:7576/api/techregime/" + yyyy + "/" + mm + "/")
      .then((response) => {
        let data = response.data;
        this.year = yyyy;
        this.selectYear = yyyy;
        this.month = mm;
        this.$store.commit("globalloading/SET_LOADING", false);
        // this.isloading = false;
        if (data) {
          console.log(data);
          this.wells = data.data;
          this.fullWells = data.data;
        } else {
          console.log("No data");
          
        }
        if (mm1 < 10) {
          this.dt = "01" + ".0" + mm1 + "." + yyyy1;
        } else {
          this.dt = "01" + "." + mm1 + "." + yyyy1;
        }
      });
  },
  data: function () {
    return {
      wells: [],
      searchString: "",
      searched: false,
      sortParam: "",
      sortType: "asc",
      // filter: "Все месторождения",
      filter: [...fields],
      fieldFilterOptions: [
        {
          group: this.trans('tr.traw'),
          fields: [...fields],
        },
      ],
      dt: null,
      fullWells: [],
      editedWells: [],
      show_first: true,
      show_second: false,
      show_add: false,
      edit: false,
      editdtm: null,
      editdty: null,
      // sortField: null,
      // currentSortDir: 'asc',
      year: null,
      selectYear: null,
      month: null,
      // isloading: true,
      isfulltable: false,
      Filter_field: undefined,
      allWells: [],
      awells: [],
      Filter_well_status: undefined,
      Filter_status: undefined,
      Filter_well_type: undefined,
      filteredWellData: [],
      lonelywell: [],
      render: 0,
      searchStringModel: "",
      Filter_well: undefined,
    };
  },
  watch: {
    fullWells() {
      this.chooseField();
    },
    filter() {
      this.chooseField();
    },
  },
  methods: {
    editrow(row, rowId) {
      console.log("row = ", row);
      console.log("rowId = ", rowId);
      row["index"] = 0;
      this.axios
        .post(
          "http://172.20.103.187:7576/api/techregime/edit/" +
            this.year +
            "/" +
            this.month +
            "/",
          {
            row: row,
          }
        )
        .then((response) => {
          if (response.data) {
            // console.log('EDIT_RESPONSE', response.data.data[0])
            // this.wells = this.wells.map((currentRow, index) => {
            //   // console.log('norm', index, rowId)
            //   return index === rowId ? response.data.data[0] :   currentRow;
            // });

            this.wells = [
              ...this.wells.slice(0, rowId),
              response.data.data[0],
              ...this.wells.slice(rowId + 1),
            ];
            this.editedWells = this.editedWells.filter(
              (item) => item.well !== response.data.data[0].well
            );
            this.editedWells = [...this.editedWells, response.data.data[0]];
          } else {
            console.log("No data");
          }
        });
    },
    savetable() {
      this.edit = false;
      this.$store.commit("globalloading/SET_LOADING", true);
      // this.isloading = true;
      const searchParam = this.searchString ? `${this.searchString}/` : "";
      this.axios
        .post(
          "http://172.20.103.187:7576/api/techregime/save/" +
            this.year +
            "/" +
            this.month +
            "/" +
            searchParam,
          {
            well: this.editedWells,
          }
        )
        .then((response) => {
          console.log(response.data);
          this.fullWells = response.data;
          this.editedWells = [];
          this.$store.commit("globalloading/SET_LOADING", false);
          // this.isloading = false;
          this.searched = searchParam ? true : false;
        })
        .catch((error) => {
          console.log(error.data);
          this.editedWells = [];
          this.searchWell();
          this.searched = searchParam ? true : false;
        });
    },
    cancelEdit() {
      this.edit = false;
      this.editedWells = [];
      this.searchWell();
    },
    cancelPP() {
      this.edit = false;

    },
    reRender() {
      this.filteredWellData = [];
      this.Filter_well_status = undefined;
      this.Filter_status = undefined;
      this.Filter_well_type = undefined;
      this.Filter_well = undefined;
      this.Filter_field = undefined;
      
    },
    reRenderAll() {
      this.$store.commit("globalloading/SET_LOADING", true);
      var today = new Date();
      var mm = today.getMonth() + 1;
      var yyyy = today.getFullYear();
      var day = today.getDate();
      if(day > 25 && mm < 12) {
        var mm1 = today.getMonth() + 2;
        var yyyy1 = today.getFullYear();
      }
      else if(day > 25 && mm === 12){
        var mm1 = 1;
        var yyyy1 = today.getFullYear() + 1;
      }
      else{
        var mm1 = today.getMonth() + 1;
        var yyyy1 = today.getFullYear();
      }

      this.axios
        .get("http://172.20.103.187:7576/api/techregime/" + yyyy + "/" + mm + "/")
        .then((response) => {
          let data = response.data;

          this.$store.commit("globalloading/SET_LOADING", false);
          // this.isloading = false;
          if (data) {
            console.log(data);
            this.wells = data.data;
            this.fullWells = data.data;
          } else {
            console.log("No data");
            
          }

        });
    },
    showWells() {
      if(this.lonelywell.length === 1){
        this.show_add = !this.show_add;
      }
      else{
        this.show_add = this.show_add;
      }
    },
    editable() {
      this.edit = true;
      this.show_second = true;
      this.show_first = false;
    },
    searchadd() {
      this.$emit();
    },
    clearClickadd() {
      this.searchStringModel= "";
      this.$emit();
      this.searchadd();
    },
    sortBy(type) {
      this.sortParam = type;
      this.$store.commit("tr/SET_SORTTYPE", this.sortType);
      this.$store.commit("tr/SET_SORTPARAM", type);
      let { wells, sortType } = this;
      console.log(type, sortType);
      if (sortType === "asc") {
        this.wells = wells.sort((a, b) => {
          let aVal = a[type];
          let bVal = b[type];
          if (Array.isArray(aVal)) {
            if (typeof aVal[0] === "string") {
              return aVal[0].localeCompare(bVal[0]);
            } else {
              if (Number(aVal[0]) > Number(bVal[0])) return 1;
              else if (Number(aVal[0]) < Number(bVal[0])) return -1;
              else return 0;
            }
          } else {
            if (typeof aVal === "string") {
              return aVal.localeCompare(bVal);
            } else {
              if (Number(aVal) > Number(bVal)) return 1;
              else if (Number(aVal) < Number(bVal)) return -1;
              else return 0;
            }
          }
        });
        this.sortType = "desc";
      } else {
        this.wells = wells.sort((a, b) => {
          let aVal = a[type];
          let bVal = b[type];
          if (Array.isArray(aVal)) {
            if (typeof aVal[0] === "string" && isNaN(Number(aVal[0]))) {
              return bVal[0].localeCompare(aVal[0]);
            } else {
              if (Number(aVal[0]) > Number(bVal[0])) return -1;
              else if (Number(aVal[0]) < Number(bVal[0])) return 1;
              else return 0;
            }
          } else {
            if (typeof aVal === "string" && isNaN(Number(aVal))) {
              return aVal.localeCompare(bVal);
            } else {
              if (Number(aVal) > Number(bVal)) return -1;
              else if (Number(aVal) < Number(bVal)) return 1;
              else return 0;
            }
          }
        });
        this.sortType = "asc";
      }
    },
    onChangeMonth(event) {
      this.$store.commit("tr/SET_MONTH", event.target.value);
    },
    onChangeYear(event) {
      this.year = event.target.value;
      this.$store.commit("tr/SET_YEAR", event.target.value);
    },

    chooseDt() {
      this.$store.commit("globalloading/SET_LOADING", true);
      // this.isloading = true;
      this.axios
        .get(
          "http://172.20.103.187:7576/api/techregime/" +
            this.selectYear +
            "/" +
            this.month +
            "/"
        )
        .then((response) => {
          this.$store.commit("globalloading/SET_LOADING", false);
          // this.isloading = false;
          let data = response.data;
          if (data) {
            this.searched = false;
            this.$store.commit("tr/SET_SORTPARAM", "");
            this.$store.commit("tr/SET_SEARCH", "");
            this.sortParam = "";
            this.searchString = "";
            console.log(data);
            // this.wells = data.data;
            this.fullWells = data.data;
          } else {
            console.log("No data");
          }
          if (this.month < 10) {
            this.dt = "01" + ".0" + this.month + "." + this.selectYear;
          } else {
            this.dt = "01" + "." + this.month + "." + this.selectYear;
          }
        });
    },

    wellAdd() {
      this.$store.commit("globalloading/SET_LOADING", true);
      // this.isloading = true;
      this.axios
        .get(
          "http://172.20.103.187:7576/api/techregime/new_wells/" 
        )
        .then((response) => {
          this.$store.commit("globalloading/SET_LOADING", false);
          // this.isloading = false;
          let data = response.data;
          if (data) {
            this.searched = false;
            this.$store.commit("tr/SET_SORTPARAM", "");
            this.$store.commit("tr/SET_SEARCH", "");
            this.sortParam = "";
            this.searchString = "";
            console.log(data);
            // this.wells = data.data;
            this.allWells = data.data;
            
          } else {
            console.log("No data");
          }
          
        });
    },
    // chooseField() {
    //   const { filter, fullWells } = this;
    //   console.log(filter);
    //   console.log(fullWells);
    //   // if (!filter || filter == "Казгермунай") {
    //   this.$store.commit("tr/SET_FILTER", filter);
    //   if (!filter || filter == "Все месторождения") {
    //     this.wells = fullWells;
    //   } else {
    //     this.wells = fullWells.filter((e) => e.field === filter);
    //   }
    // },
    chooseField() {
      const { filter, fullWells } = this;
      console.log("filter = ", filter);
      console.log(fullWells);
      // if (!filter || filter == "Казгермунай") {
      this.$store.commit("tr/SET_FILTER", filter);
      if (!filter) {
        this.wells = fullWells;
      } else {
        this.wells = fullWells.filter((e) => filter.indexOf(e.field) !== -1);
      }
    },
    swap() {
      this.show_first = !this.show_first;
      this.show_second = !this.show_second;
      this.isfulltable = !this.isfulltable;
    },

    getColor(status) {
      if (status === "1") return "#ffff00";
      return "#ff0000";
    },
    addpush(){
        
        this.$modal.show('add_well')
    },

    handlerSearch(search) {
      this.searchString = search;
    },
    handlerFilter(filter) {
      this.filter = filter;
    },
    // Отправка данных с модалки в бэк
    saveadd() {
      console.log(this.$refs.editTable);
      Vue.prototype.$notifySuccess (`Скважина ${this.lonelywell[0].rus_wellname} сохранена`);
      //this.$refs.saveTable
      let output = {}
      console.log(this.$refs.editTable[0].children);
      console.log(this.$refs.editTable[0].children[0].children[0].dataset.key);
      console.log(this.$refs.editTable[0].children[0].children[0].value);
      this.$refs.editTable[0].children.forEach((el) => {
        output[el.children[0].dataset.key] = el.children[0].value;
      });
      console.log(output)
      this.axios
        .post(
          "http://172.20.103.187:7576/api/techregime/new_wells/add_well/", 
          output).then((res) => {
            console.log(res.data)
            this.wellAdd();
            this.reRenderAll();
          })

    },
    // Удаление с модалки
    deleteWell() {
      Vue.prototype.$notifyError (`Скважина ${this.lonelywell[0].rus_wellname} удалена`);
      this.$store.commit("globalloading/SET_LOADING", true);
      if(this.lonelywell.length === 1 && this.lonelywell[0].is_saved === "Сохранено"){
        this.axios
          .get(
            "http://172.20.103.187:7576/api/techregime/new_wells/delete_well/" + 
            this.lonelywell[0].well).then((res) => {
              console.log(res.data)
              this.wellAdd();
              this.reRenderAll();
            })
      }
      else{
        return console.log("error")
      }
    },
    searchWell() {
      console.log("search = ", this.searchString);
      this.$store.commit("tr/SET_SORTPARAM", "");
      this.sortParam = "";
      this.$store.commit("globalloading/SET_LOADING", true);
      // this.isloading = true;
      const searchParam = this.searchString
        ? `search/${this.searchString}/`
        : "";
      this.axios
        .get(
          "http://172.20.103.187:7576/api/techregime/" +
            this.selectYear +
            "/" +
            this.month +
            "/" +
            searchParam
        )
        .then((response) => {
          this.$store.commit("globalloading/SET_LOADING", false);
          // this.isloading = false;
          this.searched = searchParam ? true : false;
          this.$store.commit("tr/SET_SEARCH", this.searchString);
          let data = response.data;
          if (data) {
            console.log(data);
            // this.wells = data.data;
            this.fullWells = data.data;
          } else {
            // this.wells = [];
            this.fullWells = [];
            console.log("No data");
          }
        })
        .catch((error) => {
          // this.wells = [];
          this.searched = searchParam ? true : false;
          this.$store.commit("globalloading/SET_LOADING", false);
          // this.isloading = false;
          this.fullWells = [];
          console.log("search error = ", error);
        });
    },
  },
};
</script>
<style scoped>
/* @import "element-variables"; */
body {
  color: white !important;
}
#app .multiselect {
  max-width: 300px;
}
.form-control,
.fix-rounded-right {
  background: #272953 !important;
  border: 1px solid #656a8a !important;
  height: 35px !important;
  color: white !important;
}
.input-group-text {
  background: #656a8a !important;
  color: white !important;
  border-radius: 6px !important;
  border: none !important;
  position: absolute !important;
  right: 0 !important;
  z-index: 9999;
  font-size: 14px;
  margin-right: 2px;
}
.input-group-prepend {
  padding-top: 3px !important;
  /* margin-right: 0px!important; */
}
a:hover {
  color: white !important;
  text-decoration: none !important;
}
.maintable {
  padding: 0;
}
.maintable-level2 {
  background: #272953;
}

.trdropdown {
  padding: 3;
  background: transparent;
}

.trbutnav {
  background-color: #20274e;
  border-color: #20274e;
  color: white;
}
.bttr1 {
  background: #272953;
  color: white;
  margin-left: 1000px;
  border: none;
}
.techbt1 {
  display: flex;
}
.trheadercolumn {
  background: #333975;
}
.trsubheadercolumn {
  background: #333975;
}
tr:nth-child(odd) {
  background-color: #454d7d;
}
tr:nth-child(even) {
  background-color: #454d7d73;
}
.table th,
.table td {
  padding: 5px !important;
}
.trtable {
  font-size: 9px;
  padding: unset;
}

.trcolmd12 {
  margin: 0;
  padding: 0;
  margin-bottom: 13px;
}
.fadee {
  flex: 0 1 auto;
  flex-flow: row wrap;
  width: 100%;
  align-items: center;
  position: absolute;
  height: 100%;
  justify-content: center;
  display: flex;
  z-index: 5000;
  background: rgba(59, 46, 247, 0.1);
}
.trtable {
  height: 600;
}
.trcol {
  padding-right: 0;
}

.trgraph {
  margin: 0 10px;
  background: #272953;
}

.sticky {
  position: sticky;
  top: 0;
  min-height: 2em;
  background: lightpink;
}
.table {
  overflow: scroll;
  height: calc(100vh - 205px);
}
.trkrtableborderedtabledarktableresponsive {
  font-size: 9px;
  padding: unset;
}
.butcancel.butcancel {
  flex-grow: 0;
  width: 200px;
}

.table .th {
  position: sticky;
  background: rgb(51, 57, 117);
}
.table tr:first-child .th {
  top: -1px;
  z-index: 3000;
}
.table tr:nth-child(2) .th {
  top: 24px;
  z-index: 3000;
}
.table tr:nth-child(3) .th {
  top: 49px;
  z-index: 3000;
}
.table tr:nth-child(4) .th {
  top: 80px;
  z-index: 3000;
}
.table tr:nth-child(5) .th {
  top: 97px;
  z-index: 3000;
}
tr td:first-child {
  color: #fff;
  position: sticky;
  left: 0;
  width: 100px;
}
.table-outer {
  position: relative;
}
.table-inner {
  overflow-y: visible;
}
tr:not(.notsticky) td:nth-child(-n + 3) {
  position: sticky;
  left: -1px;
  width: 27px;
  z-index: 3009;
}
tr:not(.notsticky) td:nth-child(2) {
  left: 23px;
  width: 100px;
}
tr:not(.notsticky) td:nth-child(3) {
  left: 121px;
  width: 55;
}

tr:nth-child(odd) td {
  background-color: #454d7d;
}
tr:nth-child(even) td {
  background-color: #26336f;
}

.table.table tr:not(.notsticky) .th:nth-child(-n + 3) {
  z-index: 3010;
}

.input_edit {
  background: #7879a6;
}

/* width */
table::-webkit-scrollbar {
  width: 13px;
}

/* Track */
table::-webkit-scrollbar-track {
  background: #333975;
}

/* Handle */
table::-webkit-scrollbar-thumb {
  background: #656A8A;
  
}

/* Handle on hover */
table::-webkit-scrollbar-thumb:hover {
  background: #656A8A;
  
}

table::-webkit-scrollbar-corner {
  background: #333975;
}
.modalcont {
  background: #272953;
}
.modalselect {
  background: #334296;
  color: #fff;
}

</style>
<style>
.tr-field-filter.tr-field-filter {
  margin: 0 0 0 auto;
  flex-grow: 0;
  width: 230px;
}
.tr-table-header {
  justify-content: space-between;
  height: 48px;
  align-items: center;
}
.trheadhight {
  height: 40px;
}
.fadropmenu.fadropmenu {
  background: #333975;
  /* width: 246px; */
  z-index: 4001 !important;
}
.faheadhight {
  height: 40px;
}

.button_form.button_form {
  background: #333975;
  border: 0px;
  color: #fff;
  align-self: center;
  width: 150px;
  margin-top: 5px;
}
.dropdown-menu.show {
  display: flex;
  flex-direction: column;
}

.header_mod {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: justify;
    -webkit-justify-content: space-between;
    -ms-flex-pack: justify;
    justify-content: space-between;
    padding: 15px;
}
.select_mod.select_mod.select_mod.select_mod {
     background: #334296; 
}
</style>