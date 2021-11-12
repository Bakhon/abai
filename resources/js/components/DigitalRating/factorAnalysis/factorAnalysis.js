import apexchart from 'vue-apexcharts';
import BtnDropdown from "../components/BtnDropdown";
import mainMenu from "../../GTM/mock-data/main_menu.json";
import {analysis} from '../json/data';

export default {
  name: "factorAnalysis",

  data() {
    return {
      menu: mainMenu,
      parentType: '',
      analysis: analysis,
    }
  },

  methods: {
    handleSelectAnalysis() {

    }
  }
}