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

<style lang="scss" scoped src="./BaseTableStyles.scss"></style>