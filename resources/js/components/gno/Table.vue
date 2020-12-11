<template>
  <div class="main col-md-12 col-lg-12 row">
    <div class="tables-two col-xs-12 col-sm-7 col-md-7 col-lg-8 col-xl-9">
      <div class="tables-string-gno3">
        <modal name="modalIncl" :width="1150" :height="500" style="background:transparent">
          <div class="modal-bign">
            <div class="Table" align="center" x:publishsource="Excel">
              <gno-incl-table :wellNumber="wellNumber" :wellIncl="wellIncl"></gno-incl-table>
            </div>
          </div>
        </modal>

        <modal name="modalOldWell" :width="1150" :height="450" :adaptive="true">
          <div class="modal-bign">
            <Plotly :data="data" :layout="layout" :display-mode-bar="false"></Plotly>
          </div>
          <div class="modal-analysis-menu">
            <div class="form-check">
              <input v-model="analysisBox1" class="checkbox-modal-analysis-menu" @change="postAnalysisOld()"
                type="checkbox">
              <label for="checkbox1" class="checkbox-modal-analysis-menu-label">Рпл = Рнач</label>
            </div>
            <div class="form-check">
              <input v-model="analysisBox2" class="checkbox-modal-analysnauryzbekis-menu" @change="postAnalysisOld()"
                type="checkbox">
              <label for="checkbox1" class="checkbox-modal-analysis-menu-label">Н дин = Ндин мин</label>
            </div>
            <div class="form-check">
              <input v-model="analysisBox3" class="checkbox-modal-analysnauryzbekis-menu" @change="postAnalysisOld()"
                type="checkbox">
              <label for="checkbox1" class="checkbox-modal-analysis-menu-label">Рзаб пот >= 0,75 * Рнас</label>
            </div>
            <div class="form-check">
              <input v-model="analysisBox4" class="checkbox-modal-analysis-menu" @change="postAnalysisOld()"
                type="checkbox">
              <label for="checkbox1" class="checkbox-modal-analysis-menu-label">Qж = Qж АСМА</label>
            </div>
            <div class="form-check">
              <input v-model="analysisBox5" class="checkbox-modal-analysis-menu" @change="postAnalysisOld()"
                type="checkbox">
              <label for="checkbox1" class="checkbox-modal-analysis-menu-label">Обв = Обв АСМА</label>
            </div>
             <button type="button" class="old_well_button" @click="setGraphOld()">Применить&nbsp;выполненные корректировки</button>
          </div>
        </modal>

        <modal name="modalNewWell" :width="1150" :height="450" :adaptive="true">
          <div class="modal-bign">
            <Plotly :data="data" :layout="layout" :display-mode-bar="false"></Plotly>
          </div>
          <div class="modal-analysis-menu">


            <div class="form-check-new">
              <input v-model="analysisBox6" class="new-checkbox-modal-analysis-menu" @change="postAnalysisNew()" type="checkbox">
              <label for="checkbox1" class="new-checkbox-modal-analysis-menu-label">Pпл = P по окр.</label>
            </div>
            <div class="form-check-new">
              <input v-model="analysisBox7" class="new-checkbox-modal-analysis-menu" @change="postAnalysisNew()" type="checkbox">
              <label for="checkbox1" class="new-checkbox-modal-analysis-menu-label">К пр = К по окр.</label>

            </div>
             <div class="form-check-new">
              <label for="checkbox1" class="new-checkbox-modal-analysis-menu-label">Обв по окр. = </label>
              <label for="checkbox1">{{wctOkr}}%</label>
            </div>
            <div class="form-check-new">
              <input v-model="analysisBox8" class="new-checkbox-modal-analysis-menu" @change="postAnalysisNew()" type="checkbox">
              <label for="checkbox1" class="new-checkbox-modal-analysis-menu-label">Рзаб пот = 0.75 * Рнас</label>
            </div>
            <div class="form-check-new">
              <input v-model="grp_skin" class="new-checkbox-modal-analysis-menu" @change="postAnalysisNew()" type="checkbox">
              <label for="checkbox1" class="new-checkbox-modal-analysis-menu-label">с ГРП</label>
            </div>
            <button type="button" class="old_well_button" @click="setGraphNew()">Применить&nbsp;выполненные корректировки</button>
          </div>
        </modal>


        <modal name="modalExpAnalysis" :width="1300" :height="550" :adaptive="true" class="chart">
          <div class="nno-modal">
            <h4 class="nno-title">Сравнение технико-экономических показателей за 1 год эксплуатации</h4>
            <div class="nno-graph">
              <gno-chart-bar :data="expAnalysisData"></gno-chart-bar>
            </div>
            <div class="nno-info-button">
              <div class="nno-icon" @click="onShowTable()">
                <svg width="31" height="35" viewBox="0 0 31 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M15.131 0.290039C6.83973 0.290039 0.117188 6.77814 0.117188 14.7803C0.117188 19.0149 2.00031 22.8253 5.00172 25.4754L3.66936 34.3624L11.2537 28.7829C12.4906 29.1013 13.7903 29.2719 15.131 29.2719C23.4223 29.2719 30.1463 22.7824 30.1463 14.7803C30.1463 6.77814 23.4223 0.290039 15.131 0.290039ZM18.2567 22.7482C17.4838 23.0426 16.8686 23.2656 16.4071 23.4202C15.9471 23.5749 15.4118 23.6521 14.8033 23.6521C13.8676 23.6521 13.1392 23.4316 12.6208 22.9909C12.102 22.5506 11.8441 21.9925 11.8441 21.3142C11.8441 21.0504 11.863 20.7804 11.9015 20.5057C11.9407 20.2306 12.0029 19.9217 12.0881 19.5746L13.0555 16.2768C13.1403 15.9606 13.2141 15.6601 13.2726 15.3803C13.331 15.0979 13.3593 14.8392 13.3593 14.6038C13.3593 14.1843 13.2689 13.8899 13.0898 13.7244C12.9077 13.5584 12.5661 13.4776 12.0564 13.4776C11.8072 13.4776 11.5504 13.5133 11.2872 13.5879C11.0267 13.6654 10.8006 13.7352 10.6151 13.804L10.8703 12.7881C11.5033 12.5392 12.1096 12.3256 12.6879 12.1491C13.2663 11.9698 13.8129 11.8817 14.3279 11.8817C15.2569 11.8817 15.9736 12.1 16.4784 12.5316C16.9806 12.9649 17.2336 13.5278 17.2336 14.2199C17.2336 14.3633 17.2154 14.6162 17.1814 14.9768C17.1468 15.3385 17.082 15.6685 16.9881 15.9716L16.026 19.2594C15.9472 19.5229 15.8771 19.8249 15.8137 20.1622C15.7512 20.4995 15.721 20.7571 15.721 20.93C15.721 21.3666 15.8212 21.665 16.0248 21.8233C16.2254 21.9816 16.5775 22.0612 17.0756 22.0612C17.3108 22.0612 17.5739 22.0205 17.8714 21.9422C18.1662 21.8636 18.3801 21.7938 18.5147 21.7337L18.2567 22.7482ZM18.0863 9.40345C17.6376 9.80588 17.0974 10.0071 16.4656 10.0071C15.8352 10.0071 15.2912 9.80588 14.8388 9.40345C14.3887 9.00138 14.1612 8.51159 14.1612 7.93996C14.1612 7.36978 14.3902 6.87891 14.8388 6.47284C15.2912 6.06567 15.8352 5.86336 16.4656 5.86336C17.0974 5.86336 17.6388 6.06567 18.0863 6.47284C18.5349 6.87891 18.76 7.36978 18.76 7.93996C18.76 8.51304 18.5349 9.00138 18.0863 9.40345Z"
                    fill="#FEFEFE" />
                </svg>
              </div>
            </div>

            <button class="button-nno btn-primary" @click="onCompareNpv()">Выбрать способ эксплуатации с более высоким
              NPV</button>

          </div>
        </modal>

        <modal name="tablePGNO"  :width="550" :height="550" :adaptive="true" class="chart">

          <div id="table-wrapper">
  <div id="table-scroll">
    <table>
        <thead>
            <tr>
                <th><span class="text">Наименование</span></th>
                <th><span class="text">ШГН (покупка)</span></th>
                <th><span class="text">ЭЦН (аренда)</span></th>
            </tr>
        </thead>
        <tbody>
<tr>
  <td>Доп. добыча жидкости, м³/сут</td>
  <td>{{Math.round(expAnalysisData.npvTable1.liquid)}}</td>
  <td>{{Math.round(expAnalysisData.npvTable2.liquid)}}</td>
</tr>
<tr>
  <td>Доп. добыча нефти, т/сут</td>
  <td>{{Math.round(expAnalysisData.npvTable1.oil)}}</td>
  <td>{{Math.round(expAnalysisData.npvTable2.oil)}}</td>
</tr>
<tr>
  <td>Количество отработанных дней, сут</td>
  <td>{{Math.round(expAnalysisData.npvTable1.workday)}}</td>
  <td>{{Math.round(expAnalysisData.npvTable2.workday)}}</td>
</tr>
<tr>
  <td>Количество ПРС</td>
  <td>{{Math.round(expAnalysisData.npvTable1.kolichestvoPrs)}}</td>
  <td>{{Math.round(expAnalysisData.npvTable2.kolichestvoPrs)}}</td>
