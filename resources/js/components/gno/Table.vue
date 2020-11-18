<template>
  <div class="main col-md-12 col-lg-12 row">
    <div class="tables-two col-xs-12 col-sm-7 col-md-7 col-lg-8 col-xl-9">
      <div class="tables-string-gno3">

        <modal name="modalIncl" :width="1150" :height="500" style="background:transparent">
          <div class="modal-bign">
            <div class="Table" align="center" x:publishsource="Excel">
              <gno-incl-table :wellNumber="wellNumber"></gno-incl-table>
            </div>
          </div>
        </modal>



        <modal name="modalOldWell" :width="1150" :height="450" :adaptive="true" >
          <div class="modal-bign" >
            <Plotly :data="data" :layout="layout" :display-mode-bar="false"></Plotly>
          </div>
          <div class="modal-analysis-menu">
            <div class="form-check">
              <input v-model="analysisBox1" class="checkbox-modal-analysis-menu" @change="postAnalysisOld()" type="checkbox">
              <label for="checkbox1" class="checkbox-modal-analysis-menu-label">Рпл = Рнач</label>
            </div>
            <div class="form-check">
              <input v-model="analysisBox2" class="checkbox-modal-analysis-menu" @change="postAnalysisOld()" type="checkbox">
              <label for="checkbox1" class="checkbox-modal-analysis-menu-label">Н дин = Ндин мин</label>
            </div>
            <div class="form-check">
              <input v-model="analysisBox3" class="checkbox-modal-analysis-menu" @change="postAnalysisOld()" type="checkbox">
              <label for="checkbox1" class="checkbox-modal-analysis-menu-label">Рзаб пот = Рнас*</label>
            </div>
            <div class="form-check">
              <input v-model="analysisBox4" class="checkbox-modal-analysis-menu" @change="postAnalysisOld()" type="checkbox">
              <label for="checkbox1" class="checkbox-modal-analysis-menu-label">Qж = Qж АСМА</label>
            </div>
            <div class="form-check">
              <input v-model="analysisBox5" class="checkbox-modal-analysis-menu" @change="postAnalysisOld()" type="checkbox">
              <label for="checkbox1" class="checkbox-modal-analysis-menu-label">Обв = Обв АСМА</label>
            </div>
          </div>
        </modal>
        <modal name="modalNewWell" :width="1150" :height="450" :adaptive="true" >
          <div class="modal-bign" >
            <Plotly :data="data" :layout="layout" :display-mode-bar="false"></Plotly>
          </div>
          <div class="modal-analysis-menu">
            <div><input v-model="analysisBox6" class="checkbox1" @change="postAnalysisNew()" type="checkbox">Pпл = P по окр.
            </div>
            <div><input v-model="analysisBox7" class="checkbox1" @change="postAnalysisNew()" type="checkbox">К пр = К по окр.
            </div>
            <div><input v-model="analysisBox8" class="checkbox1" @change="postAnalysisNew()" type="checkbox">Рзаб пот = Рнас*
            </div>
          </div>
        </modal>

        <modal name="modalExpAnalysis" :width="1150" :height="395" :adaptive="true" class="chart" style="margin-left:100px;">
          <div class="modal-bign2">
            <gno-chart-bar :data="expAnalysisData"></gno-chart-bar>
          </div>
        </modal>

        <modal name="modalPGNO" :width="1150" :height="400" :adaptive="true">
          <div class="modal-bign3">
            Тест 3
          </div>
        </modal>
        <gno-line-points-chart></gno-line-points-chart>
      </div>




      <div class="tables-string-gno4 col-6">
        <div class="tables-string-gno4-inner">
          <div class="select-well col-12">Настройка кривой притока</div>
          <div class="col-8 relative">
            <div class="col-6">
              <div class="cell4-gno col-4">
                Рпл
              </div>
              <div class="cell4-gno table-border-gno cell4-gno-second col-5">
                <input v-model="pResInput" type="text" class="square2" />
              </div>

              <div class="cell4-gno table-border-gno-top col-4">
                <input v-model="curveSelect" class="checkbox" value="pi" type="radio" name="set" />
                Кпрод
              </div>
              <div
                class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
              >
                <!-- <input :disabled="curveSelect != 'pi'" v-model="piInput" @ type="string" class="square1" /> -->
                <input :disabled="curveSelect != 'pi'" v-model="piInput" @change="postCurveData()" type="string" class="square2" />
              </div>

              <div class="cell4-gno table-border-gno-top col-4">
                <input v-model="curveSelect" class="checkbox" value="ql" type="radio" name="set" />
                Qж
              </div>
              <div
                class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
              >
                <input :disabled="curveSelect != 'ql'" v-model="qLInput" @change="postCurveData()" type="text" class="square2" />
              </div>
            </div>
          </div>

          <div class="col-4 relative">
            <div class="cell4-gno col-4">
              Обв.
            </div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-5">
              <input v-model="wctInput" @change="postCurveData()" type="text" class="square2" />
            </div>

            <div class="cell4-gno table-border-gno-top col-4">
              ГФ.
            </div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              <input v-model="gorInput" @change="postCurveData()" type="text" class="square2" />
            </div>
          </div>

          <br />
          <br />
          <div class="col-12 relative left-center">
            <div class="cell4-gno col-4 table-border-gno-top">
              <input v-model="curveSelect" value="bhp" :disabled="curveSelect == 'pi'" class="checkbox2" type="radio" name="set2" />
              <div class="text2">Рзаб</div>
            </div>
            <div
              class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
            >
              <input :disabled="curveSelect != 'bhp'" v-model="bhpInput" @change="postCurveData()" type="text" class="square2" />
            </div>
            <div
              class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
            ></div>
            <div
              class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
            ></div>
          </div>

          <div class="col-12 relative left-center">
            <div class="cell4-gno col-4 table-border-gno-top">
              <input v-model="curveSelect" value="hdyn" :disabled="curveSelect == 'pi'" class="checkbox2" type="radio" name="set2" />
              <div class="text2">Ндин</div>
            </div>
            <div
              class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
            >
              <input :disabled="curveSelect != 'hdyn'" v-model="hDynInput" type="text" class="square2" />
            </div>
            <div
              class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
            >
              Рзат
            </div>
            <div
              class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
            >
              <input :disabled="curveSelect != 'hdyn'" v-model="pAnnularInput" type="text" class="square2" />
            </div>
          </div>

          <div class="col-12 relative left-center">
            <div class="cell4-gno col-4 table-border-gno-top">
              <input v-model="curveSelect" value="pmanom" :disabled="curveSelect == 'pi'" class="checkbox2" type="radio" name="set2" />
              <div class="text2">Рманом</div>
            </div>
            <div
              class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
            >
              <input :disabled="curveSelect != 'pmanom'" v-model="pManomInput" type="text" class="square2" />
            </div>
            <div
              class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
            >
              Нсп маном
            </div>
            <div
              class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
            >
              <input :disabled="curveSelect != 'pmanom'" v-model="hPumpManomInput" type="text" class="square2" />
            </div>
          </div>

          <div class="col-12 relative left-center">
            <div class="cell4-gno col-4 table-border-gno-top">
              <input v-model="curveSelect" value="whp" :disabled="curveSelect == 'pi'" class="checkbox2" type="radio" name="set2" />
              <div class="text2">Рбуф (ФЭ)</div>
            </div>
            <div
              class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
            >
              <input :disabled="curveSelect != 'whp'" v-model="whpInput" type="text" class="square2" />
            </div>
            <div
              class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
            ></div>
            <div
              class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
            ></div>
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
              <input class="checkbox3" value="ШГН" v-model="expChoose" :checked="expChoose == 'ШГН'" type="radio"  name="gno10" />
            </div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-3">
              <div class="text3">ЭЦН</div>
              <input class="checkbox3" value="ЭЦН" v-model="expChoose" :checked="expChoose == 'ЭЦН'" type="radio"  name="gno10" />
            </div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-3">
              <div class="text3">Нсп</div>
            </div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-2">
              <input v-model="hPumpValue" type="text" class="square2" />
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
                <input v-model="qlCelValue" :disabled="CelButton != 'ql'" type="text" class="square2" />
              </div>
              <div class="text3">Рзаб</div>
              <input v-model="CelButton" class="checkbox3" value="bhp" type="radio" name="gno11" />
            </div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-3">
              <div class="target">
                <input v-model="bhpCelValue" :disabled="CelButton != 'bhp'" type="text"  class="square2" />
              </div>
              <div class="text3">Pnp</div>
              <input v-model="CelButton" class="checkbox3" value="pin" type="radio" name="gno11" />
            </div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-2">
              <input v-model="piCelValue" :disabled="CelButton != 'pin'" type="text" class="square2" />
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
      <div class="tables-string-gno6 col-12" @click="PgnoMenu()">
        Подбор ГНО
      </div>
    </div>
    <div class="tables-one col-xs-12 col-sm-5 col-md-5 col-lg-3 col-xl-3">
      <div class="tables-string-gno col-12">
        <div class="select-well col-12">Выбор скважины</div>
        <div class="cell4-gno col-7">Месторождение</div>
        <div class="cell4-gno table-border-gno cell4-gno-second col-5">
          <select class="select-gno2">
            <option value="" hidden>Выбор</option>
            <option>Узень</option>
            <option>Карамандыбас</option>
          </select>
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Скважина №</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          <input v-model="wellNumber" type="text" @change="getWellNumber(wellNumber)" class="square2" />
        </div>
        <div class="cell4-gno table-border-gno-top col-7">
          Новая скважина <input v-model="age" class="checkbox0" type="checkbox" />
        </div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          с ГРП <input class="checkbox0" type="checkbox" />
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Пласт</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          {{horizon}}
        </div>

        <div class="cell4-gno table-border-gno-top col-7">
          Способ эксплуатации
        </div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          <div class="center">
            {{expMeth}}
          </div>
        </div>

        <div class="cell4-gno table-border-gno-top col-7">
          {{tseh}}
        </div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          {{gu}}
        </div>

        <div class="cell4-gno table-border-gno-top col-7">
          No Data
        </div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          No Data
        </div>
      </div>
      <div class="tables-string-gno1-1">
        <div class="select-well col-12">Конструкция</div>
        <div class="cell4-gno col-7">Наружн. ØЭК</div>
        <div class="cell4-gno table-border-gno cell4-gno-second col-5">
          {{casOD}} мм
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Внутрен. ØЭК</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          {{casID}} мм
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Нперф.(ВДП м)</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          {{hPerf}} м
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Удл. на Нперф.</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          {{udl}} м
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Текущий забой</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          No Data
        </div>
      </div>
      <div class="inclinom" @click="InclMenu()">Инклинометрия</div>
      <div class="spoiler">
        <input
          style="width: 845px; height: 35px;"
          type="checkbox"
          tabindex="-1"
        />
        <div class="box">
          <div class="select-well col-12">
            <div class="select-gno">Оборудование</div>
          </div>
          <span class="closer">Скрыть</span><span class="open">Показать</span>
          <blockquote>
            <div class="cell4-gno table-border-gno-top col-7">
              Станок-качалка
            </div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              No Data
            </div>

            <div class="cell4-gno table-border-gno-top col-7">
              Диаметр насоса
            </div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              {{pumpType}}
            </div>

            <div class="cell4-gno table-border-gno-top col-7">Код насоса</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              No Data
            </div>

            <div class="cell4-gno table-border-gno-top col-7">Нсп</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              {{hPumpSet}} м
            </div>

            <div class="cell4-gno table-border-gno-top col-7">Наружн. фНКТ</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              {{tubOD}} м
            </div>
            <div class="cell4-gno table-border-gno-top col-7">Внутр. фНКТ</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              {{tubID}} мм
            </div>
            <div class="cell4-gno table-border-gno-top col-7">Дата запуска</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              {{stopDate}}
            </div>
          </blockquote>
        </div>
      </div>

      <div class="spoiler">
        <input
          style="width: 845px; height: 45px;"
          type="checkbox"
          tabindex="-1"
        />
        <div class="box">
          <div class="select-well col-12">
            <div class="select-gno">PVT</div>
          </div>
          <span class="closer">Скрыть</span><span class="open">Показать</span>
          <blockquote>
            <div class="cell4-gno col-7">Рнас</div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-5">
              {{PBubblePoint}} атм
            </div>

            <div class="cell4-gno table-border-gno-top col-7">ГФ</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              {{gor}}
            </div>

            <div class="cell4-gno table-border-gno-top col-7">Т пл</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              {{tRes}} ℃
            </div>

            <div class="cell4-gno table-border-gno-top col-7">
              Вязкость нефти (пл.усл.)
            </div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              {{viscOilRc}} сПз
            </div>

            <div class="cell4-gno table-border-gno-top col-7">
              Вязкость воды (пл.усл.)
            </div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              {{viscWaterRc}} сПз
            </div>

            <div class="cell4-gno table-border-gno-top col-7">
              Плотность нефти
            </div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              {{densOil}} г/cм³
            </div>
            <div class="cell4-gno table-border-gno-top col-7">
              Плотность воды
            </div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              {{densWater}} г/cм³
            </div>
          </blockquote>
        </div>
      </div>

      <div class="tables-string-gno2">
        <div class="select-well col-12">Технологический режим</div>
        <div class="cell4-gno col-7">Qж</div>
        <div class="cell4-gno table-border-gno cell4-gno-second col-5">
          {{qL}} м3/сут
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Qн</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          {{qO}} т/сут
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Обвод</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          {{wct}} %
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Рзаб</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          {{bhp}} атм
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Рпл</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          {{pRes}} ат
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Ндин</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          {{hDyn}} м
        </div>
        <div class="cell4-gno table-border-gno-top col-7">Рзат</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          {{pAnnular}} атм
        </div>
        <div class="cell4-gno table-border-gno-top col-7">Рбуф</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          {{whp}} атм
        </div>
        <div class="cell4-gno table-border-gno-top col-7">Рлин</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          {{lineP}} атм
        </div>
      </div>
    </div>
    <notifications position="top"></notifications>
  </div>
