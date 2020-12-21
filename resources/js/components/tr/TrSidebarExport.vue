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
export default {
  props: {},
  data() {
    return {};
  },
  computed: {
    downloadLink() {
      if (
        window.location.pathname === "/ru/fa" ||
        window.location.pathname === "/ru/trfa"
      ) {
        // FA
        return `${basePath}techregime/factor/download/${this.$store.getters["fa/year"]}/${this.$store.getters["fa/month"]}/${this.$store.getters["fa/pryear"]}/${this.$store.getters["fa/prmonth"]}/`;
      } else {
        // TR
        // return `${basePath}techregime/download/${this.$store.getters["tr/year"]}/${this.$store.getters["tr/month"]}/`
        return `${basePath}techregime/download/`;
      }
    },
  },
  methods: {
    download() {
      this.axios
        .post(this.downloadLink, {
          year: this.$store.getters["tr/year"],
          month: this.$store.getters["tr/month"],
          searchString: this.$store.getters["tr/searchString"],
          filter: this.$store.getters["tr/filter"],
          sortType: this.$store.getters["tr/sortType"],
          sortParam: this.$store.getters["tr/sortParam"],
        })
        .then((response) => {
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
