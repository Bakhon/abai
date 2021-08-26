<template>
  <div class="plast-fluids-header">
    <a :href="localeUrl('/pf-upload-monitoring/')">
      <img src="/img/PlastFluids/upload.svg" alt="upload data" width="20px" />
      <p>{{ trans("plast_fluids.data_upload") }}</p>
    </a>
    <a :href="localeUrl('/pf-data-analysis/')">
      <img src="/img/PlastFluids/analyze.svg" alt="analyze data" width="20px" />
      <p>{{ trans("plast_fluids.data_analysis") }}</p>
    </a>
    <a :href="localeUrl('/pf-standart-separation-flash/')">
      <img
        src="/img/PlastFluids/download.svg"
        alt="download data"
        width="20px"
      />
      <p>{{ trans("plast_fluids.data_download") }}</p>
    </a>
  </div>
</template>

<script>
export default {
  name: "Header",
  data() {
    return {};
  },
};
</script>

<style>
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
  padding: 8px 14px;
  background-color: #333975;
  color: #fff !important;
  cursor: pointer;
}

.plast-fluids-header > a:hover {
  text-decoration: none;
  background-color: #2E50E9;
  transition: 0.5s ease;
}

.plast-fluids-header > a > p {
  margin: 0 0 0 10px;
}
</style>
