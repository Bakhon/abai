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
const basePath = "http://172.20.103.187:7576/api/";
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
        `${basePath}techregime/download/`
      );
      // return this.ifFaTr(
      //   `${basePath}techregime/factor/download/${this.$store.getters["fa/year"]}/${this.$store.getters["fa/month"]}/${this.$store.getters["fa/pryear"]}/${this.$store.getters["fa/prmonth"]}/`,
      //   `${basePath}techregime/download/${this.$store.getters["tr/year"]}/${this.$store.getters["tr/month"]}/`
      // );
    },
    postData() {
      return this.ifFaTr(
        {
          year: this.$store.getters["fa/year"],
          month: this.$store.getters["fa/month"],
          pryear: this.$store.getters["fa/pryear"],
          prmonth: this.$store.getters["fa/prmonth"],
          searchString: this.$store.getters["fa/searchString"],
          filter: this.$store.getters["fa/filter"],
          sortType: this.$store.getters["fa/sortType"],
          sortParam: this.$store.getters["fa/sortParam"],
        },
        {
          year: this.$store.getters["tr/year"],
          month: this.$store.getters["tr/month"],
          searchString: this.$store.getters["tr/searchString"],
          filter: this.$store.getters["tr/filter"],
          sortType: this.$store.getters["tr/sortType"],
          sortParam: this.$store.getters["tr/sortParam"],
          year_dyn_start: this.$store.getters["tr/year_dyn_start"],
          year_dyn_end:  this.$store.getters["tr/year_dyn_end"],
          month_dyn_start: this.$store.getters["tr/month_dyn_start"],
          month_dyn_end:  this.$store.getters["tr/month_dyn_end"],
          day_dyn_start: this.$store.getters["tr/day_dyn_start"],
          day_dyn_end:  this.$store.getters["tr/day_dyn_end"],
          is_dynamic:  this.$store.getters["tr/is_dynamic"],
        }
      );
    },
    filename() {
      const filename = this.ifFaTr(
        `FA_${this.$store.getters["fa/month"]}_${this.$store.getters["fa/year"]}_${this.$store.getters["fa/prmonth"]}_${this.$store.getters["fa/pryear"]}`,
        `TR_${this.$store.getters["tr/month"]}_${this.$store.getters["tr/year"]}`
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
        // FA
        return fa;
      } else {
        // TR
        return tr;
      }
    },
    download() {
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
            this.filename
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
