import mainMenu from "../../GTM/mock-data/main_menu.json";
import BtnDropdown from "../components/BtnDropdown";
import {rowsOil,rowsHorizon} from '../json/data'

export default {
  name: 'CompareDrilling',

  components: {
    BtnDropdown
  },

  data() {
    return {
      menu: mainMenu,
      parentType: '',
      horizonList: [
        '13 горизонт',
        '14 горизонт'
      ],
      yearList: ['2020', '2021'],
      horizon: 12,
    }
  },

  computed: {
    getSelectedHorizon() {
      return this.horizon;
    },
    rowsOil() {
      return rowsOil;
    },
    rowsHorizon() {
      return rowsHorizon;
    }
  },

  methods: {
    menuClick(data) {
      const path = window.location.pathname.slice(3);
      if (data?.url && data.url !== path) {
        window.location.href = this.localeUrl(data.url);
      }
    },
  }
}