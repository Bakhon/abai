<template>
  <div class="table-page">
    <cat-loader v-show="loading"/>
    <div class="filter-bg" v-if="filterOpened" @click="hideFilters"></div>
    <div class="float-right table-page__links">
      <a v-if="params.links.create" class="table-page__links-item table-page__links-item_add"
         :href="params.links.create">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M16 9.6H9.6V16H6.4V9.6H0V6.4H6.4V0H9.6V6.4H16V9.6Z"
                fill="white"/>
        </svg>
      </a>
      <a v-if="params.links.export" class="table-page__links-item table-page__links-item_excel"
         @click.prevent="runJob(params.links.export)" href="#">
        <svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path
              d="M14.7071 5.70711L10.293 1.2929C10.1055 1.10536 9.8511 1 9.58588 1L2.00028 1.00002C1.448 1.00002 1.00029 1.44774 1.00029 2.00002L1.00029 18C1.00029 18.5523 1.448 19 2.00029 19L14 19C14.5523 19 15 18.5523 15 18L15 6.41421C15 6.14899 14.8946 5.89464 14.7071 5.70711Z"
              stroke="white" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M9.11719 1V6.02353C9.11719 6.57581 9.5649 7.02353 10.1172 7.02353H14.9994" stroke="white"
                stroke-width="1.4" stroke-linejoin="round"/>
          <path
              d="M4.37372 13.1938C4.66705 13.1938 4.90572 13.2885 5.08972 13.4778C5.27372 13.6645 5.36572 13.9085 5.36572 14.2098C5.36572 14.2685 5.36305 14.3218 5.35772 14.3698H4.01372C4.01372 14.4792 4.05105 14.5725 4.12572 14.6498C4.20039 14.7245 4.29239 14.7618 4.40172 14.7618C4.55105 14.7618 4.65639 14.7018 4.71772 14.5818H5.34172C5.27505 14.7818 5.16305 14.9418 5.00572 15.0618C4.84839 15.1818 4.64305 15.2418 4.38972 15.2418C4.10439 15.2418 3.86172 15.1472 3.66172 14.9578C3.46439 14.7685 3.36572 14.5192 3.36572 14.2098C3.36572 13.9165 3.45372 13.6738 3.62972 13.4818C3.80839 13.2898 4.05639 13.1938 4.37372 13.1938ZM4.36572 13.6298C4.26705 13.6298 4.18705 13.6605 4.12572 13.7218C4.06439 13.7805 4.02839 13.8538 4.01772 13.9418H4.71372C4.70305 13.8512 4.66572 13.7765 4.60172 13.7178C4.54039 13.6592 4.46172 13.6298 4.36572 13.6298ZM5.42922 15.1738L6.11722 14.2178L5.46522 13.2578H6.20922L6.39722 13.5978C6.42922 13.6565 6.45855 13.7258 6.48522 13.8058H6.50122C6.53855 13.6938 6.56255 13.6272 6.57322 13.6058L6.74522 13.2578H7.48522L6.83722 14.2058L7.50522 15.1738H6.73322L6.54922 14.8338C6.50389 14.7458 6.47855 14.6738 6.47322 14.6178H6.45722C6.44122 14.6765 6.41189 14.7498 6.36922 14.8378L6.18522 15.1738H5.42922ZM8.5735 13.1938C8.8295 13.1938 9.04017 13.2725 9.2055 13.4298C9.37083 13.5845 9.4695 13.7672 9.5015 13.9778H8.8495C8.83617 13.9112 8.80283 13.8578 8.7495 13.8178C8.69883 13.7778 8.6375 13.7578 8.5655 13.7578C8.44817 13.7578 8.3615 13.8005 8.3055 13.8858C8.25217 13.9712 8.2255 14.0805 8.2255 14.2138C8.2255 14.3472 8.25483 14.4578 8.3135 14.5458C8.37217 14.6312 8.46017 14.6738 8.5775 14.6738C8.65217 14.6738 8.71483 14.6525 8.7655 14.6098C8.81883 14.5645 8.85483 14.5072 8.8735 14.4378H9.5375C9.47883 14.6805 9.36683 14.8752 9.2015 15.0218C9.03883 15.1685 8.82683 15.2418 8.5655 15.2418C8.28017 15.2418 8.0375 15.1472 7.8375 14.9578C7.64017 14.7685 7.5415 14.5192 7.5415 14.2098C7.5415 13.9218 7.63483 13.6805 7.8215 13.4858C8.00817 13.2912 8.25883 13.1938 8.5735 13.1938ZM10.7604 13.1938C11.0538 13.1938 11.2924 13.2885 11.4764 13.4778C11.6604 13.6645 11.7524 13.9085 11.7524 14.2098C11.7524 14.2685 11.7498 14.3218 11.7444 14.3698H10.4004C10.4004 14.4792 10.4378 14.5725 10.5124 14.6498C10.5871 14.7245 10.6791 14.7618 10.7884 14.7618C10.9378 14.7618 11.0431 14.7018 11.1044 14.5818H11.7284C11.6618 14.7818 11.5498 14.9418 11.3924 15.0618C11.2351 15.1818 11.0298 15.2418 10.7764 15.2418C10.4911 15.2418 10.2484 15.1472 10.0484 14.9578C9.8511 14.7685 9.75244 14.5192 9.75244 14.2098C9.75244 13.9165 9.84044 13.6738 10.0164 13.4818C10.1951 13.2898 10.4431 13.1938 10.7604 13.1938ZM10.7524 13.6298C10.6538 13.6298 10.5738 13.6605 10.5124 13.7218C10.4511 13.7805 10.4151 13.8538 10.4044 13.9418H11.1004C11.0898 13.8512 11.0524 13.7765 10.9884 13.7178C10.9271 13.6592 10.8484 13.6298 10.7524 13.6298ZM12.107 15.1738V12.2938H12.783V15.1738H12.107Z"
              fill="white"/>
        </svg>
        <span>{{ trans('monitoring.table.export_excel') }}</span>
      </a>
      <b-form-checkbox
          class="table-page__links-item table-page__links-item_result_export"
          v-if="this.params.links.calc && params.links.calc.export"
          v-model="calcExport"
          name="calc-export"
      >
        {{ trans('monitoring.table.calc_result_export') }}
      </b-form-checkbox>
      <a v-if="params.links.calc" class="table-page__links-item table-page__links-item_excel"
         @click.prevent="runJob(params.links.calc.link)" href="#">
        <i class="fas fa-calculator"></i>
        <span>{{ trans('monitoring.table.calc_result') }}</span>
      </a>
      <a v-if="params.links.date" class="table-page__links-item table-page__links-item_date"
         @click.prevent="() => {return  false;}" href="#">
        <i class="far fa-calendar-alt"></i>
        <div class="datetime-picker">
          <datetime
              type="date"
              v-model="selectedDate"
              input-class="form-control date"
              value-zone="Asia/Almaty"
              zone="Asia/Almaty"
              :format="{ year: 'numeric', month: 'long', day: 'numeric' }"
              :phrases="{ok: trans('app.choose'), cancel: trans('app.cancel')}"
              :week-start="1"
              @input="loadData"
              auto
          >
          </datetime>
        </div>
      </a>
      <a class="table-page__links-item table-page__links-item_add" @click.prevent="resetFilters" href="#"
         v-if="activeFilters">
        {{ trans('monitoring.table.reset_filter') }}
      </a>
    </div>
    <h1 style="color:#fff">{{ params.title }}</h1>

    <div class="alert alert-success" v-if="params.success">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <p>{{ params.success }}</p>
    </div>
    <b-alert v-for="(alert, index) in alerts" :key="index" :variant="alert.variant" show dismissible>
      {{ alert.message }}
    </b-alert>
    <div class="table-page__wrapper">
      <table class="table table-bordered table-dark" :class="tableClass">
        <thead>
        <tr v-if="params.table_header">
          <th v-for="(colspan, header) in params.table_header" :colspan="colspan">{{ header }}</th>
          <th rowspan="2">{{ trans('monitoring.table.management') }}</th>
        </tr>
        <tr>
          <th v-for="(field, code) in params.fields" :class="{'selected': filters[code] && filters[code].show}">
            {{
              field.title
            }}
          </th>
          <th v-if="!params.table_header">{{ trans('monitoring.table.management') }}</th>
        </tr>
        <tr v-if="omgca && omgca.data" class="table-sort">
          <th
              v-for="(field, code) in params.fields"
              class="sort"
              :class="{
                            'selected': filters[code] && filters[code].show,
                            'active': isFilterActive(code)
                        }"
          >
            <i
                @click="showFilter(code)"
                class="fa fa-filter"
                aria-hidden="true"
                v-if="!params.hide_filter"
            ></i>
            <div class="filter-wrap" v-if="filters[code] && filters[code].show">
              <template v-if="params.fields[code].type === 'select'">
                <div class="filter-item">
                  <v-select
                      v-model="filters[code].value"
                      @input="loadData()"
                      :options="params.fields[code].filter.values"
                      :reduce="option => option.id"
                      label="name"
                      :placeholder="`Выберите ${params.fields[code].title}`"
                  >
                  </v-select>
                </div>
              </template>
              <template v-else-if="params.fields[code].type === 'date'">
                <div class="filter-item filter-item_datepicker">
                  <input
                      class="filter-input"
                      type="text"
                      @click="calendarFromShow = !calendarFromShow"
                      :value="formatDate(filters[code].value.from)"
                      readonly
                  >
                  <date-picker
                      v-if="calendarFromShow"
                      is-expanded
                      :first-day-of-week="2"
                      :locale="{id: 'ru', masks: { weekdays: 'WW' }}"
                      :max-date="new Date()"
                      v-model="filters[code].value.from"
                      @dayclick="calendarFromShow = false"
                  >
                  </date-picker>
                </div>
                <div class="filter-item filter-item_datepicker">
                  <input
                      class="filter-input"
                      type="text"
                      @click="calendarToShow = !calendarToShow"
                      :value="formatDate(filters[code].value.to)"
                      readonly
                  >
                  <date-picker
                      v-if="calendarToShow"
                      is-expanded
                      :first-day-of-week="2"
                      :locale="{id: 'ru', masks: { weekdays: 'WW' }}"
                      :max-date="new Date()"
                      v-model="filters[code].value.to"
                      @dayclick="calendarToShow = false"
                  >
                  </date-picker>
                </div>
                <button class="filter-apply" @click="loadData()">OK</button>
              </template>
              <template v-else>
                <div class="filter-item filter-item_input">
                  <input
                      class="filter-input"
                      type="text"
                      v-model="filters[code].value"
                      @keyup.enter="loadData"
                  >
                  <button class="filter-apply" @click="loadData()">OK</button>
                </div>
              </template>
            </div>
            <span
                v-if="isShowSort(code)"
                class="arrows"
                :class="{
                            'asc': sort.by === code && sort.desc === false,
                            'desc': sort.by === code && sort.desc === true,
                        }"
                @click="sortBy(code)">
                        </span>
          </th>
          <th></th>
        </tr>
        </thead>
        <tbody v-if="omgca && omgca.data">
        <tr v-for="row in omgca.data">
          <td v-for="(field, code) in params.fields">
            {{ row.fields[code] }}
          </td>
          <td class="row__links">
            <div class="links">
              <a v-if="row.links.edit" class="links__item links__item_edit" :href="row.links.edit"></a>
              <a v-if="row.links.show" class="links__item links__item_view" :href="row.links.show"></a>
              <a v-if="row.links.history" class="links__item links__item_history" :href="row.links.history"></a>
              <a v-if="row.links.delete" href="#" class="links__item links__item_delete"
                 @click.prevent="deleteItem(row)"></a>
            </div>
          </td>
        </tr>
        </tbody>
        <tbody v-else>
        <tr>
          <td :colspan="params.fields.length + 1" class="text-center">Loading</td>
        </tr>
        </tbody>
      </table>
    </div>
    <pagination :limit="3" v-if="omgca" :data="omgca" @pagination-change-page="changePage"></pagination>
  </div>
