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
    // Добавление выбранных данных в таблицу
    addWellData() {
      if (this.allWells && this.allWells.length > 0) {
        let is_saved = this.Filter_status;
        let field = this.Filter_field;
        let rus_wellname = this.Filter_well;
        let type_text = this.Filter_well_type;
        let well_status_last_day = this.Filter_well_status;
        try {
          let filteredResult = this.allWells.filter(
            (row) =>
              (!is_saved || row.is_saved === is_saved) &&
              (!field || row.field === field) &&
              (!rus_wellname || row.rus_wellname === rus_wellname) &&
              (!type_text || row.type_text === type_text) &&
              (!well_status_last_day || row.well_status_last_day === well_status_last_day)
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
      } else return false;
      this.render++;
    },
    // фильтр месторожд.
    fieldFilters() {
      if (this.allWells && this.allWells.length > 0) {
        let filters = [];
        this.allWells.forEach((el) => {
          if (
            filters.indexOf(el.field) === -1 &&
            (!this.Filter_well || el.rus_wellname === this.Filter_well) &&
            (!this.Filter_well_status || el.well_status_last_day === this.Filter_well_status) &&
            (!this.Filter_status || el.is_saved === this.Filter_status) &&
            (!this.Filter_well_type || el.type_text === this.Filter_well_type)
          ) {
            filters = [...filters, el.field];
          }
        });
        return [undefined, ...filters];
      } else return [];
    },
    // фильтр по скважинам
    wellFilters() {
      if (this.allWells && this.allWells.length > 0) {
        let filters = [];
        this.allWells.forEach((el) => {
          if (
            filters.indexOf(el.rus_wellname) === -1 &&
            (!this.Filter_field || el.field === this.Filter_field) &&
            (!this.Filter_well_status || el.well_status_last_day === this.Filter_well_status) &&
            (!this.Filter_status || el.is_saved === this.Filter_status) &&
            (!this.Filter_well_type || el.type_text === this.Filter_well_type)
          ) {
            filters = [...filters, el.rus_wellname];
          }
        });
        return [undefined, ...filters];
      } else return [];
    },
    // фильтр по сост.скв
    wellStatusFilters() {
      if (this.allWells && this.allWells.length > 0) {
        let filters = [];
        this.allWells.forEach((el) => {
          if (
            filters.indexOf(el.well_status_last_day) === -1 &&
            (!this.Filter_field || el.field === this.Filter_field) &&
            (!this.Filter_well || el.rus_wellname === this.Filter_well) &&
            (!this.Filter_status || el.is_saved === this.Filter_status) &&
            (!this.Filter_well_type || el.type_text === this.Filter_well_type)
          ) {
            filters = [...filters, el.well_status_last_day];
          }
        });
        return [undefined, ...filters];
      } else return [];
    },
    // фильтр по статусам (сохраненные или не сохраненные)
    statusFilters() {
      if (this.allWells && this.allWells.length > 0) {
        let filters = [];
        this.allWells.forEach((el) => {
          if (
            filters.indexOf(el.is_saved) === -1 &&
            (!this.Filter_field || el.field === this.Filter_field) &&
            (!this.Filter_well || el.rus_wellname === this.Filter_well)  &&
            (!this.Filter_well_status || el.well_status_last_day === this.Filter_well_status) &&
            (!this.Filter_well_type || el.type_text === this.Filter_well_type)
          ) {
            filters = [...filters, el.is_saved];
          }
        });
        return [undefined, ...filters];
      } else return [];
    },
    typeWellFilters() {
      if (this.allWells && this.allWells.length > 0) {
        let filters = [];
        this.allWells.forEach((el) => {
          if (
            filters.indexOf(el.type_text) === -1 &&
            (!this.Filter_field || el.field === this.Filter_field) &&
            (!this.Filter_well || el.rus_wellname === this.Filter_well)  &&
            (!this.Filter_well_status || el.well_status_last_day === this.Filter_well_status) &&
            (!this.Filter_status || el.is_saved === this.Filter_status)
          ) {
            filters = [...filters, el.type_text];
          }
        });
        return [undefined, ...filters];
      } else return [];
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
    this.is_dynamic = false;
    this.$store.commit("tr/SET_IS_DYNAMIC", "false");
    this.$store.commit("tr/SET_FIELD", this.selectedField);
    this.$store.commit("tr/SET_OBJECT", this.selectedObject);
    this.$store.commit("tr/SET_HORIZON", this.selectedHorizon);
    this.$store.commit("tr/SET_WELLTYPE", this.selectedWellType);
    this.$store.commit("tr/SET_BLOCK", this.selectedBlock);
    this.$store.commit("tr/SET_EXPMETH", this.selectedExpMeth);
    this.axios
      .post(
        "http://172.20.103.187:7576/api/techregime_totals_test_3/",
        this.getPageData(),
      )
      .then((response) => {
        let data = response.data;
        this.year = yyyy;
        this.selectYear = yyyy;
        this.month = mm;
        this.checkMonth = mm;
        this.checkYear = yyyy;
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
        "http://172.20.103.187:7576/api/techregime/tr_parameter_filters/"
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
        "http://172.20.103.187:7576/api/techregime_page_numbers/",
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
      searched: false,
      sortParam: "",
      sortType: true,
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
      show_first: true,
      show_second: false,
      show_add: false,
      edit: false,
      editdtm: null,
      editdty: null,
      year: null,
      selectYear: null,
      month: null,
      isfulltable: false,
      Filter_field: undefined,
      allWells: [],
      Filter_well_status: undefined,
      Filter_status: undefined,
      Filter_well_type: undefined,
      filteredWellData: [],
      lonelywell: [],
      render: 0,
      searchStringModel: "",
      Filter_well: undefined,
      checkers: false,
      checkersec: false,
      datepicker1: true,
      datepicker2: false,
      date_fix: true,
      is_dynamic: false,
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
      isEdit: false,
      checkMonth: null,
      checkYear: null,
      isDateCheck: true,
      searchParam: null,
    };
  },
  methods: {
    getPageData() {
      if (this.is_dynamic) {
        return {
          field: this.$store.getters["tr/field"],
          is_dynamic:  this.$store.getters["tr/is_dynamic"],
          object: this.$store.getters["tr/object"],
          searchString: this.$store.getters["tr/searchString"],
          sortType: this.$store.getters["tr/sortType"],
          sortParam: this.$store.getters["tr/sortParam"],
          wellType: this.$store.getters["tr/wellType"],
          pageNum: this.$store.getters["tr/pageNumber"],
          block: this.$store.getters["tr/block"],
          expMeth: this.$store.getters["tr/expMeth"],
          horizon: this.$store.getters["tr/horizon"],
          year_1: this.$store.getters["tr/year_dyn_start"],
          month_1: this.$store.getters["tr/month_dyn_start"],
          day_1: this.$store.getters["tr/day_dyn_start"],
          year_2:  this.$store.getters["tr/year_dyn_end"],
          month_2:  this.$store.getters["tr/month_dyn_end"],
          day_2:  this.$store.getters["tr/day_dyn_end"],
          };
      }
      else {
        return {
          month: this.$store.getters["tr/month"],
          year: this.$store.getters["tr/year"],
          sortType: this.$store.getters["tr/sortType"],
          sortParam: this.$store.getters["tr/sortParam"],
          field: this.$store.getters["tr/field"],
          horizon: this.$store.getters["tr/horizon"],
          wellType: this.$store.getters["tr/wellType"],
          object: this.$store.getters["tr/object"],
          block: this.$store.getters["tr/block"],
          expMeth: this.$store.getters["tr/expMeth"],
          searchString: this.$store.getters["tr/searchString"],
          is_dynamic:  this.$store.getters["tr/is_dynamic"],
          pageNum: this.$store.getters["tr/pageNumber"]
        }
      };
    },
    clickCallback(pageNum)  {
      this.$store.commit("globalloading/SET_LOADING", true);
      this.$store.commit("tr/SET_PAGENUMBER", pageNum);
      this.pageNumber = pageNum;
      this.chooseAxios();
    },
    dropWellTypeFilter() {
      this.$store.commit("globalloading/SET_LOADING", true),
      this.selectedWellType = [];
      this.$store.commit("tr/SET_WELLTYPE", this.selectedWellType);
      this.$store.commit("tr/SET_PAGENUMBER", 1);
      this.pageNumber = 1;
      this.chooseAxios();
    },
    dropFieldFilter() {
      this.$store.commit("globalloading/SET_LOADING", true),
      this.selectedField = [];
      this.$store.commit("tr/SET_FIELD", this.selectedField);
      this.$store.commit("tr/SET_PAGENUMBER", 1);
      this.pageNumber=1;
      this.chooseAxios();
    },
    dropHorizonFilter() {
      this.$store.commit("globalloading/SET_LOADING", true),
      this.selectedHorizon = [];
      this.$store.commit("tr/SET_HORIZON", this.selectedHorizon);
      this.$store.commit("tr/SET_PAGENUMBER", 1);
      this.pageNumber=1;
      this.chooseAxios();
    },
    dropObjectFilter() {
      this.$store.commit("globalloading/SET_LOADING", true),
      this.selectedObject = [];
      this.$store.commit("tr/SET_OBJECT", this.selectedObject);
      this.$store.commit("tr/SET_PAGENUMBER", 1);
      this.pageNumber=1;
      this.chooseAxios();
    },
    dropBlockFilter() {
      this.$store.commit("globalloading/SET_LOADING", true),
      this.selectedBlock = [];
      this.$store.commit("tr/SET_BLOCK", this.selectedBlock);
      this.$store.commit("tr/SET_PAGENUMBER", 1);
      this.pageNumber=1;
      this.chooseAxios();
    },
    dropExpMethFilter() {
      this.$store.commit("globalloading/SET_LOADING", true),
      this.selectedExpMeth = [];
      this.$store.commit("tr/SET_EXPMETH", this.selectedExpMeth);
      this.$store.commit("tr/SET_PAGENUMBER", 1);
      this.pageNumber=1;
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
      this.$store.commit("tr/SET_PAGENUMBER", 1);
      this.pageNumber=1;
      this.chooseAxios();
    },
    chooseChildFilter(){
      this.selectedField = this.$store.getters["tr/field"];
      this.selectedHorizon = this.$store.getters["tr/horizon"];
      this.selectedWellType = this.$store.getters["tr/wellType"];
      this.selectedObject = this.$store.getters["tr/object"];
      this.selectedBlock = this.$store.getters["tr/block"];
      this.selectedExpMeth = this.$store.getters["tr/expMeth"];
      this.$store.commit("globalloading/SET_LOADING", true);
      this.$store.commit("tr/SET_PAGENUMBER", 1);
      this.pageNumber=1;
      if (this.is_dynamic) {
        this.axiosDynamicFilterRequest();
      }
      else{
        this.axiosFilterRequest();
      }
    },
    chooseAxios() {
      if (this.is_dynamic) {
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
          "http://172.20.103.187:7576/api/techregime_edit_page/",
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
          "http://172.20.103.187:7576/api/techregime_dynamic_totals/",
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
        "http://172.20.103.187:7576/api/techregime_page_numbers/",
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
        "http://172.20.103.187:7576/api/techregime_edit_page_numbers/",
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
          "http://172.20.103.187:7576/api/techregime_totals_test_3/",
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
          "http://172.20.103.187:7576/api/techregime/edit/" +
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
      this.edit = false;
      this.$store.commit("globalloading/SET_LOADING", true);
      const searchParam = this.searchString ? `${this.searchString}/` : "";
      this.axios
        .post(
          "http://172.20.103.187:7576/api/techregime_save_page/",
          {
            well: this.editedWells,
          }
        )
        .then((response) => {
          this.fullWells = response.data;
          this.editedWells = [];
          this.$store.commit("globalloading/SET_LOADING", false);
          this.searched = searchParam ? true : false;
          this.month = this.checkMonth;
          this.selectYear = this.checkYear;
          this.show_first = true;
          this.show_second = false;
          this.$store.commit("tr/SET_MONTH", this.checkMonth);
          this.$store.commit("tr/SET_YEAR", this.checkYear);
          this.chooseDt();
        })
        .catch((error) => {
          console.log(error.data);
          this.editedWells = [];
          this.searchWell();
          this.searched = searchParam ? true : false;
        });
    },
    dateCheck() {
      if (this.year === this.checkYear && int(this.month) === this.checkMonth) {
        return this.isDateCheck = true;
      }
      else {
        return this.isDateCheck = false;
      }
    },
    cancelEdit() {
      this.$store.commit("globalloading/SET_LOADING", true);
      this.isEdit = false;
      this.edit = false;
      this.editedWells = [];
      this.month = this.checkMonth;
      this.selectYear = this.checkYear;
      this.show_first = true;
      this.show_second = false;
      this.$store.commit("tr/SET_MONTH", this.checkMonth);
      this.$store.commit("tr/SET_YEAR", this.checkYear);
      this.chooseDt();
    },
    reRender() {
      this.filteredWellData = [];
      this.Filter_well_status = undefined;
      this.Filter_status = undefined;
      this.Filter_well_type = undefined;
      this.Filter_well = undefined;
      this.Filter_field = undefined;
    },
    showWells() {
      if(this.lonelywell.length === 1){
        this.show_add = !this.show_add;
        if(this.lonelywell[0].is_saved === "Сохранено"){
          this.checkers = false;
          this.checkersec = true;
        }
        else{
          this.checkers = true;
          this.checkersec = false;
        }
      }
      else{
        this.show_add = this.show_add;
      }
    },
    editable() {
      this.$store.commit("globalloading/SET_LOADING", true);
      this.is_dynamic = false;
      this.isEdit = true;
      this.edit = true;
      this.show_second = true;
      this.show_first = false;
      this.axiosEdit();
    },
    closeModal(modalName) {
      this.$modal.hide(modalName)
    },
    sortBy(type) {
      this.$store.commit("tr/SET_SORTTYPE", this.sortType);
      this.$store.commit("tr/SET_SORTPARAM", type);
      let { sortType } = this;
      if (this.sortType === true) {
        this.sortType = false;
      } else {
        this.sortType = true;
      }
      if (this.is_dynamic) {
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
        this.is_dynamic = true;
        this.axiosDynamicFilterRequest();
        this.searched = false;
        this.date_fix = false;
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
      this.$store.commit("tr/SET_SEARCH", "");
      this.$store.commit("tr/SET_SORTTYPE", true);
      this.$store.commit("tr/SET_SORTPARAM", "rus_wellname");
      this.$store.commit("tr/SET_IS_DYNAMIC", "false");
      this.is_dynamic = false;
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
          "http://172.20.103.187:7576/api/techregime/new_wells/" 
        )
        .then((response) => {
          this.$store.commit("globalloading/SET_LOADING", false);
          let data = response.data;
          if (data) {
            this.searched = false;
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
      this.show_first = !this.show_first;
      this.show_second = !this.show_second;
      this.isfulltable = !this.isfulltable;

    },
    calendarDynamic() {
      this.is_dynamic_calendar = !this.is_dynamic_calendar
      this.datepicker1 = !this.datepicker1
      this.datepicker2 = !this.datepicker2
    },

    getColor(status) {
      if (status === "1") return "#ffff00";
      return "#ff0000";
    },
    closeModal(modalName) {
      this.$modal.hide(modalName)
      this.show_add=false;
      this.checkers=false;
      this.checkersec=false;
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
          "http://172.20.103.187:7576/api/techregime/new_wells/add_well/", 
          output).then((res) => {
            this.wellAdd();
            this.created();
            this.show_add=false;
            this.checkers=false;           
          })
    },
    // Удаление с модалки
    deleteWell() {
      Vue.prototype.$notifyError (`Скважина ${this.lonelywell[0].rus_wellname} удалена`);
      this.$store.commit("globalloading/SET_LOADING", true);
      if(this.lonelywell.length === 1 && this.lonelywell[0].is_saved === "Сохранено"){
        this.axios
          .get(
            "http://172.20.103.187:7576/api/techregime/new_wells/delete_well/" + 
            this.lonelywell[0].well).then((res) => {
              console.log(res.data)
              this.wellAdd();
              this.created();
              this.show_add=false;
              this.checkersec=false;
              
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
      this.pageNumber=1;
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
          "http://172.20.103.187:7576/api/techregime_totals_test_3/",
            this.getPageData(),
        )
        .then((response) => {
          this.$store.commit("globalloading/SET_LOADING", false);
          this.searched = this.searchParam ? true : false;
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
          this.searched = searchParam ? true : false;
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
          "http://172.20.103.187:7576/api/techregime_edit_page/",
            this.getPageData(),
        )
        .then((response) => {
          this.$store.commit("globalloading/SET_LOADING", false);
          this.searched = searchParam ? true : false;
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
          this.searched = searchParam ? true : false;
          this.$store.commit("globalloading/SET_LOADING", false);
          this.wells = [];
          this.fullWells = [];
          console.log("search error = ", error);
        });
    },
  },
};