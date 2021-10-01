<template>
  <div class="tkrs-main">
    <mainHeader />
    <indicator />
    <search />
    <div class="tkrs-content">
      <BaseTable :fields="fields" :items="items" :filter="true"/>
    </div>
  </div>
</template>

<script>
import mainHeader from "./mainHeader.vue";
import indicator from "./indicator.vue";
import search from "./search.vue";
import BaseTable from './BaseTable.vue'


export default {
  name: "tkrsMain",
  props: {
    route: String,
  },
  components: {
    mainHeader,
    indicator,
    search,
    BaseTable,
  },
  data(){
    return {
      fields: ['№', 'Активность', 'Свзяь', 'Бригада', 'Месторождение', 'Скважина', 'Вид ремонта', 'Оповощение', 'GPS'],
      items: [['1', 'Есет', 'Ерасыл'],['Абат', 'Есет', 'Ерасыл']]
    }
  }
};
</script>
'/img/tkrs/eyes.svg'
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