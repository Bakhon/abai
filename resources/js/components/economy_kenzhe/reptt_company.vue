<template>
  <div>
    <el-table
      @node-click="handleNodeClick"
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
        <template slot-scope="scope">
            {{ sum(scope.row.values) }} <br>
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
    handleNodeClick(data) {
      console.log(data);
    },
    sum(values){
      let sum = 0;
      $.each(values, function(key, value){
          sum += parseFloat(value.value);
      });
      return sum;
    }
  },
  mounted() {
    console.log(this.reptt);
  },
};
</script>
<style scoped>
.el-table td, .el-table th{
  padding: 5px;
}
</style>