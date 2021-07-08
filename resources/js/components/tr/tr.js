import Vue from 'vue';
import NotifyPlugin from "vue-easy-notify";
import "vue-easy-notify/dist/vue-easy-notify.css";
import TrTable from "./table";
import TrFullTable from "./tablefull";
import SearchFormRefresh from "../ui-kit/SearchFormRefresh.vue";
import { fields } from "./constants.js";
import TrMultiselect from "./TrMultiselect.vue";

import Paginate from 'vuejs-paginate';
Vue.component('paginate', Paginate);

Vue.use(NotifyPlugin);
export default {
  name: "TrPage",
  props: [
    'params'
  ],
  components: {
    TrTable,
    TrFullTable,
    SearchFormRefresh,
    TrMultiselect,
  },
  computed: {
    addWellData() {
      try {
        let filteredResult = this.allWells.filter(
          (row) =>
            (!this.statusFilter || row.is_saved === this.statusFilter) &&
            (!this.fieldFilter || row.field === this.fieldFilter) &&
            (!this.wellFilter || row.rus_wellname === this.wellFilter) &&
            (!this.typeWellFilter || row.type_text === this.typeWellFilter) &&
            (!this.wellStatusFilter || row.well_status_last_day === this.wellStatusFilter)
        );
        this.filteredWellData = filteredResult;
      } catch (err) {
        console.error(err);
        return false;
      }
      if(this.filteredWellData.length === 1){
        this.lonelywell = this.filteredWellData;
      }
      else return false;
      this.render++;
    },
    fieldFilters() {
        let filters = [];
        this.allWells.forEach((el) => {
          if (
            filters.indexOf(el.field) === -1 &&
            (!this.wellFilter || el.rus_wellname === this.wellFilter) &&
            (!this.wellStatusFilter || el.well_status_last_day === this.wellStatusFilter) &&
            (!this.statusFilter || el.is_saved === this.statusFilter) &&
            (!this.typeWellFilter || el.type_text === this.typeWellFilter)
          ) {
            filters = [...filters, el.field];
          }
        });
        return [undefined, ...filters];
    },

    wellFilters() {
        let filters = [];
        this.allWells.forEach((el) => {
          if (
            filters.indexOf(el.rus_wellname) === -1 &&
            (!this.fieldFilter || el.field === this.fieldFilter) &&
            (!this.wellStatusFilter || el.well_status_last_day === this.wellStatusFilter) &&
            (!this.statusFilter || el.is_saved === this.statusFilter) &&
            (!this.typeWellFilter || el.type_text === this.typeWellFilter)
          ) {
            filters = [...filters, el.rus_wellname];
          }
        });
        return [undefined, ...filters];
    },
    wellStatusFilters() {
        let filters = [];
        this.allWells.forEach((el) => {
          if (
            filters.indexOf(el.well_status_last_day) === -1 &&
            (!this.fieldFilter || el.field === this.fieldFilter) &&
            (!this.wellFilter || el.rus_wellname === this.wellFilter) &&
            (!this.statusFilter || el.is_saved === this.statusFilter) &&
            (!this.typeWellFilter || el.type_text === this.typeWellFilter)
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
            (!this.fieldFilter || el.field === this.fieldFilter) &&
            (!this.wellFilter || el.rus_wellname === this.wellFilter)  &&
            (!this.wellStatusFilter || el.well_status_last_day === this.wellStatusFilter) &&
            (!this.typeWellFilter || el.type_text === this.typeWellFilter)
          ) {
            filters = [...filters, el.is_saved];
          }
        });
        return [undefined, ...filters];
    },
    typeWellFilters() {
        let filters = [];
        this.allWells.forEach((el) => {
          if (
            filters.indexOf(el.type_text) === -1 &&
            (!this.fieldFilter || el.field === this.fieldFilter) &&
            (!this.wellFilter || el.rus_wellname === this.wellFilter)  &&
            (!this.wellStatusFilter || el.well_status_last_day === this.wellStatusFilter) &&
            (!this.statusFilter || el.is_saved === this.statusFilter)
          ) {
            filters = [...filters, el.type_text];
          }
        });
        return [undefined, ...filters];
    },          
  },
  beforeCreate: function () {},
  created() {
    this.$store.commit("globalloading/SET_LOADING", true);
    this.$store.commit("tr/SET_SORTPARAM", "rus_wellname");
    this.$store.commit("tr/SET_SEARCH", this.searchString);
    this.$store.commit("tr/SET_PAGENUMBER", 1);
    var today = new Date();
    var mm = today.getMonth() + 1;
    var yyyy = today.getFullYear();
    var day = today.getDate();
    if(day > 25 && mm < 12) {
      var mm1 = today.getMonth() + 2;
      var yyyy1 = today.getFullYear();
    }
    else if(day > 25 && mm === 12){
      var mm1 = 1;
      var yyyy1 = today.getFullYear() + 1;
    }
    else{
      var mm1 = today.getMonth() + 1;
      var yyyy1 = today.getFullYear();
    }
    this.$store.commit("tr/SET_MONTH", mm);
    this.$store.commit("tr/SET_YEAR", yyyy);
    this.isDynamic = false;
    this.$store.commit("tr/SET_IS_DYNAMIC", "false");
    this.$store.commit("tr/SET_FIELD", this.selectedField);
    this.$store.commit("tr/SET_OBJECT", this.selectedObject);
    this.$store.commit("tr/SET_HORIZON", this.selectedHorizon);
    this.$store.commit("tr/SET_WELLTYPE", this.selectedWellType);
    this.$store.commit("tr/SET_BLOCK", this.selectedBlock);
    this.$store.commit("tr/SET_EXPMETH", this.selectedExpMeth);
    this.axios
      .post(
        this.postApiUrl + "techregime_totals_test_3/",
        this.getPageData(),
      )
      .then((response) => {
        console.log(this.postApiUrl)
        let data = response.data;
        this.year = yyyy;
        this.selectYear = yyyy;
        this.month = mm;
        this.currentMonth = mm;
        this.currentYear = yyyy;
        this.$store.commit("globalloading/SET_LOADING", false);
        if (response.data) {
          this.wells = data.data;
          this.fullWells = data.data;
        }
        else {
          console.log("No data");
        }
        if (mm1 < 10) {
          this.dt = "01" + ".0" + mm1 + "." + yyyy1;
        } else {
          this.dt = "01" + "." + mm1 + "." + yyyy1;
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
        }
        else {
          console.log("No data");
        }
      });
    this.axios
      .post(
        this.postApiUrl + "techregime_page_numbers/",
        this.getPageData(),
      )
      .then((response) => {
        let data = response.data;
        if (response.data) {
          this.pageCount = data;
        }
        else {
          console.log("No data");
        }
    });
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
      fullWells: [],
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
      statusFilter: undefined,
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
      selectedObject: [],
      selectedHorizon: [],
      selectedField: [],
      selectedWellType: [],
      selectedBlock: [],
      selectedExpMeth: [],
      perPage: 3,
      currentPage: 1,
      isAscSort: "",
      pageCount: 0,
      pageNumber: 1,
      currentMonth: null,
      currentYear: null,
      searchParam: null,
      postApiUrl: process.env.MIX_POST_API_URL,
    };
  },
  methods: {
    getPageData() {
      if (this.isDynamic) {
        return {
          field: this.$store.state.tr.field,
          is_dynamic:  this.$store.state.tr.isDynamic,
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
          year_2:  this.$store.state.tr.year_dyn_end,
          month_2:  this.$store.state.tr.month_dyn_end,
          day_2:  this.$store.state.tr.day_dyn_end,
          };
      }
      else {
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
          is_dynamic:  this.$store.state.tr.isDynamic,
          pageNum: this.$store.state.tr.pageNumber
        }
      };
    },
    clickCallback(pageNum)  {
      this.$store.commit("globalloading/SET_LOADING", true);
      this.$store.commit("tr/SET_PAGENUMBER", pageNum);
      this.chooseAxios();
    },
    dropWellTypeFilter() {
      this.$store.commit("globalloading/SET_LOADING", true),
      this.selectedWellType = [];
      this.$store.commit("tr/SET_WELLTYPE", this.selectedWellType);
      this.$store.commit("tr/SET_PAGENUMBER", 1);
      this.chooseAxios();
    },
    dropFieldFilter() {
      this.$store.commit("globalloading/SET_LOADING", true),
      this.selectedField = [];
      this.$store.commit("tr/SET_FIELD", this.selectedField);
      this.$store.commit("tr/SET_PAGENUMBER", 1);
      this.chooseAxios();
    },
    dropHorizonFilter() {
      this.$store.commit("globalloading/SET_LOADING", true),
      this.selectedHorizon = [];
      this.$store.commit("tr/SET_HORIZON", this.selectedHorizon);
      this.$store.commit("tr/SET_PAGENUMBER", 1);
      this.chooseAxios();
    },
    dropObjectFilter() {
      this.$store.commit("globalloading/SET_LOADING", true),
      this.selectedObject = [];
      this.$store.commit("tr/SET_OBJECT", this.selectedObject);
      this.$store.commit("tr/SET_PAGENUMBER", 1);
      this.chooseAxios();
    },
    dropBlockFilter() {
      this.$store.commit("globalloading/SET_LOADING", true),
      this.selectedBlock = [];
      this.$store.commit("tr/SET_BLOCK", this.selectedBlock);
      this.$store.commit("tr/SET_PAGENUMBER", 1);
      this.chooseAxios();
    },
    dropExpMethFilter() {
      this.$store.commit("globalloading/SET_LOADING", true),
      this.selectedExpMeth = [];
      this.$store.commit("tr/SET_EXPMETH", this.selectedExpMeth);
      this.$store.commit("tr/SET_PAGENUMBER", 1);
      this.chooseAxios();
    },
    chooseFilter() {
      this.$store.commit("globalloading/SET_LOADING", true),
      this.$store.commit("tr/SET_SORTPARAM", this.sortParam);
      this.$store.commit("tr/SET_SEARCH", this.searchString);
      this.$store.commit("tr/SET_FIELD", this.selectedField);
      this.$store.commit("tr/SET_OBJECT", this.selectedObject);
      this.$store.commit("tr/SET_HORIZON", this.selectedHorizon);
      this.$store.commit("tr/SET_WELLTYPE", this.selectedWellType);
      this.$store.commit("tr/SET_BLOCK", this.selectedBlock);
      this.$store.commit("tr/SET_EXPMETH", this.selectedExpMeth);
      this.$store.commit("tr/SET_SORTPARAM", "rus_wellname");
      this.$store.commit("tr/SET_PAGENUMBER", 1);
      this.chooseAxios();
    },
    chooseChildFilter(){
      this.selectedField = this.$store.state.tr.field;
      this.selectedHorizon = this.$store.state.tr.horizon;
      this.selectedWellType = this.$store.state.tr.wellType;
      this.selectedObject = this.$store.state.tr.object;
      this.selectedBlock = this.$store.state.tr.block;
      this.selectedExpMeth = this.$store.state.tr.expMeth;
      this.$store.commit("globalloading/SET_LOADING", true);
      this.$store.commit("tr/SET_PAGENUMBER", 1);
      if (this.isDynamic) {
        this.axiosDynamicFilterRequest();
      }
      else{
        this.axiosFilterRequest();
      }
    },
    chooseAxios() {
      if (this.isDynamic) {
        this.axiosDynamicFilterRequest();
      }
      else if (this.isEdit) {
        this.axiosEdit();
      }
      else{
        this.axiosFilterRequest();
      }
    },
    // Режим редактирования
    axiosEdit() {
      this.axios
        .post(
          this.postApiUrl + "techregime_edit_page/",
          this.getPageData(),
        )
        .then((response) => {
          let data = response.data;
          this.$store.commit("globalloading/SET_LOADING", false);
          if (response.data) {
            this.wells = data.data;
            this.fullWells = data.data;
          }
          else {
            console.log("No data");
          }
      });
      // Пагинация редактирования
      this.axiosEditPage();
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
            this.fullWells = data.data;
          }
          else {
            console.log("No data");
          }
      });
      // Пагинация таблицы
      this.axiosPage();
    },
    // Пагинация таблицы
    axiosPage() {
      this.axios
      .post(
        this.postApiUrl + "techregime_page_numbers/",
        this.getPageData(),
      )
      .then((response) => {
        let data = response.data;
        if (response.data) {
          this.pageCount = data;
        }
        else {
          console.log("No data");
        }
      });
    },
    // Пагинация редактирования
    axiosEditPage() {
      this.axios
      .post(
        this.postApiUrl + "techregime_edit_page_numbers/",
        this.getPageData(),
      )
      .then((response) => {
        let data = response.data;
        if (response.data) {
          this.pageCount = data;
        }
        else {
          console.log("No data");
        }
      });
    },
    // Режим месячного формирования
    axiosFilterRequest() {
      this.axios
        .post(
          this.postApiUrl + "techregime_totals_test_3/",
          this.getPageData(),
        )
        .then((response) => {
          let data = response.data;
          this.$store.commit("globalloading/SET_LOADING", false);
          if (response.data) {
            this.wells = data.data;
            this.fullWells = data.data;
          }
          else {
            console.log("No data");
          }
      });
      this.axiosPage();
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
      this.isEdit = false;
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
          this.fullWells = response.data;
          this.editedWells = [];
          this.$store.commit("globalloading/SET_LOADING", false);
          this.isSearched = searchParam ? true : false;
          this.month = this.currentMonth;
          this.selectYear = this.currentYear;
          this.isShowFirst = true;
          this.isShowSecond = false;
          this.$store.commit("tr/SET_MONTH", this.currentMonth);
          this.$store.commit("tr/SET_YEAR", this.currentYear);
          this.chooseDt();
        })
        .catch((error) => {
          console.log(error.data);
          this.editedWells = [];
          this.searchWell();
          this.isSearched = searchParam ? true : false;
        });
    },
    cancelEdit() {
      this.$store.commit("globalloading/SET_LOADING", true);
      this.isEdit = false;
      this.editedWells = [];
      this.month = this.currentMonth;
      this.selectYear = this.currentYear;
      this.isShowFirst = true;
      this.isShowSecond = false;
      this.$store.commit("tr/SET_MONTH", this.currentMonth);
      this.$store.commit("tr/SET_YEAR", this.currentYear);
      this.chooseDt();
    },
    reRender() {
      this.filteredWellData = [];
      this.wellStatusFilter = undefined;
      this.statusFilter = undefined;
      this.typeWellFilter = undefined;
      this.wellFilter = undefined;
      this.fieldFilter = undefined;
    },
    showWells() {
      if(this.lonelywell.length === 1){
        this.isShowAdd = !this.isShowAdd;
        if(this.lonelywell[0].is_saved === "Сохранено"){
          this.isDeleted = false;
          this.isSaved = true;
        }
        else{
          this.isDeleted = true;
          this.isSaved = false;
        }
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
      let { isSortType } = this;
      if (this.isSortType === true) {
        this.isSortType = false;
      } else {
        this.isSortType = true;
      }
      if (this.isDynamic) {
        this.axiosDynamicFilterRequest();
      }
      else if (this.isEdit) {
        this.axiosEdit();
      }
      else{
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
    chooseDt1() {
      const { date1, date2 } = this;
      var choosenDt = date1.split("-");
      var choosenSecDt = date2.split("-");
      const dd = choosenDt[2];
      const prdd = choosenSecDt[2];
      const mm = choosenDt[1];
      const prMm = choosenSecDt[1];
      const yyyy = choosenDt[0];
      const pryyyy = choosenSecDt[0];
      if (choosenSecDt[2] >= choosenDt[2] && choosenSecDt[1] >= choosenDt[1] && choosenSecDt[0] >= choosenDt[0] || choosenSecDt[0] > choosenDt[0]) {
        Vue.prototype.$notifyError("Дата 2 должна быть меньше чем Дата 1");
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
          this.dt = '(' + prdd + "." + prMm+ "." + pryyyy + ' - ' + dd+ "." + mm+ "." + yyyy + ')';
        } else {
          this.dt = '(' + prdd + "." + prMm+ "." + pryyyy + ' - ' + dd+ "." + mm+ "." + yyyy + ')';
        }
      }
    },
    chooseDt() {
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
            this.isSearched = false;
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

    },
    calendarDynamic() {
      this.is_dynamic_calendar = !this.is_dynamic_calendar
      this.isDateNormal = !this.isDateNormal
      this.isDateDynamic = !this.isDateDynamic
    },
    isCommentClass (row_index, value) {
      return this.wells &&
          this.wells[row_index] &&
          this.wells[row_index][value][1][0] !== '0';
    },
    isActiveClass (row) {
      if (row.rus_wellname) {
          return false
      } else {
          return true
      }

    },

    getColor(status) {
      if (status === "1") return "#ffff00";
      return "#ff0000";
    },
    closeModal(modalName) {
      this.$modal.hide(modalName)
      this.isShowAdd=false;
      this.isDeleted=false;
      this.isSaved=false;
      this.reRender();
    },
    addpush(){     
        this.$modal.show('add_well')
    },

    handlerSearch(search) {
      this.searchString = search;
    },
    handlerFilter(filter) {
      this.filter = filter;
    },

    saveadd() {
      Vue.prototype.$notifySuccess (`Скважина ${this.lonelywell[0].rus_wellname} сохранена`);
      let output = {}
      this.$refs.editTable[0].children.forEach((el) => {
        output[el.children[0].dataset.key] = el.children[0].value;
      });
      this.axios
        .post(
          this.postApiUrl + "techregime/new_wells/add_well/", 
          output).then((res) => {
            this.wellAdd();
            this.created();
            this.isShowAdd=false;
            this.isDeleted=false;           
          })
    },
    // Удаление с модалки
    deleteWell() {
      Vue.prototype.$notifyError (`Скважина ${this.lonelywell[0].rus_wellname} удалена`);
      this.$store.commit("globalloading/SET_LOADING", true);
      if(this.lonelywell.length === 1 && this.lonelywell[0].is_saved === "Сохранено"){
        this.axios
          .get(
            this.postApiUrl + "techregime/new_wells/delete_well/" + 
            this.lonelywell[0].well).then((res) => {
              console.log(res.data)
              this.wellAdd();
              this.created();
              this.isShowAdd=false;
              this.isSaved=false;
              
            })
      }
      else{
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
        this.axiosEditSearch();
        this.axiosEditPage();
      }
      else {
        this.axiosSearch();
        this.axiosPage();        
      }
    },
    // API поиска простого ТР
    axiosSearch() {
      this.axios
        .post(
          this.postApiUrl + "techregime_totals_test_3/",
            this.getPageData(),
        )
        .then((response) => {
          this.$store.commit("globalloading/SET_LOADING", false);
          this.isSearched = this.searchParam ? true : false;
          this.$store.commit("tr/SET_SEARCH", this.searchString);
          let data = response.data;
          if (data) {
            this.wells = data.data;
            this.fullWells = data.data;
          } else {
            this.wells = [];
            this.fullWells = [];
            console.log("No data");
          }
        })
        .catch((error) => {
          this.isSearched = searchParam ? true : false;
          this.$store.commit("globalloading/SET_LOADING", false);
          this.wells = [];
          this.fullWells = [];
          console.log("search error = ", error);
        });
    },
    // API поиска редактирования ТР
    axiosEditSearch() {
      this.axios
        .post(
          this.postApiUrl + "techregime_edit_page/",
            this.getPageData(),
        )
        .then((response) => {
          this.$store.commit("globalloading/SET_LOADING", false);
          this.isSearched = searchParam ? true : false;
          this.$store.commit("tr/SET_SEARCH", this.searchString);
          let data = response.data;
          if (data) {
            this.wells = data.data;
            this.fullWells = data.data;
          } else {
            this.wells = [];
            this.fullWells = [];
            console.log("No data");
          }
        })
        .catch((error) => {
          this.isSearched = searchParam ? true : false;
          this.$store.commit("globalloading/SET_LOADING", false);
          this.wells = [];
          this.fullWells = [];
          console.log("search error = ", error);
        });
    },
  },
};