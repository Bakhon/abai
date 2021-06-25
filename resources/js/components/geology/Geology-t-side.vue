<template>
  <div class="d-flex align-items-center">
    <Button color="primary" icon="moleqq" class="flex-grow-1 mr-3" align="center">
      Корреляция ГИС
    </Button>
    <Button color="accent" icon="kern" class="flex-grow-1 mr-3" align="center">
      Керн
    </Button>
    <Button color="accent" icon="d3" class="flex-grow-1 mr-3" align="center">
      2D - 3D
    </Button>
    <Button color="accent" icon="geoPh" class="flex-grow-1" align="center">
      Геофизика
    </Button>
  </div>
</template>

<script>
import Button from "./components/buttons/Button";
export default {
  name: "Geology-TSide",
  components: {
    Button
  }
}
</script>

<style scoped>

</style>
