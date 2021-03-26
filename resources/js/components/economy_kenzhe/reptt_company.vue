<template>
  <div>
    <el-table
      :data="tableData"
      :tree-props="defaultProps"
      style="width: 100%;"
      row-key="id"
      border
      :row-class-name="tableRowClassName"
    >
      <el-table-column   prop="name" label="Наименование" sortable min-width="400" :key="Math.random()">
      </el-table-column>
      <el-table-column  prop="value" label="План на январь" sortable width="250" :key="Math.random()">
      </el-table-column>
    </el-table>
  </div>
</template>

<style>
  .el-table .hidden-row {
    display: none;
  }

</style>
<script>
export default {
  props: ["reptt"],
  data() {
    return {
      defaultProps: {
        id: "id",
        children: "handbook_items",
      },
        tableData: [],
        tableHeader:[
            {
                label: 'Наименование',
                prop: 'name'
            },{
                label: 'План на январь',
                prop: 'value'
            }
        ]
    };
  },
  methods: {
    distributionSumOverTree(){
        this.reptt.reduce(function x(r, a, index) {
            let hasChild = a.handbook_items.length > 0;
            a.value = a.value || hasChild && a.handbook_items.reduce(x, 0) || 0;
            if(a.value == 0){
                a.show = false;
            }else{
                a.show = true;
            }

            return r + Math.abs(a.value);
        }, 0);
    },
      tableRowClassName: function (row, index) {
          if (row.row.value === 0 && row.row.level !== 0) {
              return 'hidden-row';
          }
          return '';
      }
    },
  mounted() {
    this.distributionSumOverTree();
    this.tableData = this.reptt;
  },
};
</script>
<style scoped>
.el-table td, .el-table th{
  padding: 5px;
}
</style>