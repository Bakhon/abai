<template>
  <div>
    <div>
      <div class="level1-content row">
        <div class="col-md-12 col-lg-12 row">
          <div class="main col-lg-7-2 row">
            <div class="col-sm-12 col-md-4 col-lg-4"></div>
            <div class="col-sm-12 col-md-4 col-lg-4">
              <div class="col-md-12 col-lg-12 row">
                <div class="timer-visual-center">
                  <div class="left-arrow"></div>
                  <div class="timer">
                    <!-- <div class="time">{{date("h:i")}}</div>
                                <div class="date">{{date("d F Y")}}</div>-->
                  </div>
                  <div class="right-arrow"></div>
                </div>
              </div>
            </div>
            <div class="visual-center-center">
              <!--<div class="level2-tab active" tabindex="-3">День</div>
              <div class="level2-tab" tabindex="-3">Месяц</div>
              <div class="level2-tab" tabindex="-3">Год</div>-->
          
                 <div   class="level2-tab"            
                 
                
                
                  :style="{
                   // color: day.weekend,
                   //'background-color': menuDMY.current,
                  }"
  
                >
                {{menuDMY}} </div>
              
  </div>


            <div class="month-day">
              <div class="navigation-table">
                <div class="navigation">
                  <div v-on:click="decrease"><</div>
                </div>
                <div class="navigation-month" colspan="5">
                  {{ monthes[month] }} {{ year }}
                </div>
                <div class="navigation">
                  <div v-on:click="increase">></div>
                </div>
              </div>
              <!--<div class="day" v-for="d in day">{{d}}</div>-->
              <div v-for="week in calendar()" > 
                <div
                  @click="selectedDay = day.index"
                   class="week"
                  v-for="(day, index) in week"
                  :style="{
                    color: day.weekend,
                    'background-color': day.current,
                  }"
                >
                  <div>{{ day.index }}</div>
                </div>


