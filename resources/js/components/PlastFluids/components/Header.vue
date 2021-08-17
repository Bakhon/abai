<template>
  <div class="plast-fluids-header">
    <div>
      <img src="/img/PlastFluids/upload.svg" alt="upload data" width="20px" />
      <p>Загрузка данных</p>
    </div>
    <div>
      <img src="/img/PlastFluids/analyze.svg" alt="analyze data" width="20px" />
      <p>Анализ данных</p>
    </div>
    <div>
      <img
        src="/img/PlastFluids/download.svg"
        alt="download data"
        width="20px"
      />
      <p>Выгрузка данных</p>
    </div>
    <div>
      <img src="" alt="" width="20px" />
      <p>Выгрузка данных</p>
    </div>
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
  grid-template-columns: repeat(4, 1fr);
  margin: 0 0 10px 0;
}

.plast-fluids-header > div {
  display: flex;
  height: 35px;
  justify-content: flex-start;
  padding: 8px 14px;
  background-color: #333975;
  color: #fff;
  cursor: pointer;
}

.plast-fluids-header > div > p {
  margin: 0 0 0 10px;
}
</style>
