<template>
  <div class="row">
    <div class="col-12 big-data-page-content"
         :class="{'with-opened-filter': selectedReport}">

<!--      search input-->
      <div class="bg-dark big-data-input-container">
        <search-form :search-string.sync="searchString"
                     :placeholder="'Введите минимум 3 символа'"
                     @start-search="search()"/>
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
                 @click="selectReportsSection(section)">
              <div class="btn-blocks"
                   :class="{'selected': selectedSection === section.tag, 'disabled': !section.reports.length}">
                <span class="height-center" v-html="section.svg_icon"></span>

                <div class="bold">{{ section.reports.length }}
                  <br>
                  {{ numWord(section.reports.length, ['отчёт', 'отчёта', 'отчётов']) }}
                </div>
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

<!--      reports-->
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

                <div class="row pading-b-40 no-margin report-btn-list"
                     v-for="(reportsSectionBlock, index) in sections"
                     :key="index"
                     v-if="selectedSection === reportsSectionBlock.tag">
                  <big-data-report-button v-if="reportsSectionBlock.reports.length"
                                          v-for="(report, reportIndex) in reportsSectionBlock.reports"
                                          :key="reportIndex"
                                          :report="report"
                                          :selected-report="selectedReport"
                                          @click="selectReport(report, false)"/>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

<!--      search result-->
      <div class="bg-dark"
           v-if="searchResult.length || (searchString && !selectedSection)">
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
                    <span class="r-txt2"> Результаты поиска </span>
                  </div>
                </div>
                <!-- end надпиьс отчеты -->

                <div class="row pading-b-40 no-margin report-btn-list">
                  <big-data-report-button v-for="(report, reportIndex) in searchResult"
                                          :key="reportIndex"
                                          :report="report"
                                          :selected-report="selectedReport"
                                          @click="selectReport(report, true)"/>
                  <div v-if="!searchResult.length && searchString"
                       class="empty-reports-list">
                    <span>
                      <svg width="64" height="65" viewBox="0 0 64 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M44.1983 27.2929C44.1589 22.7458 42.5907 18.8065 39.4388 15.5282C36.2396 12.2007 32.2758 10.5528 27.6943 10.3239C17.9662 10.2955 10.4969 17.562 10.3568 27.304C10.2921 31.8096 11.9201 35.7435 15.0381 38.9841C18.2674 42.3403 22.248 44.0855 26.9354 44.2057C36.4497 44.4497 44.2505 36.6232 44.1983 27.2929ZM54.4651 27.3525C54.4651 27.8863 54.4813 28.4793 54.4612 29.0712C54.4343 29.8636 54.3424 30.6505 54.1866 31.4293C54.1078 31.8237 54.0742 32.2245 53.9971 32.6211C53.6573 34.3697 53.1327 36.0599 52.4578 37.7046C51.8807 39.1108 51.1855 40.4574 50.3722 41.7424C50.1093 42.1577 50.1131 42.1739 50.4638 42.5247C54.3468 46.4098 58.2281 50.2967 62.1156 54.1773C62.6924 54.7531 63.1915 55.3775 63.523 56.1258C63.803 56.7576 63.9864 57.4138 63.997 58.1108C64.0078 58.8246 64.0017 59.5327 63.7647 60.2234C63.5577 60.8266 63.2833 61.39 62.9068 61.9017C62.3975 62.5938 61.7673 63.1521 61.0049 63.5523C60.3074 63.9185 59.5737 64.1738 58.7768 64.1811C58.0929 64.1873 57.4079 64.227 56.7349 64.0224C55.9128 63.7725 55.1508 63.4177 54.5206 62.8264C53.3941 61.7693 52.2972 60.6818 51.2237 59.5706C50.8977 59.2331 50.545 58.9214 50.2219 58.5815C49.4808 57.8022 48.7185 57.0421 47.9531 56.2892C46.121 54.4864 44.317 52.6558 42.4886 50.8497C42.3641 50.7267 42.2382 50.6051 42.1153 50.4806C41.9688 50.3322 41.8243 50.3297 41.6481 50.4448C40.8814 50.9451 40.0774 51.3795 39.2531 51.7775C38.1756 52.2977 37.0746 52.753 35.9401 53.1406C34.3572 53.6812 32.7357 54.0412 31.0897 54.2975C30.4685 54.3942 29.8398 54.4523 29.2093 54.4977C28.1466 54.5743 27.0851 54.5707 26.0243 54.5387C25.2614 54.5157 24.4991 54.4432 23.7401 54.3377C22.6088 54.1803 21.4883 53.9799 20.3821 53.6912C18.3448 53.1596 16.3926 52.4117 14.5301 51.43C12.9934 50.6201 11.549 49.6651 10.1898 48.5867C8.98643 47.632 7.88668 46.5587 6.86091 45.4185C5.60014 44.017 4.50132 42.4888 3.57207 40.8467C2.71003 39.3234 1.98492 37.7341 1.41691 36.0764C0.897765 34.561 0.513185 33.0098 0.288122 31.4252C0.127715 30.2958 -0.0265163 29.1626 0.00385284 28.0142C0.0259432 27.1798 0.000742718 26.344 0.0305869 25.5101C0.0488003 25.0017 0.132642 24.4958 0.185061 23.9887C0.295755 22.9188 0.484148 21.8618 0.744386 20.8194C1.21454 18.9362 1.85573 17.1158 2.71398 15.3694C3.4697 13.8317 4.34257 12.3676 5.3603 10.9937C6.50003 9.45516 7.81701 8.0769 9.24239 6.79715C10.0145 6.10396 10.8309 5.47126 11.681 4.88417C13.0653 3.92835 14.5131 3.08279 16.0573 2.40083C17.1777 1.90603 18.3208 1.48441 19.49 1.1265C20.4666 0.827504 21.4606 0.601355 22.4654 0.424744C23.4176 0.257386 24.3783 0.16494 25.3417 0.079079C26.4174 -0.0168022 27.4912 -0.0140551 28.5652 0.0271177C29.2342 0.0527749 29.8998 0.15892 30.5682 0.212255C31.481 0.285146 32.372 0.484869 33.2655 0.66552C33.7778 0.769118 34.2841 0.908554 34.7857 1.05712C36.6068 1.59653 38.3697 2.2839 40.046 3.18251C41.4935 3.95849 42.852 4.86809 44.1515 5.87418C45.3376 6.79246 46.3929 7.8459 47.4173 8.93122C48.3305 9.89868 49.1451 10.9472 49.8795 12.0612C50.3385 12.7575 50.7883 13.459 51.1889 14.188C51.752 15.2126 52.2429 16.275 52.6682 17.3653C53.079 18.4185 53.4264 19.4951 53.6996 20.5903C53.9168 21.461 54.0888 22.3442 54.2235 23.2348C54.4274 24.582 54.5163 25.9331 54.4651 27.3525Z" fill="#363B68"/>
                      </svg>
                    </span>

                    <span class="empty-search-message">Не найдено ни одного отчета</span>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="report-filter-container bg-dark"
         v-if="selectedReport">
      <div class="report-filter-content-wrapper">
        <div class="report-filter-title">
          <div>
            Фильтр

            <span v-if="!selectedReport.in_favor"
                  @click="addReportToFavor(selectedReport)"
                  class="report-filter-favor-star">
              <i class="far fa-star"></i>
            </span>

            <span v-if="selectedReport.in_favor"
                  class="report-filter-favor-star">
              <i class="fas fa-star"></i>
            </span>
          </div>

          <div class="report-filter-title-description">
            {{ selectedReport.title }}
          </div>
        </div>

        <monthly-production v-if="selectedReport.tag === 'monthly-production'"/>
        <daily-production v-if="selectedReport.tag === 'daily-production'"/>
        <daily-injection v-if="selectedReport.tag === 'daily-injection'"/>
      </div>
    </div>
  </div>
