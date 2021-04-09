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
                        <button type="button" class="modal-bign-button" @click="closeModal('add_well')">Закрыть</button>

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
                                @click="showWells"
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
                              v-show = checkers
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
                              v-show = checkersec

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
                        <td><input data-key="dens_liq" :value="row.dens_liq" class="input_edit"></td>
                        <td><input data-key="h_perf" :value="row.h_perf" class="input_edit"></td>
                        <td><input data-key="bhp_meter" :value="row.bhp_meter" class="input_edit"></td>
                        <td v-show="false"><input data-key="well" :value="row.well" class="input_edit"></td>

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
          <div class="table-inner abat_tr">
                  <el-table
                    :data="wells"
                    height="calc(100vh - 205px)"
                    style="width: 100%"
                    :header-cell-class-name="getHeaderCellClassName"
                    >
                    <el-table-column 
                   
                      :label="trans('tr.ngdu_field')" 
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="field"
                            label=""
                            width="200"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.well_number')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="rus_wellname"
                            label=""
                            width="150"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.well_type')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="well_type"
                            label=""
                            width="150"
                            sortable
                            >
                            <template slot-scope="scope">
                              <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`well_type`)}" >
                                        <span
                                          :class="{
                                            'circle-err': isCircleErrClass(scope.$index,`well_type`)}"
                                          :style="`background :${getColor(
                                            wells[scope.$index].well_type[1][0]
                                          )}`"
                                        >
                                        </span><span>{{ scope.row.well_type[0] }}</span>
                                <span v-if="wells && wells[scope.$index]" class="cell-comment-tech">
                                  {{ wells[scope.$index].well_type[1][1] }}
                                </span>
                              </div>
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.horizon')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="horizon"
                            label=""
                            width="100"
                            sortable
                            >
                            <template slot-scope="scope">
                              <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`horizon`)}" >
                                        <span
                                          :class="{
                                            'circle-err': isCircleErrClass(scope.$index,`horizon`)}"
                                          :style="`background :${getColor(
                                            wells[scope.$index].horizon[1][0]
                                          )}`"
                                        >
                                        </span><span>{{ scope.row.horizon[0] }}</span>
                                <span v-if="wells && wells[scope.$index]" class="cell-comment-tech">
                                  {{ wells[scope.$index].horizon[1][1] }}
                                </span>
                              </div>
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.object')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="object"
                            label=""
                            width="150"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.block')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="block"
                            label=""
                            width="150"
                            sortable
                            >
                            <template slot-scope="scope">
                              <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`block`)}" >
                                        <span
                                          :class="{
                                            'circle-err': isCircleErrClass(scope.$index,`block`)}"
                                          :style="`background :${getColor(
                                            wells[scope.$index].block[1][0]
                                          )}`"
                                        >
                                        </span><span>{{ scope.row.block[0] }}</span>
                                <span v-if="wells && wells[scope.$index]" class="cell-comment-tech">
                                  {{ wells[scope.$index].block[1][1] }}
                                </span>
                              </div>
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>

                    <el-table-column
                      :label="trans('tr.r_feed_loop')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="r_con"
                            label=""
                            width="150"
                            sortable
                            >
                           <template slot-scope="scope">
                              <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`r_con`)}" >
                                        <span
                                          :class="{
                                            'circle-err': isCircleErrClass(scope.$index,`r_con`)}"
                                          :style="`background :${getColor(
                                            wells[scope.$index].r_con[1][0]
                                          )}`"
                                        >
                                          </span><span v-if="scope.row.r_con[0] != null">{{
                                    Math.round(scope.row.r_con[0] * 10) / 10
                                  }}</span>
                                  <span v-if="wells && wells[scope.$index]" class="cell-comment-tech">
                                    {{ wells[scope.$index].r_con[1][1] }}
                                  </span>
                              </div>    
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>

                    <el-table-column
                      :label="trans('tr.outer_diameter_producing_casing')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="cas_OD"
                            label=""
                            width="180"
                            sortable
                            >
                            <template slot-scope="scope">
                              <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`cas_OD`)}" >
                                        <span
                                          :class="{
                                            'circle-err': isCircleErrClass(scope.$index,`cas_OD`)}"
                                          :style="`background :${getColor(
                                            wells[scope.$index].cas_OD[1][0]
                                          )}`"
                                        >
                                          </span><span v-if="scope.row.cas_OD[0] != null">{{
                                    Math.round(scope.row.cas_OD[0] * 10) / 10
                                  }}</span>
                                  <span v-if="wells && wells[scope.$index]" class="cell-comment-tech">
                                    {{ wells[scope.$index].cas_OD[1][1] }}
                                  </span>
                              </div>    
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>

                    <el-table-column
                      :label="trans('tr.inner_diameter_producing_casing')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="cas_ID"
                            label=""
                            width="180"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>

                    <el-table-column
                      :label="trans('tr.outer_diameter_nkt')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="tub_OD"
                            label=""
                            width="200"
                            sortable
                            >
                            <template slot-scope="scope">
                              <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`tub_OD`)}" >
                                        <span
                                          :class="{
                                            'circle-err': isCircleErrClass(scope.$index,`tub_OD`)}"
                                          :style="`background :${getColor(
                                            wells[scope.$index].tub_OD[1][0]
                                          )}`"
                                        >
                                          </span><span v-if="scope.row.tub_OD[0] != null">{{
                                    Math.round(scope.row.tub_OD[0] * 10) / 10
                                  }}</span>
                                  <span v-if="wells && wells[scope.$index]" class="cell-comment-tech">
                                    {{ wells[scope.$index].tub_OD[1][1] }}
                                  </span>
                              </div>    
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.inner_diameter_nkt')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="tub_ID"
                            label=""
                            width="200"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.choke_diameter')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="choke_d"
                            label=""
                            width="200"
                            sortable
                            >
                            <template slot-scope="scope">
                              <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`choke_d`)}" >
                                        <span
                                          :class="{
                                            'circle-err': isCircleErrClass(scope.$index,`choke_d`)}"
                                          :style="`background :${getColor(
                                            wells[scope.$index].choke_d[1][0]
                                          )}`"
                                        >
                                          </span><span v-if="scope.row.choke_d[0] != null">{{
                                    Math.round(scope.row.choke_d[0] * 10) / 10
                                  }}</span>
                                  <span v-if="wells && wells[scope.$index]" class="cell-comment-tech">
                                    {{ wells[scope.$index].choke_d[1][1] }}
                                  </span>
                              </div>    
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.h_water_permeability')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="h_up_perf_md"
                            label=""
                            width="200"
                            sortable
                            >
                            <template slot-scope="scope">
                              <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`h_up_perf_md`)}" >
                                        <span
                                          :class="{
                                            'circle-err': isCircleErrClass(scope.$index,`h_up_perf_md`)}"
                                          :style="`background :${getColor(
                                            wells[scope.$index].h_up_perf_md[1][0]
                                          )}`"
                                        >
                                          </span><span v-if="scope.row.h_up_perf_md[0] != null">{{
                                    Math.round(scope.row.h_up_perf_md[0] * 10) / 10
                                  }}</span>
                                  <span v-if="wells && wells[scope.$index]" class="cell-comment-tech">
                                    {{ wells[scope.$index].h_up_perf_md[1][1] }}
                                  </span>
                              </div>    
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.h_water_permeability_extension')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="h_up_perf_ext"
                            label=""
                            width="200"
                            sortable
                            >
                             <template slot-scope="scope">
                              <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`h_up_perf_ext`)}" >
                                        <span
                                          :class="{
                                            'circle-err': isCircleErrClass(scope.$index,`h_up_perf_ext`)}"
                                          :style="`background :${getColor(
                                            wells[scope.$index].h_up_perf_ext[1][0]
                                          )}`"
                                        >
                                          </span><span v-if="scope.row.h_up_perf_ext[0] != null">{{
                                    Math.round(scope.row.h_up_perf_ext[0] * 10) / 10
                                  }}</span>
                                  <span v-if="wells && wells[scope.$index]" class="cell-comment-tech">
                                    {{ wells[scope.$index].h_up_perf_ext[1][1] }}
                                  </span>
                              </div>    
                            </template>
                            
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.operation_method')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="exp_meth"
                            label=""
                            width="200"
                            sortable
                            >
                            <template slot-scope="scope">
                              <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`exp_meth`)}" >
                                        <span
                                          :class="{
                                            'circle-err': isCircleErrClass(scope.$index,`exp_meth`)}"
                                          :style="`background :${getColor(
                                            wells[scope.$index].exp_meth[1][0]
                                          )}`"
                                        >
                                        </span><span>{{ scope.row.exp_meth[0] }}</span>
                                <span v-if="wells && wells[scope.$index]" class="cell-comment-tech">
                                  {{ wells[scope.$index].exp_meth[1][1] }}
                                </span>
                              </div>
                            </template>
                            
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.pump_type')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="pump_type"
                            label=""
                            width="200"
                            sortable
                            >
                            <template slot-scope="scope">
                              <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`pump_type`)}" >
                                        <span
                                          :class="{
                                            'circle-err': isCircleErrClass(scope.$index,`pump_type`)}"
                                          :style="`background :${getColor(
                                            wells[scope.$index].pump_type[1][0]
                                          )}`"
                                        >
                                        </span><span>{{ scope.row.pump_type[0] }}</span>
                                <span v-if="wells && wells[scope.$index]" class="cell-comment-tech">
                                  {{ wells[scope.$index].pump_type[1][1] }}
                                </span>
                              </div>
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>

                    <el-table-column
                      :label="trans('tr.sk_type')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="type_sr"
                            label=""
                            width="200"
                            sortable
                            >
                            
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.swing_number')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="spm"
                            label=""
                            width="200"
                            sortable
                            >
                             <template slot-scope="scope">
                              <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`spm`)}" >
                                        <span
                                          :class="{
                                            'circle-err': isCircleErrClass(scope.$index,`spm`)}"
                                          :style="`background :${getColor(
                                            wells[scope.$index].spm[1][0]
                                          )}`"
                                        >
                                          </span><span v-if="scope.row.spm[0] != null">{{
                                    Math.round(scope.row.spm[0] * 10) / 10
                                  }}</span>
                                  <span v-if="wells && wells[scope.$index]" class="cell-comment-tech">
                                    {{ wells[scope.$index].h_up_perf_ext[1][1] }}
                                  </span>
                              </div>    
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.stroke_length')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="stroke_len"
                            label=""
                            width="200"
                            sortable
                            >
                             <template slot-scope="scope">
                              <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`stroke_len`)}" >
                                        <span
                                          :class="{
                                            'circle-err': isCircleErrClass(scope.$index,`stroke_len`)}"
                                          :style="`background :${getColor(
                                            wells[scope.$index].stroke_len[1][0]
                                          )}`"
                                        >
                                          </span><span v-if="scope.row.stroke_len[0] != null">{{
                                    Math.round(scope.row.stroke_len[0] * 10) / 10
                                  }}</span>
                                  <span v-if="wells && wells[scope.$index]" class="cell-comment-tech">
                                    {{ wells[scope.$index].stroke_len[1][1] }}
                                  </span>
                              </div>    
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.q_theor')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="q_theor"
                            label=""
                            width="200"
                            sortable
                            >
                            <template slot-scope="scope">
                              <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`q_theor`)}" >
                                        <span
                                          :class="{
                                            'circle-err': isCircleErrClass(scope.$index,`q_theor`)}"
                                          :style="`background :${getColor(
                                            wells[scope.$index].q_theor[1][0]
                                          )}`"
                                        >
                                          </span><span v-if="Math.round(scope.row.q_theor[0] * 10) / 10 != '0'">{{
                                          Math.round(scope.row.q_theor[0] * 10) / 10
                                        }}</span>
                                  <span v-if="wells && wells[scope.$index]" class="cell-comment-tech">
                                    {{ wells[scope.$index].q_theor[1][1] }}
                                  </span>
                              </div>    

                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.pump_frequency_or_speed')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="freq"
                            label=""
                            width="400"
                            sortable
                            >
                            <template slot-scope="scope">
                              <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`freq`)}" >
                                        <span
                                          :class="{
                                            'circle-err': isCircleErrClass(scope.$index,`freq`)}"
                                          :style="`background :${getColor(
                                            wells[scope.$index].freq[1][0]
                                          )}`"
                                        >
                                          </span><span v-if="scope.row.freq[0] != null">{{
                                    Math.round(scope.row.freq[0] * 10) / 10
                                  }}</span>
                                  <span v-if="wells && wells[scope.$index]" class="cell-comment-tech">
                                    {{ wells[scope.$index].freq[1][1] }}
                                  </span>
                              </div>    
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>



                    <el-table-column
                      :label="trans('tr.h_pump_set')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="h_pump_set"
                            label=""
                            width="200"
                            sortable
                            >
                            <template slot-scope="scope">
                              <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`h_pump_set`)}" >
                                        <span
                                          :class="{
                                            'circle-err': isCircleErrClass(scope.$index,`h_pump_set`)}"
                                          :style="`background :${getColor(
                                            wells[scope.$index].h_pump_set[1][0]
                                          )}`"
                                        >
                                          </span><span v-if="scope.row.h_pump_set[0] != null">{{
                                    Math.round(scope.row.h_pump_set[0] * 10) / 10
                                  }}</span>
                                  <span v-if="wells && wells[scope.$index]" class="cell-comment-tech">
                                    {{ wells[scope.$index].h_pump_set[1][1] }}
                                  </span>
                              </div>    
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.p_buffer')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="whp"
                            label=""
                            width="200"
                            sortable
                            >
                            <template slot-scope="scope">
                              <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`whp`)}" >
                                        <span
                                          :class="{
                                            'circle-err': isCircleErrClass(scope.$index,`whp`)}"
                                          :style="`background :${getColor(
                                            wells[scope.$index].whp[1][0]
                                          )}`"
                                        >
                                          </span><span v-if="scope.row.whp[0] != null">{{
                                    Math.round(scope.row.whp[0] * 10) / 10
                                  }}</span>
                                  <span v-if="wells && wells[scope.$index]" class="cell-comment-tech">
                                    {{ wells[scope.$index].whp[1][1] }}
                                  </span>
                              </div>    
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.p_linear')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="line_p"
                            label=""
                            width="200"
                            sortable
                            >
                            <template slot-scope="scope">
                              <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`line_p`)}" >
                                        <span
                                          :class="{
                                            'circle-err': isCircleErrClass(scope.$index,`line_p`)}"
                                          :style="`background :${getColor(
                                            wells[scope.$index].line_p[1][0]
                                          )}`"
                                        >
                                          </span><span v-if="scope.row.line_p[0] != null">{{
                                    Math.round(scope.row.line_p[0] * 10) / 10
                                  }}</span>
                                  <span v-if="wells && wells[scope.$index]" class="cell-comment-tech">
                                    {{ wells[scope.$index].line_p[1][1] }}
                                  </span>
                              </div>    
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.p_layer')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="p_res"
                            label=""
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`p_res`)}" >
                                        <span
                                          :class="{
                                            'circle-err': isCircleErrClass(scope.$index,`p_res`)}"
                                          :style="`background :${getColor(
                                            wells[scope.$index].p_res[1][0]
                                          )}`"
                                        >
                                          </span><span v-if="scope.row.p_res[0] != null">{{
                                    Math.round(scope.row.whp[0] * 10) / 10
                                  }}</span>
                                  <span v-if="wells && wells[scope.$index]" class="cell-comment-tech">
                                    {{ wells[scope.$index].p_res[1][1] }}
                                  </span>
                              </div>    
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.h_dynamic')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="h_dyn"
                            label=""
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`h_dyn`)}" >
                                        <span
                                          :class="{
                                            'circle-err': isCircleErrClass(scope.$index,`h_dyn`)}"
                                          :style="`background :${getColor(
                                            wells[scope.$index].h_dyn[1][0]
                                          )}`"
                                        >
                                          </span><span v-if="scope.row.h_dyn[0] != null">{{
                                    Math.round(scope.row.h_dyn[0] * 10) / 10
                                  }}</span>
                                  <span v-if="wells && wells[scope.$index]" class="cell-comment-tech">
                                    {{ wells[scope.$index].h_dyn[1][1] }}
                                  </span>
                              </div>    
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.annular_pressure')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="p_annular"
                            label=""
                            width="130"
                            sortable
                            >
                             <template slot-scope="scope">
                              <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`p_annular`)}" >
                                        <span
                                          :class="{
                                            'circle-err': isCircleErrClass(scope.$index,`p_annular`)}"
                                          :style="`background :${getColor(
                                            wells[scope.$index].p_annular[1][0]
                                          )}`"
                                        >
                                          </span><span v-if="scope.row.p_annular[0] != null">{{
                                    Math.round(scope.row.p_annular[0] * 10) / 10
                                  }}</span>
                                  <span v-if="wells && wells[scope.$index]" class="cell-comment-tech">
                                    {{ wells[scope.$index].p_annular[1][1] }}
                                  </span>
                              </div>    
                            </template>
                          </el-table-column>

                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.p_intake')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="p_intake"
                            label=""
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`p_intake`)}" >
                                        <span
                                          :class="{
                                            'circle-err': isCircleErrClass(scope.$index,`p_intake`)}"
                                          :style="`background :${getColor(
                                            wells[scope.$index].p_intake[1][0]
                                          )}`"
                                        >
                                          </span><span v-if="scope.row.p_intake[0] != null">{{
                                    Math.round(scope.row.p_intake[0] * 10) / 10
                                  }}</span>
                                  <span v-if="wells && wells[scope.$index]" class="cell-comment-tech">
                                    {{ wells[scope.$index].p_intake[1][1] }}
                                  </span>
                              </div>    
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>




                    <!-- Данные за предыдущий месяц -->
                    <el-table-column
                      :label="trans('tr.previous_month_data')"
                      >
                      <el-table-column label="" >
                        <el-table-column
                        :label="trans('tr.bottomhole_pressure')"
                        >

                          <el-table-column
                            prop="bhp_prev_m"
                            label=""
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`p_intake`)}" >
                                        <span
                                          :class="{
                                            'circle-err': isCircleErrClass(scope.$index,`p_intake`)}"
                                          :style="`background :${getColor(
                                            wells[scope.$index].p_intake[1][0]
                                          )}`"
                                        >
                                          </span><span v-if="scope.row.p_intake[0] != null">{{
                                    Math.round(scope.row.p_intake[0] * 10) / 10
                                  }}</span>
                                  <span v-if="wells && wells[scope.$index]" class="cell-comment-tech">
                                    {{ wells[scope.$index].p_intake[1][1] }}
                                  </span>
                              </div>    
                            </template>

                            
                          </el-table-column>
                        </el-table-column>
                        <el-table-column
                        :label="trans('tr.tr22')"
                        >
                          <el-table-column
                            prop="q_l_prev_m"
                            label=""
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                        <el-table-column
                        :label="trans('tr.tr23')"
                        >
                          <el-table-column
                            prop="wct_prev_m"
                            label=""
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                        <el-table-column
                        :label="trans('tr.trs57')"
                        >
                          <el-table-column
                            prop="h_dyn_prev_m"
                            label=""
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                        <el-table-column
                        :label="trans('tr.trs25')"
                        >
                          <el-table-column
                            prop="pi_prev_m"
                            label=""
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>


                    <!-- Фактический режим -->
                    <el-table-column
                      :label="trans('tr.tr17')"
                      >
                      <el-table-column label="" >
                        <el-table-column
                        :label="trans('tr.tr20')"
                        >
                          <el-table-column
                            prop="bhp"
                            label=""
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                                      <span
                                        :class="{
                                          'circle-err':
                                            wells &&
                                            wells[scope.$index] &&
                                            wells[scope.$index].bhp[1][0] !== '0',
                                        }"
                                        :style="`background :${getColor(
                                          wells[scope.$index].bhp[1][0]
                                        )}`"
                                      >
                                      </span><span v-if="scope.row.bhp[0] != null">{{
                                Math.round(scope.row.bhp[0] * 10) / 10
                              }}</span>
                              <span v-if="wells && wells[scope.$index]" class="cell-comment-tech">
                                {{ wells[scope.$index].bhp[1][1] }}
                              </span>
                            </template>
                          </el-table-column>
                        </el-table-column>
                        <el-table-column
                        :label="trans('tr.tr21')"
                        >
                          <el-table-column
                            prop="q_o"
                            label=""
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                        <el-table-column
                        :label="trans('tr.tr22')"
                        >
                          <el-table-column
                            prop="q_l"
                            label=""
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                        <el-table-column
                        :label="trans('tr.tr23')"
                        >
                          <el-table-column
                            prop="wct"
                            label=""
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                        <el-table-column
                        :label="trans('tr.tr24')"
                        >
                          <el-table-column
                            prop="gor"
                            label=""
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
          
                    <el-table-column
                      :label="trans('tr.tr25')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column 
                            prop="well_status_last_day"
                            width="130"
                            sortable>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>

                    <el-table-column :label="trans('tr.trs15')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="P_bubble_point"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.trs16')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="t_res"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.trs17')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="wht"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>

                    <!-- ГРП -->
                    <el-table-column :label="trans('tr.tr28')">
                      <el-table-column label="">
                        <el-table-column :label="trans('tr.trs59')">
                          <el-table-column
                            prop="grp_skin"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                        <el-table-column :label="trans('tr.trs60')">
                          <el-table-column
                            prop="grp_jd"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                        <el-table-column :label="trans('tr.trs61')">
                          <el-table-column
                            prop="grp_date"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                        <el-table-column label="Фирма">
                          <el-table-column
                            prop="grp_contractor"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.trs18')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="visc_oil_rc"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.trs19')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="visc_wat_rc"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.trs20')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="visc_liq_rc"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.trs21')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="bo"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.trs22')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="dens_oil"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.trs23')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="dens_liq"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.trs24')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="h_perf"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column label="k">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="k"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column label="KH">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="kh"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.trs25')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="pi"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <!-- Расчет технологического потенциала от ИДН -->
                    <el-table-column :label="trans('tr.tr18')">
                        <el-table-column :label="trans('tr.trs62')" prop="fake">
                          <el-table-column label="">
                            <el-table-column
                              prop="tp_idn_bhp"
                              width="130"
                              sortable
                              >
                            </el-table-column>
                          </el-table-column>
                        </el-table-column>
                        

                        <el-table-column :label="trans('tr.tr27')">
                            <el-table-column :label="trans('tr.tr22')">
                              <el-table-column
                                prop="tp_idn_liq"
                                width="130"
                                sortable
                                >
                              </el-table-column>
                            </el-table-column>
                             <el-table-column :label="trans('tr.trs78')">
                              <el-table-column
                                prop="tp_idn_liq_cas_d_corr"
                                width="130"
                                sortable
                                >
                              </el-table-column>
                            </el-table-column>

                            <el-table-column :label="trans('tr.tr21')">
                              <el-table-column
                                prop="tp_idn_oil"
                                width="130"
                                sortable
                                >
                              </el-table-column>
                            </el-table-column>
                            <el-table-column :label="trans('tr.tr32')">
                              <el-table-column
                                prop="tp_idn_oil_inc"
                                width="130"
                                sortable
                                >
                              </el-table-column>
                            </el-table-column>
                        </el-table-column>

                        <el-table-column :label="trans('tr.trs63')" prop="fake">
                          <el-table-column label="">
                              <el-table-column
                                prop="tp_idn_jd"
                                width="130"
                                sortable
                                >
                              </el-table-column>
                          </el-table-column>
                        </el-table-column>
                        <el-table-column label="Skin" prop="fake">
                          <el-table-column label="">
                              <el-table-column
                                prop="tp_idn_skin"
                                width="130"
                                sortable
                                >
                              </el-table-column>
                          </el-table-column>
                        </el-table-column>
                        <el-table-column :label="trans('tr.trs64')" prop="fake">
                          <el-table-column label="">
                              <el-table-column
                                prop="tp_idn_pi_after"
                                width="130"
                                sortable
                                >
                              </el-table-column>
                          </el-table-column>
                        </el-table-column>


                        <el-table-column :label="trans('tr.tr28')">
                          <el-table-column :label="trans('tr.tr22')">
                              <el-table-column
                                prop="tp_idn_grp_q_liq"
                                width="130"
                                sortable
                                >
                              </el-table-column>
                          </el-table-column>
                          <el-table-column :label="trans('tr.trs78')">
                              <el-table-column
                                prop="tp_idn_grp_q_liq_cas_d_corr"
                                width="130"
                                sortable
                                >
                              </el-table-column>
                          </el-table-column>
                          <el-table-column :label="trans('tr.tr21')">
                              <el-table-column
                                prop="tp_idn_grp_q_oil"
                                width="130"
                                sortable
                                >
                              </el-table-column>
                          </el-table-column>
                          <el-table-column :label="trans('tr.tr32')">
                              <el-table-column
                                prop="tp_idn_grp_q_oil_inc"
                                width="130"
                                sortable
                                >
                              </el-table-column>
                          </el-table-column>
                        </el-table-column>
                    </el-table-column>


                    <!-- Данные за предыдущий месяц -->
                    <el-table-column
                      :label="trans('tr.previous_month_data')"
                      >
                      <el-table-column label="" >
                        <el-table-column
                        :label="trans('tr.bottomhole_pressure')"
                        >

                          <el-table-column
                            prop="bhp_prev_m"
                            label=""
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`p_intake`)}" >
                                        <span
                                          :class="{
                                            'circle-err': isCircleErrClass(scope.$index,`p_intake`)}"
                                          :style="`background :${getColor(
                                            wells[scope.$index].p_intake[1][0]
                                          )}`"
                                        >
                                          </span><span v-if="scope.row.p_intake[0] != null">{{
                                    Math.round(scope.row.p_intake[0] * 10) / 10
                                  }}</span>
                                  <span v-if="wells && wells[scope.$index]" class="cell-comment-tech">
                                    {{ wells[scope.$index].p_intake[1][1] }}
                                  </span>
                              </div>    
                            </template>

                            
                          </el-table-column>
                        </el-table-column>
                        <el-table-column
                        :label="trans('tr.tr22')"
                        >
                          <el-table-column
                            prop="q_l_prev_m"
                            label=""
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                        <el-table-column
                        :label="trans('tr.tr23')"
                        >
                          <el-table-column
                            prop="wct_prev_m"
                            label=""
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                        <el-table-column
                        :label="trans('tr.trs57')"
                        >
                          <el-table-column
                            prop="h_dyn_prev_m"
                            label=""
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                        <el-table-column
                        :label="trans('tr.trs25')"
                        >
                          <el-table-column
                            prop="pi_prev_m"
                            label=""
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>


                    <!-- Фактический режим -->
                    <el-table-column
                      :label="trans('tr.tr17')"
                      >
                      <el-table-column label="" >
                        <el-table-column
                        :label="trans('tr.tr20')"
                        >
                          <el-table-column
                            prop="bhp"
                            label=""
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                                      <span
                                        :class="{
                                          'circle-err':
                                            wells &&
                                            wells[scope.$index] &&
                                            wells[scope.$index].bhp[1][0] !== '0',
                                        }"
                                        :style="`background :${getColor(
                                          wells[scope.$index].bhp[1][0]
                                        )}`"
                                      >
                                      </span><span v-if="scope.row.bhp[0] != null">{{
                                Math.round(scope.row.bhp[0] * 10) / 10
                              }}</span>
                              <span v-if="wells && wells[scope.$index]" class="cell-comment-tech">
                                {{ wells[scope.$index].bhp[1][1] }}
                              </span>
                            </template>
                          </el-table-column>
                        </el-table-column>
                        <el-table-column
                        :label="trans('tr.tr21')"
                        >
                          <el-table-column
                            prop="q_o"
                            label=""
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                        <el-table-column
                        :label="trans('tr.tr22')"
                        >
                          <el-table-column
                            prop="q_l"
                            label=""
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                        <el-table-column
                        :label="trans('tr.tr23')"
                        >
                          <el-table-column
                            prop="wct"
                            label=""
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                        <el-table-column
                        :label="trans('tr.tr24')"
                        >
                          <el-table-column
                            prop="gor"
                            label=""
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
          
                    <el-table-column
                      :label="trans('tr.tr25')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column 
                            prop="well_status_last_day"
                            width="130"
                            sortable>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>

                    <el-table-column :label="trans('tr.trs15')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="P_bubble_point"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.trs16')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="t_res"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.trs17')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="wht"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>

                    <!-- ГРП -->
                    <el-table-column :label="trans('tr.tr28')">
                      <el-table-column label="">
                        <el-table-column :label="trans('tr.trs59')">
                          <el-table-column
                            prop="grp_skin"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                        <el-table-column :label="trans('tr.trs60')">
                          <el-table-column
                            prop="grp_jd"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                        <el-table-column :label="trans('tr.trs61')">
                          <el-table-column
                            prop="grp_date"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                        <el-table-column label="Фирма">
                          <el-table-column
                            prop="grp_contractor"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.trs18')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="visc_oil_rc"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.trs19')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="visc_wat_rc"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.trs20')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="visc_liq_rc"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.trs21')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="bo"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.trs22')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="dens_oil"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.trs23')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="dens_liq"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.trs24')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="h_perf"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column label="k">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="k"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column label="KH">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="kh"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.trs25')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="pi"
                            width="130"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <!-- Расчет технологического потенциала от ИДН -->
                    <el-table-column :label="trans('tr.tr18')">
                        <el-table-column :label="trans('tr.trs62')" prop="fake">
                          <el-table-column label="">
                            <el-table-column
                              prop="tp_idn_bhp"
                              width="130"
                              sortable
                              >
                            </el-table-column>
                          </el-table-column>
                        </el-table-column>
                        

                        <el-table-column :label="trans('tr.tr27')">
                            <el-table-column :label="trans('tr.tr22')">
                              <el-table-column
                                prop="tp_idn_liq"
                                width="130"
                                sortable
                                >
                              </el-table-column>
                            </el-table-column>
                             <el-table-column :label="trans('tr.trs78')">
                              <el-table-column
                                prop="tp_idn_liq_cas_d_corr"
                                width="130"
                                sortable
                                >
                              </el-table-column>
                            </el-table-column>

                            <el-table-column :label="trans('tr.tr21')">
                              <el-table-column
                                prop="tp_idn_oil"
                                width="130"
                                sortable
                                >
                              </el-table-column>
                            </el-table-column>
                            <el-table-column :label="trans('tr.tr32')">
                              <el-table-column
                                prop="tp_idn_oil_inc"
                                width="130"
                                sortable
                                >
                              </el-table-column>
                            </el-table-column>
                        </el-table-column>

                        <el-table-column :label="trans('tr.trs63')" prop="fake">
                          <el-table-column label="">
                              <el-table-column
                                prop="tp_idn_jd"
                                width="130"
                                sortable
                                >
                              </el-table-column>
                          </el-table-column>
                        </el-table-column>
                        <el-table-column label="Skin" prop="fake">
                          <el-table-column label="">
                              <el-table-column
                                prop="tp_idn_skin"
                                width="130"
                                sortable
                                >
                              </el-table-column>
                          </el-table-column>
                        </el-table-column>
                        <el-table-column :label="trans('tr.trs64')" prop="fake">
                          <el-table-column label="">
                              <el-table-column
                                prop="tp_idn_pi_after"
                                width="130"
                                sortable
                                >
                              </el-table-column>
                          </el-table-column>
                        </el-table-column>


                        <el-table-column :label="trans('tr.tr28')">
                          <el-table-column :label="trans('tr.tr22')">
                              <el-table-column
                                prop="tp_idn_grp_q_liq"
                                width="130"
                                sortable
                                >
                              </el-table-column>
                          </el-table-column>
                          <el-table-column :label="trans('tr.trs78')">
                              <el-table-column
                                prop="tp_idn_grp_q_liq_cas_d_corr"
                                width="130"
                                sortable
                                >
                              </el-table-column>
                          </el-table-column>
                          <el-table-column :label="trans('tr.tr21')">
                              <el-table-column
                                prop="tp_idn_grp_q_oil"
                                width="130"
                                sortable
                                >
                              </el-table-column>
                          </el-table-column>
                          <el-table-column :label="trans('tr.tr32')">
                              <el-table-column
                                prop="tp_idn_grp_q_oil_inc"
                                width="130"
                                sortable
                                >
                              </el-table-column>
                          </el-table-column>
                        </el-table-column>
                    </el-table-column>

                  </el-table>
                  <div class="ui-pagination">
                    <el-pagination
                      small
                      round
                      @current-change="$emit('handleCurrentChange')"
                      :current-page.sync="currentPage"
                      :page-size="pageSize"
                      :total="totalItems"
                      layout="prev, pager, next, jumper">
                    </el-pagination>
                  </div>
            <!-- <TrFullTable :wells="wells" :edit="edit" @onSort="sortBy" v-show="show_second"/> -->
            
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import NotifyPlugin from "vue-easy-notify";
import "vue-easy-notify/dist/vue-easy-notify.css";
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import lang from 'element-ui/lib/locale/lang/ru-RU';
import locale from 'element-ui/lib/locale';
import TrTable from "./table";
import TrFullTable from "./tablefull";
import SearchFormRefresh from "../ui-kit/SearchFormRefresh.vue";
// import FadeLoader from "vue-spinner/src/FadeLoader.vue";
import { fields } from "./constants.js";
import TrMultiselect from "./TrMultiselect.vue";

Vue.use(NotifyPlugin);
Vue.use(ElementUI); 
locale.use(lang)
export default {
  name: "TrPage",
  components: {
    TrTable,
    TrFullTable,
    SearchFormRefresh,
    TrMultiselect,
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
      year: null,
      selectYear: null,
      month: null,
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
      checkers: false,
      checkersec: false,
      isBorderColumnId: ["el-table_1_column_1", "el-table_1_column_5", "el-table_1_column_9", "el-table_1_column_13", "el-table_1_column_17", 
      "el-table_1_column_21", "el-table_1_column_25", "el-table_1_column_29", "el-table_1_column_31", "el-table_1_column_33", "el-table_1_column_37",
      "el-table_1_column_41", "el-table_1_column_45", "el-table_1_column_49", "el-table_1_column_51", "el-table_1_column_53", "el-table_1_column_57",
      "el-table_1_column_61", "el-table_1_column_65", "el-table_1_column_69",  "el-table_1_column_73", "el-table_1_column_77", "el-table_1_column_81", "el-table_1_column_85",
       "el-table_1_column_89", "el-table_1_column_93", "el-table_1_column_97", "el-table_1_column_101", "el-table_1_column_103", "el-table_1_column_105", "el-table_1_column_109", 
       "el-table_1_column_113", "el-table_1_column_125", "el-table_1_column_137", "el-table_1_column_141","el-table_1_column_145","el-table_1_column_149", 
       "el-table_1_column_153", "el-table_1_column_163", "el-table_1_column_165", "el-table_1_column_167", "el-table_1_column_169", "el-table_1_column_171",
        "el-table_1_column_173", "el-table_1_column_175",  "el-table_1_column_177", "el-table_1_column_179",  "el-table_1_column_181", "el-table_1_column_183", 
      "el-table_1_column_187",  "el-table_1_column_191",  "el-table_1_column_195",  "el-table_1_column_199", ],
        
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
    getHeaderCellClassName({column}) {
      if(column.property === "fake") {
        return 'no_border';
      }
      if(this.isBorderColumnId.includes(column.id)) {
        return 'no_border';
      }
      return 'have_border';
    },
     objectSpanMethod({ row, column, rowIndex, columnIndex }) {
        if (columnIndex === 0) {
          if (rowIndex % 2 === 0) {
            return {
              rowspan: 1,
              colspan: 0
            };
          } else {
            return {
              rowspan: 0,
              colspan: 0
            };
          }
        }
     },

    editrow(row, rowId) {
      this.$store.commit("globalloading/SET_LOADING", false);
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
        if(this.lonelywell[0].is_saved === "Сохранено"){
          this.checkers = false;
          this.checkersec = true;
        }
        else{
          this.checkers = true;
          this.checkersec = false;
        }
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
    closeModal(modalName) {
      this.$modal.hide(modalName)
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

    chooseField() {
      const { filter, fullWells } = this;
      console.log("filter = ", filter);
      console.log(fullWells);
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
    closeModal(modalName) {
      this.$modal.hide(modalName)
      this.show_add=false;
      this.checkers=false;
      this.checkersec=false;
      this.reRender();
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
    // deleteOrSave() {
    //   if(this.lonelywell[0].is_saved === "Не сохранено"){
    //         this.is_save=true
    //   }
    //   else{
    //     return this.is_save=false
    //   }
    // },
    // Отправка данных с модалки в бэк

    // deleteOrSave() {
    //   if(this.lonelywell.length === 1){
    //     this.save_check = !this.show_add;
    //   }
    //   else{
    //     this.show_add = this.show_add;
    //   }
    // },





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
            this.show_add=false;
            this.checkers=false;
            
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
              this.show_add=false;
              this.checkersec=false;
              
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
    isCellWithCommentClass (index, value) {
      return this.wells &&
          this.wells[index] &&
          this.wells[index][value][1][0] !== '0';

    },
    isCircleErrClass (index, value) {
      return this.wells &&
          this.wells[index] &&
          this.wells[index][value][1][0] !== '0';
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
.abat_tr {
  background: #334296 !important;
}
.abba {
  background: #334296 !important;
  color: white;
}
.ui-pagination {
  margin: 16px 0;
  text-align: center;
}
.el-table__body-wrapper {}

.el-table__body-wrapper td {
    height: auto;
    margin: 0;
    padding: 0;
    background: transparent;
}

.el-table__body-wrapper td .cell {
    line-height: 1.3;
    padding: 12px 0;
    margin: 0;
    height: auto;
    width: 100%;
    background: transparent;
}

.el-table__body-wrapper tr:nth-child(even) {
    background: #202b6b!important;
}

.el-table__body-wrapper tr:hover {
    background: #000!important;
}

.el-table__body-wrapper tr:hover td {
    background: #4c5cb5!important;
}

.el-table__header-wrapper th {
    padding: 0;
    height: auto;
}

.el-table__header-wrapper th div {
    background: rgb(51, 57, 117);
    height: auto;
    padding: 20px 0;
    color: #fff;
    font-size: 14px;
}
.el-table thead.is-group th {
    background: rgb(51, 57, 117);
}
.el-table th, .el-table tr {
    background-color: #454D7D;
    color: #fff
}

.no_border.no_border  {
  border-bottom: none;
  
}
.cell-comment-tech {
    display: none;
    width: auto;
    position:absolute;
    z-index:3060;
    text-align: Left;
    opacity: 0.4;
    transition: opacity 2s;
    border-radius: 6px;
    background-color: #555;
    padding:3px;
    bottom: 31px;
    margin-left: 18px;
}
</style>