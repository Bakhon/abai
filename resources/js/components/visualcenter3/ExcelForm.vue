<template>
  <hot-table :data="data" :colHeaders='true' :rowHeaders='true' width="600" height="600" licenseKey='non-commercial-and-evaluation'>
      <hot-column title="First column header">
      </hot-column>
  </hot-table>
</template>
 
<script>
  import { HotTable } from '@handsontable/vue';
  
  export default {
    data: function() {
    return {
      hotSettings: {
        data: Handsontable.helper.createSpreadsheetData(10, 5),
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

