<template>
  <div class="table-container">
    <div class="table-div">
      <div>
        <table>
          <thead>
            <tr>
              <th
                v-for="(heading, index) in fields"
                :key="index"
                :style="sticky ? 'position: sticky; top: -1px;' : ''"
              >
                <div class="table-header-cell" v-if="filter">
                  <img
                    src="/img/PlastFluids/filterIcon.svg"
                    alt="filter items"
                  />
                  <p>{{ isObjectArray ? heading.name : heading }}</p>
                  <div>
                    <img
                      src="/img/PlastFluids/tableFilterArrow.svg"
                      alt="filter new first"
                      @click="
                        emitArrowFilter(
                          isObjectArray ? heading.key : heading,
                          'up'
                        )
                      "
                    />
                    <img
                      src="/img/PlastFluids/tableFilterArrow.svg"
                      alt="filter old first"
                      @click="
                        emitArrowFilter(
                          isObjectArray ? heading.key : heading,
                          'down'
                        )
                      "
                    />
                  </div>
                </div>
                <p v-else>{{ isObjectArray ? heading.name : heading }}</p>
              </th>
            </tr>
          </thead>
          <tbody>
            <template v-if="isObjectArray">
              <tr v-for="item in items" :key="item.id">
                <td v-for="fieldKey in fieldKeys" :key="fieldKey">
                  {{ item[fieldKey] }}
                </td>
              </tr>
            </template>
            <template v-else>
              <tr v-for="(item, index) in items" :key="index">
                <template v-if="typeof item === 'string'">
                  <td style="background-color: #272953;">
                    {{ item }}
                  </td>
                </template>
                <template v-else>
                  <td v-for="(itemTD, ind) in item" :key="ind">
                    {{ itemTD }}
                  </td>
                </template>
              </tr>
            </template>
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
      return [
        ...Array(this.allPageCount > 6 ? this.allPageCount : 6).keys(),
      ].map((i) => i + 1);
    },
    fieldKeys() {
      const keys = this.fields.map((field) => field.key);
      return keys;
    },
    isObjectArray() {
      return this.fields.some((field) => typeof field === "object");
    },
  },
};
</script>

<style lang="scss" scoped src="./BaseTableStyles.scss"></style>
