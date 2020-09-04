<template>
  <div class="list-group">
    <a
      class="bg-dark list-group-item list-group-item-action circle-menu"
      :style="`${buttonMenuHover10}`"
      @click="saveCompany('all')"
    >
      <div class="d-flex w-100 justify-content-start align-items-center">
        <div class="companyLogo-kmg"></div>
        <span class="menu-collapsed companyName"></span>
      </div>
    </a>
    <a href="#submenu1" data-toggle="collapse" aria-expanded="false">
      <div class="assets2" tabindex="0">Операционные активы</div>
    </a>
    <div id="submenu1" class="collapse sidebar-submenu submenu1">
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
    <div id="submenu2" class="collapse sidebar-submenu">
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
        Цена за нефть
        <div class="price-border">{{ oilNow }} $</div>
      </div>
      <!--<hr class="hr-visualcenter" />-->
      <visual-center-chart-area-oil
        v-for="(serial, index) in oilChart"
        v-bind:postTitle="serial"
        :key="serial"
      ></visual-center-chart-area-oil>
      <hr class="hr-visualcenter" />
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
      <hr class="hr-visualcenter" />
    </div>

    <div class="assets3"></div>

    <div class="left-price-oil">
      <div class="left-price-oil2">
        Курс доллара
        <div class="price-border">{{ currencyNow.description }} &#8376;</div>
      </div>
      <ul class="oil-string-all">
        <li class="oil-string one2 width-price">1 казахстанский тенге равно</li>
        <li class="oil-string two2">1</li>
        <li class="oil-string three2">Тенге</li>
      </ul>
      <ul class="oil-string-all">
        <li class="oil-string one2-2 width-price">Доллар США</li>
        <li class="oil-string two2">
          {{ currencyNowUsd }}
        </li>
        <li class="oil-string three2">Доллар</li>
      </ul>
      <visual-center-chart-area-usd
        v-for="(serial2, index) in currencyChart"
        v-bind:postTitles="serial2"
        :key="serial2"
      ></visual-center-chart-area-usd>
    </div>
  </div>
  <!-- sidebar-container END -->
</template>

<script>
import { EventBus } from "./event-bus.js";
export default {
  data: function () {
    return {
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
    };
  },
  updated() {},
  mounted() {},
  methods: {
    timeSelect2(select) {
      this.timeSelect = select;
      this.getCurrencyNow(this.timeSelect);
      this.getOilNow(this.timeSelect);
      this.getCurrency();
    },

    getCurrencyNow: function (dates) {
      var datas;
      let uri = "/ru/getcurrency?fdate=" + dates + "";
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

    getCurrency: function (dates) {
      var datas;
      let uri = "/ru/getcurrencyperiod";
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

    getOilNow: function (dates) {
      var datas;
      //let uri = "/js/json/graph_1006.json";
      let uri =        "https://cors-anywhere.herokuapp.com/" +        "https://yandex.ru/news/quotes/graph_1006.json";
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
                date: oilDate2,
                value: oilValue,
              });
          });

          this.oilChart = [_.takeRight(oil, 7)];

          var oil2 = [];

          oil2 = _.filter(oil, _.iteratee({ date: dates }));
          console.log(dates);
          //oil2 = _.last(oil);
         // oil2 = oil2.value;
          this.oilNow = oil2[0].value;
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