</template>

<script>
import Vue from "vue";
import moment from "moment"
import vSelect from 'vue-select'
import CatLoader from '../ui-kit/CatLoader'
import 'vue-select/dist/vue-select.css'
import {Datetime} from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'
Vue.use(Datetime)

export default {
  name: "view-table",
  components: {
    vSelect,
    CatLoader,
  },
  props: {
    params: {
      type: Object,
      required: true
    },
    isResponsive: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      omgca: null,
      sort: {
        by: null,
        desc: false
      },
      loading: false,
      currentPage: 1,
      filters: {},
      calendarFromShow: false,
      calendarToShow: false,
      filterOpened: false,
      isSelectDate: false,
      selectedDate: null,
      alerts: [],
      calcExport: true,
    }
  },
  mounted() {
    this.initFilters()
    this.loadData()
  },
  computed: {
    activeFilters() {
      let activeFilter = false
      Object.entries(this.filters).forEach(([code, filter]) => {
        if (!filter.value) return
        if (typeof filter.value == 'object' && !filter.value.from && !filter.value.to) return

        activeFilter = true

      })
      return activeFilter
    },
    tableClass() {
      return {
        "table-responsive": this.isResponsive,
        'with-pagination': this.omgca && this.omgca.total > this.omgca.per_page
      }
    }
  },
  methods: {
    showFilter(code) {
      this.filters[code].show = true
      this.filterOpened = true
    },
    isShowSort(code){
      return typeof this.params.fields[code].sortable == 'undefined'
          || (typeof this.params.fields[code].sortable != 'undefined' && this.params.fields[code].sortable);
    },
    hideFilters() {
      this.filterOpened = false
      Object.entries(this.filters).forEach(([code, filter]) => {
        filter.show = false
      })
    },
    isFilterActive(code) {
      if (this.params.fields[code].type === 'date') {
        return !!this.filters[code].value.from || !!this.filters[code].value.to
      } else {
        return !!this.filters[code].value
      }
    },
    formatDate(date) {
      if (!date) return null
      return moment.parseZone(date).format('YYYY-MM-DD')
    },
    prepareQueryParams() {
      let queryParams = {
        page: this.currentPage
      }
      if (this.sort.by) {
        queryParams.order_by = this.sort.by
        queryParams.order_desc = Number(!!this.sort.desc)
      }

      if (!this.params.hide_filter && this.filters) {
        Object.entries(this.filters).forEach(([code, filter]) => {
          if (!filter.value) return
          if (typeof filter.value == 'object' && !filter.value.from && !filter.value.to) return

          queryParams['filter[' + code + ']'] = filter.value

        })
      }

      if (this.filters.date && this.filters.date.value) {
        this.filters.date.value.to = this.formatDate(this.filters.date.value.to);
        this.filters.date.value.from = this.formatDate(this.filters.date.value.from);
      }

      if (this.params.links.date && this.selectedDate) {
        queryParams.date = this.formatDate(this.selectedDate);
      }

      if (this.params.links.calc && this.params.links.calc.export) {
        queryParams.calc_export = this.calcExport;
      }

      return queryParams
    },
    changePage(page = 1) {
      this.currentPage = page
      this.loadData()
    },
    loadData: _.debounce(function (e) {
      this.hideFilters()

      this.loading = true

      this.axios.get(this.params.links.list, {params: this.prepareQueryParams()}).then(response => {
        this.omgca = response.data;
        this.alerts = response.data.alerts;
      }).catch(e => {

      }).finally(() => {
        this.loading = false
        window.scrollTo({
          top: 0,
          behavior: 'smooth'
        });
      });
    }, 500),
    sortBy(field) {
      if (this.sort.by === field) {
        this.sort.desc = !this.sort.desc
      } else {
        this.sort.by = field
        this.sort.desc = false
      }
      this.loadData()
    },
    deleteItem(item) {
      if (window.confirm('Вы действительно хотите удалить запись?')) {
        this.axios.delete(item.links.delete).then(response => {
          this.loadData()
          this.params.success = this.trans('app.deleted')
        })
      }
    },
    runJob(url) {
      this.loading = true
      this.axios.get(url, {params: this.prepareQueryParams()}).then((response) => {
        let interval = setInterval(() => {
          this.axios.get('/ru/jobs/status', {params: {id: response.data.id}}).then((response) => {
            if (response.data.job.status === 'finished') {
              this.loading = false
              clearInterval(interval)

              if (response.data.job.output) {
                if (response.data.job.output.filename) {
                  document.location.href = response.data.job.output.filename
                }

                if (response.data.job.output.error) {
                  this.showToast(response.data.job.output.error, this.trans('app.error'),'danger');
                }
              }

              if (this.params.links.calc) {
                this.loadData();
              }

            } else if (response.data.job.status === 'failed') {
              this.loading = false
              clearInterval(interval)
              alert(this.trans('monitoring.table.export_error'))
            }
          })
        }, 2000)

      });
    },
    resetFilters() {
      this.initFilters()
      this.loadData()
    },
    initFilters() {
      if (this.params) {
        Object.entries(this.params.fields).forEach(([code, field]) => {
          let filter = {
            show: false,
            value: field.type === 'date' ? {from: null, to: null} : null
          }
          Vue.set(this.filters, code, filter)
        })
      }
    }
  },
};
</script>
<style lang="scss">