</tr>
<tr>
  <td>Среднее продолжительность 1 ПРС, сут</td>
  <td>{{Math.round(expAnalysisData.npvTable1.sredniiPrs)}}</td>
  <td>{{Math.round(expAnalysisData.npvTable2.sredniiPrs)}}</td>
</tr>
<tr>
  <td>Определение доходной части, тыс.тг</td>
  <td>{{Math.round(expAnalysisData.npvTable1.godovoiDohod/1000)}}</td>
  <td>{{Math.round(expAnalysisData.npvTable2.godovoiDohod/1000)}}</td>
</tr>
<tr>
  <td>Расчет НДПИ, тыс.тг</td>
  <td>{{Math.round(expAnalysisData.npvTable1.godovoiNdpi/1000)}}</td>
  <td>{{Math.round(expAnalysisData.npvTable2.godovoiNdpi/1000)}}</td>
</tr>
<tr>
  <td>Расчет Рентного налога, тыс.тг</td>
  <td>{{Math.round(expAnalysisData.npvTable1.godovoiRent/1000)}}</td>
  <td>{{Math.round(expAnalysisData.npvTable2.godovoiRent/1000)}}</td>
</tr>
<tr>
  <td>Расчет ЭТП, тыс.тг</td>
  <td>{{Math.round(expAnalysisData.npvTable1.godovoiEtp/1000)}}</td>
  <td>{{Math.round(expAnalysisData.npvTable2.godovoiEtp/1000)}}</td>
</tr>
<tr>
  <td>Расчет Расходов по транспортировке нефти, тыс.тг</td>
  <td>{{Math.round(expAnalysisData.npvTable1.godovoiTrans/1000)}}</td>
  <td>{{Math.round(expAnalysisData.npvTable2.godovoiTrans/1000)}}</td>
</tr>
<tr>
  <td>Затраты на электроэнергию, тыс.тг</td>
  <td>{{Math.round(expAnalysisData.npvTable1.godovoiZatrElectShgn/1000)}}</td>
  <td>{{Math.round(expAnalysisData.npvTable2.godovoiZatrElectEcn/1000)}}</td>
</tr>
<tr>
  <td>Затраты на подготовку, тыс.тг</td>
  <td>{{Math.round(expAnalysisData.npvTable1.godovoiZatrPrep/1000)}}</td>
  <td>{{Math.round(expAnalysisData.npvTable2.godovoiZatrPrep/1000)}}</td>
</tr>
<tr>
  <td>Затраты на ПРС, тыс.тг</td>
  <td>{{Math.round(expAnalysisData.npvTable1.godovoiZatrPrs/1000)}}</td>
  <td>{{Math.round(expAnalysisData.npvTable2.godovoiZatrPrs/1000)}}</td>
</tr>
<tr>
  <td>Затраты за суточное обслуживание, тыс.тг</td>
  <td>{{Math.round(expAnalysisData.npvTable1.godovoiZatrSutObs/1000)}}</td>
  <td>{{Math.round(expAnalysisData.npvTable2.godovoiZatrSutObs/1000)}}</td>
</tr>
<tr>
  <td>Стоимость аренды оборудования, тыс.тг</td>
  <td>{{Math.round(expAnalysisData.npvTable1.godovoiArenda/1000)}}</td>
  <td>{{Math.round(expAnalysisData.npvTable2.godovoiArenda/1000)}}</td>
</tr>
<tr>
  <td>Амортизация, тыс.тг</td>
  <td>{{Math.round(expAnalysisData.npvTable1.godovoiAmortizacia/1000)}}</td>
  <td>{{Math.round(expAnalysisData.npvTable2.godovoiAmortizacia/1000)}}</td>
</tr>
<tr>
  <td>Операционная прибыль, тыс.тг</td>
  <td>{{Math.round(expAnalysisData.npvTable1.godovoiOperPryb/1000)}}</td>
  <td>{{Math.round(expAnalysisData.npvTable2.godovoiOperPryb/1000)}}</td>
</tr>
<tr>
  <td>КПН, тыс.тг</td>
  <td>{{Math.round(expAnalysisData.npvTable1.godovoiKpn/1000)}}</td>
  <td>{{Math.round(expAnalysisData.npvTable2.godovoiKpn/1000)}}</td>
</tr>
<tr>
  <td>Чистая прибыль, тыс.тг</td>
  <td>{{Math.round(expAnalysisData.npvTable1.godovoiChistPryb/1000)}}</td>
  <td>{{Math.round(expAnalysisData.npvTable2.godovoiChistPryb/1000)}}</td>
</tr>
<tr>
  <td>КВЛ, тыс.тг</td>
  <td>{{Math.round(expAnalysisData.npvTable1.godovoiKvl/1000)}}</td>
  <td>{{Math.round(expAnalysisData.npvTable2.godovoiKvl/1000)}}</td>
</tr>
<tr>
  <td>Свободный денежный поток, тыс.тг</td>
  <td>{{Math.round(expAnalysisData.npvTable1.godovoiSvobPot/1000)}}</td>
  <td>{{Math.round(expAnalysisData.npvTable2.godovoiSvobPot/1000)}}</td>
</tr>
<tr>
  <td>NPV, млн.тг</td>
  <td>{{Math.round(expAnalysisData.npvTable1.npv/1000000)}}</td>
  <td>{{Math.round(expAnalysisData.npvTable2.npv/1000000)}}</td>
</tr>


        </tbody>
    </table>
  </div>
