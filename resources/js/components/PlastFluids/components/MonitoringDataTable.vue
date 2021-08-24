<template>
  <div class="monitoring-table-div">
    <div class="monitoring-table-title">
      {{ trans("plast_fluids.downloads_monitoring") }}
    </div>
    <b-table
      ref="pfMonitoringTable"
      bordered
      striped
      responsive
      small
      :fields="fields"
      :items="computedTableData"
      :current-page="currentPage"
      :per-page="perPage"
      sticky-header="100%"
    >
      <template #thead-top="data">
        <b-tr>
          <b-th
            style="color: #fff;"
            v-for="field in data.fields"
            :key="field.key"
          >
            <div class="table-header-cell">
              <img src="/img/PlastFluids/search.svg" alt="search" />
              <img src="/img/PlastFluids/filterIcon.svg" alt="filter items" />
              <p>{{ field.label }}</p>
              <div>
                <img
                  src="/img/PlastFluids/tableFilterArrow.svg"
                  alt="filter new first"
                />
                <img
                  src="/img/PlastFluids/tableFilterArrow.svg"
                  alt="filter old first"
                />
              </div>
            </div>
          </b-th>
        </b-tr>
      </template>
    </b-table>
    <b-row>
      <b-col sm="5" md="6" class="my-1">
        <b-form-group
          label="Показать первые"
          label-for="per-page-select"
          label-cols-sm="6"
          label-cols-md="4"
          label-cols-lg="4"
          label-align-sm="right"
          label-size="sm"
          class="mb-0"
        >
          <b-form-select
            id="per-page-select"
            v-model="perPage"
            :options="pageOptions"
            size="sm"
          ></b-form-select>
        </b-form-group>
      </b-col>
      <div style="margin-left: 180px;" class="pagination">
        <a href="#">&laquo;</a>
        <a href="#">1</a>
        <a class="active" href="#">2</a>
        <a href="#">3</a>
        <a href="#">4</a>
        <a href="#">5</a>
        <a href="#">6</a>
        <a href="#">&raquo;</a>
      </div>
    </b-row>
  </div>
</template>

<script>
import { getTemplateHistory } from "../services/templateService";
import moment from "moment";

export default {
  name: "MonitoringDataTable",
  data() {
    return {
      fields: [
        {
          key: "upload_datetime",
          label: "Дата загрузки",
          sortable: true,
          tdClass: "monitoring-td",
        },
        {
          key: "author",
          label: "Автор загрузки",
          sortable: true,
        },
        {
          key: "subsoil_user",
          label: "Недропользователь",
          sortable: true,
        },
        {
          key: "oil_field",
          label: "Месторождение",
          sortable: true,
        },
        {
          key: "selection_date_start",
          label: "Дата отбора начало",
          sortable: true,
        },
        {
          key: "selection_date_end",
          label: "Дата отбора конец",
          sortable: true,
        },
        {
          key: "template_type",
          label: "Тип данных",
          sortable: true,
        },
      ],
      items: [],
      currentPage: 1,
      perPage: 15,
      pageOptions: [15, 20, 25, { value: 100, text: "Показать больше" }],
      tableDataFilterOptions: {
        row_on_page: 30,
        page_number: 1,
        author: "None",
        subsoil_user: "None",
        oil_field: "None",
        upload_datetime: "None",
        selection_date_start: "None",
        selection_date_end: "None",
        template_type: "None",
        loaded_samples_number: "None",
      },
    };
  },
  computed: {
    computedTableData() {
      const data = this.items.map((item) => ({
        ...item,
        upload_datetime: moment(item.upload_datetime).format("YYYY-MM-DD"),
      }));
      return data;
    },
  },
  methods: {
    async handleTemplateHistory() {
      const postData = new FormData();
      for (let key in this.tableDataFilterOptions) {
        postData.append(key, this.tableDataFilterOptions[key]);
      }
      const responseData = await getTemplateHistory(postData);
      this.items = responseData.data;
    },
    removeFirstHeader() {
      this.$refs.pfMonitoringTable.$el.children[0].style.color = "#fff";
      this.$refs.pfMonitoringTable.$children[0].$children[1].$el.style.display =
        "none";
    },
  },
  mounted() {
    this.removeFirstHeader();
    this.handleTemplateHistory();
  },
};
</script>

<style scoped>
.table-white * {
  color: #fff;
}

.monitoring-table-div {
  display: flex;
  flex-flow: column;
  flex: 2 1 auto;
  padding: 15px;
  background: #272953;
  margin: 0 10px;
}

.pf-monitoring-table {
  height: 100%;
}

.monitoring-table-title {
  margin-bottom: 17px;
  width: 100%;
  text-align: start;
  font-weight: bold;
  font-size: 22px;
  color: #fff;
}

table,
th,
td {
  border: 1px solid #454d7d;
  background: #333975 !important;
  color: #fff;
}
th,
td {
  max-width: 200px;
  height: 28px;
  padding: 13px 10px 13px 13px !important;
}

th * {
  color: #fff;
}

.table-header-cell {
  display: flex;
  width: 100%;
  height: 100%;
  align-items: center;
  justify-content: space-between;
}

.table-header-cell > p {
  margin: 0 10px;
  font-size: 12px;
  text-align: center;
}

.table-header-cell > div {
  height: 16px;
  display: flex;
  flex-flow: column;
  justify-content: space-between;
}

.table-header-cell > div > img:last-child {
  transform: rotate(180deg);
}

#per-page-select {
  width: 20%;
  background: #1f2142;
  border-color: #454fa1;
  color: #fff;
}

.pagination {
  background: none;
}
.pagination > a {
  color: #fff;
  opacity: 0.5;
  padding: 6px 14px;
  float: right;
}

tr:nth-child(even) {
  background-color: #454d7d52;
}

::-webkit-scrollbar {
  height: 4px;
  width: 4px;
}

::-webkit-scrollbar-track {
  background: #272953;
}

::-webkit-scrollbar-thumb {
  background: #656a8a;
}
</style>
