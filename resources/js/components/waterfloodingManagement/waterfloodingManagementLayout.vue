<template>
  <div class="main-wrappers">
    <water-flooding-management-main-menu @menuClick="menuClick" />
    <div v-bind:is="mainContent" ></div>
  </div>
</template>
<script>
export default {
  data: function () {
    return {
      mainContent: {
        name: "main-component",
        "template": "<div><water-flooding-management-map></water-flooding-management-map></div>",
      },
    };
  },
  methods: {
    menuClick (data) {
      this.mainContent = data;
    },
  },
}
</script>
<style >
.wft__left__side{
  margin: 5px 0 0 5px;
  width: calc(21% - 5px);
}
.wft__right__side{
  margin: 5px 5px 0 0;
  width: calc( 79% - 5px);
}
.main-wrappers{
  color: #fff;
}
.card-block .block .period-btn{
  width: 49%;
  height: 42px;
  background: #333975;
  border: 0.5px solid #454FA1;
  box-sizing: border-box;
  border-radius: 4px;
  text-align: center;
  vertical-align: middle;
  font-weight: bold;
  font-size: 14px;
  line-height: 17px;
  color: #FFFFFF;
}
.prediction-btn{
  height: 40px;
  border-radius: 4px;
  border:none;
  background: #3366FF;
  color: #fff;
  font-weight: bold;
  font-size: 17px;
  line-height: 20px;
  text-align: center;
}
.card-block{
  width: calc(100% - 0px);
  padding: 6px;
  margin: 5px;
  /*margin-bottom: 10px;*/
  background-color: #272953;
}
.card-block .card-title{
  display: flex;
  align-items: center;
  font-weight: bold;
  font-size: 18px;
  line-height: 130%;
  margin: 0.5rem 0;
}
.card-title p{
  padding: 0;
  margin: 0;
}
.block-graphic{
  background-color: #2B2E5E;
  border: 1px solid #454D7D;

}
.graphic-prompt{
  padding: 0 70px;
}
.graphic-text{
  margin: 5px 0;
}
.graphic-text img{
  width: 60px;
}
.graphic-text p{
  font-size: 12px;
  line-height: 14px;
  font-weight: bold;
  margin-bottom: 0;
  margin-left: 10px;
  padding-right: 0;
}
.card-block .choose-poligon-table{
  border: 1px solid #454D7D;
  margin-bottom: 0;
}
.card-block .table tr td{
  height: 41px;
  color: #fff;
  border-top: none;
  font-weight: 600;
  font-size: 16px;
  line-height: 259%;
  padding-top:0 ;
  padding-bottom:0 ;
}
.table-td-first{
  background-color: #454D7D;
}
</style>