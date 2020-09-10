<template>
  <div>
    <div class="level1-content row">
      <div class="col-md-12 col-lg-12 row">
        <div class="level1-tab active" tabindex="-1">Общие данные</div>
        <div class="level1-tab" tabindex="-1">Аналитика</div>
        <div class="main col-md-7 col-lg-7 row">
          <div class="col-sm-12 col-md-4 col-lg-4">
            <div class="digitOil row">
              <div class="okei okei-left">тыс.тонн</div>
              <div class="digit-oil-icon">
                <img src="img/level1/digit-oil-icon.svg" alt="" />
              </div>
              <img
                src="img/level1/oil.svg"
                alt=""
                class="digit-oil-icon-middle"
              />
              <div class="digit-oil-description">
                <div class="digit-oil-name">Нефть</div>
                <div class="digit-oil-value">136</div>
              </div>
              <div class="digit-oil-additional">
                <div class="digit-oil-additional-icon">
                  <img src="img/level1/arrow_up.svg" alt="" />
                </div>
                <div class="digit-oil-additional-value">+0,3%</div>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-4 col-lg-4">
            <!--  <div class="col-md-12 col-lg-12 row">
                  <div class="col-md-2 col-lg-2">
                           <img src="img/level1/date_left_arrow.svg" alt="">
                        </div>
                        <div class="col-md-8 col-lg-8">
                            <!--<div class="time">{{date("h:i")}}</div>
                            <div class="date">{{date("d F Y")}}</div>
                        </div>
                        <div class="col-md-2 col-lg-2">
                           <img src="img/level1/date_right_arrow.svg" alt="">
                        </div>
                    </div>-->

            <div class="col-md-12 col-lg-12 row">
              <div class="timer-welcome">
                <div class="left-arrow">
                  <!-- <img src="img/level1/date_left_arrow.svg" alt="">-->
                </div>
                <div class="timer">
                  <div class="time">{{ timeNow }}</div>
                  <div class="date">{{ dateNow }}</div>
                </div>
                <div class="right-arrow">
                  <!-- <img src="img/level1/date_right_arrow.svg" alt="">-->
                </div>
              </div>
            </div>
            <div class="col-md-12 col-lg-12 row">
              <div class="title">Казахстан</div>
            </div>
          </div>
          <div class="col-sm-12 col-md-4 col-lg-4">
            <div class="digitGaz row">
              <div class="okei okei-right">млрд.м3</div>
              <div class="digit-gaz-additional">
                <div class="digit-gaz-additional-icon">
                  <!--<img src="{{ asset('img/level1/arrow_down.svg') }}" alt="">-->
                </div>
                <div class="digit-gaz-additional-value">-0,1%</div>
              </div>
              <div class="digit-gaz-description">
                <div class="digit-gaz-name">Газ</div>
                <div class="digit-gaz-value">0.64</div>
              </div>
              <div class="digit-gaz-icon">
                <img src="img/level1/digit-gaz-icon.svg" alt="" />
              </div>
              <!--<img src="{{ asset('img/level1/gaz.svg') }}" alt="" class="digit-gaz-icon-middle">-->
            </div>
          </div>

          <!-- <div class="col-md-2 col-lg-2 indicator">
                    <div class="indicator-icon">
                        <img src="{{ asset('img/level1/oil.svg') }}" alt="">
                    </div>
                    <div class="indicator-name">Запасы нефти и конденсата</div>
                    <div class="indicator-value">668,2</div>
                    <div class="indicator-okei">тыс.тонн</div>
                </div>-->
          <!-- <div class="col-md-2 col-lg-2" style="height: 135px;"></div>
                <div class="col-md-2 col-lg-2" style="height: 135px;"></div>
                <div class="col-md-2 col-lg-2" style="height: 135px;"></div>
                <div class="col-md-2 col-lg-2" style="height: 135px;"></div>
                <div class="col-md-2 col-lg-2 indicator">
                   <div class="indicator-icon">
                        <img src="{{ asset('img/level1/gaz.svg') }}" alt="">
                    </div>
                    <div class="indicator-name">Запасы природного газа</div>
                    <div class="indicator-value">414,3</div>
                    <div class="indicator-okei">млрд.м3</div>
                </div>-->
          <div class="col-md-12 col-lg-12">
            <div class="map">
              <div class="nur-sultan">
                Нур-Султан
                <div class="square"></div>
              </div>
              <div class="org-name1 rectangle">
                ТОО «Казахтуркмунай»
                <div class="icon1 icon"></div>
                <div
                  class="square-small"
                  :style="`${changeColour}`"
                  @click="changeButton(`${changeButtons}`, 'Yes')"
                >
                  &#10003;
                </div>
              </div>

              <div class="org-name2 rectangle">
                ТОО «Казахойл Актобе»
                <div class="icon2 icon"></div>
                <div class="square-small">&#10003;</div>
              </div>

              <div class="org-name3 rectangle">
                АО «ЭмбаМунайГаз»
                <div class="icon3 icon"></div>
                <div class="square-small">&#10003;</div>
              </div>

              <div class="org-name4 rectangle">
                АО «Каражанбасмунай»
                <div class="icon4 icon"></div>
                <div class="square-small">&#10003;</div>
              </div>

              <div class="org-name5 rectangle">
                АО «Мангистаумунайгаз»
                <div class="icon5 icon"></div>
                <div class="square-small">&#10003;</div>
              </div>

              <div class="org-name6 rectangle">
                АО «ОзенМунайГаз»
                <div class="icon6 icon"></div>
                <div class="square-small">&#10003;</div>
              </div>
              <div class="org-name7 rectangle">
                ТОО «КазГерМунай»
                <div class="icon7 icon"></div>
                <div class="square-small">&#10003;</div>
              </div>
            </div>
          </div>

          <div class="footer-chart">
            <div class="point"></div>
            Добыча нефти и конденсата (тыс. тонн)
            <div id="container">
              <welcome-chart-bar-bottom1></welcome-chart-bar-bottom1>
            </div>
          </div>

          <div class="footer-chart">
            <div class="point"></div>
            Добыча природного и попутного газа (млн. м3)
            <div id="container">
              <welcome-chart-bar-bottom2></welcome-chart-bar-bottom2>
            </div>
          </div>
        </div>
        <div class="right-bar col-md-5 col-lg-5">
          <div>
            <div class="right-tab col-md-3 col-lg-3" tabindex="-1">День</div>
            <div class="right-tab col-md-3 col-lg-3" tabindex="-1">Месяц</div>
            <div class="right-tab col-md-3 col-lg-3" tabindex="-1">Квартал</div>
            <div class="right-tab col-md-3 col-lg-3" tabindex="-1">Год</div>
          </div>
          <div class="info-panel">
            <div class="right-side">
              <div class="circle1 circle">
                <div class="point"></div>
                Добыча нефти и конденсата
                <!--<div class="drop icon"> </div>-->
                <welcome-chart-donut-right1></welcome-chart-donut-right1>
                <div class="org-name11 rectangle2">
                  «КазГерМунай»: 10,9 тыс. тонн
                </div>
              </div>
              <div class="circle2 circle">
                <div class="point"></div>
                Добыча природного газа
                <welcome-chart-donut-right2></welcome-chart-donut-right2>
                <div class="org-name22 rectangle2">
                  ЭмбаМунайГаз: 0,02 млрд. м3
                </div>
              </div>
            </div>

            <div class="right-side">
              <div class="indent-top">
                <charttide></charttide>
              </div>
            </div>
            <div class="right-side">
              <div class="circle3 circle">
                <div class="point"></div>
                Нефтяной фонд скважин
                <welcome-chart-donut-right3></welcome-chart-donut-right3>
                <div class="org-name33 rectangle2">
                  «Казахойл Актобе»: 1 601 ед.
                </div>
              </div>
              <div class="circle4 circle">
                <div class="point"></div>
                Нагнетальный фонд скважин
                <welcome-chart-donut-right4></welcome-chart-donut-right4>
                <div class="org-name44 rectangle2">
                  «Мангистаумунайгаз»: 1 183 ед.
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
export default {
  data: function () {
    return {
      changeColour: "",
      ShowDzo: "",
      changeButtons: "No",
      oil: "",
      timeNow: new Date().toLocaleString("ru", {
        hour: "numeric",
        minute: "numeric",
      }),
      dateNow: new Date().toLocaleString("ru", {
        year: "numeric",
        month: "long",
        day: "numeric",
      }),
    };
  },
  methods: {
    /*  timeSelect2(select) {
      this.timeSelect = select;
      this.getCurrencyNow(this.timeSelect);      
    },*/

    getOil: function () {
      var datas;
      //let uri = "/ru/getcurrency?fdate=" + dates + "";
      let uri = "/js/json/welcome.json";
      this.axios.get(uri).then((response) => {
        var data = response.data;
        if (data) {
          this.oil = data;
          console.log(data);
        } else {
          console.log("No data");
        }
      });
    },
    changeButton(changeButtons, ShowDzo) {
      var changeColour = "color: #0F1430;";

      if (changeButtons == "Yes") {
        /*  if (this.company == "all") {
          this.displayHeadTables = "display: block";
          this.displayTable = "display:none;";
        } else {
          this.displayTable = "display:block;";
          this.displayHeadTables = "display: none";
        }*/

        this.changeButtons = "No";

        this.changeColour = ""; //colour button
      } else if (changeButtons == "No") {
        /* this.displayTable = "display:none;";
        this.displayHeadTables = "display: none";
        this.displayChart = "display:block;";
        this.ChartTable = "Таблица";
        this.displayHeadTables = "display: none";*/

        this.changeButtons = "Yes";
        this.changeColour = changeColour; //colour button
      }
    },
  },
  async mounted() {
    this.getOil();
    this.changeButton("No");
  },
};
</script>
