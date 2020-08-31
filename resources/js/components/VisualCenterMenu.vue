<template>
  <div class="list-group">
    <a
      href="#"
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
        href="#"
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
        href="#"
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
        href="#"
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
        href="#"
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
        href="#"
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
        href="#"
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
        href="#"
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
        href="#"
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
        href="#"
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
      <a href="#" class="bg-dark list-group-item list-group-item-action">
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
      <a href="#" class="bg-dark list-group-item list-group-item-action">
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
      <a href="#" class="bg-dark list-group-item list-group-item-action">
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
    <!--<button @click="getCurrency('26.08.2020')">Получить курс валют</button>
    <button @click="getCurrencyNow()">Получить текущий курс валют</button>-->


      <div class="left-price-oil">
        <div class="left-price-oil2">Цена за нефть <div class="price-border ">43.1 $</div>
        </div>
        <hr class="hr-visualcenter">
        <visual-center-chart-area-oil></visual-center-chart-area-oil>     
        <hr class="hr-visualcenter">
        <ul class="oil-string-all">
            <li class="oil-string one">Нефть Brent</li>
            <li class="oil-string two">41,65</li>
            <li class="oil-string three">+0,60</li>
            <li class="oil-string three">+1,46%</li>
        </ul>
        <hr class="hr-visualcenter">
        <ul class="oil-string-all">
            <li class="oil-string one">Нефть WTI</li>
            <li class="oil-string two">41,65</li>
            <li class="oil-string three">+0,60</li>
            <li class="oil-string three">+1,46%</li>
        </ul>
        <hr class="hr-visualcenter">
        <ul class="oil-string-all">
            <li class="oil-string one">Нефть Urals</li>
            <li class="oil-string two">41,65</li>
            <li class="oil-string three">+0,60</li>
            <li class="oil-string three">+1,46%</li>
        </ul>
        <hr class="hr-visualcenter">
    </div>
    

   <div class="assets3"></div>

    <div class="left-price-oil">
      <div class="left-price-oil2">
        Курс доллара
        <div class="price-border">{{ currencyNow.description }}&#8376;</div>
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
          <!--0,0025-->
        </li>
        <li class="oil-string three2">Доллар</li>
      </ul>
      <visual-center-chart-area-usd></visual-center-chart-area-usd>
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
      timeSelect:"",
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
      month: new Date().getMonth(),
      year: new Date().getFullYear(),
      currencyNowUsd: "",
    };
  },
    updated() {

    },
  mounted() {
    //now time
    var date = new Date();
    var currentDate =
      date.getDate() + "." + (date.getMonth() + 1) + "." + date.getFullYear();
    this.getCurrencyNow(currentDate);
    //now time 




    var Months = [];
    var currency = [];
    var id = [];
    for (let i = 1; i <= this.month + 1; i++) {
      id = i;
      Months[i] =
        new Date(this.year, this.month + 1).getDate() + "." + i + ".2020";
      currency[i] = this.getCurrency(Months[i], id);
    }
  },
  methods: {
        timeSelect2: function (select) {
      this.timeSelect = select;
       this.getCurrencyNow(this.timeSelect);
    },

    getCurrencyNow: function (dates) {
      var datas;
      let uri = "/ru/getcurrency?fdate=" + dates + "";
      this.axios.get(uri).then((response) => {
        var data = response.data;
        if (data) {
          console.log(data);
          this.currencyNow = data;
          this.currencyNowUsd =
            Math.trunc((1 / data.description) * 10000) / 10000;
        } else {
          console.log("No data");
        }
      });

    },

    getCurrency(dates, id
    
    ) {
      let uri = "/ru/getcurrency?fdate=" + dates + "";
      this.axios.get(uri).then((response) => {
        let data = response.data;
        if (data) {
          var arrdata = [];
          var arrdata2 = [];
          arrdata = { id: id, dates: dates, data: data.description };

          arrdata = this.currency;
          //arrdata = _.orderBy(arrdata, "id", "desk");
          console.log(arrdata);
          //  console.log(dates+' ' + data.description);
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

      //console.log(company == "КГМ");

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
    }
  },

created() {
 EventBus.$on("timeSelect", this.timeSelect2); 
this.buttonMenuHover10=  "background: url(../img/visualcenter/circle-menu-white.png) no-repeat;" +
        "background-size: 9% auto;" +
        "background-position: 75% 50%;" +
        "border: none;" +
        "height: 40px;" +
        "pointer-events: none;";
},
  computed: {
 


  },
  

/*
watch: {
    a: function (val, oldVal) {
      console.log('новое значение: %s, старое значение: %s', val, oldVal)
    },


watch(){
  this.getCurrencyNow(this.timeSelect);
}*/
};
</script>