</div>



        </modal>

        <div class="gno-line-chart"  v-if="visibleChart">
          <gno-line-points-chart></gno-line-points-chart>
        </div>

        <div class="podbor-gno" v-if="!visibleChart">
          <div class="img-text">
            <div class="text_img_1">Экс.колонка {{this.casID}}мм</div>
            <div class="text_img_2">НКТ {{this.tubOD}}мм</div>
            <div class="text_img_3">Штанги {{this.shgnS1D}}мм 0-{{this.shgnS1L}}м</div>
            <div class="text_img_4">Штанги {{this.shgnS2D}}мм {{this.shgnS1L}}-{{this.shgnS1L * 1 + this.shgnS2L * 1}}м</div>
            <div class="text_img_5">Штанги {{this.shgnS1D}}мм {{this.shgnS1L * 1 + this.shgnS2L * 1}}-{{this.shgnS1L * 1 + this.shgnS2L * 1 + this.shgnTNL * 1}}м</div>
            <div class="text_img_6">Насос {{this.shgnPumpType}}мм </div>
            <div class="text_img_7">Интервал перфорации {{this.hPerf}}-{{this.hPerf * 1 + this.hPerfND * 1}}м</div>
            <div class="text_img_8">Текущий забой {{this.curr}}м</div>
          </div>
          <div class="image-data">
            <img class="podborgnoimg" src="./images/podbor-gno.png" alt="podbor-gno" width="150px" height="435px" >
          </div>

          <div class="table-pgno-button">



       <div class="table-pgno-one">
         <table class="table-pgno" >

                <tr class="tr-pgno" height="10" style="height: 10pt;">
                <td class="td-pgno" rowspan="1" colspan="2">
                    Расчетный режим:
                </td>
                </tr>
                <tbody>
                    <tr>
                        <td class="td-pgno" rowspan="1">Qж</td>
                        <td class="td-pgno" rowspan="1">{{qlCelValue}} м³/сут</td>
                    </tr>
                    <tr>
                        <td class="td-pgno" rowspan="1">Qн</td>
                        <td class="td-pgno" rowspan="1">{{qOil}} т/сут</td>
                    </tr>
                    <tr>
                        <td class="td-pgno" rowspan="1">Обв</td>
                        <td class="td-pgno" rowspan="1">{{wctInput}} %</td>
                    </tr>
                    <tr>
                        <td class="td-pgno" rowspan="1">Рзаб</td>
                        <td class="td-pgno" rowspan="1">{{bhpCelValue}} ат</td>
                    </tr>
                    <tr>
                        <td class="td-pgno" rowspan="1">Рпр</td>
                        <td class="td-pgno" rowspan="1">{{piCelValue}} ат</td>
                    </tr>
                </tbody>
                </table>
       </div>

 <div class="table-pgno-two">
    <table class="table-pgno" >

                <tr class="tr-pgno" height="5px" style="height: 10pt;">
                <td class="td-pgno" rowspan="1" colspan="2">
                    Компоновка:
                </td>
                </tr>
                <tbody>
                    <tr>
                        <td class="td-pgno" rowspan="1">Ø насоса</td>
                        <td class="td-pgno" rowspan="1">{{shgnPumpType}} мм</td>
                    </tr>
                    <tr>
                        <td class="td-pgno" rowspan="1">Число качаний</td>
                        <td class="td-pgno" rowspan="1">{{shgnSPM}} мин-1</td>
                    </tr>
                    <tr>
                        <td class="td-pgno" rowspan="1">Длина хода</td>
                        <td class="td-pgno" rowspan="1">{{shgnLen}} м</td>
                    </tr>
                    <tr>
                        <td class="td-pgno" rowspan="1">Тип СК</td>
                        <td class="td-pgno" rowspan="1">{{sk}}</td>
                    </tr>
                    <tr>
                        <td class="td-pgno" rowspan="1">Ø НКТ</td>
                        <td class="td-pgno" rowspan="1">{{tubOD}} мм</td>
                    </tr>
                    <tr>
                        <td class="td-pgno" rowspan="1">Нсп насоса</td>
                        <td class="td-pgno" rowspan="1">{{hPumpValue}} м</td>
                    </tr>
                </tbody>
                </table>
 </div>





  <div class="table-pgno-four">
    <table class="table-pgno" >

                 <tr class="tr-pgno" height="5px" style="height: 10pt;">
                <td class="td-pgno" rowspan="1">
                    Штанги
                </td>
                <td class="td-pgno" rowspan="1">
                    Ø, мм
                </td>

                <td class="td-pgno" rowspan="1">
                    Длина, м
                </td>


                </tr>
                <tbody>
                    <tr>
                        <td class="td-pgno" rowspan="1">Секция 1</td>
                        <td class="td-pgno" rowspan="1">{{shgnS1D}}</td>
                        <td class="td-pgno" rowspan="1">{{shgnS1L}}</td>
                    </tr>
                    <tr class="tr-pgno">
                        <td class="td-pgno" rowspan="1">Секция 2</td>
                        <td class="td-pgno" rowspan="1">{{shgnS2D}}</td>
                        <td class="td-pgno" rowspan="1">{{shgnS2L}}</td>
                    </tr>
                      <tr>
                        <td class="td-pgno" rowspan="1">ТН</td>
                        <td class="td-pgno" rowspan="1">{{shgnS1D}}</td>
                        <td class="td-pgno" rowspan="1">{{shgnTNL}}</td>
                    </tr>
                </tbody>
                </table>
 </div>

       </div>
       </div>
      </div>

      <modal name="table" :width="1150" :height="385" :adaptive="true"></modal>

      <div class="tables-string-gno4 col-6">
        <div class="tables-string-gno4-inner">
          <div class="select-well col-12">Настройка кривой притока</div>
          <div class="col-8 relative">
            <div class="col-6">
              <div class="cell4-gno col-4">
                <span>Рпл</span>
              </div>
              <div class="cell4-gno table-border-gno cell4-gno-second col-5">
                <input v-model="pResInput" @change="postCurveData()" onfocus="this.value=''" type="text" class="square2" />
              </div>

                <div class="cell4-gno table-border-gno-top col-4">
                  <input v-model="curveSelect" class="checkbox" value="pi" type="radio" name="set" @change="postCurveData()" />
                  <span>Кпрод</span>

                </div>
                <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
                  <input v-model="piInput" :disabled="curveSelect != 'pi'" @change="postCurveData()" onfocus="this.value=''" type="text" class="square2" />
                </div>

              <div class="cell4-gno table-border-gno-top col-4">
                <input v-model="curveSelect" class="checkbox" value="hdyn" type="radio" @change="postCurveData()"
                  name="set" />
                  <span>Qж</span>
              </div>
              <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
                <input :disabled="curveSelect == 'pi'" v-model="qLInput" @change="postCurveData()" onfocus="this.value=''" type="text"
                  class="square2" />
              </div>
            </div>
          </div>

          <div class="col-4 relative">
            <div class="cell4-gno col-4">
              <span>Обв</span>
            </div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-5">
              <input v-model="wctInput" @change="postCurveData()" type="text" onfocus="this.value=''" class="square2" />
            </div>

            <div class="cell4-gno table-border-gno-top col-4">
              <span>ГФ</span>
            </div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
              <input v-model="gorInput" @change="postCurveData()" type="text" onfocus="this.value=''" class="square2" />
            </div>
          </div>

          <br />
          <br />

          <div class="col-12 relative left-center">
            <div class="cell4-gno col-4 table-border-gno-top">
              <input v-model="curveSelect" value="bhp" :disabled="curveSelect == 'pi'" class="checkbox2" type="radio" @change="postCurveData()"
                name="set2" />
              <div class="text2">Рзаб</div>
            </div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top">
              <input :disabled="curveSelect != 'bhp'" v-model="bhpInput" @change="postCurveData()" onfocus="this.value=''" type="text"
                class="square2" />
            </div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"></div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"></div>
          </div>

          <div class="col-12 relative left-center">
            <div class="cell4-gno col-4 table-border-gno-top">
              <input v-model="curveSelect"  value="hdyn" :disabled="curveSelect == 'pi'" class="checkbox2" type="radio" @change="postCurveData()"
                name="set2" />
              <div class="text2">Ндин</div>
            </div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top">
              <input :disabled="curveSelect != 'hdyn'" v-model="hDynInput" @change="postCurveData()" type="text" onfocus="this.value=''"
                class="square2" />
            </div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top">
              Рзат
            </div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top">
              <input :disabled="curveSelect != 'hdyn'" v-model="pAnnularInput" @change="postCurveData()" type="text" onfocus="this.value=''"
                class="square2" />
            </div>
          </div>

          <div class="col-12 relative left-center">
            <div class="cell4-gno col-4 table-border-gno-top">
              <input v-model="curveSelect" value="pmanom" :disabled="curveSelect == 'pi'" class="checkbox2" type="radio" @change="postCurveData()"
                name="set2" />
              <div class="text2">Рманом</div>
            </div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top">
              <input :disabled="curveSelect != 'pmanom'" v-model="pManomInput" @change="postCurveData()" type="text" onfocus="this.value=''"
                class="square2" />
            </div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top">
              Нсп маном
            </div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top">
              <input :disabled="curveSelect != 'pmanom'" v-model="hPumpManomInput" @change="postCurveData()" type="text" onfocus="this.value=''"
                class="square2" />
            </div>
          </div>

          <div class="col-12 relative left-center">
            <div class="cell4-gno col-4 table-border-gno-top">
              <input v-model="curveSelect" value="whp" :disabled="curveSelect == 'pi'" class="checkbox2" type="radio" @change="postCurveData()"
                name="set2" />
              <div class="text2">Рбуф (ФЭ)</div>
            </div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top">
              <input :disabled="curveSelect != 'whp'" v-model="whpInput" @change="postCurveData()" type="text" onfocus="this.value=''"
                class="square2" />
            </div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"></div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"></div>
          </div>
        </div>

        <div class="tables-string-gno5 col-12" @click="PotAnalysisMenu()">
          Анализ потенциала скважины
        </div>
      </div>
      <div class="col-6 tables-string-gno44">
        <div class="tables-string-gno44-inner">
          <div class="select-well col-12">Параметры подбора</div>
          <div class="select-well col-12">ГНО</div>
          <div class="col-12 relative left-center">
            <div class="cell4-gno col-3">
              <div class="text3">ШГН</div>
              <input class="checkbox3" value="ШГН" v-model="expChoose" @change="postCurveData()"
                :checked="expChoose === 'ШГН'" type="radio" name="gno10" />
            </div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-2">
              <div class="text3">ЭЦН</div>
              <input class="checkbox3" value="ЭЦН" v-model="expChoose" @change="postCurveData()"
                :checked="expChoose === 'ЭЦН'" type="radio" name="gno10" />
            </div>

            <div class="cell4-gno table-border-gno cell4-gno-second col-3">
              <div class="text3">Нсп</div>
            </div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-2">
              <input v-model="hPumpValue" @change="postCurveData()" onfocus="this.value=''" type="text" class="square2" />
            </div>
          </div>

          <div class="select-well col-12">Целевой параметр</div>
          <div class="col-12 relative left-center">
            <div class="cell4-gno col-3">
              <div class="text3">Qж</div>
              <input v-model="CelButton" class="checkbox3" value="ql" type="radio" name="gno11" />
            </div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-3">
              <div class="target">
                <input v-model="qlCelValue" @change="postCurveData()" :disabled="CelButton != 'ql'" onfocus="this.value=''" type="text"
                  class="square2" />
              </div>
              <div class="text3">Рзаб</div>
              <input v-model="CelButton" class="checkbox3" value="bhp" type="radio" name="gno11" />
            </div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-3">
              <div class="target">
                <input v-model="bhpCelValue" @change="postCurveData()" :disabled="CelButton != 'bhp'" type="text" onfocus="this.value=''"
                  class="square2" />
              </div>
              <div class="text3">Pnp</div>
              <input v-model="CelButton" class="checkbox3" value="pin" type="radio" name="gno11" />
            </div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-2">
              <input v-model="piCelValue" @change="postCurveData()" :disabled="CelButton != 'pin'" type="text" onfocus="this.value=''"
                class="square2" />
            </div>
          </div>
        </div>
        <div class="tables-string-gno55 col-12" @click="ExpAnalysisMenu()">
          Анализ эффективности способа эксплуатации
        </div>
      </div>

      <div class="col-12 row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6"></div>
      </div>
      <!-- <div class="tables-string-gno6 col-12" @click="visibleChart=!visibleChart"> -->
      <div class="tables-string-gno6 col-12" @click="onPgnoClick()">
        {{visibleChart? 'Подбор ГНО':'Кривая притока'}}
      </div>
    </div>
    <div class="tables-one col-xs-12 col-sm-5 col-md-5 col-lg-3 col-xl-3">
      <div class="tables-string-gno col-12">
        <div class="select-well col-12">Выбор скважины</div>
        <div class="cell4-gno col-7">Месторождение</div>
        <div class="cell4-gno table-border-gno cell4-gno-second col-5">
          <select class="select-gno2" v-model="field">
            <option value="UZN">Узень</option>
            <option value="KMB">Карамандыбас</option>
          </select>
        </div>
        <div class="cell4-gno table-border-gno-top col-7">Скважина №</div>
        <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
          <input v-model="wellNumber" type="text" @change="getWellNumber(wellNumber)" class="square2" />
        </div>
        <div class="cell4-gno table-border-gno-top col-7">
          Новая скважина
          <input :checked="age===true" v-model="age" class="checkbox0" type="checkbox" />
        </div>
        <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
          с ГРП <input class="checkbox0" v-model="grp_skin" :disabled="!age" type="checkbox" />
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Горизонт</div>
        <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
          {{horizon}}
        </div>

        <div class="cell4-gno table-border-gno-top col-7">
          Способ эксплуатации
        </div>
        <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
          <div class="center">
            {{expMeth}}
          </div>
        </div>

        <div class="cell4-gno table-border-gno-top col-7">
          {{tseh}}
        </div>
        <div class="cell4-gno table-border-gno-top cell4-gno-second col-5">
          {{gu}}
        </div>

        <div class="cell4-gno col-7">
          {{ngdu}}
        </div>
        <div class="cell4-gno cell4-gno-second col-5">
          АО "ОМГ"
        </div>
      </div>
      <div class="tables-string-gno1-1">
        <div class="select-well col-12">Конструкция</div>
        <div class="cell4-gno col-7">Наружн. ØЭК</div>
        <div class="cell4-gno table-border-gno cell4-gno-second col-5">
          {{casOD}} мм
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Внутрен. ØЭК</div>
        <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
          {{casID}} мм
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Нперф.(ВДП м)</div>
        <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
          {{hPerf}} м
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Удл. на Нперф.</div>
        <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
          {{udl}} м
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Текущий забой</div>
        <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
          {{curr}} м
        </div>
      </div>

      <div class="inclinom" @click="InclMenu()">Инклинометрия</div>

      <div class="spoiler">
        <input style="width: 845px; height: 35px;" type="checkbox" tabindex="-1" />
        <div class="box">
          <div class="select-well col-12">
            <div class="select-gno">Оборудование</div>
          </div>
     <span class="closer"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"
         xmlns="http://www.w3.org/2000/svg">
         <path
           d="M17.6569 16.2427L19.0711 14.8285L12.0001 7.75739L4.92896 14.8285L6.34317 16.2427L12.0001 10.5858L17.6569 16.2427Z"
           fill="currentColor" />
       </svg></span><span class="open"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"
         xmlns="http://www.w3.org/2000/svg">
         <path
           d="M6.34317 7.75732L4.92896 9.17154L12 16.2426L19.0711 9.17157L17.6569 7.75735L12 13.4142L6.34317 7.75732Z"
           fill="currentColor" />
       </svg></span>

    <blockquote>
            <div class="cell4-gno table-border-gno-top col-7">
              Станок-качалка
            </div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
              {{sk}}
            </div>

            <div class="cell4-gno table-border-gno-top col-7">
              Длина хода
            </div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
              {{strokeLenDev}} м
            </div>

            <div class="cell4-gno table-border-gno-top col-7">
              Число качаний
            </div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
              {{spmDev}} м-1
            </div>

            <div class="cell4-gno table-border-gno-top col-7">
              Диаметр насоса
            </div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
              {{pumpType}} мм
            </div>

            <div class="cell4-gno table-border-gno-top col-7">Нсп</div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
              {{hPumpSet}} м
            </div>

            <div class="cell4-gno table-border-gno-top col-7">Наружн. ØНКТ</div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
              {{tubOD}} мм
            </div>
            <div class="cell4-gno table-border-gno-top col-7">Внутр. ØНКТ</div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
              {{tubID}} мм
            </div>
            <div class="cell4-gno table-border-gno-top col-7">Дата запуска</div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
              {{stopDate}}
            </div>
          </blockquote>
        </div>
      </div>


      <div class="spoiler">
        <input style="width: 845px; height: 45px;" type="checkbox" tabindex="-1" />
        <div class="box">
          <div class="select-well col-12">
            <div class="select-gno"><b>PVT</b></div>
          </div>
          <span class="closer"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path
        d="M17.6569 16.2427L19.0711 14.8285L12.0001 7.75739L4.92896 14.8285L6.34317 16.2427L12.0001 10.5858L17.6569 16.2427Z"
        fill="currentColor" />
    </svg></span><span class="open"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"
      xmlns="http://www.w3.org/2000/svg">
      <path d="M6.34317 7.75732L4.92896 9.17154L12 16.2426L19.0711 9.17157L17.6569 7.75735L12 13.4142L6.34317 7.75732Z"
        fill="currentColor" />
    </svg></span>


          <blockquote>
            <div class="cell4-gno col-7">Рнас</div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-5">
              {{PBubblePoint}} атм
            </div>

            <div class="cell4-gno table-border-gno-top col-7">ГФ</div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
              {{gor}} м³/т
            </div>

            <div class="cell4-gno table-border-gno-top col-7">Т пл</div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
              {{tRes}} ℃
            </div>

            <div class="cell4-gno table-border-gno-top col-7">
              Вязкость нефти (пл.усл.)
            </div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
              {{viscOilRc}} сПз
            </div>

            <div class="cell4-gno table-border-gno-top col-7">
              Вязкость воды (пл.усл.)
            </div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
              {{viscWaterRc}} сПз
            </div>

            <div class="cell4-gno table-border-gno-top col-7">
              Плотность нефти
            </div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
              {{densOil}} г/cм³
            </div>
            <div class="cell4-gno table-border-gno-top col-7">
              Плотность воды
            </div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
              {{densWater}} г/cм³
            </div>
          </blockquote>
        </div>
      </div>

      <div class="tables-string-gno2">
        <div class="select-well col-12"><b>Технологический режим</b></div>
        <div class="cell4-gno col-7">Qж</div>
        <div class="cell4-gno table-border-gno cell4-gno-second col-5">
          {{qL}} м3/сут
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Qн</div>
        <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
          {{qO}} т/сут
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Обвод</div>
        <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
          {{wct}} %
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Рзаб</div>
        <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
          {{bhp}} атм
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Рпл</div>
        <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
          {{pRes}} ат
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Ндин</div>
        <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
          {{hDyn}} м
        </div>
        <div class="cell4-gno table-border-gno-top col-7">Рзат</div>
        <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
          {{pAnnular}} атм
        </div>
        <div class="cell4-gno table-border-gno-top col-7">Рбуф</div>
        <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
          {{whp}} атм
        </div>
        <div class="cell4-gno table-border-gno-top col-7">Рлин</div>
        <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">
          {{lineP}} атм
        </div>
      </div>
    </div>
    <notifications position="top"></notifications>
  </div>
