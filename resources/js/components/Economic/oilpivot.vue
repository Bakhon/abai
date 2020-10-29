<template>
    <div>
        <ejs-pivotview v-if="dataSourceSettings.dataSource" :dataSourceSettings="dataSourceSettings" :showFieldList="showFieldList"> </ejs-pivotview>
        <p v-if="!dataSourceSettings.dataSource">Идет загрука данных, ждите...</p>
    </div>
</template>

<script>
import { PivotViewPlugin, FieldList } from "@syncfusion/ej2-vue-pivotview";

Vue.use(PivotViewPlugin);

export default {
  data () {
    return {
      dataSourceSettings: {
        dataSource: null,
        expandAll: false,
        columns: [{ name: 'status', caption: 'Статус' }],
        values: [{ name: 'oil', caption: 'Нефть' }],
        rows: [{ name: 'org', caption: 'ДЗО'  }],
        filters: []
      },
      showFieldList: true
    }
  },
  provide: {
        pivotview: [FieldList]
  },
  beforeCreate: function () {
    let uri = '/ru/getoilpivotdata';
    this.axios.get(uri).then((response) => {
        let data = response.data;
        if(data) {
            this.dataSourceSettings.dataSource = data;
        }
        else {
            console.log('No data');
        }
    });
  }
}
</script>
