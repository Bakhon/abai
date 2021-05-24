<template>
  <div class="info-conteiner">
      <p class="inform-data">{{inform_data}}</p>
      <p class="description">{{description}}</p>
  </div>
</template>

<script>
export default {
  props:{
      description:String,
      inform_data:Number
  }
};
</script>
<style scoped>
    .info-conteiner {
        box-sizing: border-box;
        background: #1c1f4c;
        margin-bottom: 10px;
    }
    .inform-data{
        font-size: 48px;
        font-style: normal;
        color:#FFFFFF;
        text-align: center;
        font-family: "Harmonia Sans Pro Cyr", sans-serif;
        font-weight: 700;
        line-height: 57.6px;
        margin-top: 27px;
    }
    .description {
        font-size: 14px;
        font-style: normal;
        color:#FFFFFF;
        text-align: center;
        font-family: "Harmonia Sans Pro Cyr", sans-serif;
        font-weight: 700;
        line-height: 16.8px;
        margin-top: 14px;
    }
</style>
