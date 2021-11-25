<template>
  <div class="all-table">
      <div class="table-div">
            <div>
              <table>
                <thead>
                  <tr>
                    <th>№</th>
                    <th>Начало</th>
                    <th>Конец</th>
                    <th>Продолжительность</th>
                    <th>Код</th>
                    <th>Событие</th>
                  </tr>
                    
                </thead>
                <tbody>
                  
                    <tr>
                      <td>1</td>
                      <td>15.06.2021  14:30:26</td>
                      <td>15.06.2021  14:30:26</td>
                      <td>14:30:26</td>
                      <td>1</td>
                      <td>Подъём штанг </td>
                      
                    </tr>
                    <tr>
                      <td>1</td>
                      <td>15.06.2021  14:30:26</td>
                      <td>15.06.2021  14:30:26</td>
                      <td>14:30:26</td>
                      <td>1</td>
                      <td>Подъём штанг </td>
                      
                    </tr>
                    <tr>
                      <td>1</td>
                      <td>15.06.2021  14:30:26</td>
                      <td>15.06.2021  14:30:26</td>
                      <td>14:30:26</td>
                      <td>1</td>
                      <td>Подъём штанг </td>
                      
                    </tr>
                    <tr>
                      <td>1</td>
                      <td>15.06.2021  14:30:26</td>
                      <td>15.06.2021  14:30:26</td>
                      <td>14:30:26</td>
                      <td>1</td>
                      <td>Подъём штанг </td>
                    </tr>
                    <tr>
                      <td>1</td>
                      <td>15.06.2021  14:30:26</td>
                      <td>15.06.2021  14:30:26</td>
                      <td>14:30:26</td>
                      <td>1</td>
                      <td>Подъём штанг </td>
                    </tr>
                    <tr>
                      <td>1</td>
                      <td>15.06.2021  14:30:26</td>
                      <td>15.06.2021  14:30:26</td>
                      <td>14:30:26</td>
                      <td>1</td>
                      <td>Подъём штанг </td>
                    </tr>
                    <tr>
                      <td>1</td>
                      <td>15.06.2021  14:30:26</td>
                      <td>15.06.2021  14:30:26</td>
                      <td>14:30:26</td>
                      <td>1</td>
                      <td>Подъём штанг </td>
                    </tr>
                    <tr>
                      <td>1</td>
                      <td>15.06.2021  14:30:26</td>
                      <td>15.06.2021  14:30:26</td>
                      <td>14:30:26</td>
                      <td>1</td>
                      <td>Подъём штанг </td>
                    </tr>
                    <tr>
                      <td>1</td>
                      <td>15.06.2021  14:30:26</td>
                      <td>15.06.2021  14:30:26</td>
                      <td>14:30:26</td>
                      <td>1</td>
                      <td>Подъём штанг </td>
                    </tr>
                    
                
                  
                  
                </tbody>
              </table>
            </div>
      </div>
      <div class="table-div summary">
            <div>
              <table>
                <thead>
                  <tr>
                    <th>Дата</th>
                    <th>Начало</th>
                    <th>Конец</th>
                    <th>Часы</th>
                    <th>Сводка по работам (описание проделанных работ)</th>
                  </tr>
                    
                </thead>
                <tbody>
                  
                    <tr v-for="(row, row_index) in test" :key="row_index">
                      <td>{{ row.date }}</td>
                      <td>{{ row.dbeg }}</td>
                      <td>{{ row.dend }}</td>
                      <td>{{ row.duration }}</td>
                      <td>{{ row.value }}</td>
                    </tr>
                    
                </tbody>
              </table>
            </div>
      </div>
      

  </div>
</template>

<script>
export default {
  props: {
    test: Array,
  }

}
</script>
<style lang="scss" scoped src="../BaseTableStyles.scss"></style>
<style>
.all-table {
    display: flex;
    height: calc(100% - 525px);

}
.summary {
    padding-left: 5px;
}
.table-div {
  overflow: scroll;
  height: 214px;
}
</style>