</div></div>

 





 <div class="month-day">
               
               
               
                   <div                 
                    class="week"
                  v-for="month in getMonths()" 
                  :style="{
                   // color: day.weekend,
                    'background-color': month.current,
                  }"
                @click="selectedMonth = month.index" >{{month.index}}</div>
                </div>

 <div class="month-day">
                 <div                 
                    class="week"
                  v-for="(year, index) in getYears()" 
                  :style="{
                   // color: day.weekend,
                    'background-color': year.current,
                  }"
                @click="selectedYear = year.index" >{{year.index}}</div>
                </div>

              <div class="visual-center-center">
                <div class="tables">
                  <div class="visual-center-center">
                    <a href="#">
                      <li
                        class="circle-2"
                        tabindex="-2"
                        :style="`${buttonHover1}`"
                        @click="getProduction('oil_plan', 'oil_fact',' Добыча нефти')"
                      >
                        <div class="circle-2-string">
                          Добыча нефти
                        </div>
                      </li>
                    </a>
                    <a href="#">
                      <li
                        class="circle-2"
                        tabindex="-2"
                        :style="`${buttonHover2}`"
                        @click="getProduction('oil_dlv_plan', 'oil_dlv_fact','Сдача нефти')"
                      >
                        <div class="circle-2-string">
                          Сдача нефти
                        </div>
                      </li>
                    </a>
                    <a href="#">
                      <li
                        class="circle-2"
                        tabindex="-2"
                        :style="`${buttonHover3}`"
                        @click="getProduction('gas_plan', 'gas_fact','Добыча газа')"
                      >
                        <div class="circle-2-string">Добыча газа</div>
                      </li>
                    </a>
                    <a href="#">
                      <li
                        class="circle-2"
                        tabindex="-2"
                        :style="`${buttonHover4}`"
                        @click="getProduction('liq_plan', 'liq_fact','Добыча жидкости')"
                      >
                        <div class="circle-2-string">Добыча жидкости</div>
                      </li>
                    </a>
                    <a href="#">
                      <li
                        class="circle-2"
                        tabindex="-2"
                        :style="`${buttonHover5}`"
                        @click="getProduction('gk_plan', 'gk_fact','Добыча конденсата')"
                      >
                        <div class="circle-2-string">Добыча конденсата</div>
                      </li>
                    </a>
                    <a href="#">
                      <li
                        class="circle-2"
                        tabindex="-2"
                        :style="`${buttonHover6}`"
                        @click="getProduction('inj_plan', 'inj_fact','Объём закачки')"
                      >
                        <div class="circle-2-string">Объём закачки</div>
                      </li>
                    </a>
                  </div>

                  <div class="tables">
                    <div class="tables-name">{{circleMenu}}</div>
                    <!--<div class="btn btn-info2" >Вывести таблицу</div>-->
                    <div class="tables-string">
                      <!--<div class="cell-colour-top table-border"></div>-->
                      <div class="cell-number-top table-border">№</div>
                      <div class="cell-name-top table-border">Предприятия</div>
                      <div class="cell-last-top table-border cell-last">
                        ДОБЫЧА, тонн
                      </div>
                      <div class="cell2 table-border">План на 2020 год</div>
                      <div class="cell2 table-border">План на июль месяц</div>
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
                    <div v-for="item in tables">
                      <div>
                        <div>
                          <!-- <div class="cell-colour table-border">
                 
                </div>-->
                          <div class="cell-number table-border"></div>
                          <div class="cell-name table-border">
                            {{ item.dzo }} {{ item.time }}
                          </div>
                          <div class="cell table-border"></div>
                          <div class="cell table-border"></div>
                          <div class="cell table-border">{{ item.plan }}</div>
                          <div class="cell table-border">{{ item.fact }}</div>
                          <div class="cell table-border colour">
                            <div
                              class="circle-table"
                              :style="`background: ${getColor(
                                item.fact - item.plan
                              )}`"
                            ></div>
                            {{ item.fact - item.plan }}
                          </div>
                          <div class="cell table-border"></div>
                          <div class="cell table-border"></div>
                          <div class="cell table-border colour"></div>
                          <div class="cell table-border"></div>
                          <div class="cell table-border"></div>
                          <div class="cell table-border cell-last colour"></div>
                        </div>
                        <div style="clear: both;"></div>
                      </div>
                      <div class="tables-bottom-line"></div>
                    </div>
                  </div>
                </div>
              </div>
            <!--    <div class="visual-center-center">
                    <div class="tables-name">График добычи</div>
                   <visual-center-chart-area-center v-for='(serial, index) in test'  v-bind:postTitle='serial' :key='serial'>  

     
                        
                         </visual-center-chart-area-center> 
              </div> -->
              <div class="visual-center-center">
                <div class="visual-center-bottom">
                  <div class="visual-center-string1">Отключение РП:</div>
                  <div class="visual-center-string2"></div>
                  <div class="visual-center-string1">Отключение скважин:</div>
                  <div class="visual-center-string2"></div>
                  <div class="visual-center-string1">Выбросы и разливы:</div>
                  <div class="visual-center-string2"></div>
                  <div class="visual-center-string1">Прочие:</div>
                  <div class="visual-center-string2"></div>
                </div>
                <div class="visual-center-bottom">
                  <div class="accidents-first accidents">
                    <div class="number-of-accidents">
                      2
                    </div>
                    Несчастные<br />
                    случаи
                  </div>
                  <div class="accidents-second accidents">
                    <div class="number-of-accidents">
                      0
                    </div>
                    Смертельные<br />
                    случаи
                  </div>
                  <div class="accidents-third accidents">
                    <div class="number-of-accidents">
                      14
                    </div>
                    COVID<br />19
                  </div>
                </div>
                <div class="visual-center-bottom">
                  <div class="difference-of-24">Отклонение за сутки</div>
                  <div class="visual-center-chart-bar-bottom">
                    <visual-center-chart-bar-bottom
                      v-for="(start, index) in starts"
                      v-bind:starts="start"
                      :key="start"
                    ></visual-center-chart-bar-bottom>
                  </div>
                </div>
              </div>
            </div>
            <div class="visual-center-right-column">
              <div class="right-button-panel">
                <div class="right-chart-button right-button" tabindex="-5">
                  График
                </div>
                <div class="right-table-button right-button" tabindex="-5">
                  Таблица
                </div>
              </div>
              <div class="donut">
                <div class="indent">
                  Фонд добывающих скважин
                </div>
                <div>
              <visual-center-chart-donut-right1
               v-for="(well, index) in wells2"
                    v-bind:wells2="well"
                    :key="well"
                  >
                            </visual-center-chart-donut-right1>
                </div>
               <!--  <div class="donut-inner1 inner2">
                 В работе <br />{{ well[0] }}
                </div>
                <div class="donut-inner1 inner1">
                  В простое<br />{{ well[1] }}
                </div>-->
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
export default {
  data: function () {
    return {
      tables: "",
      buttonHover1: "",
      buttonHover2: "",
      buttonHover3: "",
      buttonHover4: "",
      buttonHover5: "",
      buttonHover6: "",
      circleMenu:"",
      month: new Date().getMonth(),
      year: new Date().getFullYear(),
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
        "Всего добыча нефти и конденсата с учётом доли участия АО НК КазМунайГаз",
        "в т.ч.:газовый конденсат",
        "АО Озенмунайгаз (нефть) (100%)",
        "(конденсат)(100%)",
        "АО Эмбамунайгаз (100%)",
        "АО Каражанбасмунай (50%)",
        "ТОО СП Казгермунай",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
      ],
      date: new Date(),
      selectedDay: undefined,
      selectedMonth: undefined,
      selectedYear: undefined,
      selectedDMY: undefined,

      wells: [""],
       wells2: [""],
      starts: [""],
      test: [""],
      series: ["", ""],

    };
  },

  methods: {
    getColor(status) {
      if (status < "0") return "#b40300";
      return "#008a17";
    },

    getProduction(item, item2,item3) {
if (this.selectedDay ===undefined) {} else {}
if (this.selectedMonth ===undefined) {} else {}
if (this.selectedYear===undefined) {} else {}


      localStorage.setItem("production-plan", item);
      localStorage.setItem("production-fact", item2);

      var productionPlan = localStorage.getItem("production-plan");
      var productionFact = localStorage.getItem("production-fact");

      this.circleMenu=item3;

      let company = localStorage.getItem("company");
      if (company === null) {
        alert("Сначала выберите название компании");
      }

      //let uri = "/js/json/getnkkmgyear.json";
      let uri = "/js/json/getnkkmg.json";
      //let uri = "/ru/getnkkmg";
      this.axios.get(uri).then((response) => {
        let data = response.data;
        if (data) {
          var arrdata = new Array();
          //select date filter
          var timestamp = new Date(
            this.monthes2[this.month] +
              this.selectedDay +
              " " +
              this.year +
              " 06:00:00 GMT+0600"
          ).getTime();
          arrdata = _.filter(data, _.iteratee({ __time: timestamp }));
          if (arrdata.length == 0) {
            alert(
              "К сожалению на текущую дату нет данных, выберите другую дату"
            );
          } else {
            arrdata = _.filter(arrdata, _.iteratee({ dzo: company }));
          } //select dzo filter

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

          //Create massive with a part
          var dzo2 = new Array();
          _.each(dzo, function (dzo) {
            dzo2.push({ dzo });
          });

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

          //----------------------------
          var result = _.zipWith(
            _.sortBy(dzo2, (dzo) => dzo.dzo),
            _.sortBy(liq_fact2, (liq_fact) => liq_fact.liq_fact),
            _.sortBy(liq_plan2, (liq_plan) => liq_plan.liq_plan),
            _.sortBy(__time2, (time) => time.time),
            (dzo, liq_fact, liq_plan, time) =>
              _.defaults(dzo, liq_fact, liq_plan, time)
          );

          this.tables = result;

          /*var prod_wells_work_one = prod_wells_work2[0].prod_wells_work;
          var prod_wells_idle_one = prod_wells_idle2[0].prod_wells_idle;
          this.series = [prod_wells_work_one, prod_wells_idle_one];*/


  var wells2 = _.zipWith(
            _.sortBy(prod_wells_work2, (prod_wells_work) => prod_wells_work.prod_wells_work),
            _.sortBy(prod_wells_idle2, (prod_wells_idle) => prod_wells_idle.prod_wells_idle),
                (prod_wells_work, prod_wells_idle) =>
              _.defaults(prod_wells_work, prod_wells_idle)
          );

    this.wells2 = wells2;

          var starts = _.zipWith(
            _.sortBy(starts_krs2, (starts_krs) => starts_krs.starts_krs),
            _.sortBy(starts_prs2, (starts_prs) => starts_prs.starts_prs),
            _.sortBy(starts_drl2, (starts_drl) => starts_drl.starts_drl),
            (starts_krs, starts_prs, starts_drl) =>
              _.defaults(starts_krs, starts_prs, starts_drl)
          );

          this.starts = starts;

          var wells = _.zipWith(
            _.sortBy(
              inj_wells_idle2,
              (inj_wells_idle) => inj_wells_idle.inj_wells_idle
            ),
            _.sortBy(
              inj_wells_work2,
              (inj_wells_work) => inj_wells_work.inj_wells_work
            ),
            (inj_wells_idle, inj_wells_work) =>
              _.defaults(inj_wells_idle, inj_wells_work)
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
      });
    },

    /*getSelectedDay() {
      localStorage.setItem("selected-day", this.selectedDay);
      var selectedDay = localStorage.getItem("selected-day");
      this.selectedDay = selectedDay;
      this.selectedColour = "background:red!important;";
    },

        getSelectedMonth() {
      localStorage.setItem("selected-day", this.selectedDay);
      var selectedDay = localStorage.getItem("selected-month");
      this.selectedDay = selectedDay;
      this.selectedColour = "background:red!important;";
    },*/

         calendar: function(){
			var days = [];
			var week = 0;
			days[week] = [];
			var dlast = new Date(this.year, this.month + 1, 0).getDate();
                for (let i = 1; i <= dlast; i++) {
                    if (new Date(this.year, this.month, i).getDay() != this.dFirstMonth) {
					var	a = {index:i, id: i };
                        days[week].push(a);
						 if (this.selectedDay == i) {
            a.current = "black";
          } else if (
            i == new Date().getDate() &&
            this.year == new Date().getFullYear() &&
            this.month == new Date().getMonth()
          ) {
            a.current = "#009846";
          }
						if (new Date(this.year, this.month, i).getDay() == 6 || new Date(this.year, this.month, i).getDay() == 0) { a.weekend = '#ff0000'};
						}
                     else {
                        week++;
						
                        days[week] = [];
						a = {index:i};
                        days[week].push(a);
						if ((i == new Date().getDate()) && (this.year == new Date().getFullYear()) && (this.month == new Date().getMonth())) { a.current = '#747ae6'};
						if (new Date(this.year, this.month, i).getDay() == 6 || new Date(this.year, this.month, i).getDay() == 0) { a.weekend = '#ff0000'};
						}
                    }

			/*	if (days[0].length > 0) {
					for (let i = days[0].length; i < 7; i++) {
						days[0].unshift('');
						
					}
				}*/
				this.dayChange;
			
				return days;
			},
            decrease: function(){
                    this.month--;
                    if (this.month < 0) {
                        this.month = 12;
                        this.month--;
                        this.year--;
                    }
                    
            },
			increase: function(){

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
      if (new Date(this.year, this.month, i).getMonth() ) {
        var a = { index: i,id: i };
        monthAll.push(a);
        

        if (this.selectedMonth == i) {
          a.current = "black";
        } else if (
          i == new Date().getMonth() &&
          this.year == new Date().getFullYear()  /* &&
        this.month == new Date().getMonth()*/
        ) {
          a.current = "#009846";
        }
       
      }
     
    }
          return monthAll;
     
  },



getYears: function () {
var yearAll = [];
var year = this.year;
    for (let i = 2018; i <= year; i++) {
      //if (this.year, this.month, i).getYear() ) {
        var a = { index: i,id: i  };
        yearAll.push(a);     
        if (this.selectedYear == i) {
          a.current = "black";
        } else if (
          i == year /*&&
          this.year == new Date().getFullYear() &&
          this.month == new Date().getMonth()*/
        ) {
          a.current = "#009846";
        }
  
    }
         
         return yearAll;
  },

  menuDMY(){



    menuDMY[id]=[];
    var menuDMY = [{DMY:'День',id:'0'},{DMY:'Месяц',id:'1'},{DMY:'Год',id:'2'}];

    for (let i = 0; i <= 2; i++) {

      var menuDMY = [];
			var id = 0;
			menuDMY[id] = [];
    
    
     menuDMY[i];

  if (this.selectedDMY == i) {
          var z = { index: i };         
          z.current = "black";
            menuDMY[id].push(z);
        }



         // }

           return menuDMY;
   console.log(menuDMY); 

  }
  
  }

  },
 
  computed: {
    dayChange: function () {
      if (this.dFirstMonth == 0) {
        //this.day = ["Su", "Mn", "Tu", "We", "Th", "Fr", "Sa"];
        this.day = ["ВС", "ПН", "ВТ", "СР", "ЧТ", "ПТ", "СБ"];
      }
      
    },
  },
};
</script>
