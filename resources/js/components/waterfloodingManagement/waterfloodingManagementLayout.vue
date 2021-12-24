<template>
  <div class="main-wrappers">
    <menuList :menuType="menuType" @menuClick="menuClick" />
    <div v-bind:is="mainContent" @prediction="prediction"></div>
  </div>
</template>
<script>
import mainMenu from './mock-data/main_menu.json'
import {waterfloodingManagementMapActions} from "../../store/helpers";
import menuList from './components/mainMenu'

export default {
  components: {
    menuList
  },
  data: function () {
    return {
      menu: mainMenu,
      menuType: 'choose_object_area',
      mapObject: {
        name: "main-component",
        "template": `<water-flooding-management-map v-on:menuClicks="menuClicks"></water-flooding-management-map>`,
        methods:{
          menuClicks(data){
            this.$emit("prediction", data);
          }
        }
      },
      forecasting: {
        name: this.trans('waterflooding_management.forecasting_optimization'),
        "template": `<water-flooding-management-forecasting v-on:monitoring="monitoring"></water-flooding-management-forecasting>`,
        methods:{
          monitoring(data){
            this.$emit("prediction", data);
          }
        }
      },
      mainContent: null,
    };
  },
  mounted() {
    this.mainContent = this.mapObject;
    this.changePolygonFeatures(null)
    this.changeChoosePolygons(null)
    this.changePolygonList([])
  },
  methods: {
    ...waterfloodingManagementMapActions([
      'changePolygonFeatures',
      'changeChoosePolygons',
      'changeChooseModelPrediction',
      'changeOptimizationTask',
      'changePolygonList'
    ]),
    menuClick(data) {
      if (data.type == "choose_object_area"){
        this.mainContent = this.mapObject
      }else if (data.type == "forecasting_optimization"){
        this.mainContent = this.forecasting
      }else{
        this.mainContent = data;
      }
      this.menuType = data.type;
    },
    prediction(data){
      let component = ""
      if (data == 'choose_object_area')
        component = this.forecasting
      else
        component = this.menu[2].component
      this.mainContent = component;
      this.menuType = component.type;
    }
  },
}
</script>
<style >
.map__legend {
  background-color: #fff;
  border-radius: 3px;
  bottom: 30px;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
  padding: 10px;
  position: absolute;
  left: 10px;
  z-index: 1;
  color: #000;
}

.map__legend .well__legend {
  display: inline-block;
  height: 10px;
  margin-right: 5px;
  width: 10px;
}
.map__legend .line__legend {
  display: inline-block;
  height: 3px;
  margin-right: 5px;
  width: 25px;
  background: red;
}
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
.wft__modal__close{
  display: flex;
  justify-content: center;
  align-items: center;
  height: 30px;
  width: 100px;
  background: #656A8A;
  border-radius: 4px;
  color: #fff;
  outline: none;
  border: none;
  margin-left: 10px;
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
.inactive{
  background-color: #5f6781!important;
}
.recommendation__block{
  width: 100%;
  margin-top: 10px;
  padding: 10px;
  background: #2B2E5E;
  border: 0.5px solid #363B68;
  box-sizing: border-box;
}
</style>