</template>

<script>
import { Plotly } from "vue-plotly";
import { eventBus } from "../../event-bus.js";
import NotifyPlugin from "vue-easy-notify";
import 'vue-easy-notify/dist/vue-easy-notify.css';
import { VueMomentLib }from "vue-moment-lib";
import moment from "moment";
import Vue from 'vue';

Vue.prototype.$eventBus = new Vue();


Vue.use(NotifyPlugin,VueMomentLib);
Vue.component("Plotly", Plotly);

export default {
  data: function () {
    return {
      layout: {
        width: 950,
        height: 450,
        showlegend: true,
        xaxis: {
          // title: "Дебит, Qж, м³/сут.",
          hoverformat: ".1f",
          //  showline: true,
          zeroline: false,
          // showgrid: true,
          // mirror:true,
          // ticklen: 4,
          gridcolor: "#123E73",
          //tickfont: {size: 10},
        },
        yaxis: {
          title: "Давление, Pзаб, атм.",
          hoverformat: ".1f",
          showlegend: true,
          // showline: true,
          zeroline: false,
          //showgrid: true,
          // mirror:true,
          // ticklen: 4,
          gridcolor: "#123E73",
          //tickfont: {size: 10},
        },

        //   scene:{ gridcolor: '#ffffff',},
        paper_bgcolor: "#20274e",
        plot_bgcolor: "#20274e",
        font: { color: "#fff" },

        legend: {
          orientation: "h",
          y: -0.3,
          font: {
            size: 12,
            color: "#fff",
          },
        },
      },

      data: [
        {
          name: "IPR (кривая притока)",
          x: [0,1,3],
          y: [0,1,3],

          marker: {
            size: "15",
            color: "#FF0D18",
          },
        },
        ],
        bhpPot: null,
        qlPot: null,
        pinPot: null,
        visibleChart: true,
        stroke_len: null,
        qOil: null,
        shgnPumpType: null,
        shgnSPM: null,
        shgnLen: null,
        shgnS1D: null,
        shgnS2D: null,
        shgnS1L: null,
        shgnS2L: null,
        shgnTNL: null,
        shgnTNL: null,
        hPerfND: null,
        type: String,
        required: true,
        wellNumber: null,
        age: false,
        horizon: null,
        x: null,
        y: null,
        wctOkr: null,
        expMeth: null,
        tseh: null,
        gu: null,
        casOD: null,
        casID: null,
        hPerf: null,
        udl: null,
        pumpType: null,
        hPumpSet: null,
        tubOD: null,
        tubID: null,
        stopDate: null,
        PBubblePoint: null,
        gor:null,
        tRes: null,
        viscOilRc: null,
        viscWaterRc: null,
        densOil: null,
        densWater: null,
        qO: null,
        wct: null,
        bhp: null,
        pRes: null,
        hDyn: null,
        pAnnular: null,
        whp: null,
        lineP: null,
        piInput: null,
        pplInput: null,
        pResInput: null,
        qLInput: null,
        wctInput: null,
        gorInput: null,
        bhpInput: null,
        hDynInput: null,
        pAnnularInput: null,
        pManomInput: null,
        hPumpManomInput: null,
        whpInput: null,
        hPumpValue: null,
        curveSelect: 'pi',
        curveValue: '',
        curr: null,
        expChoose: null,
        CelButton: 'ql',
        bhpCurveButton: '',
        qlCelValue: null,
        bhpCelValue: null,
        piCelValue: null,
        expID: null,
        CelValue: null,
        analysisBox1: true,
        analysisBox2: true,
        analysisBox3: true,
        analysisBox4: true,
        analysisBox5: true,
        analysisBox6: true,
        analysisBox7: true,

        analysisBox8: true,
        menu: "MainMenu",
        ngdu: null,
        sk: null,
        grp_skin: false,
        newData: null,
        strokeLenDev: null,
        spmDev: null,
        expAnalysisData:{
            NNO1:null,
            NNO2:null,
            prs1:null,
            prs2:null,
            qoilEcn:null,
            qoilShgn:null,
            shgnParam:null,
            ecnParam:null,
            ecnNpv:null,
            shgnNpv:null,
            npvTable1:{},
            npvTable2:{},
            nno1:null,
            nno2:null,
        },

        qZhExpEcn:null,
        qOilExpEcn:null,
        qZhExpShgn:null,
        qOilExpShgn:null,
        param_eco:null,

        field: "UZN",
        wellIncl: null,
        dataNNO:"2020-11-01",

    };

  },

  methods: {

    setData: function(data) {
      if (this.method == "CurveSetting") {
        console.log('1');
        this.pResInput = data["Well Data"]["p_res"][0] + ' атм'
        this.piInput = data["Well Data"]["pi"][0].toFixed(2) + ' м³/сут/ат'
        this.qLInput = data["Well Data"]["q_l"][0].toFixed(0) + ' м³/сут'
        this.wctInput = data["Well Data"]["wct"][0] + ' %'
        this.gorInput = data["Well Data"]["gor"][0] + ' м³/т'
        this.bhpInput = data["Well Data"]["bhp"][0].toFixed(0) + ' атм'
        this.hDynInput = data["Well Data"]["h_dyn"][0].toFixed(0) + ' м'
        this.pAnnularInput = data["Well Data"]["p_annular"][0].toFixed(0) + ' атм'
        this.qlCelValue = JSON.parse(data.PointsData)["data"][2]["q_l"].toFixed(0) + ' м³/сут'
        this.bhpCelValue = JSON.parse(data.PointsData)["data"][2]["p"].toFixed(0) + ' атм'
        this.piCelValue = JSON.parse(data.PointsData)["data"][2]["pin"].toFixed(0) + ' атм'
        this.whpInput = data["Well Data"]["whp"][0].toFixed(0) + ' атм'
        this.pManomInput = data["Well Data"]["p_intake"][0] + ' атм'
        if(this.curveSelect == 'pmanom') {
          this.hPumpManomInput = data["Well Data"]["h_pump_point"][0] + ' м'  
        }
        this.curveLineData = JSON.parse(data.LineData)["data"]
        this.curvePointsData = JSON.parse(data.PointsData)["data"]
        this.qOil = this.curvePointsData[2]["q_oil"].toFixed(0)
        this.bhpPot = this.curvePointsData[1]["p"].toFixed(0)
        this.qlPot = this.curvePointsData[1]["q_l"].toFixed(0)
        this.pinPot = this.curvePointsData[1]["pin"].toFixed(0)
      } else {
        this.ngdu = data["Well Data"]["ngdu"][0]
        this.sk = data["Well Data"]["sk_type"][0]
        this.wellNumber = data["Well Data"]["well"][0].split("_")[1]
        this.age = data["Age"]
        this.horizon = data["Well Data"]["horizon"][0]
        this.expMeth = data["Well Data"]["exp_meth"][0]
        this.tseh = data["Well Data"]["tseh"][0]
        this.gu = data["Well Data"]["gu"][0]
        this.stroke_len = data["Well Data"]["stroke_len"][0]
        this.casOD = data["Well Data"]["cas_OD"][0]
        this.casID = data["Well Data"]["cas_ID"][0]
        this.hPerf = data["Well Data"]["h_up_perf_vd"][0]
        this.udl = data["udl"].toFixed(1)
        this.hPumpSet = data["Well Data"]["h_pump_set"][0]
        this.tubOD = data["Well Data"]["tub_OD"][0]
        this.tubID = data["Well Data"]["tub_ID"][0]
        this.stopDate = data["Well Data"]["stop_date"][0]
        this.pumpType = data["Well Data"]["pump_type"][0]
        this.PBubblePoint = data["Well Data"]["P_bubble_point"][0].toFixed(2)
        this.gor = data["Well Data"]["gor"][0].toFixed(0)
        this.tRes = data["Well Data"]["t_res"][0].toFixed(2)
        this.viscOilRc = data["Well Data"]["visc_oil_rc"][0].toFixed(2)
        this.viscWaterRc = data["Well Data"]["visc_wat_rc"][0].toFixed(2)
        this.densOil = data["Well Data"]["dens_oil"][0].toFixed(2)
        this.densWater = data["Well Data"]["dens_liq"][0].toFixed(2)
        this.qL = data["Well Data"]["q_l"][0].toFixed(0)
        this.qO = data["Well Data"]["q_o"][0].toFixed(0)
        this.wct = data["Well Data"]["wct"][0].toFixed(0)
        this.bhp = data["Well Data"]["bhp"][0].toFixed(0)
        this.pRes = data["Well Data"]["p_res"][0].toFixed(0)
        this.hDyn = data["Well Data"]["h_dyn"][0].toFixed(0)
        this.pAnnular = data["Well Data"]["p_annular"][0].toFixed(0)
        this.whp = data["Well Data"]["whp"][0].toFixed(0)
        this.lineP = data["Well Data"]["line_p"][0].toFixed(0)
        this.piInput = data["Well Data"]["pi"][0].toFixed(2) + ' атм'
        this.curr = data["Well Data"]["curr_bh"][0].toFixed(0)
        this.piCelValue = JSON.parse(data.PointsData)["data"][0]["pin"].toFixed(0) + ' атм'
        this.bhpCelValue = JSON.parse(data.PointsData)["data"][0]["p"].toFixed(0) + ' атм'
        this.wellIncl = data["Well Data"]["well"][0]
        this.hPerfND = data["Well Data"]["h_perf"][0]
        this.strokeLenDev = data["Well Data"]["stroke_len"][0]
        this.spmDev = data["Well Data"]["spm"][0]


        this.stopDate = this.stopDate.substring(0, 10)
        this.pResInput = this.pRes + ' атм'
        this.qLInput = this.qL + ' м³/сут'
        this.wctInput = this.wct + ' %'
        this.gorInput = this.gor + ' м³/т'
        this.bhpInput = this.bhp + ' атм'
        this.hDynInput = this.hDyn + ' м'
        this.pAnnularInput = this.pAnnular + ' атм'
        this.pManomInput = data["Well Data"]["p_intake"][0] + ' атм'
        this.hPumpManomInput = data["Well Data"]["h_pump_set"][0] + ' м'
        this.whpInput = this.whp + ' атм'
        this.qlCelButton = true
        this.qlCelValue = this.qLInput + ' м³/сут'
        this.hPumpValue = this.hPumpSet + ' м'
        
        
        if (this.expMeth == "ШГН") {
              this.expChoose = "ШГН"
        } else {
              this.expChoose = "ЭЦН"
        }
        if (this.age === true) {
          this.curveSelect = 'pi'
        } else {
          this.curveSelect = 'hdyn'
        }

        this.piButton = true
        this.curveLineData = JSON.parse(data.LineData)["data"]
        this.curvePointsData = JSON.parse(data.PointsData)["data"]
        this.qOil = this.curvePointsData[2]["q_oil"].toFixed(0)
        this.bhpPot = this.curvePointsData[1]["p"].toFixed(0)
        this.qlPot = this.curvePointsData[1]["q_l"].toFixed(0)
        this.pinPot = this.curvePointsData[1]["pin"].toFixed(0)
      }
    },
    setLine: function (value) {
      console.log(value)
      var ipr_points = [];
      var qo_points = [];
      var value2 = [];
      var ipr_points2 = [];
      var qo_points2 = [];
      var q_oil = [];
      var q_oil2 = [];


      _.forEach(value, function (values) {
        ipr_points = values.ipr_points;
        qo_points = values.qo_points;
        q_oil = values.q_oil
        ipr_points2.push(ipr_points);
        qo_points2.push("" + qo_points + "");
        q_oil2.push(q_oil);
      });

      this.data = [
        {
          name: "IPR (кривая притока)",
          x: qo_points2,
          y: ipr_points2,
          text: q_oil2,
          hovertemplate:  "<b>IPR (кривая притока)</b><br>" +
                          "Qж = %{x:.1f} м³/сут<br>" +
                          "Qн = %{text:.1f} т/сут<br>" +
                          "Pзаб = %{y:.1f} атм<extra></extra>",

          marker: {
            size: "15",
            color: "#FF0D18",
          },
        },
        {
          name: "Текущий режим",
          x: [],
          y: [],
          text: [],
          mode: "markers",
          hovertemplate:  "<b>Текущий режим</b><br>" +
                          "Qж = %{x:.1f} м³/сут<br>" +
                          "Qн = %{text:.1f} т/сут<br>" +
                          "Pзаб = %{y:.1f} атм<extra></extra>",
          marker: {
            size: "15",
            color: "#00A0E3",
          },
        },

        {
          name: "Потенциальный режим",
          x: [],
          y: [],
          text: [],
          mode: "markers",
          hovertemplate:  "<b>Потенциальный режим</b><br>" +
                          "Qж = %{x:.1f} м³/сут<br>" +
                          "Qн = %{text:.1f} т/сут<br>" +
                          "Pзаб = %{y:.1f} атм<extra></extra>",
          marker: {
            size: "15",
            color: "#FBA409",
          },
        },
        {
          name: "New Line",
          x: [],
          y: [],
          text: [],
          hovertemplate:  "<b>New Line</b><br>" +
                          "Qж = %{x:.1f} м³/сут<br>" +
                          "Qн = %{text:.1f} т/сут<br>" +
                          "Pзаб = %{y:.1f} атм<extra></extra>",

          marker: {
            size: "15",
            color: "#237DEB",
          },
        },
      ];
      this.chartOptions = {
        labels: qo_points2,
      };
    },
    updateLine:  function (value) {
      var ipr_points = [];
      var qo_points = [];
      var ipr_points2 = [];
      var qo_points2 = [];
      var q_oil = [];
      var q_oil2 = [];

      _.forEach(value, function (values) {
        ipr_points = values.ipr_points;
        qo_points = values.qo_points;
        q_oil = values.q_oil
        ipr_points2.push(ipr_points);
        qo_points2.push("" + qo_points + "");
        q_oil2.push(q_oil)
      });
      this.data[3]['x'] = qo_points2
      this.data[3]['y'] = ipr_points2
      this.data[3]['text'] = q_oil2
      console.log(JSON.stringify(this.data[0]['x']) == JSON.stringify(this.data[3]['x']))
      if (JSON.stringify(this.data[0]['x']) == JSON.stringify(this.data[3]['x']) && JSON.stringify(this.data[0]['y']) == JSON.stringify(this.data[3]['y'])) {
        this.data[3]['x'] = []
        this.data[3]['y'] = []
        this.data[3]['text'] = []
      }
    },
    setPoints: function (value) {
      this.data[1]['x'][0] = value[0]["q_l"]
      this.data[1]['y'][0] = value[0]["p"]
      this.data[1]['text'][0] = value[0]["q_oil"]
      this.data[2]['x'][0] = value[1]["q_l"]
      this.data[2]['y'][0] = value[1]["p"]
      this.data[2]['text'][0] = value[1]["q_oil"]

    },
    PotAnalysisMenu() {
      this.postCurveData()
      this.setLine(this.curveLineData)
      this.setPoints(this.curvePointsData)
      if (this.age) {
        this.postAnalysisNew();
        this.$modal.show('modalNewWell');
      } else {
        this.postAnalysisOld();
        this.$modal.show('modalOldWell');
      }
    },

    async ExpAnalysisMenu(){
        await this.NnoCalc()

         if(this.casOD < 127) {
          Vue.prototype.$notifyError('В ЭК 127 мм применение УЭЦН с габаритами 5 и 5А невозможно')
         }

        if (this.qlCelValue < 40){
            Vue.prototype.$notifyError("Не рекомендуется применение ЭЦН");
        }
        if (this.qlCelValue > 106) {
            Vue.prototype.$notifyError("Не рекомендуется применение ШГН");
        }
        this.qZhExpEcn=this.qlCelValue
        this.qOilExpEcn=this.qlCelValue*(1-(this.wctInput/100))*this.densOil

        if (this.qlCelValue<106){
            this.qZhExpShgn=this.qlCelValue
            this.qOilExpShgn=this.qlCelValue*(1-(this.wctInput/100))*this.densOil

        } else {
            this.qZhExpShgn=106
            this.qOilExpShgn=106*(1-(this.wctInput/100))*this.densOil
        }

        this.expAnalysisData.qoilShgn=this.qOilExpShgn
        this.expAnalysisData.qoilEcn=this.qOilExpEcn

        if(this.expAnalysisData.NNO1!=null) {
            await this.EconomParam();
        }


    },
    async EconomParam(){
        var prs1 = this.expAnalysisData.prs1;
        var prs2 = this.expAnalysisData.prs2;

        var nnoDayUp=moment(this.dataNNO, 'YYYY-MM-DD').toDate();
        var nnoDayFrom=moment(this.stopDate, 'YYYY-MM-DD').toDate();

        var date_diff=(nnoDayUp-nnoDayFrom)/(1000*3600*24);

        if (date_diff<365){
            date_diff=365;
        }



        if (prs1!=0 && prs2!=0){
            this.param_eco=1;
            await this.EconomCalc();
        } else if (prs1==0 && prs2==0){
            if(this.age){
                this.param_eco=1;
                await this.EconomCalc();
            } else {
                if(this.expMeth=="ШГН"){
                    this.expAnalysisData.NNO1=date_diff;
                    this.param_eco=1;
                    await this.EconomCalc();
                }else{
                    this.expAnalysisData.NNO2=date_diff;
                    this.param_eco=1;
                    await this.EconomCalc();
                }
            }
        } else if (prs1==0 && prs2!=0){
            this.param_eco=2;
            await this.EconomCalc();
        } else {
            this.param_eco=3;
            await this.EconomCalc();
        }
    },
    async EconomCalc(){
        console.log('Nno',typeof this.expAnalysisData.NNO1,typeof this.expAnalysisData.NNO2);



        let uri2="/ru/nnoeco?equip=1&org=5&param="+this.param_eco+"&qo="+this.qOilExpShgn+"&qzh="+this.qZhExpShgn+"&reqd="+this.expAnalysisData.NNO1+"&reqecn="+this.expAnalysisData.prs1+"&scfa=%D0%A4%D0%B0%D0%BA%D1%82&start=2021-01-21";
        let uri3="/ru/nnoeco?equip=2&org=5&param="+this.param_eco+"&qo="+this.qOilExpEcn+"&qzh="+this.qZhExpEcn+"&reqd="+this.expAnalysisData.NNO2+"&reqecn="+this.expAnalysisData.prs2+"&scfa=%D0%A4%D0%B0%D0%BA%D1%82&start=2021-01-21";

        const responses = await Promise.all([ this.axios.get(uri2), this.axios.get(uri3) ]);


            let data = responses[0].data;
            if(data) {

                this.expAnalysisData.shgnParam=data[12].godovoiShgnParam;
                this.expAnalysisData.shgnNpv=data[12].npv;
                this.expAnalysisData.npvTable1=data[12];
            }
            else {
                console.log('No data');
            }



            let data2 = responses[1].data;
            if(data2) {

                this.expAnalysisData.ecnParam=data2[12].godovoiEcnParam;
                this.expAnalysisData.ecnNpv=data2[12].npv;
                this.expAnalysisData.npvTable2=data2[12];

                if(this.qOilExpShgn!=null && this.qOilExpEcn!=null && this.expAnalysisData.NNO1!=null && this.expAnalysisData.NNO2!=null && this.expAnalysisData.shgnParam!=null && this.expAnalysisData.shgnNpv!=null && this.expAnalysisData.ecnParam!=null && this.expAnalysisData.ecnNpv!=null ){
                    this.$modal.show("modalExpAnalysis");
                }

            }
            else {
                console.log('No data');
            }



    },
    async NnoCalc(){
        let uri = "http://172.20.103.187:7575/api/nno/";

        this.eco_param=null;

        this.qZhExpEcn=this.qlCelValue
        this.qOilExpEcn=this.qlCelValue*(1-(this.wctInput/100))*this.densOil

        if (this.qlCelValue<106){
            this.qZhExpShgn=this.qlCelValue
            this.qOilExpShgn=this.qlCelValue*(1-(this.wctInput/100))*this.densOil

        } else {
            this.qZhExpShgn=106
            this.qOilExpShgn=106*(1-(this.wctInput/100))*this.densOil
        }

        if(this.wellNumber!=null){
            let jsonData = JSON.stringify(
                {"well_number": this.wellNumber,
                "exp_meth": "ШГН",
                }
            )

            let jsonData2 = JSON.stringify(
                {"well_number": this.wellNumber,
                "exp_meth": "ЭЦН",
                }
            )


            const responses = await Promise.all([ this.axios.post(uri, jsonData), this.axios.post(uri, jsonData2) ]);
            //microservise na SHGN NNO


            var data = JSON.parse(responses[0].data.Result)
            if (data) {
                this.expAnalysisData.NNO1=data.NNO
                this.expAnalysisData.qoilShgn=this.qOilExpShgn
                this.expAnalysisData.prs1=data.prs
            } else {
            console.log("No data");
            }

            var data2 = JSON.parse(responses[1].data.Result)
            if (data2) {
                this.expAnalysisData.NNO2=data2.NNO
                this.expAnalysisData.qoilEcn=this.qOilExpEcn
                this.expAnalysisData.prs2=data2.prs
            } else {
                console.log("No data");
            }



        }
    },

    InclMenu() {
        if (this.age === true) {
        Vue.prototype.$notifyWarning("Данные инклинометрии новой скважины отсутствуют");

      } else {
        this.$modal.show('modalIncl')
      }
    },

    getWellNumber(wellnumber) {
      this.visibleChart = true;
      let uri = "http://172.20.103.187:7575/api/pgno/"+ this.field + "/" + wellnumber + "/";
      this.axios.get(uri).then((response) => {
        var data = response.data;
        this.method = 'MainMenu'
        if (data["Error"] === "NoData"){
          Vue.prototype.$notifyError("Указанная скважина отсутствует");

        this.curveLineData = JSON.parse(data.LineData)["data"]
        this.curvePointsData = JSON.parse(data.PointsData)["data"]
        this.ngdu = 0
        this.sk = 0

          //Выбор скважины
        this.horizon = 0;
        this.expMeth = 0;
        this.tseh = 0;
        this.gu = 0;
        this.curr = 0;

        // Конструкция
        this.casOD = 0;
        this.casID = 0;
        this.hPerf = 0;
        this.udl = 0;

        //PVT
        this.PBubblePoint = 0;
        this.gor = 0;
        this.tRes = 0;
        this.densOil = 0;
        this.viscOilRc = 0;
        this.viscWaterRc = 0;
        this.densWater = 0;
        this.hdynValue = [this.hDynInput = 0, this.pAnnularInput = 0];

        //Оборудование
        this.pumpType = 0;
        this.hPumpSet = 0;
        this.tubOD = 0;
        this.tubID = 0;
        this.stopDate = 0;

        //Технологический  режим
        this.qL = 0;
        this.qO = 0;
        this.wct = 0;
        this.bhp = 0;
        this.pRes = 0;
        this.hDyn = 0;
        this.pAnnular = 0;
        this.whp = 0;
        this.lineP = 0;

        //Настройка кривой притока
        this.pResInput = 0;
        this.piInput = 0;
        this.qLInput = 0;
        this.bhpInput = 0;
        this.wctInput = 0;
        this.gorInput = 0;
        this.hDynInput = 0;
        this.pAnnularInput = 0;
        this.hPumpManomInput = 0;
        this.whpInput = 0;

        //Параметры подбора
        this.hPumpValue = 0;
        this.qlCelValue = 0;
        this.bhpCelValue = 0;
        this.piCelValue = 0;


        } else if(data["Age"] === true) {


          this.curveLineData = JSON.parse(data.LineData)["data"]
          this.curvePointsData = JSON.parse(data.PointsData)["data"]
          this.horizon = data["Well Data"]["horizon"][0]
          this.curveSelect = 'pi'
          this.age = data["Age"]


          this.PBubblePoint = data["Well Data"]["P_bubble_point"][0].toFixed(1)
          this.gor = data["Well Data"]["gor"][0].toFixed(1)
          this.tRes = data["Well Data"]["t_res"][0].toFixed(1)
          this.viscOilRc = data["Well Data"]["visc_oil_rc"][0].toFixed(1)
          this.viscWaterRc = data["Well Data"]["visc_wat_rc"][0].toFixed(1)
          this.densOil = data["Well Data"]["dens_oil"][0].toFixed(1)
          this.densWater = data["Well Data"]["dens_liq"][0].toFixed(1)
          this.hPumpValue = data["Well Data"]["h_pump_set"][0].toFixed(0) + ' м'
          
          Vue.prototype.$notifyWarning("Нсп установлено на 150м выше ВДП по умолчанию")




          Vue.prototype.$notifyWarning("Новая скважина");

        this.ngdu = 0
        this.sk = 0

          //Выбор скважины
        this.expMeth = 0;
        this.tseh = 0;
        this.gu = 0;
        this.curr = 0;

        // Конструкция
        this.casOD = 168;
        this.casID = 150;
        this.hPerf = data["Well Data"]["h_up_perf_vd"][0].toFixed(0);
        this.udl = 0;

        //Оборудование
        this.pumpType = 0;
        this.hPumpSet = 0
        this.tubOD = 73;
        this.tubID = 62;
        this.stopDate = 0;

        //Технологический  режим
        this.qL = 0;
        this.qO = 0;
        this.wct = 0;
        this.bhp = 0;
        this.pRes = 0;
        this.hDyn = 0;
        this.pAnnular = 0;
        this.whp = 0;
        this.lineP = 0;

        //Настройка кривой притока
        this.pResInput = 0 + ' атм';
        this.piInput = 0 + ' м³/сут/ат';
        this.qLInput = 0 + ' м³/сут';
        this.bhpInput = 0 + ' атм';
        this.wctInput = 0 + ' %';
        this.gorInput = this.gor + ' м³/т';
        this.hDynInput = 0 + ' м';
        this.pAnnularInput = 0 + ' атм';
        this.hPumpManomInput = 0 + ' атм';
        this.whpInput = 0 + ' атм';
        this.pManomInput = 0 + ' атм'
        this.expChoose = 'ШГН'

        //Параметры подбора
        this.qlCelValue = 0 + ' м³/сут';
        this.bhpCelValue = 0 + ' атм';
        this.piCelValue = 0 + ' атм';

        } else if (data["Age"] === false){
        this.setData(data)
        }
          this.$emit('LineData', this.curveLineData)
          this.$emit('PointsData', this.curvePointsData)
          //this.NnoCalc();
        }
      );



    },

    postCurveData(value) {
      this.visibleChart = true;
      console.log(value)
        let uri = "http://172.20.103.187:7575/api/pgno/"+ this.field + "/" + this.wellNumber + "/";
        // api/pgno/UZN/
        // KMB
      if (this.CelButton == 'ql') {
        this.CelValue = this.qlCelValue
      } else if (this.CelButton == 'bhp') {
        this.CelValue = this.bhpCelValue
      } else if (this.CelButton == 'pin') {
        this.CelValue = this.piCelValue
      }



      let jsonData = JSON.stringify(
        {
        "curveSelect": this.curveSelect,
        "presValue": this.pResInput.split(' ')[0],
        "piValue": this.piInput.split(' ')[0],
        "qlValue": this.qLInput.split(' ')[0],
        "bhpValue": this.bhpInput.split(' ')[0],
        "hdynValue": [this.hDynInput.split(' ')[0], this.pAnnularInput.split(' ')[0]],
        "pmanomValue": [this.pManomInput.split(' ')[0], this.hPumpManomInput.split(' ')[0]],
        "whpValue": this.whpInput.split(' ')[0],
        "wctValue": this.wctInput.split(' ')[0],
        "gorValue": this.gorInput.split(' ')[0],
        "expSelect": this.expChoose,
        "hPumpValue": this.hPumpValue.split(' ')[0],
        "celSelect": this.CelButton,
        "celValue": this.CelValue.split(' ')[0],
        "menu": "MainMenu",
        "well_age": this.age,
        "grp_skin": this.grp_skin,
        "analysisBox1": this.analysisBox1,
        "analysisBox2": this.analysisBox2,
        "analysisBox3": this.analysisBox3,
        "analysisBox4": this.analysisBox4,
        "analysisBox5": this.analysisBox5,
        "analysisBox6": this.analysisBox6,
        "analysisBox7": this.analysisBox7,
        "analysisBox8": this.analysisBox8
                   }
      )

        if(this.pResInput * 1 <= this.bhpInput * 1 || this.pResInput * 1 <= this.bhpCelValue * 1) {
          Vue.prototype.$notifyError("Pзаб не должно быть больше чем Рпл");
          } else {
            this.axios.post(uri, jsonData).then((response) => {
              var data = response.data;
              if (data) {
          this.method = "CurveSetting"
          if(data["Well Data"]["pi"][0] * 1 < 0) {
            Vue.prototype.$notifyWarning("Pзаб не должно быть больше чем Рпл")
          } else {
          if(this.hPumpValue > this.hPerf){
          Vue.prototype.$notifyWarning("Насос установлен ниже перфорации")
          }
          this.setData(data)
          this.$emit('LineData', this.curveLineData)
          this.$emit('PointsData', this.curvePointsData)
      
          
          if(this.qlPot < this.qlCelValue && this.CelButton == 'ql'){
          Vue.prototype.$notifyError("Целевой режим превышает тех. потенциал")
          console.log(this.qlPot, this.qlCelValue, this.bhpPot, this.bhpCelValue, this.pinPot, this.piCelValue);
          } else if(this.bhpPot > this.bhpCelValue && this.CelButton == 'bhp'){
          Vue.prototype.$notifyError("Целевой режим превышает тех. потенциал")
          console.log(this.qlPot, this.qlCelValue, this.bhpPot, this.bhpCelValue, this.pinPot, this.piCelValue);
          } else if(this.pinPot < this.piCelValue && this.CelButton == 'pin'){
          Vue.prototype.$notifyError("Целевой режим превышает тех. потенциал")
          console.log(this.qlPot, this.qlCelValue, this.bhpPot, this.bhpCelValue, this.pinPot, this.piCelValue);
          }
          }

          } else {
        }
      });
            }

    },

    postAnalysisOld() {
      this.visibleChart = true;
      let uri = "http://172.20.103.187:7575/api/pgno/" + this.field + "/" + this.wellNumber + "/";
      if (this.CelButton == 'ql') {
        this.CelValue = this.qlCelValue
      } else if (this.CelButton == 'bhp') {
        this.CelValue = this.bhpCelValue
      } else if (this.CelButton == 'pin') {
        this.CelValue = this.piCelValue
      }

      let jsonData = JSON.stringify(
        {
        "curveSelect": this.curveSelect,
        "presValue": this.pResInput.split(' ')[0],
        "piValue": this.piInput.split(' ')[0],
        "qlValue": this.qLInput.split(' ')[0],
        "bhpValue": this.bhpInput.split(' ')[0],
        "hdynValue": [this.hDynInput.split(' ')[0], this.pAnnularInput.split(' ')[0]],
        "pmanomValue": [this.pManomInput.split(' ')[0], this.hPumpManomInput.split(' ')[0]],
        "whpValue": this.whpInput.split(' ')[0],
        "wctValue": this.wctInput.split(' ')[0],
        "gorValue": this.gorInput.split(' ')[0],
        "expSelect": this.expChoose,
        "hPumpValue": this.hPumpValue.split(' ')[0],
        "celSelect": this.CelButton,
        "celValue": this.CelValue.split(' ')[0],
        "menu": "PotencialAnalysis",
        "well_age": this.age,
        "grp_skin": this.grp_skin,
        "analysisBox1": this.analysisBox1,
        "analysisBox2": this.analysisBox2,
        "analysisBox3": this.analysisBox3,
        "analysisBox4": this.analysisBox4,
        "analysisBox5": this.analysisBox5,
        "analysisBox6": this.analysisBox6,
        "analysisBox7": this.analysisBox7,
        "analysisBox8": this.analysisBox8
                   }
      )
      this.axios.post(uri, jsonData).then((response) => {
        var data = response.data;
        if (data) {
          console.log(data)
          this.method = "CurveSetting"
          this.newData = data["Well Data"]
          // this.setData(data)
          this.newCurveLineData = JSON.parse(data.LineData)["data"]
          this.newPointsData = JSON.parse(data.PointsData)["data"]
          this.updateLine(this.newCurveLineData)
          this.setPoints(this.newPointsData)
          // this.$emit('LineData', this.curveLineData)
          // this.$emit('PointsData', this.curvePointsData)
          } else {
        }
      });
    },

    postAnalysisNew() {
      this.visibleChart = true;
      console.log("POST NEW WELL")
      let uri = "http://172.20.103.187:7575/api/pgno/"+ this.field + "/" + this.wellNumber + "/";
      if (this.CelButton == 'ql') {
        this.CelValue = this.qlCelValue
      } else if (this.CelButton == 'bhp') {
        this.CelValue = this.bhpCelValue
      } else if (this.CelButton == 'pin') {
        this.CelValue = this.piCelValue
      }

      let jsonData = JSON.stringify(
        {
        "curveSelect": this.curveSelect,
        "presValue": this.pResInput.split(' ')[0],
        "piValue": this.piInput.split(' ')[0],
        "qlValue": this.qLInput.split(' ')[0],
        "bhpValue": this.bhpInput.split(' ')[0],
        "hdynValue": [this.hDynInput.split(' ')[0], this.pAnnularInput.split(' ')[0]],
        "pmanomValue": [this.pManomInput.split(' ')[0], this.hPumpManomInput.split(' ')[0]],
        "whpValue": this.whpInput.split(' ')[0],
        "wctValue": this.wctInput.split(' ')[0],
        "gorValue": this.gorInput.split(' ')[0],
        "expSelect": this.expChoose,
        "hPumpValue": this.hPumpValue.split(' ')[0],
        "celSelect": this.CelButton,
        "celValue": this.CelValue.split(' ')[0],
        "menu": "PotencialAnalysis",
        "well_age": this.age,
        "grp_skin": this.grp_skin,
        "analysisBox1": this.analysisBox1,
        "analysisBox2": this.analysisBox2,
        "analysisBox3": this.analysisBox3,
        "analysisBox4": this.analysisBox4,
        "analysisBox5": this.analysisBox5,
        "analysisBox6": this.analysisBox6,
        "analysisBox7": this.analysisBox7,
        "analysisBox8": this.analysisBox8
        }
      )
      this.axios.post(uri, jsonData).then((response) => {
        var data = response.data;
        if (data) {
          console.log(data)
          this.newData = data["Well Data"]
          this.method = "CurveSetting"
          this.newCurveLineData = JSON.parse(data.LineData)["data"]
          this.newPointsData = JSON.parse(data.PointsData)["data"]
          this.updateLine(this.newCurveLineData)
          this.setPoints(this.newPointsData)
          this.wctOkr = data["Well Data"]["wct"][0].toFixed(0)
          // this.$emit('LineData', this.curveLineData)
          // this.$emit('PointsData', this.curvePointsData)
          } else {
        }
      });
    },
    setGraphOld() {
      this.updateLine(this.newCurveLineData)
      this.setPoints(this.newPointsData)
      this.$modal.hide('modalOldWell');
      this.$eventBus.$emit('newCurveLineData', this.newCurveLineData)
      this.$eventBus.$emit('newPointsData', this.newPointsData)
      this.pResInput = this.newData["p_res"][0].toFixed(0) + ' атм'
      this.piInput = this.newData["pi"][0].toFixed(2) + ' м³/сут/ат'
      this.qLInput = this.newData["q_l"][0].toFixed(0) + ' м³/сут'
      this.bhpInput = this.newData["bhp"][0].toFixed(0) + ' атм'
      this.hDynInput = this.newData["h_dyn"][0].toFixed(0) + ' м'
      this.pAnnularInput = this.newData["p_annular"][0].toFixed(0) + ' атм'
      this.pManomInput = this.newData["p_intake"][0].toFixed(0) + ' атм'
      this.hPumpManomInput = this.newData["h_pump_set"][0].toFixed(0) + ' м'
      this.whpInput = this.newData["whp"][0].toFixed(0) + ' атм'
      this.wctInput = this.newData["wct"][0].toFixed(0) + ' %'
      this.qlCelValue = this.newPointsData[0]["q_l"].toFixed(0) + ' м³/сут'
      this.bhpCelValue = this.newPointsData[0]["p"].toFixed(0) + ' атм'
      this.piCelValue = this.newPointsData[0]["pin"].toFixed(0) + ' атм'
    },

     setGraphNew() {
      Vue.prototype.$notifyWarning("Нсп установлено на 150м выше ВДП по умолчанию")
      this.updateLine(this.newCurveLineData)
      this.setPoints(this.newPointsData)
      this.$modal.hide('modalNewWell');
      this.$eventBus.$emit('newCurveLineData', this.newCurveLineData)
      this.$eventBus.$emit('newPointsData', this.newPointsData)
      this.pResInput = this.newData["p_res"][0].toFixed(0) + ' атм'
      this.piInput = this.newData["pi"][0].toFixed(2) + ' м³/сут/ат'
      this.wctInput = this.newData["wct"][0].toFixed(0) + ' %'
      this.hPumpValue = this.newData["h_pump_set"][0].toFixed(0) + ' м'
      console.log(this.newData)
    },

    onCompareNpv() {
      if(this.expAnalysisData.ecnNpv > this.expAnalysisData.shgnNpv) {
        this.expChoose = "ЭЦН"
      } else {
        this.expChoose = "ШГН"
      }
      this.postCurveData();
      this.$modal.hide("modalExpAnalysis");
    },

    onShowTable() {
      console.log('mytable');
      this.$modal.hide("modalExpAnalysis");
      this.$modal.show("tablePGNO")
    },

    onPgnoClick() {
        if(this.qlPot < this.qlCelValue && this.CelButton == 'ql'){
          Vue.prototype.$notifyError("Целевой режим превышает тех. потенциал")
          console.log(this.qlPot, this.qlCelValue, this.bhpPot, this.bhpCelValue, this.pinPot, this.piCelValue);
          } else if(this.bhpPot > this.bhpCelValue && this.CelButton == 'bhp'){
          Vue.prototype.$notifyError("Целевой режим превышает тех. потенциал")
          console.log(this.qlPot, this.qlCelValue, this.bhpPot, this.bhpCelValue, this.pinPot, this.piCelValue);
          } else if(this.pinPot < this.piCelValue && this.CelButton == 'pin'){
          Vue.prototype.$notifyError("Целевой режим превышает тех. потенциал")
          console.log(this.qlPot, this.qlCelValue, this.bhpPot, this.bhpCelValue, this.pinPot, this.piCelValue);
          } else {
        if(this.expChoose == 'ШГН'){
          if(this.visibleChart) {
        let uri = "http://172.20.103.187:7575/api/pgno/shgn";
        let jsonData = JSON.stringify(
        {
        "ql_cel": this.qlCelValue.split(' ')[0],
        "h_pump_set": this.hPumpValue.split(' ')[0],
        "sk_type": this.sk,
        "dens_oil": this.densOil,
        "dens_water": this.densWater,
        "wct": this.wctInput.split(' ')[0],
        "stroke_len": this.stroke_len
        }
        )
        this.axios.post(uri, jsonData).then((response) => {
          var data = JSON.parse(response.data);
          console.log(data);
          if(data) {
            if (data["error"] == "NoIntersection") {
              Vue.prototype.$notifyWarning("По выбранным параметрам насос подобрать невозможно, попробуйте изменить глубину спуска или ожидаемый дебит");
            } else {
            if(this.sk == "ПШГН" || this.sk == "0") {
              Vue.prototype.$notifyWarning("Тип СК на скважине не определен")
            } 
          Vue.prototype.$notifyWarning("Раздел 'Подбор ШГН' находится в разработке")
          this.shgnPumpType = data["pump_type"]
          this.shgnSPM = data["spm"].toFixed(0)
          this.shgnLen = data["stroke_len"]
          this.shgnS1D = data["s1d"].toFixed(0)
          this.shgnS2D = data["s2d"].toFixed(0)
          this.shgnS1L = data["s1l"].toFixed(0)
          this.shgnS2L = data["s2l"].toFixed(0)
          this.shgnTN = data["tn"]
          this.shgnTNL = data["tn_l"]
          this.visibleChart = !this.visibleChart
            }
          } else {
          }
          })
    } else {
      this.visibleChart = !this.visibleChart
      this.postCurveData()
    }
        } else {
          Vue.prototype.$notifyWarning("Раздел 'Подбор УЭЦН' не разработан")
        }

    }
  }},
};
</script>

<style scoped>
</style>
