<template>
  <div>
    <el-table
      @node-click="handleNodeClick"
      :data="reptt"
      :tree-props="defaultProps"
      style="width: 100%; margin-bottom: 20px"
      row-key="id"
      border
      default-expand-all
      stripe
    >
      <el-table-column prop="name" label="Наименование" sortable width="250">
      </el-table-column>
      <el-table-column prop="name" label="План на январь" sortable width="250">
      </el-table-column>

      <el-table-column prop="id" label="Id" sortable width="180">
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
        name: "name",
      },
    };
  },
  methods: {
    handleNodeClick(data) {
      console.log(data);
    },
  },
  mounted() {
    console.log(this.reptt);
  },
};
</script>
