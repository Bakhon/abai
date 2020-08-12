<template>
  <div>
    <div class="visual-center-center">
      <a href="#">
        <li
          class="circle-2"
          tabindex="-2"
          :style="`${buttonHover1}`"
          @click="getProduction('oil_plan', 'oil_fact')"
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
          @click="getProduction('oil_dlv_plan', 'oil_dlv_fact')"
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
          @click="getProduction('gas_plan', 'gas_fact')"
        >
          <div class="circle-2-string">Добыча газа</div>
        </li>
      </a>
      <a href="#">
        <li
          class="circle-2"
          tabindex="-2"
          :style="`${buttonHover4}`"
          @click="getProduction('liq_plan', 'liq_fact')"
        >
          <div class="circle-2-string">Добыча жидкости</div>
        </li>
      </a>
      <a href="#">
        <li
          class="circle-2"
          tabindex="-2"
          :style="`${buttonHover5}`"
          @click="getProduction('gk_plan', 'gk_fact')"
        >
          <div class="circle-2-string">Добыча конденсата</div>
        </li>
      </a>
      <a href="#">
        <li
          class="circle-2"
          tabindex="-2"
          :style="`${buttonHover6}`"
          @click="getProduction('inj_plan', 'inj_fact')"
        >
          <div class="circle-2-string">Объём закачки</div>
        </li>
      </a>
    </div>
    <div class="tables">
      <div class="tables-name">Добыча нефти и конденсата</div>
      <!--<div class="btn btn-info2" >Вывести таблицу</div>-->
      <div class="tables-string">
        <div class="cell-colour-top table-border"></div>
        <div class="cell-number-top table-border">№</div>
        <div class="cell-name-top table-border">Предприятия</div>
        <div class="cell-last-top table-border cell-last">ДОБЫЧА, тонн</div>
        <div class="cell2 table-border">План на 2020 год</div>
        <div class="cell2 table-border">План на июль месяц</div>
        <div class="cell3 table-border">СУТОЧНАЯ</div>
        <div class="cell3 table-border">С НАЧАЛА МЕСЯЦА</div>
        <div class="cell3 table-border cell-last">С НАЧАЛА ГОДА</div>
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
      <div v-for="item in series">
        <div>
          <div>
            <div class="cell-colour table-border">
              <div
                class="circle-table"
                :style="`background: ${getColor(item.fact - item.plan)}`"
              ></div>
            </div>
            <div class="cell-number table-border"></div>
            <div class="cell-name table-border">
              {{ item.dzo }} {{ item.time }}
            </div>
            <div class="cell table-border"></div>
            <div class="cell table-border"></div>
            <div class="cell table-border">{{ item.plan }}</div>
            <div class="cell table-border">{{ item.fact }}</div>
            <div
              class="cell table-border colour"
              :style="`background: ${getColor(item.fact - item.plan)}`"
            >
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
</template>

<script>
export default {
  data: function () {
    return {
      series: "",
      buttonHover1: "",
      buttonHover2: "",
    };
  },

  methods: {
    getColor(status) {
      if (status < "0") return "#b40300";
      return "#008a17";
    },

    getProduction(item, item2) {
      localStorage.setItem("production-plan", item);
      localStorage.setItem("production-fact", item2);

      var productionPlan = localStorage.getItem("production-plan");
      var productionFact = localStorage.getItem("production-fact");

      /* getColorButton() {
      if (localStorage.getItem("production-plan") == "oil_plan") return "#b40300";
      return "#008a17";
    },*/

      let company = localStorage.getItem("company");
      //let uri = "/js/json/getnkkmgyear.json";
      let uri = "/js/json/getnkkmg.json";
      //let uri = "/ru/getnkkmg";
      this.axios.get(uri).then((response) => {
        let data = response.data;
        if (data) {
          var arrdata = new Array();
          arrdata = _.filter(data, _.iteratee({ dzo: company }));
          var dzo = new Array();
          var liq_fact = new Array();
          var liq_plan = new Array();
          var time = new Array();
          _.forEach(arrdata, function (item) {
            dzo.push(item.dzo);
            liq_fact.push(item[productionFact]);
            liq_plan.push(item[productionPlan]);
            time.push(item.__time);
          });

          //Собираем массив по отдельности
          var dzo2 = new Array();
          _.each(dzo, function (dzo) {
            dzo2.push({ dzo });
          });

          var liq_fact2 = new Array();
          _.each(liq_fact, function (fact) {
            liq_fact2.push({ fact });
          });

          var liq_plan2 = new Array();
          _.each(liq_plan, function (plan) {
            liq_plan2.push({ plan });
          });

          var __time2 = new Array();
          _.each(time, function (time) {
            time = new Date(time).toLocaleDateString().split("/");
            __time2.push({ time });
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

          this.series = result;

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

                      if (productionPlan == "inj_plan") {
            this.buttonHover5 = buttonHover;
          } else {
            this.buttonHover5 = "";
          }

                      if (productionPlan == "gk_plan") {
            this.buttonHover6 = buttonHover;
          } else {
            this.buttonHover6 = "";  }

        } else {
          console.log("No data");
        }
      });
    },
  },
};
</script>
