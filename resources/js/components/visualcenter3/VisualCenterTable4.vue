<template>
  <div>
    <div class="left-side">
      <div class="first-string">
        <div class="table-responsive">
          <table class="table table1-2">
            <tr>
              <td>
                <div class="first-td-header">
                  <div class="nu">
                    <div class="number">
                      {{ new Intl.NumberFormat("ru-RU").format(oil_fact) }}
                    </div>
                    <div class="unit-vc">тыс. тонн</div>
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
                  <div class="percent-header" v-if="oil_factDay">
                    {{
                      (
                        100 -
                        (oil_factDayPercent / oil_factDay - 1) * 100
                      ).toFixed(2)
                    }}%
                  </div>
                  <div class="plan-header" v-if="oil_planDay">
                    {{ new Intl.NumberFormat("ru-RU").format(oil_planDay) }}
                  </div>
                  <br />
                  <div
                    v-if="(oil_factDayPercent / oil_factDay - 1) * 100 > 0"
                    class="arrow2"
                  ></div>
                  <div
                    v-if="(oil_factDayPercent / oil_factDay - 1) * 100 < 0"
                    class="arrow3"
                  ></div>
                  <div class="header-bottom">
                    <div class="txt2" v-if="oil_factDay">
                      {{
                        new Intl.NumberFormat("ru-RU").format(
                          Math.abs(
                            (oil_factDayPercent / oil_factDay - 1) * 100
                          ).toFixed(2)
                        )
                      }}%
                    </div>
                    <div class="txt3">vs {{ lastMonth }}</div>
                  </div>
                </div>
              </td>

              <td>
                <div class="first-td-header">
                  <div class="nu">
                    <div class="number">
                      {{ new Intl.NumberFormat("ru-RU").format(proceeds) }}
                    </div>
                    <div class="unit-vc">млрд. тенге</div>
                  </div>
                  <div class="txt1">Выручка/Доход</div>
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
                  <div class="percent-header" v-if="oil_factDay">
                    {{
                      (
                        100 -
                        (oil_factDayPercent / oil_factDay - 1) * 100
                      ).toFixed(2)
                    }}%
                  </div>
                  <div class="plan-header" v-if="oil_planDay">
                    {{ new Intl.NumberFormat("ru-RU").format(oil_planDay) }}
                  </div>
                  <br />
                  <div
                    v-if="(oil_factDayPercent / oil_factDay - 1) * 100 > 0"
                    class="arrow2"
                  ></div>
                  <div
                    v-if="(oil_factDayPercent / oil_factDay - 1) * 100 < 0"
                    class="arrow3"
                  ></div>
                  <div class="header-bottom">
                    <div class="txt2" v-if="oil_factDay">
                      {{
                        new Intl.NumberFormat("ru-RU").format(
                          Math.abs(
                            (oil_factDayPercent / oil_factDay - 1) * 100
                          ).toFixed(2)
                        )
                      }}%
                    </div>
                    <div class="txt3">vs от плана</div>
                  </div>
                </div>
              </td>

              <td>
                <div class="first-td-header">
                  <div class="nu">
                    <div class="number">
                      {{ new Intl.NumberFormat("ru-RU").format(costs) }}
                    </div>
                    <div class="unit-vc">млрд. тенге</div>
                  </div>
                  <div class="txt1">Расходы</div>
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
                  <div class="percent-header" v-if="oil_factDay">
                    {{
                      (
                        100 -
                        (oil_factDayPercent / oil_factDay - 1) * 100
                      ).toFixed(2)
                    }}%
                  </div>
                  <div class="plan-header" v-if="oil_planDay">
                    {{ new Intl.NumberFormat("ru-RU").format(oil_planDay) }}
                  </div>
                  <br />
                  <div
                    v-if="(oil_factDayPercent / oil_factDay - 1) * 100 > 0"
                    class="arrow2"
                  ></div>
                  <div
                    v-if="(oil_factDayPercent / oil_factDay - 1) * 100 < 0"
                    class="arrow3"
                  ></div>
                  <div class="header-bottom">
                    <div class="txt2" v-if="oil_factDay">
                      {{
                        new Intl.NumberFormat("ru-RU").format(
                          Math.abs(
                            (oil_factDayPercent / oil_factDay - 1) * 100
                          ).toFixed(2)
                        )
                      }}%
                    </div>
                    <div class="txt3">vs от плана</div>
                  </div>
                </div>
              </td>

              <td>
                <div class="first-td-header">
                  <div class="nu">
                    <div class="number">
                      {{ new Intl.NumberFormat("ru-RU").format(net_profit) }}
                    </div>
                    <div class="unit-vc">млрд. тенге</div>
                  </div>
                  <div class="txt1">Чистая прибыль</div>
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
                  <div class="percent-header" v-if="oil_factDay">
                    {{
                      (
                        100 -
                        (oil_factDayPercent / oil_factDay - 1) * 100
                      ).toFixed(2)
                    }}%
                  </div>
                  <div class="plan-header" v-if="oil_planDay">
                    {{ new Intl.NumberFormat("ru-RU").format(oil_planDay) }}
                  </div>
                  <br />
                  <div
                    v-if="(oil_factDayPercent / oil_factDay - 1) * 100 > 0"
                    class="arrow2"
                  ></div>
                  <div
                    v-if="(oil_factDayPercent / oil_factDay - 1) * 100 < 0"
                    class="arrow3"
                  ></div>
                  <div class="header-bottom">
                    <div class="txt2" v-if="oil_factDay">
                      {{
                        new Intl.NumberFormat("ru-RU").format(
                          Math.abs(
                            (oil_factDayPercent / oil_factDay - 1) * 100
                          ).toFixed(2)
                        )
                      }}%
                    </div>
                    <div class="txt3">vs от плана</div>
                  </div>
                </div>
              </td>
              <td>
                <div class="first-td-header">
                  <div class="nu">
                    <div class="number">
                      {{
                        new Intl.NumberFormat("ru-RU").format(
                          сapital_investment
                        )
                      }}
                    </div>
                    <div class="unit-vc">млрд. тенге</div>
                  </div>
                  <div class="txt1">Капиталовложения</div>
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

                  <div class="percent-header" v-if="oil_dlv_factDay">
                    {{
                      (
                        100 -
                        (oil_dlv_factDayPercent / oil_dlv_factDay - 1) * 100
                      ).toFixed(2)
                    }}%
                  </div>
                  <div class="plan-header" v-if="oil_dlv_planDay">
                    {{ new Intl.NumberFormat("ru-RU").format(oil_dlv_planDay) }}
                  </div>
                  <br />
                  <div
                    v-if="
                      (oil_dlv_factDayPercent / oil_dlv_factDay - 1) * 100 > 0
                    "
                    class="arrow2"
                  ></div>
                  <div
                    v-if="
                      (oil_dlv_factDayPercent / oil_dlv_factDay - 1) * 100 < 0
                    "
                    class="arrow3"
                  ></div>
                  <div class="header-bottom">
                    <div class="txt2" v-if="gas_factDay">
                      {{
                        new Intl.NumberFormat("ru-RU").format(
                          Math.abs(
                            (oil_dlv_factDayPercent / oil_dlv_factDay - 1) * 100
                          ).toFixed(2)
                        )
                      }}%
                    </div>
                    <div class="txt3">vs от плана</div>
                  </div>
                </div>
              </td>
              <td>
                <div class="first-td-header">
                  <div class="nu">
                    <div class="number">
                      {{ new Intl.NumberFormat("ru-RU").format(cash_flow) }}
                    </div>
                    <div class="unit-vc">
                      <!--млрд.-->
                      млрд. тенге
                    </div>
                  </div>
                  <div class="txt1">Свободный <br />денежный поток</div>

                  <br />
                  <div
                    v-if="(gas_factDayPercent / gas_factDay - 1) * 100 > 0"
                    class="arrow2"
                  ></div>
                  <div
                    v-if="(gas_factDayPercent / gas_factDay - 1) * 100 < 0"
                    class="arrow3"
                  ></div>
                  <div class="header-bottom">
                    <div class="txt2" v-if="gas_factDay">
                      {{
                        new Intl.NumberFormat("ru-RU").format(
                          Math.abs(
                            (gas_factDayPercent / gas_factDay - 1) * 100
                          ).toFixed(2)
                        )
                      }}%
                    </div>
                    <div class="txt3">vs от плана</div>
                  </div>
                </div>
              </td>
              <td @click="changeTable('2')" :style="`${tableHover2}`">
                <div class="nu">
                  <div class="number">{{ oilNow }}</div>
                  <div class="unit-vc">$ / bbl</div>
                </div>
                <br />
                <div class="txt1">Цена на нефть</div>
                <br />
                <div class="percent-currency">
                  <div class="arrow"></div>
                  <div class="txt2">5,2%</div>
                  <div class="txt3">vs сентябрь</div>
                </div>
              </td>
              <td @click="changeTable('3')" :style="`${tableHover3}`">
                <div class="nu">
                  <div class="number">{{ currencyNow }}</div>
                  <div class="unit-vc">kzt / $</div>
                </div>
                <br />
                <div class="txt1">Курс доллара</div>
                <br />
                <div class="percent-currency">
                  <div class="arrow"></div>
                  <div class="txt2">5,2%</div>
                  <div class="txt3">vs сентябрь</div>
                </div>
              </td>
            </tr>
          </table>
        </div>
      </div>

      <div class="second-table" :style="`${Table1}`">
        <div class="first-string first-string2">
          <div class="table-responsive">
            <div class="kpd">
              <div class="kpd-txt">Корпоративные КПД</div>
              <div class="kpd-line">
                <div class="progress2">
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
              </div>
              <div class="close2">Закрыть</div>
            </div>
          </div>
        </div>

        <div class="first-string col-4 first-string2 float table-border2">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <td
                  class="w-50"
                  @click="changeTable('4')"
                  :style="`${tableHover4}`"
                >
                  <div class="first-td-header">
                    <div class="txt7" v-if="default2">
                      {{ new Intl.NumberFormat("ru-RU").format(default2) }}
                    </div>

                    <div class="in-work">млрд. тенге</div>

                    <div class="report-execution">
                      Исполнение за отчётный период
                    </div>
                  </div>
                  <div class="second-td-header">
                    <div class="vert-line"></div>
                  </div>
                </td>

                <td>
                    <div class="report-execution">
                   Текущее исполнение КПД
                    </div>
                
                </td>
              </tr>
              <tr>
                <td
                  colspan="2"
                  @click="changeTable('4')"
                  :style="`${tableHover4}`"
                >
                  <div class="right-side-bottom">
                    <div class="txt8">Снижение OPEX и CAPEX</div>
                  </div>
                </td>
              </tr>
            </table>
          </div>
        </div>



           <div class="first-string col-4 first-string2 float table-border2">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <td
                  class="w-50"
                  @click="changeTable('4')"
                  :style="`${tableHover4}`"
                >
                  <div class="first-td-header">
                    <div class="txt7" v-if="default2">
                      {{ new Intl.NumberFormat("ru-RU").format(default2) }}
                    </div>

                    <div class="in-work">млрд. тенге</div>

                    <div class="report-execution">
                      Исполнение за отчётный период
                    </div>
                  </div>
                  <div class="second-td-header">
                    <div class="vert-line"></div>
                  </div>
                </td>

                <td>
                    <div class="report-execution">
                   Текущее исполнение КПД
                    </div>
                
                </td>
              </tr>
              <tr>
                <td
                  colspan="2"
                  @click="changeTable('4')"
                  :style="`${tableHover4}`"
                >
                  <div class="right-side-bottom">
                    <div class="txt8">Снижение OPEX и CAPEX</div>
                  </div>
                </td>
              </tr>
            </table>
          </div>
        </div>


        <div class="first-string col-4 first-string2 float">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <td
                  class="w-50"
                  @click="changeTable('4')"
                  :style="`${tableHover4}`"
                >
                  <div class="first-td-header">
                    <div class="txt7" v-if="default2">
                      {{ new Intl.NumberFormat("ru-RU").format(default2) }}
                    </div>

                    <div class="in-work">млрд. тенге</div>

                    <div class="report-execution">
                      Исполнение за отчётный период
                    </div>
                  </div>
                  <div class="second-td-header">
                    <div class="vert-line"></div>
                  </div>
                </td>

                <td>
                    <div class="report-execution">
                   Текущее исполнение КПД
                    </div>
                
                </td>
              </tr>
              <tr>
                <td
                  colspan="2"
                  @click="changeTable('4')"
                  :style="`${tableHover4}`"
                >
                  <div class="right-side-bottom">
                    <div class="txt8">Снижение OPEX и CAPEX</div>
                  </div>
                </td>
              </tr>
            </table>
          </div>
        </div>

        <div class="first-string col-4 first-string2 float table-border2">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <td
                  class="w-50"
                  @click="changeTable('4')"
                  :style="`${tableHover4}`"
                >
                  <div class="first-td-header">
                    <div class="txt7" v-if="default2">
                      {{ new Intl.NumberFormat("ru-RU").format(default2) }}
                    </div>

                    <div class="in-work">млрд. тенге</div>

                    <div class="report-execution">
                      Исполнение за отчётный период
                    </div>
                  </div>
                  <div class="second-td-header">
                    <div class="vert-line"></div>
                  </div>
                </td>

                <td>
                    <div class="report-execution">
                   Текущее исполнение КПД
                    </div>
                
                </td>
              </tr>
              <tr>
                <td
                  colspan="2"
                  @click="changeTable('4')"
                  :style="`${tableHover4}`"
                >
                  <div class="right-side-bottom">
                    <div class="txt8">Снижение OPEX и CAPEX</div>
                  </div>
                </td>
              </tr>
            </table>
          </div>
        </div>

        <div class="first-string col-4 first-string2 float table-border2">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <td
                  class="w-50"
                  @click="changeTable('4')"
                  :style="`${tableHover4}`"
                >
                  <div class="first-td-header">
                    <div class="txt7" v-if="default2">
                      {{ new Intl.NumberFormat("ru-RU").format(default2) }}
                    </div>

                    <div class="in-work">млрд. тенге</div>

                    <div class="report-execution">
                      Исполнение за отчётный период
                    </div>
                  </div>
                  <div class="second-td-header">
                    <div class="vert-line"></div>
                  </div>
                </td>

                <td>
                    <div class="report-execution">
                   Текущее исполнение КПД
                    </div>
                
                </td>
              </tr>
              <tr>
                <td
                  colspan="2"
                  @click="changeTable('4')"
                  :style="`${tableHover4}`"
                >
                  <div class="right-side-bottom">
                    <div class="txt8">Снижение OPEX и CAPEX</div>
                  </div>
                </td>
              </tr>
            </table>
          </div>
        </div>


        <div class="first-string col-4 first-string2 float">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <td
                  class="w-50"
                  @click="changeTable('4')"
                  :style="`${tableHover4}`"
                >
                  <div class="first-td-header">
                    <div class="txt7" v-if="default2">
                      {{ new Intl.NumberFormat("ru-RU").format(default2) }}
                    </div>

                    <div class="in-work">млрд. тенге</div>

                    <div class="report-execution">
                      Исполнение за отчётный период
                    </div>
                  </div>
                  <div class="second-td-header">
                    <div class="vert-line"></div>
                  </div>
                </td>

                <td>
                    <div class="report-execution">
                   Текущее исполнение КПД
                    </div>
                
                </td>
              </tr>
              <tr>
                <td
                  colspan="2"
                  @click="changeTable('4')"
                  :style="`${tableHover4}`"
                >
                  <div class="right-side-bottom">
                    <div class="txt8">Снижение OPEX и CAPEX</div>
                  </div>
                </td>
              </tr>
            </table>
          </div>
        </div>
        
      </div>

      <div class="second-table" :style="`${Table2}`"></div>

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
          <div class="big-area">Удельные доходы</div>
        </div>
      </div>

      <div class="third-table" :style="`${Table5}`">
        <div class="first-string first-string2">
          <div class="close2" @click="changeTable('1')">Закрыть</div>
          <div class="big-area">Удельные расходы</div>
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
    <div class="right-side2">
      <div class="first-string">
        <div class="table-responsive">
          <table class="table">
            <tr>
              <td
                class="w-50"
                @click="changeTable('4')"
                :style="`${tableHover4}`"
              >
                <div class="first-td-header">
                  <div class="in-work">план</div>
                  <div class="txt4" v-if="wells2[0].prod_wells_work">
                    {{
                      new Intl.NumberFormat("ru-RU").format(
                        wells2[0].prod_wells_work
                      )
                    }}
                  </div>

                  <div class="in-work">факт</div>
                  <div class="txt4" v-if="wells2[0].prod_wells_work">
                    {{
                      new Intl.NumberFormat("ru-RU").format(
                        wells2[0].prod_wells_work
                      )
                    }}
                  </div>
                  <div class="in-idle">тенге/тонна</div>
                </div>
                <div class="second-td-header">
                  <div class="vert-line"></div>
                </div>
              </td>

              <td
                class="w-50"
                @click="changeTable('4')"
                :style="`${tableHover4}`"
              >
                <div class="in-work">план</div>
                <div class="txt4" v-if="wells2[0].prod_wells_idle">
                  {{
                    new Intl.NumberFormat("ru-RU").format(
                      wells2[0].prod_wells_idle
                    )
                  }}
                </div>

                <div class="in-work">факт</div>
                <div class="txt4" v-if="wells2[0].prod_wells_idle">
                  {{
                    new Intl.NumberFormat("ru-RU").format(
                      wells2[0].prod_wells_idle
                    )
                  }}
                </div>

                <div class="in-idle">$/bbl</div>
              </td>
            </tr>
            <tr>
              <td
                colspan="2"
                @click="changeTable('4')"
                :style="`${tableHover4}`"
              >
                <div class="right-side-bottom">
                  <div class="txt2">Удельные доходы</div>
                  <div class="percent-arrow">
                    <div class="arrow"></div>
                    <div class="txt2">48%</div>
                  </div>
                </div>
              </td>
            </tr>
          </table>
        </div>
      </div>

      <div class="first-string first-string2">
        <div class="table-responsive">
          <table class="table">
            <tr>
              <td
                class="w-50"
                @click="changeTable('4')"
                :style="`${tableHover4}`"
              >
                <div class="first-td-header">
                  <div class="in-work">план</div>
                  <div class="txt4" v-if="wells2[0].prod_wells_work">
                    {{
                      new Intl.NumberFormat("ru-RU").format(
                        wells2[0].prod_wells_work
                      )
                    }}
                  </div>

                  <div class="in-work">факт</div>
                  <div class="txt4" v-if="wells2[0].prod_wells_work">
                    {{
                      new Intl.NumberFormat("ru-RU").format(
                        wells2[0].prod_wells_work
                      )
                    }}
                  </div>
                  <div class="in-idle">тенге/тонна</div>
                </div>
                <div class="second-td-header">
                  <div class="vert-line"></div>
                </div>
              </td>

              <td
                class="w-50"
                @click="changeTable('4')"
                :style="`${tableHover4}`"
              >
                <div class="in-work">план</div>
                <div class="txt4" v-if="wells2[0].prod_wells_idle">
                  {{
                    new Intl.NumberFormat("ru-RU").format(
                      wells2[0].prod_wells_idle
                    )
                  }}
                </div>

                <div class="in-work">факт</div>
                <div class="txt4" v-if="wells2[0].prod_wells_idle">
                  {{
                    new Intl.NumberFormat("ru-RU").format(
                      wells2[0].prod_wells_idle
                    )
                  }}
                </div>

                <div class="in-idle">$/bbl</div>
              </td>
            </tr>
            <tr>
              <td
                colspan="2"
                @click="changeTable('4')"
                :style="`${tableHover4}`"
              >
                <div class="right-side-bottom">
                  <div class="txt2">Удельные расходы</div>
                  <div class="percent-arrow">
                    <div class="arrow"></div>
                    <div class="txt2">48%</div>
                  </div>
                </div>
              </td>
            </tr>
          </table>
        </div>
      </div>

      <div class="first-string first-string2">
        <div class="table-responsive">
          <table class="table">
            <tr>
              <td
                class="w-50"
                @click="changeTable('4')"
                :style="`${tableHover4}`"
              >
                <div class="first-td-header">
                  <div class="in-work">план</div>
                  <div class="txt4" v-if="wells2[0].prod_wells_work">
                    {{
                      new Intl.NumberFormat("ru-RU").format(
                        wells2[0].prod_wells_work
                      )
                    }}
                  </div>

                  <div class="in-work">факт</div>
                  <div class="txt4" v-if="wells2[0].prod_wells_work">
                    {{
                      new Intl.NumberFormat("ru-RU").format(
                        wells2[0].prod_wells_work
                      )
                    }}
                  </div>
                  <div class="in-idle">тенге/тонна</div>
                </div>
                <div class="second-td-header">
                  <div class="vert-line"></div>
                </div>
              </td>

              <td
                class="w-50"
                @click="changeTable('4')"
                :style="`${tableHover4}`"
              >
                <div class="in-work">план</div>
                <div class="txt4" v-if="wells2[0].prod_wells_idle">
                  {{
                    new Intl.NumberFormat("ru-RU").format(
                      wells2[0].prod_wells_idle
                    )
                  }}
                </div>

                <div class="in-work">факт</div>
                <div class="txt4" v-if="wells2[0].prod_wells_idle">
                  {{
                    new Intl.NumberFormat("ru-RU").format(
                      wells2[0].prod_wells_idle
                    )
                  }}
                </div>

                <div class="in-idle">$/bbl</div>
              </td>
            </tr>
            <tr>
              <td @click="changeTable('4')" :style="`${tableHover4}`">
                <div class="right-side-bottom">
                  <div class="txt2">КВЛ на тонну</div>
                </div>
              </td>

              <td @click="changeTable('4')" :style="`${tableHover4}`">
                <div class="right-side-bottom">
                  <div class="arrow"></div>
                  <div class="txt2">48%</div>
                </div>
              </td>
            </tr>
          </table>
        </div>
      </div>

      <div class="first-string first-string2">
        <div class="table-responsive">
          <table class="table">
            <tr>
              <td
                class="w-50"
                @click="changeTable('4')"
                :style="`${tableHover4}`"
              >
                <div class="first-td-header">
                  <div class="in-work">Рентабельные</div>
                  <div class="txt4" v-if="wells2[0].prod_wells_work">
                    {{
                      new Intl.NumberFormat("ru-RU").format(
                        wells2[0].prod_wells_work
                      )
                    }}
                  </div>

                  <div class="in-idle">тенге/тонна</div>
                </div>
                <div class="second-td-header">
                  <div class="vert-line2"></div>
                </div>
              </td>

              <td
                class="w-50"
                @click="changeTable('4')"
                :style="`${tableHover4}`"
              >
                <div class="in-work">Нерентабельные</div>
                <div class="txt4" v-if="wells2[0].prod_wells_idle">
                  {{
                    new Intl.NumberFormat("ru-RU").format(
                      wells2[0].prod_wells_idle
                    )
                  }}
                </div>

                <div class="in-idle">$/bbl</div>
              </td>
            </tr>
            <tr>
              <td
                colspan="2"
                @click="changeTable('4')"
                :style="`${tableHover4}`"
              >
                <div class="right-side-bottom">
                  <div class="txt2">Фактическая эффективность ГТМ</div>
                  <div class="percent-arrow">
                    <div class="arrow"></div>
                    <div class="txt2">48%</div>
                  </div>
                </div>
              </td>
            </tr>
          </table>
        </div>
      </div>

      <div class="first-string first-string2">
        <div class="table-responsive">
          <table class="table">
            <tr>
              <td
                class="w-50"
                @click="changeTable('4')"
                :style="`${tableHover4}`"
              >
                <div class="first-td-header">
                  <div class="in-work">Рентабельные</div>
                  <div class="txt4" v-if="wells2[0].prod_wells_work">
                    {{
                      new Intl.NumberFormat("ru-RU").format(
                        wells2[0].prod_wells_work
                      )
                    }}
                  </div>

                  <div class="in-idle">тенге/тонна</div>
                </div>
                <div class="second-td-header">
                  <div class="vert-line2"></div>
                </div>
              </td>

              <td
                class="w-50"
                @click="changeTable('4')"
                :style="`${tableHover4}`"
              >
                <div class="in-work">Нерентабельные</div>
                <div class="txt4" v-if="wells2[0].prod_wells_idle">
                  {{
                    new Intl.NumberFormat("ru-RU").format(
                      wells2[0].prod_wells_idle
                    )
                  }}
                </div>

                <div class="in-idle">$/bbl</div>
              </td>
            </tr>
            <tr>
              <td
                colspan="2"
                @click="changeTable('4')"
                :style="`${tableHover4}`"
              >
                <div class="right-side-bottom">
                  <div class="txt2">Фактическая эффективность бурения</div>
                  <div class="percent-arrow">
                    <div class="arrow"></div>
                    <div class="txt2">48%</div>
                  </div>
                </div>
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
<script src="./VisualCenterTable4.js"></script>
