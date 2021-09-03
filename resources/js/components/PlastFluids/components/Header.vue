<template>
  <div class="plast-fluids-header">
    <a
      v-for="heading in headings"
      :key="heading.url"
      :class="{ activeLink: currentPage === heading.url }"
      @click="routeTo(`/${heading.url}`)"
    >
      <img
        @click.stop="goToMainPage"
        class="back-button"
        v-if="currentPage === heading.url"
        src="/img/PlastFluids/backArrow.svg"
        alt="go back"
      />
      <img
        :src="'/img/PlastFluids/' + heading.localeName + '.svg'"
        alt="upload data"
        width="20px"
      />
      <p>{{ trans(`plast_fluids.${heading.localeName}`) }}</p>
    </a>
  </div>
</template>

<script>
export default {
  name: "Header",
  data() {
    return {
      headings: [
        {
          url: "pf-upload-monitoring",
          localeName: "data_upload",
        },
        {
          url: "pf-data-analysis",
          localeName: "data_analysis",
        },
        {
          url: "pf-download-monitoring",
          localeName: "data_download",
        },
      ],
      currentPage: "",
    };
  },
  methods: {
    routeTo(url) {
      const { reload, pathname, origin } = location;
      if (this.localeUrl(url) === pathname) {
        reload();
        return;
      }
      location.href = origin + this.localeUrl(url);
    },
    goToMainPage() {
      location.href = location.origin + this.localeUrl("/pf");
    },
    urlIncludes(url) {
      const { pathname } = location;
      if (pathname.includes(url)) return true;
    },
    handleCurrentPage() {
      let i = 0;
      while (this.headings.length > i) {
        const _includes = this.urlIncludes(this.headings[i].url);
        if (!_includes) {
          this.currentPage = "";
          i++;
          continue;
        }
        this.currentPage = this.headings[i].url;
        break;
      }
    },
  },
  mounted() {
    this.handleCurrentPage();
  },
};
</script>

<style scoped>
.plast-fluids-header {
  display: grid;
  column-gap: 10px;
  grid-template-columns: repeat(3, 1fr);
  margin: 0 0 10px 0;
}

.plast-fluids-header > a {
  display: flex;
  border-radius: 4px;
  height: 35px;
  justify-content: flex-start;
  align-items: center;
  padding: 8px 14px;
  background-color: #333975;
  color: #fff;
  cursor: pointer;
}

.plast-fluids-header > a:hover,
.activeLink {
  text-decoration: none;
  background-color: #2e50e9 !important;
  transition: 0.5s ease;
}

.plast-fluids-header > a > p {
  margin: 0 0 0 10px;
}

.back-button {
  width: 24px;
  height: 24px;
  margin-right: 14px;
}
</style>
