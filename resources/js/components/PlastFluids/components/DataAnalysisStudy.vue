<template>
  <div class="">
    <div class="data-analysis__wrapper">
      <div class="data-analysis__wrapper-title">
        <div class="icon-title">
          <i><img src="/img/PlastFluids/tableIcon.png" alt=""/></i>
        </div>
        <span>Детальная статистика изученности по видам исследований</span>
      </div>
      <div class="data-analysis__wrapper-img">
        <div class="row">
          <div class="col-sm-12">
            <table class="table defaultTable">
              <tbody>
                <tr>
                  <th>№ исследования</th>
                  <th>Скважина</th>
                  <th>Дата отбора проб</th>
                  <th>Вид пробы</th>
                  <th>Давление насыщения при ТПЛ</th>
                  <th>Зависимость давления насыщения от температуры</th>
                  <th>PV-соотношение при Тпл</th>
                  <th>Стандартная сепарация</th>
                  <th>Ступенчатая сепарация</th>
                  <th>Дивверенциальное разгазирование</th>
                  <th>Определение состава флюидов</th>
                  <th>Вязкость пластовой нефти при Рпл</th>
                  <th>
                    Зависимость вязкости пластовой нефти от давления выше Ps
                  </th>
                  <th>
                    Зависимость вязкости пластовой нефти от давления выше Ps
                  </th>
                  <th>Зависимость вязкости пластовой нефти от температуры</th>
                </tr>
                <tr v-for="i in 50">
                  <td>{{ i }}</td>
                  <td>КТ-I</td>
                  <td>18.07.06</td>
                  <td>Pgor</td>
                  <td v-for="i in 10">1</td>
                  <td>50.3</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "DataAnalysisStudy",
};
</script>

<style scoped>
.icon-title img {
  width: 26px;
}
table {
  margin-bottom: 5px;
}
</style>
