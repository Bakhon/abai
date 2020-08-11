<template>
  <div class="list-group">
    <a href="#submenu1" data-toggle="collapse" aria-expanded="false">
      <div class="assets2" tabindex="0">Операционные активы</div>
    </a>
    <div id="submenu1" class="collapse sidebar-submenu submenu1">
      <a
        href="#"
        data-toggle="collapse"
        aria-expanded="false"
        class="bg-dark list-group-item list-group-item-action circle-menu flex-column align-items-start circle-menu"
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
      >
        <div
          class="d-flex w-100 justify-content-start align-items-center"
          @click="saveCompany('КБМ')"
        >
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
  </div>
  <!-- sidebar-container END -->
</template>

<script>
export default {
  data: () => ({
    company: "",
  }),
  methods: {
    saveCompany(com) {
      localStorage.setItem("company", com);
      this.company = localStorage.getItem("company");
    },
  },
};
</script>