</template>

<script>
import Sections from './sections.json'
import NewReportTable from '../reports/MonthlyProduction';
import SearchForm from '../ui-kit/SearchForm';
import BigDataReportButton from './BigDataReportButton';

export default {
  components: { NewReportTable, SearchForm, BigDataReportButton },
  data() {
    return {
      sections: Sections.data,
      selectedSection: null,
      selectedReport: null,
      searchString: '',
      searchResult: [],
    }
  },
  mounted() {
    this.selectedSection = 'favor';
    // не забыть удалить
    let self = this;
    this.sections.forEach((section) => {
      if (section.tag === 'favor') {
        self.selectedReport = section.reports[0];
      }
    });
  },
  methods: {
    numWord(value, words){
      value = Math.abs(value) % 100;
      let num = value % 10;
      if (value > 10 && value < 20) {
        return words[2];
      }

      if (num > 1 && num < 5) {
        return words[1];
      }
      if (num == 1) {
        return words[0];
      }

      return words[2];
    },
    selectReportsSection(section) {
      if (section.reports.length) {
        this.searchResult = [];
        this.searchString = '';
        this.selectedSection = section.tag;
      }
    },
    selectReport(report, bySearchResult) {
      if (!bySearchResult) {
        this.searchResult = [];
        this.searchString = '';
      }

      if (report.is_active) {
        this.selectedReport = report;
      }
    },
    searchCondition(search, report) {
      search = search.trim().replace('ё', 'е');
      return search.length >= 3 && (report.title.toLowerCase().match(search.toLowerCase()) || report.description.toLowerCase().match(search.toLowerCase()))
    },
    addReportToFavor(report) {
      report.in_favor = true;

      this.sections.forEach((section) => {
        if (section.tag === 'favor') {
          section.reports.push(report);
        }
      });
    },
    checkResult(result, report) {
      return result.find((item) => {
        return item.tag === report.tag;
      });
    },
    search() {
      let self = this;
      let searchVars = self.searchString.trim().split(' ');
      let result = [];

      self.searchResult = [];
      self.selectedSection = null;
      self.selectedReport = null;

      self.sections.forEach((section) => {
        if (section.tag !== 'favor' && section.reports.length) {
          section.reports.forEach((report) => {
            if (!self.checkResult(result, report) && self.searchCondition(self.searchString, report)) {
              result.push(report);
            }
          });
        }
      });

      if (!result.length) {
        self.sections.forEach((section) => {
          if (section.tag !== 'favor' && section.reports.length) {
            section.reports.forEach((report) => {
              searchVars.forEach((search) => {
                if (!self.checkResult(result, report) && self.searchCondition(search, report)) {
                  result.push(report);
                }
              });
            });
          }
        });
      }

      self.searchResult = result;
    }
  }
}
</script>

<style scoped></style>
