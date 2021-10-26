<template>
  <div
    class="table-container"
    :style="tableType === 'analysis' ? 'height: 100%;' : ''"
  >
    <div class="table-div" :style="!pagination ? 'height: 100%' : ''">
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
              <th
                v-if="tableType === 'upload'"
                style="padding: 13px 10px 13px 22px"
                :style="sticky ? 'position: sticky; top: -1px;' : ''"
              >
                {{ trans("plast_fluids.actions") }}
              </th>
            </tr>
          </thead>
          <tbody>
            <template v-if="isObjectArray">
              <tr v-for="item in items" :key="item.id">
                <td v-for="fieldKey in fieldKeys" :key="fieldKey">
                  {{ item[fieldKey] }}
                </td>
                <td v-if="tableType === 'upload'">
                  <button @click="handleReportDownload(item)">
                    <img src="/img/PlastFluids/downloadTableIcon.svg" alt="download">
                    <p>{{ trans("plast_fluids.download") }}</p>
                  </button>
                </td>
              </tr>
            </template>
            <template v-else-if="tableType === 'analysis'">
              <tr v-for="(item, index) in items" :key="index">
                <td v-for="(itemTD, ind) in item.table_data" :key="ind">
                  {{ itemTD }}
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
import { downloadUserReport } from "../services/templateService";
import { mapMutations } from "vuex";

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
    tableType: String,
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
    ...mapMutations("plastFluidsLocal", ["SET_LOADING"]),
    emitArrowFilter(key, type) {
      this.$emit("sort-by-arrow-filter", { key, type });
    },
    async handleReportDownload(item) {
      try {
        this.SET_LOADING(true);
        const postData = new FormData();
        postData.append("file_id", item.file_id);
        const report = await downloadUserReport(postData);
        let link = document.createElement("a");

        link.download = item.file_name;
        const blob = new Blob([report.data], {
          type: "application/vnd.ms-excel",
        });

        link.href = URL.createObjectURL(blob);
        link.click();
      } catch (error) {
        console.log(error);
      } finally {
        this.SET_LOADING(false);
      }
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
