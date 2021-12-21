<template>
  <div class="waring_modal_back">
    <div class="waring_modal">
      warning
    </div>
  </div>
</template>
<script>
export default {
  name: "warningModal"
}
</script>
<style scoped>
.waring_modal_back{
  width: 100%;
  position: fixed;
  top: 100px;
  left: 0;
  z-index: 10001;
  display: flex;
  justify-content: center;
}
.waring_modal{
  padding: 3px 20px;
  background-color: #e3342f;
  font-size: 16px;
}
</style>