<template>
  <div class="row visualcenter-page-container mx-0">
    <div class="col-lg-10 middle-block-columns pr-2">
      <horizontal-indicators
        :dateStart="dateStart"
        :dateEnd="dateEnd"
        :dzo="dzoSelect"
      ></horizontal-indicators>
      <div class="d-flex flex-column background-color-table flex-sm-row">
        <div class="col-sm-3 p-3 flex-column">
          <h5>
            <strong>
              {{ trans("visualcenter.operResults") }}
              <br />
              {{ trans("visualcenter.finIndicators") }}
            </strong>
          </h5>
          <select
            class="w-100 p-2 select__button_color"            
            v-model="selectMonthFromBeginOfTheYearh"
          >
            <option :value="0" :selected="'selected'">
              {{ trans("visualcenter.yearBegin") }}
            </option>       
            <option
              v-for="i in numbersOfMonths"
              :value="i + 1"
              :disabled="actualMonth < i"
            >
              {{ trans(`economy_be.months.0`) }} -
              {{ trans(`economy_be.months.${i}`) }} {{new Date().getFullYear() - 1}}
            </option>
          </select>
        </div>
        <div class="col-sm-6 flex-column pt-3">
          <select
            class="w-100 p-2 select__button_color"   
            v-model="dzoSelect"
          >
            <option :value="'ALL'" :selected="'selected'">
              {{ trans("visualcenter.allNDO") }}
            </option>
            <option
              v-for="company in fullCompanyNames"
              :value="company.code"
            >
              {{ company.title }}
            </option>
          </select>
          <div class="w-100 d-flex" style="margin-top: 14px">
            <select
              class="w-50 p-2 mr-3 select__button_color"          
              v-model="selectMonth"
            >
              <option :value="0" :selected="'selected'">
                {{ trans("visualcenter.monthZa") }}
              </option>
              <option
                v-for="i in numbersOfMonths"
                :value="i + 1"
                :disabled="actualMonth < i"
              >
                {{ trans(`economy_be.months.${i}`) }} {{new Date().getFullYear() - 1}}
              </option>
            </select>
            <select
              class="w-50 p-2 select__button_color"           
              v-model="selectQuarter"
            >
              <option :value="0" :selected="'selected'">
                {{ trans("visualcenter.quarter") }}
              </option>
              <option :value="1">
                {{ trans("visualcenter.janMar2020") }}
              </option>
              <option :value="4" :disabled="actualMonth < 3">
                {{ trans("visualcenter.aprJune2020") }}
              </option>
              <option :value="7" :disabled="actualMonth < 6">
                {{ trans("visualcenter.julySept2020") }}
              </option>
              <option :value="10" :disabled="actualMonth < 9">
                {{ trans("visualcenter.octDec2020") }}
              </option>
            </select>
          </div>
        </div>
        <div class="col-sm-3 flex-column p-3">
          <div class="float-right">
            <div class="close-button d-none d-sm-block">
              {{ trans("visualcenter.close") }}
            </div>
          </div>
          <button
            class="w-100 p-2 vc-button mt-4 select__button_color"         
            :value="selectActualMonth"
            @click="selectActualMonth = (selectActualMonth + 1) % 2"
          >
            {{ trans("visualcenter.monthAct") }}
          </button>
        </div>
      </div>
      <div class="background-color-table vc-5-tables-block">
        <div v-if="macroData.length > 0">
          <h5 class="text-center mr-2">
            <strong>
              {{ trans("visualcenter.macroIndicators") }}
            </strong>
          </h5>
          <div class="ml-0 ml-sm-3 mr-0 mr-sm-3 pb-3 table-scroll">
            <div class="w-100">
              <table
                class="table table-economics pl-2 table-striped table-borderless text-right economics-table-border"
              >
                <thead class="economics-table-color">
                  <tr>
                    <th class="text-left column-1-macro-table" scope="col">
                      {{ trans("visualcenter.name") }}
                    </th>
                    <th scope="col" class="column-2-macro-table">
                      {{ trans("visualcenter.unit") }}
                    </th>
                    <th scope="col" class="column-all-macro-table">
                      {{ trans("visualcenter.Fact") }} <br />
                      {{new Date().getFullYear() - 2}} {{ trans("economy_be.year") }}
                    </th>
                    <th scope="col" class="column-all-macro-table">
                      <br />
                      {{ trans("economics.factZa") }} <br />
                      {{factFromOneDay}}
                    </th>
                    <th scope="col" class="column-all-macro-table">
                      {{ trans("economics.planNa") }} <br />
                      {{new Date().getFullYear() - 1}}  {{ trans("economy_be.year") }}
                    </th>

                    <th
                      scope="col"
                      class="column-all-macro-table reptt-column-blue"
                    >
                      {{ trans("visualcenter.Plan") }}<br />
                      {{ trans("economics.sinceTheBeginningOfTheYear") }}
                    </th>

                    <th
                      scope="col"
                      class="column-all-macro-table reptt-column-blue"
                    >
                      {{ trans("visualcenter.Fact") }}
                      <br />{{ trans("economics.sinceTheBeginningOfTheYear") }}
                    </th>
                    <th
                      scope="col"
                      class="column-all-macro-table reptt-column-blue"
                    >
                      {{ trans("visualcenter.deviationAbs") }}
                      <br />
                      {{ trans("economics.sinceTheBeginningOfTheYear") }}, +/-
                    </th>
                    <th
                      scope="col"
                      class="column-all-macro-table reptt-column-blue"
                    >
                      {{ trans("visualcenter.deviationOtn") }}
                      <br />
                      {{ trans("economics.sinceTheBeginningOfTheYear") }}%
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in macroData">
                    <td class="text-left">{{ item.title }}</td>
                    <td>{{ item.units }}</td>
                    <td>{{ item.dataFactPrevYear.toFixed(1) }}</td>
                    <td>30.01.2019</td>
                    <td>
                      <div v-if="item.plan2020">
                        {{ item.plan2020.toFixed(1) }}
                      </div>
                    </td>
                    <td>{{ item.dataPlan.toFixed(1) }}</td>
                    <td>{{ item.dataFact.toFixed(1) }}</td>
                    <td>
                      <div class="d-flex justify-content-end">
                        <span
                          v-if="item.dataPlan - item.dataFact > 0"
                          class="arrow2"
                        ></span>
                        <span v-else class="arrow3"></span>
                        {{ Math.abs(item.dataPlan - item.dataFact).toFixed(1) }}
                      </div>
                    </td>
                    <td>
                      <div class="d-flex justify-content-end">
                        <span
                          v-if="
                            ((item.dataPlan - item.dataFact) / item.dataPlan) *
                              100 >
                            0
                          "
                          class="arrow2"
                        ></span>
                        <span v-else class="arrow3"></span>
                        {{
                          Math.abs(
                            ((item.dataPlan - item.dataFact) / item.dataPlan) *
                              100
                          ).toFixed(1)
                        }}
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div>
          <h5 class="text-center mr-2">
            <strong>
              {{ trans("economics.executionForTheReportingPeriod") }}
            </strong>
          </h5>
          <div class="ml-0 ml-sm-3 mr-0 mr-sm-3 pb-3 table-scroll">
            <reptt-company  :data-reptt="repttData"></reptt-company>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-2 middle-block-columns" v-if="dateStart">
      <div class="second-column-container">
        <budget-execution-vertical-indicators
          :dateStart="dateStart"
          :dateEnd="dateEnd"
          :dzo="dzoSelect"
        ></budget-execution-vertical-indicators>
      </div>
    </div>
    <cat-loader />
  </div>
</template>
<script src="./budgetExecution.js"></script>
<style scoped>
@import "./budgetExecution.css";
</style>
