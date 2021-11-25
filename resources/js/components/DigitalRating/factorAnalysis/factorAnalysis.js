import apexchart from 'vue-apexcharts';
import BtnDropdown from "../components/BtnDropdown";
import mainMenu from "../../GTM/mock-data/main_menu.json";
import {analysis, factorTableHeads, factorRows} from '../json/data';

export default {
  name: "factorAnalysis",

  components: {
    BtnDropdown
  },

  data() {
    return {
      menu: mainMenu,
      parentType: '',
      analysis: analysis,
    }
  },

  computed: {
    tableHead() {
      return factorTableHeads;
    },
    rows() {
      return factorRows;
    },
  },

  methods: {
    handleSelectAnalysis() {

    },
    getColor(item) {
      if (item > 0) return '#00A859';
      return '#ED3237';
    },
    getIcon(item) {
      if (item > 0) {
        return '<i className="fas fa-caret-down" style="color: #ED3237; margin-right: 4px;"/>';
      }
      return '<i className="fas fa-caret-up" style="color: #00A859; margin-right: 4px;"/>';
    },
    menuClick(data) {
      const path = window.location.pathname.slice(3);
      if (data?.url && data.url !== path) {
        window.location.href = this.localeUrl(data.url);
      }
    },
  }
}