<template>
  <div class="list-group">
    <a
      class="bg-dark list-group-item list-group-item-action circle-menu"
      :style="`${buttonMenuHover10}`"
      @click="saveCompany('all')"
    >
      <div class="d-flex w-100 justify-content-start align-items-center">
        <img
          src="/img/level1/kmg_small2.png"
          width="25"
          height="25"
          class="companyLogo"
        />

        <span class="menu-collapsed companyName">
          <div class="companyLogo-kmg"></div
        ></span>
      </div>
    </a>
    <a href="#submenu1" data-toggle="collapse" aria-expanded="false">
      <div class="assets2" tabindex="0">Операционные активы</div>
    </a>
    <div id="submenu1" class="collapse">
      <a
        data-toggle="collapse"
        aria-expanded="false"
        class="bg-dark list-group-item list-group-item-action circle-menu flex-column align-items-start circle-menu"
        :style="`${buttonMenuHover1}`"
        @click="saveCompany('ОМГ')"
      >
        <div class="d-flex w-100 justify-content-start align-items-center">
          <img
            src="/img/level1/logo_ozen.svg"
            width="25"
            height="25"
            class="companyLogo"
          />
          <span class="menu-collapsed companyName">АО "ОзенМунайГаз"</span>
        </div>
      </a>
      <a
        class="bg-dark list-group-item list-group-item-action circle-menu"
        :style="`${buttonMenuHover2}`"
        @click="saveCompany('КБМ')"
      >
        <div class="d-flex w-100 justify-content-start align-items-center">
          <img
            src="/img/level1/logo_karazhanbas.svg"
            width="25"
            height="25"
            class="companyLogo"
          />
          <span class="menu-collapsed companyName">АО "Каражанбасмунай"</span>
        </div>
      </a>
      <a
        class="bg-dark list-group-item list-group-item-action circle-menu"
        :style="`${buttonMenuHover3}`"
        @click="saveCompany('КГМ')"
      >
        <div class="d-flex w-100 justify-content-start align-items-center">
          <img
            src="/img/level1/logo_kazger.svg"
            width="25"
            height="25"
            class="companyLogo"
          />
          <span class="menu-collapsed companyName">ТОО "КазГерМунай"</span>
        </div>
      </a>
      <a
        class="bg-dark list-group-item list-group-item-action circle-menu"
        :style="`${buttonMenuHover4}`"
        @click="saveCompany('ЭМГ')"
      >
        <div class="d-flex w-100 justify-content-start align-items-center">
          <img
            src="/img/level1/logo_ozen.svg"
            width="25"
            height="25"
            class="companyLogo"
          />
          <span class="menu-collapsed companyName">АО "ЭмбаМунайГаз"</span>
        </div>
      </a>
      <a
        class="bg-dark list-group-item list-group-item-action circle-menu"
        :style="`${buttonMenuHover5}`"
        @click="saveCompany('ММГ')"
      >
        <div class="d-flex w-100 justify-content-start align-items-center">
          <img
            src="/img/level1/logo_mangistau.png"
            width="25"
            height="25"
            class="companyLogo"
          />
          <span class="menu-collapsed companyName">АО "Мангистаумунайгаз"</span>
        </div>
      </a>
      <a
        class="bg-dark list-group-item list-group-item-action circle-menu"
        :style="`${buttonMenuHover6}`"
        @click="saveCompany('КТМ')"
      >
        <div class="d-flex w-100 justify-content-start align-items-center">
          <img
            src="/img/level1/logo_kazakhturkmunai.png"
            width="25"
            height="25"
            class="companyLogo"
          />
          <span class="menu-collapsed companyName">ТОО "Казахтуркмунай"</span>
        </div>
      </a>
      <a
        class="bg-dark list-group-item list-group-item-action circle-menu"
        :style="`${buttonMenuHover7}`"
        @click="saveCompany('КОА')"
      >
        <div class="d-flex w-100 justify-content-start align-items-center">
          <img
            src="/img/level1/logo_koa.svg"
            width="25"
            height="25"
            class="companyLogo"
          />
          <span class="menu-collapsed companyName">ТОО "Казахойл Актобе"</span>
        </div>
      </a>
      <a
        class="bg-dark list-group-item list-group-item-action circle-menu"
        :style="`${buttonMenuHover8}`"
        @click="saveCompany('ПКИ')"
      >
        <div class="d-flex w-100 justify-content-start align-items-center">
          <img
            src="/img/level1/logo_petrokaz.svg"
            width="25"
            height="25"
            class="companyLogo"
          />
          <span class="menu-collapsed companyName">ПетроКазахстан Инк.</span>
        </div>
      </a>
      <a
        class="bg-dark list-group-item list-group-item-action circle-menu"
        :style="`${buttonMenuHover9}`"
        @click="saveCompany('АГГ')"
      >
        <div class="d-flex w-100 justify-content-start align-items-center">
          <img
            src="/img/level1/logo_amangeldy.png"
            width="25"
            height="25"
            class="companyLogo"
          />
          <span class="menu-collapsed companyName">Амангельды Газ</span>
        </div>
      </a>
    </div>

    <a href="#submenu2" data-toggle="collapse" aria-expanded="false"
      ><div class="assets" tabindex="-0">
        Неоперационные активы
        <div tabindex="-0" class="button-menu button-menu-position"></div></div
    ></a>
    <div id="submenu2" class="collapse">
      <a class="bg-dark list-group-item list-group-item-action">
        <div class="d-flex w-100 justify-content-start align-items-center">
          <img
            src="/img/level1/logo_tengiz.svg"
            width="25"
            height="25"
            class="companyLogo"
          />
          <span class="menu-collapsed companyName">ТОО «Тенгизшевройл»</span>
        </div>
      </a>
      <a class="bg-dark list-group-item list-group-item-action">
        <div class="d-flex w-100 justify-content-start align-items-center">
          <img
            src="/img/level1/logo_karachaganak.svg"
            width="25"
            height="25"
            class="companyLogo"
          />
          <span class="menu-collapsed companyName"
            >«Карачаганак Петролеум Оперейтинг б.в.»</span
          >
        </div>
      </a>
      <a class="bg-dark list-group-item list-group-item-action">
        <div class="d-flex w-100 justify-content-start align-items-center">
          <img
            src="/img/level1/logo_ncoc.svg"
            width="25"
            height="25"
            class="companyLogo"
          />
          <span class="menu-collapsed companyName"
            >«Норт Каспиан Оперейтинг Компани н.в.»</span
          >
        </div>
      </a>
    </div>
    <div class="left-price-oil">
      <div class="left-price-oil2">
        Цена за баррель нефти
        <div class="price-border">{{ oilNow }} $</div>
      </div>

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

      <!-- <div class="period" @click="periodSelect('7','7 дней')">7 дней</div>
      <div class="period" @click="periodSelect('30','1 мес')">1 мес</div>
      <div class="period" @click="periodSelect('133','6 мес')">6 мес</div>
      <div class="period" @click="periodSelect('365','1 год')">1 год</div>
      <div class="period" @click="periodSelect('1825','5 лет')">5 лет</div>-->

      <!--<hr class="hr-visualcenter" />-->
      <visual-center-chart-area-oil
        v-for="(serial, index) in oilChart"
        v-bind:postTitle="serial"
        :key="serial"
      ></visual-center-chart-area-oil>
      <!--<hr class="hr-visualcenter" />
      <ul class="oil-string-all">
        <li class="oil-string one">Нефть Brent</li>
        <li class="oil-string two">41,65</li>
        <li class="oil-string three">+0,60</li>
        <li class="oil-string three">+1,46%</li>
      </ul>
      <hr class="hr-visualcenter" />
      <ul class="oil-string-all">
        <li class="oil-string one">Нефть WTI</li>
        <li class="oil-string two">41,65</li>
        <li class="oil-string three">+0,60</li>
        <li class="oil-string three">+1,46%</li>
      </ul>
      <hr class="hr-visualcenter" />
      <ul class="oil-string-all">
        <li class="oil-string one">Нефть Urals</li>
        <li class="oil-string two">41,65</li>
        <li class="oil-string three">+0,60</li>
        <li class="oil-string three">+1,46%</li>
      </ul>
      <hr class="hr-visualcenter" />-->
    </div>
    <div class="assets3"></div>

    <div class="left-price-oil">
      <div class="left-price-oil2">
        Курс доллара
        <div class="price-border">{{ currencyNow.description }} &#8376;</div>
      </div>
      <div
        @click="selectedDMY2 = menuDMY.id"
        class="period"
        v-for="(menuDMY, index) in periodSelectFunc()"
        :style="{
          color: menuDMY.current2,
        }"
        v-on:click="periodSelect"
      >
        <div>{{ menuDMY.DMY }}</div>
      </div>

      <visual-center-chart-area-usd
        v-for="(serial2, index) in currencyChart"
        v-bind:postTitles="serial2"
        :key="serial2"
      ></visual-center-chart-area-usd>
      <div class="oil-period">{{ oilPeriod }}</div>
    </div>
  </div>
  <!-- sidebar-container END -->
