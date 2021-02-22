<template>
  <hot-table
    :data="data"
    :colHeaders="true"
    :settings="hotSettings"
    :rowHeaders="true"
    licenseKey="non-commercial-and-evaluation"
  >
    <input type="hidden" name="oil_plan" v-model="oil_plan" />
    <input type="hidden" name="oil_fact" v-model="oil_fact" />
    <button @click="save()" class="btn btn-primary" id="submit_btn">
      Сохранить
    </button>   
  </hot-table>
</template>
 
<script>
import { HotTable } from "@handsontable/vue";
export default {
  data: function () {
    return {
      temp: [1],
      oil_plan: "",
      oil_fact: "",
      data: [
        [
          '                           СУТОЧНЫЙ РАПОРТ  АО"КАРАЖАНБАСМУНАЙ"  ЗА 			',
          " ",
          " ",
          " ",
          "13.02.2021",
          " ",
          " ",
          " ",
        ],
        ["НЕФТЬ /OIL", " ДОБЫЧА, тонн 						"],
        [, "ГРАФИК на месяц ", "СУТОЧНАЯ 		", " ", " ", "С НАЧАЛА МЕСЯЦА		"],
        [, , "План ", "Факт", "(+,-)", "План", "Факт ", "(+,-)"],
        ['АО "КАРАЖАНБАСМУНАЙ" '],
      ],
      hotSettings: {
        colHeaders: true,
        rowHeaders: true,
        contextMenu: true,
        readOnly: true,
        className: "htCenter htMiddle",
        stretchH: "all",
        mergeCells: [
          { row: 0, col: 0, rowspan: 1, colspan: 4 },
          { row: 1, col: 0, rowspan: 3, colspan: 1 },
          { row: 1, col: 1, rowspan: 1, colspan: 7 },
          { row: 2, col: 1, rowspan: 2, colspan: 1 },
          { row: 2, col: 2, rowspan: 1, colspan: 3 },
          { row: 2, col: 5, rowspan: 1, colspan: 3 },
        ],
        startCols: 30,
        startRows: 50,
        formulas: true,
        licenseKey: "non-commercial-and-evaluation",
        cells: function (row, col, prop) {
          var cellProperties = {};

          if (row === 4) {
            cellProperties.readOnly = false;
          }

          if (col > 0) {
            if (row === 4) {
              cellProperties.type = "numeric";
              cellProperties.allowEmpty = false;
            }
          }

          return cellProperties;
        },
      },
    };
  },
  methods: {
    save() {
      this.oil_plan = this.data[4][2];
      this.oil_fact = this.data[4][3];
    },
  },
  components: {
    HotTable,
  },
};
</script>

