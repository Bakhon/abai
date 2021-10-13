<template>
  <div class="tkrs-main">
    <mainHeader />
    <div class="sidebar_graph" style="display:flex">
        <baseBlock />

        <div class="tkrs-content">
            <div>


                <BaseTable :fields="fields" :items="items" :filter="true"/>

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
  name: "video",
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