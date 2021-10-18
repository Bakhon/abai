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
      <div class="table-div">
            <div>
              <table>
                <thead>
                  <tr>
                    <th>№</th>
                    <th>Начало</th>
                    <th>Конец</th>
                    <th>Продолжительность</th>
                    
                  </tr>
                    
                </thead>
                <tbody>
                  
                    <tr>
                      <td>1</td>
                      <td><img class="cursor-pointer" src="/img/tkrs/active.svg" alt=""></td>
                      <td><img class="cursor-pointer" src="/img/tkrs/connection.svg" alt=""></td>
                      <td><img class="cursor-pointer" @click="brigada_modal()" data-toggle="modal" 
                data-target="#exampleModalCenter"  src="/img/tkrs/brigada_table.svg" alt="">Бригада №11 ТОО "Жанрос Дриллинг</td>
                      
                    </tr>
                    <tr>
                      <td>1</td>
                      <td><img class="cursor-pointer" src="/img/tkrs/active.svg" alt=""></td>
                      <td><img class="cursor-pointer" src="/img/tkrs/connection.svg" alt=""></td>
                      <td><img class="cursor-pointer" @click="brigada_modal()" data-toggle="modal" 
                data-target="#exampleModalCenter"  src="/img/tkrs/brigada_table.svg" alt="">Бригада №11 ТОО "Жанрос Дриллинг</td>

                      
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
</style>