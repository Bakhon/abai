<template>
  <div class="tables">
    <div class="tables-name">Добыча нефти и конденсата</div>
    <div class="btn btn-info2" @click="getTable()">Вывести таблицу</div>
    <div class="tables-string">
      <div class="cell-colour-top table-border"></div>
      <div class="cell-number-top table-border">№</div>
      <div class="cell-name-top table-border">Предприятия</div>
      <div class="cell-last-top table-border cell-last">ДОБЫЧА, тонн</div>
      <div class="cell2 table-border">План на 2020 год</div>
      <div class="cell2 table-border">План на июль месяц</div>
      <div class="cell3 table-border">СУТОЧНАЯ</div>
      <div class="cell3 table-border">С НАЧАЛА МЕСЯЦА</div>
      <div class="cell3 table-border cell-last">С НАЧАЛА ГОДА</div>
      <div class="cell4 table-border">ПЛАН</div>
      <div class="cell4 table-border">ФАКТ</div>
      <div class="cell4 table-border">(+,-)</div>
      <div class="cell4 table-border">ПЛАН</div>
      <div class="cell4 table-border">ФАКТ</div>
      <div class="cell4 table-border">(+,-)</div>
      <div class="cell4 table-border">ПЛАН</div>
      <div class="cell4 table-border">ФАКТ</div>
      <div class="cell4 table-border cell-last">(+,-)</div>
    </div>
    <div style="clear: both;"></div>
    <div v-for="item in series">
      <div>
        <div>
          <div class="cell-colour table-border">
            <div
              class="circle-table"
              :style="`background: ${getColor(item.liq_fact - item.liq_plan)}`"
            ></div>
          </div>
          <div class="cell-number table-border"></div>
          <div class="cell-name table-border">{{ item.dzo }}</div>
          <div class="cell table-border"></div>
          <div class="cell table-border"></div>
          <div class="cell table-border">{{ item.liq_plan }}</div>
          <div class="cell table-border">{{ item.liq_fact }}</div>
          <div
            class="cell table-border colour"
            :style="`background: ${getColor(item.liq_fact - item.liq_plan)}`"
          >
            {{ item.liq_fact - item.liq_plan }}
          </div>
          <div class="cell table-border"></div>
          <div class="cell table-border"></div>
          <div class="cell table-border colour"></div>
          <div class="cell table-border"></div>
          <div class="cell table-border"></div>
          <div class="cell table-border cell-last colour"></div>
        </div>
        <div style="clear: both;"></div>
      </div>
      <div class="tables-bottom-line"></div>
    </div>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      series: "",
    };
  },
  methods: {
    getColor(status) {
      if (status < "0") return "#b40300";
      return "#008a17";
    },

    getTable() {
      let company = localStorage.getItem("company");
      let uri = "/js/json/getnkkmg.json";
      //let uri = "/ru/getnkkmg";
      this.axios.get(uri).then((response) => {
        let data = response.data;
        if (data) {
          var arrdata = new Array();
          arrdata = _.filter(data, _.iteratee({ dzo: company }));
          this.series = arrdata;
        } else {
          console.log("No data");
        }
      });
    },
  },
};
</script>
