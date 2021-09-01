<template>
  <div class="table-container">
    <div class="table-div">
      <div>
        <table>
          <thead>
            <tr>
              <th
                v-for="heading in fields"
                :key="heading.key"
                :style="sticky ? 'position: sticky; top: -1px;' : ''"
              >
                <div class="table-header-cell" v-if="filter">
                  <img
                    src="/img/PlastFluids/filterIcon.svg"
                    alt="filter items"
                  />
                  <p>{{ heading.name }}</p>
                  <div>
                    <img
                      src="/img/PlastFluids/tableFilterArrow.svg"
                      alt="filter new first"
                      @click="emitArrowFilter(heading.key, 'up')"
                    />
                    <img
                      src="/img/PlastFluids/tableFilterArrow.svg"
                      alt="filter old first"
                      @click="emitArrowFilter(heading.key, 'down')"
                    />
                  </div>
                </div>
                <p v-else>{{ heading.name }}</p>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in items" :key="item.id">
              <td v-for="fieldKey in computedFields" :key="fieldKey">
                {{ item[fieldKey] }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div v-if="pagination" class="table-pagination-container">
      <div class="per-page-select-div">
        <p>{{ trans("plast_fluids.show_first") }}</p>
        <select v-model="perPage" name="per-page-select" id="per-page-select">
          <option disabled value="">{{ trans("plast_fluids.choose") }}</option>
          <option value="10">10</option>
          <option value="20">20</option>
          <option value="30">30</option>
        </select>
        <p>{{ trans("plast_fluids.data_on_page") }}</p>
      </div>
      <div class="pagination">
        <div class="arrow-icons-holder">
          <img src="/img/PlastFluids/doubleArrow.svg" alt="3 pages back" />
          <img src="/img/PlastFluids/backArrow.svg" alt="previous page" />
        </div>
        <div class="pagination-page-buttons">
          <a v-for="(page, index) in computedPagesCount" :key="index">{{
            page
          }}</a>
        </div>
        <div class="flipped-icons arrow-icons-holder">
          <img src="/img/PlastFluids/backArrow.svg" alt="next page" />
          <img src="/img/PlastFluids/doubleArrow.svg" alt="3 pages forward" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "BaseTable",
  props: {
    filter: Boolean,
    pagination: Boolean,
    sticky: Boolean,
    allPageCount: Number,
    currentPage: Number,
    fields: Array,
    items: Array,
    handlePageChange: Function,
  },
  data() {
    return {
      perPage: 30,
    };
  },
  watch: {
    perPage: {
      handler(val) {
        this.$emit("show-items-per-page", Number(val));
      },
    },
  },
  methods: {
    emitArrowFilter(key, type) {
      this.$emit("sort-by-arrow-filter", { key, type });
    },
  },
  computed: {
    computedPagesCount() {
      return [...Array(6).keys()].map((i) => i + 1);
    },
    computedFields() {
      const keys = this.fields.map((field) => field.key);
      return keys;
    },
  },
};
</script>

<style scoped>
table,
th,
td {
  border: 1px solid #454d7d;
  color: #fff;
}

table {
  width: 100%;
  position: relative;
  font-size: 12px;
}

th {
  background: #333975;
  max-width: 200px;
  white-space: nowrap;
}

tr:nth-child(even) {
  background: #272953;
}

tr:nth-child(odd) {
  background: rgba(69, 77, 125, 0.32);
}

.table-container {
  width: 100%;
  height: calc(100% - 47px);
}

.table-div {
  width: 100%;
  height: calc(100% - 30px);
  overflow: auto;
}

.table-div > div {
  display: table;
  table-layout: fixed;
  width: 100%;
  height: 100%;
}

th,
td {
  padding: 13px 10px;
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

.table-pagination-container {
  display: flex;
  justify-content: space-between;
  width: 100%;
  height: 30px;
}

.per-page-select-div {
  display: flex;
  height: 100%;
  align-items: center;
  width: 50%;
  color: #fff;
}

.per-page-select-div > select {
  margin: 0 10px;
  width: 60px;
  background: #1f2142;
  border-color: #454fa1;
  color: #fff;
}

.per-page-select-div > p {
  margin: 0;
}

.pagination {
  width: 240px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.pagination > div {
  display: flex;
  justify-content: space-between;
}

.arrow-icons-holder {
  width: 36px;
}

.arrow-icons-holder > img {
  cursor: pointer;
}

.pagination-page-buttons {
  width: 125px;
}

.pagination-page-buttons > a {
  font-size: 16px;
  color: #fff;
  opacity: 0.5;
}

.flipped-icons > img {
  transform: rotate(180deg);
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