</template>

<script>
import { Plotly } from "vue-plotly";
import { EventBus } from "../../event-bus.js";
import NotifyPlugin from "vue-easy-notify";
import 'vue-easy-notify/dist/vue-easy-notify.css'



Vue.use(NotifyPlugin)
Vue.component("Plotly", Plotly);
export default {
  data: function () {
    return {
      expAnalysisData:{},

      layout: {
        width: 950,
        height: 450,
        showlegend: true,

        xaxis: {
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
          hoverformat: ".1f",
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
        type: String,
        required: true,
        wellNumber: null,
        age: false,
        horizon: null,
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
        expChoose: 'ШГН',
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
        grp_skin: false,
        qZhExpEcn:null,
        qOilExpEcn:null,
        qZhExpShgn:null,
        qOilExpShgn:null,
    };

  },

  methods: {
    setData: function(data) {
      if (this.method == "CurveSetting") {
        this.pResInput = data["Well Data"]["p_res"][0]
        this.piInput = data["Well Data"]["pi"][0]
        this.qLInput = data["Well Data"]["q_l"][0]
        this.wctInput = data["Well Data"]["wct"][0]
        this.gorInput = data["Well Data"]["gor"][0]
        this.bhpInput = data["Well Data"]["bhp"][0]
        this.hDynInput = data["Well Data"]["h_dyn"][0]
        this.pAnnularInput = data["Well Data"]["p_annular"][0]
        this.qlCelValue = JSON.parse(data.PointsData)["data"][2]["q_l"],
        this.bhpCelValue = JSON.parse(data.PointsData)["data"][2]["p"],
        this.pManomInput = 0
        this.hPumpManomInput = 0
        this.whpInput = data["Well Data"]["whp"][0]
        this.curveLineData = JSON.parse(data.LineData)["data"]
        this.curvePointsData = JSON.parse(data.PointsData)["data"]
      } else {
        this.wellNumber = data["Well Data"]["well"][0].split("_")[1]
        this.age = data["Age"]
        this.horizon = data["Well Data"]["horizon"][0]
        this.expMeth = data["Well Data"]["exp_meth"][0]
        this.tseh = data["Well Data"]["tseh"][0]
        this.gu = data["Well Data"]["gu"][0]
        this.casOD = data["Well Data"]["cas_OD"][0]
        this.casID = data["Well Data"]["cas_ID"][0]
        this.hPerf = data["Well Data"]["h_perf"][0]
        this.udl = data["Well Data"]["h_up_perf_md"][0]
        this.hPumpSet = data["Well Data"]["h_pump_set"][0]
        this.tubOD = data["Well Data"]["tub_OD"][0]
        this.tubID = data["Well Data"]["tub_ID"][0]
        this.stopDate = data["Well Data"]["stop_date"][0]
        this.pumpType = data["Well Data"]["pump_type"][0]
        this.PBubblePoint = data["Well Data"]["P_bubble_point"][0]
        this.gor = data["Well Data"]["gor"][0]
        this.tRes = data["Well Data"]["t_res"][0].toFixed(1)
        this.viscOilRc = data["Well Data"]["visc_oil_rc"][0]
        this.viscWaterRc = data["Well Data"]["visc_wat_rc"][0]
        this.densOil = data["Well Data"]["dens_oil"][0]
        this.densWater = data["Well Data"]["dens_liq"][0]
        this.qL = data["Well Data"]["q_l"][0]
        this.qO = data["Well Data"]["q_o"][0]
        this.wct = data["Well Data"]["wct"][0]
        this.bhp = data["Well Data"]["bhp"][0]
        this.pRes = data["Well Data"]["p_res"][0]
        this.hDyn = data["Well Data"]["h_dyn"][0]
        this.pAnnular = data["Well Data"]["p_annular"][0]
        this.whp = data["Well Data"]["whp"][0]
        this.lineP = data["Well Data"]["line_p"][0]
        this.piInput = data["Well Data"]["pi"][0]
        this.pResInput = this.pRes
        this.qLInput = this.qL
        this.wctInput = this.wct
        this.gorInput = this.gor
        this.bhpInput = this.bhp
        this.hDynInput = this.hDyn
        this.pAnnularInput = this.pAnnular
        this.pManomInput = 0
        this.hPumpManomInput = 0
        this.whpInput = this.whp
        this.qlCelButton = true
        this.qlCelValue = this.qLInput*1
        this.hPumpValue = this.hPumpSet
        if (this.expMeth == "ШГН") {
              this.shgnButton = true;
        } else {
              this.shgnButton = false
        }
        this.expChoose = this.expMeth
        this.piButton = true
        this.curveLineData = JSON.parse(data.LineData)["data"]
        this.curvePointsData = JSON.parse(data.PointsData)["data"]
      }
    },
    setLine: function (value) {
      console.log(value)
      var ipr_points = [];
      var qo_points = [];
      var value2 = [];
      var ipr_points2 = [];
      var qo_points2 = [];

      _.forEach(value, function (values) {
        ipr_points = values.ipr_points;
        qo_points = values.qo_points;
        ipr_points2.push(ipr_points);
        qo_points2.push("" + qo_points + "");
      });

      this.data = [
        {
          name: "IPR (кривая притока)",
          x: qo_points2,
          y: ipr_points2,

          marker: {
            size: "15",
            color: "#FF0D18",
          },
        },

        {
          name: "Текущий режим",
          x: [40],
          y: [40],
          mode: "markers",
          marker: {
            size: "15",
            color: "#00A0E3",
          },
        },

        {
          name: "Потенциальный режим",
          x: [],
          y: [],
          mode: "markers",
          marker: {
            size: "15",
            color: "#FBA409",
          },
        },
        {
          name: "New Line",
          x: [],
          y: [],

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

      _.forEach(value, function (values) {
        ipr_points = values.ipr_points;
        qo_points = values.qo_points;
        ipr_points2.push(ipr_points);
        qo_points2.push("" + qo_points + "");
      });
      this.data[3]['x'] = qo_points2
      this.data[3]['y'] = ipr_points2
      console.log(JSON.stringify(this.data[0]['x']) == JSON.stringify(this.data[3]['x']))
      if (JSON.stringify(this.data[0]['x']) == JSON.stringify(this.data[3]['x']) && JSON.stringify(this.data[0]['y']) == JSON.stringify(this.data[3]['y'])) {
        this.data[3]['x'] = []
        this.data[3]['y'] = []
      }
    },
    setPoints: function (value) {
      this.data[1]['x'][0] = value[0]["q_l"]
      this.data[1]['y'][0] = value[0]["p"]
      this.data[2]['x'][0] = value[1]["q_l"]
      this.data[2]['y'][0] = value[1]["p"]
    },
    PotAnalysisMenu() {
      this.analysisBox1 = false
      this.analysisBox2 = false
      this.analysisBox3 = false
      this.analysisBox4 = false
      this.analysisBox5 = false
      this.setLine(this.curveLineData)
      this.setPoints(this.curvePointsData)
      if (this.age) {
        this.$modal.show('modalNewWell');
      } else {
        this.$modal.show('modalOldWell');
      }
    },
    ExpAnalysisMenu(){
      let uri = "http://172.20.103.187:7575/api/nno/";

        this.qZhExpEcn=this.qlCelValue
        this.qOilExpEcn=this.qlCelValue*(1-(this.wctInput/100))*this.densOil*1000

        if (this.qlCelValue<106){
            this.qZhExpShgn=this.qlCelValue
            this.qOilExpShgn=this.qlCelValue*(1-(this.wctInput/100))*this.densOil*1000

        } else {
            this.qZhExpShgn=106
            this.qOilExpShgn=106*(1-(this.wctInput/100))*this.densOil*1000
        }


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

        //console.log("JSON =", jsonData)


        this.axios.post(uri, jsonData).then((response) => {
        //var data = response.data;
        var data = JSON.parse(response.data.Result)
        if (data) {
          console.log("1",data)

          this.expAnalysisData.NNO1=data.NNO
          this.expAnalysisData.qoilShgn=this.qOilExpShgn
          this.expAnalysisData.qoilEcn=this.qOilExpEcn
          this.prs1=data.prs

          //this.$modal.show("modalExpAnalysis");

        } else {
          console.log("No data");
        }

        });


        this.axios.post(uri, jsonData2).then((response) => {
        //var data = response.data;
        var data = JSON.parse(response.data.Result)


        if (data) {
          console.log("2",data)
          this.expAnalysisData.NNO2=data.NNO
          this.prs2=data.prs



        } else {
          console.log("No data");
        }




        });

        let uri2= "/ru/nnoeco?avgprs=3&equip=1&org=5&qo="+this.qOilExpShgn+"&qzh="+this.qZhExpShgn+"&razr=5&scfa=%D0%A4%D0%B0%D0%BA%D1%82&reqecn=2&reqd="+this.expAnalysisData.NNO1+"";
        this.axios.get(uri2).then((response) => {
            let data = response.data;
            if(data) {
                //console.log("eco",this.qO,this.qL);

                this.expAnalysisData.ecnParam=data[0].ecnParam
                this.expAnalysisData.shgnParam=data[0].shgnParam
                this.expAnalysisData.shgnNpv=data[11].npv
            }
            else {
                console.log('No data');
            }
        });

        let uri3= "/ru/nnoeco?avgprs=3&equip=2&org=5&qo="+this.qOilExpEcn+"&qzh="+this.qZhExpEcn+"&razr=5&scfa=%D0%A4%D0%B0%D0%BA%D1%82&reqecn=2&reqd="+this.expAnalysisData.NNO2+"";

        this.axios.get(uri3).then((response) => {
            let data = response.data;
            if(data) {
                //console.log("eco",this.qO,this.qL);
                this.expAnalysisData.ecnNpv=data[11].npv
                this.$modal.show("modalExpAnalysis");
            }
            else {
                console.log('No data');
            }
        });
    },
    PgnoMenu() {
      this.$modal.show('modalPGNO')
    },
    InclMenu() {
      this.$modal.show('modalIncl')
    },

    getWellNumber(wellnumber) {
      let uri = "http://172.20.103.187:7575/api/pgno/" + wellnumber;
      this.axios.get(uri).then((response) => {
        var data = response.data;

        if (data["Error"] === "NoData"){
          Vue.prototype.$notifyError("Данные по указанной скважине отсутствуют");
          return this.hdynValue = [this.hDynInput = 0, this.pAnnularInput = 0], this.hDyn, this.lineP, this.casOD, this.tubID, this.bhp, this.bhpInput, this.casID, this.hPerf, this.pumpType, this.hPumpSet, this.hPumpValue, this.wctInput, this.wct, this.whp, this.pRes, this.pResInput, this.wctInput, this.qO, this.qLInput, this.qlCelValue, this.densWater, this.densOil, this.densWater, this.densOil, this.viscWaterRc, this.viscOilRc, this.tRes, this.gor, this.gorInput, this.PBubblePoint, this.tubOD = 0;
        } else if (data) {
          this.setData(data)
          this.$emit('LineData', this.curveLineData)
          this.$emit('PointsData', this.curvePointsData)
        }


        // if (data) {
        //   this.setData(data)
        //   this.$emit('LineData', this.curveLineData)
        //   this.$emit('PointsData', this.curvePointsData)


        // } else if (data["Error"] === "NoData"){
        //   Vue.prototype.$notifyError('Такой скважины нет');
        //   this.lineP = 0;
        //   this.whp = 0
        //   this.setData(data = []);}
        //   }).catch(function(error) {
        //   Vue.prototype.$notifyError("Данные по указанной скважине отсутствуют");



            // return this.whp, this.pAnnular, this.hDyn, this.pRes, this.bhp, this.wct, this.qO, this.qL, this.densWater, this.densOil  = 0;
            // this.pAnnular = 0;
            // this.hDyn = 0;
            // this.pRes = 0;
            // this.bhp = 0;
            // this.wct = 0;
            // this.qO = 0;
            // this.qL = 0;
            // this.densWater = 0;
            // this.densOil = 0;
        }
      );



    },
    postCurveData() {
      let uri = "http://172.20.103.187:7575/api/pgno/" + this.wellNumber + "/";
      if (this.CelButton == 'ql') {
        this.CelValue = this.qlCelValue
      } else if (this.CelButton == 'bhp') {
        this.CelValue = this.bhpCelValue
      } else if (this.CelButton == 'pin') {
        this.CelValue = this.piCelValue
      }



      // if (this.curveSelect == 'pi') {
      //   this.curveValue = this.piInput
      // } else if (this.curveSelect == 'ql') {
      //   this.curveValue = this.qLInput
      // } else if (this.curveSelect == 'bhp') {
      //   this.curveValue = this.bhpInput
      // } else if (this.curveSelect == 'hdyn') {
      //   this.curveValue = [this.hDynInput, this.pAnnularInput]
      // } else if (this.curveSelect == 'pmanom') {
      //   this.curveValue = [this.pManomInput, this.hPumpManomInput]
      // } else if (this.curveSelect == 'whp') {
      //   this.curveValue = this.whpInput
      // }
      let jsonData = JSON.stringify(
        {
        "curveSelect": this.curveSelect,
        "presValue": this.pResInput,
        "piValue": this.piInput,
        "qlValue": this.qLInput,
        "bhpValue": this.bhpInput,
        "hdynValue": [this.hDynInput, this.pAnnularInput],
        "pmanomValue": [this.pManomInput, this.hPumpManomInput],
        "whpValue": this.whpInput,
        "wctValue": this.wctInput,
        "gorValue": this.gorInput,
        "expSelect": this.expChoose,
        "hPumpValue": this.hPumpValue,
        "celSelect": this.CelButton,
        "celValue": this.CelValue,
        "menu": "MainMenu",
        "well_age": this.age,
        "grp_skin": true,
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
      // console.log("JSON =", jsonData)
      this.axios.post(uri, jsonData).then((response) => {
        var data = response.data;
        if (data) {
          this.method = "CurveSetting"
          this.setData(data)
          this.$emit('LineData', this.curveLineData)
          this.$emit('PointsData', this.curvePointsData)
          } else {
        }
      });
    },
    postAnalysisOld() {
      let uri = "http://172.20.103.187:7575/api/pgno/" + this.wellNumber + "/";
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
        "presValue": this.pResInput,
        "piValue": this.piInput,
        "qlValue": this.qLInput,
        "bhpValue": this.bhpInput,
        "hdynValue": [this.hDynInput, this.pAnnularInput],
        "pmanomValue": [this.pManomInput, this.hPumpManomInput],
        "whpValue": this.whpInput,
        "wctValue": this.wctInput,
        "gorValue": this.gorInput,
        "expSelect": this.expChoose,
        "hPumpValue": this.hPumpValue,
        "celSelect": this.celSelect,
        "celValue": this.celValue,
        "menu": "PotencialAnalysis",
        "well_age": this.age,
        "grp_skin": true,
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
      // console.log("JSON =", jsonData)
      this.axios.post(uri, jsonData).then((response) => {
        var data = response.data;
        if (data) {
          console.log(data)
          this.method = "CurveSetting"
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
      console.log("POST NEW WELL")
      let uri = "http://172.20.103.187:7575/api/pgno/" + this.wellNumber + "/";
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
        "presValue": this.pResInput,
        "piValue": this.piInput,
        "qlValue": this.qLInput,
        "bhpValue": this.bhpInput,
        "hdynValue": [this.hDynInput, this.pAnnularInput],
        "pmanomValue": [this.pManomInput, this.hPumpManomInput],
        "whpValue": this.whpInput,
        "wctValue": this.wctInput,
        "gorValue": this.gorInput,
        "expSelect": this.expChoose,
        "hPumpValue": this.hPumpValue,
        "celSelect": this.celSelect,
        "celValue": this.celValue,
        "menu": "MainMenu",
        "well_age": this.age,
        "grp_skin": true,
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
      // console.log("JSON =", jsonData)
      this.axios.post(uri, jsonData).then((response) => {
        var data = response.data;
        if (data) {
          console.log(data)
          this.method = "CurveSetting"
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


  },
  beforeCreate: function() {
    let uri = "http://172.20.103.187:7575/api/pgno/0046/";
      this.axios.get(uri).then((response) => {
        var data = response.data;
        if (data) {
          this.setData(data)
          this.$emit('LineData', this.curveLineData)
          this.$emit('PointsData', this.curvePointsData)
        } else {
          console.log("No data");
        }
      });

  },
};
</script>

<style scoped>
.modalOldWell {
  font-family: 'Courier New', Courier, monospace;
}

.checkbox-modal-analysis-menu-label {
  font-family: 'Courier New', Courier, monospace;
  margin-right: px;
  font-size: 13.5px;
}

.checkbox-modal-analysis-menu {
  margin-left: -15px;
}

.modal-analysis-menu {
  display: flex;
  flex-direction: column;
  justify-content: left;
}

div {
  font-family: 'Roboto', sans-serif;
  font-weight: 400;
}
</style>
