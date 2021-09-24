<template>
  <div>
    <div class="data-analysis__wrapper">
      <div class="data-analysis__wrapper-title">
        <div class="icon-title">
          <i><img src="/img/PlastFluids/tableIcon.png" alt=""/></i>
        </div>
        <span>Детальная статистика изученности по видам исследований</span>
      </div>
      <div class="data-analysis__wrapper-table">
        <table class="table defaultTable">
          <tbody>
            <tr>
              <th>№ п/п</th>
              <th>Дата отбора проб</th>
              <th>Плотность газа, кг/м3</th>
              <th>N2</th>
              <th>CO2</th>
              <th>H2S</th>
              <th>C1</th>
              <th>C2</th>
              <th>C3</th>
              <th>iC4</th>
              <th>nC4</th>
              <th>iC5</th>
              <th>nC5</th>
              <th>C6</th>
              <th>C7</th>
              <th>C8</th>
            </tr>
            <tr v-for="i in 15">
              <td class="head">K-001</td>
              <td v-for="i in 15">66.7</td>
            </tr>
            <br /><br />
            <tr>
              <th></th>
              <th></th>
              <th>Плотность газа, кг/м3</th>
              <th>N2</th>
              <th>CO2</th>
              <th>H2S</th>
              <th>C1</th>
              <th>C2</th>
              <th>C3</th>
              <th>iC4</th>
              <th>nC4</th>
              <th>iC5</th>
              <th>nC5</th>
              <th>C6</th>
              <th>C7</th>
              <th>C8</th>
            </tr>
            <tr>
              <td class="head">Среднее</td>
              <td v-for="i in 15">66.7</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "DataAnalysisGasComposition",
};
</script>

<style scoped>
tbody {
  width: 100%;
}
</style>
