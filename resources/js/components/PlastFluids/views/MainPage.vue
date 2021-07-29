<template>
  <div class="wrapper-info">
    <div class="statistic-info">
      <div class="grid-container">
        <info-table inform_data="21" :description="amount_of_pvt"></info-table>
        <info-table inform_data="17" :description="deep_samples"></info-table>

        <info-table inform_data="53" :description="recombined"></info-table>
        <info-table inform_data="9" :description="well_head_samples"></info-table>
      </div>
    </div>
   <p class="filter-header">Недропользователь</p>
   <b-input-group class="mt-3 input">
            <b-form-input class="input-bg"></b-form-input>
            <b-input-group-append>
              <b-button variant="info">Button</b-button>
            </b-input-group-append>
          </b-input-group>
   <div class="filter">
      <div class="user-checkbox">
        <b-form-checkbox-group
            v-model="selected"
            :options="options"
            class="mb-3 checkbox-user"
            value-field="item"
            text-field="name"
            stacked
        ></b-form-checkbox-group>
      </div>
     <div class="field-checkbox">
        <div>
          <b-input-group class="mt-3 input">
            <b-form-input class="input-bg"></b-form-input>
            <b-input-group-append>
              <b-button variant="info">Button</b-button>
            </b-input-group-append>
          </b-input-group>
          <div class="user-checkbox">
            <b-form-checkbox-group
                v-model="selected"
                :options="options"
                class="mb-3 checkbox-user"
                value-field="item"
                text-field="name"
                stacked
            ></b-form-checkbox-group>
          </div>
        </div>
      </div>
   </div>
    <div class="buttons-wrapper">
      <button>{{ trans("plast_fluids.data_download") }}</button>
      <button>{{ trans("plast_fluids.data_analysis") }}</button>
      <button>{{ trans("plast_fluids.data_upload") }}</button>
    </div>
  </div>
</template>

<script>
import InfoTable from "../components/InfoTable.vue";
export default {
  data: function () {
    return {
      amount_of_pvt: this.trans("plast_fluids.amount_of_pvt"),
      deep_samples: this.trans("plast_fluids.deep_samples"),
      recombined: this.trans("plast_fluids.recombined"),
      well_head_samples: this.trans("plast_fluids.well_head_samples"),

      options: [
        { item: 'A', name: 'АО «Озенмунайгаз»' },
        { item: 'B', name: 'АО «Мангистаумунайгаз»' },
        { item: 'C', name: 'АО «Каражанбасмунай»' },
        // { item: 'D', name: 'ТОО «Казахтуркмунай»' }
        // { item: 'E', name: 'АО «Эмбамунайгаз»' }
        // { item: 'F', name: 'ТОО СП «Казгермунай»' }
      ]
    };
  },
  components: {
    InfoTable,
  },
};
</script>

<style scoped>
.user-checkbox{
  background: #1C1F4C;
  padding: 5px;
}
.filter-header{
  color: #fff;
  font-size: 20px;
}
.checkbox-user{
  margin: 15px;
}
.field-checkbox{
  margin-bottom: 10px;
}
.input{
  margin-top: 15px;
}
.input-bg{
  background-color: #1F2142;
}
.wrapper-info {
  display : flex;
  flex-direction: column;
  /* justify-content: space-between; */
  background: #272953;
  padding: 10px 14px 10px;
  height: 100%;
}
.grid-container {
  display: grid;
  grid-template-rows: 1fr 1fr;
  grid-template-columns: 1fr 1fr;
}
.buttons-wrapper {
  background: #272953;
  display : flex;
  flex-direction: column;

}
.buttons-wrapper button {
  height:40px;
  background: #333975;
  margin-bottom: 10px;
  font-size: 14px;
  font-style: normal;
  color: #ffffff;
  text-align: center;
  font-family: "Harmonia Sans Pro Cyr", sans-serif;
  font-weight: 700;
  line-height: 16.8px;
}
</style>
