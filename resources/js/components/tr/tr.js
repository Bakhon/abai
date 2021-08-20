import Vue from 'vue';
import NotifyPlugin from "vue-easy-notify";
import "vue-easy-notify/dist/vue-easy-notify.css";
import TrTable from "./table";
import TrFullTable from "./tablefull";
import SearchFormRefresh from "@ui-kit/SearchFormRefresh.vue";
import {fields} from "./constants.js";
import TrMultiselect from "./TrMultiselect.vue";
import CatLoader from "@ui-kit/CatLoader";
import Multiselect from 'vue-multiselect';

import Paginate from 'vuejs-paginate';
import moment from 'moment';

Vue.component('paginate', Paginate);

Vue.use(NotifyPlugin);
export default {
  name: "TrPage",
  props: [
    'params'
  ],
  components: {
    CatLoader,
    TrTable,
    TrFullTable,
    SearchFormRefresh,
    TrMultiselect,
    Multiselect,
  },
  computed: {
    selectHorizon: {
      get(){
        return this.$store.state.tr.horizon;
      }, 
      set(newVal){
        this.$store.commit("tr/SET_HORIZON", newVal);
      }, 
    },
    selectObject: {
      get(){
        return this.$store.state.tr.object;
      }, 
      set(newVal){
        this.$store.commit("tr/SET_OBJECT", newVal);
      }, 
    },
    selectField: {
      get(){
        return this.$store.state.tr.field;
      }, 
      set(newVal){
        this.$store.commit("tr/SET_FIELD", newVal);
      }, 
    },
    selectExpMeth: {
      get(){
        return this.$store.state.tr.expMeth;
      }, 
      set(newVal){
        this.$store.commit("tr/SET_EXPMETH", newVal);
      }, 
    },
    selectWellType: {
      get(){
        return this.$store.state.tr.wellType;
      }, 
      set(newVal){
        this.$store.commit("tr/SET_WELLTYPE", newVal);
      }, 
    },
    selectWellName: {
      get(){
        return this.$store.state.tr.wellName;
      }, 
      set(newVal){
        this.$store.commit("tr/SET_WELLNAME", newVal);
      }, 
    },
    selectBlock: {
      get(){
        return this.$store.state.tr.block;
      }, 
      set(newVal){
        this.$store.commit("tr/SET_BLOCK", newVal);
      }, 
    },
    addWellData() {
      try {
        let filteredResult = this.allWells.filter(
          (row) =>
            (!this.fieldFilter || this.fieldFilter.indexOf(row.field) !== -1) &&
            (!this.wellStatusFilter || this.wellStatusFilter.indexOf(row.well_status_last_day) !== -1) &&
            (!this.statusFilter || this.statusFilter.indexOf(row.is_saved) !== -1) &&
            (!this.typeWellFilter || this.typeWellFilter.indexOf(row.type_text) !== -1) &&
            (!this.wellFilter || this.wellFilter.indexOf(row.rus_wellname) !== -1)
        );
        this.filteredWellData = filteredResult;
      } catch (err) {
        console.error(err);
        return false;
      }
      if (this.filteredWellData.length < 6) {
        this.lonelywell = this.filteredWellData;
      }
      else {
        this.lonelywell = [];
      }
      this.render++;
    },
    fieldFilters() {
      let filters = [];
      this.allWells.forEach((el) => {
        // const el_horizon = this.getStringOrFirstItem(el, "horizon");
        // const el_exp_meth = this.getStringOrFirstItem(el, "exp_meth");
        if (
          filters.indexOf(el.field) === -1 &&
          (!this.wellStatusFilter ||
            this.wellStatusFilter.length === 0 ||
            this.wellStatusFilter.indexOf(el.well_status_last_day) !== -1) &&
          (!this.statusFilter ||
            this.statusFilter.length === 0 ||
            this.statusFilter.indexOf(el.is_saved) !== -1) &&
          (!this.typeWellFilter ||
            this.typeWellFilter.length === 0 ||
            this.typeWellFilter.indexOf(el.type_text) !== -1) &&
          (!this.wellFilter ||
            this.wellFilter.length === 0 ||
            this.wellFilter.indexOf(el.rus_wellname) !== -1)
        ) {
          filters = [...filters, el.field];
        }
      });
      return [undefined, ...filters];
  },  
      wellStatusFilters() {
        let filters = [];
        this.allWells.forEach((el) => {
          if (
            filters.indexOf(el.well_status_last_day) === -1 &&
            (!this.fieldFilter ||
              this.fieldFilter.length === 0 ||
              this.fieldFilter.indexOf(el.field) !== -1) &&
            (!this.statusFilter ||
              this.statusFilter.length === 0 ||
              this.statusFilter.indexOf(el.is_saved) !== -1) &&
            (!this.typeWellFilter ||
              this.typeWellFilter.length === 0 ||
              this.typeWellFilter.indexOf(el.type_text) !== -1) &&
            (!this.wellFilter ||
              this.wellFilter.length === 0 ||
              this.wellFilter.indexOf(el.rus_wellname) !== -1)
          ) {
            filters = [...filters, el.well_status_last_day];
          }
        });
        return [undefined, ...filters];
    },  
    statusFilters() {
      let filters = [];
      this.allWells.forEach((el) => {
        if (
          filters.indexOf(el.is_saved) === -1 &&
          (!this.fieldFilter ||
            this.fieldFilter.length === 0 ||
            this.fieldFilter.indexOf(el.field) !== -1) &&
          (!this.wellStatusFilter ||
            this.wellStatusFilter.length === 0 ||
            this.wellStatusFilter.indexOf(el.well_status_last_day) !== -1) &&
          (!this.typeWellFilter ||
            this.typeWellFilter.length === 0 ||
            this.typeWellFilter.indexOf(el.type_text) !== -1) &&
          (!this.wellFilter ||
            this.wellFilter.length === 0 ||
            this.wellFilter.indexOf(el.rus_wellname) !== -1)
        ) {
          filters = [...filters, el.is_saved];
        }
      });
      return [...filters];
  },  
      typeWellFilters() {
        let filters = [];
        this.allWells.forEach((el) => {
          if (
            filters.indexOf(el.type_text) === -1 &&
            (!this.fieldFilter ||
              this.fieldFilter.length === 0 ||
              this.fieldFilter.indexOf(el.field) !== -1) &&
            (!this.wellStatusFilter ||
              this.wellStatusFilter.length === 0 ||
              this.wellStatusFilter.indexOf(el.well_status_last_day) !== -1) &&
            (!this.statusFilter ||
              this.statusFilter.length === 0 ||
              this.statusFilter.indexOf(el.is_saved) !== -1) &&
            (!this.wellFilter ||
              this.wellFilter.length === 0 ||
              this.wellFilter.indexOf(el.rus_wellname) !== -1)
          ) {
            filters = [...filters, el.type_text];
          }
        });
        return [undefined, ...filters];
    },   
    wellFilters() {
        let filters = [];
        this.allWells.forEach((el) => {
          if (
            filters.indexOf(el.rus_wellname) === -1 &&
            (!this.fieldFilter ||
              this.fieldFilter.length === 0 ||
              this.fieldFilter.indexOf(el.field) !== -1) &&
            (!this.wellStatusFilter ||
              this.wellStatusFilter.length === 0 ||
              this.wellStatusFilter.indexOf(el.well_status_last_day) !== -1) &&
            (!this.statusFilter ||
              this.statusFilter.length === 0 ||
              this.statusFilter.indexOf(el.is_saved) !== -1) &&
            (!this.typeWellFilter ||
              this.typeWellFilter.length === 0 ||
              this.typeWellFilter.indexOf(el.type_text) !== -1)
          ) {
            filters = [...filters, el.rus_wellname];
          }
        });
        return [undefined, ...filters];
    },          
  },
  beforeCreate: function () {},
  created() {
    this.loadPage();
  },
  data: function () {
    return {
      wells: [],
      searchString: "",
      isSearched: false,
      sortParam: "",
      isSortType: true,
      filter: [...fields],
      fieldFilterOptions: [
          {
              group: this.trans('tr.all_wells'),
              fields: [...fields],
          },
      ],
      dt: null,
      editedWells: [],
      isShowFirst: true,
      isShowSecond: false,
      isShowAdd: false,
      isEdit: false,
      editdtm: null,
      editdty: null,
      year: null,
      selectYear: null,
      month: null,
      isFullTable: false,
      fieldFilter: undefined,
      allWells: [],
      wellStatusFilter: undefined,
      statusFilter: "Не сохранено",
      typeWellFilter: undefined,
      filteredWellData: [],
      lonelywell: [],
      render: 0,
      searchStringModel: "",
      wellFilter: undefined,
      isDeleted: false,
      isSaved: false,
      isDateNormal: true,
      isDateDynamic: false,
      isDateFix: true,
      isDynamic: false,
      permissionName: 'tr edit',
      isPermission: false,
      filter_column: [],
      horizonFilterData: [],
      objectFilterData: [],
      fieldFilterData: [],
      wellTypeFilterData: [],
      blockFilterData: [],
      expMethFilterData: [],
      wellNameFilterData: [],
      perPage: 3,
      currentPage: 1,
      isAscSort: "",
      pageCount: 0,
      pageNumber: 1,
      currentMonth: null,
      currentYear: null,
      searchParam: null,
      postApiUrl: process.env.MIX_POST_API_URL,
      pageNumberLink: "techregime_page_numbers/",
      editPageNumberLink: "techregime_edit_page_numbers/",
      searchLink: "techregime_totals_test_3/",
      editSearchLink: "techregime_edit_page/",
      isMaxDate: true,
      isActiveHorizonFilterr: false,
    };
  },
  methods: {
    loadPage() {
        this.$store.commit("globalloading/SET_LOADING", true);
        this.$store.commit("tr/SET_VERSION", false);
        this.$store.commit("tr/SET_SORTPARAM", "rus_wellname");
        this.$store.commit("tr/SET_SEARCH", this.searchString);
        this.$store.commit("tr/SET_PAGENUMBER", 1);
        this.$store.commit("tr/SET_SORTTYPE", true);
        var today = new Date();
        var mm = today.getMonth() + 1;
        var yyyy = today.getFullYear();
        var day = today.getDate();
        if (day > 25 && mm < 12) {
            var month = today.getMonth() + 2;
            var year = today.getFullYear();
        } else if (day > 25 && mm === 12) {
            var month = 1;
            var year = today.getFullYear() + 1;
        } else {
            var month = today.getMonth() + 1;
            var year = today.getFullYear();
        }
        this.$store.commit("tr/SET_MONTH", month);
        this.$store.commit("tr/SET_YEAR", year);
        this.isDynamic = false;
        this.$store.commit("tr/SET_IS_DYNAMIC", "false");
        this.$store.commit("tr/SET_FIELD", []);
        this.$store.commit("tr/SET_OBJECT", []);
        this.$store.commit("tr/SET_HORIZON", []);
        this.$store.commit("tr/SET_WELLTYPE", []);
        this.$store.commit("tr/SET_BLOCK", []);
        this.$store.commit("tr/SET_EXPMETH", []);
        this.$store.commit("tr/SET_WELLNAME", []);
        this.axios
            .post(
                this.postApiUrl + this.searchLink,
                this.getPageData(),
            )
            .then((response) => {
                let data = response.data;
                this.year = yyyy;
                this.selectYear = yyyy;
                this.month = mm;
                this.currentMonth = mm;
                this.currentYear = yyyy;
                this.$store.commit("globalloading/SET_LOADING", false);
                if (response.data) {
                    this.wells = data.data;
                } else {
                    console.log("No data");
                    this.wells = data.data;
                }
                if (month < 10) {
                    this.dt = "01" + ".0" + month + "." + year;
                } else {
                    this.dt = "01" + "." + month + "." + year;
                }
                this.isPermission = this.params.includes(this.permissionName);
            });
        this.axios
            .get(
                this.postApiUrl + "techregime/tr_parameter_filters/"
            )
            .then((response) => {
                let data = response.data;
                if (data) {
                    this.filter_column = data;
                    this.horizonFilterData = data.horizon;
                    this.objectFilterData = data.object;
                    this.fieldFilterData = data.field;
                    this.wellTypeFilterData = data.well_type;
                    this.blockFilterData = data.block;
                    this.expMethFilterData = data.exp_meth;
                    this.wellNameFilterData = data.rus_wellname;
                } else {
                    console.log("No data");
                }
            });
        this.axiosPage(this.pageNumberLink);
    },
    getPageData() {
        if (this.isDynamic) {
            return {
                field: this.$store.state.tr.field,
                is_dynamic: this.$store.state.tr.isDynamic,
                object: this.$store.state.tr.object,
                searchString: this.$store.state.tr.searchString,
                sortType: this.$store.state.tr.isSortType,
                sortParam: this.$store.state.tr.sortParam,
                wellType: this.$store.state.tr.wellType,
                pageNum: this.$store.state.tr.pageNumber,
                block: this.$store.state.tr.block,
                expMeth: this.$store.state.tr.expMeth,
                horizon: this.$store.state.tr.horizon,
                year_1: this.$store.state.tr.year_dyn_start,
                month_1: this.$store.state.tr.month_dyn_start,
                day_1: this.$store.state.tr.day_dyn_start,
                year_2: this.$store.state.tr.year_dyn_end,
                month_2: this.$store.state.tr.month_dyn_end,
                day_2: this.$store.state.tr.day_dyn_end,
                wellName: this.$store.state.tr.wellName,
            };
        } else {
            return {
                month: this.$store.state.tr.month,
                year: this.$store.state.tr.year,
                sortType: this.$store.state.tr.isSortType,
                sortParam: this.$store.state.tr.sortParam,
                field: this.$store.state.tr.field,
                horizon: this.$store.state.tr.horizon,
                wellType: this.$store.state.tr.wellType,
                object: this.$store.state.tr.object,
                block: this.$store.state.tr.block,
                expMeth: this.$store.state.tr.expMeth,
                searchString: this.$store.state.tr.searchString,
                is_dynamic: this.$store.state.tr.isDynamic,
                pageNum: this.$store.state.tr.pageNumber,
                wellName: this.$store.state.tr.wellName,
            }
        };
    },
    clickCallback(pageNum) {
        this.$store.commit("globalloading/SET_LOADING", true);
        this.$store.commit("tr/SET_PAGENUMBER", pageNum);
        this.chooseAxios();
    },
    dropAllFilters() {
      this.$store.commit("globalloading/SET_LOADING", true),
      this.$store.commit("tr/SET_FIELD", []);
      this.$store.commit("tr/SET_OBJECT", []);
      this.$store.commit("tr/SET_HORIZON", []);
      this.$store.commit("tr/SET_WELLTYPE", []);
      this.$store.commit("tr/SET_BLOCK", []);
      this.$store.commit("tr/SET_EXPMETH", []);
      this.$store.commit("tr/SET_WELLNAME", []);
      this.$store.commit("tr/SET_PAGENUMBER", 1);
      this.pageNumber = 1;
      this.isNoActiveHorizonFilter();
      this.chooseAxios();
    },
    dropFilter(x) {
        this.$store.commit("globalloading/SET_LOADING", true),
            console.log(x);
        if (x === 'tr/SET_HORIZON') {
            this.$store.commit(x, []);
        } else if (x === 'tr/SET_FIELD') {
            this.$store.commit(x, []);
        } else if (x === 'tr/SET_OBJECT') {
            this.$store.commit(x, []);
        } else if (x === 'tr/SET_BLOCK') {
            this.$store.commit(x, []);
        } else if (x === 'tr/SET_EXPMETH') {
            this.$store.commit(x, []);
        } else if (x === 'tr/SET_WELLTYPE') {
            this.$store.commit(x, []);
        } else {
            this.$store.commit("tr/SET_WELLNAME", []);
        };
        this.$store.commit("tr/SET_PAGENUMBER", 1);
        this.pageNumber = 1;
        this.isNoActiveHorizonFilter();
        this.chooseAxios();
    },
    chooseFilter() {
        this.$store.commit("globalloading/SET_LOADING", true),
        this.$store.commit("tr/SET_SORTPARAM", this.sortParam);
        this.$store.commit("tr/SET_SEARCH", this.searchString);
        this.$store.commit("tr/SET_SORTPARAM", "rus_wellname");
        this.$store.commit("tr/SET_PAGENUMBER", 1);
        this.isActiveHorizonFilter();
        this.chooseAxios();
    },
    chooseAxios() {
        if (this.isDynamic) {
            this.axiosDynamicFilterRequest();
        } else if (this.isEdit) {
            this.axiosEdit();
        } else {
            this.axiosFilterRequest();
        }
    },
    // Режим редактирования
    axiosEdit() {
        this.axios
            .post(
                this.postApiUrl + this.editSearchLink,
                this.getPageData(),
            )
            .then((response) => {
                let data = response.data;
                this.$store.commit("globalloading/SET_LOADING", false);
                if (response.data) {
                    this.wells = data.data;
                } else {
                    console.log("No data");
                }
            });
        // Пагинация редактирования
        this.axiosPage(this.editPageNumberLink);
    },
    // Режим динамического формирования
    axiosDynamicFilterRequest() {
        this.axios
            .post(
                this.postApiUrl + "techregime_dynamic_totals/",
                this.getPageData(),
            )
            .then((response) => {
                let data = response.data;
                this.$store.commit("globalloading/SET_LOADING", false);
                if (response.data) {
                    this.wells = data.data;
                } else {
                    console.log("No data");
                }
            });
        // Пагинация таблицы
        this.axiosPage(this.pageNumberLink);
    },
    // Пагинация таблицы
    axiosPage(link) {
        this.axios
            .post(
                this.postApiUrl + link,
                this.getPageData(),
            )
            .then((response) => {
                let data = response.data;
                if (response.data) {
                    this.pageCount = data;
                } else {
                    console.log("No data");
                }
            });
    },
    // Режим месячного формирования
    axiosFilterRequest() {
        this.axios
            .post(
                this.postApiUrl + this.searchLink,
                this.getPageData(),
            )
            .then((response) => {
                let data = response.data;
                this.$store.commit("globalloading/SET_LOADING", false);
                if (response.data) {
                    this.wells = data.data;
                } else {
                    console.log("No data");
                }
            });
        this.axiosPage(this.pageNumberLink);
    },
    editrow(row, rowId) {
        this.$store.commit("globalloading/SET_LOADING", false);
        console.log("row = ", row);
        console.log("rowId = ", rowId);
        row["index"] = 0;
        this.axios
            .post(
                this.postApiUrl + "techregime/edit/" +
                this.year +
                "/" +
                this.month +
                "/",
                {
                    row: row,
                }
            )
            .then((response) => {
                if (response.data) {
                    this.wells = [
                        ...this.wells.slice(0, rowId),
                        response.data.data[0],
                        ...this.wells.slice(rowId + 1),
                    ];
                    this.editedWells = this.editedWells.filter(
                        (item) => item.well !== response.data.data[0].well
                    );
                    this.editedWells = [...this.editedWells, response.data.data[0]];
                } else {
                    console.log("No data");
                }
            });
    },
    savetable() {
        this.isEdit = true;
        this.$store.commit("globalloading/SET_LOADING", true);
        const searchParam = this.searchString ? `${this.searchString}/` : "";
        this.axios
            .post(
                this.postApiUrl + "techregime_save_page/",
                {
                    well: this.editedWells,
                }
            )
            .then((response) => {
                this.editedWells = [];
                this.$store.commit("globalloading/SET_LOADING", false);
                this.isSearched = searchParam ? true : false;
                this.month = this.currentMonth;
                this.selectYear = this.currentYear;
                this.isShowFirst = false;
                this.isShowSecond = true;
                this.$store.commit("tr/SET_MONTH", this.currentMonth);
                this.$store.commit("tr/SET_YEAR", this.currentYear);
                this.chooseDate();
            })
            .catch((error) => {
                console.log(error.data);
                this.editedWells = [];
                this.searchWell();
                this.isSearched = searchParam ? true : false;
            });
    },
    cancelEdit() {
        this.isEdit = false;
        this.editedWells = [];
        this.isShowFirst = false;
        this.isShowSecond = true;
        this.loadPage();
    },
    reRender() {
        this.filteredWellData = [];
        this.lonelywell = [];
        this.isShowAdd = false;
        this.isDeleted = false;
        this.isSaved = false;
        this.wellStatusFilter = undefined;
        this.statusFilter = undefined;
        this.typeWellFilter = undefined;
        this.wellFilter = undefined;
        this.fieldFilter = undefined;
    },
    onChangePage(newVal) {
        this.$store.commit("globalloading/SET_LOADING", true);
        this.$store.commit("tr/SET_PAGENUMBER", parseInt(newVal));
        this.chooseAxios();
    },
    showWells() {
      if(this.lonelywell[0].is_saved === "Сохранено"){
        this.isShowAdd = !this.isShowAdd;
        this.isDeleted = false;
        this.isSaved = true;
      }
      else if(this.lonelywell[0].is_saved === "Не сохранено"){
        this.isShowAdd = !this.isShowAdd;
        this.isDeleted = true;
        this.isSaved = false;
      }
      else{
        this.isShowAdd = this.isShowAdd;
      }
    },
    editable() {
        this.$store.commit("globalloading/SET_LOADING", true);
        this.isDynamic = false;
        this.isEdit = true;
        this.isShowSecond = true;
        this.isShowFirst = false;
        this.axiosEdit();
    },
    closeModal(modalName) {
      this.$modal.hide(modalName)
    },
    sortBy(type) {
        this.$store.commit("tr/SET_SORTTYPE", this.isSortType);
        this.$store.commit("tr/SET_SORTPARAM", type);
        let {isSortType} = this;
        if (this.isSortType === true) {
            this.isSortType = false;
        } else {
            this.isSortType = true;
        }
        if (this.isDynamic) {
            this.axiosDynamicFilterRequest();
        } else if (this.isEdit) {
            this.axiosEdit();
        } else {
            this.axiosFilterRequest();
        }
    },
    onChangeMonth(event) {
        this.$store.commit("tr/SET_MONTH", event.target.value);
    },
    onChangeYear(event) {
        this.year = event.target.value;
        this.$store.commit("tr/SET_YEAR", event.target.value);
    },
    chooseDynamicDate() {
        const {date1, date2} = this;
        var choosenDt = date1.split("-");
        var choosenSecDt = date2.split("-");
        const dd = choosenDt[2];
        const prdd = choosenSecDt[2];
        const mm = choosenDt[1];
        const prMm = choosenSecDt[1];
        const yyyy = choosenDt[0];
        const pryyyy = choosenSecDt[0];
        this.is_dynamic = true;
        this.isMaxDate = false;
        if (choosenSecDt[2] >= choosenDt[2] && choosenSecDt[1] >= choosenDt[1] && choosenSecDt[0] >= choosenDt[0] || choosenSecDt[0] > choosenDt[0]) {
            this.notification("Дата 2 должна быть меньше чем Дата 1");
            // Vue.prototype.$notifyError("Дата 2 должна быть меньше чем Дата 1");
        } else {
            this.$store.commit("globalloading/SET_LOADING", true);
            this.$store.commit("tr/SET_DYN_MONTH_END", mm);
            this.$store.commit("tr/SET_DYN_YEAR_END", yyyy);
            this.$store.commit("tr/SET_DYN_DAY_END", dd);
            this.$store.commit("tr/SET_DYN_MONTH_START", prMm);
            this.$store.commit("tr/SET_DYN_YEAR_START", pryyyy);
            this.$store.commit("tr/SET_DYN_MONTH_START", prMm);
            this.$store.commit("tr/SET_DYN_DAY_START", prdd);
            this.$store.commit("tr/SET_FIELD", []);
            this.$store.commit("tr/SET_OBJECT", []);
            this.$store.commit("tr/SET_HORIZON", []);
            this.$store.commit("tr/SET_WELLTYPE", []);
            this.$store.commit("tr/SET_BLOCK", []);
            this.$store.commit("tr/SET_EXPMETH", []);
            this.$store.commit("tr/SET_PAGENUMBER", 1);
            this.$store.commit("tr/SET_SEARCH", "");
            this.$store.commit("tr/SET_SORTTYPE", true);
            this.$store.commit("tr/SET_SORTPARAM", "");
            this.$store.commit("tr/SET_IS_DYNAMIC", true);
            this.isDynamic = true;
            this.axiosDynamicFilterRequest();
            this.isSearched = false;
            this.isDateFix = false;
            this.$store.commit("tr/SET_IS_DYNAMIC", "true");
            this.$store.commit("tr/SET_SORTPARAM", "");
            this.$store.commit("tr/SET_SEARCH", "");
            this.sortParam = "";
            this.searchString = "";
            if (this.month < 10) {
                this.dt = '(' + prdd + "." + prMm + "." + pryyyy + ' - ' + dd + "." + mm + "." + yyyy + ')';
            } else {
                this.dt = '(' + prdd + "." + prMm + "." + pryyyy + ' - ' + dd + "." + mm + "." + yyyy + ')';
            }
        }
    },
    chooseDate() {
        this.$store.commit("tr/SET_FIELD", []);
        this.$store.commit("tr/SET_OBJECT", []);
        this.$store.commit("tr/SET_HORIZON", []);
        this.$store.commit("tr/SET_WELLTYPE", []);
        this.$store.commit("tr/SET_BLOCK", []);
        this.$store.commit("tr/SET_EXPMETH", []);
        this.$store.commit("tr/SET_PAGENUMBER", 1);
        this.$store.commit("tr/SET_SORTTYPE", true);
        this.$store.commit("tr/SET_SORTPARAM", "rus_wellname");
        this.$store.commit("tr/SET_IS_DYNAMIC", "false");
        this.isDynamic = false;
        this.$store.commit("globalloading/SET_LOADING", true);
        this.axiosFilterRequest();
        if (this.month < 10) {
            this.dt = "01" + ".0" + this.month + "." + this.selectYear;
        } else {
            this.dt = "01" + "." + this.month + "." + this.selectYear;
        }
        ;
        this.checkMaxDate();
    },
    checkMaxDate() {
        this.isMaxDate = moment().format("01.MM.YYYY") === this.dt ? true : false;
    },
    wellAdd() {
        this.$store.commit("globalloading/SET_LOADING", true);
        this.axios
            .get(
                this.postApiUrl + "techregime/new_wells/"
            )
            .then((response) => {
                this.$store.commit("globalloading/SET_LOADING", false);
                let data = response.data;
                if (data) {
                    this.isSearched = true;
                    this.$store.commit("tr/SET_SORTPARAM", "");
                    this.$store.commit("tr/SET_SEARCH", "");
                    this.sortParam = "";
                    this.searchString = "";
                    this.allWells = data.data;
                } else {
                    console.log("No data");
                }

            });
    },
    swap() {
        this.isShowFirst = !this.isShowFirst;
        this.isShowSecond = !this.isShowSecond;
        this.isFullTable = !this.isFullTable;
        this.$store.commit("tr/SET_VERSION", this.isFullTable);
    },
    calendarDynamic() {
        this.is_dynamic_calendar = !this.is_dynamic_calendar
        this.isDateNormal = !this.isDateNormal
        this.isDateDynamic = !this.isDateDynamic
    },
    isCommentClass(row_index, value) {
        return this.wells &&
            this.wells[row_index] &&
            this.wells[row_index][value][1][0] !== '0';
    },
    isActiveClass(row) {
        if (row.rus_wellname) {
            return false
        } else {
            return true
        }
    },
    isActiveHorizonFilter() {
        if (this.selectHorizon === null) {
            return this.isActiveHorizonFilterr = false;
        } else {
            return this.isActiveHorizonFilterr = true;
        }

    },
    isNoActiveHorizonFilter() {
        if (this.selectHorizon === null) {
            return this.isActiveHorizonFilterr = true;
        } else {
            return this.isActiveHorizonFilterr = false;
        }
    },
    getRowWidthSpan(row) {
        return row.rus_wellname ? 0 : 2;

    },
    getColor(status) {
        if (status === "1") return "#ffff00";
        return "#ff0000";
    },
    closeModal(modalName) {
        this.$modal.hide(modalName)
        this.isShowAdd = false;
        this.isDeleted = false;
        this.isSaved = false;
        this.reRender();
    },
    addpush() {
        this.$modal.show('add_well')
    },

    handlerSearch(search) {
        this.searchString = search;
    },
    handlerFilter(filter) {
        this.filter = filter;
    },
    saveadd() {
        this.notification(`Скважина ${this.lonelywell[0].rus_wellname} сохранена`);
        // Vue.prototype.$notifySuccess(`Скважина ${this.lonelywell[0].rus_wellname} сохранена`);
        let output = {};
        this.$refs.editTable[0].children.forEach((el) => {
            output[el.children[0].dataset.key] = el.children[0].value;
        });
        this.axios
            .post(
                this.postApiUrl + "techregime/new_wells/add_well/",
                output,
            )
            .then((response) => {
                this.wellAdd();
                this.reRender();
                console.log('good')
            })
    },
    // Удаление с модалки
    deleteWell() {
        this.notification(`Скважина ${this.lonelywell[0].rus_wellname} удалена`);
        // Vue.prototype.$notifyError(`Скважина ${this.lonelywell[0].rus_wellname} удалена`);
        this.$store.commit("globalloading/SET_LOADING", true);
        if (this.lonelywell.length === 1 && this.lonelywell[0].is_saved === "Сохранено") {
            this.axios
                .get(
                    this.postApiUrl + "techregime/new_wells/delete_well/" +
                    this.lonelywell[0].well).then((res) => {
                console.log(res.data)
                this.wellAdd();
                this.reRender();
            })
        } else {
            return console.log("error")
        }
    },
    // Поиск по скважине
    searchWell() {
        this.$store.commit("tr/SET_SORTPARAM", "rus_wellname");
        this.$store.commit("globalloading/SET_LOADING", true);
        this.$store.commit("tr/SET_PAGENUMBER", 1);
        this.searchParam = this.searchString
            ? `search/${this.searchString}/`
            : "";
        this.$store.commit("tr/SET_SEARCH", this.searchString);
        if (this.isEdit) {
            this.axiosSearch(this.editSearchLink);
            this.axiosPage(this.editPageNumberLink);
        } else {
            this.axiosSearch(this.searchLink);
            this.axiosPage(this.pageNumberLink);
        }
    },
    notification(val) {
      this.$bvToast.toast(val, {
        title: this.trans('app.error'),
        toaster: "b-toaster-top-center",
        solid: true,
        appendToast: false,
        variant: 'danger',
      });
    },
    // API поиска простого ТР
    axiosSearch(link) {
        this.axios
            .post(
                this.postApiUrl + link,
                this.getPageData(),
            )
            .then((response) => {
                this.$store.commit("globalloading/SET_LOADING", false);
                this.isSearched = this.searchParam ? true : false;
                this.$store.commit("tr/SET_SEARCH", this.searchString);
                let data = response.data;
                if (data) {
                    this.wells = data.data;
                } else {
                    this.wells = [];
                    this.notification(this.trans('tr.no_well_toaster'));
                }
            })
            .catch((error) => {
                this.isSearched = searchParam ? true : false;
                this.$store.commit("globalloading/SET_LOADING", false);
                this.wells = []
                this.notification(this.trans('tr.no_well_toaster'));
            });
    },
  },
};