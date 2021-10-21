<template>
  <div class="tkrs-main">
    <mainHeader />
    <div class="sidebar_graph" style="display:flex">
        <baseBlock />

        <div class="tkrs-content">
            <div>
              <div class="table-div">
            <div>
              <table>
                
                <tbody>
                    <tr>
                      <td>ТОО “КМГ Инжиниринг”</td>
                      <td>Служба бурение и ремонт скважин (СБ и РС)</td>
                    </tr>
                </tbody>
              </table>
              <table>
                <tbody>
                    <tr>
                      <td>Ежедневный отчет по освоению, капитальному и подземному ремонту скважин </td>
                    </tr>
                </tbody>
              </table>
              <table>
                <tbody>
                    <tr>
                      <td >Дата отчета</td>
                      <td class="input-form">29.05.2020 г.</td>
                      <td>Скважина № 283</td>
                      <td>м/р. Акшабулак </td>
                      <td>Начало бурения:</td>
                      <td>10.08.2012г</td>
                      <td>Конец бурения:</td>
                      <td>31.08.2012г</td>
                    </tr>
                </tbody>
              </table>
               <table>
                <tbody>
                    <tr>
                      <td> № отчета:</td>
                      <td>1</td>
                      <td>Задание по программе:</td>
                      <td>Переход на низлежащий горизонт (ПНЛГ)</td>
                      <td>Тип скважины:</td>
                      <td>эксплуатационная</td>
                    </tr>
                    <tr>
                      <td colspan="2">Тип станка:</td>
                      <td>УПА-80  kz 146 АL 11</td>
                      <td>Подрядчик:</td>
                      <td colspan="2">ТОО "Zhanros-Drilling"</td>
                    </tr>
                </tbody>
              </table>
              <table>
                <tbody>
                    <tr>
                      <td>Параметры (давления) по скважине </td>
                    </tr>
                </tbody>
              </table>
            </div>
      </div>
              
              

            </div>

        </div>
    </div>
    
  </div>
</template>

<script>
import mainHeader from "./mainHeader.vue";
import baseBlock from './baseBlock.vue';
import BaseTable from './BaseTable.vue';


export default {
  name: "gps",
  props: {
    route: String,
  },
  components: {
    mainHeader,
    BaseTable,
    baseBlock,
  },
  data(){
    return {
      fields: ['№', 'Начало', 'Конец', 'Продолжительность', 'Количество превышений', 'Событие'],
      items: [['1', '15.06.2021  14:30:26', '15.06.2021  14:30:26', '14:30:26', "1", 'Подъём штанг '], ['1', '15.06.2021  14:30:26', '15.06.2021  14:30:26', '14:30:26', "1", 'Подъём штанг '],['1', '15.06.2021  14:30:26', '15.06.2021  14:30:26', '14:30:26', "1", 'Подъём штанг '],['1', '15.06.2021  14:30:26', '15.06.2021  14:30:26', '14:30:26', "1", 'Подъём штанг '],['1', '15.06.2021  14:30:26', '15.06.2021  14:30:26', '14:30:26', "1", 'Подъём штанг '],['1', '15.06.2021  14:30:26', '15.06.2021  14:30:26', '14:30:26', "1", 'Подъём штанг ']]
    }
  }
};
</script>
<style lang="scss" scoped src="./InputFormTableStyles.scss"></style>
<style scoped>
.tkrs-main {
  width: 100%;
  height: 100%;
}

.tkrs-content {
  display: flex;
  width: 100%;
  height: calc(100vh - 143px);
}
table {
  color: white;
  background: #333975;
}
table, th, td {
  border:1px solid black;
}
.input-form {
background: #FFFFFF
}
</style>