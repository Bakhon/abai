<template>
  <div class="excess-table">
      <div class="table-div">
            <div>
              <table>
                <thead>
                  <tr>
                    <th>№</th>
                    <th>Дата</th>
                    <th>Время</th>
                    <th>Нормативное значение</th>
                    <th>Фактическое значение</th>
                    <th>Отклонение</th>
                    <th>Тип превышения</th>
                  </tr>
                </thead>
                <tbody>
                  
                    <tr class="work_limit">
                      <td>1</td>
                      <td>08.10.2021</td>
                      <td>11:43</td>
                      <td>40</td>
                      <td>43</td>
                      <td>-3</td>
                      <td>Рабочий предел</td>
                    </tr>
                    <tr class="tech_limit">
                      <td>1</td>
                      <td>08.10.2021</td>
                      <td>11:43</td>
                      <td>40</td>
                      <td>43</td>
                      <td>-3</td>
                      <td>Технологический предел</td>
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
.work_limit {
  background: #A4673BE5 !important;
}
.tech_limit {
  background: #752747 !important;
}
.excess-table {
  height: calc(100% - 525px);
}
</style>