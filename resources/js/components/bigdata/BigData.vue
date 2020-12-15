<template>
  <div class="row">
    <div class="col-12">

<!--      search input-->
      <div class="bg-dark">
        <div class="input-group input-group-sm">
          <div class="input-group-F">
            <input type="text" class="form-control fix-rounded-right" placeholder="Поиск" required>
          </div>

          <span class="input-group-text" style="font-size: 18px">Поиск</span>
          <div class="invalid-feedback">
            No data.
          </div>
        </div>
      </div>

<!--      delimiter-->
      <div class="row">
        <div class="col-md-12 col-lg-12" style="padding: 10px;">
        </div>
      </div>

<!--      sections block-->
      <div class="bg-dark ">
        <div class="row">
          <div class="col contentTitle r-txt">
            <svg width="20" class="r-txt" height="22" viewBox="0 0 20 22" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M17.7777 2.20008H13.1331C12.6668 0.924038 11.4443 0 10 0C8.55567 0 7.33321 0.924038 6.86653 2.20008H2.22228C0.999815 2.20008 0 3.1899 0 4.40015V19.8003C0 21.0102 0.999815 22 2.22228 22H17.7777C18.9998 22 20 21.0102 20 19.8003V4.40015C20 3.1899 18.9998 2.20008 17.7777 2.20008ZM10 2.20008C10.6112 2.20008 11.1113 2.69518 11.1113 3.29992C11.1113 3.90505 10.6112 4.40015 10 4.40015C9.38878 4.40015 8.88867 3.90505 8.88867 3.29992C8.88867 2.69518 9.38878 2.20008 10 2.20008ZM7.77774 17.6002L3.3332 13.2001L4.89995 11.649L7.77774 14.4869L15.1001 7.23806L16.6668 8.79992L7.77774 17.6002Z"
                    fill="#9EA4C9"/>
            </svg>
            <span class="r-txt2"> Разделы </span>
          </div>
        </div>

        <div class="col">
          <div class="row pading-b-40">

            <div class="col btn-clk"
                 v-for="(section, index) in sections"
                 :key="index"
                 @click="selectReportsSection(index)">
              <div class="btn-blocks">
                <span v-html="section.svg_icon"></span>
                <div class="bold">{{ section.reports.length }} <br> отчёта</div>
              </div>
              <div class="col-md-12 btn-blocks-txt">
                {{ section.title }}
              </div>
            </div>
          </div>
        </div>
      </div>

<!--      delimiter-->
      <div class="row">
        <div class="col-md-12 col-lg-12" style="padding: 10px;">
        </div>
      </div>


      <div class="bg-dark"
           v-if="selectedSection">
        <div class="col">
          <div class="row">
            <div class="reportsBut col-md-12">

              <div class="menu-items">

                <!-- Надпись отчеты -->
                <div class="row pading-b-40">
                  <div class="col contentTitle r-txt">
                    <svg width="27" class="r-txt" height="22" viewBox="0 0 27 22" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M19.0025 4.04802H23.8041C25.1996 4.04802 26.3413 5.18972 26.3413 6.58517V7.74398V18.8907V19.4629C26.3413 20.8583 25.1996 22 23.8041 22H23.232H3.1093H2.53714C1.1417 22 0 20.8583 0 19.4629V18.8907V6.58517V3.1093C0 1.39917 1.39917 0 3.1093 0H15.0773L19.0025 4.04802V4.04802ZM8.46266 12.1001L11.4375 14.8479L17.7026 8.52142L18.9793 9.72999L11.3681 17.405L7.08398 13.2147L8.46266 12.1001ZM13.6253 0.557345H14.7986L18.0436 3.96H16.8813L13.6253 0.557345ZM11.4106 0.557345H12.5839L15.8289 3.96H14.6666L11.4106 0.557345V0.557345ZM9.284 0.557345H10.4573L13.7023 3.96H12.54L9.284 0.557345V0.557345Z"
                            fill="#9EA4C9"/>
                    </svg>
                    <span class="r-txt2"> Отчеты </span>
                  </div>
                </div>
                <!-- end надпиьс отчеты -->

                <div class="row"
                     v-for="(reportsSectionBlock, index) in sections"
                     :key="index"
                     v-if="selectedSection === index">
                  <button type="button"
                          class="col btn report-btn-bd"
                          v-for="(report, reportIndex) in reportsSectionBlock.reports"
                          :key="reportIndex">
                    <span v-html="report.svg_icon"></span>
                    <span class="font-size">
                      {{ report.title }}
                    </span>
                    <span class="r-txt f-right">
                        <svg width="8" height="16" viewBox="0 0 8 16" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0.888015 16.001C1.01426 16.0008 1.13902 15.9737 1.254 15.9215C1.36898 15.8693 1.47155 15.7932 1.55487 15.6982L7.77884 8.57414C7.92139 8.41163 8 8.20272 8 7.98641C8 7.7701 7.92139 7.56118 7.77884 7.39867L1.55487 0.27461C1.39616 0.109125 1.1798 0.0113815 0.950901 0.00176043C0.721998 -0.00786062 0.49822 0.0713829 0.326229 0.222969C0.154237 0.374554 0.047307 0.586782 0.0277324 0.8154C0.00815725 1.04402 0.0774493 1.27138 0.221161 1.45008L5.92943 7.98641L0.221161 14.5227C0.108386 14.6513 0.0349884 14.8097 0.00975227 14.9789C-0.0154839 15.1482 0.00850964 15.3212 0.0788636 15.4771C0.149217 15.6331 0.262951 15.7654 0.406452 15.8583C0.549953 15.9512 0.717143 16.0008 0.888015 16.001Z"
                                fill="#9EA4C9"/>
                        </svg>
                    </span>
                  </button>
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
import Sections from './sections.json'

export default {
  data() {
    return {
      sections: Sections,
      selectedSection: null
    }
  },
  mounted() {
    console.log(this.sections);
  },
  methods: {
    selectReportsSection(index) {
      this.selectedSection = index
    }
  }
}
</script>