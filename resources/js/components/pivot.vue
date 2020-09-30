<template>
        <ejs-pivotview :dataSourceSettings="dataSourceSettings" :height= "height" :showFieldList="showFieldList"> </ejs-pivotview>
</template>

<script>
import { PivotViewPlugin, FieldList } from "@syncfusion/ej2-vue-pivotview";
import { pivotData } from './datasource.js';

Vue.use(PivotViewPlugin);

export default {
  data () {
    return {
      dataSourceSettings: {
        dataSource: pivotData,
        expandAll: false,
        drilledMembers: [{ name: 'Country', items: ['France'] }],
        columns: [{ name: 'Year', caption: 'Production Year' }, { name: 'Quarter' }],
        values: [{ name: 'Sold', caption: 'Units Sold' }, { name: 'Amount', caption: 'Sold Amount' }],
        rows: [{ name: 'Country' }, { name: 'Products' }],
        formatSettings: [{ name: 'Amount', format: 'C0' }],
        filters: []
      },
      height: 350,
      showFieldList: true
    }
  },
  provide: {
        pivotview: [FieldList]
    }
}
</script>
