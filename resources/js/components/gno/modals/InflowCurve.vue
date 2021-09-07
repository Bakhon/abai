<template>
  <div>
    <Plotly :data="data"
            :layout="layout"
            :display-mode-bar="false"
            :displaylogo="false"
            :mode-bar-buttons-to-remove="buttonsToRemove"/>
  </div>
</template>

<script src="./js/InflowCurve.js"></script>