/* width */
table::-webkit-scrollbar {
  width: 13px;
}

/* Track */
table::-webkit-scrollbar-track {
  background: #333975;
}

/* Handle */
table::-webkit-scrollbar-thumb {
  background: #656A8A;

}

/* Handle on hover */
table::-webkit-scrollbar-thumb:hover {
  background: #656A8A;

}

table::-webkit-scrollbar-corner {
  background: #333975;
}

.table-page {
  background: #272953;
  padding: 16px 24px 20px 19px;

  &__wrapper {
    min-height: 400px;
    overflow-x: auto;
    position: relative;
    max-width: calc(100vw - 137px);
  }

  h1 {
    font-weight: bold;
    font-size: 22px;
    line-height: 26px;
    margin-bottom: 19px;
  }

  &__links {
    display: flex;

    &-item {
      align-items: center;
      background: #656A8A;
      border-radius: 6px;
      color: #fff;
      display: flex;
      font-weight: bold;
      justify-content: center;
      height: 30px;
      margin-left: 8px;
      padding: 0 7px;

      &:hover {
        color: #fff;
        text-decoration: none;
      }

      &_excel {
        padding: 0 17px 0 20px;

        span {
          margin-left: 9px;
        }
      }

      &_date {
        padding: 0 17px 0 20px;

        i {
          margin-right: 9px;
          font-size: 18px;
        }

        input.vdatetime-input {
          max-height: 20px;
        }
      }

      &_result_export {
        &.custom-control.custom-checkbox {
          line-height: 30px;
          background: none;
        }

        .custom-control-label::before {
          top: 7px;
          left: -30px;
        }

        .custom-control-label::after {
          top: 7px;
          left: -30px;
        }
      }
    }
  }

  .alert {
    p {
      margin: 0;
    }
  }

  .filter {
    &-bg {
      background: rgba(0, 0, 0, 0.5);
      position: absolute;
      left: 0;
      top: 0;
      right: 0;
      bottom: 0;
      z-index: 10;
    }

    &-wrap {
      background: #333975;
      border: 0.4px solid #2E50E9;
      border-radius: 5px;
      display: flex;
      padding: 10px;
      position: absolute;
      left: 0;
      top: 36px;
      z-index: 1000;


    }

    &-item {
      margin-left: 20px;
      position: relative;

      &:before {
        background: rgba(196, 222, 242, 0.4);
        content: "";
        height: 36px;
        left: -10px;
        position: absolute;
        top: 2px;
        width: 1px;
      }

      &:first-child {
        margin-left: 0;

        &:before {
          display: none;
        }
      }

      &_datepicker {
        .vc-container {
          background: #40467E;
          border: 0.4px solid #2E50E9;
          padding-top: 17px;
          position: absolute;
        }

        .vc-header {
          padding-bottom: 14px;
        }

        .vc-title {
          color: #fff;
          font-size: 15px;
          font-weight: normal;
          text-transform: capitalize;
        }

        .vc-weekday {
          background: rgba(51, 57, 117, 0.501961);
          margin-bottom: 15px;
          padding: 8px 0;
        }

        .vc-arrows-container {
          padding: 0 30px;
        }

        .vc-day-content {
          color: #fff;
          font-size: 12px;
          opacity: 0.8;

          &.vc-focusable {
            opacity: 1;
          }
        }
      }

      &_input {
        .filter-apply {
          position: absolute;
          right: 4px;
        }
      }
    }

    &-input {
      background: #41488B;
      border: none;
      border-radius: 5px;
      color: #fff;
      height: 40px;
      font-size: 16px;
      font-weight: bold;
      outline: none;
      padding: 0 16px;
      width: 314px;
    }

    &-apply {
      background: rgba(123, 132, 173, 0.64);
      border: none;
      border-radius: 4px;
      color: #fff;
      font-size: 16px;
      font-weight: 600;
      height: 32px;
      margin-left: 10px;
      outline: none;
      position: relative;
      top: 4px;
      width: 56px;
    }
  }

  .table {
    border: 1px solid #454D7D;
    color: white !important;
    margin-bottom: 28px;

    &.table-responsive {
      overflow: scroll;
      height: calc(100vh - 205px);

      &.with-pagination {
        height: calc(100vh - 258px);
      }
    }

    th {
      background: #333975;
      border: 1px solid #454D7D;
      font-weight: bold;
      font-size: 12px;
      min-width: 70px;
      padding: 10px 0;
      text-align: center;

      &.selected {
        position: relative;
        z-index: 100;
      }

      &.active {
        i.fa {
          color: #3366FF;
        }
      }

      &.sort {
        background: #505585;
        font-weight: normal;
        padding: 10px 20px 10px 5px;
        position: relative;
        text-align: right;

        .arrows {
          display: block;
          height: 16px;
          position: absolute;
          right: 2px;
          top: 50%;
          transform: translateY(-50%);
          width: 15px;

          &:before {
            background: url(/img/icons/table_sort_up.svg);
            background-size: cover;
            content: "";
            height: 4px;
            position: absolute;
            top: 0;
            right: 0;
            width: 6px;
          }

          &:after {
            background: url(/img/icons/table_sort_down.svg);
            background-size: cover;
            content: "";
            height: 4px;
            position: absolute;
            bottom: 0;
            right: 0;
            width: 7px;
          }

          &.asc {
            &:before {
              display: none;
            }
          }

          &.desc {
            &:after {
              display: none;
            }
          }
        }
      }

    }

    tbody {
      tr {
        td {
          background: #303560;
          border: none;
          border-left: 1px solid #454D7D;
          border-right: 1px solid #454D7D;
          font-size: 14px;
          padding: 7px 5px;
          text-align: center;
          vertical-align: middle;

          &.row__links {
            padding-left: 20px;
            padding-right: 20px;
            width: 150px;
          }

          .links {
            align-items: center;
            display: flex;
            justify-content: space-between;
            width: 112px;

            &__item {
              display: block;

              &_edit {
                background: url(/img/icons/edit.svg);
                height: 14px;
                width: 14px;
              }

              &_view {
                background: url(/img/icons/view.svg);
                height: 10px;
                width: 21px;
              }

              &_history {
                background: url(/img/icons/history.svg);
                height: 14px;
                width: 17px;
              }

              &_delete {
                background: url(/img/icons/delete.svg);
                height: 14px;
                width: 15px;
              }
            }
          }
        }

        &:nth-child(2n) {
          td {
            background: #272953;
          }
        }
      }
    }
  }

  .loader {
    flex: 0 1 auto;
    flex-flow: row wrap;
    width: 100%;
    align-items: flex-start;
    position: absolute;
    height: 100%;
    justify-content: center;
    display: flex;
    z-index: 5000;
    background: rgba(0, 0, 0, 0.4);
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;

    .v-spinner {
      top: 250px;
    }
  }

  .pagination {
    justify-content: center;

    .page-item {
      .page-link {
        background: none;
        border-color: #40489C;
        color: #636A99;
        padding: 0.8rem 1.35rem;
      }

      &.active {
        .page-link {
          background: #3366FF;
          color: #fff;
        }
      }
    }
  }

}
</style>
