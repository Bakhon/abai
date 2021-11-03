<template>
  <div class="tkrs-main">
    <mainHeader />
    <div class="sidebar_graph" style="display:flex">
        <baseBlock />

        <div class="tkrs-content">
            <div>
                <img src="/img/tkrs/temporary/gps_positioning.svg" 
                  alt=""
                >
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
  name: "hookWeightSensorAnalyse",
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
      fields: ['№', 'Начало', 'Конец', 'Продолжительность', 'ПВ/НПВ', 'Причина', 'Ответственный'],
      items: [['1', '15.06.2021  14:30:26', '15.06.2021  14:30:26', "1", 'Непроизводительное время', '', 'Заказчик'], 
      ['2', '15.06.2021  14:30:26', '15.06.2021  14:30:26', "1", 'Непроизводительное время', '', 'Подрядчик'],
      ['3', '15.06.2021  14:30:26', '15.06.2021  14:30:26', "1", 'Непроизводительное время', '', 'Подрядчик'],
      ['4', '15.06.2021  14:30:26', '15.06.2021  14:30:26', "1", 'Непроизводительное время', '', 'Подрядчик'],
      ['5', '15.06.2021  14:30:26', '15.06.2021  14:30:26', "1", 'Непроизводительное время', '', 'Подрядчик'],
      ['6', '15.06.2021  14:30:26', '15.06.2021  14:30:26', "1", 'Непроизводительное время', '', 'Подрядчик']]
    }
  }
};
</script>
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
</style>