</template>

<script>
import { EventBus } from "./event-bus.js";
export default {
  data: function () {
    return {
      selectedDMY2: "",
      selectedDMY: "",
      periodSelectOil: "",
      oilPeriod: "",
      period: "7",
      periodUSD: "7",
      company: "",
      timeSelect: "",
      oilNow: "",
      oilChart: "",
      buttonMenuHover1: "",
      buttonMenuHover2: "",
      buttonMenuHover3: "",
      buttonMenuHover4: "",
      buttonMenuHover5: "",
      buttonMenuHover6: "",
      buttonMenuHover7: "",
      buttonMenuHover8: "",
      buttonMenuHover9: "",
      buttonMenuHover10: "all",
      currencyNow: "",
      currencyChart: "",
      month: new Date().getMonth(),
      year: new Date().getFullYear(),
      currencyNowUsd: "",
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
    };
  },
  updated() {},
  mounted() {},
  methods: {
    periodSelectFunc() {
      var DMY = ["7 дней", "1 мес", "6 мес", "1 год", "5 лет"];
      var menuDMY = [];
      var id = 0;
      for (let i = 0; i <= 4; i++) {
        var a = { index: i, id: i };
        a.DMY = DMY[i];
        menuDMY.push(a);
        if (this.selectedDMY == i) {
          a.current = "#fff";
          this.DMY = menuDMY[i]["DMY"];
        }
        if (this.selectedDMY2 == i) {
          a.current2 = "#fff";
          this.DMY = menuDMY[i]["DMY"];
        }
      }

      if (this.selectedDMY != undefined) {
      }

      // localStorage.setItem("selectedDMY", this.selectedDMY);

      return menuDMY;
      // this.periodSelect();
    },

    periodSelect: function (event) {
      if (this.selectedDMY == 0) {
        this.period = 7;
      }
      if (this.selectedDMY == 1) {
        this.period = 30;
      }
      if (this.selectedDMY == 2) {
        this.period = 183;
      }
      if (this.selectedDMY == 3) {
        this.period = 365;
      }
      if (this.selectedDMY == 4) {
        this.period = 1825;
      }
      return this.getOilNow(this.timeSelect, this.period);
    },

    periodSelect: function (event) {
      if (this.selectedDMY2 == 0) {
        this.periodUSD = 7;
      }
      if (this.selectedDMY2 == 1) {
        this.periodUSD = 30;
      }
      if (this.selectedDMY2 == 2) {
        this.periodUSD = 183;
      }
      if (this.selectedDMY2 == 3) {
        this.periodUSD = 365;
      }
      if (this.selectedDMY2 == 4) {
        this.periodUSD = 1825;
      }
      return this.getCurrencyPeriod(this.timeSelect, this.periodUSD);
    },

    timeSelect2(select) {
      this.timeSelect = select;
      this.getCurrencyNow(this.timeSelect);
      this.getOilNow(this.timeSelect, this.period);
      this.getCurrencyPeriod(this.timeSelect, this.periodUSD);
    },

    getCurrencyNow: function (dates) {
      var datas;
      let uri = this.localeUrl("/getcurrency?fdate=") + dates + "";
      this.axios.get(uri).then((response) => {
        var data = response.data;
        if (data) {
          //console.log(data);
          this.currencyNow = data;
          this.currencyNowUsd =
            Math.trunc((1 / data.description) * 10000) / 10000;
        } else {
          console.log("No data");
        }
      });
    },

    getCurrencyPeriod: function (dates, item2) {
      var dates = dates;
      let uri =
        this.localeUrl("/getcurrencyperiod?dates=") + dates + "&period=" + item2 + " ";
      this.axios.get(uri).then((response) => {
        var data = response.data;
        if (data) {
          var arrdata2 = [];
          _.forEach(data, function (item) {
            arrdata2.push({ dates: item.dates, value: item.description["0"] });
          });
          var currencyChart = Array({ data: arrdata2 });
          this.currencyChart = currencyChart;
        } else {
          console.log("No data");
        }
      });
    },

    getOilNow: function (dates, period) {
      var datas;
      let uri = "/js/json/graph_1006.json";
      //let uri =        "https://cors-anywhere.herokuapp.com/" +        "https://yandex.ru/news/quotes/graph_1006.json";
      this.axios.get(uri).then((response) => {
        var data = response.data;
        if (data) {
          var oilDate;
          var oilDate2;
          var oilValue;
          var splits = [];
          var oil = [];
          var oil2;
          _.forEach(data.prices, function (prices) {
            splits = prices.toString().split(",");
            oilValue = splits["1"];
            oilDate = Number(splits["0"]);

            (oilDate2 = new Date(oilDate).toLocaleString("ru", {
              year: "numeric",
              day: "numeric",
              month: "numeric",
              timeZone: "Europe/Moscow",
            })),
              oil.push({
                dateSimple: oilDate,
                date: oilDate2,
                value: oilValue,
              });
          });

          var oil2 = [];

          oil2 = _.filter(oil, _.iteratee({ date: dates }));

          if (oil2.length != "0") {
            this.oilNow = oil2[0].value;
          } else {
            oil = _.last(oil);
            this.oilNow = oil.value;
          }

          var datesNow = [];
          datesNow = dates.split(".");
          var day = datesNow[0];
          var month = datesNow[1].replace(/^0+/, "");
          var year = datesNow[2];

          var timestampToday = new Date(
            this.monthes2[month - 1] + day + " " + year + " 06:00:00 GMT+0600"
          ).getTime();

          //console.log(timestampToday);
          var dateInOil = [];
          dateInOil = _.filter(oil, function (item) {
            return _.every([
              _.inRange(
                item.dateSimple,
                timestampToday - 86400000 * Number(period),
                timestampToday + 86400000
              ),
            ]);
          });
          //this.oilChart=    [_.takeRight(oil, 31)];
          this.oilChart = [dateInOil];
          console.log(dateInOil);
        } else {
          console.log("No data");
        }
      });
    },

    saveCompany(com) {
      localStorage.setItem("company", com);
      var company = localStorage.getItem("company");
      this.company = company;

      var buttonMenuHover =
        "background: url(../img/visualcenter/circle-menu-white.png) no-repeat;" +
        "background-size: 9% auto;" +
        "background-position: 75% 50%;" +
        "border: none;" +
        "height: 40px;" +
        "pointer-events: none;";

      if (company == "ОМГ") {
        this.buttonMenuHover1 = buttonMenuHover;
      } else {
        this.buttonMenuHover1 = "";
      }
      if (company == "КБМ") {
        this.buttonMenuHover2 = buttonMenuHover;
      } else {
        this.buttonMenuHover2 = "";
      }

      if (company == "КГМ") {
        this.buttonMenuHover3 = buttonMenuHover;
      } else {
        this.buttonMenuHover3 = "";
      }

      if (company == "ЭМГ") {
        this.buttonMenuHover4 = buttonMenuHover;
      } else {
        this.buttonMenuHover4 = "";
      }

      if (company == "ММГ") {
        this.buttonMenuHover5 = buttonMenuHover;
      } else {
        this.buttonMenuHover5 = "";
      }

      if (company == "КТМ") {
        this.buttonMenuHover6 = buttonMenuHover;
      } else {
        this.buttonMenuHover6 = "";
      }

      if (company == "КОА") {
        this.buttonMenuHover7 = buttonMenuHover;
      } else {
        this.buttonMenuHover7 = "";
      }

      if (company == "ПКИ") {
        this.buttonMenuHover8 = buttonMenuHover;
      } else {
        this.buttonMenuHover8 = "";
      }

      if (company == "АГГ") {
        this.buttonMenuHover9 = buttonMenuHover;
      } else {
        this.buttonMenuHover9 = "";
      }

      if (company == "all") {
        this.buttonMenuHover10 = buttonMenuHover;
      } else {
        this.buttonMenuHover10 = "";
      }

      EventBus.$emit("messageSend", this.company);
    },
  },

  created() {
    EventBus.$on("timeSelect", this.timeSelect2);
    this.buttonMenuHover10 =
      "background: url(../img/visualcenter/circle-menu-white.png) no-repeat;" +
      "background-size: 9% auto;" +
      "background-position: 75% 50%;" +
      "border: none;" +
      "height: 40px;" +
      "pointer-events: none;";
  },
  computed: {},
};
</script>
