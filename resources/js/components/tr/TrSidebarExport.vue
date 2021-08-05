<template>
  <a
    href="#"
    @click="download"
    class="bg-dark list-group-item list-group-item-action"
  >
    <div class="d-flex w-100 justify-content-start align-items-center">
      <img
        src="/img/gno/download.png"
        width="25"
        height="25"
        class="companyLogo"
      />
      <span class="menu-collapsed companyName d-none"></span>
    </div>
  </a>
</template>

<script>
const basePath = process.env.MIX_POST_API_URL;
const fileDownload = require("js-file-download");

export default {
  props: {},
  data() {
    return {};
  },
  computed: {
    downloadLink() {
      return this.ifFaTr(
        `${basePath}techregime/factor/download/`,
        `${basePath}techregime/download_tr/`
      );
    },
    postData() {
      return this.ifFaTr(
        {
          year: this.$store.getters["fa/year"],
          month: this.$store.getters["fa/month"],
          day: this.$store.getters["fa/day"],
          pryear: this.$store.getters["fa/pryear"],
          prmonth: this.$store.getters["fa/prmonth"],
          prday: this.$store.getters["fa/prday"],
          searchString: this.$store.getters["fa/searchString"],
          filter: this.$store.getters["fa/filter"],
          sortType: this.$store.getters["fa/sortType"],
          sortParam: this.$store.getters["fa/sortParam"],
          is_dynamic:  this.$store.getters["fa/isDynamic"],
        },
        {
          field: this.$store.state.tr.field,
          is_dynamic:  this.$store.state.tr.isDynamic,
          object: this.$store.state.tr.object,
          searchString: this.$store.state.tr.searchString,
          sortType: this.$store.state.tr.isSortType,
          sortParam: this.$store.state.tr.sortParam,
          wellType: this.$store.state.tr.wellType,
          pageNum: this.$store.state.tr.pageNumber,
          block: this.$store.state.tr.block,
          expMeth: this.$store.state.tr.expMeth,
          horizon: this.$store.state.tr.horizon,
          year_1: this.$store.state.tr.year_dyn_start,
          month_1: this.$store.state.tr.month_dyn_start,
          day_1: this.$store.state.tr.day_dyn_start,
          year_2:  this.$store.state.tr.year_dyn_end,
          month_2:  this.$store.state.tr.month_dyn_end,
          day_2:  this.$store.state.tr.day_dyn_end,
          wellName: this.$store.state.tr.wellName,
          isFullVersion: this.$store.state.tr.isFullVersion,
          month: this.$store.state.tr.month,
          year: this.$store.state.tr.year,

        }
      );
    },
    filename() {
      const filename = this.ifFaTr(
        `FA_${this.$store.getters["fa/month"]}_${this.$store.getters["fa/year"]}_${this.$store.getters["fa/prmonth"]}_${this.$store.getters["fa/pryear"]}`,
        `TR_${this.$store.state.tr.month}_${this.$store.state.tr.year}`
      );
      return `${filename}.xlsx`;
  },
  },
  methods: {
    ifFaTr(fa, tr) {
      if (
        window.location.pathname === this.localeUrl("/fa") ||
        window.location.pathname === this.localeUrl("/trfa")
      ) {
        return fa;
      } else {
        return tr;
      }
    },
    download() {
      this.$store.commit("globalloading/SET_LOADING", true);
      this.axios
        .post(
          this.downloadLink,
          this.postData,
          {
            responseType: "blob",
          }
        )
        .then((response) => {
          fileDownload(
            response.data,
            this.filename,
            this.$store.commit("globalloading/SET_LOADING", false),

          );
          console.log("download then = ", response);
        })
        .catch((error) => {
          console.log("download error = ", error);
        });
    },
  },
};
</script>

<style  scoped>
</style>
