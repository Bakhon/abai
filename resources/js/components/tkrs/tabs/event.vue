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
                    <th>Количество превышений</th>
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
                      <td>Подъём штанг</td>
                      
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>15.06.2021  14:30:26</td>
                      <td>15.06.2021  14:30:26</td>
                      <td>14:30:26</td>
                      <td>3</td>
                      <td>Подъём штанг</td>
                      
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
                    <th>Начало</th>
                    <th>Конец</th>
                    <th>Часы</th>
                    <th>Сводка по работам (описание проделанных работ)</th>
                    
                  </tr>
                    
                </thead>
                <tbody>
                  
                    <tr>
                      <td style="background: #009847;"></td>
                      <td style="background: #009847;"></td>
                      <td style="background: #009847;"></td>
                      <td style="background: #009847;"> Дневное время</td>
                      
                    </tr>
                    <tr>
                      <td>6:00</td>
                      <td>8:00</td>
                      <td>2:00</td>
                      <td>Завоз тех.воды с плотностью 1,01г/см3 в объеме-60м3.</td>

                      
                    </tr>
                
                  
                  
                </tbody>
              </table>
            </div>
      </div>
      

  </div>
</template>

<script>
export default {

}
</script>
<style lang="scss" scoped src="../BaseTableStyles.scss"></style>
<style>
.all-table {
    display: flex;
}
.summary {
    padding-left: 5px;
}
</style>