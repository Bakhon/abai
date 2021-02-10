<template>
  <hot-table :data="data" :colHeaders='true' :settings='hotSettings' :rowHeaders='true' licenseKey='non-commercial-and-evaluation'></hot-table>
</template>
 
<script>
  import { HotTable } from '@handsontable/vue';
  
  export default {
    data: function() {
    return {
      hotSettings: {
        data: Handsontable.helper.createSpreadsheetData(50, 30),
        colHeaders: true,
        contextMenu: {
          items: {
            'row_above': {
              name: 'Insert row above this one (custom name)'
            },
            'row_below': {},
            'separator': Handsontable.plugins.ContextMenu.SEPARATOR,
            'clear_custom': {
              name: 'Clear all cells (custom)',
              callback: function() {
                this.clear();
              }
            }
          }
        }
      }
    }
  },
  components: {
    HotTable
  }
  }
</script>

