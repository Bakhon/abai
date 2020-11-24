<template>
  <div>
    <div class="col-10 left-side">
      <div class="first-string">
        <div class="table-responsive">
          <table class="table table1">
            <tr>
              <td>
                <div class="nu">
                  <div class="number">
                    {{ new Intl.NumberFormat("ru-RU").format(oil_factDay) }}
                  </div>
                  <div class="unit-vc">тонн</div>
                </div>
                <div class="txt1">Добыча нефти</div>
                <br />
                <div class="progress">
                  <br />
                  <div
                    class="progress-bar"
                    role="progressbar"
                    :style="{
                      width: oil_factDayProgressBar + '%',
                    }"
                    :aria-valuenow="oil_planDay"
                    aria-valuemin="0"
                    :aria-valuemax="oil_factDay"
                  ></div>
                </div>
                <br />
                <div v-if="((oil_factDayPercent/oil_factDay-1) *100) > 0" class="arrow2">   
                </div>
                   <div v-if="((oil_factDayPercent/oil_factDay-1) *100) < 0" class="arrow3">   
                </div>     

                <div class="txt2" v-if="oil_factDay">{{ new Intl.NumberFormat("ru-RU").format(Math.abs((oil_factDayPercent/oil_factDay-1) *100).toFixed(2))  }}%</div>
                <div class="txt3">vs прошлый период</div>
              </td>
              <td>
                <div class="nu">
                  <div class="number">
                    {{ new Intl.NumberFormat("ru-RU").format(oil_dlv_factDay) }}
                  </div>
                  <div class="unit-vc">тн</div>
                </div>
                <div class="txt1">Сдача нефти</div>
                <br />
                <div class="progress">
                  <br />
                  <div
                    class="progress-bar"
                    role="progressbar"
                    :style="{
                      width: oil_dlv_factDayProgressBar + '%',
                    }"
                    :aria-valuenow="oil_dlv_factDay"
                    aria-valuemin="0"
                    :aria-valuemax="oil_dlv_planDay"
                  ></div>
                </div>
                <br />
                 <div v-if="((oil_dlv_factDayPercent/oil_dlv_factDay-1) *100) > 0" class="arrow2">   
                </div>
                   <div v-if="((oil_dlv_factDayPercent/oil_dlv_factDay-1) *100) < 0" class="arrow3">   
                </div>  

                <div class="txt2" v-if="gas_factDay">{{ new Intl.NumberFormat("ru-RU").format(Math.abs((oil_dlv_factDayPercent/oil_dlv_factDay-1) *100).toFixed(2))  }}%</div>
                <div class="txt3">vs прошлый период</div>                
              </td>
              <td>
                <div class="nu">
                  <div class="number">
                    {{ new Intl.NumberFormat("ru-RU").format(gas_factDay) }} 
                  </div>
                  <div class="unit-vc">млрд. м³</div>
                </div>
                <div class="txt1">Добыча газа</div>
                <br />
                <div class="progress">
                  <br />

                  <div
                    class="progress-bar"
                    role="progressbar"
                    :style="{
                      width: gas_factDayProgressBar + '%',
                    }"
                    :aria-valuenow="gas_factDay"
                    aria-valuemin="0"
                    :aria-valuemax="gas_planDay"
                  ></div>
                </div>
                <br />
                        <div v-if="((gas_factDayPercent/gas_factDay-1) *100) > 0" class="arrow2">   
                </div>
                   <div v-if="((gas_factDayPercent/gas_factDay-1) *100) < 0" class="arrow3">   
                </div>  

                <div class="txt2" v-if="gas_factDay">{{ new Intl.NumberFormat("ru-RU").format(Math.abs((gas_factDayPercent/gas_factDay-1) *100).toFixed(2))  }}%</div>
                <div class="txt3">vs прошлый период</div> 
              </td>
              <td
                style="width: 200px; border-left: 10px solid #0f1430;"
                @click="changeTable('2')"
                :style="`${tableHover2}`"
              >
                <div class="nu">
                  <div class="number">{{ oilNow }}</div>
                  <div class="unit-vc">$ / bbl</div>
                </div>
                <div class="txt1">Цена на нефть</div>
                <br /><br />
                <div class="arrow"></div>
                <div class="txt2">5,2%</div>
                <div class="txt3">vs сентябрь</div>
              </td>
              <td
                style="width: 200px; border-left: 10px solid #0f1430;"
                @click="changeTable('3')"
                :style="`${tableHover3}`"
              >
                <div class="nu">
                  <div class="number">{{ currencyNow }}</div>
                  <div class="unit-vc">kzt / $</div>
                </div>
                <div class="txt1">Курс доллара</div>

                <br /><br />
                <div class="arrow"></div>
                <div class="txt2">5,2%</div>
                <div class="txt3">vs сентябрь</div>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div class="first-table" :style="`${Table1}`">
        <div class="first-string first-string2">
          <div class="container-fluid">
            <!--class="table-responsive"-->
            <table class="table table2">
              <tr>
                <td class="dropdown3">
                  <input type="checkbox" id="menu" />

                  <div
                    class="button1"
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
                    <!-- <label for="menu">-->
                    <div class="icon-all icons1"></div>
                    <div class="txt5">Добыча нефти</div>
                    <div class="txt6">тыс. тн</div>
                    <!--   </label>-->
                  </div>

                  <!-- <div class="dropdown">-->

                  <ul>
                    <li class="center-li" @click="changeMenu('101')">
                      <a>С учётом доли участия КМГ</a>

                      <div
                        class="square-small2"
                        :style="`${changeMenuButton1}`"
                      >
                        &#10003;
                      </div>
                    </li>
                  </ul>
                </td>
                <td class="dropdown3">
                  <div
                    class="button1"
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
                    <div class="icon-all icons2"></div>
                    <div class="txt5">Сдача нефти</div>
                    <div class="txt6">тыс. тонн</div>
                  </div>

                  <ul>
                    <li class="center-li" @click="changeMenu('102')">
                      <a>Сдача нефти по узлам учёта</a>
                      <div
                        class="square-small2"
                        :style="`${changeMenuButton2}`"
                      >
                        &#10003;
                      </div>
                    </li>

                    <li class="center-li" @click="changeMenu('103')">
                      <a>Товарный остаток нефти</a>
                      <div
                        class="square-small2"
                        :style="`${changeMenuButton3}`"
                      >
                        &#10003;
                      </div>
                    </li>
                  </ul>
                </td>
                <td class="dropdown3">
                  <div
                    class="button1"
                    :style="`${buttonHover3}`"
                    @click="
                      getProduction(
                        'gas_plan',
                        'gas_fact',
                        'Добыча газа',
                        'тыс м³'
                      )
                    "
                  >
                    <div class="icon-all icons3"></div>
                    <div class="txt5">Добыча газа</div>
                    <div class="txt6">млрд. м³</div>
                  </div>
                  <ul>
                    <li class="center-li">
                      <a href> Сдача природного газа</a>
                    </li>
                    <li class="center-li">
                      <a href>Расход природного газа на собственные нужды </a>
                    </li>
                    <li class="center-li">
                      <a href>Переработка природного газа</a>
                    </li>
                    <li class="center-li"><a href>Сдача попутного газа </a></li>
                    <li class="center-li">
                      <a href>Расход попутного газа на собственные нужды </a>
                    </li>
                    <li class="center-li">
                      <a href> Переработка попутного газа </a>
                    </li>
                  </ul>
                </td>
                <td class="dropdown3">
                  <div
                    class="button1"
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
                    <div class="icon-all icons4"></div>
                    <div class="txt5">Добыча конденсата</div>
                    <div class="txt6">тыс. тонн</div>
                  </div>
                  <ul>
                    <li class="center-li">
                      <a href>С учётом доли участия КМГ</a>
                    </li>
                  </ul>
                </td>
                <td class="dropdown3">
                  <div
                    class="button1"
                    :style="`${buttonHover6}`"
                    @click="
                      getProduction(
                        'inj_plan',
                        'inj_fact',
                        'Объём закачки',
                        'м³'
                      )
                    "
                  >
                    <div class="icon-all icons5"></div>
                    <div class="txt5">Объём закачки воды</div>
                    <div class="txt6">тыс. м³</div>
                  </div>
                  <ul>
                    <li class="center-li"><a href> Закачка морской воды</a></li>
                    <li class="center-li"><a href>Закачка сточной воды</a></li>
                    <li class="center-li"><a href>Закачка альбсен. воды</a></li>
                  </ul>
                </td>
              </tr>
            </table>
          </div>

          <div class="container-fluid">
            <table class="table table2">
              <tr>
                <td>
                  <div
                    class="button2"
                    :style="`${buttonHover7}`"
                    @click="changeMenu2(1)"
                  >
                    Суточная
                  </div>
                </td>
                <td>
                  <div
                    class="button2"
                    :style="`${buttonHover8}`"
                    @click="changeMenu2(2)"
                  >
                    С начала месяца
                  </div>
                </td>
                <td>
                  <div
                    class="button2"
                    :style="`${buttonHover9}`"
                    @click="changeMenu2(3)"
                  >
                    С начала года
                  </div>
                </td>
                <td class="dropdown3">
                  <div
                    class="button2"
                    :style="`${buttonHover10}`"
                    @click="changeMenu2(4)"
                  >
                    Календарь
                  </div>
                  <ul class="center-menu2">
                    <li class="center-li">
                       <!--<div
                        class="calendar-tab"
                        v-for="(menuDMY, index) in menuDMY()"
                        @click="selectedDMY = menuDMY.id"
                        :style="{
                          'background-color': menuDMY.current,
                        }"
                      >
                     {{ menuDMY.DMY }}
                      </div>-->
                      <br /><br />

                      <div class="month-day">
                        <div class="calendar-day">
                          <date-picker
                            v-if="selectedDMY == 0"
                            mode="range"
                            v-model="range"
                            is-range
                            class="m-auto"
                            :model-config="modelConfig"
                            @input="changeDate"
                          />
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
                      </div>
                    </li>
                  </ul>
                </td>
              </tr>

              <tr>
                <td>
                  <div
                    class="assets4"
                    :style="`${buttonHover11}`"
                    @click="changeAssets('b11')"
                  >
                    Операционные активы
                  </div>
                </td>

                <td colspan="2">
                  <div
                    class="assets4"
                    :style="`${buttonHover12}`"
                    @click="changeAssets('b12')"
                  >
                    Неоперационные активы
                  </div>
                </td>

                <td>
                  <div
                    class="assets4"
                    :style="`${buttonHover13}`"
                    @click="changeAssets('b13')"
                  >
                    Все активы КМГ
                  </div>
                </td>
              </tr>
            </table>
          </div>

          <div :style="`${displayTable}`">
            <div
              class="container-fluid w-50 table-near-chart2 table-responsive"
            >
              <table class="table4-2">
                <tbody>
                  <tr>
                    <td class="big-table-hidtd small-td"></td>

                    <td class="small-td">
                      <div class="center">план</div>
                    </td>
                    <td class="small-td">
                      <div class="center">факт</div>
                    </td>
                    <td class="small-td">
                      <div class="center">+/-</div>
                    </td>
                    <td class="small-td"><div class="center">%</div></td>
                  </tr>

                  <tr v-for="(item, index) in tables">
                    <td
                      @click="saveCompany('all')"
                      :class="index % 2 === 0 ? 'tdStyle' : 'tdNone first-td'"
                    >
                      <div class="first-td">{{ item.dzo |dzo }}</div>
                    </td>

                    <td
                      :class="
                        index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'
                      "
                    >
                      <!--old date-->
                      <div v-if="item.productionPlanForMonth">
                        {{ (new Intl.NumberFormat('ru-RU').format(item.productionPlanForMonth)) }}
                      </div>

                      <div v-if="item.planYear">
                        {{ (new Intl.NumberFormat('ru-RU').format(item.planYear)) }}
                      </div>
                      <!--old date-->

                      <div class="font" v-if="item.plan">
                        {{ new Intl.NumberFormat("ru-RU").format(item.plan) }}
                        <div class="right">{{ item4 }}</div>
                      </div>
                    </td>
                    <td :class="index % 2 === 0 ? 'tdStyle' : 'tdNone'">
                      <!--old date-->
                      <div v-if="item.productionFactForMonth">
                        {{ (new Intl.NumberFormat('ru-RU').format(item.productionFactForMonth)) }}
                      </div>

                      <div v-if="item.factYear">
                        {{ (new Intl.NumberFormat('ru-RU').format(item.factYear ))}}
                      </div>
                      <!--old date-->

                      <div class="font" v-if="item.fact">
                        {{ new Intl.NumberFormat("ru-RU").format(item.fact) }}
                        <div class="right">{{ item4 }}</div>
                      </div>
                    </td>
                    <td
                      :class="
                        index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'
                      "
                    >
                      <div
                        v-if="item.fact"
                        class="triangle2"
                        :style="`${getColor(item.fact - item.plan)}`"
                      ></div>
                      <div class="percent font" v-if="item.fact">
                        {{
                          new Intl.NumberFormat("ru-RU").format(
                            Math.abs(item.fact - item.plan)
                          )
                        }}
                        <div class="right">{{ item4 }}</div>
                      </div>
                    </td>
                    <td :class="index % 2 === 0 ? 'tdStyle' : 'tdNone'">
                      <div
                        v-if="item.fact"
                        class="triangle2"
                        :style="`${getColor(item.fact - item.plan)}`"
                      ></div>
                      <div class="percent font">5,2%</div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="w-50 vc-chart">
              <vc-chart v-if="company != 'all'"> </vc-chart>
            </div>
          </div>
          <div class="background-center" :style="`${displayHeadTables}`">
            <div class="container-fluid w-50 table-near-chart2">
              <table class="table4">
                <tbody>
                  <tr>
                    <td class="big-table-hidtd small-td"></td>

                    <td class="small-td">
                      <div class="center">план</div>
                    </td>
                    <td class="small-td">
                      <div class="center">факт</div>
                    </td>
                    <td class="small-td">
                      <div class="center">+/-</div>
                    </td>
                    <td class="small-td"><div class="center">%</div></td>
                  </tr>

                  <tr v-for="(item, index) in bigTable">
                    <td
                      @click="saveCompany(item.dzoMonth)"
                      :class="index % 2 === 0 ? 'tdStyle' : 'tdNone first-td'"
                    >
                      <div class="first-td" >{{getNameDzoFull(item.dzoMonth) }}   </div>
                    </td>

                    <td
                      :class="
                        index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'
                      "
                    >
                      <div class="font" v-if="item.planMonth">
                        <!-- {{
                          new Intl.NumberFormat("ru-RU").format(item.planDay)
                        }}-->

                        {{
                          new Intl.NumberFormat("ru-RU").format(item.planMonth)
                        }}

                        <div class="right">{{ item4 }}</div>
                      </div>
                    </td>
                    <td :class="index % 2 === 0 ? 'tdStyle' : 'tdNone'">
                      <div class="font" v-if="item.factMonth">
                        <!--  {{
                          new Intl.NumberFormat("ru-RU").format(item.factDay)
                        }}-->

                        {{
                          new Intl.NumberFormat("ru-RU").format(item.factMonth)
                        }}

                        <div class="right">{{ item4 }}</div>
                      </div>
                    </td>
                    <td
                      :class="
                        index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'
                      "
                    >
                      <div
                        v-if="item.factMonth"
                        class="triangle"
                        :style="`${getColor(item.factMonth - item.planMonth)}`"
                      ></div>
                      <div class="percent font" v-if="item.factMonth">
                        {{
                          new Intl.NumberFormat("ru-RU").format(
                            Math.abs(item.factMonth - item.planMonth)
                          )
                        }}
                       <!-- <div class="right">{{ item4 }}</div>-->
                      </div>
                    </td>
                    <td :class="index % 2 === 0 ? 'tdStyle' : 'tdNone'">
                      <div
                        v-if="item.factMonth"
                        class="triangle"
                        :style="`${getColor((item.factMonth/item.productionFactPercent-1) *100)}`"
                      ></div>
                      <div class="percent font" v-if="item.productionFactPercent">
                     
                      {{new Intl.NumberFormat("ru-RU").format(Math.abs((item.productionFactPercent/item.factMonth-1) *100).toFixed(2))  }} %
                      </div>
                    </td>
                  </tr>

                  <!--  <tr>
                <td colspan="13">1</td>
              </tr>

              <tr>
                <td>2</td>
              </tr>

              <tr>
                <td colspan="13">3</td>
              </tr>-->

                  <tr>
                    <td :class="index % 2 === 0 ? 'tdStyle3-total' : 'tdNone'">
                      <div class="first-td">{{ NameDzoFull[0] }}</div>
                    </td>

                    <td
                      :class="
                        index % 2 === 0 ? 'tdStyleLight3' : 'tdStyleLight2'
                      "
                    >
                      <div class="font">
                        <!--{{ new Intl.NumberFormat("ru-RU").format(planDaySumm) }}-->

                        {{
                          new Intl.NumberFormat("ru-RU").format(planMonthSumm)
                        }}

                        <div class="right">{{ item4 }}</div>
                      </div>
                    </td>
                    <td :class="index % 2 === 0 ? 'tdStyle3' : 'tdNone'">
                      <div class="font">
                        <!-- {{ new Intl.NumberFormat("ru-RU").format(factDaySumm) }}-->
                        {{
                          new Intl.NumberFormat("ru-RU").format(factMonthSumm)
                        }}
                        <div class="right">{{ item4 }}</div>
                      </div>
                    </td>
                    <td
                      :class="
                        index % 2 === 0 ? 'tdStyleLight3' : 'tdStyleLight2'
                      "
                    >
                      <div
                        v-if="factMonthSumm"
                        class="triangle"
                        :style="`${getColor(factMonthSumm - planMonthSumm)}`"
                      ></div>
                      <div class="percent font">
                        {{
                          new Intl.NumberFormat("ru-RU").format(
                            Math.abs(factMonthSumm - planMonthSumm)
                          )
                        }}

                        <!--<div class="right">{{ item4 }}</div>-->
                      </div>
                    </td>
                    <td :class="index % 2 === 0 ? 'tdStyle3' : 'tdNone'">
                      <div
                        v-if="factMonthSumm"
                        class="triangle"
                       :style="`${getColor((factMonthSumm/productionFactPercentSumm-1) *100)}`"
                      ></div>
                      <div class="percent font"v-if="factMonthSumm">
                     
                      {{new Intl.NumberFormat("ru-RU").format(Math.abs((productionFactPercentSumm/factMonthSumm-1) *100).toFixed(2))  }} %</div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="w-50 vc-chart">
              <vc-chart v-if="company == 'all'"> </vc-chart>
            </div>
          </div>
        </div>
      </div>

      <div class="second-table" :style="`${Table2}`">
        <div class="first-string first-string2">
          <div class="close2" @click="changeTable('1')">Закрыть</div>
          <div class="big-area">
            <br />

            <div
              @click="selectedDMY = menuDMY.id"
              class="period"
              v-for="(menuDMY, index) in periodSelectFunc()"
              :style="{
                color: menuDMY.current,
              }"
              v-on:click="periodSelect"
            >
              <div>{{ menuDMY.DMY }}</div>
            </div>
            <visual-center-chart-area-oil3></visual-center-chart-area-oil3>
          </div>
        </div>
      </div>

      <div class="third-table" :style="`${Table3}`">
        <div class="first-string first-string2">
          <div class="close2" @click="changeTable('1')">Закрыть</div>
          <div class="big-area">
            <br />

            <div
              @click="selectedDMY2 = menuDMY.id"
              class="period"
              v-for="(menuDMY, index) in periodSelectFunc()"
              :style="{
                color: menuDMY.current2,
              }"
              v-on:click="periodSelectUSD"
            >
              <div>{{ menuDMY.DMY }}</div>
            </div>
            <visual-center-chart-area-usd3></visual-center-chart-area-usd3>
          </div>
        </div>
      </div>

      <div class="third-table" :style="`${Table4}`">
        <div class="first-string first-string2">
          <div class="close2" @click="changeTable('1')">Закрыть</div>
          <div class="big-area">Фонд добывающих скважин</div>
        </div>
      </div>

      <div class="third-table" :style="`${Table5}`">
        <div class="first-string first-string2">
          <div class="close2" @click="changeTable('1')">Закрыть</div>
          <div class="big-area">Фонд нагнетательных скважин</div>
        </div>
      </div>

      <div class="third-table" :style="`${Table6}`">
        <div class="first-string first-string2">
          <div class="close2" @click="changeTable('1')">Закрыть</div>
          <div class="big-area">ОТМ</div>
        </div>
      </div>

      <div class="third-table" :style="`${Table7}`">
        <div class="first-string first-string2">
          <div class="close2" @click="changeTable('1')">Закрыть</div>
          <div class="big-area">Химизация</div>
        </div>
      </div>
    </div>
    <div class="col-2 right-side2">
      <div class="first-string">
        <div class="table-responsive">
          <table class="table table1-2">
            <tr>
              <td
                class="w-50"
                @click="changeTable('4')"
                :style="`${tableHover4}`"
              >
                <div class="txt4" v-if="wells2[0].prod_wells_work">
                  {{
                    new Intl.NumberFormat("ru-RU").format(
                      wells2[0].prod_wells_work
                    )
                  }}
                </div>
                <div class="in-work">В работе</div>
                <div class="arrow"></div>
                <div class="txt2">48</div>
              </td>

              <td
                class="w-50"
                @click="changeTable('4')"
                :style="`${tableHover4}`"
              >
                <div class="txt4" v-if="wells2[0].prod_wells_idle">
                  {{
                    new Intl.NumberFormat("ru-RU").format(
                      wells2[0].prod_wells_idle
                    )
                  }}
                </div>
                <div class="in-idle">В простое</div>
                <div class="arrow"></div>
                <div class="txt2">200</div>
                <br />
              </td>
            </tr>
            <tr>
              <td
                colspan="2"
                @click="changeTable('4')"
                :style="`${tableHover4}`"
              >
                <div class="txt2">Фонд добывающих скважин</div>
              </td>
            </tr>
          </table>
          <!-- <div class="line-bottom"></div>-->
        </div>
        <div class="first-string first-string2">
          <div class="table-responsive">
            <table class="table table1-2">
              <tr>
                <td
                  class="w-50"
                  @click="changeTable('5')"
                  :style="`${tableHover5}`"
                >
                  <div class="txt4" v-if="wells[0].inj_wells_work">
                    {{
                      new Intl.NumberFormat("ru-RU").format(
                        wells[0].inj_wells_work
                      )
                    }}
                  </div>
                  <div class="in-work">В работе</div>
                  <div class="arrow"></div>
                  <div class="txt2">48</div>
                </td>

                <td
                  class="w-50"
                  @click="changeTable('5')"
                  :style="`${tableHover5}`"
                >
                  <div class="txt4" v-if="wells[0].inj_wells_idle">
                    {{
                      new Intl.NumberFormat("ru-RU").format(
                        wells[0].inj_wells_idle
                      )
                    }}
                  </div>
                  <div class="in-idle">В простое</div>
                  <div class="arrow"></div>
                  <div class="txt2">200</div>
                  <br />
                </td>
              </tr>
              <tr>
                <td
                  colspan="2"
                  @click="changeTable('5')"
                  :style="`${tableHover5}`"
                >
                  <div class="txt2">Фонд нагнетательных скважин</div>
                </td>
              </tr>
            </table>
          </div>
        </div>

        <div class="first-string first-string2">
          <div class="table-responsive">
            <table class="table table5">
              <tr>
                <td
                  class="w-50"
                  @click="changeTable('6')"
                  :style="`${tableHover6}`"
                >
                  <div class="otm"></div>
                  <div class="txt2">ОТМ</div>
                </td>

                <td
                  class="w-50"
                  @click="changeTable('7')"
                  :style="`${tableHover7}`"
                >
                  <div class="him"></div>
                  <div class="txt2">Химизация</div>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>

      <div class="first-string first-string2">
        <div class="table-responsive">
          <table class="table">
            <tr>
              <td class="size-td">
                <div class="number">908</div>
              </td>

              <td class="w-65">
                <div class="column-1">
                  <div class="arrow"></div>
                  <div class="txt2">7</div>
                </div>
                <div class="column-1">
                  <div class="in-idle">Прирост</div>
                  <div class="in-idle">с начала месяца</div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <div class="txt2">Численность персонала</div>
              </td>
            </tr>
          </table>
        </div>
      </div>

      <div class="first-string first-string2">
        <div class="table-responsive">
          <table class="table">
            <tr>
              <td class="size-td">
                <div class="number">24</div>
              </td>

              <td class="w-65">
                <div class="column-1">
                  <div class="arrow"></div>
                  <div class="txt2">11</div>
                </div>
                <div class="column-1">
                  <div class="in-idle">Прирост</div>
                  <div class="in-idle">с начала месяца</div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <div class="txt2">COVID-19</div>
              </td>
            </tr>
          </table>
        </div>
      </div>

      <div class="first-string first-string2">
        <div class="table-responsive">
          <table class="table table1-2">
            <tr>
              <td class="w-50">
                <div class="number">11</div>
                <div class="near-number">
                  <!-- <div class="column-1">
                    <div class="arrow"></div>
                    <div class="txt2">7</div>
                  </div>-->
                  <div class="column-1">
                    <!-- <div class="in-idle">Прирост</div>-->
                    <div class="in-idle">с начала</div>
                    <div class="in-idle">месяца</div>
                  </div>
                </div>
              </td>

              <td class="w-50">
                <div class="number">11</div>
                <div class="near-number">
                  <!--  <div class="column-1">
                    <div class="arrow"></div>
                    <div class="txt2">7</div>
                  </div>-->
                  <div class="column-1">
                    <!--<div class="in-idle">Прирост</div>-->
                    <div class="in-idle">с начала</div>
                    <div class="in-idle">года</div>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <div class="txt2">Несчастные случаи</div>
              </td>
            </tr>
          </table>
        </div>
      </div>

      <div class="first-string first-string2">
        <div class="table-responsive">
          <table class="table">
            <tr>
              <td class="size-td">
                <div class="number">2</div>
              </td>

              <td class="w-65">
                <!--  <div class="column-1">
                  <div class="arrow"></div>
                  <div class="txt2">1</div>
                </div>-->
                <div class="column-1">
                  <div class="in-idle">Прирост</div>
                  <div class="in-idle">с начала месяца</div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <div class="txt2">Смертельные случаи</div>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script src="./VisualCenterTable3.js"></script>
