<template>
  <div class="tkrs-main">
    <mainHeader />
    <div class="sidebar_graph" style="display:flex">
        

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
                      <td class="input-form-auto">29.05.2020 г.</td>
                      <td class="input-form-auto">Скважина № 283</td>
                      <td class="input-form-auto">м/р. Акшабулак </td>
                      <td>Начало бурения:</td>
                      <td class="input-form-auto">10.08.2012г</td>
                      <td>Конец бурения:</td>
                      <td class="input-form-auto">31.08.2012г</td>
                    </tr>
                    <tr>
                      <td> № отчета:</td>
                      <td class="input-form-auto">1</td>
                      <td>Задание по программе:</td>
                      <td class="input-form-auto" colspan="2">
                            <div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle input-form-dropdown" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Переход на низлежащий горизонт (ПНЛГ)
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="#">Освоение новой скважины после бурения с ГРП</a>
    <a class="dropdown-item" href="#">Another action</a>
    <a class="dropdown-item" href="#">Something else here</a>
  </div>
</div>
                      </td>
                      <td>Тип скважины:</td>
                      <td class="input-form-auto" colspan="2">эксплуатационная</td>
                    </tr>
                    <tr>
                      <td colspan="2">Тип станка:</td>
                      <td class="input-form-auto">

                        <div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle input-form-dropdown"  type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    УПА-80  kz 146 АL 11
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="#">Action</a>
    <a class="dropdown-item" href="#">Another action</a>
    <a class="dropdown-item" href="#">Something else here</a>
  </div>
