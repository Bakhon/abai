<template>
  <div>
    <!-- <div id = "databinding">
         <button v-on:click = "displaynumbers">Click ME</button>
      </div>-->
    <div>
      <div class="level1-content row">
        <div class="col-md-12 col-lg-12 row">
          <div class="main col-lg-7-2 row">
            <div class="visual-center-center">
              <div
                class="level2-tab"
                v-for="(menuDMY, index) in menuDMY()"
                @click="selectedDMY = menuDMY.id"
                :style="{
                  'background-color': menuDMY.current,
                }"
                  >
                {{ menuDMY.DMY }}
              </div>

              <div class="month-day">
                <div
                  class="navigation-table"
                  v-bind:style="{ display: display }"
                >
                  <div class="navigation">
                    <div v-on:click="decrease"><</div>
                  </div>
                  <div class="navigation-month navigation" colspan="5">
                    {{ monthes[month] }} {{ year }}
                  </div>
                  <div class="navigation">
                    <div v-on:click="increase">></div>
                  </div>
                </div>
                <!--<div class="day" v-for="d in day">{{d}}</div>-->
                <div v-for="week in calendar()">
                  <div
                    @click="selectedDay = day.index"
                    class="week"
                    v-for="(day, index) in week"
                    :style="{
                      color: day.weekend,
                      'background-color': day.current,
                    }"
                    v-on:click="displaynumbers"
                  >
                    <div>{{ day.index }}</div>
                  </div>
                </div>
                <div
                  class="week"
                  v-for="(month, index) in getMonths()"
                  :key="index.id"
                  :style="{
                    'background-color': month.current,
                  }"
                  @click="selectedMonth = month.index"
                  v-on:click="displaynumbers"
                >
                  {{ month.index }}
                </div>

                <div
                  class="week"
                  v-for="(year, index) in getYears()"
                  :key="year.id"
                  :style="{
                    'background-color': year.current,
                  }"
                  @click="selectedYear = year.index"
                  v-on:click="displaynumbers"
                >
                  {{ year.index }}
                </div>
              </div>

              <div class="visual-center-center">
                <div class="tables">
                  <div class="visual-center-center">
                    <a>
                      <li
                        class="circle-2"
                        tabindex="-2"
                        :style="`${buttonHover1}`"
                        @click="
                          getProduction(
                            'oil_plan',
                            'oil_fact',
                            ' Добыча нефти',
                            'тн'
                          )
                        "
                      >
                        <div class="circle-2-string">Добыча нефти</div>
                      </li>
                    </a>

                    <a>
                      <li
                        class="circle-2"
                        tabindex="-2"
                        :style="`${buttonHover5}`"
                        @click="
                          getProduction(
                            'gk_plan',
                            'gk_fact',
                            'Добыча конденсата',
                            'тн'
                          )
                        "
                      >
                        <div class="circle-2-string">Добыча конденсата</div>
                      </li>
                    </a>

                    <a>
                      <li
                        class="circle-2"
                        tabindex="-2"
                        :style="`${buttonHover3}`"
                        @click="
                          getProduction(
                            'gas_plan',
                            'gas_fact',
                            'Добыча газа',
                            'тыс м3'
                          )
                        "
                      >
                        <div class="circle-2-string">Добыча газа</div>
                      </li>
                    </a>

                    <a>
                      <li
                        class="circle-2"
                        tabindex="-2"
                        :style="`${buttonHover4}`"
                        @click="
                          getProduction(
                            'liq_plan',
                            'liq_fact',
                            'Добыча жидкости',
                            'м3'
                          )
                        "
                      >
                        <div class="circle-2-string">Добыча жидкости</div>
                      </li>
                    </a>

                    <a>
                      <li
                        class="circle-2"
                        tabindex="-2"
                        :style="`${buttonHover6}`"
                        @click="
                          getProduction(
                            'inj_plan',
                            'inj_fact',
                            'Объём закачки',
                            'м3'
                          )
                        "
                      >
                        <div class="circle-2-string">Объём закачки</div>
                      </li>
                    </a>

                    <a>
                      <li
                        class="circle-2"
                        tabindex="-2"
                        :style="`${buttonHover2}`"
                        @click="
                          getProduction(
                            'oil_dlv_plan',
                            'oil_dlv_fact',
                            'Сдача нефти',
                            'тн'
                          )
                        "
                      >
                        <div class="circle-2-string">Сдача нефти</div>
                      </li>
                    </a>
                  </div>
                  <!--<div class="right-chart-button right-button" tabindex="-5">
               
                -->

                  <!--<div
                    class="right-table-button right-button"
                    :style="`${showTableOn}`"
                    @click="changeButton(`${showTable2}`, 'Yes')"
                  >
                    {{ ChartTable }}
                  </div>-->

                  <div class="tables" :style="`${displayHeadTables}`">
                    <div
                      class="right-table-button right-button"
                      :style="`${showTableOn}`"
                      @click="changeButton(`${showTable2}`, 'Yes')"
                    >
                      {{ ChartTable }}
                    </div>
                    <div class="tables-name">{{ circleMenu }}</div>
                    <!--<div class="btn btn-info2" >Вывести таблицу</div>-->
                    <div class="tables-string">
                      <!--<div class="cell-colour-top table-border"></div>-->
                      <div class="cell-number-top table-border">№</div>
                      <div class="cell-name-top table-border">Предприятия</div>
                      <div class="cell-last-top table-border cell-last">
                        ДОБЫЧА, {{ unit }}
                      </div>
                      <div class="cell2 table-border">
                        План на {{ selectedYear }} год
                      </div>
                      <div class="cell2 table-border">
                        План на {{ currentMonth }} месяц
                      </div>
                      <div class="cell3 table-border">СУТОЧНАЯ</div>
                      <div class="cell3 table-border">С НАЧАЛА МЕСЯЦА</div>
                      <div class="cell3 table-border cell-last">
                        С НАЧАЛА ГОДА
                      </div>
                      <div class="cell4 table-border">ПЛАН</div>
                      <div class="cell4 table-border">ФАКТ</div>
                      <div class="cell4 table-border">(+,-)</div>
                      <div class="cell4 table-border">ПЛАН</div>
                      <div class="cell4 table-border">ФАКТ</div>
                      <div class="cell4 table-border">(+,-)</div>
                      <div class="cell4 table-border">ПЛАН</div>
                      <div class="cell4 table-border">ФАКТ</div>
                      <div class="cell4 table-border cell-last">(+,-)</div>
                    </div>
                    <div style="clear: both;"></div>
                    <div>
                      <div>
                        <!-- <div class="cell-colour table-border">
                 
                        </div>-->

                        <div v-for="(item, index) in bigTable">
                          <div>
                            <div>
                              <!-- <div class="cell-colour table-border">
                 
                        </div>-->
                              <div class="cell-number table-border">
                                {{ index + 1 }}
                              </div>
                              <div class="cell-name table-border">
                                {{ item.dzoDay }}
                                <!--  {{ item.dzo }}{{ item.dzoMonth }}  {{item.dzoYear}}-->
                                <!--{{item.time}}-->
                              </div>
                              <div class="cell table-border">
                                <div v-if="item.planYear">
                                  {{ (new Intl.NumberFormat('ru-RU').format(item.planYear)) }}
                                </div>
                              </div>
                              <div class="cell table-border">
                                <div v-if="item.planMonth">
                                  {{ (new Intl.NumberFormat('ru-RU').format(item.planMonth)) }}
                                </div>
                              </div>
                              <div class="cell table-border">
                                <div v-if="item.planDay">
                                  {{ (new Intl.NumberFormat('ru-RU').format(item.planDay  ))}}
                                </div>
                              </div>
                              <div class="cell table-border">
                                <div v-if="item.factDay">
                                  {{ (new Intl.NumberFormat('ru-RU').format(item.factDay ))}}
                                </div>
                              </div>
                              <div class="cell table-border colour">
                                <div>
                                  <div
                                    v-if="item.factDay"
                                    class="circle-table"
                                    :style="`background: ${getColor(
                                      item.factDay - item.planDay
                                    )}`"
                                  ></div>
                                </div>
                                <div v-if="item.factDay">
                                  <div>
                                    {{(new Intl.NumberFormat('ru-RU').format( item.factDay - item.planDay)) }}
                                  </div>
                                </div>
                              </div>
                              <div class="cell table-border">
                                <div v-if="item.planMonth">
                                  {{ (new Intl.NumberFormat('ru-RU').format(item.planMonth)) }}
                                </div>
                              </div>
                              <div class="cell table-border">
                                <div v-if="item.factMonth">
                                  {{ (new Intl.NumberFormat('ru-RU').format(item.factMonth)) }}
                                </div>
                              </div>
                              <div class="cell table-border colour">
                                <div
                                  v-if="item.planMonth"
                                  class="circle-table"
                                  :style="`background: ${getColor(
                                    item.factMonth - item.planMonth
                                  )}`"
                                ></div>
                                <!--3cell-->
                                <div v-if="item.planMonth">
                                  {{ (new Intl.NumberFormat('ru-RU').format(item.factMonth - item.planMonth)) }}
                                </div>
                              </div>
                              <div class="cell table-border">
                                <div v-if="item.planYear">
                                  {{(new Intl.NumberFormat('ru-RU').format( item.planYear)) }}
                                </div>
                              </div>
                              <div class="cell table-border">
                                <div v-if="item.factYear">
                                  {{ (new Intl.NumberFormat('ru-RU').format(item.factYear)) }}
                                </div>
                              </div>
                              <div class="cell table-border cell-last colour">
                                <div
                                  v-if="item.planYear"
                                  class="circle-table"
                                  :style="`background: ${getColor(
                                    item.factYear - item.planYear
                                  )}`"
                                ></div>
                                <div v-if="item.planYear">
                                  {{ (new Intl.NumberFormat('ru-RU').format(item.factYear - item.planYear)) }}
                                </div>
                              </div>
                            </div>
                            <div style="clear: both;"></div>
                          </div>
                        </div>
                        <div class="cell-number table-border"></div>
                        <div class="cell-name2 table-border">
                          {{ NameDzoFull[0] }}
                        </div>
                        <div class="cell table-border">
                          <div>
                            {{ (new Intl.NumberFormat('ru-RU').format(planYearSumm)) }}
                          </div>
                        </div>
                        <div class="cell table-border">
                          <div>
                            {{ (new Intl.NumberFormat('ru-RU').format(planMonthSumm)) }}
                          </div>
                        </div>
                        <div class="cell table-border">
                          <div>
                            {{ (new Intl.NumberFormat('ru-RU').format(planDaySumm  ))}}
                          </div>
                        </div>
                        <div class="cell table-border">
                          <div>
                            {{ (new Intl.NumberFormat('ru-RU').format(factDaySumm ))}}
                          </div>
                        </div>
                        <div class="cell table-border colour">
                          <div>
                            <div
                              :style="`background: ${getColor(
                                factDaySumm - planDaySumm
                              )}`"
                              class="circle-table"
                            ></div>
                          </div>
                          <div>
                            <div class="cell-width">
                              {{(new Intl.NumberFormat('ru-RU').format(factDaySumm - planDaySumm)) }}
                            </div>
                          </div>
                        </div>
                        <div class="cell table-border">
                          <div>
                            {{ (new Intl.NumberFormat('ru-RU').format(planMonthSumm)) }}
                          </div>
                        </div>
                        <div class="cell table-border">
                          <div>
                            {{ (new Intl.NumberFormat('ru-RU').format(factMonthSumm)) }}
                          </div>
                        </div>
                        <div class="cell table-border colour">
                          <div
                            :style="`background: ${getColor(
                              factMonthSumm - planMonthSumm
                            )}`"
                            class="circle-table"
                          ></div>
                          <!--3cell-->
                          <div class="cell-width">
                            {{ (new Intl.NumberFormat('ru-RU').format(factMonthSumm - planMonthSumm)) }}
                          </div>
                        </div>
                        <div class="cell table-border">
                          <div>
                            {{(new Intl.NumberFormat('ru-RU').format( planYearSumm)) }}
                          </div>
                        </div>
                        <div class="cell table-border">
                          <div>
                            {{ (new Intl.NumberFormat('ru-RU').format(factYearSumm)) }}
                          </div>
                        </div>
                        <div class="cell table-border cell-last colour">
                          <div
                            :style="`background: ${getColor(
                              factYearSumm - planYearSumm
                            )}`"
                            class="circle-table"
                          ></div>
                          <div>
                            {{ (new Intl.NumberFormat('ru-RU').format(factYearSumm - planYearSumm)) }}
                          </div>
                        </div>
                      </div>
                      <div style="clear: both;"></div>
                      <div class="tables-bottom-line"></div>
                    </div>
                  </div>

                  <div class="tables" :style="`${displayTable}`">
                    <div
                      class="right-table-button right-button"
                      :style="`${showTableOn}`"
                      @click="changeButton(`${showTable2}`, 'Yes')"
                    >
                      {{ ChartTable }}
                    </div>
                    <div class="tables-name">{{ circleMenu }}</div>
                    <!--<div class="btn btn-info2" >Вывести таблицу</div>-->
                    <div class="tables-string2">
                      <!--<div class="cell-colour-top table-border"></div>-->
                      <div class="cell-number-top table-border">№</div>
                      <div class="cell-name-top table-border">Предприятия</div>
                      <div class="table-border cell-last-top-small-table">
                        ДОБЫЧА, {{ unit }}
                      </div>
                      <!--<div class="cell2 table-border">
                        План на {{ selectedYear }} год
                      </div>
                        <div class="cell2 table-border">
                        План на {{ currentMonth }} месяц
                      </div>
                      <div class="cell3 table-border">СУТОЧНАЯ</div>
                      <div class="cell3 table-border">С НАЧАЛА МЕСЯЦА</div>
                    <div class="cell3 table-border cell-last">
                        С НАЧАЛА ГОДА
                      </div>
                      <div class="cell4 table-border">ПЛАН</div>
                      <div class="cell4 table-border">ФАКТ</div>
                      <div class="cell4 table-border">(+,-)</div>
                      <div class="cell4 table-border">ПЛАН</div>
                      <div class="cell4 table-border">ФАКТ</div>
                      <div class="cell4 table-border">(+,-)</div>-->
                      <div class="cell4-small-table table-border">ПЛАН</div>
                      <div class="cell4-small-table table-border">ФАКТ</div>
                      <div class="cell4-small-table table-border cell-last">
                        (+,-)
                      </div>
                    </div>
                    <div style="clear: both;"></div>
                    <div v-for="(item, index) in tables">
                      <div>
                        <div>
                          <!-- <div class="cell-colour table-border">
           
                        </div>-->
                          <div class="cell-number table-border">
                            {{ index + 1 }}
                          </div>
                          <div class="cell-name table-border">
                            {{ item.dzo }}
                            {{ item.timeMonth }}
                          </div>
                          <!--<div class="cell table-border">
                            <div v-if="item.planYear">
                              {{ (new Intl.NumberFormat('ru-RU').format(item.planYear ))}}
                            </div>
                          </div>
                          <div class="cell table-border"></div>
                          <div class="cell table-border">
                            <div v-if="item.plan">
                              {{ (new Intl.NumberFormat('ru-RU').format(item.plan ))}}
                            </div>
                          </div>
                          <div class="cell table-border">
                            <div v-if="item.fact">
                              {{(new Intl.NumberFormat('ru-RU').format( item.fact ))}}
                            </div>
                          </div>
                          <div class="cell table-border colour">
                            <div>
                              <div
                                v-if="item.fact"
                                class="circle-table"
                                :style="`background: ${getColor(
                                  item.fact - item.plan
                                )}`"
                              ></div>
                            </div>
                            <div v-if="item.fact">
                              <div>
                                {{(new Intl.NumberFormat('ru-RU').format( item.fact - item.plan)) }}
                              </div>
                            </div>
                          </div>
                          <div class="cell table-border">
                            <div v-if="item.productionPlanForMonth">
                              {{ item.productionPlanForMonth }}
                            </div>
                          </div>
                          <div class="cell table-border">
                            <div v-if="item.productionFactForMonth">
                              {{ (new Intl.NumberFormat('ru-RU').format(item.productionFactForMonth ))}}
                            </div>
                          </div>
                          <div class="cell table-border colour">
                            <div
                              v-if="item.productionPlanForMonth"
                              class="circle-table"
                              :style="`background: ${getColor(
                                item.productionFactForMonth -
                                  item.productionPlanForMonth
                              )}`"
                            ></div>
                            3cell
                            <div v-if="item.productionPlanForMonth">
                              {{
                              (new Intl.NumberFormat('ru-RU').format(item.productionFactForMonth -
                              item.productionPlanForMonth))
                              }}
                            </div>
                          </div>-->
                          <div class="cell table-border">
                            <div v-if="item.plan">
                              {{ (new Intl.NumberFormat('ru-RU').format(item.plan)) }}
                            </div>

                            <div v-if="item.productionPlanForMonth">
                              {{ (new Intl.NumberFormat('ru-RU').format(item.productionPlanForMonth)) }}
                            </div>

                            <div v-if="item.planYear">
                              {{ (new Intl.NumberFormat('ru-RU').format(item.planYear)) }}
                            </div>
                          </div>

                          <div class="cell table-border">
                            <div v-if="item.fact">
                              {{ (new Intl.NumberFormat('ru-RU').format(item.fact)) }}
                            </div>

                            <div v-if="item.productionFactForMonth">
                              {{ (new Intl.NumberFormat('ru-RU').format(item.productionFactForMonth)) }}
                            </div>

                            <div v-if="item.factYear">
                              {{ (new Intl.NumberFormat('ru-RU').format(item.factYear ))}}
                            </div>
                          </div>

                          <div class="cell table-border cell-last colour">
                            <div
                              v-if="item.plan"
                              class="circle-table"
                              :style="`background: ${getColor(
                                item.fact - item.plan
                              )}`"
                            ></div>
                            <div v-if="item.plan">
                              {{ (new Intl.NumberFormat('ru-RU').format(item.fact - item.plan)) }}
                            </div>

                            <div
                              v-if="item.productionPlanForMonth"
                              class="circle-table"
                              :style="`background: ${getColor(
                                item.productionFactForMonth -
                                  item.productionPlanForMonth
                              )}`"
                            ></div>
                            <div v-if="item.productionPlanForMonth">
                              {{ (new Intl.NumberFormat('ru-RU').format(item.productionFactForMonth - item.productionPlanForMonth)) }}
                            </div>

                            <div
                              v-if="item.planYear"
                              class="circle-table"
                              :style="`background: ${getColor(
                                item.factYear - item.planYear
                              )}`"
                            ></div>
                            <div v-if="item.planYear">
                              {{ (new Intl.NumberFormat('ru-RU').format(item.factYear - item.planYear)) }}
                            </div>
                          </div>
                        </div>
                        <div style="clear: both;"></div>
                      </div>
                      <div class="tables-bottom-line-small-table"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="visual-center-center" :style="`${displayChart}`">
                <div
                  class="right-table-button right-button"
                  :style="`${showTableOn}`"
                  @click="changeButton(`${showTable2}`, 'Yes')"
                >
                  {{ ChartTable }}
                </div>
                <div class="tables-name">График {{ circleMenu }}</div>
                <div class="unit">{{ unit }}</div>
                <div class="otstup">
                  <visual-center-chart-area-center
                    v-for="(serial, index) in productionForChart"
                    v-bind:postTitle="serial"
                    :key="serial"
                  >
                  </visual-center-chart-area-center>
                  <div class="chart-date">{{ DMY }}</div>
                </div>
              </div>
              <div class="visual-center-center">
                <div class="visual-center-bottom">
                  <div class="visual-center-string1">Отключение РП:</div>
                  <div class="visual-center-string2">
                    <div class="marquee">
                      <span>Отключение РП: 12.09.2020 г.</span>
                    </div>
                  </div>
                  <div class="visual-center-string1">Отключение скважин:</div>
                  <div class="visual-center-string2">
                    <div class="marquee">
                      <span
                        >Внимание коллеги! Отключение скважин ожидается
                        12.09.2020 г.</span
                      >
                    </div>
                  </div>
                  <div class="visual-center-string1">Выбросы и разливы:</div>
                  <div class="visual-center-string2"></div>
                  <div class="visual-center-string1">Прочие:</div>
                  <div class="visual-center-string2"></div>
                </div>
                <div class="visual-center-bottom vcb-left">
                  <div class="accidents-first accidents">
                    <div class="number-of-accidents">2</div>
                    Несчастные <br />случаи
                  </div>
                  <div class="accidents-second accidents">
                    <div class="number-of-accidents">0</div>
                    Смертельные <br />случаи
                  </div>
                  <div class="accidents-third accidents">
                    <div class="number-of-accidents">14</div>
                    COVID <br />19
                  </div>
                </div>
                <div class="visual-center-bottom vcb-left">
                  <div class="difference-of-24">Отклонение</div>
                  <div class="visual-center-chart-bar-bottom">
                    <visual-center-chart-bar-bottom
                      v-for="(start, index) in starts"
                      v-bind:starts="start"
                      :key="start"
                    ></visual-center-chart-bar-bottom>
                  </div>
                  <div class="starting">
                    <div class="start">Пуски из КРС</div>
                    <div class="start">Пуски из ПРС</div>
                    <div class="start">Ввод из бурения</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="visual-center-right-column">
              <div class="donut">
                <div class="indent">Фонд добывающих скважин</div>
                <div>
                  <visual-center-chart-donut-right1
                    v-for="(well, index) in wells2"
                    v-bind:wells2="well"
                    :key="well"
                  ></visual-center-chart-donut-right1>
                </div>
              </div>
              <div class="donut donut2">
                <div class="indent">Фонд нагнетательных скважин</div>
                <div>
                  <visual-center-chart-donut-right2
                    v-for="(well, index) in wells"
                    v-bind:wells="well"
                    :key="well"
                  ></visual-center-chart-donut-right2>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { EventBus } from "./event-bus.js";
export default {
  template: "#vue-status-overview-template",
  data: function () {
    return {
      //showTableItem: "No",]
      DMY: "День",
      item: "",
      item2: "",
      item3: "",
      item4: "",
      productionForChart: "",
      tables: "",
      showTable2: "Yes",
      displayTable: "display: none;",
      displayChart: "display: none;",
      showTableOn: "",
      buttonHover1: "",
      buttonHover2: "",
      buttonHover3: "",
      buttonHover4: "",
      buttonHover5: "",
      buttonHover6: "",

      circleMenu: "",
      month: new Date().getMonth(),
      year: new Date().getFullYear(),
      currentMonth: [],
      ChartTable: "График",
      date2: new Date().toLocaleString("ru", {
        /*year: 'numeric',
	month: 'long',
	day: 'numeric',
	weekday: 'long',
	timezone: 'UTC',*/
        hour: "numeric",
        minute: "numeric",
        //second: 'numeric'
      }),

      date3: new Date().toLocaleString("ru", {
        weekday: "long",
      }),
      dFirstMonth: "0",
      day: ["Mn", "Tu", "We", "Th", "Fr", "Sa", "Su"],
      monthes: [
        "ЯНВАРЬ",
        "ФЕВРАЛЬ",
        "МАРТ",
        "АПРЕЛЬ",
        "МАЙ",
        "ИЮНЬ",
        "ИЮЛЬ",
        "АВГУСТ",
        "СЕНТЯБРЬ",
        "ОКТЯБРЬ",
        "НОЯБРЬ",
        "ДЕКАБРЬ",
      ],
      monthes3: [
        "",
        "январь",
        "февраль",
        "март",
        "апрель",
        "май",
        "июнь",
        "июль",
        "август",
        "сентябрь",
        "октябрь",
        "ноябрь",
        "декабрь",
      ],
      monthes2: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
      ],

      NameDzoFull: [
        "Всего добыча нефти с учётом доли участия АО НК КазМунайГаз",
        'АО "Озенмунайгаз" (100%)',
        'АО "Эмбамунайгаз" (100%)',
        'АО "Каражанбасмунай" (50%)',
        'ТОО "Казгермунай" (50%)',
        "ТОО «Тенгизшевройл»",
        'АО "Мангистаумунайгаз" (50%)',
        'ТОО "Казахтуркмунай" (100%)',
        'ТОО "Казахойл Актобе" (50%)',
        '"ПетроКазахстан Инк."',
        '"Амангельды Газ"',
        "«Карачаганак Петролеум Оперейтинг б.в.»",
        "«Норт Каспиан Оперейтинг Компани н.в.»",
        "(конденсат)(100%)",
        "в т.ч.:газовый конденсат",
      ],
      date: new Date(),
      selectedDay: undefined,
      selectedMonth: undefined,
      selectedYear: undefined,
      selectedDMY: undefined,

      wells: [""],
      wells2: [""],
      bigTable: [""],
      displayHeadTables: "",
      starts: [""],
      test: [""],
      series: ["", ""],
      display: "none",
      company: "all",
      factYearSumm: "",
      planYearSumm: "",
      planMonthSumm: "",
      factMonthSumm: "",
      factDaySumm: "",
      planDaySumm: "",
      unit: "",
    };
  },
  methods: {
    displaynumbers: function (event) {
      console.log(event);
      return this.getProduction(this.item, this.item2, this.item3, this.item4);
    },
    displayMessage: function (message) {
      this.company = message;
    },
    getCompany() {},

    getColor(status) {
      if (status < "0") return "#b40300";
      return "#008a17";
    },

    calendar: function () {
      var days = [];
      var week = 0;
      days[week] = [];
      var dlast = new Date(this.year, this.month + 1, 0).getDate();
      for (let i = 1; i <= dlast; i++) {
        if (new Date(this.year, this.month, i).getDay() != this.dFirstMonth) {
          var a = { index: i, id: i };
          days[week].push(a);
          if (this.selectedDay == i) {
            a.current = "#232236";
          } else if (
            i == new Date().getDate() &&
            this.year == new Date().getFullYear() &&
            this.month == new Date().getMonth()
          ) {
            a.current = "#13B062";
          }

          if (
            new Date(this.year, this.month, i).getDay() == 6 ||
            new Date(this.year, this.month, i).getDay() == 0
          ) {
            a.weekend = "#ff0000";
          }
        } else {
          week++;

          days[week] = [];
          a = { index: i };
          days[week].push(a);
          if (this.selectedDay == i) {
            a.current = "#232236";
          } else if (
            i == new Date().getDate() &&
            this.year == new Date().getFullYear() &&
            this.month == new Date().getMonth()
          ) {
            a.current = "#747ae6";
          }
          if (
            new Date(this.year, this.month, i).getDay() == 6 ||
            new Date(this.year, this.month, i).getDay() == 0
          ) {
            a.weekend = "#ff0000";
          }
        }
      }

      /*	if (days[0].length > 0) {
					for (let i = days[0].length; i < 7; i++) {
						days[0].unshift('');

					}
				}*/
      this.dayChange;
      if (this.selectedDMY == "0") {
        this.display = "block";
        return days;
      }
    },

    decrease: function () {
      this.month--;
      if (this.month < 0) {
        this.month = 12;
        this.month--;
        this.year--;
      }
    },
    increase: function () {
      this.month++;
      if (this.month > 11) {
        this.month = -1;
        this.month++;
        this.year++;
      }
    },

    getMonths: function () {
      var monthAll = [];
      var month = new Date(this.year, this.month + 1, 0).getMonth();

      for (let i = 1; i <= 12; i++) {
        if (new Date(this.year, this.month + 1, i)) {
          var a = { index: i, id: i };
          monthAll.push(a);
          if (this.selectedMonth == i) {
            a.current = "#232236";
          } else if (
            i == Number(new Date().getMonth() + 1) && //new Date().getMonth() &&
            this.year ==
              new Date().getFullYear() /* &&
        this.month == new Date().getMonth()*/
          ) {
            a.current = "#13B062";
          }
        }
      }
      if (this.selectedDMY == "1") {
        this.display = "none";
        return monthAll;
      }
    },

    getDays: function () {
      var DaysInMonth = [];
      var dlast = new Date(this.year, this.month + 1, 0).getDate(); //k1q
      for (let i = 1; i <= dlast; i++) {
        var a = { index: i, id: i };
        DaysInMonth.push(a);
      }
      return DaysInMonth;
    },

    getDaysMonth: function () {
      var DaysInMonth = [];
      var dlast = new Date(this.year, this.selectedMonth, 0).getDate(); //k1q
      for (let i = 1; i <= dlast; i++) {
        var a = { index: i, id: i };
        DaysInMonth.push(a);
      }
      return DaysInMonth;
    },

    getDaysInYear: function () {
      var getDaysInYear = [];
      for (let q = 1; q <= 12; q++) {
        var dlast = new Date(this.year, q, 0).getDate();
        for (let i = 1; i <= dlast; i++) {
          var a = { month: q, day: i };
          getDaysInYear.push(a);
        }
      }
      return getDaysInYear;
    },

    getYears: function () {
      var yearAll = [];
      var year = this.year;
      for (let i = 2018; i <= year; i++) {
        //if (this.year, this.month, i).getYear() ) {
        var a = { index: i, id: i };
        yearAll.push(a);
        if (this.selectedYear == i) {
          a.current = "#232236";
        } else if (
          i ==
          year /*&&
          this.year == new Date().getFullYear() &&
          this.month == new Date().getMonth()*/
        ) {
          a.current = "#13B062";
        }
      }

      if (this.selectedDMY == "2") {
        this.display = "none";
        return yearAll;
      }
    },

    menuDMY() {
      var DMY = ["День", "Месяц", "Год"];
      var menuDMY = [];
      var id = 0;
      for (let i = 0; i <= 2; i++) {
        var a = { index: i, id: i };
        a.DMY = DMY[i];
        menuDMY.push(a);
        if (this.selectedDMY == i) {
          a.current = "#1D70B7";
          this.DMY = menuDMY[i]["DMY"];
        }
      }
      if (this.selectedDMY != undefined) {
      }

      localStorage.setItem("selectedDMY", this.selectedDMY);

      return menuDMY;
    },
    pad(n) {
      return n < 10 ? "0" + n : n;
    },
    getProduction(item, item2, item3, item4) {
      this.item = item;
      this.item2 = item2;
      this.item3 = item3;
      this.item4 = item4;

      this.unit = item4;

      if (this.selectedDay == undefined) {
        var timeSelect =
          this.pad(new Date().getDate()) +
          "." +
          this.pad(this.month + 1) +
          "." +
          this.year;
      } else {
        var timeSelect =
          this.pad(this.selectedDay) +
          "." +
          this.pad(this.month + 1) +
          "." +
          this.year;
      }
      EventBus.$emit("timeSelect", timeSelect);

      localStorage.setItem("production-plan", item);
      localStorage.setItem("production-fact", item2);

      var productionPlan = localStorage.getItem("production-plan");
      var productionFact = localStorage.getItem("production-fact");

      var selectedDMY = localStorage.getItem("selectedDMY");

      this.circleMenu = item3;

      var company = this.company;

      if (company === null) {
        alert("Сначала выберите название компании");
      }

      //data from the year
      var data2;
      let uri2 = "/js/json/getnkkmgyear.json";
      this.axios.get(uri2).then((response) => {
        data2 = response.data;
      });

      //data from the day
      let uri = "/js/json/getnkkmg.json";
      //let uri = "/ru/getnkkmg";
      this.axios.get(uri).then((response) => {
        let data = response.data;
        if (data) {
          var arrdata = new Array();
          //select date filter k1q
          var timestamp = new Date(
            this.monthes2[this.month] +
              this.selectedDay +
              " " +
              this.year +
              " 06:00:00 GMT+0600"
          ).getTime();

          arrdata = _.filter(data, _.iteratee({ dzo: company }));
          //get data by Month
          var SelectYearInMonth; //value
          if (this.selectedYear == undefined) {
            SelectYearInMonth = this.year;
          } else {
            SelectYearInMonth = this.selectedYear;
          }

          if (this.selectedDMY == 0) {
            //selectedDay by chart
            var timestampMonthStart = new Date(
              this.monthes2[this.month] +
                //this.selectedDay +
                "1" +
                " " +
                SelectYearInMonth +
                " 06:00:00 GMT+0600"
            ).getTime();

            var dayInMonth = this.getDays().length;

            var dataWithMay = new Array();
            dataWithMay = _.filter(arrdata, function (item) {
              return _.every([
                _.inRange(
                  item.__time,
                  // 1588291200000, // May 2020
                  timestampMonthStart,
                  timestampMonthStart + 86400000 * dayInMonth
                ),
              ]);
            });

            //for chart
            var productionPlanForChart = new Array();
            _.forEach(dataWithMay, function (item) {
              productionPlanForChart.push({
                productionPlanForChart: item[productionPlan],
              });
            });

            var productionFactForChart = new Array();
            _.forEach(dataWithMay, function (item) {
              productionFactForChart.push({
                productionFactForChart: item[productionFact],
              });
            });
          }

          if (this.selectedDMY == 1) {
            //selectedMonth by chart
            var getDaysInYear = [];
            for (let i = 1; i <= 12; i++) {
              var allDays = _.filter(
                this.getDaysInYear(),
                _.iteratee({ month: i })
              );
              getDaysInYear[i] = allDays.length;
            }
            var months = [];
            var getMonthsTime = [];

            var timestampMonthStart = [];
            for (let i = 0; i <= 11; i++) {
              timestampMonthStart[i] = new Date(
                this.monthes2[i] + "01 " + this.year + ""
              ).getTime();
            }

            for (let i = 0; i <= 11; i++) {
              months[i] = _.filter(arrdata, function (item) {
                return _.every([
                  _.inRange(
                    item.__time,
                    timestampMonthStart[i],
                    timestampMonthStart[i] + 86400000 * getDaysInYear[i + 1]
                  ),
                ]);
              });
              getMonthsTime = months;
            }

            var productionFactForChart = _.reduce(
              getMonthsTime[0],
              function (memo, item) {
                return memo + item[productionFact];
              },
              0
            );

            //  productionFactForChart = productionFactForChart / getDaysInYear[1];

            var productionPlanForChart = _.reduce(
              getMonthsTime[0],
              function (memo, item) {
                return memo + item[productionPlan];
              },
              0
            );
            //  productionPlanForChart = productionPlanForChart / getDaysInYear[1];

            //2
            var productionFactForChart2 = _.reduce(
              getMonthsTime[1],
              function (memo, item) {
                return memo + item[productionFact];
              },
              0
            );

            //  productionFactForChart2 =              productionFactForChart2 / getDaysInYear[2];

            var productionPlanForChart2 = _.reduce(
              getMonthsTime[1],
              function (memo, item) {
                return memo + item[productionPlan];
              },
              0
            );
            //  productionPlanForChart2 =              productionPlanForChart2 / getDaysInYear[2];

            //3
            var productionFactForChart3 = _.reduce(
              getMonthsTime[2],
              function (memo, item) {
                return memo + item[productionFact];
              },
              0
            );

            //  productionFactForChart3 =              productionFactForChart3 / getDaysInYear[3];

            var productionPlanForChart3 = _.reduce(
              getMonthsTime[2],
              function (memo, item) {
                return memo + item[productionPlan];
              },
              0
            );
            //  productionPlanForChart3 =              productionPlanForChart3 / getDaysInYear[3];

            //4
            var productionFactForChart4 = _.reduce(
              getMonthsTime[3],
              function (memo, item) {
                return memo + item[productionFact];
              },
              0
            );

            // productionFactForChart4 =              productionFactForChart4 / getDaysInYear[4];

            var productionPlanForChart4 = _.reduce(
              getMonthsTime[3],
              function (memo, item) {
                return memo + item[productionPlan];
              },
              0
            );
            //  productionPlanForChart4 =              productionPlanForChart4 / getDaysInYear[4];

            //5
            var productionFactForChart5 = _.reduce(
              getMonthsTime[4],
              function (memo, item) {
                return memo + item[productionFact];
              },
              0
            );

            // productionFactForChart5 =              productionFactForChart5 / getDaysInYear[5];

            var productionPlanForChart5 = _.reduce(
              getMonthsTime[4],
              function (memo, item) {
                return memo + item[productionPlan];
              },
              0
            );
            // productionPlanForChart5 =              productionPlanForChart5 / getDaysInYear[5];

            //6
            var productionFactForChart6 = _.reduce(
              getMonthsTime[5],
              function (memo, item) {
                return memo + item[productionFact];
              },
              0
            );

            //productionFactForChart6 =              productionFactForChart6 / getDaysInYear[6];

            var productionPlanForChart6 = _.reduce(
              getMonthsTime[5],
              function (memo, item) {
                return memo + item[productionPlan];
              },
              0
            );
            // productionPlanForChart6 =              productionPlanForChart6 / getDaysInYear[6];

            //7
            var productionFactForChart7 = _.reduce(
              getMonthsTime[6],
              function (memo, item) {
                return memo + item[productionFact];
              },
              0
            );

            //productionFactForChart7 =              productionFactForChart7 / getDaysInYear[7];

            var productionPlanForChart7 = _.reduce(
              getMonthsTime[6],
              function (memo, item) {
                return memo + item[productionPlan];
              },
              0
            );
            //  productionPlanForChart7 =              productionPlanForChart7 / getDaysInYear[7];

            //8
            var productionFactForChart8 = _.reduce(
              getMonthsTime[7],
              function (memo, item) {
                return memo + item[productionFact];
              },
              0
            );

            //   productionFactForChart8 =              productionFactForChart8 / getDaysInYear[8];

            var productionPlanForChart8 = _.reduce(
              getMonthsTime[7],
              function (memo, item) {
                return memo + item[productionPlan];
              },
              0
            );
            // productionPlanForChart8 =              productionPlanForChart8 / getDaysInYear[8];

            //9
            var productionFactForChart9 = _.reduce(
              getMonthsTime[8],
              function (memo, item) {
                return memo + item[productionFact];
              },
              0
            );

            // productionFactForChart9 =              productionFactForChart9 / getDaysInYear[9];

            var productionPlanForChart9 = _.reduce(
              getMonthsTime[8],
              function (memo, item) {
                return memo + item[productionPlan];
              },
              0
            );
            //   productionPlanForChart9 =              productionPlanForChart9 / getDaysInYear[9];

            //10
            var productionFactForChart10 = _.reduce(
              getMonthsTime[9],
              function (memo, item) {
                return memo + item[productionFact];
              },
              0
            );

            //   productionFactForChart10 =              productionFactForChart10 / getDaysInYear[10];

            var productionPlanForChart10 = _.reduce(
              getMonthsTime[9],
              function (memo, item) {
                return memo + item[productionPlan];
              },
              0
            );
            // productionPlanForChart10 =              productionPlanForChart10 / getDaysInYear[10];

            //11
            var productionFactForChart11 = _.reduce(
              getMonthsTime[10],
              function (memo, item) {
                return memo + item[productionFact];
              },
              0
            );

            //  productionFactForChart11 =              productionFactForChart11 / getDaysInYear[11];

            var productionPlanForChart11 = _.reduce(
              getMonthsTime[10],
              function (memo, item) {
                return memo + item[productionPlan];
              },
              0
            );
            //productionPlanForChart11 =              productionPlanForChart11 / getDaysInYear[11];

            //12
            var productionFactForChart12 = _.reduce(
              getMonthsTime[11],
              function (memo, item) {
                return memo + item[productionFact];
              },
              0
            );

            //productionFactForChart12 =              productionFactForChart12 / getDaysInYear[12];

            var productionPlanForChart12 = _.reduce(
              getMonthsTime[11],
              function (memo, item) {
                return memo + item[productionPlan];
              },
              0
            );
            // productionPlanForChart12 =              productionPlanForChart12 / getDaysInYear[12];

            var productionFactForChartMonth = [];

            productionFactForChartMonth = [
              { productionFactForChart: Math.ceil(productionFactForChart) },
              { productionFactForChart: Math.ceil(productionFactForChart2) },
              { productionFactForChart: Math.ceil(productionFactForChart3) },
              { productionFactForChart: Math.ceil(productionFactForChart4) },
              { productionFactForChart: Math.ceil(productionFactForChart5) },
              { productionFactForChart: Math.ceil(productionFactForChart6) },
              { productionFactForChart: Math.ceil(productionFactForChart7) },
              { productionFactForChart: Math.ceil(productionFactForChart8) },
              { productionFactForChart: Math.ceil(productionFactForChart9) },
              { productionFactForChart: Math.ceil(productionFactForChart10) },
              { productionFactForChart: Math.ceil(productionFactForChart11) },
              { productionFactForChart: Math.ceil(productionFactForChart12) },
            ];

            var productionPlanForChartMonth = [];
            productionPlanForChartMonth = [
              { productionPlanForChart: Math.ceil(productionPlanForChart) },
              { productionPlanForChart: Math.ceil(productionPlanForChart2) },
              { productionPlanForChart: Math.ceil(productionPlanForChart3) },
              { productionPlanForChart: Math.ceil(productionPlanForChart4) },
              { productionPlanForChart: Math.ceil(productionPlanForChart5) },
              { productionPlanForChart: Math.ceil(productionPlanForChart6) },
              { productionPlanForChart: Math.ceil(productionPlanForChart7) },
              { productionPlanForChart: Math.ceil(productionPlanForChart8) },
              { productionPlanForChart: Math.ceil(productionPlanForChart9) },
              { productionPlanForChart: Math.ceil(productionPlanForChart10) },
              { productionPlanForChart: Math.ceil(productionPlanForChart11) },
              { productionPlanForChart: Math.ceil(productionPlanForChart12) },
            ];
          }

          //select data by
          if (this.selectedDMY == 1) {
            //select only for month
            var timestampMonthStart = new Date(
              this.monthes2[this.selectedMonth - 1] +
                //this.selectedDay +
                "1" +
                " " +
                SelectYearInMonth +
                " 06:00:00 GMT+0600"
            ).getTime();

            var dayInMonth2 = this.getDaysMonth().length;

            var dataWithMay = new Array();
            dataWithMay = _.filter(arrdata, function (item) {
              return _.every([
                _.inRange(
                  item.__time,
                  timestampMonthStart,
                  timestampMonthStart + 86400000 * dayInMonth2
                ),
              ]);
            });

            var dzo = [];
            var productionPlanForMonth = [];
            var productionFactForMonth = [];
            var __time2 = [];
            _.forEach(dataWithMay, function (item) {
              dzo.push(item.dzo);
              productionPlanForMonth.push({
                productionPlanForMonth: Math.ceil(item[productionPlan]),
              });
              productionFactForMonth.push({
                productionFactForMonth: Math.ceil(item[productionFact]),
              });
              __time2.push({
                timeMonth: new Date(item.__time).toLocaleString("ru", {
                  year: "numeric",
                  month: "numeric",
                  day: "numeric",
                  /*	weekday: 'long',
	timezone: 'UTC',
        hour: "numeric",
        minute: "numeric",*/
                  //second: 'numeric'
                }),
              });
            });

            var prod_wells_work = _.reduce(
              dataWithMay,
              function (memo, item) {
                return memo + item.prod_wells_work;
              },
              0
            );

            //   prod_wells_work = Math.ceil(prod_wells_work / dayInMonth);

            var prod_wells_idle = _.reduce(
              dataWithMay,
              function (memo, item) {
                return memo + item.prod_wells_idle;
              },
              0
            );
            // prod_wells_idle = Math.ceil(prod_wells_idle / dayInMonth);

            var starts_krs = _.reduce(
              dataWithMay,
              function (memo, item) {
                return memo + item.starts_krs;
              },
              0
            );
            // starts_krs = Math.ceil(starts_krs / dayInMonth);

            var starts_prs = _.reduce(
              dataWithMay,
              function (memo, item) {
                return memo + item.starts_prs;
              },
              0
            );
            //starts_prs = Math.ceil(starts_prs / dayInMonth);

            var starts_drl = _.reduce(
              dataWithMay,
              function (memo, item) {
                return memo + item.starts_drl;
              },
              0
            );
            //starts_drl = Math.ceil(starts_drl / dayInMonth);

            var inj_wells_idle = _.reduce(
              dataWithMay,
              function (memo, item) {
                return memo + item.inj_wells_idle;
              },
              0
            );
            //   inj_wells_idle = Math.ceil(inj_wells_idle / dayInMonth);

            var inj_wells_work = _.reduce(
              dataWithMay,
              function (memo, item) {
                return memo + item.inj_wells_work;
              },
              0
            );

            var prod_wells_work2 = [{ prod_wells_work: prod_wells_work }];

            var prod_wells_idle2 = [{ prod_wells_idle: prod_wells_idle }];
            var starts_krs2 = [{ starts_krs: starts_krs }];
            var starts_prs2 = [{ starts_prs: starts_prs }];
            var starts_drl2 = [{ starts_drl: starts_drl }];
            var inj_wells_idle2 = [{ inj_wells_idle: inj_wells_idle }];
            var inj_wells_work2 = [{ inj_wells_work: inj_wells_work }];
          }

          if (this.selectedDMY == 0) {
            arrdata = _.filter(arrdata, _.iteratee({ __time: timestamp }));
            /*if (arrdata.length == 0) {
            alert(
              "К сожалению на текущую дату нет данных, выберите другую дату"
            );
            } else {*/
            // }
            //select dzo filter

            var dzo = new Array();
            var liq_fact = new Array();
            var liq_plan = new Array();
            var time = new Array();
            var prod_wells_work = new Array();
            var prod_wells_idle = new Array();
            var starts_krs = new Array();
            var starts_prs = new Array();
            var starts_drl = new Array();
            var inj_wells_active = new Array();
            var inj_wells_idle = new Array();
            var inj_wells_work = new Array();
            var prod_wells_active = new Array();

            _.forEach(arrdata, function (item) {
              dzo.push(item.dzo);
              liq_fact.push(item[productionFact]);
              liq_plan.push(item[productionPlan]);
              time.push(item.__time);
              prod_wells_work.push(item.prod_wells_work);
              prod_wells_idle.push(item.prod_wells_idle);
              starts_krs.push(item.starts_krs);
              starts_prs.push(item.starts_prs);
              starts_drl.push(item.starts_drl);
              inj_wells_work.push(item.inj_wells_work);
              inj_wells_idle.push(item.inj_wells_idle);
            });

            //select only for day
            //Create massive with a part

            var liq_fact2 = new Array();
            _.each(liq_fact, function (fact) {
              fact = Math.ceil(fact);
              liq_fact2.push({ fact });
            });

            var liq_plan2 = new Array();
            _.each(liq_plan, function (plan) {
              plan = Math.ceil(plan); //okrugl vverh
              liq_plan2.push({ plan });
            });

            var __time2 = new Array();
            _.each(time, function (time) {
              //time = new Date(time).toLocaleDateString();
              //   time = new Date(time);
              __time2.push({ time });
            });

            var prod_wells_work2 = new Array();
            _.each(prod_wells_work, function (prod_wells_work) {
              prod_wells_work2.push({ prod_wells_work });
            });

            var prod_wells_idle2 = new Array();
            _.each(prod_wells_idle, function (prod_wells_idle) {
              prod_wells_idle2.push({ prod_wells_idle });
            });

            var starts_krs2 = new Array();
            _.each(starts_krs, function (starts_krs) {
              starts_krs2.push({ starts_krs });
            });

            var starts_prs2 = new Array();
            _.each(starts_prs, function (starts_prs) {
              starts_prs2.push({ starts_prs });
            });

            var starts_drl2 = new Array();
            _.each(starts_drl, function (starts_drl) {
              starts_drl2.push({ starts_drl });
            });

            var inj_wells_idle2 = new Array();
            _.each(inj_wells_idle, function (inj_wells_idle) {
              inj_wells_idle2.push({ inj_wells_idle });
            });

            var inj_wells_work2 = new Array();
            _.each(inj_wells_work, function (inj_wells_work) {
              inj_wells_work2.push({ inj_wells_work });
            });
          }

          //for year
          if (this.selectedDMY == 2) {
            var selectedYear = this.selectedYear;
            if (selectedYear === 2020) {
              selectedYear = "2020 (с начала года)";
            }
            var arrdataYear = new Array();
            arrdataYear = _.filter(
              data2,
              _.iteratee({ period: String(selectedYear) })
            );
            arrdataYear = _.filter(arrdataYear, _.iteratee({ dzo: company }));

            var dzo = new Array();
            var factYear = new Array();
            var planYear = new Array();

            var prod_wells_work_year = new Array();
            var prod_wells_idle_year = new Array();

            var inj_wells_idle_year = new Array();
            var inj_wells_work_year = new Array();

            var starts_krs_year = new Array();
            var starts_prs_year = new Array();
            var starts_drl_year = new Array();

            _.forEach(arrdataYear, function (item) {
              dzo.push(item.dzo);
              factYear.push(item[productionFact]);
              planYear.push(item[productionPlan]);
              prod_wells_work_year.push(item.prod_wells_work);
              prod_wells_idle_year.push(item.prod_wells_idle);
              inj_wells_idle_year.push(item.inj_wells_idle);
              inj_wells_work_year.push(item.inj_wells_work);
              starts_krs_year.push(item.starts_krs);
              starts_prs_year.push(item.starts_prs);
              starts_drl_year.push(item.starts_drl);
            });

            var arrdataYearChart = new Array();
            var arrdataYearChart = [];
            arrdataYearChart = _.filter(data2, _.iteratee({ dzo: company }));
            arrdataYearChart = _.orderBy(
              arrdataYearChart,
              ["period"],
              ["desk"]
            );

            var productionPlanForChartYear = new Array();
            _.forEach(arrdataYearChart, function (item) {
              productionPlanForChartYear.push({
                productionPlanForChartYear: Math.ceil(item[productionPlan]),
              });
            });

            var productionFactForChartYear = new Array();
            _.forEach(arrdataYearChart, function (item) {
              productionFactForChartYear.push({
                productionFactForChartYear: Math.ceil(item[productionFact]),
              });
            });

            //select only for year
            var factYear2 = new Array();
            _.each(factYear, function (factYear) {
              factYear = Math.ceil(factYear);
              factYear2.push({ factYear });
            });

            var planYear2 = new Array();
            _.each(planYear, function (planYear) {
              planYear = Math.ceil(planYear);
              planYear2.push({ planYear });
            });

            var prod_wells_work_year2 = new Array();
            _.each(prod_wells_work_year, function (prod_wells_work_year) {
              prod_wells_work_year2.push({ prod_wells_work_year });
            });

            var prod_wells_idle_year2 = new Array();
            _.each(prod_wells_idle_year, function (prod_wells_idle_year) {
              prod_wells_idle_year2.push({ prod_wells_idle_year });
            });

            var inj_wells_idle_year2 = new Array();
            _.each(inj_wells_idle_year, function (inj_wells_idle_year) {
              inj_wells_idle_year = Math.ceil(inj_wells_idle_year);
              inj_wells_idle_year2.push({ inj_wells_idle_year });
            });

            var inj_wells_work_year2 = new Array();
            _.each(inj_wells_work_year, function (inj_wells_work_year) {
              inj_wells_work_year = Math.ceil(inj_wells_work_year);
              inj_wells_work_year2.push({ inj_wells_work_year });
            });

            /* var dzoYear2 = new Array();
            _.each(dzoYear, function (dzoYear) {
              dzoYear2.push({ dzoYear });
            });*/

            var starts_krs_year2 = new Array();
            _.each(starts_krs_year, function (starts_krs_year) {
              starts_krs_year2.push({ starts_krs_year });
            });

            var starts_prs_year2 = new Array();
            _.each(starts_prs_year, function (starts_prs_year) {
              starts_prs_year2.push({ starts_prs_year });
            });

            var starts_drl_year2 = new Array();
            _.each(starts_drl_year, function (starts_drl_year) {
              starts_drl_year2.push({ starts_drl_year });
            });
          }

          //all variables
          var NameDzoFull = this.NameDzoFull;

          var dzo2 = new Array();
          var name;
          _.each(dzo, function (dzo) {
            if (String(dzo) === "ОМГ") {
              name = NameDzoFull[1];
            } else if (String(dzo) === "ММГ") {
              name = NameDzoFull[6];
            } else if (String(dzo) === "КТМ") {
              name = NameDzoFull[7];
            } else if (String(dzo) === "КОА") {
              name = NameDzoFull[8];
            } else if (String(dzo) === "КГМ") {
              name = NameDzoFull[4];
            } else if (String(dzo) === "КБМ") {
              name = NameDzoFull[3];
            }
            dzo = name;

            dzo2.push({ dzo });
          });

          var productionForChart = [{}];
          productionForChart = _.zipWith(
            _.sortBy(
              productionPlanForChart,
              (productionPlanForChart) =>
                productionPlanForChart.productionPlanForChart
            ),
            _.sortBy(
              productionFactForChart,
              (productionFactForChart) =>
                productionFactForChart.productionFactForChart
            ),

            _.sortBy(
              productionPlanForChartMonth,
              (productionPlanForChartMonth) =>
                productionPlanForChartMonth.productionPlanForChartMonth
            ),

            _.sortBy(
              productionFactForChartMonth,
              (productionFactForChartMonth) =>
                productionFactForChartMonth.productionFactForChartMonth
            ),

            _.sortBy(
              productionPlanForChartYear,
              (productionPlanForChartYear) =>
                productionPlanForChartYear.productionPlanForChartYear
            ),

            _.sortBy(
              productionFactForChartYear,
              (productionFactForChartYear) =>
                productionFactForChartYear.productionFactForChartYear
            ),

            (
              productionPlanForChart2,
              productionFactForChart2,
              productionPlanForChartMonth,
              productionFactForChartMonth,
              productionPlanForChartYear,
              productionFactForChartYear
            ) =>
              _.defaults(
                productionPlanForChart2,
                productionFactForChart2,
                productionPlanForChartMonth,
                productionFactForChartMonth,
                productionPlanForChartYear,
                productionFactForChartYear
              )
          );

          productionForChart = { data: productionForChart };
          this.productionForChart = productionForChart;

          var tables = _.zipWith(
            _.sortBy(dzo2, (dzo) => dzo.dzo),
            _.sortBy(liq_fact2, (liq_fact) => liq_fact.liq_fact),
            _.sortBy(liq_plan2, (liq_plan) => liq_plan.liq_plan),
            _.sortBy(__time2, (time) => time.time),
            _.sortBy(factYear2, (factYear) => factYear),
            _.sortBy(planYear2, (planYear) => planYear),
            _.sortBy(
              productionFactForMonth,
              (productionFactForMonth) => productionFactForMonth
            ),
            _.sortBy(
              productionPlanForMonth,
              (productionPlanForMonth) => productionPlanForMonth
            ),
            // _.sortBy(dzoYear2, (dzoYear) => dzoYear),
            (
              dzo,
              liq_fact,
              liq_plan,
              time,
              factYear,
              planYear, //, dzoYear
              productionFactForMonth,
              productionPlanForMonth
            ) =>
              _.defaults(
                dzo,
                liq_fact,
                liq_plan,
                time,
                factYear,
                planYear,
                //dzoYear,
                productionFactForMonth,
                productionPlanForMonth
              )
          );

          this.tables = tables;

          //VisualCenterChartDonutRight1.vue
          var wells2 = _.zipWith(
            _.sortBy(
              prod_wells_work2,
              (prod_wells_work) => prod_wells_work.prod_wells_work
            ),
            _.sortBy(
              prod_wells_idle2,
              (prod_wells_idle) => prod_wells_idle.prod_wells_idle
            ),
            _.sortBy(
              prod_wells_work_year2,
              (prod_wells_work_year) =>
                prod_wells_work_year.prod_wells_work_year
            ),
            _.sortBy(
              prod_wells_idle_year2,
              (prod_wells_idle_year) =>
                prod_wells_idle_year.prod_wells_idle_year
            ),
            (
              prod_wells_work,
              prod_wells_idle,
              prod_wells_work_year,
              prod_wells_idle_year
            ) =>
              _.defaults(
                prod_wells_work,
                prod_wells_idle,
                prod_wells_work_year,
                prod_wells_idle_year
              )
          );

          this.wells2 = wells2;

          var starts = _.zipWith(
            _.sortBy(starts_krs2, (starts_krs) => starts_krs.starts_krs),
            _.sortBy(starts_prs2, (starts_prs) => starts_prs.starts_prs),
            _.sortBy(starts_drl2, (starts_drl) => starts_drl.starts_drl),

            _.sortBy(
              starts_krs_year2,
              (starts_krs_year) => starts_krs_year.starts_krs_year
            ),
            _.sortBy(
              starts_prs_year2,
              (starts_prs_year) => starts_prs_year.starts_prs_year
            ),
            _.sortBy(
              starts_drl_year2,
              (starts_drl_year) => starts_drl_year.starts_drl_year
            ),

            (
              starts_krs,
              starts_prs,
              starts_drl,
              starts_krs_year,
              starts_prs_year,
              starts_drl_year
            ) =>
              _.defaults(
                starts_krs,
                starts_prs,
                starts_drl,
                starts_krs_year,
                starts_prs_year,
                starts_drl_year
              )
          );

          this.starts = starts;

          //VisualCenterChartDonutRight2.vue
          var wells = _.zipWith(
            _.sortBy(
              inj_wells_idle2,
              (inj_wells_idle) => inj_wells_idle.inj_wells_idle
            ),
            _.sortBy(
              inj_wells_work2,
              (inj_wells_work) => inj_wells_work.inj_wells_work
            ),

            _.sortBy(
              inj_wells_idle_year2,
              (inj_wells_idle_year) => inj_wells_idle_year.inj_wells_idle_year
            ),

            _.sortBy(
              inj_wells_work_year2,
              (inj_wells_work_year) => inj_wells_work_year.inj_wells_work_year
            ),

            (
              inj_wells_idle,
              inj_wells_work,
              inj_wells_idle_year,
              inj_wells_work_year
            ) =>
              _.defaults(
                inj_wells_idle,
                inj_wells_work,
                inj_wells_idle_year,
                inj_wells_work_year
              )
          );

          this.wells = wells;

          var buttonHover =
            "border: none;" +
            " background: url(../img/visualcenter/button-hover.png) no-repeat;" +
            "    background-size: 100% auto;" +
            " background-color: #1c6fb6;";

          if (productionPlan == "oil_plan") {
            this.buttonHover1 = buttonHover;
          } else {
            this.buttonHover1 = "";
          }
          if (productionPlan == "oil_dlv_plan") {
            this.buttonHover2 = buttonHover;
          } else {
            this.buttonHover2 = "";
          }

          if (productionPlan == "gas_plan") {
            this.buttonHover3 = buttonHover;
          } else {
            this.buttonHover3 = "";
          }

          if (productionPlan == "liq_plan") {
            this.buttonHover4 = buttonHover;
          } else {
            this.buttonHover4 = "";
          }

          if (productionPlan == "gk_plan") {
            this.buttonHover5 = buttonHover;
          } else {
            this.buttonHover5 = "";
          }

          if (productionPlan == "inj_plan") {
            this.buttonHover6 = buttonHover;
          } else {
            this.buttonHover6 = "";
          }
        } else {
          console.log("No data");
        }

        //bigtable
        //year
        var dataDay = [];
        var dataYear = [];
        var dzo = [];
        dataDay = data;
        dataYear = data2;
        var factYear = [];
        var planYear = [];
        var dataMonth = [];
        var dzoYear = [];
        dataMonth = _.filter(
          data2,
          _.iteratee({ period: "2020 (с начала года)" })
        );

        dataMonth = _.orderBy(dataMonth, ["dzo"], ["desc"]);

        _.forEach(dataMonth, function (item) {
          var e = [];
          e = { dzoYear: item.dzo };
          dzoYear.push(e);

          var f = [];
          f = { factYear: Math.ceil(item[productionFact]) };
          factYear.push(f);
          var p = [];
          p = { planYear: Math.ceil(item[productionPlan]) };
          planYear.push(p);
        });

        this.currentMonth = this.monthes3[this.month + 1];

        //console.log(timestampMonthStart);
        var selectedDay = this.selectedDay;
        var monthBigTable;
        var timestampToday;
        if (selectedDay == undefined) {
          timestampToday = new Date(
            this.monthes2["5"] + "15" + " " + this.year + " 06:00:00 GMT+0600"
          ).getTime();
          this.currentMonth = this.monthes3["6"];
          monthBigTable = "5";
        } else {
          timestampToday = new Date(
            this.monthes2[this.month] +
              this.selectedDay +
              " " +
              this.year +
              " 06:00:00 GMT+0600"
          ).getTime();
          monthBigTable = this.month;
        }

        /*
          
           if (this.selectedDMY == 1) {
            monthBigTable=this.selectedMonth-1;
           }*/

        var timestampMonthStart = new Date(
          //   this.monthes2[this.selectedMonth] + //change when data upgrade
          this.monthes2[monthBigTable] +
            //this.selectedDay +
            "1" +
            " " +
            SelectYearInMonth +
            " 06:00:00 GMT+0600"
        ).getTime();

        var dayInMonth = this.getDays().length;
        var dataWithMay = new Array();
        dataWithMay = _.filter(data, function (item) {
          return _.every([
            _.inRange(
              item.__time,
              timestampMonthStart,
              timestampToday + 86400000
            ),
          ]);
        });

        //console.log(timestampMonthStart);

        //Summ plan and fact from dzo
        var productionPlanAndFactMonth = _(dataWithMay)
          .groupBy("dzo")
          .map((dzo, id) => ({
            dzo: id,
            productionFactForChart: _.round(_.sumBy(dzo, productionFact), 0),
            productionPlanForChart: _.round(_.sumBy(dzo, productionPlan), 0),
          }))

          .value();

        productionPlanAndFactMonth = _.orderBy(
          productionPlanAndFactMonth,
          ["dzo"],
          ["desc"]
        );

        var productionForChart = _(dataWithMay)
          .groupBy("__time")
          .map((__time, id) => ({
            productionFactForChart: _.round(_.sumBy(__time, productionFact), 0),
            productionPlanForChart: _.round(_.sumBy(__time, productionPlan), 0),
          }))
          .value();

        var dzo2 = [];
        var planMonth = [];
        var factMonth = [];
        var oil_fact = [];
        var oil_plan = [];

        var e = [];
        var f = [];
        var p = [];
        var getMonthBigTable = [];
        _.forEach(dataWithMay, function (item) {
          e = { dzo2: item.dzo };
          f = { factMonth: Math.ceil(item[productionFact]) };
          p = { planMonth: Math.ceil(item[productionPlan]) };
          oil_fact = { oil_fact: item.oil_fact };
          oil_plan = { oil_plan: item.oil_plan };
          getMonthBigTable.push([e, f, p, oil_fact, oil_plan]);
        });

        var factMonth2 = _.reduce(
          factMonth,
          function (memo, item) {
            return memo + item.productionFact;
          },
          0
        );

        var planMonth = _.reduce(
          planMonth,
          function (memo, item) {
            return memo + item[productionPlan];
          },
          0
        );

        var dataDay = [];
        dataDay = _.filter(data, _.iteratee({ __time: timestampToday }));
        dataDay = _.orderBy(dataDay, ["dzo"], ["desc"]);

        var dzoDay = [];
        var factDay = [];
        var planDay = [];
        var getDayTable = [];
        var inj_wells_idle = [];
        var inj_wells_work = [];
        var prod_wells_work = [];
        var prod_wells_idle = [];
        var starts_krs = [];
        var starts_prs = [];
        var starts_drl = [];
        var NameDzoFull = this.NameDzoFull;
        _.forEach(dataDay, function (item) {
          if (String(item.dzo) === "ОМГ") {
            name = NameDzoFull[1];
          } else if (String(item.dzo) === "ММГ") {
            name = NameDzoFull[6];
          } else if (String(item.dzo) === "КТМ") {
            name = NameDzoFull[7];
          } else if (String(item.dzo) === "КОА") {
            name = NameDzoFull[8];
          } else if (String(item.dzo) === "КГМ") {
            name = NameDzoFull[4];
          } else if (String(item.dzo) === "КБМ") {
            name = NameDzoFull[3];
          }
          e = { dzoDay: name };
          f = { factDay: Math.ceil(item[productionFact]) };
          p = { planDay: Math.ceil(item[productionPlan]) };
          dzoDay.push(e);
          factDay.push(f);
          planDay.push(p);
          inj_wells_idle.push({ inj_wells_idle: item.inj_wells_idle });
          inj_wells_work.push({ inj_wells_work: item.inj_wells_work });
          prod_wells_work.push({ prod_wells_work: item.prod_wells_work });
          prod_wells_idle.push({ prod_wells_idle: item.prod_wells_idle });
          starts_krs.push({ starts_krs: item.starts_krs });
          starts_prs.push({ starts_prs: item.starts_prs });
          starts_drl.push({ starts_drl: item.starts_drl });
        });

        var starts_krs = _.reduce(
          starts_krs,
          function (memo, item) {
            return memo + item.starts_krs;
          },
          0
        );

        var starts_prs = _.reduce(
          starts_prs,
          function (memo, item) {
            return memo + item.starts_prs;
          },
          0
        );

        var starts_drl = _.reduce(
          starts_drl,
          function (memo, item) {
            return memo + item.starts_drl;
          },
          0
        );

        var inj_wells_idle = _.reduce(
          inj_wells_idle,
          function (memo, item) {
            return memo + item.inj_wells_idle;
          },
          0
        );

        var inj_wells_work = _.reduce(
          inj_wells_work,
          function (memo, item) {
            return memo + item.inj_wells_work;
          },
          0
        );

        var prod_wells_work = _.reduce(
          prod_wells_work,
          function (memo, item) {
            return memo + item.prod_wells_work;
          },
          0
        );

        var prod_wells_idle = _.reduce(
          prod_wells_idle,
          function (memo, item) {
            return memo + item.prod_wells_idle;
          },
          0
        );

        var dzoMonth = [];
        var factMonth = [];
        var planMonth = [];

        _.forEach(productionPlanAndFactMonth, function (item) {
          factMonth.push({ factMonth: item.productionFactForChart });
          planMonth.push({ planMonth: item.productionPlanForChart });
          dzoMonth.push({ dzoMonth: item.dzo });
        });

        //summ table value
        var factYearSumm = _.reduce(
          factYear,
          function (memo, item) {
            return memo + item.factYear;
          },
          0
        );

        var planYearSumm = _.reduce(
          planYear,
          function (memo, item) {
            return memo + item.planYear;
          },
          0
        );

        var planMonthSumm = _.reduce(
          planMonth,
          function (memo, item) {
            return memo + item.planMonth;
          },
          0
        );

        var factMonthSumm = _.reduce(
          factMonth,
          function (memo, item) {
            return memo + item.factMonth;
          },
          0
        );

        var factDaySumm = _.reduce(
          factDay,
          function (memo, item) {
            return memo + item.factDay;
          },
          0
        );

        var planDaySumm = _.reduce(
          planDay,
          function (memo, item) {
            return memo + item.planDay;
          },
          0
        );

        this.factYearSumm = factYearSumm;
        this.planYearSumm = planYearSumm;
        this.planMonthSumm = planMonthSumm;
        this.factMonthSumm = factMonthSumm;
        this.factDaySumm = factDaySumm;
        this.planDaySumm = planDaySumm;

        if (this.company == "all") {
          var bigTable = _.zipWith(
            dzoYear,
            dzoMonth,
            factYear,
            dzo,
            dzo2,
            planYear,
            planMonth,
            factMonth,
            dzoDay,
            factDay,
            planDay,
            (
              dzoYear,
              dzoMonth,
              factYear,
              dzo,
              dzo2,
              planYear,
              planMonth,
              factMonth,
              dzoDay,
              factDay,
              planDay
            ) =>
              _.defaults(
                dzoYear,
                dzoMonth,
                factYear,
                dzo,
                dzo2,
                planYear,
                planMonth,
                factMonth,
                dzoDay,
                factDay,
                planDay
              )
          );

          this.bigTable = bigTable;

          var wells = [];
          wells = _.zipWith(
            [{ inj_wells_idle: inj_wells_idle }],
            [{ inj_wells_work: inj_wells_work }],
            (inj_wells_idle, inj_wells_work) =>
              _.defaults(inj_wells_idle, inj_wells_work)
          );
          this.wells = wells;

          wells2 = _.zipWith(
            [{ prod_wells_work: prod_wells_work }],
            [{ prod_wells_idle: prod_wells_idle }],

            (prod_wells_work, prod_wells_idle) =>
              _.defaults(prod_wells_work, prod_wells_idle)
          );

          this.wells2 = wells2;

          var starts = _.zipWith(
            [{ starts_krs: starts_krs }],
            [{ starts_prs: starts_prs }],
            [{ starts_drl: starts_drl }],

            (prod_wells_work, prod_wells_idle) =>
              _.defaults(prod_wells_work, prod_wells_idle)
          );

          this.starts = starts;

          productionForChart = { data: productionForChart };
          this.productionForChart = productionForChart;
        }
      });

      this.showTable(localStorage.getItem("changeButton"));
    },

    changeButton(showTableItem, changeButton) {
      var a;
      if (changeButton == "Yes") {
        if (showTableItem == "Yes") {
          a = "No";
        } else {
          a = "Yes";
        }
        this.showTable2 = a;
        localStorage.setItem("changeButton", a);
      }
      this.showTable(localStorage.getItem("changeButton"));
    },

    showTable(showTableItem, changeButton) {
      var showTableOn =
        " border: none;" +
        "color: white;" +
        "background: url(../img/level1/button-on.png) no-repeat;" +
        "background-size: 16% auto;" +
        "background-position: 80% 50%;" +
        "outline: none;";

      if (showTableItem == "Yes") {
        this.ChartTable = "График";
        this.displayChart = "display:none;";

        if (this.company == "all") {
          this.displayHeadTables = "display: block";
          this.displayTable = "display:none;";
        } else {
          this.displayTable = "display:block;";
          this.displayHeadTables = "display: none";
        }
        this.showTableOn = ""; //colour button
      } else if (showTableItem == "No") {
        this.displayTable = "display:none;";
        this.displayHeadTables = "display: none";
        this.displayChart = "display:block;";
        this.ChartTable = "Таблица";
        this.displayHeadTables = "display: none";

        this.showTableOn = showTableOn; //colour button
      }
    },
  },

  created: function () {
    EventBus.$on("messageSend", this.displayMessage);
  },

  computed: {
    selectedDay2: function () {
      this.getProduction("oil_plan", "oil_fact", "Добыча нефти", "тн");
    },
    dayChange: function () {
      $("#ids").change(function () {
        alert("Works");
      });
      if (this.dFirstMonth == 0) {
        //this.day = ["Su", "Mn", "Tu", "We", "Th", "Fr", "Sa"];
        this.day = ["ВС", "ПН", "ВТ", "СР", "ЧТ", "ПТ", "СБ"];
      }
    },
  },
  async mounted() {
    this.selectedYear = this.year;
    var productionPlan = localStorage.getItem("production-plan");
    var productionFact = localStorage.getItem("production-fact");
    if (this.company == "all") {
      this.getProduction("oil_plan", "oil_fact", "Добыча нефти", "тн");
      this.changeButton("No");
    }
    localStorage.setItem("selectedDMY", "undefined");
  },
};
</script>
