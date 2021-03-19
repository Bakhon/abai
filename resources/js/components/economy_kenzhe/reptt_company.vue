<template>
  <div>
    <el-table
      :data="reptt"
      :tree-props="defaultProps"
      style="width: 100%;x"
      row-key="id"
      border
      stripe
    >
      <el-table-column prop="name" label="Наименование" sortable min-width="400">
      </el-table-column>
      <el-table-column label="План на январь" sortable width="250">
        <template slot-scope="scope" v-if="!scope.row.isHide">
            {{ scope.row.value }} <br>
        </template>
      </el-table-column> 
    </el-table>
  </div>
</template>

<script>
export default {
  props: ["reptt"],
  data() {
    return {
      defaultProps: {
        id: "id",
        children: "handbook_items",
      },
    };
  },
  methods: {
    distributionSumOverTree(){
        this.reptt.reduce(function x(r, a, index) {
            let hasChild = a.handbook_items.length > 0;
            a.value = a.value || hasChild && a.handbook_items.reduce(x, 0) || 0;
            if(a.value == 0){
                a.isHide = true;
            }else{
                a.isHide = false;
            }

            return r + Math.abs(a.value);
        }, 0);
    }
  },
  mounted() {
    this.distributionSumOverTree();
  },
};
</script>
<style scoped>
.el-table td, .el-table th{
  padding: 5px;
}
</style>