</div>
                      </td>
                      <td colspan="2">Подрядчик:</td>
                      <td colspan="3" class="input-form-auto">ТОО "Zhanros-Drilling"</td>
                    </tr>
                </tbody>
              </table>
              <table>
                <tbody>
                    <tr>
                      <td colspan="6">Параметры (давления) по скважине </td>
                    </tr>
                    <tr>
                      <td>Трубное давление:</td>
                      <td class="input-form-auto"> 0 атм</td>
                      <td>Затрубное давление:</td>
                      <td class="input-form-auto">0 атм</td>
                      <td>Межколонное давление:</td>
                      <td class="input-form-auto">0 атм</td>
                    </tr>
                </tbody>
              </table>
              <table>
                <tbody>
                    <tr>
                      <td>Начало</td>
                      <td>Конец</td>
                      <td>Часы</td>
                      <td rowspan="2">Сводка по работам (описание проделаных работ)</td>
                    </tr>
                    <tr>
                      <td colspan="3">Дневное время</td>
                    </tr>
                    <tr>
                      <td>6:00</td>
                      <td>8:00</td>
                      <td class="input-form-auto">2:00</td>
                      <td class="manual-edit"><input class="manual-input"/></td>
                    </tr>
                    <tr>
                      <td>8:00</td>
                      <td>11:00</td>
                      <td class="input-form-auto">3:00</td>
                      <td class="manual-edit"><input class="manual-input"/></td>
                    </tr>
                    <tr>
                      <td>11:00</td>
                      <td>14:00</td>
                      <td class="input-form-auto">3:00</td>
                      <td class="manual-edit"><input class="manual-input"/></td>
                    </tr>
                    <tr>
                      <td>14:00</td>
                      <td>15:00</td>
                      <td class="input-form-auto">1:00</td>
                      <td class="manual-edit"><input class="manual-input"/></td>
                    </tr>
                    <tr>
                      <td>15:00</td>
                      <td>18:00</td>
                      <td class="input-form-auto">3:00</td>
                      <td class="manual-edit"><input class="manual-input"/></td>
                    </tr>
                    <tr>
                      <td colspan="3">Ночное время</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>18:00</td>
                      <td>21:30</td>
                      <td class="input-form-auto">3:30</td>
                      <td class="manual-edit"><input class="manual-input"/></td>
                    </tr>
                    <tr>
                      <td>21:30</td>
                      <td>1:00</td>
                      <td class="input-form-auto">3:30</td>
                      <td class="manual-edit"><input class="manual-input"/></td>
                    </tr>
                    <tr>
                      <td>1:00</td>
                      <td>6:00</td>
                      <td class="input-form-auto">5:00</td>
                      <td class="manual-edit"><input class="manual-input"/></td>
                    </tr>
                </tbody>
              </table>
              <table>
                <tbody>
                    <tr>
                      <td>Всего за сутки:</td>
                      <td class="input-form-auto">24</td>
                      <td>Сегодня</td>
                      <td>Предыдущее</td>
                      <td>Итого</td>
                      <td colspan="6">Данные по скважине</td>
                    </tr>
                    <tr>
                      <td colspan="2">Всего часов, в т.ч:</td>
                      <td class="input-form-auto">24,0</td>
                      <td class="input-form-auto">0,0</td>
                      <td class="input-form-auto">24,0</td>
                      <td>Превышение стола ротора, м</td>
                      <td class="input-form-auto"></td>
                      <td>наружный диаметр, мм</td>
                      <td>толщина стенки, мм</td>
                      <td>глубина спуска, м</td>
                      <td>объем, литр на 1-метр</td>
                    </tr>
                    <tr>
                      <td colspan="2">Производительное время:</td>
                      <td class="input-form-auto">23,0</td>
                      <td class="input-form-auto">0,0</td>
                      <td class="input-form-auto">23,0</td>
                      <td colspan="2"> Эксплуатационная колонна</td>
                      <td class="input-form-auto">168,3</td>
                      <td class="input-form-auto">8,94</td>
                      <td class="input-form-auto">0-1869м</td>
                      <td class="input-form-auto">17,76</td>
                    </tr>
                    <tr>
                      <td colspan="2">прочее (ОЗЦ и т.д)</td>
                      <td class="input-form-auto">0,0</td>
                      <td class="input-form-auto">0,0</td>
                      <td class="input-form-auto">0,0</td>
                      <td colspan="6">Примечание</td>
                    </tr>
                    <tr>
                      <td colspan="2">Непроизводительное время в т.ч:</td>
                      <td class="input-form-auto">1,0</td>
                      <td class="input-form-auto">0,0</td>
                      <td class="input-form-auto">1,0</td>
                      <td colspan="2">Искусственный забой, м</td>
                      <td class="input-form-auto">1856</td>
                      <td colspan="2">Текущий забой, м</td>
                      <td class="input-form-auto">1851м</td>
                    </tr>
                    <tr>
                      <td colspan="2">обеденный перерыв</td>
                      <td class="input-form-auto">1,0</td>
                      <td class="input-form-auto">0,0</td>
                      <td class="input-form-auto">1,0</td>
                      <td colspan="2">Интервал перфорации</td>
                      <td colspan="4" class="input-form-auto">1700-1710м.</td>
                    </tr>
                    <tr>
                      <td colspan="2">ремонт оборудования</td>
                      <td class="input-form-auto">0,0</td>
                      <td class="input-form-auto">0,0</td>
                      <td class="input-form-auto">0,0</td>
                      <td colspan="6" rowspan="4" class="input-form-auto">Завоз тех.воды с плотностью 1,01г/см3 в объеме-60м3.Параметры скважины: Ртр-10атм. Рзтр-15атм. Рм/к-0атм. 
                        Стравливание трубного и затрубного пространство на выходе газ без жидкостью. Подъём полированного штока до 6-метров. 
                        Глушение скважины через трубного пространство тех.водой в объёме-40м3 на выходе газ с жидкостью в объёме-21м3. На заполнение закачено-17м3.
                        Циркуляция скважины до выхода чистой воды 1,5-цикла. Поглошение-2м3.Наблюдение за скважиной на перелив. Перелив отсутствует.Монтаж станка УПА-80. 
                        Подъём штанги ф22мм и ф19мм с вставным насосом в количестве-210шт из них ф22мм 71шт и ф19мм-139шт.
                        Демонтаж штанговой ПВО и планшайбы. Монтаж ПВО и опрессовка ПВО на 130 атм в присутствии представителя КФ РГП на ПХВ "ПВАСС". Результат-герметично.
                         Получено письменное разрешение для дальнейших работ.Подъём замковый опоры и газосеператора на ВНКТ ф73мм в количестве 110шт c тугим отваротом.</td>
                    </tr>
                    <tr>
                      <td colspan="2">метеоусловия</td>
                      <td class="input-form-auto">0,0</td>
                      <td class="input-form-auto">0,0</td>
                      <td class="input-form-auto">0,0</td>
                    </tr>
                    <tr>
                      <td colspan="2"> ожидание по вине Подрядчика</td>
                      <td class="input-form-auto">0,0</td>
                      <td class="input-form-auto">0,0</td>
                      <td class="input-form-auto">0,0</td>
                    </tr>
                    <tr>
                      <td colspan="2">ожидание по вине третьей стороны</td>
                      <td class="input-form-auto">0,0</td>
                      <td class="input-form-auto">0,0</td>
                      <td class="input-form-auto">0,0</td>
                    </tr>
                </tbody>
              </table>
              <table>
                <tbody>
                    <tr>
                      <td rowspan="3">Начальник Б и РС ТОО СП "КГМ"</td>
                      <td rowspan="3" class="input-form-auto">Кушкинбаев Б. / Сапаров М. </td>
                      <td>подпись</td>
                      <td>Мастер КПРС</td>
                      <td>ФИО</td>
                      <td>подпись</td>
                      <td>номер телефона</td>
                    </tr>
                    <tr>
                      
                      <td></td>
                      <td>дневная смена</td>
                      <td class="manual-edit"><input class="manual-input"/></td>
                      <td></td>
                      <td class="manual-edit"><input class="manual-input"/></td>
                    </tr>
                    <tr>
                      
                      <td></td>
                      <td>ночная смена</td>
                      <td class="manual-edit"><input class="manual-input"/></td>
                      <td></td>
                      <td class="manual-edit"><input class="manual-input"/></td>
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
.input-form-auto{
background: #eaf3fa
}
.input-form-dropdown {
background: #eaf3fa !important; 
color: black !important; 
border: none !important;
}
.manual-edit {
  background: #ffff;
}
.manual-input {
  width: 100%; 
  height: 22px;
  border: none;
}
.manual-input:hover {
  border: none;
}
</style>